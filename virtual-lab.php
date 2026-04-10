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
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
        }
        .sim-header {
            padding: 20px 30px;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .mode-pill {
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            background: #f1f5f9;
            color: #64748b;
        }
        .mode-pill.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }
        #lab-canvas {
            width: 100%;
            height: 500px;
            background: #e2e8f0;
            display: block;
            cursor: crosshair;
        }
        .sim-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 100;
            color: white;
            text-align: center;
            padding: 40px;
        }
        .glass-result {
            position: absolute;
            bottom: 30px;
            left: 30px;
            right: 30px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border-radius: 20px;
            border: 1px solid white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: none;
            z-index: 50;
        }
    </style>
</head>
<body>
    <?php include 'components/navigation.php'; ?>

    <main class="lab-container">
        <div class="container">
            <div class="section-header text-center mb-12">
                <span class="badge">Virtual Simulation</span>
                <h1 class="font-black text-4xl mb-4">Digital Twin <span class="text-primary">Sandbox</span></h1>
                <p class="text-slate-500">ทดลองสแกนและวิเคราะห์ฟาร์มจำลองด้วยเทคโนโลยี AI ในโลก 3D เสมือนจริง</p>
            </div>

            <div class="sim-box">
                <div class="sim-header">
                    <div class="flex gap-3">
                        <div class="mode-pill active" onclick="switchMode('DRONE')">🚁 AI Drone Scan</div>
                        <div class="mode-pill" onclick="switchMode('BOT')">🤖 Soil Inspector</div>
                    </div>
                    <div class="text-sm font-bold text-slate-400">SCORE: <span id="val-score" class="text-primary">0</span></div>
                </div>

                <div style="position: relative;">
                    <canvas id="lab-canvas" width="1200" height="600"></canvas>
                    
                    <div id="sim-start-overlay" class="sim-overlay">
                        <h2 class="text-3xl font-black mb-4">Launch Mission 🚀</h2>
                        <p class="mb-8 opacity-70">บังคับตัวละครเพื่อเริ่มการสำรวจพื้นที่และวิเคราะห์สถานภาพพืช</p>
                        <button onclick="startSim()" class="btn-primary">START SIMULATOR</button>
                    </div>

                    <div id="sim-result" class="glass-result">
                        <div class="flex justify-between items-center mb-2">
                            <span id="res-tag" class="badge">Diagnosis</span>
                            <span id="res-acc" class="text-xs font-bold text-emerald-500">ACCURACY: 98%</span>
                        </div>
                        <h3 id="res-title" class="text-xl font-bold text-slate-800">SCANNING...</h3>
                        <p id="res-desc" class="text-sm text-slate-500">Analyzing biological markers in the area...</p>
                    </div>
                </div>
            </div>

            <!-- Controls Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="glass-compact p-6 rounded-3xl">
                    <div class="text-2xl mb-2">⌨️</div>
                    <h4 class="font-bold">Controls</h4>
                    <p class="text-xs text-slate-500">ARROWS: Move<br>SPACE: Scan / Inspect</p>
                </div>
                <div class="glass-compact p-6 rounded-3xl">
                    <div class="text-2xl mb-2">🎯</div>
                    <h4 class="font-bold">Objective</h4>
                    <p class="text-xs text-slate-500">ตรวจพบทุเรียนที่เป็นโรคและเสนอแนวทางแก้ไขที่ถูกต้อง</p>
                </div>
                <div class="glass-compact p-6 rounded-3xl">
                    <div class="text-2xl mb-2">📊</div>
                    <h4 class="font-bold">Mission Status</h4>
                    <p class="text-xs text-slate-500" id="log-msg">Ready for deployment</p>
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
        const assets = {
            tile: new Image(),
            bot: new Image(),
            drone: new Image(),
            treeH: new Image(),
            treeD: new Image()
        };
        assets.tile.src = 'assets/images/sim/tile_grass.png';
        assets.bot.src = 'assets/images/sim/agri_bot.png';
        assets.drone.src = 'assets/images/sim/agri_drone.png';
        assets.treeH.src = 'assets/images/sim/tree_healthy.png';
        assets.treeD.src = 'assets/images/sim/tree_diseased.png';

        let state = {
            running: false,
            mode: 'DRONE', // DRONE, BOT
            bot: { ix: 2, iy: 2 },
            grid: [],
            score: 0,
            frame: 0,
            keys: {},
            activeScan: false
        };

        const TILE_W = 200;
        const TILE_H = 100;
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
            const size = 5;
            for(let x=0; x<size; x++) {
                for(let y=0; y<size; y++) {
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
            if(state.keys['ArrowDown'] && state.bot.iy < 4) state.bot.iy += 1;
            if(state.keys['ArrowLeft'] && state.bot.ix > 0) state.bot.ix -= 1;
            if(state.keys['ArrowRight'] && state.bot.ix < 4) state.bot.ix += 1;

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

        function draw() {
            ctx.clearRect(0,0,1200,600);
            
            // Draw Tiles
            for(let x=0; x<5; x++) {
                for(let y=0; y<5; y++) {
                    let p = isoToScreen(x, y);
                    ctx.drawImage(assets.tile, p.x - TILE_W/2, p.y - 120, TILE_W, 200);
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
                        let h = Math.sin(state.frame * 0.1) * 10;
                        ctx.drawImage(assets.drone, p.x - 70, p.y - 150 + h, 140, 140);
                    } else {
                        ctx.drawImage(assets.bot, p.x - 60, p.y - 110, 120, 120);
                    }
                } else {
                    let img = e.status === 'Healthy' ? assets.treeH : assets.treeD;
                    ctx.drawImage(img, p.x - 100, p.y - 180, 200, 200);
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
