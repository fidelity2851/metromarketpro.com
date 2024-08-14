@extends('layouts.layout')

@section('title')
Support Ticket
@endsection

@section('content')
<div class="col acct_cont_con px-0">
    <x-top-header title="Tickets" />

    @livewire('support.edit-ticket', ['ticket_id' => $ticket])

</div>
@endsection