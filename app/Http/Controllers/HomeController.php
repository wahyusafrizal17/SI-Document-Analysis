<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Histori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\ListFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Clegginabox\PDFMerger\PDFMerger;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('chat-pdf', [
                'list_chat' => collect(),
                'histori' => collect()
            ]);
        }

        if (Auth::user()->role === 'Admin') {
            $jumlahDokumen = \App\Models\Dokumen::count();
            $jumlahPengguna = \App\Models\User::count();
            $jumlahHistory = \App\Models\Histori::count();

            return view('welcome', [
                'jumlahDokumen' => $jumlahDokumen,
                'jumlahPengguna' => $jumlahPengguna,
                'jumlahHistory' => $jumlahHistory,
            ]);
        }

        $userId = Auth::id();

        // Get real-time data without caching
        $histori = Histori::selectRaw('DATE(created_at) as tanggal, GROUP_CONCAT(id) as histori_ids')
            ->where('user_id', $userId)
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('tanggal')
            ->get();

        $listChat = Histori::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'histori' => $histori,
            'list_chat' => $listChat
        ];

        return view('chat-pdf', $data);
    }

    /**
     * Get chat history by date (real-time)
     */
    public function getChatByDate($tanggal)
    {
        $userId = Auth::id();

        $chat = Histori::where('user_id', $userId)
            ->whereDate('created_at', Carbon::parse($tanggal))
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chat);
    }

    /**
     * Show user profile (real-time)
     */
    public function profile()
    {
        $userId = Auth::id();

        $data['model'] = User::select('id', 'name', 'email', 'role', 'foto', 'created_at')
            ->where('id', $userId)
            ->first();

        $file = (Auth::user()->role === 'Admin') ? 'profile.admin' : 'profile.pengguna';
        return view($file, $data);
    }

    /**
     * Update user profile with optimized file handling
     */
    public function profileUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $model = User::findOrFail($id);
            $input = $request->only(['name', 'email']);
            // Handle file upload with optimization
            if ($request->hasFile('foto')) {
                $oldFoto = $model->foto;

                $documentName = strtolower(str_replace(' ', '_', $request->name));
                $fileName = $documentName . '_foto_' . date('YmdHis') . '.png';
                $path = public_path('foto');

                // Ensure directory exists
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                // Move file with error handling
                if ($request->file('foto')->move($path, $fileName)) {
                    $input['foto'] = $fileName;

                    // Delete old file if exists
                    if ($oldFoto && File::exists(public_path('foto/' . $oldFoto))) {
                        File::delete(public_path('foto/' . $oldFoto));
                    }
                }
            }

            // Handle password update
            if ($request->filled('password')) {
                $input['password'] = Hash::make($request->password);
            }

            $model->update($input);

            // Cache clearing no longer needed since we're using real-time data

            DB::commit();

            alert()->success('Data berhasil diubah', 'Berhasil');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Profile update failed: ' . $e->getMessage());

            alert()->error('Gagal mengubah data', 'Error');
            return redirect()->back();
        }
    }

    /**
     * Send message with optimized PDF handling and async operations
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        set_time_limit(120);
        $message = $request->input('message');
        $userId = Auth::id();

        try {
            $folderPath = storage_path('app/chatpdf-files/');

            // Ensure directory exists
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            // Cari listFile yang belum punya document_id
            $listFile = ListFile::where('document_id', null)->first();

            if ($listFile) {
                $sourceId = $listFile->source_id;
            } else {
                $files = File::files($folderPath);

                if (empty($files)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada file PDF di folder chatpdf-files.'
                    ]);
                }

                // Merge dan upload file, dapatkan sourceId baru
                $sourceId = $this->mergeAndUploadPDFs($files);

                if (!$sourceId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal memproses file PDF.'
                    ]);
                }
            }

            // Send message to ChatPDF with timeout
            $summary = $this->sendToChatPDF($sourceId, $message);

            if (!$summary) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mendapatkan jawaban dari ChatPDF.'
                ]);
            }

            // Save chat history asynchronously
            $this->saveChatHistoryAsync($userId, $message, $summary);

            return response()->json([
                'success' => true,
                'sent' => $message,
                'combined_content' => $summary,
                'message' => 'Ringkasan berhasil diambil dari ChatPDF.'
            ]);
        } catch (\Exception $e) {
            Log::error('Send message failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ]);
        }
    }

    /**
     * Merge PDFs and upload to ChatPDF
     */
    private function mergeAndUploadPDFs($files)
    {
        try {
            $merger = new PDFMerger;

            foreach ($files as $file) {
                $merger->addPDF($file->getRealPath(), 'all');
            }

            $mergedPath = storage_path('app/merged.pdf');
            $merger->merge('file', $mergedPath);

            // Upload to ChatPDF with timeout
            $uploadResponse = Http::timeout(30)->withHeaders([
                'x-api-key' => 'sec_aIH4Fr9aytRWhXMk6XGVdekYBkozhcbf'
            ])->attach(
                'file',
                file_get_contents($mergedPath),
                'merged.pdf'
            )->post('https://api.chatpdf.com/v1/sources/add-file');

            if (!$uploadResponse->ok()) {
                Log::error('ChatPDF upload failed: ' . $uploadResponse->body());
                return null;
            }

            $sourceId = $uploadResponse->json('sourceId');

            // Save to database
            $listFile = new ListFile();
            $listFile->document_id = null;
            $listFile->source_id = $sourceId;
            $listFile->created_at = now();
            $listFile->save();

            // Clean up merged file
            if (File::exists($mergedPath)) {
                File::delete($mergedPath);
            }

            return $sourceId;
        } catch (\Exception $e) {
            Log::error('PDF merge failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send message to ChatPDF API
     */
    private function sendToChatPDF($sourceId, $message)
    {
        try {
            // Prompt engineering: tambahkan konteks jika pesan terlalu singkat
            $wordCount = str_word_count($message);
            if ($wordCount < 5) {
                $message = 'Tolong carikan informasi secara detail tentang: "' . $message . '" dari dokumen ini.';
            }

            $chatResponse = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
                'x-api-key' => 'sec_aIH4Fr9aytRWhXMk6XGVdekYBkozhcbf'
            ])->post('https://api.chatpdf.com/v1/chats/message', [
                'sourceId' => $sourceId,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ]
            ]);

            if (!$chatResponse->ok()) {
                Log::error('ChatPDF API failed: ' . $chatResponse->body());
                return null;
            }

            return $chatResponse->json('content');
        } catch (\Exception $e) {
            Log::error('ChatPDF request failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save chat history asynchronously
     */
    private function saveChatHistoryAsync($userId, $message, $summary)
    {
        try {
            $chatHistory = new Histori();
            $chatHistory->document_id = null;
            $chatHistory->user_id = $userId;
            $chatHistory->sent = $message;
            $chatHistory->accepted = $summary;
            $chatHistory->created_at = now();
            $chatHistory->save();

            // Cache clearing no longer needed since we're using real-time data
        } catch (\Exception $e) {
            Log::error('Save chat history failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete chat history by date
     */
    public function deleteHistory($tanggal)
    {
        try {
            $userId = Auth::id();

            // Delete all chat history for the specified date
            $deletedCount = Histori::where('user_id', $userId)
                ->whereDate('created_at', Carbon::parse($tanggal))
                ->delete();

            if ($deletedCount > 0) {
                // Cache clearing no longer needed since we're using real-time data

                return response()->json([
                    'success' => true,
                    'message' => "Successfully deleted {$deletedCount} chat(s)",
                    'deleted_count' => $deletedCount
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No chat history found for this date'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Delete history failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete chat history'
            ]);
        }
    }
}
