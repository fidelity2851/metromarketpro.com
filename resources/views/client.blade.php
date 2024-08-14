@extends('layouts.layout')

@section('title')
Clients
@endsection


@section('content')
<div class="col acct_cont_con px-0">

    <!-- New Client Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            @livewire('client.create-client-modal')
        </div>
    </div>


    <x-top-header title="Clients" />

    @livewire('clients')
</div>

@endsection