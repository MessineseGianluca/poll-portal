<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Poll;
use App\Question;
use App\Answer;

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
        $joins = User::where('id', '=', $user->id)->with('polls')->get();
        foreach($joins as $join) {
            foreach($join->polls as $poll) {
                if($poll->id == $poll_id)
                   return redirect('/home');
            }
        }

        /* get poll informations */
        $poll = Poll::where('id', '=', $poll_id)
                    ->select('id', 'start_date', 'end_date', 'title')->first();

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

        /* Get questions of the current poll */
        $questions = Question::with('options')
                         ->whereHas('poll', function($query) use($poll_id) {
                              $query->where('poll_id', '=', $poll_id);
                         })
                         ->select('id', 'text', 'type')
                         ->get();

        return view(
            'compile',
            ['poll' => $poll, 'questions' => $questions, ]
        );
    }

    public function answer(Request $request, $poll_id)
    {
        $input = $request->all();

        foreach ($input as $key => $answer) {

            /*Check if the value corresponds to the token csrf*/
            if($key == '_token') continue;

            /* Leave "answered_ques_" from the key
               in order to only get the question id */
            $ques_id = substr($key, 14);
            $question = Question::where('id', '=', $ques_id)
              ->select('type')
              ->first();

            /* A storing answers function... */
            $insert = function($ques_id, $option, $question) {
                $answer = new Answer;
                $answer->ques_id = $ques_id;
                if($question->type !== 'a') {
                  $answer->option_id = $option;
                } else {
                  $answer->content = $option;
                }
                $answer->save();
            };

            //check if the answer has more than one option(type c)
            if(is_array($answer)) {
                foreach ($answer as $option) {
                    $insert($ques_id, $option, $question);
                }
            } else {
                $insert($ques_id, $answer, $question);
            }
        }

        /* Store the poll joining information */
        $user = Auth::user();
        User::find($user->id)->polls()->attach($poll_id);

        return redirect('/home');
    }

    public function show_result(Request $request, $poll_id) {
      /* get the poll's informations */
      $poll = Poll::where('id', '=', $poll_id)
                  ->with('users')
                  ->select('id', 'start_date', 'end_date', 'title')->first();

        /* check if $poll_id is wrong and then poll doesn't exist */
        if(!is_object ( $poll ))
            return redirect('/home');

        /* check if the poll is still opened */
        if($poll->end_date > date('Y-m-d h:i:sa'))
            return redirect('/home');


        /* check if the poll is yet to come */
        if($poll->start_date > date('Y-m-d h:i:sa'))
            return redirect('/home');

        /* check if the poll has no joins */
        $joins = $poll->users()->count();
        if(!$joins)
            return redirect('/home');

        $questions = Question::where('poll_id', $poll_id)
                        ->with('options', 'answers')
                        ->select('id', 'text', 'type')
                        ->get();

        foreach ($questions as $key => $question) {

            $answers = $question->answers;

            /* opened questions */
            if($question->type == 'a') {
                //link answers to the relative question
                $questions[$key]->options = $answers;
            }

            /* single or multiple answer question */
            else {
                $tot_num_of_answers = $question->answers()->count();

                foreach ($question->options as $o_key => $option) {
                    /* Calculate the number of answer with the current option */
                    $num_of_answers = $option->answers()->count();
                    /* Calculate the percentual */
                    $percentual = $num_of_answers / $tot_num_of_answers * 100;
                    $percentual = round($percentual, 1);
                    $questions[$key]->options[$o_key]->percentual = $percentual;
                }
            }

        }

        return view(
            'show',
            ['poll' => $poll, 'questions' => $questions, 'joins' => $joins,]
        );
    }
}
