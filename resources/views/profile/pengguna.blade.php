@extends('layouts.app-2') 
@section('content') 

<div class="app-content content py-3 mb-0">
    <div class="content-overlay"></div>
    <div class="content-wrapper container-xxl p-0 mt-3">
        <div class="content-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow border-0" style="background: #1E1E1E; border-radius: 12px;">
                        <div class="card-body py-4 px-4">
                            {{-- <h4 class="text-white mb-4">Pengaturan Profil</h4> --}}

                            {{ Form::model($model, ['url'=>route('profile.update',[$model->id]), 'method'=>'PUT', 'files'=>true]) }}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">Nama</label>
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap']) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">Email</label>
                                    {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">Foto</label>
                                    {{ Form::file('foto', ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control" name="password" placeholder="Your Password">
                                        <span class="input-group-text cursor-pointer toggle-password">
                                            <i data-feather="eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 text-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-3 mt-lg-0">
                    <div class="card text-white text-center shadow border-0" style="background: #1E1E1E; border-radius: 12px;">
                        <div class="card-body">
                            <img src="{{ !empty(Auth::user()->foto) ? asset('foto/'.Auth::user()->foto) : asset('app-assets/images/portrait/small/avatar-s-11.jpg') }}" class="rounded-circle mb-2" width="100" height="100" alt="Foto Profil" style="object-fit: cover">
                            <h5 class="mt-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted small">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

@endsection
@push('scripts')
<script>
    feather.replace();

    // Toggle password visibility
    document.querySelector('.toggle-password').addEventListener('click', function () {
        const input = this.previousElementSibling;
        input.type = input.type === 'password' ? 'text' : 'password';
    });
</script>
@endpush
