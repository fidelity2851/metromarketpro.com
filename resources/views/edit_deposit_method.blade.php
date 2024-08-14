@extends('layouts.layout')

@section('content')

<div class="col acct_cont_con px-0">
    <x-top-header title="Settings" />

    <div class="col py-4 px-0 px-md-3">

        <div class="col d-md-flex justify-content-between align-items-center mb-4">
            <p class="acct_cont_header">Update Payment Method</p>
            <a href="{{ route('deposit-methods') }}" class="text-decoration-none"> <button type="button" class="acct_btn2"> <i
                        class="fas fa-arrow-left mr-2"></i> Back</button> </a>
        </div>

        <div class="col">
            <div class="col acct_newdep_cont shadow-sm ">
                @livewire('payment.edit-deposit-method', ['method' => $method])
            </div>
        </div>

    </div>

</div>

</div>

@endsection