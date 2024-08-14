<x-guest-layout>
    <form method="POST" action="{{ route('google2fa.verify') }}">
        @csrf

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Could you please provide the Google authenticator code for authentication?') }}
        </div>
        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="one_time_password" :value="__('Authenticator Code')" />

            <x-text-input id="one_time_password" class="block mt-1 w-full" type="text" name="one_time_password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('one_time_password')" class="mt-2" />

            @if (session('error'))
            <x-input-error :messages="session('error')" class="mt-2" />
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>


    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Lost your Authenticator app? contact admin: ') }}
            <a href="mailto:{{$GlobalSettings->company_email}}" class="">{{$GlobalSettings->company_email}}</a>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </div>

        <div class="gtranslate_wrapper"></div>
        <script>
            window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","flag_size":24}
        </script>
        <script src="https://cdn.gtranslate.net/widgets/latest/popup.js" defer></script>
    </form>
</x-guest-layout>