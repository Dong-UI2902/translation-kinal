<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class WordPosTag extends BaseModel
{
    use HasFactory;

    protected $guarded = ['code'];

    public function vietnamese(): MorphToMany
    {
        return $this->morphedByMany(Vietnamese::class, "taggable", "word_pos_taggables")->withTimestamps();
    }

    public function chinese(): MorphToMany
    {
        return $this->morphedByMany(Chinese::class, "taggable", "word_pos_taggables")->withTimestamps();
    }
}
