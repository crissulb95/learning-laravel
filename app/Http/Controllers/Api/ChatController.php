<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Message;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        
        $response = array(
            'status' => 'success'
        );

        $response['messages'] = $messages = Message::with('user')->get();

        try {
            return response()->json($response,200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Is not possible to send request',
                'error' => $th
            ]);
        }
    }
}
