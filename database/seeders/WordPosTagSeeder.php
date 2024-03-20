<?php

namespace Database\Seeders;

use App\Console\Commands\ImportWordPosTag;
use Artisan;
use Illuminate\Database\Seeder;

class WordPosTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call(ImportWordPosTag::class);
    }
}
