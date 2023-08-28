<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Auth;
use Illuminate\Http\Request;
use Validator;

class MessageController extends Controller
{
    public function createMessage(Request $request) {
        $user = Auth::user();

        if($user) {
            $validateMessage = Validator::make($request->all(),[
                'email' => ['required', 'email', 'max:40', 'min:6',],         
                'topic' => ['required', 'string', 'max:20',],         
                'message' => ['string', 'max:255']
            ]);

            if ($validateMessage->fails()) {
                return response()->json(['errors' => $validateMessage->errors()], 400);
            }

            $message = $validateMessage->validate();
            $message['user_id'] = $user->id;

            Message::create($message);

            return response()->json(['Message Sent' => $message], 201);
        }
        return response()->json(['error' => 'Login to send a message'],401);
    }

    public function getMessages() {
        $user = Auth::user();
        
        if($user) {
            $message = Message::where('user_id', $user->id)->get();
            return response()->json(['message' => $message]);
        }
        return response()->json(['error' => 'Login to send a message'],401);
    }
}
