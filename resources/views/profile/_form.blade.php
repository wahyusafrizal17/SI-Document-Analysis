<div class="content-body">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Profile Details</h4>
                </div>
                <div class="card-body py-2 my-25">
                    <!-- form -->
                    {{ Form::model($model,['url'=>route('profile.update',[$model->id]),'class'=>'form-horizontal','method'=>'PUT','files'=>true])}}
                        <div class="row">
                            <div class="col-12 col-sm-12 mb-1">
                                <label class="form-label" for="accountFirstName">Nama</label>
                                {{ Form::text('name', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-12 col-sm-12 mb-1">
                                <label class="form-label" for="accountLastName">Email</label>
                                {{ Form::email('email', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-12 col-sm-12 mb-1">
                                <label class="form-label" for="accountEmail">Foto</label>
                                {{ Form::file('foto', ['class' => 'form-control']) }}
                            </div>
                            <div class="col-12 col-sm-12 mb-1">
                                <label class="form-label" for="accountOrganization">Password</label>
                                <div class="input-group input-group-merge form-password-toggle mb-2">
                                    <input type="password" class="form-control" id="basic-default-password1" placeholder="Your Password" aria-describedby="basic-default-password1">
                                    <span class="input-group-text cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye font-small-4"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save changes</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <!--/ form -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 text-center">
                        <img src="{{ !empty(Auth::user()->foto) ? asset('foto/'.Auth::user()->foto) : asset('app-assets/images/portrait/small/avatar-s-11.jpg') }}" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" height="100" width="100">
                    </div>
                    <h5 class="mb-75">Nama</h5>
                    <p class="card-text">
                        {{ Auth::user()->name }}
                    </p>
                    <div class="mt-2">
                        <h5 class="mb-75">Email</h5>
                        <p class="card-text">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>