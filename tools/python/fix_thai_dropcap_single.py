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
            
        html = html.replace('<span class="thai-dropcap">ใน</span>', '<span class="thai-dropcap">ใ</span>น')
        html = html.replace('<span class="thai-dropcap">เจาะ</span>', '<span class="thai-dropcap">เ</span>จาะ')
        
        with open(filename, 'w', encoding='utf-8') as f:
            f.write(html)
        print(f"✅ Fixed single char Dropcap in {filename}")
