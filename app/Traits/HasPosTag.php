<?php


namespace App\Traits;

use App\Models\WordPosTag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasPosTag
{

    public function posTags(): MorphToMany
    {
        return $this->morphToMany(WordPosTag::class, 'taggable', 'word_pos_taggables', relatedPivotKey: 'tag_code', relatedKey: 'code')->withTimestamps();
    }

    public function addPosTag(string $posTag)
    {
        $this->posTags()->attach($posTag);
    }

    public function updatePosTag(string $posTag)
    {
        if ($this->havePosTag($posTag)) {
            if (!$this->isPosTagInUse($posTag)) {
                $this->destroyPosTag($posTag);
            }
            return;
        }

        $this->addPosTag($posTag);
    }

    public function destroyPosTag(string $posTag)
    {
        $this->posTags()->detach($posTag);
    }

    public function havePosTag(string $posTag): bool
    {
        return $this->posTags()->where('tag_code', $posTag)->exists();
    }

    public function isPosTagInUse(string $posTag): bool
    {
        return $this->meanings()->wherePivot('pos_tag_code', $posTag)->exists();
    }
}
