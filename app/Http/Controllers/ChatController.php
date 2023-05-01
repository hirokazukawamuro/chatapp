<?php

namespace App\Http\Controllers;
use App\Events\ChatEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ChatController extends Controller
{
  public function send(){
    $message = 'Hello';
    $user=User::find(Auth::id());
    event(new ChatEvent($message,$user));
}    
  // public function __construct()
  //   {
  //       $this->middleware('auth');
  //   }

  //   public function index()
  //   {
  //       return view('chat');
  //   }

  //   public function fetchMessages()
  //   {
  //       return Message::with('user')->get();
  //   }

  //   public function sendMessage(Request $request)
  //   {
  //       $user = Auth::user();
  //       $message = $user->messages()->create([
  //           'message' => $request->input('message')
  //       ]);
  //       return ['status' => 'Message Sent!'];
  //   }

}
