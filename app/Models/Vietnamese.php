<?php

namespace App\Models;

class Vietnamese extends Word
{

    const TYPE_NORMAL = 1;
    const TYPE_CHINESE_VIETNAMESE = 2;

    protected $table = 'vietnamese';

    function meaningRelationCfg(): array
    {
        return [Chinese::Class, "chinese_vietnamese", "vietnamese_id", "chinese_id"];
    }

    public function pivotFields(): array
    {
        return ['chinese_id', 'vietnamese_id', 'frequency', "pos_tag_code"];
    }
}
