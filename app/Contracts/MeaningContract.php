<?php


namespace App\Contracts;


use App\Models\Word;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface MeaningContract
{
    public function meaningRelationCfg(): array;

    public function pivotFields(): array;

    public function meanings(): BelongsToMany;

    public function addMeaning(Word $meaning, string $posTagCode);

    public function deleteMeaning(Word $meaning);

    public function getMeaningsByPosTag(string $posTag): Collection;

    public function isMeaningHasPosTag(Word $meaning, string $posTag): bool;
}
