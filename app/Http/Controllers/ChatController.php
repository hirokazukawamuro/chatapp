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
            'message' => $request->input('message'),
            'link_id' => $request->input('link_id'),
        ]);
        event(new ChatEvent($request->message, $user));
    }

    public function fetchMessages(Request $request)
    {
        $messages = Message::where('link_id', $request->link_id)->get();
        return response()->json($messages);
    }

    public function user(Request $request)
    {
        $users = User::all();
        $currentUserId = auth()->check() ? auth()->user()->id : null;
        return response()->json(['users' => $users, 'currentUserId' => $currentUserId]);
    }
}
