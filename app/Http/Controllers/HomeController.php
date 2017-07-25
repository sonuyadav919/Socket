<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Models\PrivateChat;

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
        return view('home');
    }

    public function privateChat()
    {
        $data['users'] = User::where('id', '!=', Auth::id())->get();
        $data['authId'] = Auth::id();

        return view('chats.private', $data);
    }

    public function privateMessages($receverId)
    {
        return PrivateChat::where(['sender_id' => Auth::id(), 'recever_id' => $receverId])
                            ->orWhere(['sender_id' => $receverId, 'recever_id' => Auth::id()])
                            ->with(['sender', 'recever'])
                            ->get();
    }
}
