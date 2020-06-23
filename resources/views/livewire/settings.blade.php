
<div class="h-full flex justify-center min-h-screen bg-gray-200 dark-mode:bg-gray-700 shadow-inner p-6 sm:p-24">
    <div
        x-cloak
        x-data="{ show: false }"
        x-show="show"
        x-init="setTimeout(() => { show = true }, 200)"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 transform"
        x-transition:enter-end="opacity-100 transform"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform"
        x-transition:leave-end="opacity-0 transform"
        class="flex flex-col w-11/12 max-w-6xl h-full">
        <a class="mb-2 inline-block text-xl text-center transition-colors duration-200 ease-linear hover:bg-black hover:text-white py-2 px-8 rounded-full" href="{{ route('home') }}">
            <svg class="h-6 w-6 inline -mt-1" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
            Back
        </a>
        <div x-data="{ active: 'settings' }" class="bg-white rounded-lg shadow-xl">
            <ul class="bg-gray-100 rounded-tl-lg rounded-tr-lg text-gray-600 p-3 mb-6">
                <li @click="active = 'settings'" class="inline-block px-4 py-3 cursor-pointer mr-3 transition-colors duration-150 ease-linear rounded-lg" :class="{ 'shadow-inner bg-gray-500 hover:bg-gray-600 hover:text-white text-gray-50': active === 'settings', 'hover:bg-gray-200 hover:text-black': active !== 'settings' }">{{ __('Settings') }}</li>
                <li @click="active = 'followers'" class="inline-block px-4 py-3 cursor-pointer mr-3 transition-colors duration-150 ease-linear rounded-lg" :class="{ 'shadow-inner bg-gray-500 hover:bg-gray-600 hover:text-white text-gray-50': active === 'followers', 'hover:bg-gray-200 hover:text-black': active !== 'followers' }">{{ __('Followers') }}</li>
            </ul>
            @if (session()->has('success'))
            <div
                x-cloak
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => { show = false }, 5000)"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform"
                x-transition:leave-end="opacity-0 transform"
                class="mb-6 mx-8 p-3 shadow-sm bg-green-200 text-green-600 leading-none rounded-full flex items-center" role="alert">
                <svg class="inline-block h-6 w-6 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                <span class="text-sm text-left flex-auto">{{ session('success') }}</span>
          </div>
            @endif
            <div class="flex flex-col" x-show="active === 'settings'">
                <div class="flex flex-col sm:flex-row mx-8 pb-6 border-b-2 border-gray-100">
                    <div class="sm:w-1/3 pb-4">
                        <label for="password_current" class="block text-lg leading-tight font-medium">{{ __('Update Password') }}</label>
                    </div>
                    <div class="sm:w-2/3">
                        <div>
                            <label for="text" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">{{ __('Your current password') }}</label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input wire:model.lazy="passwordCurrent" id="passwordCurrent" name="passwordCurrent" type="password" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('passwordCurrent') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                            </div>
                            @error('passwordCurrent')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="text" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">{{ __('Enter new password') }}</label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input wire:model.lazy="password" id="password" name="password" type="password" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="text" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">{{ __('Confirm new password') }}</label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input wire:model.lazy="passwordConfirmation" id="passwordConfirmation" name="passwordConfirmation" type="password" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('passwordConfirmation') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark-mode:bg-gray-700">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="updatePassword" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            {{ __('Update Password') }}
                        </button>
                    </span>
                </div>

                <div class="flex flex-col" x-show="active === 'followers'">
                    Followers
                </div>
            </div>
        </div>
    </div>
</div>