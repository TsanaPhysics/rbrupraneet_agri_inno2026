<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Agent | RBRU-Praneet Digital Agri-Innovation</title>
    <meta name="description"
        content="AI Agent ผู้ช่วยอัจฉริยะสำหรับการเกษตรยุคใหม่">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
        .agent-hero {
            padding-top: 120px;
            padding-bottom: 60px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 70vh;
            display: flex;
            align-items: center;
        }
        
        .agent-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(56, 189, 248, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            z-index: 0;
        }

        .agent-content {
            position: relative;
            z-index: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* AI Avatar CSS */
        .ai-avatar {
            position: relative;
            width: 200px;
            height: 200px;
            margin-bottom: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ai-core {
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #fff 0%, #38bdf8 50%, #0ea5e9 100%);
            border-radius: 50%;
            box-shadow: 0 0 40px rgba(56, 189, 248, 0.6);
            position: relative;
            z-index: 10;
            animation: pulse-core 2s ease-in-out infinite;
        }

        .ai-ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: rgba(56, 189, 248, 0.5);
            border-bottom-color: rgba(139, 92, 246, 0.5);
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.2);
        }

        .ring-1 {
            width: 120px;
            height: 120px;
            animation: spin 4s linear infinite;
        }

        .ring-2 {
            width: 160px;
            height: 160px;
            border-left-color: rgba(56, 189, 248, 0.3);
            border-right-color: rgba(139, 92, 246, 0.3);
            animation: spin-reverse 7s linear infinite;
        }

        .ring-3 {
            width: 200px;
            height: 200px;
            border: 1px dashed rgba(255, 255, 255, 0.2);
            animation: spin 15s linear infinite;
        }

        .ai-particles span {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #fff;
            border-radius: 50%;
            opacity: 0;
            animation: float-particle 3s ease-in-out infinite;
        }

        @keyframes pulse-core {
            0%, 100% { transform: scale(1); box-shadow: 0 0 40px rgba(56, 189, 248, 0.6); }
            50% { transform: scale(1.1); box-shadow: 0 0 60px rgba(56, 189, 248, 0.8); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes spin-reverse {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }

        @keyframes float-particle {
            0% { transform: translate(0, 0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translate(var(--tx), var(--ty)); opacity: 0; }
        }

        /* Chat Interface CSS */
        .chat-container {
            width: 100%;
            max-width: 800px;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 500px;
            margin-top: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            max-width: 80%;
            padding: 12px 18px;
            border-radius: 15px;
            font-size: 1rem;
            line-height: 1.5;
            position: relative;
            word-wrap: break-word;
        }

        .message.user {
            align-self: flex-end;
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message.ai {
            align-self: flex-start;
            background: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
            border-bottom-left-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .chat-input-area {
            padding: 20px;
            background: rgba(15, 23, 42, 0.5);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            gap: 10px;
        }

        .chat-input {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            padding: 12px 20px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .chat-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #38bdf8;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.2);
        }

        .send-btn {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }

        .send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
        }

        .send-btn:disabled {
            background: #475569;
            cursor: not-allowed;
            transform: none;
        }

        .typing-indicator {
            display: flex;
            gap: 5px;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            align-self: flex-start;
            margin-bottom: 10px;
            display: none;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: #94a3b8;
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out both;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
</head>

<body>
    <?php include 'components/navigation.php'; ?>

    <section class="agent-hero">
        <div class="container">
            <div class="agent-content">
                <div class="ai-avatar">
                    <img src="assets/images/ai_avatar.png" alt="AI Agent" style="width: 200px; height: 200px; border-radius: 50%; box-shadow: 0 0 40px rgba(56, 189, 248, 0.6); animation: pulse-core 2s ease-in-out infinite;">
                </div>
                
                <h1 class="section-title" style="color: white; font-size: 4rem; margin-bottom: 1rem; text-shadow: 0 0 20px rgba(56, 189, 248, 0.3);">AI Agent</h1>
                <p class="section-description" style="color: #cbd5e0; font-size: 1.5rem; max-width: 800px; margin: 0 auto; line-height: 1.6;">
                    ผู้ช่วยอัจฉริยะที่จะมาปฏิวัติวงการเกษตร ด้วยพลังของ Artificial Intelligence<br>
                    ช่วยวิเคราะห์ข้อมูล ตอบคำถาม และให้คำแนะนำที่แม่นยำ
                </p>
                
                <div class="chat-container">
                    <div class="chat-messages" id="chatMessages">
                        <div class="message ai">
                            สวัสดีครับ! ผมคือ AI Agent ผู้ช่วยอัจฉริยะด้านการเกษตร มีอะไรให้ผมช่วยไหมครับ? 🌱
                        </div>
                    </div>
                    <div class="typing-indicator" id="typingIndicator">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                    <form class="chat-input-area" id="chatForm">
                        <input type="text" class="chat-input" id="userInput" placeholder="พิมพ์คำถามของคุณที่นี่..." autocomplete="off">
                        <button type="submit" class="send-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <script type="module" src="js/main.js"></script>
    <script type="module" src="js/ai_agent.js"></script>
</body>

</html>
