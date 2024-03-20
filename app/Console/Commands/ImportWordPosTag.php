<?php

namespace App\Console\Commands;

use App\Models\WordPosTag;
use Illuminate\Console\Command;

class ImportWordPosTag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postag:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = file(storage_path("data/WordPosTags.tsv"));
        $arrayMaxItems = 0;
        foreach ($file as $index => $fileLine) {
            $data = explode("\t", $fileLine);
            if ($index == 0) {
                $arrayMaxItems = count($data);
                continue;
            }
            for ($i = 0; $i < $arrayMaxItems, $i++;) {
                if (!isset($data[$i])) {
                    $data[$i] = null; // Fill null if key not exists
                }
            }

            [$code, $name, $description] = $data;
            $wordTag = WordPosTag::firstOrCreate([
                "code" => $code,
                "name" => $name,
                "description" => $description,
            ]);
            $this->info("Saved ${name} {$wordTag->code}");
        }
        return 0;
    }

}
