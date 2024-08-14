@extends('layouts.layout')

@section('title')
Plans
@endsection

@section('content')

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @livewire('plan.create-new-plan')
    </div>
</div>


<div class="col acct_cont_con px-0">
    <x-top-header title="Plans" />

    @livewire('plans')

</div>

@endsection