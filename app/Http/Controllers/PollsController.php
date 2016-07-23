<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;

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
    public function index(Request $request, $poll_id)
    {   
        /* Check if the user has already done the poll */       
        $user = Auth::user();
        $join = DB::table('joins')
                    ->where('poll_id', $poll_id)
                    ->where('user_id', $user->id)
                    ->count();
        if($join > 0) 
            return redirect('/home');
        
        /* get poll informations */
        $poll = DB::table('polls')
                    ->select('id', 'start_date', 'end_date', 'title')
                    ->where('id', $poll_id)
                    ->first();
        
        /* check if $id is wrong and then poll doesn't exist */ 
        if(!is_object ( $poll )) 
            return redirect('/home');

        /* check if the poll is closed */
        elseif($poll->end_date <= date('Y-m-d h:i:sa'))
            return redirect('/home/closed/' . $poll_id);
        
        /*check if the poll is incoming */
        elseif($poll->start_date > date('Y-m-d h:i:sa')) {
            return redirect('/home');
        }

        $questions = DB::table('questions')
                         ->select('id', 'text', 'type')
                         ->where('poll_id', $poll_id)
                         ->get();

        foreach ($questions as $key => $question) {
            $options = DB::table('options')
                            ->select('id', 'text')
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
                    DB::table('answers')
                        ->insert(
                            array(
                                'ques_id' => $ques_id, 
                                'content' => $option
                            )
                        );
                }   
            }

            else {
                DB::table('answers')
                    ->insert(
                        array(
                            'ques_id' => $ques_id, 
                            'content' => $answer
                        )
                    );
            }
        }

        /* Store the poll joining information */
        $user = Auth::user();
        DB::table('joins')
            ->insert(
                    array(
                        'poll_id' => $id, 
                        'user_id' => $user->id
                    )
            );

        return redirect('/home');
        
    }

    public function show_result(Request $request, $poll_id) {
        
        $poll = DB::table('polls')
                   ->select('id', 'start_date', 'end_date', 'title')
                   ->where('id', $poll_id)
                   ->first();

        /* check if $poll_id is wrong and then poll doesn't exist */ 
        if(!is_object ( $poll )) 
            return redirect('/home');           

        /* check if the poll is still opened */
        if($poll->end_date > date('Y-m-d h:i:sa')) 
            return redirect('/home');
        
        
        /* check if the poll is yet to come */
        if($poll->start_date > date('Y-m-d h:i:sa')) 
            return redirect('/home');
        
        /* number of joins*/
        $joins = DB::table('joins')
                     ->where('poll_id', $poll_id)
                     ->count();
        if($joins == 0) 
            return redirect('home');
        
        $questions = DB::table('questions')
                        ->select('id', 'text', 'type')
                        ->where('poll_id', $poll_id)
                        ->get();
        
        foreach ($questions as $key => $question) {
            
            $answers = DB::table('answers')
                           ->select('id', 'content')
                           ->where('ques_id', $question->id)
                           ->get();

            /* opened questions */
            if($question->type == 'a') {                           
                //link answers to the relative question 
                $questions[$key]->answers = $answers;
            }
            
            /* single answer question */
            else if($question->type == 'b' || $question->type =='c') {

                $options = DB::table('options')
                               ->select('id', 'text')
                               ->where('ques_id', $question->id)
                               ->get();
                
                $questions[$key]->options = $options;
                
                $tot_num_of_answers = DB::table('answers')
                                          ->where('ques_id', $question->id)
                                          ->count();

                foreach ($options as $o_key => $option) {
                    $num_of_answers = DB::table('answers')
                                          ->where('content', $option->id)
                                          ->count();
                    /* Calculate the percentual */
                    $percentual = $num_of_answers / $tot_num_of_answers * 100;
                    $questions[$key]->options[$o_key]->percentual = $percentual;
                }
            }

            print_r($questions[$key]);
            echo "<br><br><br>";
            
        }                
        

        return view(
            'show',
            [
                'poll' => $poll,
                'questions' => $questions,
                'joins' => $joins,
            ]
        );
    }
}
