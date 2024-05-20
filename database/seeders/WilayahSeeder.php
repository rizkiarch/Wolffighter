<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Wilayah::whereCode('92.71.10.1004')->exists()) {
            return;
        }

        $this->command->info('Run seeding wilayah');
        $sqlFile = file_get_contents('database/seeders/_wilayah_nkri.sql');
        $statements = array_filter(array_map('trim', explode(';', $sqlFile)));

        $this->command->withProgressBar(count($statements), function (ProgressBar $bar) use ($statements) {
            $bar->start();
            foreach ($statements as $statement) {
                \DB::statement($statement);
                $bar->advance();
            }
            $bar->finish();
            $this->command->newLine(2);
        });
    }
}
