<!-- resources/views/livewire/admin/create-deck.blade.php -->
<div class="container mx-auto p-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Create a New Deck</h1>
            <p class="text-gray-600 mt-2">Fill in the details below to create a new deck.</p>
        </div>
        <form wire:submit.prevent="saveDeck" class="space-y-4">
            @if (session()->has('message'))
                <div class="alert alert-success bg-green-100 text-green-800 p-4 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <div class="form-control">
                <label class="label">
                    <span class="label-text text-gray-700">Title</span>
                </label>
                <input type="text" wire:model.live.debounce.500ms="title" class="input input-bordered w-full border-gray-300 rounded-lg p-2" placeholder="Enter title" />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text text-gray-700">Description</span>
                </label>
                <textarea wire:model="description" class="textarea textarea-bordered w-full border-gray-300 rounded-lg p-2" placeholder="Enter description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-full bg-blue-500 text-white rounded-lg p-2 hover:bg-blue-600">Add Deck</button>
        </form>
    </div>
</div>
