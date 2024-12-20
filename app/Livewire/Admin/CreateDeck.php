<?php

namespace App\Livewire\Admin;

use App\Models\Deck;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateDeck extends Component
{
    public $title;
    public $description;

    protected $rules = [
        'title' => 'required|min:5',
        'description' => 'required|min:10',
    ];

    public function saveDeck()
    {
        $this->validate();

        // Ensure the user is authenticated
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to create a deck.');
            return;
        }

        // Save the deck with the user_id
        Deck::create([
            'title'       => $this->title,
            'description' => $this->description,
            'user_id'     => Auth::id(), // Ensure user_id is set
        ]);

        session()->flash('message', 'Deck Created.');

        // Clear the form fields
        $this->reset(['title', 'description']);
    }

    public function updatedTitle() {
        $this->description = $this->aiNoteBody( 'Create a flashcard text description in less than 200 characters on: '. $this->title );
    }

    public function aiNoteBody($message)
    {
        $openAIService = new openAIservice();
        $response = $openAIService->chatWithGPT($message);

        return $response;
    }

    public function render()
    {
        return view('livewire.admin.create-deck');
    }
}
