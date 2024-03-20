<?php

namespace Database\Seeders;

use App\Models\Chinese;
use App\Models\Vietnamese;
use App\Traits\DictionaryTrait;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    use DictionaryTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $chinese = Chinese::create([
            'text' => '人',
            'type' => Chinese::TYPE_SIMPLIFIED,
        ]);

        $vietnamese = Vietnamese::create([
            'text' => 'Người',
            'type' => Vietnamese::TYPE_NORMAL,
        ]);

        $this->saveDictionary($chinese, $vietnamese, 'n');
    }

}
