<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Add fund into your account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and card_no address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.fund') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="amount" :value="__('Amount')" />
            <x-text-input id="amount" name="amount" type="number" min="0" class="mt-1 block w-full" :value="old('amount')" required autofocus autocomplete="amount" />
            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
        </div>

        <div>
            <x-input-label for="card_no" :value="__('Card no')" />
            <x-text-input id="card_no" name="card_no" type="number" class="mt-1 block w-full" :value="old('card_no', $user->card_no)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('card_no')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Add fund') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('add fund.') }}</p>
            @endif
        </div>
    </form>
</section>
