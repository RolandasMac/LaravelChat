<?php
namespace App\Livewire;

use Livewire\Component;
use Log;

class ChatMessages extends Component
{
    // public $chatId;
    public $messages     = [];
    public $chatName     = "";
    protected $listeners = ['updateMessages' => 'updateMessages', 'addMessage' => 'addMessage', 'setContact' => 'setContact']; // Registruojame event'ą
    public function mount($messages)
    {
        // $this->chatId   = $chatId;
        $this->messages = $messages;
    }
    // public function loadMessages()
    // {
    //     $this->messages = ChatRoom::find($this->chatId)
    //         ->messages()
    //         ->with('user')
    //         ->latest()
    //         ->take(20)
    //         ->get()
    //         ->toArray();
    // }
    public function updateMessages($newMessages)
    {

        $this->messages = json_decode(json_encode($newMessages), true); // Atnaujiname žinutes

    }
    public function addMessage($message)
    {
        Log::info('Žinutė prieš pridėjimą:', ['message' => json_encode($message)]);
        $this->messages = [$message, ...$this->messages];
    }
    public function setContact($contact)
    {
        $this->chatName = $contact;
    }
    public function render()
    {
        return view('livewire.chat-messages');
    }
    // public static function booted()
    // {
    //     static::on('updateMessages', 'updateMessages');
    // }
}
