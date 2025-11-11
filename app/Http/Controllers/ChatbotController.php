<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// Tambahkan untuk logging
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $userMessage = $request->message;

        $response = Http::withToken(env('GROQ_API_KEY'))->post('https://api.groq.com/openai/v1/chat/completions', [
            // MENGEMBALIKAN MODEL KE LLAMA3-70B-8192
            'model' => 'llama-3.1-8b-instant', 
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Kamu adalah chatbot ramah untuk website catering bernama Dapoer MJ. Jawab dengan bahasa santai, ramah, pendek tapi jelas. Jika user tanya menu, bisa rekomendasikan menu sehat & hemat. Jangan terlalu panjang.'
                ],
                [
                    'role' => 'user',
                    'content' => $userMessage
                ]
            ]
        ]);
        
        // Cek apakah request sukses secara HTTP (status 200)
        if (!$response->successful()) {
            // Log error jika status HTTP bukan 200
            Log::error('GROQ API HTTP Error', [
                'status' => $response->status(), 
                'response_body' => $response->body()
            ]);
            
            $reply = "Maaf, terjadi kesalahan koneksi server. Coba lagi ya.";
            
        } else {
            // Cek jika balasan content tidak ada, maka lakukan logging
            $reply = $response->json()['choices'][0]['message']['content'] ?? null;

            if ($reply === null) {
                Log::warning('GROQ API Content Missing', [
                    'request_message' => $userMessage,
                    'full_response' => $response->json() // Log respons lengkap
                ]);
                $reply = "Maaf, sistem lagi sibuk nih. Coba lagi ya.";
            }
        }


        return response()->json([
            'reply' => nl2br($reply)
        ]);
    }
}