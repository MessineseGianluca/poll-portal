<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Poll;
use App\Question;
use App\Option;
use App\Answer;

class AdminController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('admin');
  }

  public function index()
  {
      return view ('admin', ['polls' => Poll::all()]);
  }

  public function create_poll()
  {
      return view('create');
  }

  public function modify_poll_view($poll_id)
  {
      $poll = Poll::find($poll_id)
          ->select('id', 'title')
          ->with('questions', 'questions.options')
          ->first();

      return view('modify', ['poll' => $poll]);
  }

  public function delete_poll($poll_id)
  {
      //select questions
      $questions = Question::where('poll_id', '=', $poll_id)
          ->select('id')
          ->get();

      foreach($questions as $question) {
        //delete all asnwers
        Answer::where('ques_id', '=', $question->id )
            ->each(function ($answer, $key) { $answer->delete(); });
        //delete all options
        Option::where('ques_id', '=', $question->id )
            ->each(function ($option, $key) { $option->delete(); });
        //delete the current question
        $question->delete();
      }

      //delete the query
      Poll::destroy($poll_id);

      return redirect('/admin');
  }
}
