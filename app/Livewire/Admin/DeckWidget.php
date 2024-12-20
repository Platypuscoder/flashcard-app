<?php
namespace App\Livewire\Admin;

use App\Models\Deck;
use App\Models\Favorites;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DeckWidget extends Component
{
    public array $myChart;
    public $totalDecks;
    public $favoriteDecks;

    public function mount()
    {
        $this->totalDecks = Deck::where('user_id', '=', Auth::id())->count(); // Fetch the total number of decks
        $this->favoriteDecks = $this->getFavoriteDecks(); // Fetch favorite decks
    }

    public function getFavoriteDecks()
    {
        return Deck::whereIn('id', Favorites::where('user_id', Auth::id())->pluck('deck_id'))->pluck('title')->implode(', ');
    }

    public function render()
    {
        return view('livewire.admin.deck-widget', [
            'totalDecks' => $this->totalDecks,
            'favoriteDecks' => $this->favoriteDecks,
        ]);
    }
}
