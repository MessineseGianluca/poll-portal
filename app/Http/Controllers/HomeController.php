<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Poll;
use App\User;
use DB;


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
        $opened_polls = Poll::where('start_date', '<=', date('Y-m-d h:i:sa'))
                            ->where('end_date', '>', date('Y-m-d h:i:sa'))
                            ->get();


        $closed_polls = Poll::where('end_date', '<=', date('Y-m-d h:i:sa'))
                            ->get();

        $incoming_polls = Poll::where('start_date', '>', date('Y-m-d h:i:sa'))
                            ->get();

        $joins = User::where('id', '=', Auth::user()->id)->with('polls')->get();

        $answered_polls = NULL;

        foreach($joins as $join) {
            foreach($join->polls as $poll) {
                $answered_polls[] = $poll->title;
            }
        }

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
        $this->validate($request, [
            'old_password' => 'required|max:16|min:8',
            'new_password' => 'required|max:16|min:8',
            'new_password_confirm' => 'required|max:16|min:8',
        ]);

        $input = $request->all();

        if($input['new_password'] !== $input['new_password_confirm']) {

            /* Communicate error */

            return redirect('/account');
        }

        if($input['old_password'] === $input['new_password']) {

            /* Communicate Error */

            return redirect('/account');
        }

        $password = Auth::user()->password;

        if(Hash::check($input['old_password'], $password)) {
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($input['new_password']);
            $user->save();
            /* Communicate email has been modified successfully */
        }

        else {

            /* Communicate error */
        }

        return redirect('/account');

    }

    public function change_email(Request $request)
    {
        $this->validate($request, [
            'old_email' => 'required|max:255',
            'new_email' => 'required|unique:users,email|max:255',
        ]);

        $input = $request->all();

        $user = Auth::user();
        if($input['old_email'] === $user->email) {

            $user = User::find($user->id);
            $user->email = $input['new_email'];
            $user->save();
            /* Communicate email has been modified successfully */
        }

        else {
            /* Communicate error */
        }

        return redirect('/account');
    }
}
