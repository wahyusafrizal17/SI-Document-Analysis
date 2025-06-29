<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Histori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\ListFile;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!\Auth::check()) {
            return view('chat-pdf', [
                'list_chat' => [],
                'histori' => []
            ]);
        }
        
        if (\Auth::user()->role == 'Admin') {
            return view('welcome');
        } else {
            $data['histori'] = Histori::selectRaw('DATE(created_at) as tanggal, GROUP_CONCAT(id) as histori_ids')
            ->where('user_id', \Auth::user()->id)
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('tanggal')
            ->get();

            $data['list_chat'] = Histori::where('user_id', \Auth::user()->id)->whereDate('created_at', Carbon::today())->get();
            
            return view('chat-pdf', $data);
        }        
    }

    public function getChatByDate($tanggal)
    {
        $chat = Histori::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::parse($tanggal))
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chat);
    }

    public function profile()
    {
        $data['model'] = User::where('id', \Auth::user()->id)->first();
        $file = (\Auth::user()->role == 'Admin') ? 'profile.admin' : 'profile.pengguna';
        return view($file, $data);
    }

    public function profileUpdate(Request $request, $id)
    {
        $model = User::find($id);
        $input = $request->all();
        if ($request->hasFile('foto')) {
            $documentName = strtolower(str_replace(' ', '_', $request->name));
            $fileName = $documentName . '_foto_' . date('YmdHis') . '.png';
            $path = public_path('foto');
            $request->file('foto')->move($path, $fileName);
            $input['foto'] = $fileName;
        }
        if($request->password != '')
        {
        $input['password'] = Hash::make($request->password);
        }
        
        $model->update($input);

        alert()->success('Data berhasil diubah', 'Berhasil');
        return redirect()->back();
    }

    public function sendMessage(Request $request)
{
    $message = $request->input('message');
    $files = Dokumen::all();
    $combinedContent = "";
    $foundRelevantContent = false; // Flag to track if any relevant content was found

    foreach ($files as $file) {
        // Cek apakah file sudah ada di database
        $listFile = ListFile::where('document_id', $file->id)->first();

        if (!$listFile) {
            // Kirim file ke ChatPDF API
            $addUrlResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-key' => 'sec_aIH4Fr9aytRWhXMk6XXGVdekYBkozhcbf'
            ])->post('https://api.chatpdf.com/v1/sources/add-url', [
                'url' => $file->document_url
            ]);

            if (!$addUrlResponse->ok()) {
                return response()->json([
                    'success' => false,
                    'file' => $file->document_url,
                    'message' => 'Gagal mendaftarkan file ke ChatPDF API.'
                ], 500);
            }

            // Simpan ke database
            $listFile = new ListFile();
            $listFile->document_id = $file->id;
            $listFile->source_id = $addUrlResponse->json('sourceId');
            $listFile->created_at = now();
            $listFile->save();
        }

        $sourceId = $listFile->source_id;

        if ($sourceId) {
            // Kirim pesan ke ChatPDF API
            $chatResponse = Http::withHeaders([
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

            if ($chatResponse->ok()) {
                $contentFromChat = $chatResponse->json('content');
                if (!empty(trim($contentFromChat)) && strtolower(trim($contentFromChat)) !== 'maaf, saya tidak menemukan informasi mengenai nama dosen teknik informatika di halaman yang diberikan. namun, secara umum, dosen teknik informatika adalah pendidik profesional yang mengajar dan membimbing mahasiswa dalam program studi tersebut. jika anda memerlukan informasi lebih spesifik, saya sarankan untuk menghubungi politeknik tedc bandung secara langsung.') {
                    $combinedContent .= $contentFromChat . "\n";
                    $foundRelevantContent = true; // Set flag if content is found
                }
            } else {
                return response()->json([
                    'success' => false,
                    'file' => $file->document_url,
                    'message' => 'Gagal mengambil data dari ChatPDF untuk file: ' . $file->document_url
                ], 500);
            }
        }
    }

    // Handle case where no relevant content was found after checking all files
    if (!$foundRelevantContent) {
        $errorMessage = 'Maaf, saya tidak menemukan informasi mengenai "' . $message . '" di semua dokumen yang tersedia. Silakan coba pertanyaan lain atau hubungi administrator jika Anda memerlukan informasi lebih lanjut.';

        // Simpan riwayat chat meskipun tidak ditemukan
        $chatHistory = new Histori();
        $chatHistory->document_id = $file->id ?? null; // document_id might not be set if $files is empty
        $chatHistory->user_id = \Auth::user()->id;
        $chatHistory->sent = $message;
        $chatHistory->accepted = $errorMessage;
        $chatHistory->created_at = now();
        $chatHistory->save();

        return response()->json([
            'success' => false,
            'sent' => $message,
            'combined_content' => $errorMessage,
            'message' => $errorMessage
        ]);
    }

    // Simpan riwayat chat jika ditemukan konten
    $chatHistory = new Histori();
    $chatHistory->document_id = $file->id; // This will hold the ID of the last processed file. Consider if you need a different logic for document_id for combined content.
    $chatHistory->user_id = \Auth::user()->id;
    $chatHistory->sent = $message;
    $chatHistory->accepted = $combinedContent;
    $chatHistory->created_at = now();
    $chatHistory->save();

    return response()->json([
        'success' => true,
        'sent' => $message,
        'combined_content' => $combinedContent,
        'message' => 'Data berhasil dikombinasikan dari semua file.'
    ]);
}
}
