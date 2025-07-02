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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Clegginabox\PDFMerger\PDFMerger;

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
        set_time_limit(120);
        $message = $request->input('message');

        $folderPath = storage_path('app/chatpdf-files/');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        $files = File::files($folderPath);
        if (count($files) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file di folder chatpdf-files.'
            ]);
        }

        // Gabungkan file PDF
        $merger = new PDFMerger;
        foreach ($files as $file) {
            $merger->addPDF($file->getRealPath(), 'all');
        }

        $mergedPath = storage_path('app/merged.pdf');
        $merger->merge('file', $mergedPath);

        // Upload hasil gabungan ke ChatPDF
        $uploadResponse = Http::withHeaders([
            'x-api-key' => 'sec_aIH4Fr9aytRWhXMk6XGVdekYBkozhcbf'
        ])->attach(
            'file', file_get_contents($mergedPath), 'merged.pdf'
        )->post('https://api.chatpdf.com/v1/sources/add-file');

        if (!$uploadResponse->ok()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file ke ChatPDF.',
                'error' => $uploadResponse->json()
            ]);
        }

        $sourceId = $uploadResponse->json('sourceId');

        // Kirim pertanyaan
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

        if (!$chatResponse->ok()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan jawaban dari ChatPDF.'
            ]);
        }

        $summary = $chatResponse->json('content');

        // Simpan histori
        $chatHistory = new \App\Models\Histori();
        $chatHistory->document_id = null;
        $chatHistory->user_id = \Auth::id();
        $chatHistory->sent = $message;
        $chatHistory->accepted = $summary;
        $chatHistory->created_at = now();
        $chatHistory->save();

        return response()->json([
            'success' => true,
            'sent' => $message,
            'combined_content' => $summary,
            'message' => 'Summary berhasil dibuat dari gabungan semua file.'
        ]);

    }
}
