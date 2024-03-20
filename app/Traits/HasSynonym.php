<?php


namespace App\Traits;

use App\Models\Word;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasSynonym
{

    public function synonymTable(): string
    {
        return strtolower(\Str::afterLast($this::class, "\\") . "_synonyms");
    }

    function synonyms(): BelongsToMany
    {
        return $this->belongsToMany($this::class, $this->synonymTable(), "word1_id", "word2_id")->withTimestamps();
    }

    function syncSynonym(Word $synonymWord)
    {
        if ($synonymWord === $this) {
            return;
        }

        $this->synonyms()->syncWithoutDetaching($synonymWord);
        $synonymWord->synonyms()->syncWithoutDetaching($this);
    }

    public function detachSynonym(Word $synonymWord)
    {
        $this->synonyms()->detach($synonymWord);
        $synonymWord->synonyms()->detach($this);
    }

    function getSynonymsByPosTag(string $posTag): Collection
    {
        return $this->synonyms()->where('pos_tag_code', $posTag)->get();
    }
}
