<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Http\Requests\Dokumen\StoreRequest;
use App\Http\Requests\Dokumen\UpdateRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['model'] = Dokumen::all();

        return view('dokumen.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('document_url')) {
            $documentName = strtolower(str_replace(' ', '_', $request->document_name));
            $fileName = $documentName . '_document_' . date('YmdHis') . '.pdf';

            // Simpan ke public/dokumen
            $path = public_path('dokumen');
            $request->file('document_url')->move($path, $fileName);

            // Simpan URL untuk DB
            $input['document_url'] = url('dokumen/' . $fileName);
            $filePath = $path . '/' . $fileName;
        }

        $input['upload_by'] = \Auth::user()->id;
        $dokumen = Dokumen::create($input);

        // Upload ke ChatPDF dan dapatkan source_id (hanya jika ada file)
        if ($request->hasFile('document_url')) {
            $sourceId = $this->uploadToChatPDF($filePath);
            
            if ($sourceId) {
                // Simpan source_id ke tabel list_file
                \App\Models\ListFile::create([
                    'document_id' => $dokumen->id,
                    'source_id' => $sourceId,
                    'created_at' => now()
                ]);
            } else {
                // Jika upload ke ChatPDF gagal, hapus dokumen yang baru dibuat dan file
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $dokumen->delete();
                alert()->error('Gagal mengupload dokumen ke ChatPDF. Silakan coba lagi.', 'Error');
                return redirect('document');
            }
        }

        alert()->success('Data berhasil disimpan', 'Berhasil');
        return redirect('document');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['model'] = Dokumen::find($id);
        return view('dokumen.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $model = Dokumen::find($id);
        $input = $request->all();

        if ($request->hasFile('document_url')) {
            $documentName = strtolower(str_replace(' ', '_', $request->document_name));
            $fileName = $documentName . '_document_' . date('YmdHis') . '.pdf';
            $path = public_path('dokumen');

            // Simpan file ke public/dokumen
            $request->file('document_url')->move($path, $fileName);
            $input['document_url'] = url('dokumen/' . $fileName);
            $filePath = $path . '/' . $fileName;
        }

        $model->update($input);

        // Jika ada file baru, upload ke ChatPDF dan update source_id
        if ($request->hasFile('document_url')) {
            $sourceId = $this->uploadToChatPDF($filePath);
            
            if ($sourceId) {
                // Update atau create list_file record
                \App\Models\ListFile::updateOrCreate(
                    ['document_id' => $model->id],
                    [
                        'source_id' => $sourceId,
                        'updated_at' => now()
                    ]
                );
            }
        }

        alert()->success('Data berhasil diubah', 'Berhasil');
        return redirect('document');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Dokumen::find($id);
        
        // Hapus file dari public/dokumen
        if ($model->document_url) {
            $fileName = basename($model->document_url);
            $filePath = public_path('dokumen/' . $fileName);
            
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        
        // Hapus record dari list_file
        \App\Models\ListFile::where('document_id', $id)->delete();
        
        $model->delete();

        alert()->success('Data berhasil dihapus', 'Berhasil');
        return redirect('document');
    }

    public function delete(Request $request)
    {
        $model = Dokumen::find($request->id);
        
        // Hapus file dari public/dokumen
        if ($model->document_url) {
            $fileName = basename($model->document_url);
            $filePath = public_path('dokumen/' . $fileName);
            
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        
        // Hapus record dari list_file
        \App\Models\ListFile::where('document_id', $request->id)->delete();
        
        $model->delete();

        return 'success';
    }

    /**
     * Upload PDF to ChatPDF and get source_id
     */
    private function uploadToChatPDF($filePath)
    {
        try {
            $uploadResponse = Http::timeout(30)->withHeaders([
                'x-api-key' => 'sec_aIH4Fr9aytRWhXMk6XGVdekYBkozhcbf'
            ])->attach(
                'file',
                file_get_contents($filePath),
                basename($filePath)
            )->post('https://api.chatpdf.com/v1/sources/add-file');

            if (!$uploadResponse->ok()) {
                Log::error('ChatPDF upload failed: ' . $uploadResponse->body());
                return null;
            }

            return $uploadResponse->json('sourceId');
        } catch (\Exception $e) {
            Log::error('ChatPDF upload failed: ' . $e->getMessage());
            return null;
        }
    }
}
