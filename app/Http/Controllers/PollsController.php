<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class PollsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {          
        $poll = DB::table('polls')
                        ->where('id', $id)->first();
        
        /* check if $id is wrong and then poll doesn't exist */ 
        if(!is_object ( $poll )) 
            return redirect('/home');

        /* check if the poll is closed */
        elseif($poll->end_date <= date('Y-m-d h:i:sa'))
            return redirect('/home/closed/' . $id);
        
        /*check if the poll is incoming */
        elseif($poll->start_date > date('Y-m-d h:i:sa')) {
            return redirect('/home');
        }

        $questions = DB::table('questions')
                            ->where('poll_id', $id)
                            ->get();

        foreach ($questions as $key => $question) {
            $options = DB::table('options')
                            ->where('ques_id', $question->id)
                            ->get();
            $questions[$key]->options = $options;             
        }

        return view(
                     'compile', 
                     [
                       'poll' => $poll,
                       'questions' => $questions,
                     ]
        );
    }
    
    public function answer(Request $request, $id)
    {
        
        $input = $request->all();

        foreach ($input as $key => $answer) {
      
            /*Check if the value corresponds to the token csrf*/
            if($key == '_token') continue;

            /* Leave "answered_ques_" from the key 
               in order to only get the question id */
            $ques_id = substr($key, 14);
            
            //check if the answer has more than one option(type c)
            if(is_array($answer)) {

                foreach ($answer as $option) {
                    $options = DB::table('answers')
                        ->insert(
                            array(
                              'ques_id' => $ques_id, 
                              'content' => $option
                            )
                        );
                }   
            }
            else {
                $options = DB::table('answers')
                             ->insert(
                                array(
                                  'ques_id' => $ques_id, 
                                  'content' => $answer
                                )
                            );
            }
        }

        return redirect('/home');
        
    }

    public function show_result(Request $request, $id) {
        return view('show');
    }
}
