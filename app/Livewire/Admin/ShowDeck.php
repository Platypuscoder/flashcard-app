<?php

namespace App\Livewire\Admin;

use App\Models\Deck;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ShowDeck extends Component
{
    use Toast, WithPagination;

    public bool $modalDeleteDeck = false;
    public $headers;
    public $delete_deck_id = 0;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        // dd( $this->aiNoteBody("Write a short poem about cats.") );

        $this->modalDeleteDeck = false; // Ensure the modal is closed on load




        $this->headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'title', 'label' => 'Deck Title'],
            ['key' => 'description', 'label' => 'Deck Description']
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function confirmDeleteDeck($id)
    {
        $this->delete_deck_id = $id;
        $this->modalDeleteDeck = true;
    }

    public function approveDelete()
    {
        $this->deleteDeck($this->delete_deck_id);
        $this->modalDeleteDeck = false; // Ensure the modal is closed after deletion

    }

    public function getOtherUsersDecks()
    {
        return Deck::where('user_id', '!=', Auth::id())
            ->where('title', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function deleteDeck($id)
    {
        $deck = Deck::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete related flashcards
        $deck->flashcards()->delete();

        // Delete the deck
        $deck->delete();

        $this->resetPage();
        $this->delete_deck_id = 0;
        $this->modalDeleteDeck = false;
        $this->success('Deck Is Deleted!');
    }


    public function render()
    {
        if(Auth::check()) {
            $decks = Deck::query()
                ->where('user_id', '=', Auth::id())
                ->paginate(2);

            $public_decks = Deck::where('user_id', '!=', Auth::id())
                ->where('title', 'like', '%' . $this->search . '%')
                ->paginate(100);
        } else {
            $decks = Deck::query()
                ->paginate(100);

            $public_decks = Deck::where('title', 'like', '%' . $this->search . '%')
                ->paginate(100);
        }


        return view('livewire.admin.show-deck', [
            'decks'           => $decks,
            'public_decks'    => $public_decks,
            'showLoginButton' => (!Auth::check()),
        ]);
    }
}
