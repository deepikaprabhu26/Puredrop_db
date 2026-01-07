// Auto Refresh Dashboard every 5 seconds
function refreshData() {
    if(document.getElementById('admin-dashboard') || document.getElementById('public-dashboard')){
        location.reload();
    }
}
setInterval(refreshData, 5000);

// Chatbot UI Toggle
function toggleChat() {
    let chat = document.getElementById('chatbot-box');
    chat.style.display = (chat.style.display === 'none') ? 'block' : 'none';
}

// Send Message to PHP
async function sendMessage() {
    let input = document.getElementById('chat-input').value;
    let res = await fetch('chatbot-handler.php', {
        method: 'POST',
        body: new URLSearchParams({'msg': input})
    });
    let text = await res.text();
    document.getElementById('chat-logs').innerHTML += `<p>User: ${input}</p><p>AI: ${text}</p>`;
}
