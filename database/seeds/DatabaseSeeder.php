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
      
        /* seed user */
        DB::table('users')->insert([
            'name' => 'Gianluca',
            'surname' => 'Messinese',
            'password' => bcrypt('ciaociao'),
            'email' => 'gianluca.messi1@gmail.com',
            'admin' => true,
        ]);

    	  /* seed random poolls */
        DB::table('polls')->insert([
            'title' => str_random(15),
            'start_date' => '20160719',
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


        
        /* seeds random questions 
         *   type a: opened answer
         *   type b: single answer
         *   type c: multiple answer
         */
        $charset = 'abc';
        $polls = DB::table('polls')->get();

        foreach($polls as $poll) {
        	for($j = 0; $j < 10; $j++) {
        		DB::table('questions')->insert([
          	        'text' => str_random(20) . "?",
          			'type' => substr(str_shuffle($charset), 0, 1),
          			'poll_id' => $poll->id,
        		]);
        	}
        }



        /* seeds random options */		
		    $questions = DB::table('questions')
                            ->whereIn('type', array('b', 'c'))
                            ->get();

        foreach ($questions as $question) {
           	for($i = 0; $i < 4; $i++) {
           		DB::table('options')->insert([                      
            	    'text' => str_random(20) . ".",
            	    'ques_id' => $question->id,
            	]);
            }
        }

    }
}
