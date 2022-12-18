<?php

namespace App\Http\Controllers;

use App\Models\FriendUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // below is getting suggested friends
        $suggestedFriends = User::where('id', '!=', Auth::user()->id);
        if (Auth::user()->suggestedFriends->count()) {
            $suggestedFriends->whereNotIn('id', Auth::user()->suggestedFriends->modelKeys());
        }
        $suggestedFriends = $suggestedFriends->count();
        //below is getting friends count
        $friends = FriendUser::with('user', 'friend')->where(function ($query) {
            $query->where('user_id', auth()->id())->orWhere('friend_id',auth()->id());
        })->where('status', '1')->count();

        //below is to get auth user request to other users
        $sentRequests = FriendUser::with('user')->where('user_id', Auth::id())->where('friend_id', '!=', Auth::id())->whereStatus('0')->count();

        //below is to get auth user requests which other users sent
        $receivedRequest = FriendUser::with('user')->where('friend_id', Auth::id())->where('user_id', '!=', Auth::id())->whereStatus('0')->count();

        return view('home')->with(['suggestions' => $suggestedFriends, 'friends' => $friends, 'sentRequests' => $sentRequests, 'receivedRequests' => $receivedRequest]);
    }
}
