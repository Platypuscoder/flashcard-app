<div class="p-4">
    @if($showLoginButton)
        <div class="flex justify-center items-center min-h-screen">
            <div class="text-center mt-[-20px]"> <!-- Adjusted margin-top to move the div higher -->
                <div>
                    <img src="{{ asset('images/undraw_login_re_4vu2.svg') }}" alt="Login Illustration" class="mb-6 w-96 h-96 mx-auto">
                </div>
                <h1 class="text-4xl font-bold mb-6">Welcome to Flashcard App</h1>
                <a href="{{ route('login') }}"  class="btn btn-primary text-2xl px-8  rounded-lg shadow-lg hover:bg-blue-700 transition duration-300">Login To View Decks<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                    </svg>
                </a>

            </div>
        </div>
    @else
        @if($decks->isNotEmpty())
            <div class="shadow-lg rounded-lg overflow-hidden">
                <div class="overflow-y-auto max-h-96 bg-white">
                    <x-mary-table class="min-w-full text-lg text-gray-800" :headers="$headers" link="{{ route('admin-decks-view', '') }}/{id}" :rows="$decks->items()">
                        @forelse($decks as $deck)
                            @scope('actions', $deck)
                            @auth
                                <x-mary-button icon="o-trash" wire:click="confirmDeleteDeck({{ $deck->id }})" spinner class="btn-sm text-red-600 bg-white hover:bg-gray-100" />
                            @endauth
                            @endscope
                        @empty
                            <tr>
                                <td colspan="{{ count($headers) }}" class="text-center text-gray-500">No decks found.</td>
                            </tr>
                        @endforelse
                    </x-mary-table>
                </div>
            </div>
        @endif

        <div class="mt-6 text-center">
            {{ $decks->links() }}


        </div>

        @auth
            <div class="mt-8 text-center">
                <a href="{{ route('admin-decks-create') }}" role="button">
                    <x-mary-button label="Create New Deck" class="btn-md btn-error rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </x-mary-button>
                </a>
            </div>

                <x-mary-modal box-class="bg-white text-black" class=" backdrop-blur" wire:model.live="modalDeleteDeck" title="Are you sure you want to delete this deck?">
                <x-slot:actions>
                    <x-mary-button label="Confirm" wire:click="approveDelete" class="btn-success text-white" />
                    <x-mary-button label="Cancel" @click="$wire.modalDeleteDeck = false" class="btn-light text-white" />
                </x-slot:actions>
                </x-mary-modal>
        @endauth
    @endif

    <!-- New Section for Other Users' Decks -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Decks from Other Users</h2>

        <div class="mt-6 text-center">
            @if($public_decks->isNotEmpty())
                <div class="m-4">
                    {{ $public_decks->links() }}
                </div>

                <div class="lg:flex">
                    @foreach($public_decks as $public_deck)
                        <div class="mx-auto p-4 bg-white rounded-lg shadow-md m-4 border border-gray-400">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $public_deck->title }}</h2>
                            <p class="text-gray-600 mb-4">
                                {{ $public_deck->description }}
                            </p>
                            <div class="text-sm text-gray-500">
                                <p><span class="font-semibold">Hatched On:</span> {{ $public_deck->created_at }}</p>
                                <p><span class="font-semibold">Last Updated:</span> {{ $public_deck->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="m-4">
                    {{ $public_decks->links() }}
                </div>
            @else
                <div>
                    No one has created a ding dang deck yet!
                </div>
            @endif
        </div>
    </div>
</div>
