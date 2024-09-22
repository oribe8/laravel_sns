<x-guest-layout>
    <form method="POST" action="{{ route('register') }}"  enctype="multipart/form-data">
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

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- ↓新規追加↓ -->

        <!-- プロフィール文 -->
        <div class="mt-4">
            <x-input-label for="profile_text" value="プロフィール文" />
            <!-- <x-text-input id="profile_text" class="block mt-1 w-full" type="text" name="profile_text" :value="old('profile_text')" /> -->
            <input id="profile_text" class="block mt-1 w-full" type="text" name="profile_text" value="{{old('profile_text')}}">
            <x-input-error :messages="$errors->get('profile_text')" class="mt-2" />
        </div>

        <!-- プロフィール画像 -->
        <div class="mt-4">
            <x-input-label for="profile_image" value="プロフィール画像" />
            <!-- <x-text-input id="profile_image" class="block mt-1 w-full" type="file" name="profile_image" :value="old('profile_image')" /> -->
            <input id="profile_image" class="block mt-1 w-full" type="file" name="profile_image" value="{{old('profile_image')}}">
            <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
        </div>

        <!-- ↑新規追加↑ -->

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
