// js/ai_agent.js
document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.getElementById('chatForm');
    const userInput = document.getElementById('userInput');
    const chatMessages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');

    if (chatForm) {
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = userInput.value.trim();
            if (message) {
                // User Message
                addMessage(message, 'user');
                userInput.value = '';

                // Show Typing Indicator
                showTyping();

                try {
                    // Call API Endpoint (RAG System)
                    const response = await fetch('api/chat.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ message: message })
                    });

                    const data = await response.json();

                    hideTyping();
                    addMessage(data.reply, 'ai');

                } catch (error) {
                    hideTyping();
                    console.error('Error:', error);
                    addMessage('ขออภัยครับ ระบบขัดข้องชั่วคราว โปรดลองใหม่ภายหลัง', 'ai');
                }
            }
        });
    }

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', sender);
        messageDiv.innerHTML = text; // Enable HTML rendering for links/formatting

        // Insert before typing indicator if it exists inside the container
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
});
