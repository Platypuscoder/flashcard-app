<?php

namespace App\Livewire\Admin;

use App\Models\Deck;
use App\Models\favorites;
use App\Models\Flashcard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;

class DeckView extends Component
{
    use WithFileUploads;

   use Toast;

   public $modalDeleteFlashcard = false;
    public $creatorName;
    public bool $showModal = false;
    public $id;
    public $deck;
    public $slideshow = [];

    public $delete_flashcard_id = 0;
    public $isFavorite;

    public $flashcards = [];



     public $showCarousel = false;
    public $image;
    public $question;
    public $answer;
    public $hint;
    protected $rules = [
        'question' => 'required|min:5',
        'answer' => 'required|min:5',
        'hint' => 'required|min:5',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];


   public function toggleCarousel()
{
    $this->slideshow = $this->deck->flashcards->map(function ($flashcard) {
        return [
            'content' => view('components.flashcard-slide', ['flashcard' => $flashcard])->render()
        ];
    })->toArray();

    logger()->info('Slideshow data:', $this->slideshow);


    $this->showCarousel = !$this->showCarousel;
}

    public function saveFlashcard()
    {
        $this->validate();

        $imagepath = null;
        if ($this->image){
            $imagepath = $this->image->store('images', 'public');
        }


        Flashcard::create([
            'deck_id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'hint' => $this->hint,
            'image' => $imagepath,
        ]);

        session()->flash('message', 'Flashcard Created.');

        // Clear the form fields
        $this->reset(['question', 'answer', 'hint', 'image']);
        $this->showModal = false;
    }

    public function confirmDeleteFlashcard($id)
    {
        $this->delete_flashcard_id = $id;
        $this->modalDeleteFlashcard = true;
    }

   public function deleteFlashcard()
{
    Flashcard::where('id', $this->delete_flashcard_id)
        ->where('deck_id', $this->deck->id)
        ->firstOrFail()
        ->delete();

    $this->deck->refresh();
    $this->delete_flashcard_id = 0;
    $this->modalDeleteFlashcard = false;
    $this->success('Flashcard Deleted!');
}


    public function downloadFlashcard()
    {

}



    public function toggleFavorite()
    {
        if ($this->isFavorite){
            favorites::where('user_id', Auth::id())->where('deck_id', $this->deck->id)->delete();
        }else{
            favorites::create(['user_id' => Auth::id(), 'deck_id' => $this->deck->id]);
        }
        $this->isFavorite = !$this->isFavorite;
    }




    public function mount($id)
    {
        $this->deck = Deck::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $this->isFavorite = favorites::where('user_id', Auth::id())->where('deck_id', $id)->exists();
        $this->id = $id;

        $this->creatorName = $this->deck->user ? $this->deck->user->name : 'Unknown';




        // Collect images for the slideshow
        $this->slideshow = $this->deck->flashcards->pluck('image')->filter()->map(function ($image) {
            return asset('storage/' . $image);
        })->toArray();

        $this->flashcards = $this->deck->flashcards;

         //dd($this->flashcards);
    }

    public function render()
    {
        return view('livewire.admin.deck-view');
    }
}
