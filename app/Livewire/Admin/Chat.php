<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $deckId;
    public $newMessage;
    public $messages = [];

    public function mount($deckId)
    {
        $this->deckId = $deckId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $messages = Redis::get("chat:deck:$this->deckId");
        $this->messages = $messages ? json_decode($messages, true) : [];
    }

   public function sendMessage()
{
    if ($this->newMessage) {
        $message = [
            'user' => Auth::user()->name,
            'text' => $this->newMessage,
            'timestamp' => now()->timestamp,
        ];

        $this->messages[] = $message;
        Redis::set("chat:deck:$this->deckId", json_encode($this->messages));

        $this->newMessage = '';
    }
}

    public function render()
    {
        return view('livewire.admin.chat');
    }
}
