<?php
session_start();
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th';
require_once "languages/{$lang_code}.php";
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Twin Lab | RBRU-Praneet</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sections.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        .lab-container {
            padding-top: 120px;
            background: #f8fafc;
            min-height: 100vh;
        }
        .sim-box {
            background: #0f172a;
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255,255,255,0.05);
            position: relative;
        }
        .mode-row {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
            justify-content: center;
        }
        .mode-pill {
            flex: 1;
            max-width: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 24px;
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            color: #475569;
            border: 2px solid transparent;
            box-shadow: 0 10px 20px rgba(0,0,0,0.03);
        }
        .mode-pill:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }
        .mode-pill.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 15px 35px rgba(249, 115, 22, 0.3);
        }
        .mode-icon {
            font-size: 1.8rem;
        }
        #lab-canvas {
            width: 100%;
            height: auto;
            aspect-ratio: 16/7; /* Wider for row layout */
            background: #1e293b;
            display: block;
            cursor: crosshair;
        }
        .status-grid {
            display: grid;
            grid-template-cols: 1fr;
            gap: 20px;
            margin-top: 30px;
        }
        @media (min-width: 768px) {
            .status-grid {
                grid-template-cols: repeat(3, 1fr);
            }
        }
        .status-card {
            background: white;
            padding: 25px;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.3s;
        }
        .status-card:hover {
            border-color: #f97316;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        }
        .score-display {
            background: rgba(15, 23, 42, 0.9);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 900;
            font-size: 1.2rem;
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <?php include 'components/navigation.php'; ?>

    <main class="lab-container">
        <div class="container">
            <div class="section-header text-center mb-10">
                <span class="badge">Next-Gen Simulation</span>
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-4">
                    <h1 class="font-black text-5xl italic">Digital Twin <span class="text-primary underline">Sandbox</span></h1>
                    <div class="score-display">
                        <span class="opacity-50 mr-2">MISSION SCORE:</span>
                        <span id="val-score" class="text-primary">0</span>
                    </div>
                </div>
                <p class="text-slate-500 max-w-2xl mx-auto">ยกระดับการเรียนรู้ด้วยปัญญาประดิษฐ์และห้องวิจัยเสมือนจริงในรูปแบบแถวแนวนอนที่สะอาดตาและใช้งานง่าย</p>
            </div>

            <div class="mission-hub">
                <!-- Mode Selection Row -->
                <div class="mode-row">
                    <div class="mode-pill active" onclick="switchMode('DRONE')">
                        <span class="mode-icon">🚁</span>
                        <span>AI Drone Scan</span>
                    </div>
                    <div class="mode-pill" onclick="switchMode('BOT')">
                        <span class="mode-icon">🤖</span>
                        <span>Soil Inspector</span>
                    </div>
                </div>

                <!-- Simulation Main Area -->
                <div class="sim-box">
                    <div style="position: relative;">
                        <canvas id="lab-canvas" width="1400" height="600"></canvas>
                        
                        <div id="sim-start-overlay" class="sim-overlay">
                            <div class="bg-white/10 p-12 rounded-[60px] backdrop-blur-2xl border border-white/20 text-center">
                                <h2 class="text-4xl font-black mb-4">READY TO DEPLOY? 🚀</h2>
                                <p class="mb-8 opacity-70">ยืนยันเพื่อเข้าสู่พื้นที่จำลองและเริ่มการสำรวจทันที</p>
                                <button onclick="startSim()" class="btn btn-primary" style="padding: 22px 60px; font-size: 1.3rem; border-radius: 50px;">INITIALIZE MISSION</button>
                            </div>
                        </div>

                        <div id="sim-result" class="glass-result">
                            <div class="flex justify-between items-center mb-4">
                                <span id="res-tag" class="badge">Analysing...</span>
                                <span id="res-acc" class="text-xs font-black text-emerald-500">TELEMETRY LINK ACTIVE</span>
                            </div>
                            <h3 id="res-title" class="text-2xl font-black text-slate-800">WAITING FOR INPUT</h3>
                            <p id="res-desc" class="text-slate-500 font-bold">กรุณาเลื่อนตำแหน่งสแกนไปยังเป้าหมายที่คุณต้องการตรวจสอบ</p>
                        </div>
                    </div>
                </div>

                <!-- Status Grid Row -->
                <div class="status-grid">
                    <div class="status-card">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl">🎯</div>
                            <h4 class="font-black text-lg">Objective</h4>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed font-bold italic">ตรวจพบทุเรียนที่เป็นโรคและเสนอแนวทางแก้ไขที่ถูกต้องแม่นยำผ่านระบบสแกนอัตโนมัติ</p>
                    </div>
                    <div class="status-card">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">⌨️</div>
                            <h4 class="font-black text-lg">Controls</h4>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed font-bold">ลูกศร: เคลื่อนที่ตัวละคร<br>SPACE: เริ่มการสแกนพื้นที่เป้าหมาย</p>
                    </div>
                    <div class="status-card border-l-4 border-l-primary">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">📡</div>
                            <h4 class="font-black text-lg">System Status</h4>
                        </div>
                        <div id="log-msg" class="text-xs font-black text-emerald-500 uppercase tracking-widest">Optimal / No Errors</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>

    <script>
        const canvas = document.getElementById('lab-canvas');
        const ctx = canvas.getContext('2d');
        const overlay = document.getElementById('sim-start-overlay');
        const resBox = document.getElementById('sim-result');
        
        // Assets Mapping
        const assetPaths = {
            tile: 'assets/images/sim/tile_grass.png',
            bot: 'assets/images/sim/agri_bot.png',
            drone: 'assets/images/sim/agri_drone.png',
            treeH: 'assets/images/sim/tree_healthy.png',
            treeD: 'assets/images/sim/tree_diseased.png'
        };

        const assets = {};
        let loadedCount = 0;
        const totalAssets = Object.keys(assetPaths).length;

        function processTransparency(img) {
            const tempCanvas = document.createElement('canvas');
            const tCtx = tempCanvas.getContext('2d');
            tempCanvas.width = img.width;
            tempCanvas.height = img.height;
            tCtx.drawImage(img, 0, 0);

            const imgData = tCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height);
            const data = imgData.data;

            for (let i = 0; i < data.length; i += 4) {
                const r = data[i], g = data[i+1], b = data[i+2];
                
                // Advanced Color Distance: remove bright near-neutral/white pixels
                // Stricter check to catch greyish areas in corners
                const brightness = (r + g + b) / 3;
                const saturation = Math.max(Math.abs(r-g), Math.abs(g-b), Math.abs(b-r));
                
                if (brightness > 200 && saturation < 30) {
                    data[i + 3] = 0;
                }
            }

            tCtx.putImageData(imgData, 0, 0);
            return tempCanvas; 
        }

        // Initialize Loading
        Object.keys(assetPaths).forEach(key => {
            const img = new Image();
            img.src = assetPaths[key];
            img.onload = () => {
                assets[key] = processTransparency(img);
                loadedCount++;
                if(loadedCount === totalAssets) {
                    console.log("All assets processed with transparency.");
                }
            };
        });

        let state = {
            running: false,
            mode: 'DRONE', // DRONE, BOT
            bot: { ix: 1, iy: 1 }, // Centered start
            grid: [],
            score: 0,
            frame: 0,
            keys: {},
            activeScan: false
        };

        // NEW DIMENSIONS: Doubled spacing for more "breathing room"
        const TILE_W = 400; 
        const TILE_H = 200;
        const OFFSET_X = 600;
        const OFFSET_Y = 100;

        function isoToScreen(ix, iy) {
            return {
                x: OFFSET_X + (ix - iy) * (TILE_W / 2),
                y: OFFSET_Y + (ix + iy) * (TILE_H / 2)
            };
        }

        function switchMode(m) {
            state.mode = m;
            document.querySelectorAll('.mode-pill').forEach(p => {
                p.classList.remove('active');
                if(p.innerText.includes(m)) p.classList.add('active');
            });
            if(state.running) initGrid();
        }

        function initGrid() {
            state.grid = [];
            const size = 3; // Reduced grid size for better focus
            for(let x=0; x<size; x++) {
                for(let y=0; y<size; y++) {
                    // Place trees with interleaving or just pure 3x3
                    state.grid.push({
                        ix: x, iy: y,
                        type: 'tree',
                        status: Math.random() > 0.7 ? 'Diseased' : 'Healthy',
                        scanned: false
                    });
                }
            }
        }

        function startSim() {
            overlay.style.display = 'none';
            state.running = true;
            initGrid();
            requestAnimationFrame(loop);
        }

        function update() {
            if(!state.running || state.activeScan) return;
            state.frame++;

            if(state.keys['ArrowUp'] && state.bot.iy > 0) state.bot.iy -= 1;
            if(state.keys['ArrowDown'] && state.bot.iy < 2) state.bot.iy += 1;
            if(state.keys['ArrowLeft'] && state.bot.ix > 0) state.bot.ix -= 1;
            if(state.keys['ArrowRight'] && state.bot.ix < 2) state.bot.ix += 1;

            if(state.keys[' ']) performScan();
            
            state.keys = {}; // Clear simple key press
        }

        function performScan() {
            state.activeScan = true;
            resBox.style.display = 'block';
            document.getElementById('res-title').innerText = 'สแกนเป้าหมาย...';
            document.getElementById('res-desc').innerText = 'กำลังประมวลผลข้อมูลชีวภาพในจุดที่เลือก';

            const item = state.grid.find(g => g.ix === state.bot.ix && g.iy === state.bot.iy);
            
            setTimeout(() => {
                if(item) {
                    if(item.status === 'Healthy') {
                        document.getElementById('res-title').innerText = 'TREE STATUS: HEALTHY ✅';
                        document.getElementById('res-desc').innerText = 'ต้นไม้สมบูรณ์แข็งแรงดี ไม่พบสารบ่งชี้โรค';
                        document.getElementById('res-tag').className = 'badge bg-emerald-500';
                    } else {
                        document.getElementById('res-title').innerText = 'ISSUE DETECTED: PHYTOPHTORA ⚠️';
                        document.getElementById('res-desc').innerText = 'ตรวจพบอาการรากเน่าโคนเน่า แนะนำให้ฉีดพ่นสารฟอสอีทิล และระบายน้ำด่วน';
                        document.getElementById('res-tag').className = 'badge bg-rose-500';
                        if(!item.scanned) {
                            state.score += 100;
                            document.getElementById('val-score').innerText = state.score;
                            item.scanned = true;
                        }
                    }
                }
                setTimeout(() => {
                    resBox.style.display = 'none';
                    state.activeScan = false;
                }, 3000);
            }, 1000);
        }

        function loop() {
            update();
            draw();
            if(state.running) requestAnimationFrame(loop);
        }

        function draw() {
            ctx.clearRect(0,0,1200,600);
            
            if (loadedCount < totalAssets) {
                ctx.fillStyle = "white";
                ctx.textAlign = "center";
                ctx.fillText("Loading 3D Assets...", 600, 300);
                return;
            }

            // Draw Base Tiles with extra care
            for(let x=0; x<5; x++) {
                for(let y=0; y<5; y++) {
                    let p = isoToScreen(x, y);
                    // Drawing ground with slight overlap to prevent gaps, 
                    // but the primary scene is handled by the trees/objects.
                    ctx.drawImage(assets.tile, p.x - TILE_W, p.y - TILE_H, TILE_W*2, TILE_H*2);
                }
            }

            // Draw Entities
            let entities = [...state.grid];
            entities.push({type:'player', ix: state.bot.ix, iy: state.bot.iy});
            entities.sort((a,b) => (a.ix + a.iy) - (b.ix + b.iy));

            entities.forEach(e => {
                let p = isoToScreen(e.ix, e.iy);
                if(e.type === 'player') {
                    if(state.mode === 'DRONE') {
                        let h = Math.sin(state.frame * 0.1) * 15;
                        ctx.drawImage(assets.drone, p.x - 80, p.y - 180 + h, 160, 160);
                    } else {
                        ctx.drawImage(assets.bot, p.x - 70, p.y - 130, 140, 140);
                    }
                } else {
                    let img = e.status === 'Healthy' ? assets.treeH : assets.treeD;
                    // Trees are 1024px assets, scale them appropriately for the isometric grid
                    ctx.drawImage(img, p.x - 120, p.y - 220, 240, 240);
                }
            });
        }

        function loop() {
            update();
            draw();
            if(state.running) requestAnimationFrame(loop);
        }

        window.addEventListener('keydown', e => {
            state.keys[e.key] = true;
            if(['ArrowUp','ArrowDown','ArrowLeft','ArrowRight',' '].includes(e.key)) e.preventDefault();
        });
    </script>
</body>
</html>
