<x-guest-layout>
    <form method="POST" action="{{ route('register.organizer.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Bio -->
        <div class="mt-4">
            <x-input-label for="bio" :value="__('Bio')" />
            <x-textarea id="bio" class="block mt-1 w-full" name="bio" required>{{ old('bio') }}</x-textarea>
            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
        </div>

        <!-- Startup Affiliation -->
        <div class="mt-4">
            <x-input-label for="startup_affiliation" :value="__('Startup Affiliation')" />
            <x-text-input id="startup_affiliation" class="block mt-1 w-full" type="text" name="startup_affiliation" :value="old('startup_affiliation')" required />
            <x-input-error :messages="$errors->get('startup_affiliation')" class="mt-2" />
        </div>

        <!-- Organization Name -->
        <div class="mt-4">
            <x-input-label for="organization_name" :value="__('Organization Name')" />
            <x-text-input id="organization_name" class="block mt-1 w-full" type="text" name="organization_name" :value="old('organization_name')" required />
            <x-input-error :messages="$errors->get('organization_name')" class="mt-2" />
        </div>

        <!-- Organization Description -->
        <div class="mt-4">
            <x-input-label for="organization_description" :value="__('Organization Description')" />
            <x-textarea id="organization_description" class="block mt-1 w-full" name="organization_description" required>{{ old('organization_description') }}</x-textarea>
            <x-input-error :messages="$errors->get('organization_description')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register as Organizer') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> 