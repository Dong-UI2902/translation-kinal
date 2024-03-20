<?php


namespace App\Traits;


use App\Contracts\MeaningContract;
use App\Events\DictionarySaved;
use App\Models\Word;

trait DictionaryTrait
{
    public function saveDictionary(Word $word, Word $meaning, string $posTag)
    {
        if ($word instanceof MeaningContract) {
            $word->addMeaning($meaning, $posTag);
            event(new DictionarySaved($word, $meaning, $posTag));
        }
    }
}
