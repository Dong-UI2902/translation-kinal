<?php

namespace App\Http\Controllers\Translation;

use App\Http\Controllers\WordController;
use App\Models\Chinese;

class ChineseWordController extends WordController
{
    public function __construct(Chinese $word) { parent::__construct($word); }
}
