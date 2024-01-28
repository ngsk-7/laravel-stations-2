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
        // Movie::factory(30)->create();

        // DB::table('genres')->insert([
        //     'name' => 'ジャンル',
        // ]);


        $sheetsArray = ['A','B','C'];
        $idCount = 1;
        
        for($m=1;$m<=3;$m++){
            DB::table('screens')->insert([
                'id' => $m,
                'name' => 'スクリーン'.$m,
            ]);
            
            for($i=0;$i<count($sheetsArray);$i++){
                for($k=1;$k<=5;$k++){
                    $idExistCheck = DB::table('sheets')->where('id',$idCount)->exists();
                    if(!$idExistCheck){
                        DB::table('sheets')->insert([
                            'id' => $idCount,
                            'column' => $k,
                            'row' => $sheetsArray[$i],
                            'screen_id' => $m,
                        ]);
                    }
                    $idCount++;
                }
            }
        }

    }
}
