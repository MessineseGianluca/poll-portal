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
      $poll = Poll::where('id', '=', $poll_id)
          ->select('id', 'title')
          ->with('questions', 'questions.options')
          ->first();

      return view('modify', ['poll' => $poll]);
  }

  public function delete_poll($poll_id)
  {
    /* Delete all questions, answers, options linked to the poll */
    $poll = Poll::where('id', '=', $poll_id)
      ->with([
        'questions.answers' => function ($query) {
          $query->each(function($answer) { $answer->delete(); });
        },
        'questions.options' => function ($query) {
          $query->each(function($option) { $option->delete(); });
        },
        'questions' => function ($query) {
          $query->each(function($question) { $question->delete(); });
        }])
      ->first();
    Poll::destroy($poll_id);
    return redirect('/admin');
  }

  public function delete_question($question_id)
  {
    // Delete all options and answers linked to the question
    $question = Question::where('id', '=', $question_id)
      ->with([
        'options' => function ($query) {
          $query->each(function($option) { $option->delete(); });
        },
        'answers' => function ($query) {
          $query->each(function($answer) { $answer->delete(); });
        }])
      ->first();

    $poll_id = $question->poll_id;
    Question::destroy($question_id);
    return redirect('/admin/' . $poll_id);
  }
}
