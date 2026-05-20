<?php
session_start();
// Language Handler
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
if (!in_array($lang_code, ['th', 'en', 'cn'])) {
    $lang_code = 'th';
}
require_once "languages/{$lang_code}.php";
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIDA — ผู้ช่วยอัจฉริยะ | RBRU-Praneet xAI Center</title>
    <meta name="description" content="AIDA — ผู้ช่วยอัจฉริยะด้านเกษตรและสิ่งแวดล้อม พร้อมระบบเสียง Vision และ AI หลายโมเดล">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
        /* ============================================================
           AIDA Agent — Premium Dark UI
           ============================================================ */
        :root {
            --aida-primary: #84cc16; /* Durian Green */
            --aida-secondary: #fde047; /* Durian Gold */
            --aida-accent: #8b5cf6; /* xAI Purple */
            --aida-bg-deep: #050a01; /* Very dark green */
            --aida-bg-card: rgba(10, 20, 1, 0.9);
            --aida-glass: rgba(10, 20, 1, 0.6);
            --aida-border: rgba(132, 204, 22, 0.15);
            --aida-text: #f0fdf4;
            --aida-text-dim: #a3e635;
            --aida-success: #22c55e;
            --aida-warning: #f59e0b;
            --durian-glow: 0 0 20px rgba(132, 204, 22, 0.3);
        }

        .agent-page {
            min-height: 100vh;
            background: var(--aida-bg-deep);
            color: var(--aida-text);
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .agent-page::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: 
                radial-gradient(ellipse at 15% 20%, rgba(132, 204, 22, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 85% 80%, rgba(253, 224, 71, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 92, 246, 0.05) 0%, transparent 40%);
            z-index: 0;
            animation: bgShift 20s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes bgShift {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        /* Grid pattern */
        .agent-page::after {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image: 
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
            pointer-events: none;
        }

        /* ============================================================
           Hero Section
           ============================================================ */
        .agent-hero {
            padding-top: 120px;
            padding-bottom: 30px;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .aida-avatar-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            position: relative;
        }

        .aida-avatar-container::after {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            border: 2px solid var(--aida-primary);
            border-radius: 50%;
            border-style: dashed;
            animation: rotate 20s linear infinite;
            opacity: 0.3;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .aida-avatar {
            position: relative;
            width: 140px;
            height: 140px;
        }

        .aida-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(56, 189, 248, 0.4);
            box-shadow: 
                0 0 30px rgba(56, 189, 248, 0.3),
                0 0 60px rgba(139, 92, 246, 0.15);
            animation: avatarPulse 3s ease-in-out infinite;
        }

        .aida-status {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            background: var(--aida-success);
            border-radius: 50%;
            border: 3px solid var(--aida-bg-deep);
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.6);
            animation: statusBlink 2s ease-in-out infinite;
        }

        @keyframes avatarPulse {
            0%, 100% { box-shadow: 0 0 30px rgba(56, 189, 248, 0.3), 0 0 60px rgba(139, 92, 246, 0.15); }
            50% { box-shadow: 0 0 40px rgba(56, 189, 248, 0.5), 0 0 80px rgba(139, 92, 246, 0.25); }
        }

        @keyframes statusBlink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .aida-title {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--aida-primary) 0%, var(--aida-accent) 50%, var(--aida-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .aida-subtitle {
            font-size: 1.1rem;
            color: var(--aida-text-dim);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* ============================================================
           Model Status Bar
           ============================================================ */
        .model-status-bar {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .model-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: var(--aida-glass);
            border: 1px solid var(--aida-border);
            border-radius: 100px;
            font-size: 0.75rem;
            color: var(--aida-text-dim);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .model-chip:hover {
            border-color: var(--aida-primary);
            color: var(--aida-primary);
            transform: translateY(-2px);
        }

        .model-chip .chip-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--aida-success);
        }

        /* ============================================================
           Quick Actions
           ============================================================ */
        .quick-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .quick-action-btn {
            padding: 8px 18px;
            background: var(--aida-glass);
            border: 1px solid var(--aida-border);
            border-radius: 100px;
            color: var(--aida-text);
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }

        .quick-action-btn:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: var(--aida-primary);
            color: var(--aida-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.2);
        }

        /* ============================================================
           Chat Container
           ============================================================ */
        .chat-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .chat-container {
            background: var(--aida-bg-card);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid var(--aida-border);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 55vh;
            min-height: 400px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        }

        /* Chat Header */
        .chat-header {
            padding: 16px 24px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border-bottom: 1px solid var(--aida-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-header-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--aida-primary), var(--aida-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .chat-header-info h3 {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .chat-header-info span {
            font-size: 0.7rem;
            color: var(--aida-success);
        }

        .active-model-display {
            font-size: 0.7rem;
            padding: 4px 12px;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 100px;
            color: var(--aida-success);
            font-weight: 500;
        }

        .chat-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-header-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--aida-border);
            color: var(--aida-text);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .chat-header-btn:hover {
            background: rgba(249, 115, 22, 0.2);
            border-color: #f97316;
            color: #f97316;
        }

        /* Voice Settings Panel */
        .voice-settings-overlay {
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--aida-border);
            padding: 20px 24px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .voice-settings-overlay.hidden {
            display: none;
        }

        .settings-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .settings-label-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--aida-text-dim);
        }

        .settings-label-row span:last-child {
            color: #f97316;
        }

        .aida-range {
            -webkit-appearance: none;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            outline: none;
        }

        .aida-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            background: #f97316;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid white;
        }

        .aida-select {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--aida-border);
            color: var(--aida-text);
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            outline: none;
        }

        .aida-select:focus {
            border-color: #f97316;
        }

        .re-read-btn {
            background: rgba(249, 115, 22, 0.1);
            border: 1px solid rgba(249, 115, 22, 0.2);
            color: #f97316;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 100px;
            margin-top: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }

        .re-read-btn:hover {
            background: rgba(249, 115, 22, 0.2);
            transform: translateY(-1px);
        }

        /* Messages */
        .chat-messages {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
            scroll-behavior: smooth;
        }

        .chat-messages::-webkit-scrollbar {
            width: 4px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .message {
            max-width: 82%;
            padding: 14px 20px;
            border-radius: 20px;
            font-size: 0.95rem;
            line-height: 1.7;
            position: relative;
            word-wrap: break-word;
            animation: messageIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes messageIn {
            from { opacity: 0; transform: translateY(12px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .message.user {
            align-self: flex-end;
            background: linear-gradient(135deg, var(--aida-primary) 0%, #0284c7 100%);
            color: white;
            border-bottom-right-radius: 6px;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.3);
        }

        .message.ai {
            align-self: flex-start;
            background: var(--aida-glass);
            color: var(--aida-text);
            border-bottom-left-radius: 6px;
            border: 1px solid var(--aida-border);
        }

        .message .model-badge {
            font-size: 0.65rem;
            color: var(--aida-primary);
            margin-bottom: 6px;
            font-weight: 600;
            opacity: 0.8;
            letter-spacing: 0.3px;
        }

        .message .message-content {
            font-family: 'Noto Sans Thai', 'Inter', sans-serif;
        }

        .message .message-content code {
            background: rgba(0, 0, 0, 0.3);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85em;
            font-family: 'Fira Code', monospace;
        }

        .message .message-content strong {
            color: var(--aida-accent);
        }

        .message .message-content .list-num,
        .message .message-content .list-bullet {
            color: var(--aida-primary);
            font-weight: 700;
            margin-right: 4px;
        }

        /* Chat Image */
        .chat-image {
            max-width: 280px;
            max-height: 200px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        /* Typing Indicator */
        .typing-indicator {
            display: none;
            gap: 6px;
            padding: 14px 20px;
            background: var(--aida-glass);
            border-radius: 20px;
            align-self: flex-start;
            border: 1px solid var(--aida-border);
            align-items: center;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: var(--aida-primary);
            border-radius: 50%;
            animation: typingPulse 1.4s infinite ease-in-out both;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typingPulse {
            0%, 80%, 100% { transform: scale(0.4); opacity: 0.3; }
            40% { transform: scale(1); opacity: 1; }
        }

        /* ============================================================
           Image Preview
           ============================================================ */
        .image-preview {
            display: none;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: rgba(56, 189, 248, 0.08);
            border-top: 1px solid var(--aida-border);
        }

        .image-preview img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--aida-primary);
        }

        .image-preview .preview-info {
            flex: 1;
            font-size: 0.8rem;
            color: var(--aida-primary);
        }

        .image-preview .remove-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid rgba(239, 68, 68, 0.3);
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.2s;
        }

        .image-preview .remove-btn:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        /* ============================================================
           Chat Input Area
           ============================================================ */
        .chat-input-area {
            padding: 16px 20px;
            background: rgba(10, 15, 26, 0.6);
            border-top: 1px solid var(--aida-border);
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .chat-input {
            flex: 1;
            background: var(--aida-glass);
            border: 1px solid var(--aida-border);
            border-radius: 50px;
            padding: 12px 22px;
            color: white;
            font-size: 0.95rem;
            font-family: 'Noto Sans Thai', 'Inter', sans-serif;
            outline: none;
            transition: all 0.3s ease;
        }

        .chat-input::placeholder {
            color: var(--aida-text-dim);
        }

        .chat-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--aida-primary);
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.15);
        }

        /* Action buttons */
        .input-action-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid var(--aida-border);
            background: var(--aida-glass);
            color: var(--aida-text-dim);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .input-action-btn:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: var(--aida-primary);
            color: var(--aida-primary);
            transform: scale(1.05);
        }

        /* Voice Recording State */
        .input-action-btn.recording {
            background: rgba(239, 68, 68, 0.2) !important;
            border-color: #ef4444 !important;
            color: #ef4444 !important;
            animation: recordPulse 1s ease-in-out infinite;
        }

        @keyframes recordPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        }

        /* Send Button */
        .send-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, var(--aida-primary) 0%, #0284c7 100%);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.3);
        }

        .send-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 25px rgba(56, 189, 248, 0.5);
        }

        .send-btn:active {
            transform: scale(0.95);
        }

        /* ============================================================
           Features Section
           ============================================================ */
        .features-section {
            padding: 60px 20px;
            position: relative;
            z-index: 1;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--aida-glass);
            border: 1px solid var(--aida-border);
            border-radius: 20px;
            padding: 28px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: var(--aida-primary);
            box-shadow: 0 15px 40px rgba(56, 189, 248, 0.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 16px;
            display: block;
        }

        .feature-card h3 {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: white;
        }

        .feature-card p {
            font-size: 0.85rem;
            color: var(--aida-text-dim);
            line-height: 1.6;
        }

        /* ============================================================
           Responsive
           ============================================================ */
        @media (max-width: 768px) {
            .agent-hero { padding-top: 90px; }
            .aida-title { font-size: 2rem; }
            .aida-subtitle { font-size: 0.95rem; }
            .chat-container { height: 60vh; border-radius: 16px; }
            .message { max-width: 90%; font-size: 0.9rem; }
            .model-status-bar { gap: 6px; }
            .model-chip { font-size: 0.65rem; padding: 4px 10px; }
            .quick-actions { gap: 6px; }
            .quick-action-btn { font-size: 0.75rem; padding: 6px 14px; }
            .features-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
            .feature-card { padding: 20px; }
        }

        @media (max-width: 480px) {
            .features-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body class="agent-page">
    <?php include 'components/navigation.php'; ?>

    <!-- Hero Section -->
    <section class="agent-hero">
        <div class="container">
            <!-- Avatar -->
            <div class="aida-avatar-container">
                <div class="aida-avatar">
                    <img src="assets/images/ai_avatar.png" alt="AIDA Avatar">
                    <div class="aida-status" title="Online"></div>
                </div>
            </div>

            <h1 class="aida-title">AIDA Intelligence</h1>
            <p class="aida-subtitle">
                ผู้ช่วยอัจฉริยะด้านเกษตรและสิ่งแวดล้อม — พูดคุย วิเคราะห์ภาพ สั่งงานด้วยเสียง
            </p>

            <!-- Model Status -->
            <div class="model-status-bar">
                <div class="model-chip"><span class="chip-dot"></span> Gemma 4 (Multimodal)</div>
                <div class="model-chip"><span class="chip-dot"></span> DeepSeek-R1 (Reasoning)</div>
                <div class="model-chip"><span class="chip-dot"></span> Qwen 3 VL (Vision)</div>
                <div class="model-chip"><span class="chip-dot"></span> Llama 3.2 (Fast)</div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="quick-action-btn" data-prompt="วิเคราะห์สภาพดินที่เหมาะกับการปลูกทุเรียนในจันทบุรี">🌱 ดินทุเรียน</button>
                <button class="quick-action-btn" data-prompt="ทำไม IoT ถึงสำคัญกับการเกษตรยุคใหม่">🤖 IoT เกษตร</button>
                <button class="quick-action-btn" data-prompt="คำนวณปริมาณน้ำที่ต้องใช้สำหรับสวนผลไม้ 5 ไร่">💧 คำนวณน้ำ</button>
                <button class="quick-action-btn" data-prompt="แนะนำเทคนิค AI สำหรับตรวจจับโรคพืช">🔬 AI ตรวจโรค</button>
            </div>
        </div>
    </section>

    <!-- Chat Interface -->
    <div class="chat-wrapper">
        <div class="chat-container">
            <!-- Chat Header -->
            <div class="chat-header">
                <div class="chat-header-left">
                    <div class="chat-header-avatar">🤖</div>
                    <div class="chat-header-info">
                        <h3>AIDA Assistant</h3>
                        <span>● Online — Smart Routing Active</span>
                    </div>
                </div>
                </div>
                <div class="chat-header-actions">
                    <div class="active-model-display" id="activeModelDisplay">🧠 Gemma 4</div>
                    <button class="chat-header-btn" id="voiceSettingsBtn" title="Voice Settings">⚙️</button>
                </div>
            </div>

            <!-- Voice Settings Overlay -->
            <div class="voice-settings-overlay hidden" id="voiceSettingsOverlay">
                <div class="settings-row">
                    <div class="settings-label-row">
                        <span>โทนเสียง (Pitch)</span>
                        <span id="pitchValLabel">1.0</span>
                    </div>
                    <input type="range" class="aida-range" id="pitchRangeInput" min="0.5" max="2" step="0.1" value="1">
                </div>
                <div class="settings-row">
                    <div class="settings-label-row">
                        <span>ความเร็ว (Speed)</span>
                        <span id="rateValLabel">1.0</span>
                    </div>
                    <input type="range" class="aida-range" id="rateRangeInput" min="0.5" max="2" step="0.1" value="1">
                </div>
                <div class="settings-row">
                    <div class="settings-label-row">
                        <span>เลือกเสียง (Voice)</span>
                    </div>
                    <select class="aida-select" id="voiceSelectInput"></select>
                </div>
            </div>

            <!-- Messages -->
            <div class="chat-messages" id="chatMessages">
                <div class="message ai">
                    <div class="model-badge">🧠 Gemma 4 (Multimodal)</div>
                    <div class="message-content">
                        สวัสดีจ๊ะ! ผมคือ <strong>AIDA</strong> ผู้ช่วยอัจฉริยะด้านเกษตรและสิ่งแวดล้อม จากมหาวิทยาลัยราชภัฏรำไพพรรณี 🌾<br><br>
                        ผมรองรับทั้ง <strong>พิมพ์ พูด และส่งรูปภาพ</strong> ให้วิเคราะห์ได้เลยนะเนอะ ฮิ<br><br>
                        💬 <em>พิมพ์คำถาม</em> | 🎙️ <em>กดปุ่มไมค์พูด</em> | 📷 <em>ส่งรูปวิเคราะห์</em>
                        <br>
                        <button class="re-read-btn" onclick="speakThai('สวัสดีจ๊ะ! ผมคือ AIDA ผู้ช่วยอัจฉริยะด้านเกษตรและสิ่งแวดล้อม จากมหาวิทยาลัยราชภัฏรำไพพรรณี ผมรองรับทั้ง พิมพ์ พูด และส่งรูปภาพ ให้วิเคราะห์ได้เลยนะเนอะ ฮิ')">📢 ฟังซ้ำ</button>
                    </div>
                </div>

                <div class="typing-indicator" id="typingIndicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>

            <!-- Image Preview -->
            <div class="image-preview" id="imagePreview">
                <img id="previewImg" src="" alt="Preview">
                <div class="preview-info">📷 รูปภาพพร้อมส่งวิเคราะห์</div>
                <button class="remove-btn" id="removeImageBtn" title="ลบรูป">✕</button>
            </div>

            <!-- Input Area -->
            <form class="chat-input-area" id="chatForm">
                <!-- Image Upload -->
                <input type="file" id="imageInput" accept="image/*" style="display:none">
                <button type="button" class="input-action-btn" id="imageBtn" title="อัปโหลดรูปภาพ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </button>

                <!-- Voice Button -->
                <button type="button" class="input-action-btn" id="voiceBtn" title="พูดคำสั่งเสียง">
                    <span class="voice-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                            <line x1="12" y1="19" x2="12" y2="23"/>
                            <line x1="8" y1="23" x2="16" y2="23"/>
                        </svg>
                    </span>
                </button>

                <!-- Text Input -->
                <input type="text" class="chat-input" id="userInput" placeholder="พิมพ์หรือพูดคำถามของคุณที่นี่..." autocomplete="off">

                <!-- Send Button -->
                <button type="submit" class="send-btn" title="ส่งข้อความ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">🧠</span>
                <h3>Smart Routing</h3>
                <p>เลือกโมเดล AI ที่เหมาะสมอัตโนมัติ — Reasoning, Vision, Fast Chat</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🎙️</span>
                <h3>Voice Interface</h3>
                <p>พูดภาษาไทยสั่งงาน AI พร้อมฟังคำตอบเสียงอัตโนมัติ</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">👁️</span>
                <h3>Vision Analysis</h3>
                <p>ส่งรูปภาพพืช ดิน แมลง ให้ AI วิเคราะห์ทันที</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">📚</span>
                <h3>Knowledge Base</h3>
                <p>ฐานความรู้เกษตรอัจฉริยะจากมหาวิทยาลัยราชภัฏรำไพพรรณี</p>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <script type="module" src="js/main.js"></script>
    <script src="js/ai_agent.js"></script>
</body>

</html>
