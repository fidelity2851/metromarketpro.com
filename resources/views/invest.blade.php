@extends('layouts.layout')

@section('title')
Investment
@endsection

@section('content')
<!-- New Investment Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        @livewire('investment.new-investment')
    </div>
</div>

<!-- Top Up Investment Modal -->
<div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdrop2Label" aria-hidden="true">
    <div class="modal-dialog">
        @livewire('investment.topup-investment')
    </div>
</div>

<!-- Investment Invoice Modal -->
<div class="modal fade " id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        @livewire('investment.investment-invoice')
    </div>
</div>

<div class="col acct_cont_con px-0">
    <x-top-header title="Invest" />

    @livewire('investment.all-investments')

</div>

@endsection