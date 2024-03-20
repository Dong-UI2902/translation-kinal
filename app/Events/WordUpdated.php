<?php

namespace App\Events;

use App\Models\Word;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WordUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Word $word;
    public string $posTag;

    /**
     * Create a new event instance.
     *
     * @param Word $word
     * @param string $posTag
     * @return void
     */
    public function __construct(Word $word, string $posTag)
    {
        $this->word = $word;
        $this->posTag = $posTag;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('word.' . $this->word->id);
    }
}
