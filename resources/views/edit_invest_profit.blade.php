@extends('layouts.layout')

@section('content')

<div class="col acct_cont_con px-0">
    <x-top-header title="Edit Profit" />

    @livewire('investment.edit-profit', ['invest_id' => $invest_id])

    
</div>

@endsection

        
