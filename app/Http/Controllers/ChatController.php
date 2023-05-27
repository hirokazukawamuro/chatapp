<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        // Eloquent (DBへの処理記述)
        $user = User::find(Auth::id());
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);
        event(new ChatEvent($request->message, $user));
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function user(Request $request)
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }
    // public function send(Request $request)
    // {
    //     $user = Auth::user();
    //     $message = $user->messages()->create([
    //         'message' => $request->input('message')
    //     ]);
    //     broadcast(new ChatEvent($user, $message));
    //     return ['status' => 'Message Sent!'];
    // }

}
