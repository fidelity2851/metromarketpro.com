<x-mail::message>
    # New Deposit Request

    {{ $deposit->user->fullname }} made a new deposit of {{ number_format($deposit->amount) }},


    Thanks,
    {{ config('app.name') }}
</x-mail::message>