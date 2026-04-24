@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="bg-blob bg-blob-1"></div>
<div class="bg-blob bg-blob-2"></div>
<div class="bg-blob bg-blob-3"></div>

<div class="deco dot-1"></div>
<div class="deco dot-2"></div>
<div class="deco dot-3"></div>

<div class="star-deco"></div>

<div class="login-wrapper">
    <div class="login-card card">
        <div class="row g-0">

            <!-- GAMBAR -->
            <div class="col-md-6 panel-left d-none d-md-flex align-items-center justify-content-center">
                <div class="blob-shape"></div>

                <div class="illus-wrap">
                    <img src="{{ asset('images/gambar.png') }}">
                </div>
            </div>

            <!-- FORM -->
            <div class="col-md-6 panel-right p-5 d-flex flex-column justify-content-center">

                <h1 class="form-title mb-4">Login</h1>
                  @error('login')
                  <div class="alert alert-danger">
                     {{ $message }}
                 </div>
                  @enderror

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <input type="email" name="email" class="form-control mb-3" placeholder="Email">
                    <input type="password" name="password" class="form-control mb-3" placeholder="Password">

                    <button type="submit" class="btn btn-login">
                        Masuk
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>

@endsection