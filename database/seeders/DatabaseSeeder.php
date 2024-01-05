<?php

namespace Database\Seeders;

// use App\Practice;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Practice::factory(10)->create();
        Movie::factory(30)->create();

        DB::table('genres')->insert([
            'name' => 'ジャンル',
        ]);

        $sheetsArray = ['a','b','c'];
        for($i=0;$i<count($sheetsArray);$i++){
            for($k=1;$k<=5;$k++){
                DB::table('sheets')->insert([
                    'column' => $k,
                    'row' => $sheetsArray[$i],
                ]);
            }
        }
    }
}
