import os

files = [
    'manual-pocketbook.php',
    'manual-cnn-pocketbook.php',
    'manual-iot-pocketbook.php'
]

for filename in files:
    if os.path.exists(filename):
        with open(filename, 'r', encoding='utf-8') as f:
            html = f.read()
            
        # 1. Update CSS Selectors
        html = html.replace('.dropcap::first-letter {', '.thai-dropcap {')
        
        # 2. Inject span around first Thai syllable for Prologue
        html = html.replace('ในยุคที่สภาพภูมิอากาศแปรปรวน', '<span class="thai-dropcap">ใน</span>ยุคที่สภาพภูมิอากาศแปรปรวน')
        
        # 3. Inject span around first Thai syllable for dynamic session loop
        html = html.replace('เจาะลึกทักษะหลักด้วย', '<span class="thai-dropcap">เจาะ</span>ลึกทักษะหลักด้วย')
        
        with open(filename, 'w', encoding='utf-8') as f:
            f.write(html)
        print(f"✅ Fixed Thai Dropcap in {filename}")
