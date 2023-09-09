<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Auth;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function getActiveMessages() {
        Auth::user();

        $messages = Message::with('user')->where('status', 'active')->get();
        return response()->json(['message' => $messages]);
    }
}
