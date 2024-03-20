<?php


namespace App\Contracts;


use App\Models\Word;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface SynonymContract
{
    public function synonymTable(): string;

    public function synonyms(): BelongsToMany;

    public function syncSynonym(Word $synonymWord);

    public function detachSynonym(Word $synonymWord);

    public function getSynonymsByPosTag(string $posTag): Collection;

}
