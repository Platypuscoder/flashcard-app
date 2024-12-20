<?php
namespace App\Http\Livewire\Decks;

use Livewire\Component;
use App\Models\Deck;

class ViewDeck extends Component
{
public $deckId;
public $deck;

public function mount($id)
{
$this->deckId = $id;
$this->deck = Deck::findOrFail($id);
}

public function render()
{
return view('livewire.decks.view-deck');
}
}
