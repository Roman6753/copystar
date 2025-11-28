<div>
        <section class="text-gray-600 body-font">
        <div class="container px-5 py-2 mx-auto">
            <div class="flex flex-col text-center w-full">
                <h2 class="sm:text-2xl text-xl font-medium title-font mb-4 text-gray-900">List Country</h2>
                <div class="flex justify-between">
                   <input wire:model.live.debounce.300ms="search" type="text" placeholder="Seach..."
                        class="border border-gray-300 p-1">
                </div>
                @if (count($countries) < 1)
                    Country not found
                @else
                    <table>
                        <thead>
                            <tr class="grid grid-cols-[1fr_1fr_10fr_1fr] justify-items-start p-2 ">
                                @foreach ($fields as $key => $field)
                                    <th wire:click='changeField("{{ $field }}")' class="cursor-pointer" wire:key='{{ $key }}'>
                                        <x-sort :field="$field" :orderByField="$orderByField" :direction="$orderByDirection" />
                                    </th>
                                @endforeach
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $country)
                                <tr class="grid grid-cols-[1fr_1fr_10fr_1fr] justify-items-start items-center p-2 odd:bg-white even:bg-gray-50"
                                    wire:key="{{ $country->id }}">
                                    <td>{{ $country->id }}</td>
                                    <td>
                                        <button wire:click='minusTop({{ $country }})' class="text-2xl font-bold cursor-pointer text-blue-500">-</button>
                                        {{ $country->top }}
                                        <button wire:click='addTop({{ $country }})' class="text-2xl font-bold cursor-pointer text-green-500">+</button>
                                    </td>
                                    <td>{{ $country->name }}</td>
                                    <td>
                                        <button wire:click="deleteCountry({{ $country->id }})"
                                            class="inline-flex items-center bg-red-100 border-0 py-1 px-3 focus:outline-none hover:bg-red-400 rounded text-base mt-4 md:mt-0 text-wite">Delete</button>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    {{ $countries->links() }}
                @endif

            </div>

        </div>
    </section>
</div>
