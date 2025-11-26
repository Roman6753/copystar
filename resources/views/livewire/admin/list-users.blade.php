<div>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h2 class="sm:text-2xl text-xl font-medium title-font mb-4 text-gray-900">List Users</h2>
            </div>
            <div class="grid">

                @if(count($users) < 1)
                    <span class="text-center">Not Users</span>
                @endif

                @foreach ($users as $user)

                    <div class="p-2 w-full" id="user-{{ $user->id }}">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg">
                            <img alt="team" class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="{{ asset('storage/'.$user->avatar) }}">
                            <div class="flex-grow flex gap-x-6">
                                <h2 class="text-gray-900 title-font font-medium">{{ $user->name }}</h2>
                                <p class="text-gray-500">{{ $user->email }}</p>
                            </div>
                            <button wire:click="deleteUser({{ $user->id }})" class="inline-flex items-center bg-red-100 border-0 py-1 px-3 focus:outline-none hover:bg-red-400 rounded text-base mt-4 md:mt-0 text-wite">Delete</button>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
</div>
