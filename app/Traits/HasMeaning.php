<?php


namespace App\Traits;

use App\Contracts\PosTagContract;
use App\Events\WordUpdated;
use App\Models\Word;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasMeaning
{

    public function meanings(): BelongsToMany
    {
        $relations = $this->meaningRelationCfg();

        return $this->belongsToMany(...$relations)
            ->withPivot($this->pivotFields())
            ->withTimestamps();
    }

    public function addMeaning(Word $meaning, string $posTag)
    {
        if (!$this instanceof PosTagContract) {
            return;
        }
        event(new WordUpdated($this, $posTag));
        event(new WordUpdated($meaning, $posTag));

        if (!$this->isMeaningHasPosTag($meaning, $posTag)) {
            $this->meanings()->attach([$meaning->id => ['pos_tag_code' => $posTag]]);
        }
    }

    public function deleteMeaning(Word $meaning)
    {
        $this->meanings()->detach($meaning);
    }

    public function getMeaningsByPosTag(string $posTag): Collection
    {
        return $this->meanings()->where('pos_tag_code', $posTag)->get();
    }

    public function isMeaningHasPosTag(Word $meaning, string $posTag): bool
    {
        return $this->meanings()->wherePivot('pos_tag_code', $posTag)->whereId($meaning->id)->exists();
    }
}
