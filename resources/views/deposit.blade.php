@extends('layouts.layout')

@section('title')
Deposit
@endsection

@section('content')
<!-- New Deposit Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        @livewire('deposit.deposit-modal')
    </div>
</div>

<!-- Deposit Invoice Modal -->
<div class="modal fade " id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        @livewire('deposit.deposit-invoice')
    </div>
</div>

<div class="col acct_cont_con px-0">

    <x-top-header title="Deposit" />

    @livewire('deposit.all-deposit')

</div>
@endsection