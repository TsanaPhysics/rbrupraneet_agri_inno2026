import os

files = [
    'workshop-climate.php',
    'workshop-cnn.php',
    'workshop-iot.php',
    'manual-pocketbook.php',
    'manual-cnn-pocketbook.php',
    'manual-iot-pocketbook.php'
]

for filename in files:
    if os.path.exists(filename):
        with open(filename, 'r', encoding='utf-8') as f:
            html = f.read()
        
        # 1. Fix Web Dashboard Titles
        html = html.replace('| IDEA Center Workshop</title>', '| Digital Agri-Innovation Center</title>')
        
        # 2. Fix Manual CSS header (page::before)
        html = html.replace('content: "ID - ศูนย์นวัตกรรมดิจิทัลอัจฉริยะ (IDEA)";', 'content: "ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี-ประณีตวิทยาคม";')
        
        # 3. Fix Manual footer blocks
        html = html.replace('ศูนย์นวัตกรรมดิจิทัลอัจฉริยะเพื่อสิ่งแวดล้อมและเกษตร (IDEA)', 'ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล')
        html = html.replace('Intelligent Digital Environment & Agri-Tech Center', 'Digital Agri-Innovation Center')
        
        # 4. Fix Manual final huge text section
        html = html.replace('ศูนย์นวัตกรรมดิจิทัลอัจฉริยะเพื่อสิ่งแวดล้อมและเกษตร', 'ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล รำไพพรรณี-ประณีตวิทยาคม')
        html = html.replace('INTELLIGENT DIGITAL ENVIRONMENT & AGRI-TECH CENTER', 'DIGITAL AGRI-INNOVATION CENTER')
        html = html.replace('IDEA</p>', 'RBRU-PRANEET</p>')
        
        with open(filename, 'w', encoding='utf-8') as f:
            f.write(html)
        print(f"✅ Fixed names in {filename}")
