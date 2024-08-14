@extends('layouts.layout')

@section('title')
Payouts
@endsection

@section('content')


<div class="col acct_cont_con px-0">
    <x-top-header title="Payouts" />

    @livewire('payouts')

</div>

@endsection