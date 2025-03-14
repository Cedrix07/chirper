<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.update', $chirp) }}">
            @csrf
            @method('patch')
            <textarea
                name="message"
                class="block w-full border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-700 dark:border-slate-900 dark:focus:ring-blue-500 dark:focus:ring-opacity-50"
            >{{ old('message', $chirp->message) }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('chirps.index') }}" class="px-4 py-2 text-white bg-red-700 rounded-md hover:bg-red-500">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
