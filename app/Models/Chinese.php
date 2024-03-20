<?php

namespace App\Models;

class Chinese extends Word
{
    const TYPE_SIMPLIFIED = 1;
    const TYPE_TRADITIONAL = 2;

    protected $table = 'chinese';

    function meaningRelationCfg(): array
    {
        return [Vietnamese::class, "chinese_vietnamese", "chinese_id", "vietnamese_id"];
    }

    public function pivotFields(): array
    {
        return ['chinese_id', 'vietnamese_id', 'frequency', "pos_tag_code"];
    }
}
