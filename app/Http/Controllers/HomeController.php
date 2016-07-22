<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
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
    public function index()
    {          
        
        $opened_polls = DB::table('polls')
                            ->where('start_date', '<=', date('Y-m-d h:i:sa'))
                            ->where('end_date', '>', date('Y-m-d h:i:sa'))
                            ->get();

        $closed_polls = DB::table('polls')
                            ->where('end_date', '<=', date('Y-m-d h:i:sa'))
                            ->get();
        
        $incoming_polls = DB::table('polls')
                            ->where('start_date', '>', date('Y-m-d h:i:sa'))
                            ->get();
        
        $user = Auth::user();
        $answered_polls = DB::table('joins')
                            ->join('polls', function($join){
                                 $join->on('joins.poll_id', '=', 'polls.id');
                            })
                            ->where('joins.user_id', '=', $user->id)
                            ->get();                                      

        return view(  
                      'home', 
                      [
                        'opened_polls' => $opened_polls, 
                        'closed_polls' => $closed_polls, 
                        'incoming_polls' => $incoming_polls,
                        'answered_polls' => $answered_polls
                      ] 
        );
    }
}
