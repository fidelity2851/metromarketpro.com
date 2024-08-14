@extends('layouts.layout')

@section('content')

<div class="col acct_cont_con px-0">
    <x-top-header title="Edit Plan" />

    @livewire('plan.edit-plan', ['plan' => $plan])

    
</div>

@endsection

        
