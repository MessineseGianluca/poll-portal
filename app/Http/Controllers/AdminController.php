<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Poll;

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

  public function modify_poll_view(Request $request, $poll_id)
  {
      return view('modify', ['poll' => $poll_id]);
  }
}
