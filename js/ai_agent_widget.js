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
                            <h4>AIDA</h4>
                            <div class="status-row">
                                <span class="status-text">Online • AI Assistant</span>
                                <span id="ai-model-badge" class="model-badge">Initializing...</span>
                            </div>
                        </div>
                    </div>
                    <div class="header-actions">
                        <button id="ai-voice-settings-toggle" class="header-btn" title="Voice Settings">
                            <span id="settings-icon">⚙️</span>
                        </button>
                        <button id="ai-voice-toggle" class="header-btn" title="Toggle Voice Response">
                            <span id="voice-icon">🔇</span>
                        </button>
                        <button id="ai-close-btn" class="close-btn">&times;</button>
                    </div>
                </div>

                <!-- Voice Settings Panel -->
                <div id="ai-voice-settings-panel" class="ai-settings-panel hidden">
                    <div class="settings-title">การตั้งค่าเสียงอ่าน</div>
                    <div class="settings-group">
                        <div class="settings-label">
                            <span>โทนเสียง (Pitch)</span>
                            <span id="ai-pitch-val">1.0</span>
                        </div>
                        <input type="range" id="ai-pitch-range" min="0.5" max="2" step="0.1" value="1">
                    </div>
                    <div class="settings-group">
                        <div class="settings-label">
                            <span>ความเร็ว (Speed)</span>
                            <span id="ai-rate-val">0.9</span>
                        </div>
                        <input type="range" id="ai-rate-range" min="0.5" max="2" step="0.1" value="0.9">
                    </div>
                    <div class="settings-group">
                        <div class="settings-label">เลือกเสียง (Voice)</div>
                        <select id="ai-voice-select" class="ai-select"></select>
                    </div>
                </div>
                
                <div class="ai-chat-messages" id="ai-chat-messages">
                        <div class="message ai-message">
                            สวัสดีจ๊ะ! 👋 ผมคือ AIDA ผู้ช่วยอัจฉริยะจาก มรภ.รำไพพรรณี<br>มีอะไรให้คนจันท์ช่วยหาข้อมูลไหมฮิ?
                            <br>
                            <button id="ai-initial-read-btn" class="re-read-btn">📢 <span style="font-size: 10px;">ฟังซ้ำ</span></button>
                        </div>
                </div>

                <div class="ai-chat-input">
                    <div class="input-wrapper">
                        <input type="text" id="ai-input-field" placeholder="พิมพ์คำถาม... (เช่น 'IoT คืออะไร')">
                        <button id="ai-mic-btn" class="mic-btn" title="Voice Input">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                        </button>
                    </div>
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
                font-size: 11px;
                color: #94a3b8;
                opacity: 0.9;
            }

            .status-row {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .model-badge {
                font-size: 9px;
                background: rgba(56, 189, 248, 0.2);
                color: #38bdf8;
                padding: 1px 6px;
                border-radius: 10px;
                text-transform: uppercase;
                font-weight: 700;
                letter-spacing: 0.5px;
                border: 1px solid rgba(56, 189, 248, 0.3);
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
                padding: 10px 40px 10px 15px; /* Increased right padding for mic */
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

            .header-actions {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .header-btn {
                background: none;
                border: none;
                color: white;
                font-size: 18px;
                cursor: pointer;
                opacity: 0.7;
                transition: opacity 0.2s;
            }
            .header-btn:hover { opacity: 1; }

            .input-wrapper {
                flex: 1;
                position: relative;
                display: flex;
                align-items: center;
            }

            .mic-btn {
                position: absolute;
                right: 12px;
                background: none;
                border: none;
                color: #64748b; /* Sharper gray */
                cursor: pointer;
                padding: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                border-radius: 50%;
            }
            .mic-btn:hover { 
                color: #38bdf8; 
                background: rgba(56, 189, 248, 0.1);
                transform: scale(1.1);
            }
            .mic-btn.listening { 
                color: #f43f5e; 
                background: rgba(244, 63, 94, 0.1);
                animation: pulse-glow 1.5s infinite; 
            }

            @keyframes pulse-glow {
                0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); }
                70% { transform: scale(1.2); box-shadow: 0 0 0 10px rgba(244, 63, 94, 0); }
                100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); }
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

            /* Voice Settings Panel Styles */
            .ai-settings-panel {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid #e2e8f0;
                padding: 15px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                z-index: 10;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }

            .ai-settings-panel.hidden {
                display: none;
            }

            .settings-title {
                font-size: 13px;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 5px;
                border-left: 3px solid #f97316;
                padding-left: 8px;
            }

            .settings-group {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .settings-label {
                display: flex;
                justify-content: space-between;
                font-size: 11px;
                font-weight: 600;
                color: #64748b;
            }

            .settings-label span:last-child {
                color: #f97316;
            }

            .ai-settings-panel input[type="range"] {
                -webkit-appearance: none;
                height: 4px;
                background: #e2e8f0;
                border-radius: 5px;
            }

            .ai-settings-panel input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                width: 14px;
                height: 14px;
                background: #f97316;
                border-radius: 50%;
                cursor: pointer;
                border: 2px solid white;
            }

            .ai-select {
                width: 100%;
                padding: 6px;
                font-size: 11px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                outline: none;
            }

            .ai-select:focus {
                border-color: #f97316;
            }

            .re-read-btn {
                background: none;
                border: none;
                color: #f97316;
                cursor: pointer;
                padding: 4px;
                font-size: 14px;
                opacity: 0.6;
                transition: opacity 0.2s, transform 0.2s;
                margin-top: 4px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .re-read-btn:hover {
                opacity: 1;
                transform: scale(1.1);
            }
        </style>
    `;

    document.body.insertAdjacentHTML('beforeend', widgetHTML);

    // 2. Select Elements
    const messagesContainer = document.getElementById('ai-chat-messages');
    const inputField = document.getElementById('ai-input-field');
    const toggleBtn = document.getElementById('ai-toggle-btn');
    const closeBtn = document.getElementById('ai-close-btn');
    const chatWindow = document.getElementById('ai-chat-window');
    const sendBtn = document.getElementById('ai-send-btn');
    const micBtn = document.getElementById('ai-mic-btn');
    const voiceToggle = document.getElementById('ai-voice-toggle');
    const voiceIcon = document.getElementById('voice-icon');
    const settingsToggle = document.getElementById('ai-voice-settings-toggle');
    const settingsPanel = document.getElementById('ai-voice-settings-panel');
    const initialReadBtn = document.getElementById('ai-initial-read-btn');

    if (initialReadBtn) {
        initialReadBtn.addEventListener('click', () => {
            isVoiceEnabled = true;
            voiceIcon.textContent = '🔊';
            speak("สวัสดีจ๊ะ! ผมคือ AIDA ผู้ช่วยอัจฉริยะจาก มรภ.รำไพพรรณี มีอะไรให้คนจันท์ช่วยหาข้อมูลไหมฮิ?");
        });
    }

    // Settings logic
    let currentPitch = 1.08;
    let currentRate = 0.92;
    let currentSelectedVoice = null;

    settingsToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        settingsPanel.classList.toggle('hidden');
        settingsToggle.classList.toggle('active');
    });

    const pitchRange = document.getElementById('ai-pitch-range');
    const rateRange = document.getElementById('ai-rate-range');
    const pitchVal = document.getElementById('ai-pitch-val');
    const rateVal = document.getElementById('ai-rate-val');
    const voiceSelect = document.getElementById('ai-voice-select');

    pitchRange.addEventListener('input', (e) => {
        currentPitch = e.target.value;
        pitchVal.textContent = parseFloat(currentPitch).toFixed(1);
    });

    rateRange.addEventListener('input', (e) => {
        currentRate = e.target.value;
        rateVal.textContent = parseFloat(currentRate).toFixed(1);
    });

    voiceSelect.addEventListener('change', (e) => {
        currentSelectedVoice = systemVoices.find(v => v.name === e.target.value);
    });

    // Toggle Chat Window
    toggleBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            inputField.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
    });

    let isVoiceEnabled = false;
    let isListening = false;

    // 4. Voice Interaction Logic (TTS - Text to Speech)
    let systemVoices = [];
    function loadVoices() {
        systemVoices = window.speechSynthesis.getVoices();
        if (voiceSelect && systemVoices.length > 0) {
            voiceSelect.innerHTML = '';
            const thaiVoices = systemVoices.filter(v => v.lang.includes('th') || v.lang.includes('TH'));
            const otherVoices = systemVoices.filter(v => !v.lang.includes('th') && !v.lang.includes('TH'));
            
            [...thaiVoices, ...otherVoices].forEach(voice => {
                const option = document.createElement('option');
                option.textContent = `${voice.name} (${voice.lang})`;
                option.value = voice.name;
                if (!currentSelectedVoice && (voice.lang.includes('th') || voice.lang.includes('TH'))) {
                    option.selected = true;
                    currentSelectedVoice = voice;
                }
                voiceSelect.appendChild(option);
            });
        }
    }
    
    // Voices are loaded asynchronously in many browsers
    if (window.speechSynthesis.onvoiceschanged !== undefined) {
        window.speechSynthesis.onvoiceschanged = loadVoices;
    }
    loadVoices();

    function speak(text) {
        if (!isVoiceEnabled || !window.speechSynthesis) return;
        
        // Stop current speech
        window.speechSynthesis.cancel();

        // 1. Clean text
        let cleanText = text.replace(/AIDA/gi, 'ไอด้า') // Pronunciation fix
                           .replace(/\*\*|\[.*?\]|หัวข้อ:|เนื้อหา:/g, '');
        
        // 2. Add natural rhythmic pauses
        cleanText = cleanText.replace(/จ๊ะ/g, '...จ๊ะ');
        cleanText = cleanText.replace(/ฮิ/g, '...ฮิ');
        cleanText = cleanText.replace(/คุณ/g, '...คุณ');

        const utterance = new SpeechSynthesisUtterance(cleanText);
        utterance.lang = 'th-TH';
        utterance.rate = parseFloat(currentRate);
        utterance.pitch = parseFloat(currentPitch);

        if (currentSelectedVoice) {
            utterance.voice = currentSelectedVoice;
            console.log('AIDA Speaking with:', currentSelectedVoice.name);
        } else {
            const thaiVoices = systemVoices.filter(v => v.lang.includes('th') || v.lang.includes('TH'));
            if (thaiVoices.length > 0) {
                let fallbackVoice = thaiVoices.find(v => v.name.includes('Enhanced') || v.name.includes('Premium')) ||
                                    thaiVoices.find(v => v.name.includes('Narisa')) ||
                                    thaiVoices[0];
                utterance.voice = fallbackVoice;
            }
        }

        utterance.rate = parseFloat(currentRate);
        utterance.pitch = parseFloat(currentPitch);

        window.speechSynthesis.speak(utterance);
    }

    // 5. Voice Command Logic (STT - Speech to Text)
    let recognition;
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        recognition.lang = 'th-TH';
        recognition.continuous = false;
        recognition.interimResults = false;

        recognition.onstart = () => {
            isListening = true;
            micBtn.classList.add('listening');
            inputField.placeholder = "กำลังฟังคนจันท์อยู่นะจ๊ะ...";
        };

        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            inputField.value = transcript;
            sendMessage();
        };

        recognition.onend = () => {
            isListening = false;
            micBtn.classList.remove('listening');
            inputField.placeholder = "พิมพ์คำถาม... (เช่น 'IoT คืออะไร')";
        };

        recognition.onerror = (event) => {
            console.error('Speech recognition error', event);
            isListening = false;
            micBtn.classList.remove('listening');
        };
    }

    // Event Listeners
    voiceToggle.addEventListener('click', () => {
        isVoiceEnabled = !isVoiceEnabled;
        voiceIcon.textContent = isVoiceEnabled ? '🔊' : '🔇';
        if (!isVoiceEnabled) window.speechSynthesis.cancel();
    });

    micBtn.addEventListener('click', () => {
        if (!recognition) {
            alert("Browser ของคุณไม่รองรับการสั่งการด้วยเสียงจ๊ะ ฮิ");
            return;
        }
        if (isListening) {
            recognition.stop();
        } else {
            recognition.start();
        }
    });

    // 6. Send Message Logic
    async function sendMessage() {
        const text = inputField.value.trim();
        if (!text) return;

        appendMessage(text, 'user');
        inputField.value = '';

        const typingId = 'typing-' + Date.now();
        appendTyping(typingId);

        try {
            const response = await fetch('api/chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });
            const data = await response.json();
            
            if (data.model) {
                document.getElementById('ai-model-badge').textContent = data.model;
            }
            
            removeTyping(typingId);
            appendMessage(data.reply, 'ai');
            speak(data.reply);

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
        
        if (type === 'ai') {
            const readBtn = document.createElement('button');
            readBtn.className = 're-read-btn';
            readBtn.innerHTML = '📢 <span style="font-size: 10px;">ฟังซ้ำ</span>';
            readBtn.title = 'ฟังเสียงอ่านนี้อีกรอบ';
            readBtn.onclick = () => {
                isVoiceEnabled = true; // Ensure voice is enabled for re-read
                voiceIcon.textContent = '🔊';
                speak(text);
            };
            div.appendChild(readBtn);
        }
        
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
