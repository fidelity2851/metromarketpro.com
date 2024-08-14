<x-mail::message>
    # Welcome to {{ config('app.name') }} - Your Journey Begins Here!

    Dear {{ $user->fullname }},

    We are thrilled to welcome you to {{ config('app.name') }}! 🎉

    Thank you for choosing us as your Invesment provider. We are committed to providing you with top-notch Invesment and
    a seamless experience. Whether you're looking to gain financial freedom or grow your wealth, we're here to support
    you every step of the way.


    Thanks,
    {{ config('app.name') }}
</x-mail::message>