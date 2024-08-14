@extends('layouts.layout')

@section('title')
KYC Portal
@endsection

@section('content')

<div class="col acct_cont_con px-0">

    <x-top-header title="Kyc Portal" />

    @livewire('kyc.kyc-portal')

</div>

@endsection
