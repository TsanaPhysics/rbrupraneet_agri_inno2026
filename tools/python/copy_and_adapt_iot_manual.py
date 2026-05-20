import re

print("Starting structural transfer of manual to IoT...")

with open('manual-pocketbook.php', 'r', encoding='utf-8') as f:
    html = f.read()

# 1. Update text metadata & titles
html = html.replace('ePocketbook: Climate Hacking 2026', 'ePocketbook: AI-IoT Prototyping 2026')
html = html.replace('Climate Hacking Handbook', 'AI-IoT MicroPython Handbook')
html = html.replace('เปลี่ยนพยากรณ์อากาศให้เป็นปัญญาประดิษฐ์อัตโนมัติ', 'ต้นแบบเครือข่ายฮาร์ดแวร์เพื่อการเกษตร (IoT Edge Rules)')
html = html.replace('Intelligent Climate Control System', 'Smart Farm Edge Control System')

# 2. Update JSON sources
html = html.replace('data/climate_sessions.json', 'data/iot_sessions.json')
html = html.replace('$climate_sessions', '$iot_sessions')

# 3. Swap main brand imagery
html = html.replace('assets/images/manual_cover_orange_1775878501210.png', 'assets/images/activities/iot_smart_sensor.png')
html = html.replace('assets/images/manual_interior_page_illustration_1775860235095.png', 'assets/images/activities/iot_orchard.png')

# 4. Color transformations for print layout (Ocean Blue instead of Orange)
html = html.replace('--primary: #d97706;', '--primary: #2563eb;')
html = html.replace('--accent: #f97316;', '--accent: #3b82f6;')
html = html.replace('--gold: #b45309;', '--gold: #1d4ed8;')
html = html.replace('--orange-soft: rgba(249, 115, 22, 0.1);', '--orange-soft: rgba(59, 130, 246, 0.1);')

# Write out new manual
with open('manual-iot-pocketbook.php', 'w', encoding='utf-8') as f:
    f.write(html)

print("✅ Successfully generated manual-iot-pocketbook.php")
