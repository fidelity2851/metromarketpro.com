@extends('layouts.layout')

@section('title')
Transfer Funds
@endsection

@section('content')
<!-- New Transfer Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        @livewire('transfer.new-transfer')
    </div>
</div>

<!-- Transfer Invoice Modal -->
<div class="modal fade " id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        @livewire('transfer.transfer-invoice')
    </div>
</div>

<div class="col acct_cont_con px-0">

    <x-top-header title="Transfer" />

    @livewire('transfer.all-transfer')

</div>
@endsection