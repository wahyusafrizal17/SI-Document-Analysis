@extends('layouts.app-2') 
@section('content') 

    <!-- BEGIN: Content-->
    <div class="app-content content py-3 mb-0">
        <div class="content-overlay"></div>
        <div class="content-wrapper container-xxl p-0 mt-3">

            @include('profile._form')  
            
        </div>
    </div>
    
@endsection