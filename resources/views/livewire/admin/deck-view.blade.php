<div class="container mx-auto p-4 grid grid-cols-1 md:grid-cols-3 gap-6 relative">

    <div class="created-by absolute top-0 left-0 p-4 text-2xl font-bold text-gray-800">
        Created By: {{ $creatorName }}
    </div>

    <div class="col-span-1 md:col-span-2">
        <div class="card bg-white text-neutral-content shadow-lg rounded-lg relative mb-6">
            <div class="absolute top-2 right-2">
                <div wire:click="toggleFavorite" class="cursor-pointer">
                    @if($isFavorite)
                        <x-heroicon-o-star name="star" class="w-6 h-6 text-yellow-500" />
                    @else
                        <x-heroicon-o-star name="star" class="w-6 h-6 text-gray-500 hover:text-yellow-500 transition-colors duration-300" />
                    @endif
                </div>
            </div>
            <div class="card-body text-center p-8">
                <div class="card-title text-4xl pt-4 text-emerald-900 font-bold mx-auto">
                    Title:
                    <br>
                    {{ $deck->title }}
                </div>

                <div class="text-lg pt-2 text-gray-700">
                    Description:
                    <br>
                    {{ $deck->description }}
                </div>
            </div>
        </div>

        <div class="flex justify-center space-x-4 mb-6">
            <x-mary-button wire:click="$set('showModal', true)" class=" rounded-md btn-success text-2xl h-10 text-white">
                Create A Flash Cardd 😃
            </x-mary-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($deck->flashcards as $flashcard)
                <div class="flip-card shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 border border-gray-300 h-64" onclick="flipCard(event, this)">
                    <div class="flip-card-inner">
                        <div class="flip-card-front p-6 flex items-center justify-center flex-col relative" x-data="{ showHint: false }">
                            <div class="absolute top-2 left-8">
                                <x-mary-button icon="o-trash" wire:click="confirmDeleteFlashcard({{ $flashcard->id }})" spinner class="btn-sm text-red-600 hover:text-red-800" onclick="event.stopPropagation()" />
                            </div>

                            <div class="card-title text-2xl font-bold text-center">
                                {{$flashcard->question}}
                            </div>

                            @if ($flashcard->image)
                                <img src="{{ asset('storage/' . $flashcard->image) }}" alt="Flashcard Image" class="w-40 h-40 mx-auto">
                            @endif

                            <div class="absolute bottom-2 right-2 flex space-x-2">
                                <x-mary-button onclick="readFlashcard(event, '{{ $flashcard->question }}')" class="btn-primary btn-sm">
                                    🔊
                                </x-mary-button>
                                <x-mary-button @click.stop="showHint = !showHint" class="btn-primary btn-sm">
                                    <span x-text="showHint ? 'Hide Hint' : 'Show Hint'"></span>
                                </x-mary-button>
                            </div>

                            <div x-show="showHint" class="hint-text mt-2 text-gray-700 italic">
                                {{$flashcard->hint}}
                            </div>
                        </div>
                        <div class="flip-card-back p-6 flex items-center justify-center flex-col">
                            <div class="text-lg pt-2 text-gray-700 text-center">
                                {{$flashcard->answer}}
                            </div>
                            <x-mary-button onclick="readFlashcard(event, '{{ $flashcard->answer }}')" class="mt-4 btn-primary">
                                🔊 Read Answe
                            </x-mary-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-span-1">
        <livewire:admin.chat :deckId="$deck->id" />
    </div>

    <x-mary-modal wire:model="showModal" title="Create A New Flashcard" class="text-2xl">
        <form wire:submit.prevent="saveFlashcard" class="space-y-4">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Question</span>
                </label>
                <input type="text" wire:model="question" class="input input-bordered w-full" placeholder="Enter Question" />
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Answer</span>
                </label>
                <textarea wire:model="answer" class="textarea textarea-bordered w-full" placeholder="Enter Answer"></textarea>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Hint</span>
                </label>
                <textarea wire:model="hint" class="textarea textarea-bordered w-full" placeholder="Enter Hint"></textarea>
            </div>
            <div class="form-control">
                <label for="image" class="label">
                    <span class="label-text">Image</span>
                </label>
                <x-mary-file wire:model="image" label="Receipt" hint="jpeg,png,jpg,gif,svg" accept="application/pdf" />
            </div>

            <x-mary-button type="submit" class="btn-primary">
                Submit
            </x-mary-button>
            <x-mary-button label="Cancel" wire:click="$set('showModal', false)" />
        </form>
    </x-mary-modal>

    <x-mary-modal wire:model="modalDeleteFlashcard" title="Are you sure you want to delete this flashcard?">
        <div class="text-gray-600">Click "cancel" or press ESC to exit.</div>

        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="$set('modalDeleteFlashcard', false)" class="bg-gray-200 hover:bg-gray-300 text-gray-700" />
            <x-mary-button label="Confirm" wire:click="deleteFlashcard" class="bg-red-600 hover:bg-red-700 text-white" />
        </x-slot:actions>
    </x-mary-modal>

    <style>
        .flip-card {
            perspective: 1000px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .flip-card-back {
            transform: rotateY(180deg);
            padding: 1rem;
            overflow-y: auto;
            word-wrap: break-word;
        }

        .created-by {
            position: absolute;
            top: 0;
            left: 0;
            padding: 1rem;
            font-size: 1.875rem; /* 3xl */
        }
    </style>

    <script>
        function flipCard(event, element) {
            element.classList.toggle('flipped');
        }

        function readFlashcard(event, text) {
            event.stopPropagation();
            const utterance = new SpeechSynthesisUtterance(text);
            speechSynthesis.speak(utterance);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        document.getElementById('chat-icon').addEventListener('click', function() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.classList.toggle('hidden');
        });
    </script>

</div>
