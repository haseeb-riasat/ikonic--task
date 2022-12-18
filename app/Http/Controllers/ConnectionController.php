<?php

namespace App\Http\Controllers;

use App\Models\FriendUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getSuggestions(Request $request)
    {
        $suggestedFriends = User::where('id', '!=', Auth::user()->id);
        if (Auth::user()->suggestedFriends->count()) {
            $suggestedFriends->whereNotIn('id', Auth::user()->suggestedFriends->modelKeys());
        }
        $notFriends = $suggestedFriends->offset($request->offset)->take($request->limit)->get();
        $content = view('components.suggestion', ['suggestedFriendsList' => $notFriends])->render();
        return response()->json(['content' => $content]);
    }

    public function sendRequest(Request $request)
    {
        FriendUser::create([
            'user_id'=>$request->user_id,
            'friend_id'=>$request->suggestion_id
        ]);
        //rendering component 
        $suggestedFriends = User::where('id', '!=', Auth::user()->id);
        if (Auth::user()->suggestedFriends->count()) {
            $suggestedFriends->whereNotIn('id', Auth::user()->suggestedFriends->modelKeys());
        }
        $notFriends = $suggestedFriends->offset(0)->take(10)->get();
        $content = view('components.suggestion', ['suggestedFriendsList' => $notFriends])->render();
        return response()->json(['content' => $content]);
    }

    public function getSentRequests(Request $request)
    {
        $sentRequests = FriendUser::with('user')->where('user_id', Auth::id())->where('friend_id', '!=', Auth::id())->whereStatus('0')->offset($request->offset)->take($request->limit)->get();
        $content = view('components.request', ['friendRequests' => $sentRequests, 'mode' => 'sent'])->render();
        return response()->json(['content' => $content]);
    }
    public function withdrawRequest(Request $request)
    {
        $user = User::find($request->request_id);
        Auth::user()->removeFriend($user, 'remove_request');
        //rendering component again
        $sentRequests = FriendUser::with('user')->where('user_id', Auth::id())->where('friend_id', '!=', Auth::id())->whereStatus('0')->offset(0)->take(10)->get();
        $content = view('components.request', ['friendRequests' => $sentRequests, 'mode' => 'sent'])->render();
        return response()->json(['content' => $content]);
    }

    public function getReceivedRequests(Request $request)
    {
        $receivedRequest = FriendUser::with('user')->where('friend_id', Auth::id())->where('user_id', '!=', Auth::id())->whereStatus('0')->offset($request->offset)->take($request->limit)->get();
        $content = view('components.request', ['friendRequests' => $receivedRequest, 'mode' => 'receive'])->render();
        return response()->json(['content' => $content]);
    }
    public function acceptRequest(Request $request)
    {
        FriendUser::where('friend_id', $request->user_id)->where('user_id', $request->request_id)->update([
            'status' => '1'
        ]);
        $receivedRequest = FriendUser::with('user')->where('friend_id', Auth::id())->where('user_id', '!=', Auth::id())->whereStatus('0')->offset(0)->take(10)->get();
        $content = view('components.request', ['friendRequests' => $receivedRequest, 'mode' => 'receive'])->render();
        return response()->json(['content' => $content]);
    }

    public function getFriends(Request $request)
    {
        $friends = FriendUser::with('user', 'friend')->where(function ($query) {
            $query->where('user_id', auth()->id())->orWhere('friend_id',auth()->id());
        })->where('status', '1')->offset($request->offset)->take($request->limit)->get();
        $content = view('components.connection', ['friends' => $friends])->render();
        return response()->json(['content' => $content]);
    }
    public function getCommonFriends()
    {
    }
    public function removeFriend(Request $request)
    {
        FriendUser::whereUserId(auth()->id())->whereFriendId($request->connection_id)->delete();
        //rendering component
        $friends = FriendUser::with('user', 'friend')->where(function ($query) {
            $query->where('user_id', auth()->id());
        })->where('status', '1')->offset(0)->take(10)->get();
        $content = view('components.connection', ['friends' => $friends])->render();
        return response()->json(['content' => $content]);
    }
}
