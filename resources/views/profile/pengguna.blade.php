@extends('layouts.app-2')
@section('content')
<div class="app-content content py-3 mb-0" style="background: #3a3a3a;">
    <div class="content-overlay"></div>
    <div class="content-wrapper container-xxl p-0 mt-3">
        <div class="content-body">
            <div class="row justify-content-center">
                <div class="col-lg-8" style="margin-top: 16px;">
                    <div class="card shadow border-0" style="background: rgba(30,30,30,0.85); border-radius: 2rem; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37); border: 1px solid rgba(255,255,255,0.18);">
                        <div class="card-body py-4 px-4">
                            <div class="text-center mb-4">
                                <h3 class="text-white mb-2" style="font-weight: 600;">Profile Settings</h3>
                                <p class="text-white-50">Update your personal information and preferences</p>
                            </div>
                            {{ Form::model($model, ['url'=>route('profile.update',[$model->id]), 'method'=>'PUT', 'files'=>true]) }}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white-50"><i data-feather="user" style="width: 16px; height: 16px; margin-right: 8px;"></i>Nama Lengkap</label>
                                    {{ Form::text('name', null, ['class' => 'form-control modern-input', 'placeholder' => 'Masukkan nama lengkap', 'style' => 'background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem; border: none;']) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white-50"><i data-feather="mail" style="width: 16px; height: 16px; margin-right: 8px;"></i>Email Address</label>
                                    {{ Form::email('email', null, ['class' => 'form-control modern-input', 'placeholder' => 'Masukkan email', 'style' => 'background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem; border: none;']) }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white-50"><i data-feather="image" style="width: 16px; height: 16px; margin-right: 8px;"></i>Profile Photo</label>
                                    <div class="input-group">
                                        {{ Form::file('foto', ['class' => 'form-control modern-input', 'style' => 'background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem 0rem 0rem 1rem; border: none;']) }}
                                        <span class="input-group-text" style="background: rgba(255,255,255,0.08); border-radius: 0 1rem 1rem 0; border: none;">
                                            <i data-feather="upload" style="width: 16px; height: 16px;"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white-50"><i data-feather="lock" style="width: 16px; height: 16px; margin-right: 8px;"></i>New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control modern-input" name="password" placeholder="Masukkan password baru" style="background: rgba(255,255,255,0.08); color: #fff; border-radius: 1rem 0 0 1rem; border: none;">
                                        <span class="input-group-text toggle-password" style="background: rgba(255,255,255,0.08); border-radius: 0 1rem 1rem 0; border: none; cursor: pointer;">
                                            <i data-feather="eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 text-center">
                                    <button type="submit" class="btn btn-gradient-primary px-5 py-2" style="border-radius: 1rem; font-weight: 600;">
                                        <i data-feather="save" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-3 mt-lg-0" style="margin-top: 16px !important;">
                    <div class="card text-white text-center shadow border-0" style="background: rgba(30,30,30,0.85); border-radius: 2rem; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37); border: 1px solid rgba(255,255,255,0.18);">
                        <div class="card-body py-4">
                            <div class="position-relative mb-3">
                                <img src="{{ !empty(Auth::user()->foto) ? asset('foto/'.Auth::user()->foto) : asset('app-assets/images/portrait/small/avatar-s-11.jpg') }}" class="rounded-circle" width="120" height="120" alt="Foto Profil" style="object-fit: cover; border: 4px solid rgba(255,255,255,0.18);">
                            </div>
                            <h5 class="mb-2" style="font-weight: 600;">{{ Auth::user()->name }}</h5>
                            <p class="text-white-50 mb-3">{{ Auth::user()->email }}</p>
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge" style="background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%); border-radius: 1rem; padding: 0.5rem 1rem;">
                                    <i data-feather="user" style="width: 14px; height: 14px; margin-right: 4px;"></i>
                                    {{ Auth::user()->role ?? 'Pengguna' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Quick Stats Card -->
                    {{-- <div class="card text-white text-center shadow border-0 mt-3" style="background: rgba(40,40,60,0.95); border-radius: 2rem; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37); border: 1px solid rgba(255,255,255,0.18);">
                        <div class="card-body py-3">
                            <h6 class="mb-3 text-white-50">Account Statistics</h6>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="mb-2">
                                        <i data-feather="message-circle" style="width: 24px; height: 24px; color: #6a82fb;"></i>
                                    </div>
                                    <h5 class="mb-1" style="color: #fff;">0</h5>
                                    <small class="text-white-50">Chats</small>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <i data-feather="clock" style="width: 24px; height: 24px; color: #fc5c7d;"></i>
                                    </div>
                                    <h5 class="mb-1" style="color: #fff;">0</h5>
                                    <small class="text-white-50">Sessions</small>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>    
</div>
<!-- Custom CSS for Modern Profile -->
<style>
.modern-input:focus {
    background: rgba(255,255,255,0.12) !important;
    color: #fff !important;
    box-shadow: 0 0.2rem 0.5rem rgba(16,16,32,0.25) !important;
    border: none !important;
}
.modern-input::placeholder {
    color: rgba(255,255,255,0.5) !important;
}
.btn-gradient-primary {
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
    color: #fff;
    border: none;
    transition: all 0.3s;
    box-shadow: 0 2px 8px 0 rgba(252,92,125,0.15);
}
.btn-gradient-primary:hover, .btn-gradient-primary:focus {
    background: linear-gradient(90deg, #fc5c7d 0%, #6a82fb 100%);
    color: #fff;
    box-shadow: 0 4px 16px 0 rgba(106,130,251,0.18);
    transform: translateY(-1px);
}
.card {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
.form-control {
    transition: all 0.3s;
}
.input-group-text {
    color: rgba(255,255,255,0.7);
    transition: all 0.3s;
}
.input-group-text:hover {
    color: #fff;
    background: rgba(255,255,255,0.12) !important;
}
</style>
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