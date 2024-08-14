<x-mail::message>
    # New Withdrawal Request

    {{ $withdrawal->user->fullname }} made a new withdrawal of {{ number_format($withdrawal->amount) }},


    Thanks,
    {{ config('app.name') }}
</x-mail::message>