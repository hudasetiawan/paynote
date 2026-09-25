<?php

namespace App\Http\Controllers;

use App\Models\Chatbot;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function bot(Request $request)
    {
        // Cari jawaban berdasarkan pertanyaan yang cocok atau mendekati
        $reply = Chatbot::where('queries', 'LIKE', '%' . $request->text . '%')->first();

        if ($reply) {
            return response()->json([
                'status' => 'success',
                'message' => $reply->replies
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf, saya tidak mengerti pertanyaan Anda. Coba tanyakan dengan kalimat lain.'
            ]);
        }
    }
}
