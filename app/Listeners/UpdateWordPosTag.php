<?php

namespace App\Listeners;

use App\Contracts\PosTagContract;
use App\Events\WordUpdated;

class UpdateWordPosTag
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param WordUpdated $event
     * @return void
     */
    public function handle(WordUpdated $event)
    {
        if ($event->word instanceof PosTagContract) {
            $event->word->updatePosTag($event->posTag);
        }
    }
}
