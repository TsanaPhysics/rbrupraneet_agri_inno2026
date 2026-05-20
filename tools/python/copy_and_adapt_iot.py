import re

print("Starting structural transfer from climate structure to IoT...")

# 1. Read climate template
with open('workshop-climate.php', 'r', encoding='utf-8') as f:
    html = f.read()

# 2. Modify Hero Texts & Paths
html = html.replace('Climate Data Hacking | IDEA Center Workshop', 'AI-IoT Prototyping | IDEA Center Workshop')
html = html.replace('Climate Data Hacking', 'AI-IoT Prototyping Lab')
html = html.replace('เปลี่ยนพยากรณ์อากาศให้เป็นปัญญาประดิษฐ์ (Interactive Dashboard)', 'กิจกรรมที่ 3: การสร้างต้นแบบเซ็นเซอร์อัจฉริยะ (Edge Computing Dashboard)')
html = html.replace('manual-pocketbook.php', 'manual-iot-pocketbook.php')

# Change images
html = html.replace('url(\'assets/images/manual_cover_orange_1775878501210.png\')', 'url(\'assets/images/activities/iot_smart_sensor.png\')')

# Change JSON loaders
html = html.replace('data/climate_sessions.json', 'data/iot_sessions.json')
html = html.replace('$climate_sessions', '$iot_sessions')
html = html.replace('climate_starter.py', 'iot_sensor_hub.py')
html = html.replace('rbru_climate_master.py', 'rbru_iot_master.py')
html = html.replace('chanthaburi_climate_sample.csv', 'mqtt_payload_samples.json')
html = html.replace('DATASET (.CSV)', 'MQTT LOG (.JSON)')
html = html.replace('Starter Script', 'ESP32 Starter')

# Change specific colors to Ocean Blue to fit IoT vibe
# Orange -> Blue
html = html.replace('--workshop-accent: #f97316;', '--workshop-accent: #3b82f6;')
html = html.replace('--workshop-amber: #fbbf24;', '--workshop-amber: #60a5fa;')
html = html.replace('--workshop-gold: #d97706;', '--workshop-gold: #2563eb;')
html = html.replace('--workshop-soft: rgba(249, 115, 22, 0.05);', '--workshop-soft: rgba(59, 130, 246, 0.05);')
html = html.replace('rgba(249, 115, 22, 0.2)', 'rgba(59, 130, 246, 0.2)')
html = html.replace('rgba(249, 115, 22, 0.5)', 'rgba(59, 130, 246, 0.5)')
html = html.replace('rgba(249, 115, 22, 0.3)', 'rgba(59, 130, 246, 0.3)')
html = html.replace('rgba(249, 115, 22, 0.4)', 'rgba(59, 130, 246, 0.4)')
html = html.replace('rgba(249, 115, 22, 0.05)', 'rgba(59, 130, 246, 0.05)')
html = html.replace('rgba(249, 115, 22, 0.15)', 'rgba(59, 130, 246, 0.15)')

# 3. Write to workshop-iot.php
with open('workshop-iot.php', 'w', encoding='utf-8') as f:
    f.write(html)

print("✅ Successfully adapted workshop-iot.php using the climate template.")
