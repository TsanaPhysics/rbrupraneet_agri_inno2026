import json
import requests
import os

# Configuration
OLLAMA_API = "http://localhost:11434/api/generate"
MODEL_NAME = "gemma3:4b"  # User has this model installed
DATABASE_PATH = "storage/database/soil_readings.json"

def calculate_status(value, low, high):
    if value < low: return "ต่ำ (Low)"
    if value > high: return "สูง (High)"
    return "เหมาะสม (Optimal)"

def analyze_soil(zone_data):
    reading = zone_data['readings']
    # Basic logic for calculation
    n_status = calculate_status(reading['nitrogen'], 15, 25)
    p_status = calculate_status(reading['phosphorus'], 10, 20)
    k_status = calculate_status(reading['potassium'], 20, 30)
    ph_status = calculate_status(reading['ph'], 5.5, 6.5)

    summary = (f"Zone: {zone_data['zone']}\n"
               f"- Nitrogen: {reading['nitrogen']} ({n_status})\n"
               f"- Phosphorus: {reading['phosphorus']} ({p_status})\n"
               f"- Potassium: {reading['potassium']} ({k_status})\n"
               f"- pH Level: {reading['ph']} ({ph_status})\n")
    
    return summary

def get_ai_recommendation(soil_summary):
    prompt = f"""
    คุณคือผู้เชี่ยวชาญด้านดินโครงการ RBRU-Praneet สวนทุเรียนจันทบุรี
    จากข้อมูลวิเคราะห์ดินด้านล่างนี้ ช่วยให้คำแนะนำสั้นๆ 3 ข้อในการปรับปรุงดินและการให้ปุ๋ย:
    
    {soil_summary}
    
    คำแนะนำ (ภาษาไทย):
    """
    
    try:
        response = requests.post(OLLAMA_API, json={
            "model": MODEL_NAME,
            "prompt": prompt,
            "stream": False
        }, timeout=30)
        
        if response.status_code == 200:
            return response.json().get('response', 'ไม่สามารถขอคำแนะนำจาก AI ได้')
        return f"Error: {response.status_code}"
    except Exception as e:
        return f"Connection Error: {e}"

def main():
    if not os.path.exists(DATABASE_PATH):
        print(f"Error: {DATABASE_PATH} not found.")
        return

    with open(DATABASE_PATH, 'r', encoding='utf-8') as f:
        data = json.load(f)

    print("--- 🔬 RBRU Soil AI Analyst System 🔬 ---")
    for zone_data in data:
        print(f"\n📍 เข้าถึงข้อมูลโซน: {zone_data['zone']}")
        summary = analyze_soil(zone_data)
        print(summary)
        
        print("🤖 กำลังขอคำแนะนำจาก Local AI (Gemma 3)...")
        recommendation = get_ai_recommendation(summary)
        print(f"\n💡 คำแนะนำแม่นยำสูง:\n{recommendation}")
        print("-" * 50)

if __name__ == "__main__":
    main()
