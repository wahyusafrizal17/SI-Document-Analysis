<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Http\Requests\Dokumen\StoreRequest;
use App\Http\Requests\Dokumen\UpdateRequest;
use Illuminate\Support\Facades\File;

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

            // === Tambahan: copy ke storage/app/chatpdf-files ===
            $chatPdfFolder = storage_path('app/chatpdf-files');

            if (!File::exists($chatPdfFolder)) {
                File::makeDirectory($chatPdfFolder, 0755, true);
            }

            $sourcePath = $path . '/' . $fileName;
            $targetPath = $chatPdfFolder . '/' . $fileName;

            File::copy($sourcePath, $targetPath);
        }

        $input['upload_by'] = \Auth::user()->id;
        Dokumen::create($input);

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

            // === Tambahan: copy ke storage/app/chatpdf-files ===
            $chatPdfFolder = storage_path('app/chatpdf-files');

            if (!File::exists($chatPdfFolder)) {
                File::makeDirectory($chatPdfFolder, 0755, true);
            }

            $sourcePath = $path . '/' . $fileName;
            $targetPath = $chatPdfFolder . '/' . $fileName;

            File::copy($sourcePath, $targetPath);
        }

        $model->update($input);

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
        $model->delete();

        alert()->success('Data berhasil dihapus', 'Berhasil');
        return redirect('document');
    }

    public function delete(Request $request)
    {
        $category = Dokumen::find($request->id);
        $category->delete();

        return 'success';
    }
}
