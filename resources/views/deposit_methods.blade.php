@extends('layouts.layout')

@section('title')
Deposit Methods
@endsection


@section('content')
<div class="col acct_cont_con px-0">

    <!-- New Deposit Method Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            @livewire('payment.new-deposit-method')
        </div>
    </div>


    <x-top-header title="Settings" />

    @livewire('payment.deposit-methods')
</div>

@endsection