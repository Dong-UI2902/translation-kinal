<?php


namespace App\Contracts;


use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface PosTagContract
{
    public function posTags(): MorphToMany;

    public function addPosTag(string $posTag);

    public function updatePosTag(string $posTag);

    public function destroyPosTag(string $posTag);

    public function havePosTag(string $posTag): bool;

    public function isPosTagInUse(string $posTag): bool;
}
