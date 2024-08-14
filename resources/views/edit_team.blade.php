@extends('layouts.layout')

@section('content')

<div class="col acct_cont_con px-0">
    <x-top-header title="Team" />

    @livewire('team.edit-team', ['team' => $team])
</div>

@endsection