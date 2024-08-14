@extends('layouts.layout')

@section('content')
<div class="col acct_cont_con px-0">
    <x-top-header title="Clients" />

    @livewire('client.edit-client', ['user' => $user])

</div>
@endsection