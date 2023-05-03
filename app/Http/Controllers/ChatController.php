<?php

namespace App\Http\Controllers;
use App\Events\ChatEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ChatController extends Controller
{
    // public function chat(){
    //  return view('chat');
    // }
    public function send(Request $request){
      $user=User::find(Auth::id());
      event(new ChatEvent($request->message,$user));
     }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    // public function sendMessage(Request $request)
    // {
    //     $user = Auth::user();
    //     $message = $user->messages()->create([
    //         'message' => $request->input('message')
    //     ]);
    //     broadcast(new MessageSent($user, $message))->toOthers();
    //     return ['status' => 'Message Sent!'];
    // }

}
