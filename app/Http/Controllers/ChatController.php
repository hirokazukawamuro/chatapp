<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        // Eloquent (DBへの処理記述)
        $user = User::find(Auth::id());
        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'link_id' => $request->input('linkId'),
            'user_id' => $request->input('userId'),
        ]);
        broadcast(new ChatEvent($request->message, $user)); //Pusherに届ける内容
        return response()->json($message);
    }

    public function fetchMessages(Request $request)
    {
        $userId = $request->input('userId');
        $linkId = $request->input('linkId');

        $messages = Message::with('user')
            ->where('user_id', $userId)
            ->where('link_id', $linkId)
            ->orWhere('link_id', $userId)
            ->where('user_id', $linkId)
            ->get();

        $messagesWithUser = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'user' => $message->user ? $message->user->toArray() : null,
                'message' => $message->message,
            ];
        });

        return response()->json(['messages' => $messagesWithUser]);
    }


    public function user(Request $request)
    {
        $users = User::all();
        $currentUserId = auth()->check() ? auth()->user()->id : null;
        return response()->json(['users' => $users, 'currentUserId' => $currentUserId]);
    }
}
