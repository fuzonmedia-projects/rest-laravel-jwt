<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0;$i<=10;++$i){
            DB::table('products')->insert([
                'order_number'=>Str::random(10),
                'order_ammt'=>rand(1,50),
                
            ]);
        }
    }
}
