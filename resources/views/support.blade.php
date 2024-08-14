@extends('layouts.layout')

@section('title')
Support Ticket
@endsection

@section('content')
<!-- New Support Ticket Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @livewire('support.new-ticket')
    </div>
</div>

<div class="col acct_cont_con px-0">

    <x-top-header title="Tickets" />

    @livewire('support.all-tickets')

</div>
@endsection