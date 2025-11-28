<div>
    <div>

        <section class="text-gray-600 body-font">
            @session('ok')
                <div class="bg-green-400 py-2 text-white text-center">
                    {{ session('ok') }}
                </div>
            @endsession
            @session('error')
                <div class="bg-red-400 py-2 text-white text-center">
                    {{ session('error') }}
                </div>
            @endsession
            <div class="container px-5 py-2 mx-auto">
                <button wire:click='toggleActive' class="border">AddCountry</button>
                @if ($is_active)
                    <div class="flex flex-col text-center w-full">
                        <h2 class="sm:text-2xl text-xl font-medium title-font mb-4 text-gray-900">Add Country</h2>
                    </div>

                    <form wire:submit="addCountry"
                        class="flex lg:w-2/3 w-full sm:flex-row flex-col mx-auto px-8 sm:space-x-4 sm:space-y-0 space-y-4 sm:px-0 items-center">
                        <div class="relative flex-grow w-full grid grid-cols-[2fr_1fr] grid-rows-3">
                            <label for="name" class="self-end leading-7 text-sm text-gray-600">Name Country</label>
                            <input type="text" id="name" wire:model="name"
                                class="row-start-2 col-start-1 w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            @error('name')
                                <span class="row-start-3 col-start-1 text-sm text-red-400">{{ $message }}</span>
                            @enderror
                            <button type="submit"
                                class="row-start-2 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Save</button>
                        </div>
                    </form>
                @endif

            </div>
        </section>
    </div>

</div>
