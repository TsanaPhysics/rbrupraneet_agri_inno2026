import json
import os

sessions = []

xr_images = [
    "assets/images/xr_sim_heat_stress_1775883976084.png",
    "assets/images/xr_sim_weather_api_1775883991320.png",
    "assets/images/xr_sim_data_timelapse_1775884006573.png",
    "assets/images/xr_sim_automated_irrigation_1775884023508.png"
]

# Session 1
sessions.append({
    "id": "session-1",
    "title": "ตัวแปรและข้อมูลฟาร์ม (Variables)",
    "desc": "สำหรับ ม.1 - ม.6: ปูพื้นฐานการเก็บข้อมูลเกษตรลงในหน่วยความจำของโปรแกรม",
    "xr_image": xr_images[0],
    "xr_caption": "XR Output: ตัวแปรทั้งหมดถูกฉายออกมาเป็นโฮโลแกรมเพื่อแสดงสถานะเริ่มต้นของฟาร์ม",
    "examples": [
        {
            "title": "Ex 1.1: Numeric Data - การนับจำนวนต้น",
            "code": "tree_count = 1500\nprint(f\"จำนวนทุเรียนทั้งหมด: {tree_count} ต้น\")"
        },
        {
            "title": "Ex 1.2: Float Data - ค่าอุณหภูมิความละเอียดสูง",
            "code": "current_temp = 32.54\nprint(f\"อุณหภูมิปัจจุบัน: {current_temp} องศาเซลเซียส\")"
        },
        {
            "title": "Ex 1.3: String - เปลี่ยนชื่อสายพันธุ์",
            "code": "# ให้นักเรียนลองเปลี่ยนชื่อจาก Monthong เป็นสายพันธุ์อื่น\nbreed = \"Monthong (หมอนทอง)\"\nprint(f\"โซน A ปลูกสายพันธุ์: {breed}\")"
        }
    ]
})

# Session 2
sessions.append({
    "id": "session-2",
    "title": "การคำนวณทางเกษตรศาสตร์ (Agri-Math)",
    "desc": "ใช้ Operators ของ Python มาช่วยคำนวณพื้นที่ ปริมาณปุ๋ย และการใช้น้ำ",
    "xr_image": xr_images[1],
    "xr_caption": "XR Output: 3D Mapping ประเมินพื้นที่และรัศมีการฉีดน้ำอัตโนมัติ",
    "examples": [
        {
            "title": "Ex 2.1: คำนวณความต้องการน้ำ",
            "code": "water_per_tree = 20.5  # ลิตร\ntree_count = 50\ntotal_water = water_per_tree * tree_count\nprint(f\"น้ำทั้งหมดที่ต้องการ: {total_water} ลิตร\")"
        },
        {
            "title": "Ex 2.2: คำนวณคาดการณ์ผลผลิต",
            "code": "yield_per_tree = 45 # ลูก\ntotal_yield = yield_per_tree * 150\nprint(f\"คาดการณ์ผลผลิต: {total_yield} ลูก\")"
        },
        {
            "title": "Ex 2.3: Modulo - การแบ่งโซนรดน้ำ",
            "code": "row_count = 14\nzone_split = row_count % 3\nprint(f\"ต้นไม้ที่เหลือจากจัดกลุ่มโซนละ 3 แถว: {zone_split}\")"
        }
    ]
})

# Session 3
sessions.append({
    "id": "session-3",
    "title": "สถาปัตยกรรมการตัดสินใจ (If-Else Logic)",
    "desc": "สอน AI ให้คิดแทนเรา ถ้าร้อนไป ทำยังไง? ถ้าชื้นไป ทำยังไง?",
    "xr_image": xr_images[0],
    "xr_caption": "XR Output: Thermal Simulation - โฮโลแกรมแจ้งจุดร้อนจัดสีแดง",
    "examples": [
        {
            "title": "Ex 3.1: พื้นฐาน If Condition",
            "code": "temp = 36.0\nif temp > 35:\n    print(\"🚨 ร้อนจัด! เสี่ยงใบไหม้\")"
        },
        {
            "title": "Ex 3.2: If-Else การวิเคราะห์ความชื้น",
            "code": "moisture = 40.5\nif moisture < 45:\n    print(\"เปิดระบบน้ำ\")\nelse:\n    print(\"ความชื้นเพียงพอ\")"
        },
        {
            "title": "Ex 3.3: Complex Logic (And/Or)",
            "code": "temp = 34.0\nhumidity = 85\nif temp > 32 and humidity > 80:\n    print(\"⚠️ เตือนภัยเชื้อรา และ แมลงปากดูด!\")"
        }
    ]
})

# Session 4
sessions.append({
    "id": "session-4",
    "title": "ข้อมูลแถวคอย (Lists & Arrays)",
    "desc": "จัดการเซ็นเซอร์ 100 ตัวพร้อมกันด้วย List",
    "xr_image": xr_images[2],
    "xr_caption": "XR Output: แผนผัง Array เซ็นเซอร์ลอยขึ้นมาในอากาศ",
    "examples": [
        {
            "title": "Ex 4.1: สร้าง Sensor Array",
            "code": "sensors = [\"Temp_01\", \"Hum_02\", \"Light_03\"]\nprint(f\"จำนวนเซ็นเซอร์: {len(sensors)}\")"
        },
        {
            "title": "Ex 4.2: การเข้าถึงข้อมูล (Indexing)",
            "code": "humidities = [60, 65, 40, 80]\n# ดึงข้อมูลโซนที่ 3 (Index 2)\nprint(f\"ความชื้นโซน C: {humidities[2]}%\")"
        },
        {
            "title": "Ex 4.3: การเพิ่มอุปกรณ์ใหม่ (Append)",
            "code": "devices = [\"Valve_1\", \"Valve_2\"]\ndevices.append(\"Valve_3_New\")\nprint(\"อุปกรณ์หลังติดตั้งใหม่:\", devices)"
        }
    ]
})

# Session 5
sessions.append({
    "id": "session-5",
    "title": "การทำงานซ้ำ (Loops in Agri)",
    "desc": "ล้างแค็ตตาล็อก หรือตรวจสอบทุกต้นด้วย Loops",
    "xr_image": xr_images[3],
    "xr_caption": "XR Output: ระบบวาล์วเปิดไล่ทีละโซน (Iteration Model)",
    "examples": [
        {
            "title": "Ex 5.1: For Loop แจ้งสถานะ",
            "code": "zones = [\"Zone A\", \"Zone B\", \"Zone C\"]\nfor zone in zones:\n    print(f\"Checking {zone}...\")"
        },
        {
            "title": "Ex 5.2: For Loop คำนวณค่ารวม",
            "code": "rain_week = [10, 0, 0, 5, 20, 0, 0] # มิลลิเมตร\ntotal = 0\nfor rain in rain_week:\n    total += rain\nprint(f\"ฝนรวม 7 วัน: {total} mm\")"
        },
        {
            "title": "Ex 5.3: While Loop จำลองการเติมน้ำ",
            "code": "tank_level = 0\nwhile tank_level < 3:\n    tank_level += 1\n    print(f\"กำลังสูบน้ำ... ระดับ {tank_level}/3\")\nprint(\"ถังเต็ม!\")"
        }
    ]
})

# Session 6
sessions.append({
    "id": "session-6",
    "title": "สร้างคำสั่งควบคุม (Functions)",
    "desc": "รวมชุดคำสั่งยาวๆ เป็นฟังก์ชันสั้นๆ ให้เรียกใช้ง่าย",
    "xr_image": xr_images[3],
    "xr_caption": "XR Output: Automation Blueprint แสดงการห่อหุ้มคำสั่งเป็นกล่องเดียว",
    "examples": [
        {
            "title": "Ex 6.1: Basic Def",
            "code": "def emergency_stop():\n    print(\"---🛑 ปิดวาล์วทั้งหมดฉุกเฉิน 🛑---\")\n\nemergency_stop()"
        },
        {
            "title": "Ex 6.2: Def พร้อมพารามิเตอร์",
            "code": "def spray(zone_name, minutes):\n    print(f\"เปิดพ่นหมอก {zone_name} เป็นเวลา {minutes} นาที\")\n\nspray(\"โซนป่าดิบ\", 10)"
        },
        {
            "title": "Ex 6.3: Def พร้อมค่า Return",
            "code": "def calc_heat_index(t, h):\n    return t + (0.05 * h)\n\nidx = calc_heat_index(33.0, 75)\nprint(f\"ดัชนีคำนวณได้: {idx:.1f}\")"
        }
    ]
})

# Session 7
sessions.append({
    "id": "session-7",
    "title": "ถอดรหัส Dictionary",
    "desc": "ก้าวแรกสู่การอ่าน JSON ที่มาจากส่วนกลาง",
    "xr_image": xr_images[2],
    "xr_caption": "XR Output: Hologram วิเคราะห์สถาปัตยกรรมข้อมูล JSON",
    "examples": [
        {
            "title": "Ex 7.1: สร้าง Dictionary",
            "code": "farm_data = {\"temp\": 34, \"hum\": 60}\nprint(\"อุณหภูมิ:\", farm_data[\"temp\"])"
        },
        {
            "title": "Ex 7.2: Dictionary ซ้อนทับ (Nested)",
            "code": "api_mock = {\"station\": \"Chanthaburi\", \"sensors\": {\"t1\": 32, \"t2\": 31}}\nprint(\"Temp Zone 1:\", api_mock[\"sensors\"][\"t1\"])"
        },
        {
            "title": "Ex 7.3: อัพเดทข้อมูลใหม่",
            "code": "state = {\"pump_A\": \"OFF\"}\nstate[\"pump_A\"] = \"ON\"\nprint(\"Current State:\", state)"
        }
    ]
})

# Session 8
sessions.append({
    "id": "session-8",
    "title": "API Cloud Connections",
    "desc": "พูดคุยกับเซิร์ฟเวอร์กรมอุตุนิยมวิทยาผ่าน Requests",
    "xr_image": xr_images[1],
    "xr_caption": "XR Output: Digital Twin รับข้อมูลฝนจำลองจากเครือข่าย",
    "examples": [
        {
            "title": "Ex 8.1: จำลองดึงข้อมูล (Mock Fetch)",
            "code": "# สมมติเราดึงข้อมูล JSON จาก Cloud\nlive_data = {\"rain_today\": 12.5, \"forecast\": \"Heavy Rain\"}\nprint(\"พยากรณ์:\", live_data[\"forecast\"])"
        },
        {
            "title": "Ex 8.2: การสกัดจุดข้อมูล (Extraction)",
            "code": "weather_api = {\"data\": {\"stations\": [{\"name\": \"Chanthaburi\", \"rain\": 45}]}}\nch_rain = weather_api[\"data\"][\"stations\"][0][\"rain\"]\nprint(f\"ฝนที่ตก: {ch_rain} mm\")"
        },
        {
            "title": "Ex 8.3: Action from API",
            "code": "rain_data = 30\nif rain_data > 20:\n    print(\"มีฝนตกหนัก ข้ามรอบการรดน้ำวันนี้ไปเลย\")"
        }
    ]
})

# Session 9
sessions.append({
    "id": "session-9",
    "title": "ข้อมูลระดับบิ๊กดาต้า (Pandas)",
    "desc": "เมื่อข้อมูลมีนับแสนบรรทัด Pandas คือคำตอบ",
    "xr_image": xr_images[2],
    "xr_caption": "XR Output: แถวข้อมูล Dataframe ลอยขึ้นเป็นมิติ",
    "examples": [
        {
            "title": "Ex 9.1: สร้าง DataFrame",
            "code": "import pandas as pd\ndata = {'Day': ['Mon', 'Tue', 'Wed'], 'Temp': [31, 33, 35]}\ndf = pd.DataFrame(data)\nprint(df)"
        },
        {
            "title": "Ex 9.2: ถอดค่าสถิติเบื้องต้น",
            "code": "import pandas as pd\ntemps = pd.Series([31, 33, 35, 36, 32])\nprint(f\"อุณหภูมิเฉลี่ย: {temps.mean()} C\")\nprint(f\"ร้อนสุดในรอบสัปดาห์: {temps.max()} C\")"
        },
        {
            "title": "Ex 9.3: Filtering กรองวันวิกฤต",
            "code": "import pandas as pd\ndf = pd.DataFrame({'Temp': [31, 36, 30, 37]})\nhot_days = df[df['Temp'] > 35]\nprint(\"วันที่ร้อนจัด:\\n\", hot_days)"
        }
    ]
})

# Session 10
sessions.append({
    "id": "session-10",
    "title": "Data Forensics (หาสิ่งผิดปกติ)",
    "desc": "วิเคราะห์หาปีหรือเดือนที่เกิดปรากฏการณ์ความร้อนผิดปกติ",
    "xr_image": xr_images[2],
    "xr_caption": "XR Output: 3D Mapping Anomaly Detection",
    "examples": [
        {
            "title": "Ex 10.1: การไล่เรียงข้อมูล (Sorting)",
            "code": "import pandas as pd\ndf = pd.DataFrame({'Yr': [2020, 2021], 'Rain': [1500, 800]})\nprint(df.sort_values(by='Rain'))"
        },
        {
            "title": "Ex 10.2: Moving Average",
            "code": "import pandas as pd\ndaily_rain = pd.Series([0, 10, 50, 0, 0, 0, 30])\n# ค้นหาค่าเฉลี่ย 3 วัน\nprint(daily_rain.rolling(window=3).mean())"
        },
        {
            "title": "Ex 10.3: ค้นหาจุดต่ำสุด",
            "code": "import pandas as pd\ndf = pd.DataFrame({'Yr': [2021,2022], 'Yield': [12000, 4500]})\ncrisis_yr = df[df['Yield'] == df['Yield'].min()]\nprint(\"ปีที่วิกฤตผลผลิต:\\n\", crisis_yr)"
        }
    ]
})

# Session 11
sessions.append({
    "id": "session-11",
    "title": "สร้างกราฟแสดงทัศนวิสัย (Visualization)",
    "desc": "แปลข้อมูลตัวเลขที่น่าเบื่อ ให้เป็นกราฟที่ CEO อ่านออก",
    "xr_image": xr_images[1],
    "xr_caption": "XR Output: Holographic Charts and Visuals",
    "examples": [
        {
            "title": "Ex 11.1: Line Plot (สายเวลา)",
            "code": "import matplotlib.pyplot as plt\nplt.plot([1,2,3], [32, 33, 35], color='orange')\nplt.title(\"Temperature Trend\")\n# plt.show()"
        },
        {
            "title": "Ex 11.2: Bar Chart (เปรียบเทียบ)",
            "code": "import matplotlib.pyplot as plt\nplt.bar(['Zone A', 'Zone B'], [150, 90])\nplt.title(\"Yield by Zone\")\n# plt.show()"
        },
        {
            "title": "Ex 11.3: Dark Mode Customization",
            "code": "import matplotlib.pyplot as plt\nplt.style.use('dark_background')\nplt.plot([2020, 2021], [1500, 1100], color='#f97316')\n# plt.show()"
        }
    ]
})

# Session 12
sessions.append({
    "id": "session-12",
    "title": "Capstone: RBRU AI DSS",
    "desc": "ระบบสมองกลเกษตรรวมตรรกะ แจ้งเตือน อัตโนมัติ",
    "xr_image": xr_images[3],
    "xr_caption": "XR Output: จักรกลวาล์วที่ตอบสนองต่อโค้ดบรรทัดสุดท้ายแบบทันที",
    "examples": [
        {
            "title": "Ex 12.1: Master Logic Function",
            "code": "def dss_engine(t, h):\n    if t > 35 and h < 40:\n        return \"START_MISTING\"\n    return \"IDLE\"\n\nprint(dss_engine(36, 30))"
        },
        {
            "title": "Ex 12.2: Loop Tracking",
            "code": "farm_data = [{'t': 36, 'h': 35}, {'t': 28, 'h': 60}]\nfor reading in farm_data:\n    action = dss_engine(reading['t'], reading['h'])\n    print(f\"Action Executed: {action}\")"
        },
        {
            "title": "Ex 12.3: Final System Output",
            "code": "# ระบบจำลองสถานการณ์แจ้งเตือนเข้าสู่หน้า Dashboard หลัก\nfinal_status = \"--- ALL SYSTEMS NORMAL ---\"\nprint(final_status)"
        }
    ]
})

data_str = json.dumps(sessions, indent=4, ensure_ascii=False)
with open('/Applications/XAMPP/xamppfiles/htdocs/rbrupraneet_agri_inno2026/data/climate_sessions.json', 'w', encoding='utf-8') as f:
    f.write(data_str)

print(f"✅ Generated {len(sessions)} sessions and saved to data/climate_sessions.json")
