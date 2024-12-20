<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class FaqPage extends Component

{
    public $faqs;

    public string $group = 'group1';

    public function mount()
{
    $this->faqs = [
        [
            "title" => "How do I create a new flashcard?",
            "info" => "To create a new flashcard, go to the dashboard and click on 'Create New Flashcard'. Fill in the details and save."
        ],
        [
            "title" => "Can I share my flashcards with others?",
            "info" => "Yes, you can share your flashcards by clicking on the 'Share' button and sending the link to others."
        ],
        [
            "title" => "How do I edit or delete a flashcard?",
            "info" => "To edit or delete a flashcard, go to your flashcard list, select the flashcard, and choose either 'Edit' or 'Delete'."
        ],
        [
            "title" => "What is the best way to use flashcards for studying?",
            "info" => "Use flashcards regularly, shuffle them to ensure you are not memorizing the order, and test yourself frequently."
        ],
        [
            "title" => "Can I import flashcards from other sources?",
            "info" => "Yes, you can import flashcards from other sources by using the import feature available in the settings."
        ]
    ];
}




    public function render()
    {
        return view('livewire.admin.faq-page');
    }
}
