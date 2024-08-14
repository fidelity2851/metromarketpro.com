@extends('layouts.layout')

@section('title')
Notification
@endsection

@section('content')

<div class="col acct_cont_con px-0">
    <x-top-header title="Notification" />

    @livewire('notification')

</div>

@endsection