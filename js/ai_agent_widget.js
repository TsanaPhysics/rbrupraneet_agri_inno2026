// AI Agent Widget
// Injects the floating chat interface into the page

document.addEventListener('DOMContentLoaded', function() {
    // 1. Create and Inject HTML
    const widgetHTML = `
        <div id="ai-widget-container">
            <!-- Floating Button -->
            <button id="ai-toggle-btn" class="ai-float-btn">
                <div class="ai-avatar-small">
                    <img src="assets/images/ai_avatar.png" alt="AI Agent">
                </div>
                <span class="ai-status-dot"></span>
            </button>

            <!-- Chat Window -->
            <div id="ai-chat-window" class="ai-chat-window hidden">
                <div class="ai-chat-header">
                    <div class="header-info">
                        <img src="assets/images/ai_avatar.png" alt="AI Avatar" class="header-avatar">
                        <div>
                            <h4>RBRU-AgriBot</h4>
                            <span class="status-text">Online • AI Assistant</span>
                        </div>
                    </div>
                    <button id="ai-close-btn" class="close-btn">&times;</button>
                </div>
                
                <div class="ai-chat-messages" id="ai-chat-messages">
                    <div class="message ai-message">
                        สวัสดีครับ! 👋 ผมคือ AI ผู้ช่วยด้านนวัตกรรมเกษตร<br>มีอะไรให้ผมช่วยหาข้อมูลไหมครับ?
                    </div>
                </div>

                <div class="ai-chat-input">
                    <input type="text" id="ai-input-field" placeholder="พิมพ์คำถาม... (เช่น 'IoT คืออะไร')">
                    <button id="ai-send-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <style>
            /* Widget Styles */
            #ai-widget-container {
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 9999;
                font-family: 'Inter', 'Noto Sans Thai', sans-serif;
            }

            .ai-float-btn {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
                border: none;
                cursor: pointer;
                box-shadow: 0 4px 15px rgba(56, 189, 248, 0.4);
                transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            .ai-float-btn:hover {
                transform: scale(1.1);
            }

            .ai-avatar-small img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid white;
            }

            .ai-status-dot {
                position: absolute;
                bottom: 2px;
                right: 2px;
                width: 14px;
                height: 14px;
                background-color: #22c55e;
                border: 2px solid white;
                border-radius: 50%;
            }

            /* Chat Window */
            .ai-chat-window {
                position: absolute;
                bottom: 80px;
                right: 0;
                width: 350px;
                height: 500px;
                background: white;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                display: flex;
                flex-direction: column;
                overflow: hidden;
                transform-origin: bottom right;
                transition: all 0.3s ease;
                border: 1px solid #e2e8f0;
            }

            .ai-chat-window.hidden {
                transform: scale(0);
                opacity: 0;
                pointer-events: none;
            }

            .ai-chat-header {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                padding: 15px;
                color: white;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .header-info {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .header-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: 2px solid rgba(56, 189, 248, 0.5);
            }

            .header-info h4 {
                margin: 0;
                font-size: 16px;
                font-weight: 600;
            }

            .status-text {
                font-size: 12px;
                color: #94a3b8;
                opacity: 0.9;
            }

            .close-btn {
                background: none;
                border: none;
                color: white;
                font-size: 24px;
                cursor: pointer;
                opacity: 0.7;
            }
            
            .close-btn:hover { opacity: 1; }

            .ai-chat-messages {
                flex: 1;
                padding: 15px;
                background: #f8fafc;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .message {
                max-width: 80%;
                padding: 10px 14px;
                border-radius: 12px;
                font-size: 14px;
                line-height: 1.5;
            }

            .ai-message {
                background: white;
                color: #334155;
                align-self: flex-start;
                border-bottom-left-radius: 4px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .user-message {
                background: #38bdf8;
                color: white;
                align-self: flex-end;
                border-bottom-right-radius: 4px;
                box-shadow: 0 2px 5px rgba(56, 189, 248, 0.2);
            }

            .ai-chat-input {
                padding: 15px;
                background: white;
                border-top: 1px solid #e2e8f0;
                display: flex;
                gap: 8px;
            }

            #ai-input-field {
                flex: 1;
                padding: 10px 15px;
                border: 1px solid #cbd5e1;
                border-radius: 20px;
                outline: none;
                font-size: 14px;
            }

            #ai-input-field:focus {
                border-color: #38bdf8;
            }

            #ai-send-btn {
                background: #0f172a;
                color: white;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background 0.2s;
            }

            #ai-send-btn:hover {
                background: #38bdf8;
            }
            
            /* Typing Animation */
            .typing-indicator {
                display: inline-flex;
                gap: 4px;
                padding: 8px 12px;
                background: white;
                border-radius: 12px;
                align-self: flex-start;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            .dot {
                width: 6px;
                height: 6px;
                background: #94a3b8;
                border-radius: 50%;
                animation: typing 1.4s infinite ease-in-out both;
            }
            .dot:nth-child(1) { animation-delay: -0.32s; }
            .dot:nth-child(2) { animation-delay: -0.16s; }
            @keyframes typing {
                0%, 80%, 100% { transform: scale(0); }
                40% { transform: scale(1); }
            }
        </style>
    `;

    document.body.insertAdjacentHTML('beforeend', widgetHTML);

    // 2. Select Elements
    const toggleBtn = document.getElementById('ai-toggle-btn');
    const closeBtn = document.getElementById('ai-close-btn');
    const chatWindow = document.getElementById('ai-chat-window');
    const messagesContainer = document.getElementById('ai-chat-messages');
    const inputField = document.getElementById('ai-input-field');
    const sendBtn = document.getElementById('ai-send-btn');

    // 3. Toggle Chat
    toggleBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            inputField.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
    });

    // 4. Send Message Logic
    async function sendMessage() {
        const text = inputField.value.trim();
        if (!text) return;

        // Add User Message
        appendMessage(text, 'user');
        inputField.value = '';

        // Add Typing Indicator
        const typingId = 'typing-' + Date.now();
        appendTyping(typingId);

        try {
            // Call API
            const response = await fetch('api/chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });
            const data = await response.json();
            
            // Remove Typing & Add AI Response
            removeTyping(typingId);
            appendMessage(data.reply, 'ai');

        } catch (error) {
            removeTyping(typingId);
            appendMessage('ขออภัย เกิดข้อผิดพลาดในการเชื่อมต่อ', 'ai');
            console.error('Chat Error:', error);
        }
    }

    // Helper: Append Message
    function appendMessage(text, type) {
        const div = document.createElement('div');
        div.className = `message ${type}-message`;
        div.innerHTML = text; // Allow HTML in response
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Helper: Append Typing
    function appendTyping(id) {
        const div = document.createElement('div');
        div.id = id;
        div.className = 'typing-indicator';
        div.innerHTML = '<div class="dot"></div><div class="dot"></div><div class="dot"></div>';
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Helper: Remove Typing
    function removeTyping(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    // Event Listeners
    sendBtn.addEventListener('click', sendMessage);
    inputField.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
});
