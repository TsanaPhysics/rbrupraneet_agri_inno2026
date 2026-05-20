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
            
        html = html.replace('<p class="dropcap">', '<p>')
        html = html.replace('<p class="dropcap" style="font-size: 1rem;">', '<p style="font-size: 1rem;">')
        
        with open(filename, 'w', encoding='utf-8') as f:
            f.write(html)
        print(f"✅ Removed dropcap classes in {filename}")
