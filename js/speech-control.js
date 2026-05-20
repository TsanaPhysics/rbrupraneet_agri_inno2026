/**
 * Speech Control logic for RBRU-Praneet
 * Handles Text-to-Speech with customizable Pitch, Rate, and Voice Selection.
 */

class SpeechControl {
    constructor() {
        this.synth = window.speechSynthesis;
        this.voices = [];
        this.utterance = null;
        this.isSpeaking = false;
        
        // Settings
        this.pitch = 1.0;
        this.rate = 1.0;
        this.selectedVoice = null;
        
        // UI Elements
        this.container = null;
        this.fab = null;
        this.panel = null;
        
        this.init();
    }

    init() {
        // Create UI Structure
        this.injectUI();
        
        // Load Voices
        this.loadVoices();
        if (this.synth.onvoiceschanged !== undefined) {
            this.synth.onvoiceschanged = () => this.loadVoices();
        }

        // Bind Events
        this.bindEvents();
    }

    injectUI() {
        const html = `
            <div class="speech-control-container" id="speechControl">
                <div class="speech-panel" id="speechPanel">
                    <div class="speech-header">
                        <h3>การตั้งค่าเสียงอ่าน</h3>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">
                            <span>โทนเสียง (Pitch)</span>
                            <span id="pitchVal">1.0</span>
                        </label>
                        <input type="range" id="pitchRange" min="0.5" max="2" step="0.1" value="1">
                    </div>

                    <div class="control-group">
                        <label class="control-label">
                            <span>ความเร็ว (Speed)</span>
                            <span id="rateVal">1.0</span>
                        </label>
                        <input type="range" id="rateRange" min="0.5" max="2" step="0.1" value="1">
                    </div>

                    <div class="control-group">
                        <label class="control-label"><span>เลือกเสียง (Voice)</span></label>
                        <select class="voice-select" id="voiceSelect">
                            <option value="">กำลังโหลดเสียง...</option>
                        </select>
                    </div>

                    <div class="speech-actions">
                        <button class="btn-speech btn-play" id="btnPlay">
                            <span class="icon">🔊</span> ฟังอีกครั้ง
                        </button>
                        <button class="btn-speech btn-stop" id="btnStop">
                            <span class="icon">⏹️</span> หยุด
                        </button>
                    </div>
                </div>
                <button class="speech-fab" id="speechFab" title="ฟังเสียงอ่าน">
                    <span id="fabIcon">🎙️</span>
                </button>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', html);
        
        this.container = document.getElementById('speechControl');
        this.fab = document.getElementById('speechFab');
        this.panel = document.getElementById('speechPanel');
    }

    loadVoices() {
        this.voices = this.synth.getVoices();
        const voiceSelect = document.getElementById('voiceSelect');
        if (!voiceSelect) return;

        voiceSelect.innerHTML = '';
        
        // Prioritize Thai voices
        const thaiVoices = this.voices.filter(v => v.lang.includes('th'));
        const otherVoices = this.voices.filter(v => !v.lang.includes('th'));

        [...thaiVoices, ...otherVoices].forEach(voice => {
            const option = document.createElement('option');
            option.textContent = `${voice.name} (${voice.lang})`;
            option.value = voice.name;
            if (voice.lang.includes('th') && !this.selectedVoice) {
                option.selected = true;
                this.selectedVoice = voice;
            }
            voiceSelect.appendChild(option);
        });

        if (!this.selectedVoice && this.voices.length > 0) {
            this.selectedVoice = this.voices[0];
        }
    }

    bindEvents() {
        // Toggle Panel
        this.fab.addEventListener('click', () => {
            this.panel.classList.toggle('open');
            this.fab.classList.toggle('active');
            const icon = document.getElementById('fabIcon');
            icon.textContent = this.panel.classList.contains('open') ? '✕' : '🎙️';
        });

        // Sliders
        const pitchRange = document.getElementById('pitchRange');
        const rateRange = document.getElementById('rateRange');
        const pitchVal = document.getElementById('pitchVal');
        const rateVal = document.getElementById('rateVal');

        pitchRange.addEventListener('input', (e) => {
            this.pitch = e.target.value;
            pitchVal.textContent = parseFloat(this.pitch).toFixed(1);
        });

        rateRange.addEventListener('input', (e) => {
            this.rate = e.target.value;
            rateVal.textContent = parseFloat(this.rate).toFixed(1);
        });

        // Voice Select
        const voiceSelect = document.getElementById('voiceSelect');
        voiceSelect.addEventListener('change', (e) => {
            this.selectedVoice = this.voices.find(v => v.name === e.target.value);
        });

        // Controls
        document.getElementById('btnPlay').addEventListener('click', () => this.speak());
        document.getElementById('btnStop').addEventListener('click', () => this.stop());

        // Close panel when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target) && this.panel.classList.contains('open')) {
                this.panel.classList.remove('open');
                this.fab.classList.remove('active');
                document.getElementById('fabIcon').textContent = '🎙️';
            }
        });
    }

    getTextToSpeak() {
        // Target specific content based on RBRU Poster structure
        const title = document.querySelector('.main-title')?.innerText || '';
        const school = document.querySelector('.school-badge')?.innerText || '';
        const intro = document.querySelector('.intro-text')?.innerText || '';
        
        const pillars = Array.from(document.querySelectorAll('.pillar-card')).map(card => {
            const h3 = card.querySelector('h3')?.innerText || '';
            const p = card.querySelector('p')?.innerText || '';
            return `${h3}. ${p}`;
        }).join('. ');

        const footer = document.querySelector('.footer-text')?.innerText || '';

        return `${title}. ${school}. ${intro}. รายละเอียดโครงการมีดังนี้. ${pillars}. ${footer}`;
    }

    speak() {
        this.stop();
        
        const text = this.getTextToSpeak();
        if (!text) return;

        this.utterance = new SpeechSynthesisUtterance(text);
        this.utterance.pitch = this.pitch;
        this.utterance.rate = this.rate;
        this.utterance.voice = this.selectedVoice;

        this.utterance.onstart = () => {
            this.isSpeaking = true;
            this.container.classList.add('speaking');
            console.log('Started speaking...');
        };

        this.utterance.onend = () => {
            this.isSpeaking = false;
            this.container.classList.remove('speaking');
            console.log('Finished speaking.');
        };

        this.utterance.onerror = (e) => {
            this.isSpeaking = false;
            this.container.classList.remove('speaking');
            console.log('Speech error:', e);
        };

        this.synth.speak(this.utterance);
    }

    stop() {
        this.synth.cancel();
        this.isSpeaking = false;
        this.container.classList.remove('speaking');
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    window.aidaSpeech = new SpeechControl();
});
