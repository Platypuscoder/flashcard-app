<div wire:poll.30s class="p-4 bg-gray-100 rounded-lg shadow-md">
    <div class="chat-container space-y-4 overflow-y-auto h-64">
        @foreach($messages as $message)
            <div class="message p-3 bg-white rounded-lg shadow-sm">
                <strong class="text-blue-600">{{ $message['user'] }}:</strong>
                <span class="text-gray-800">{{ $message['text'] }}</span>
                <span class="timestamp text-gray-500 text-sm">{{ \Carbon\Carbon::createFromTimestamp($message['timestamp'])->diffForHumans() }}</span>
            </div>
        @endforeach
    </div>

    <div class="new-message mt-4 flex items-center space-x-2">
        <input type="text" wire:model="newMessage" placeholder="Type your message here..." class="input input-bordered w-full" />
        <button wire:click="sendMessage" class="btn btn-primary">Send</button>
    </div>
</div>
