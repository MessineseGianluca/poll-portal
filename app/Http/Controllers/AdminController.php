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
          ->select('id', 'title', 'start_date', 'end_date')
          ->with('questions', 'questions.options')
          ->first();
      /* Convert datetime in date format */
      $poll->start_date = strtotime($poll->start_date);
      $poll->start_date = date('Y-m-d', $poll->start_date);
      $poll->end_date = strtotime($poll->end_date);
      $poll->end_date = date('Y-m-d', $poll->end_date);

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

  public function delete_option($option_id)
  {

    $option = Option::where('id', '=', $option_id)
    ->with([
      'answers' => function($query) {
        $query->each(function($answer) { $answer->delete(); });
      },
      'question' => function($query) {
        $query->first();
      }])
    ->first();
    $poll_id = $option->question->poll_id;
    Option::destroy($option->id);
    return redirect('/admin/' . $poll_id);
  }

  public function create_question(Request $request) {
    if(!empty($request->input('title'))) {
      $question = new Question;
      $question->text = $request->input('title');
      $question->type = $request->input('ques_type');
      $question->poll_id = $request->input('poll_id');
      $question->save();
    }
    return redirect('/admin/' . $request->input('poll_id'));
  }

  public function create_option(Request $request) {
    if(!empty($request->input('title'))) {
      $option = new Option;
      $option->text = $request->input('title');
      $option->ques_id = $request->input('ques_id');
      $option->save();
    }
    return redirect('/admin/' . $request->input('poll_id'));
  }

  public function modify_poll(Request $request, $poll_id) {
    $poll = Poll::find($poll_id);
    if(!empty($request->input('title')))
      $poll->title = $request->input('title');
    $poll->start_date = $request->input('start_date');
    $poll->end_date = $request->input('end_date');
    $poll->save();
    return redirect('/admin/' . $poll_id);
  }


}
