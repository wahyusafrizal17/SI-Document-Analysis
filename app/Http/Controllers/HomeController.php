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
            // Cari listFile yang tersedia dan terhubung dengan dokumen
            $listFile = ListFile::whereNotNull('document_id')->first();

            if ($listFile) {
                $sourceId = $listFile->source_id;
            } else {
                // Jika tidak ada listFile yang terhubung dengan dokumen, berarti belum ada dokumen yang diupload dengan benar
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan upload dokumen terlebih dahulu sebelum melakukan chat. Pastikan dokumen berhasil diupload ke sistem.'
                ]);
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
     * Send message to ChatPDF API
     */
    private function sendToChatPDF($sourceId, $message)
    {
        try {
            // Daftar sapaan yang umum
            $greetings = [
                'pagi',
                'siang',
                'sore',
                'malam',
                'halo',
                'hai',
                'assalamualaikum',
                'hi'
            ];
            $lowerMessage = strtolower(trim($message));
            $isGreeting = false;
            foreach ($greetings as $greet) {
                if (strpos($lowerMessage, $greet) !== false) {
                    $isGreeting = true;
                    break;
                }
            }

            // Prompt engineering: selalu gunakan prompt yang memastikan pencarian menyeluruh
            if (!$isGreeting) {
                // Untuk semua pencarian (bukan sapaan), gunakan prompt yang memastikan pencarian dari seluruh dokumen
                // Tambahkan instruksi untuk mengabaikan case sensitivity dan mencari dengan berbagai variasi
                $originalMessage = $message;
                $message = 'Tolong carikan dan rangkum secara lengkap dan menyeluruh tentang: "' . $originalMessage . '" dari seluruh dokumen ini. Carilah dengan berbagai variasi kata kunci (termasuk sinonim dan variasi penulisan). Pastikan mencari di semua halaman dan menampilkan SEMUA informasi terkait yang ditemukan, tidak peduli di halaman mana informasinya berada. Jika ada informasi yang tersebar di beberapa halaman, rangkum semuanya.';
            }

            // Jika bukan sapaan, gunakan prompt yang lebih sederhana tapi efektif
            if (!$isGreeting) {
                // Gunakan prompt yang memaksa ChatPDF untuk mencari di seluruh dokumen
                // $message = 'Tolong carikan dan rangkum secara lengkap dan menyeluruh tentang: "' . $message . '" dari seluruh dokumen ini, termasuk jika informasinya tersebar di beberapa halaman. Carilah dengan mengabaikan huruf besar/kecil (case insensitive). Pastikan semua informasi terkait ditemukan dan ditampilkan.';
                $message = 'Tolong carikan dan rangkum secara lengkap dan menyeluruh tentang: "' . $message . '" dari seluruh dokumen ini, termasuk jika informasinya tersebar di beberapa halaman. Pastikan semua informasi terkait ditemukan dan ditampilkan.';
            }
            
            // Fallback ke query tunggal jika multiple queries gagal
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
