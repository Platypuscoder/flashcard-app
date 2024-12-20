<?php
namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function view($id)
    {
        $deck = Deck::findOrFail($id);
        return view('Admin.Decks.View', compact('deck', 'id'));
    }
}
