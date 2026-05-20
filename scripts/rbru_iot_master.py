"""
=========================================================
⚡ RBRU AI-IoT Edge Node: Full Master Code 🌐
=========================================================
บทสรุปโค้ดรวม (IoT Master Script): สมองกลไมโครไพธอนสำหรับบอร์ด ESP32
ครอบคลุมเซ็นเซอร์, ตรรกะตัดสินใจ, Wi-Fi, MQTT, และโหมดจำศีล
"""

import machine
from machine import Pin, ADC
import time
import network
import ujson
from umqtt.simple import MQTTClient

# ---------------------------------------------
# 1. การตั้งค่าฮาร์ดแวร์พื้นฐาน (Session 1-4)
# ---------------------------------------------
print("🚀 บูทระบบไร้สาย RBRU Edge Node")

# ตั้งค่าเซ็นเซอร์ความชื้นในดินและปั๊มน้ำ
soil_sensor = ADC(Pin(34))
soil_sensor.atten(ADC.ATTN_11DB) # อ่านกระแสสูงสุด 3.3v

pump_relay = Pin(23, Pin.OUT)
pump_relay.value(1) # เริ่มต้นปิดปั๊มไว้ก่อน (Active Low)

def read_moisture():
    # แปลงเลข 0-4095 เป็นสเกลเปอร์เซ็นต์
    raw = soil_sensor.read()
    moisture = (raw / 4095.0) * 100
    return round(moisture, 1)

# ---------------------------------------------
# 2. การเชื่อมต่อเครือข่ายและระบบรักษาความปลอดภัย (Session 5-7)
# ---------------------------------------------
SSID = 'RBRU_Agri_Lab'
PASSWORD = 'secret_agri_pwd'
MQTT_BROKER = 'broker.hivemq.com'
CLIENT_ID = 'rbru_edge_node_42'

def connect_network():
    print("📡 กำลังเชื่อมต่อ Wi-Fi...")
    wlan = network.WLAN(network.STA_IF)
    wlan.active(True)
    if not wlan.isconnected():
        wlan.connect(SSID, PASSWORD)
        # จำลองเวลารอเชื่อมต่อ
        time.sleep(1)
    print("✅ เครือข่ายพร้อมใช้งาน IP:", wlan.ifconfig()[0])
    return wlan

# ---------------------------------------------
# 3. ลอจิกไร้สายตัดสินใจหน้างาน (Edge Rules - Session 11)
# ---------------------------------------------
def run_edge_logic(moisture):
    if moisture < 30:
        print("⚠️ ดินแห้งสาหัส: Edge AI สั่งเปิดวาล์วน้ำ 5 วินาที!")
        pump_relay.value(0)
        time.sleep(5)
        pump_relay.value(1)
        return "IRRIGATED"
    elif moisture > 80:
        print("💧 ดินแฉะเกินไป: ระงับการรดน้ำ เพื่อป้องกันเชื้อราที่รากพืช")
        return "HALTED_TOO_WET"
    else:
        print("🟢 ดินอยู่ในสภาวะสมบูรณ์")
        return "OPTIMAL"

# ---------------------------------------------
# 4. วัฏจักรหลัก (The Digital Twin Capstone - Session 12)
# ---------------------------------------------
def run_master_cycle():
    # 1. ต่ออินเทอร์เน็ต
    wlan = connect_network()
    
    # 2. อ่านค่าเซ็นเซอร์
    current_moisture = read_moisture()
    print(f"📊 ตรวจพบความชื้น: {current_moisture}%")
    
    # 3. ตัดสินใจรดน้ำ (Edge Logic)
    action_taken = run_edge_logic(current_moisture)
    
    # 4. ส่งข้อมูลรายงาน Cloud Database (Telemetry)
    try:
        print("☁️ กำลังซิงค์ข้อมูลขึ้น Digital Twin Server...")
        client = MQTTClient(CLIENT_ID, MQTT_BROKER)
        client.connect()
        
        payload = ujson.dumps({
            "node_id": CLIENT_ID,
            "moisture": current_moisture,
            "system_status": action_taken,
            "timestamp": time.ticks_ms()
        })
        
        client.publish(b'rbru/orchard/data', payload.encode())
        print("📤 เผยแพร่ข้อมูลสำเร็จ! (Published)")
        client.disconnect()
        
    except Exception as e:
        print("❌ เกิดข้อผิดพลาดด้านเครือข่าย:", e)
    
    # 5. ประหยัดพลังงานระดับอุตสาหกรรม (Deep Sleep - Session 10)
    minutes_to_sleep = 10
    print(f"💤 ภารกิจรอบลูปนี้ลุล่วง... กำลังปิดระบบจำศีลเป็นเวลา {minutes_to_sleep} นาทีเพื่อรักษาแบตเตอรี่")
    
    # Uncomment บรรทัดด้านล่างเพื่อบังคับเครื่องเข้าสู่โหมดหลับลึกจริงๆ
    # machine.deepsleep(minutes_to_sleep * 60 * 1000)

if __name__ == "__main__":
    run_master_cycle()
