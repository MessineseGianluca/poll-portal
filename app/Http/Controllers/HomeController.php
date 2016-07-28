<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;

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

    public function account_info() 
    {
        return view('account');
    }

    public function change_password(Request $request)
    {
        $input = $request->all();
        
        if($input['new_password'] !== $input['new_password_confirm']) {
            
            /* Communicate error */
            
            return redirect('/account');
        }
       
        $password = Auth::user()->password;

        if(Hash::check($input['old_password'] ,$password)) {
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['password' => bcrypt($input['new_password'])]);
            /* Communicate email has been modified successfully */
        }

        else {
            
            /* Communicate error */
        }

        return redirect('/account');

    }

    public function change_email(Request $request)
    {
        $input = $request->all();

        if($input['old_email'] === Auth::user()->email) {
            DB::table('users')
                ->where('email', $input['old_email'])
                ->update(['email' => $input['new_email']]);
            /* Communicate email has been modified successfully */
        }

        else {
            /* Communicate error */
        }

        return redirect('/account');
    }
}
