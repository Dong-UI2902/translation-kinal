<?php


namespace App\Models;


use App\Contracts\MeaningContract;
use App\Contracts\PosTagContract;
use App\Contracts\SynonymContract;
use App\Traits\HasMeaning;
use App\Traits\HasPosTag;
use App\Traits\HasSynonym;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Word extends BaseModel implements SynonymContract, PosTagContract, MeaningContract
{
    use HasFactory, SoftDeletes, HasMeaning, HasSynonym, HasPosTag;
    public static $snakeAttributes = false;

    protected $guarded = ['id'];

}
