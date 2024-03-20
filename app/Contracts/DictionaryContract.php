<?php


namespace App\Contracts;


use App\Models\Word;

interface DictionaryContract
{
    public function saveDictionary(Word $word, Word $meaning, string $posTag);
}
