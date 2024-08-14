@extends('layouts.layout')

@section('title')
2FA
@endsection


@section('content')
<div class="col acct_cont_con px-0">

    <x-top-header title="Two Factor Authentication" />

    {{-- Two Factor Auth --}}
    <div class="col col-lg-8 mx-auto px-0 py-5">
        @if (session('enabled'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{session('enabled')}}</strong>
        </div>
        @endif
        @if (session('disabled'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{session('disabled')}}</strong>
        </div>
        @endif

        <p class="acct_user_header text-center">Two Factor Authentication</p>
        <p class="acct_text text-center">
            When two factor authentication is enabled, you will be prompted for a secure, random token during
            authentication. You may retrieve this token from your phone's Google Authenticator App.
        </p>

        @if ($user->two_fa_secret && !$user->google2fa_secret)
        <div class="col">
            <p class="acct_label text-center">
                For two factor authentication to be enabled. Scan the following QR code using your phone's Google Authenticator App.
            </p>
            <div class="d-flex justify-content-center">{!! $qr_code !!}</div>
            <p class="acct_label text-center">{{ $secret }}</p>
        </div>

        <form method="POST" action="{{ route('google2fa.activate') }}" class="col-10 mx-auto mb-3">
            @csrf
            <div class="col px-0">
                <input type="text" name='one_time_password' class="acct_box mb-3" placeholder="OTP Code">
                <input type="text" name="secret" value="{{ $secret }}" hidden>
                @if (session('error'))
                <span class="acct_box_error">{{ session('error') }}</span>
                @endif
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="acct_btn2">Verify</button>
            </div>
        </form>
        @endif


        <div class="col d-flex justify-content-center mt-2">
            @if ($user->two_fa_secret && $user->google2fa_secret)
            <a href="{{route('google2fa.disable')}}" class="">
                <button type="button" class="acct_btn mx-auto">Disable</button></a>
            @endif
            @if ($user->two_fa_secret && !$user->google2fa_secret)
            <a href="{{route('google2fa.delete')}}" class="">
                <button type="button" class="acct_btn3 mx-auto">Delete</button></a>
            @endif
            @if (!$user->two_fa_secret)
            <a href="{{route('google2fa.enable')}}" class="">
                <button type="button" class="acct_btn2 mx-auto">Enable</button>
            </a>
            @endif
        </div>

    </div>

</div>

@endsection