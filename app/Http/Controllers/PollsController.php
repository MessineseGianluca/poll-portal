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
         
        if(!is_object ( $poll )) 
            return redirect('/home');

        /* check if the poll is closed */
        elseif($poll->end_date <= date('Y-m-d'))
            return redirect('/home/closed/$id');
        
        /*check if the poll is incoming */
        elseif($poll->start_date > date('Y-m-d')) {
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
                       'title' => $poll->title,
                       'questions' => $questions,
                     ]
        );
    }
    
    public function answer()
    {

    }

    public function show_result(Request $request, $id) {
        return view('show');
    }
}
