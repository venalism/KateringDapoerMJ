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
        $knowledgeBase = "Informasi FAKTA BISNIS Dapoer MJ:
        - Nama Resmi: Dapoer MJ Catering, bergerak di bidang katering sehat dan harian.
        - Produk Unggulan: Paket Katering Sehat Harian, Nasi Box Acara, Tumpeng Mini.
        - Harga Paket Harian: Mulai dari Rp 25.000 hingga Rp 50.000 per box.
        - Area Layanan: Hanya melayani pengiriman area Jakarta Selatan, Depok, dan Tangerang Selatan.
        - Waktu Pengiriman: Pengiriman harian dilakukan antara jam 11.00 - 13.00 WIB.
        - Cara Pemesanan: Pemesanan WAJIB melalui WhatsApp resmi di 0812-3456-7890 atau link di bio.
        - Aturan Khusus: Dilarang mengarang harga, area layanan, atau kontak WA. Selalu arahkan user ke kontak WA untuk transaksi atau melihat menu lengkap.
        ";
        $userMessage = $request->message;

        $response = Http::withToken(env('GROQ_API_KEY'))->post('https://api.groq.com/openai/v1/chat/completions', [
            // MENGEMBALIKAN MODEL KE LLAMA3-70B-8192
            'model' => 'llama-3.1-8b-instant', 
           'messages' => [
    [
        'role' => 'system',
        'content' => $knowledgeBase . "\n\n" . 
                     'Kamu adalah chatbot ramah untuk website catering bernama Dapoer MJ. Jawab dengan bahasa santai, ramah, pendek tapi jelas. **HARUS** berpegangan pada FAKTA yang disediakan di atas. Jika user tanya menu, bisa rekomendasikan menu sehat & hemat. Jangan terlalu panjang.'
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