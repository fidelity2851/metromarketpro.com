@extends('layouts.layout')

@section('title')
Withdrawal
@endsection

@section('content')
<!-- New withdrawal Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        @livewire('withdraw.new-withdrawal')
    </div>
</div>

<!-- Withdrawal Invoice Modal -->
<div class="modal fade " id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        @livewire('withdraw.withdrawal-invoice')
    </div>
</div>

<div class="col acct_cont_con px-0">

    <x-top-header title="Withdrawal" />

    @livewire('withdraw.all-withdrawal')

</div>
@endsection