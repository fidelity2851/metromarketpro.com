@extends('layouts.layout')

@section('content')

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
       @livewire('team.create-team-modal')
    </div>
</div>
<div class="col acct_cont_con px-0">
   
    <x-top-header title="Team" />

    @livewire('team')

</div>
@endsection