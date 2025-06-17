<div class="card-body">

    <div class="form-group">
        <label>Nama Dokumen</label>
        {{ Form::text('document_name',null,['class'=>'form-control'])}}
        @if ($errors->has('document_name')) <span class="help-block" style="color:red">{{ $errors->first('document_name') }}</span> @endif
    </div>

    <div class="form-group mt-1">
        <label>Upload Dokumen</label>
        {{ Form::file('document_url',['class'=>'form-control'])}}
        @if ($errors->has('document_url')) <span class="help-block" style="color:red">{{ $errors->first('document_url') }}</span> @endif
    </div>
  
  </div>
  
  <div class="card-footer">
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>
            
        <a href="{{ route('document.index') }}" class="btn btn-danger btn-sm"><i class="fas fa-backward"></i> Kembali</a>
    </div>
  </div>