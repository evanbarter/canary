<label for="visibility" class="block text-sm font-medium text-gray-700 leading-5 dark-mode:text-white">
    {{ __('Visibility') }}
</label>
<div id="visibility" x-data="{ selected: {{ $visibility }} }" class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-2">
    <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': selected === 1 }" @click="selected = 1" for="visibility-1" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
        <div class="mr-2"><input wire:model="visibility" id="visibility-1" class="form-radio text-indigo-600" type="radio" name="-1" value="1" /></div>
        <div class="flex flex-col">
            <span class="font-bold">{{ __('Public') }}</span>
            <span class="text-xs sm:text-sm">{{ __('Anyone will be able to view this :type.', ['type' => $type]) }}</span>
        </div>
    </label>
    <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': selected === 0 }" @click="selected = 0" for="visibility-0" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
        <div class="mr-2"><input wire:model="visibility" id="visibility-0" class="form-radio text-indigo-600" type="radio" name="visibility-0" value="0" /></div>
        <div class="flex flex-col">
            <span class="font-bold">{{ __('Peers') }}</span>
            <span class="text-xs sm:text-sm">{{ __('Only peers may view this :type.', ['type' => $type]) }}</span>
        </div>
    </label>
    <label x-bind:class="{ 'bg-indigo-100 border-indigo-400': selected === -1 }" @click="selected = -1" for="visibility--1" class="w-full flex p-2 shadow-sm border-2 rounded text-sm">
        <div class="mr-2"><input wire:model="visibility" id="visibility--1" class="form-radio text-indigo-600" type="radio" name="visibility--1" value="-1" /></div>
        <div class="flex flex-col">
            <span class="font-bold">{{ __('Private') }}</span>
            <span class="text-xs sm:text-sm">{{ __('This :type is only visible to you.', ['type' => $type]) }}</span>
        </div>
    </label>
</div>