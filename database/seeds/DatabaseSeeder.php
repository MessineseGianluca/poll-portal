<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//seed random poolls
        DB::table('polls')->insert([
            'title' => str_random(15),
            'start_date' => '20160721',
            'end_date' => '20170721',
        ]);

        DB::table('polls')->insert([
            'title' => str_random(15),
            'start_date' => '20160721',
            'end_date' => '20170721',
        ]);

        DB::table('polls')->insert([
            'title' => str_random(15),
            'start_date' => '20160722',
            'end_date' => '20170122',
        ]);

        DB::table('polls')->insert([
            'title' => str_random(15),
            'start_date' => '20150722',
            'end_date' => '20160222',
        ]);
        
        //seeds random questions
        $charset = 'abc';
        for($i = 1; $i < 5; $i++) {
        	for($j = 0; $j < 10; $j++) {
        		DB::table('questions')->insert([
          	        'text' => str_random(20) . "?",
          			'type' => substr(str_shuffle($charset), 0, 1),
          			'poll_id' => $i,
        		]);
        	}
        }

        //seeds random options
        

    }
}
