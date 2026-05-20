"""
=========================================================
🔥 RBRU 12-Hour Climate Hacking Masterclass: Full Code 🔥
=========================================================
บทสรุปโค้ดรวม (Master Script): นำทุกองค์ประกอบตั้งแต่ 
Variables, API Fetch, Pandas, และ AI DSS มารวมเป็นระบบเดียว
"""

import requests
import pandas as pd
import matplotlib.pyplot as plt

# ---------------------------------------------
# [Session 1 & 4] ตั้งค่าข้อมูลฟาร์ม (Farm Arrays & Variables)
# ---------------------------------------------
FARM_ZONES = ["Zone_A", "Zone_B", "Zone_C"]
SOIL_MOISTURE_CRITICAL = 30.0
TEMP_CRITICAL = 35.0

print(f"✅ Booting RBRU DSS System... Managing {len(FARM_ZONES)} Zones.")

# ---------------------------------------------
# [Session 8] ฟังก์ชันจำลองดึงข้อมูลจาก API
# ---------------------------------------------
def fetch_weather_api():
    print("📡 Fetching Live Data from TMD Network...")
    # ในสภาวะจริง ใช้: requests.get('url').json()
    return {
        "status": "Success",
        "station": "Chanthaburi",
        "temperature": 36.5,
        "humidity": 88,
        "rainfall_24h": 0.0
    }

# ---------------------------------------------
# [Session 9 & 10] การวิเคราะห์ข้อมูล 10 ปี (Pandas Forensics)
# ---------------------------------------------
def load_and_analyze_history():
    print("📂 Loading Big Data History for Trend Analysis...")
    # สร้าง DataFrame จำลองจากข้อมูลในอดีตเพื่อใช้เทียบเคียงสถานการณ์ปัจจุบัน
    data = {
        'Date': ['2026-05-01', '2026-05-02', '2026-05-03'],
        'Rainfall': [0, 50, 10],
        'Max_Temp': [35.5, 30.2, 36.8]
    }
    df = pd.DataFrame(data)
    
    # Session 10: หา Moving Average
    df['Temp_Trend'] = df['Max_Temp'].rolling(window=2, min_periods=1).mean()
    print("📊 ข้อมูลแนวโน้มสัปดาห์นี้:")
    print(df[['Date', 'Max_Temp', 'Temp_Trend']])
    return df

# ---------------------------------------------
# [Session 3, 6 & 12] สถาปัตยกรรม DSS (If-Else & Functions)
# ---------------------------------------------
def dss_logic_engine(temp, humidity, rain, zone_id):
    """ฟังก์ชันสมองกลตัดสินใจ (Decision Support System)"""
    action = None
    
    if temp > TEMP_CRITICAL and rain < 5.0:
        action = f"🚨 แจ้งเตือน: สั่งเปิดวาล์วน้ำหลักโซน {zone_id} ดับร้อนด่วน!"
    elif 25 <= temp <= 28 and humidity > 90:
        action = f"⚠️ ระวังเชื้อรา: สั่งโดรนบินตรวจสอบใบโซน {zone_id}"
    else:
        action = f"✅ สถานะปกติ: ต้นไม้ใน {zone_id} เติบโตได้ดี"
    
    return action

# ---------------------------------------------
# [Session 5 & 12] วงจรการทำงานหลัก (Main Loop)
# ---------------------------------------------
def run_master_system():
    print("\n" + "="*50)
    print("🚀 เริ่มต้นเดินเครื่องระบบฟาร์มอัจฉริยะ (AUTO-MODE)")
    print("="*50)
    
    # 1. โหลดข้อมูลสถิติ
    history_df = load_and_analyze_history()
    
    # 2. ดึงข้อมูลสดจากเซ็นเซอร์ / API
    live_weather = fetch_weather_api()
    t = live_weather['temperature']
    h = live_weather['humidity']
    r = live_weather['rainfall_24h']
    
    print(f"\n[Live API] อุณหภูมิ: {t}°C | ความชื้น: {h}% | ฝน: {r}mm")
    
    # 3. ลูปตรวจสอบและสั่งงานทุกโซน
    print("\n--- 🤖 AI DSS Execution ---")
    for zone in FARM_ZONES:
        decision = dss_logic_engine(t, h, r, zone)
        print(f"[{zone}]: {decision}")

    print("\n" + "="*50)
    print("✨ รันโค้ดประมวลผลทั้งฟาร์มเรียบร้อย ✨")

# Trigger the System
if __name__ == "__main__":
    run_master_system()
