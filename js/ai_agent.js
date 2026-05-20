// js/ai_agent.js — AIDA Voice Intelligence v2
// Features: Chat, Voice (STT/TTS), Image Upload, Model Badge
document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.getElementById('chatForm');
    const userInput = document.getElementById('userInput');
    const chatMessages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');
    const voiceBtn = document.getElementById('voiceBtn');
    const imageBtn = document.getElementById('imageBtn');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImageBtn = document.getElementById('removeImageBtn');

    // Speech Settings Elements
    const voiceSettingsBtn = document.getElementById('voiceSettingsBtn');
    const voiceSettingsOverlay = document.getElementById('voiceSettingsOverlay');
    const pitchRangeInput = document.getElementById('pitchRangeInput');
    const rateRangeInput = document.getElementById('rateRangeInput');
    const pitchValLabel = document.getElementById('pitchValLabel');
    const rateValLabel = document.getElementById('rateValLabel');
    const voiceSelectInput = document.getElementById('voiceSelectInput');

    let currentPitch = 1.08; // Slightly higher for friendly feel
    let currentRate = 0.92; // Slightly slower for clear Thai
    let currentSelectedVoice = null;
    let systemVoices = [];

    if (voiceSettingsBtn) {
        voiceSettingsBtn.addEventListener('click', () => {
            voiceSettingsOverlay.classList.toggle('hidden');
        });
    }

    if (pitchRangeInput) {
        pitchRangeInput.addEventListener('input', (e) => {
            currentPitch = e.target.value;
            pitchValLabel.textContent = parseFloat(currentPitch).toFixed(1);
        });
    }

    if (rateRangeInput) {
        rateRangeInput.addEventListener('input', (e) => {
            currentRate = e.target.value;
            rateValLabel.textContent = parseFloat(currentRate).toFixed(1);
        });
    }

    if (voiceSelectInput) {
        voiceSelectInput.addEventListener('change', (e) => {
            currentSelectedVoice = systemVoices.find(v => v.name === e.target.value);
        });
    }

    let pendingImageBase64 = null;
    let isRecording = false;
    let recognition = null;

    // ============================================================
    // 1. Chat Form Submission
    // ============================================================
    if (chatForm) {
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = userInput.value.trim();
            const hasImage = !!pendingImageBase64;

            if (!message && !hasImage) return;

            // Show user message
            if (message) addMessage(message, 'user');
            if (hasImage) {
                addImageMessage(pendingImageBase64);
            }
            userInput.value = '';

            // Show typing
            showTyping();

            try {
                const payload = { message: message };
                if (hasImage) {
                    payload.image = pendingImageBase64;
                }

                const response = await fetch('api/chat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();
                hideTyping();

                // Format response with markdown-lite
                const formattedReply = formatMarkdown(data.reply);
                addMessage(formattedReply, 'ai', data.model);

                // TTS: Speak the response
                speakThai(data.reply);

            } catch (error) {
                hideTyping();
                console.error('AIDA Error:', error);
                addMessage('ขออภัยครับ ระบบขัดข้องชั่วคราว โปรดลองใหม่ภายหลัง', 'ai', '❌ Error');
            }

            // Clear image preview
            clearImagePreview();
        });
    }

    // ============================================================
    // 2. Voice Input (STT - Speech to Text)
    // ============================================================
    if (voiceBtn) {
        // Check browser support
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        
        if (SpeechRecognition) {
            recognition = new SpeechRecognition();
            recognition.lang = 'th-TH';
            recognition.continuous = false;
            recognition.interimResults = true;

            recognition.onstart = () => {
                isRecording = true;
                voiceBtn.classList.add('recording');
                voiceBtn.querySelector('.voice-icon').innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                        <rect x="6" y="4" width="4" height="16" rx="2"/>
                        <rect x="14" y="4" width="4" height="16" rx="2"/>
                    </svg>`;
                userInput.placeholder = '🎙️ กำลังฟัง...';
            };

            recognition.onresult = (event) => {
                let transcript = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    transcript += event.results[i][0].transcript;
                }
                userInput.value = transcript;
            };

            recognition.onend = () => {
                isRecording = false;
                voiceBtn.classList.remove('recording');
                voiceBtn.querySelector('.voice-icon').innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                        <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                        <line x1="12" y1="19" x2="12" y2="23"/>
                        <line x1="8" y1="23" x2="16" y2="23"/>
                    </svg>`;
                userInput.placeholder = 'พิมพ์หรือพูดคำถามของคุณที่นี่...';

                // Auto-submit if text was recognized
                if (userInput.value.trim()) {
                    chatForm.dispatchEvent(new Event('submit'));
                }
            };

            recognition.onerror = (event) => {
                console.error('Voice error:', event.error);
                isRecording = false;
                voiceBtn.classList.remove('recording');
                userInput.placeholder = 'พิมพ์หรือพูดคำถามของคุณที่นี่...';
                
                if (event.error === 'not-allowed') {
                    addMessage('⚠️ กรุณาอนุญาตการเข้าถึงไมโครโฟนในเบราว์เซอร์', 'ai', 'System');
                }
            };

            voiceBtn.addEventListener('click', () => {
                if (isRecording) {
                    recognition.stop();
                } else {
                    recognition.start();
                }
            });
        } else {
            voiceBtn.style.display = 'none';
            console.warn('Speech Recognition not supported');
        }
    }

    // ============================================================
    // 3. Image Upload for Vision
    // ============================================================
    if (imageBtn && imageInput) {
        imageBtn.addEventListener('click', () => {
            imageInput.click();
        });

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            // Validate file
            if (!file.type.startsWith('image/')) {
                addMessage('⚠️ กรุณาเลือกไฟล์รูปภาพเท่านั้น', 'ai', 'System');
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                addMessage('⚠️ รูปภาพต้องมีขนาดไม่เกิน 10MB', 'ai', 'System');
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => {
                pendingImageBase64 = ev.target.result;
                showImagePreview(ev.target.result);
            };
            reader.readAsDataURL(file);
            imageInput.value = ''; // Reset
        });
    }

    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', clearImagePreview);
    }

    // ============================================================
    // 4. TTS (Text to Speech) — Thai Voice
    // ============================================================
    function speakThai(text) {
        if (!('speechSynthesis' in window)) return;
        
        // Cancel any ongoing speech
        window.speechSynthesis.cancel();

        // Clean text for speech
        let cleanText = text
            .replace(/AIDA/gi, 'ไอด้า') // Pronunciation fix
            .replace(/[#*_`~\[\]()]/g, '')
            .replace(/https?:\/\/\S+/g, '')
            .replace(/\n+/g, '. ')
            .substring(0, 500); // Limit length

        const utterance = new SpeechSynthesisUtterance(cleanText);
        utterance.lang = 'th-TH';
        utterance.rate = parseFloat(currentRate);
        utterance.pitch = parseFloat(currentPitch);

        if (currentSelectedVoice) {
            utterance.voice = currentSelectedVoice;
        } else {
            const voices = window.speechSynthesis.getVoices();
            // Prioritize English/Enhanced or Google voices if no selection
            const thaiVoice = voices.find(v => v.lang.startsWith('th') && (v.name.includes('Google') || v.name.includes('Enhanced') || v.name.includes('Premium'))) || 
                              voices.find(v => v.lang.startsWith('th')) ||
                              voices[0];
            if (thaiVoice) utterance.voice = thaiVoice;
        }

        window.speechSynthesis.speak(utterance);
    }

    // Load voices
    function loadVoices() {
        if (!('speechSynthesis' in window)) return;
        systemVoices = window.speechSynthesis.getVoices();
        if (voiceSelectInput && systemVoices.length > 0) {
            voiceSelectInput.innerHTML = '';
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
                voiceSelectInput.appendChild(option);
            });
        }
    }

    if ('speechSynthesis' in window) {
        if (window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
        }
        loadVoices();
    }

    // ============================================================
    // 5. UI Helper Functions
    // ============================================================
    function addMessage(text, sender, modelName = '') {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', sender);

        if (sender === 'ai' && modelName) {
            const badge = document.createElement('div');
            badge.className = 'model-badge';
            badge.textContent = modelName;
            messageDiv.appendChild(badge);
        }


        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = text;
        messageDiv.appendChild(contentDiv);

        if (sender === 'ai') {
            const readBtn = document.createElement('button');
            readBtn.className = 're-read-btn';
            readBtn.innerHTML = '📢 ฟังซ้ำ';
            readBtn.onclick = () => speakThai(text);
            messageDiv.appendChild(readBtn);
        }

        insertMessage(messageDiv);
    }

    function addImageMessage(base64Data) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', 'user');
        const img = document.createElement('img');
        img.src = base64Data;
        img.className = 'chat-image';
        img.alt = 'Uploaded image';
        messageDiv.appendChild(img);
        insertMessage(messageDiv);
    }

    function insertMessage(messageDiv) {
        if (typingIndicator && typingIndicator.parentNode === chatMessages) {
            chatMessages.insertBefore(messageDiv, typingIndicator);
        } else {
            chatMessages.appendChild(messageDiv);
        }
        scrollToBottom();
    }

    function showTyping() {
        if (typingIndicator) {
            typingIndicator.style.display = 'flex';
            scrollToBottom();
        }
    }

    function hideTyping() {
        if (typingIndicator) {
            typingIndicator.style.display = 'none';
        }
    }

    function scrollToBottom() {
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    function showImagePreview(src) {
        if (imagePreview && previewImg) {
            previewImg.src = src;
            imagePreview.style.display = 'flex';
        }
    }

    function clearImagePreview() {
        pendingImageBase64 = null;
        if (imagePreview) imagePreview.style.display = 'none';
        if (previewImg) previewImg.src = '';
    }

    // ============================================================
    // 6. Markdown-lite Formatter
    // ============================================================
    function formatMarkdown(text) {
        if (!text) return '';
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`(.*?)`/g, '<code>$1</code>')
            .replace(/^(\d+)\.\s/gm, '<span class="list-num">$1.</span> ')
            .replace(/^[-•]\s(.*)/gm, '<span class="list-bullet">•</span> $1')
            .replace(/\n/g, '<br>');
    }

    // ============================================================
    // 7. Quick Action Buttons
    // ============================================================
    document.querySelectorAll('.quick-action-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const prompt = btn.dataset.prompt;
            if (prompt && userInput) {
                userInput.value = prompt;
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    });
});
