<style>
/* --- STYLING UTAMA --- */
/* Tombol Chat Floating */
#chatbot-btn {
    position: fixed;
    bottom: 25px; /* Pindah ke bawah agar tidak terlalu tinggi */
    right: 25px;
    background: #4E1F00; /* Coklat Tua Dapoer MJ */
    border-radius: 50%;
    width: 60px; 
    height: 60px; 
    border: none;
    color: white;
    font-size: 26px;
    cursor: pointer;
    box-shadow: 0px 4px 8px rgba(0,0,0,.3);
    transition: .3s;
    z-index: 999;
}
#chatbot-btn:hover { background: #FEBA17; color: #4E1F00; } /* Warna Kuning saat hover */

/* Kotak Chat Utama */
#chatbot-box {
    position: fixed;
    bottom: 95px; /* Di atas tombol chat */
    right: 25px;
    width: 320px;
    height: 420px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,.2);
    display: none; /* Default tersembunyi */
    flex-direction: column;
    overflow: hidden;
    z-index: 999;
    font-family: 'Arial', sans-serif;
}

/* Header (JUDUL & TOMBOL CLOSE) */
#chatbot-header {
    background: #4E1F00; /* Coklat Tua */
    color: white;
    padding: 10px 12px;
    font-weight: bold;
    display: flex; 
    justify-content: space-between;
    align-items: center;
}

#chatbot-title {
    flex-grow: 1;
    text-align: center;
    margin-right: 20px; 
}

/* Tombol Close Baru */
#close-chat-btn {
    background: transparent;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    transition: opacity .2s;
}

#close-chat-btn:hover {
    opacity: 0.7;
}

/* Area Pesan */
#chatbot-messages {
    flex: 1;
    padding: 15px 10px;
    overflow-y: auto;
    font-size: 14px;
    background-color: #F8F4E1; /* Warna latar belakang chat */
}

/* Gaya Balon Pesan */
.message {
    margin: 8px 0;
    padding: 10px 14px;
    border-radius: 18px;
    max-width: 80%;
    line-height: 1.4;
    word-wrap: break-word;
    box-shadow: 0 1px 1px rgba(0,0,0,0.05);
}

.user-message { 
    background: #FEBA17; /* Kuning Dapoer MJ */
    color: #4E1F00; 
    margin-left: auto; /* Pindah ke kanan */
    border-bottom-right-radius: 4px; /* Sudut lebih tajam di pojok bawah-kanan */
}

.bot-message { 
    background: white; 
    color: #4E1F00; 
    border: 1px solid #ddd;
    border-bottom-left-radius: 4px; /* Sudut lebih tajam di pojok bawah-kiri */
}

/* Area Input */
#chatbot-input-area {
    padding: 10px;
    border-top: 1px solid #ddd;
    display: flex;
    gap: 8px;
    background: white;
}

#chatbot-input {
    flex: 1;
    border-radius: 20px; /* Lebih membulat */
    border: 1px solid #ccc;
    padding: 8px 15px;
    font-size: 14px;
    outline: none;
}

#send-chat {
    background: #FEBA17; 
    color: #4E1F00; 
    border: none; 
    border-radius: 20px; 
    padding: 8px 15px; 
    font-weight: bold; 
    cursor:pointer;
    transition: background .2s;
}
#send-chat:hover { background: #f3a60a; }

/* Menangani Baris Baru dari nl2br di PHP */
.bot-message br {
    display: block; /* Memastikan <br> berfungsi */
    content: " ";
    margin-top: 5px; /* Sedikit spasi antar baris */
}
</style>

<button id="chatbot-btn">💬</button>

<div id="chatbot-box">
    <div id="chatbot-header">
        <div id="chatbot-title">Chat Dapoer MJ</div>
        <button id="close-chat-btn">&times;</button> 
    </div>
    <div id="chatbot-messages">
        <div class="message bot-message">Halo Kak! Ada yang bisa Dapoer MJ bantu? Mau cek menu, cari paket hemat, atau tanya cara pesan? 😉</div>
    </div>
    <div id="chatbot-input-area">
        <input type="text" id="chatbot-input" placeholder="Tanya sesuatu..." autocomplete="off">
        <button id="send-chat">Send</button>
    </div>
</div>

<script>
// Route untuk API dan Token (Dipastikan Blade memproses ini)
const chatRoute = "{{ route('chatbot.respond') }}";
const csrfToken = "{{ csrf_token() }}";
const chatbotBox = document.getElementById("chatbot-box");


// --- Fungsi Pembuka/Penutup Chat ---
document.getElementById("chatbot-btn").onclick = () => {
    chatbotBox.style.display = chatbotBox.style.display === "flex" ? "none" : "flex";
    if (chatbotBox.style.display === "flex") {
        const messages = document.getElementById("chatbot-messages");
        messages.scrollTop = messages.scrollHeight; // Scroll ke bawah saat dibuka
        document.getElementById("chatbot-input").focus(); // Fokus ke input
    }
};

document.getElementById("close-chat-btn").onclick = () => {
    chatbotBox.style.display = "none";
};


// --- Fungsi Kirim Pesan ---
function sendMessage() {
    const input = document.getElementById("chatbot-input");
    const message = input.value.trim();
    if (!message) return;

    const messages = document.getElementById("chatbot-messages");

    // 1. Tampilkan pesan user
    messages.innerHTML += `<div class="message user-message">${message}</div>`;
    messages.scrollTop = messages.scrollHeight; 
    input.value = "";
    
    // 2. Tampilkan indikator loading
    const loadingId = 'loading-' + Date.now();
    messages.innerHTML += `<div id="${loadingId}" class="message bot-message">Typing...</div>`;
    messages.scrollTop = messages.scrollHeight;

    // 3. Panggil API
    fetch(chatRoute, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken 
        },
        body: JSON.stringify({ message })
    })
    .then(res => {
        if (!res.ok) {
            // Ini akan menangani 4xx/5xx dari Laravel (seperti CSRF error)
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        // Hapus pesan loading
        const loadingElement = document.getElementById(loadingId);
        if (loadingElement) loadingElement.remove();

        // Tampilkan balasan
        messages.innerHTML += `<div class="message bot-message">${data.reply}</div>`;
        messages.scrollTop = messages.scrollHeight;
    })
    .catch(error => {
        console.error("Error fetching chatbot response:", error);
        
        // Hapus pesan loading
        const loadingElement = document.getElementById(loadingId);
        if (loadingElement) loadingElement.remove();
        
        // Tampilkan pesan error ke user
        messages.innerHTML += `<div class="message bot-message">Maaf, terjadi masalah koneksi ke server. Coba periksa koneksi Anda atau coba lagi nanti.</div>`;
        messages.scrollTop = messages.scrollHeight;
    });
}

// Event Listeners
document.getElementById("send-chat").onclick = sendMessage;
document.getElementById("chatbot-input").addEventListener("keypress", function(e){
    if(e.key === "Enter") {
        e.preventDefault(); // Mencegah Enter default form submission
        sendMessage();
    }
});
</script>