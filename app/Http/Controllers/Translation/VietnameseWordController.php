<?php

namespace App\Http\Controllers\Translation;

use App\Http\Controllers\WordController;
use App\Models\Vietnamese;

class VietnameseWordController extends WordController
{
    public function __construct(Vietnamese $word) { parent::__construct($word); }
}
