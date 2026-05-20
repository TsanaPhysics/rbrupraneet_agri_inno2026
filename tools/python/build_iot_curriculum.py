import json
import os

iot_sessions = [
    # Phase A: ฮาร์ดแวร์และการรับรู้
    {
        "id": "iot-session-1",
        "title": "สถาปัตยกรรม ESP32 (GPIO)",
        "desc": "เริ่มต้นทำความรู้จักกับบอร์ดไมโครคอนโทรลเลอร์ ESP32 สมองกลหลักของการทำ IoT เกษตรอัจฉริยะ",
        "xr_image": "assets/images/activities/iot_smart_sensor.png",
        "xr_caption": "XR Simulator: โฮโลแกรม 3 มิติแสดงโครงสร้างภายในของชิป ESP32",
        "examples": [
            {
                "title": "Blink: ใจเต้นจังหวะแรก",
                "code": "from machine import Pin\nimport time\n\n# กำหนดขา 2 เป็นขาออกไปยังหลอดไฟ LED บนบอร์ด\nled = Pin(2, Pin.OUT)\n\nwhile True:\n    led.value(not led.value()) # สลับสถานะ\n    time.sleep(0.5) # พักเครื่อง 0.5 วินาที"
            },
            {
                "title": "รับค่าสัญญาณ (Digital Input)",
                "code": "# จำลองการรับสัญญาณจากสวิตซ์หรือเซ็นเซอร์ใบพัดน้ำ\nbutton = Pin(0, Pin.IN, Pin.PULL_UP)\n\nif button.value() == 0:\n    print('🚨 มีการกดปุ่มฉุกเฉินปิดวาล์วน้ำ!')\nelse:\n    print('✅ ระบบทำงานตามปกติ')"
            },
            {
                "title": "ควบคุมไฟฉายไล่แมลง (PWM)",
                "code": "from machine import PWM\n\n# ใช้ Pulse Width Modulation เพื่อหรี่แสง\nlight = PWM(Pin(4), freq=1000)\nlight.duty(512) # ปรับความสว่างที่ 50% (0-1023)\nprint('เปิดไฟความสว่าง 50% แล้ว')"
            }
        ]
    },
    {
        "id": "iot-session-2",
        "title": "สัญญาณแอนะล็อกและดิจิทัล (A/D)",
        "desc": "ธรรมชาติเป็นคลื่นที่ต่อเนื่อง (Analog) แต่คอมพิวเตอร์เข้าใจแค่ 0 กับ 1 (Digital) เรียนรู้วิธีเปลี่ยนคลื่นธรรมชาติให้เป็นตัวเลข",
        "xr_image": "assets/images/activities/iot_orchard.png",
        "xr_caption": "Signal Visualizer: กราฟิกจำลองการจับสัญญาณความต้านทานไฟฟ้าผ่านดินในสวน 3D",
        "examples": [
            {
                "title": "ตั้งโปรแกรมช่องอ่าน Analog (ADC)",
                "code": "from machine import ADC\n\n# เปิดใช้งานวงจรแปลงสัญญาณที่ขา 34\nsoil_sensor = ADC(Pin(34))\nsoil_sensor.atten(ADC.ATTN_11DB) # ปรับจูนให้รองรับไฟสูงสุด 3.3V\nprint('พอร์ต ADC ขา 34 พร้อมรับสัญญาณธรรมชาติ...')"
            },
            {
                "title": "การอ่านค่าดิบ (Raw Values)",
                "code": "# ESP32 จะแบ่งกระแสไฟแอนะล็อกเป็นสเกล 0-4095 (12-bit)\nraw_value = soil_sensor.read()\nprint(f'💻 คอมพิวเตอร์อ่านกระแสไฟได้รหัส: {raw_value}')\n# ยิ่งดินแฉะ กระแสไฟยิ่งไหลผ่านได้ดี ตัวเลขยิ่งมาก!"
            },
            {
                "title": "แปลงรหัสหยาบสู่เปอร์เซ็นต์ (Map Function)",
                "code": "def map_percent(val, in_min, in_max):\n    # สเกล 0-4095 แปลงเป็น 0-100%\n    return (val - in_min) * 100 / (in_max - in_min)\n\nmoisture = map_percent(raw_value, 0, 4095)\nprint(f'💧 ความชื้นสัมพัทธ์ในดิน: {moisture:.1f}%')"
            }
        ]
    },
    {
        "id": "iot-session-3",
        "title": "เซ็นเซอร์สภาพแวดล้อม (I2C Sensors)",
        "desc": "การดึงข้อมูลจากชิปเซ็นเซอร์ดิจิทัลอัจฉริยะ (เช่น DHT หรือ BME280) ที่คุยกันเป็นภาษาซีเรียล I2C",
        "xr_image": "assets/images/pillar_iot.png",
        "xr_caption": "I2C Blueprint: แสดงผังการเดินสาย SDA และ SCL ไปยังวงจรต่างๆ",
        "examples": [
            {
                "title": "แสกนหาอุปกรณ์บน I2C (Bus Scan)",
                "code": "from machine import I2C\n\n# เปิด Bus หมายเลข 0 ด้วยความเร็ว 400kHz\ni2c = I2C(0, scl=Pin(22), sda=Pin(21), freq=400000)\n\n# สแกนหาที่อยู่ (Address) ของเซ็นเซอร์ในสาย\ndevices = i2c.scan()\nprint('พบอุปกรณ์ที่ตำแหน่ง:', [hex(d) for d in devices])"
            },
            {
                "title": "อ่านค่าอุณหภูมิดิจิทัล (DHT)",
                "code": "import dht\n\nsensor_th = dht.DHT22(Pin(15))\nsensor_th.measure() # สั่งให้ชิปทำงาน 1 รอบ\n\ntemp = sensor_th.temperature()\nhumid = sensor_th.humidity()\nprint(f'🌡️ อากาศ: {temp}°C | 💦 ความชื้นลม: {humid}%')"
            },
            {
                "title": "คำนวณ Heat Index",
                "code": "# ดัชนีความร้อน คืออุณหภูมิที่ต้นไม้ 'รู้สึก' จริงๆ\nheat_index = temp + (0.5555 * (humid - 10.0))\nprint(f'⚠️ พืชกำลังแบกรับความร้อนที่สัมผัสได้: {heat_index:.1f}°C')"
            }
        ]
    },
    {
        "id": "iot-session-4",
        "title": "จอแสดงผลกลางสวน (OLED I2C)",
        "desc": "เพิ่มหน้าจอให้โมดูล เพื่อให้เกษตรกรสามารถเดินมาดูค่าหน้ากล่องได้โดยไม่ต้องใช้สมาร์ทโฟน",
        "xr_image": "assets/images/activities/tech_showcase.png",
        "xr_caption": "OLED Projection: จำลองหน้าจอโปร่งใสในอากาศแบบไซไฟ",
        "examples": [
            {
                "title": "เริ่มต้นหน้าจอ SSD1306",
                "code": "import ssd1306\n\n# เซ็ตอัพจอขนาด 128x64 พิกเซล\ndisplay = ssd1306.SSD1306_I2C(128, 64, i2c)\ndisplay.fill(0) # ล้างจอ (0 = จอดำ, 1 = พิกเซลสว่าง)\nprint('✅ OLED Boot Complete!')"
            },
            {
                "title": "พิมพ์ข้อความและตัวแปร",
                "code": "# ระบุตำแหน่ง (X, Y) เพื่อวาดข้อความ\ndisplay.text('RBRU Agri-Node', 10, 0)\ndisplay.text(f'Temp: {temp} C', 10, 20)\ndisplay.text(f'Moisture: 75%', 10, 40)\n\n# สั่งส่งข้อมูลจาก RAM ขึ้นไปแสดงผลจริง\ndisplay.show()"
            },
            {
                "title": "วาดกราฟิกสถานะแทงก์น้ำ",
                "code": "# วาดกรอบสี่เหลี่ยมแทนถังน้ำ (x, y, w, h, สลับสี)\ndisplay.rect(100, 10, 20, 50, 1)\n# เติมพิกเซลความสูงตามระดับน้ำจริง\ndisplay.fill_rect(100, 30, 20, 30, 1) \ndisplay.show()"
            }
        ]
    },
    
    # Phase B: เครือข่ายไร้พรมแดน
    {
        "id": "iot-session-5",
        "title": "เชื่อมต่อโลกผ่าน Wi-Fi (Networking)",
        "desc": "การปลดล็อกศักยภาพ ESP32 ให้พูดคุยสื่อสารกับเราท์เตอร์ Wi-Fi เพื่อก้าวข้ามข้อจำกัดด้านพื้นที่",
        "xr_image": "assets/images/activities/iot_smart_sensor.png",
        "xr_caption": "Wireless Vis: เส้นพลังงานเรืองแสงเชื่อมต่อจากต้นไม้ขึ้นเสา 5G",
        "examples": [
            {
                "title": "เปิดโหมด Station",
                "code": "import network\n\n# ตั้งค่าเสาอากาศบอร์ดให้เป็นโหมดผู้รับ (Station) ไม่ใช่ตัวกระจายสัญญาณ (AP)\nwlan = network.WLAN(network.STA_IF)\nwlan.active(True)\nprint('📡 เสาอากาศ Wi-Fi พร้อมใช้งาน')"
            },
            {
                "title": "เชื่อมต่อคลื่น SSID",
                "code": "# ป้อนชื่อและรหัสผ่าน Wi-Fi ของศูนย์วิจัย\nwlan.connect('RBRU_Agri_Lab', 'secret2026')\n\nwhile not wlan.isconnected():\n    pass # รอจนกว่าโปรโตคอลการจับมือ (Handshake) จะสำเร็จ\nprint('✅ เชื่อมต่อ Wi-Fi เรียบร้อย!')"
            },
            {
                "title": "ตรวจสอบ IP Address",
                "code": "# ขอตรวจสอบตั๋ว IP จาก Router\nstatus = wlan.ifconfig()\nprint('🌐 IP ประจำตัวของเครื่องนี้คือ:', status[0])\nprint('เส้นทาง Gateway ขาออกคือ:', status[2])"
            }
        ]
    },
    {
        "id": "iot-session-6",
        "title": "โปรโตคอลเพื่อการเกษตร (MQTT 101)",
        "desc": "ทำไมเราไม่ใช้ HTTP แบบเว็บแอป? เพราะ MQTT ออกแบบมาเพื่ออุปกรณ์ขนาดเล็ก ส่งข้อมูลข้ามทวีปได้ไวและกินแบนด์วิธต่ำมาก",
        "xr_image": "assets/images/cloud_lab.png",
        "xr_caption": "MQTT Broker: แบบจำลองศูนย์ท่อส่งข้อมูลแมงมุมเชื่อมต่อไปยังทุกดีไวซ์",
        "examples": [
            {
                "title": "สร้างตัวตนลงทะเบียน Cloud",
                "code": "from umqtt.simple import MQTTClient\nimport ubinascii\nimport machine\n\n# ดึงรหัสประจำตัวฮาร์ดแวร์ที่ไม่ซ้ำกันในโลก\nCLIENT_ID = ubinascii.hexlify(machine.unique_id())\nBROKER_IP = 'broker.hivemq.com'\n\nclient = MQTTClient(CLIENT_ID, BROKER_IP)\nclient.connect()\nprint('🔗 ผูกวิญญาณเข้ากับศูนย์สั่งการคลาวด์สำเร็จแล้ว!')"
            },
            {
                "title": "สร้างท่อข้อมูล (Publish Topic)",
                "code": "import json\n\n# แพ็คเกจข้อมูลตัวแปรให้อยู่ในรูป JSON String\npayload = json.dumps({'zone': 'A1', 'temp': 32.5, 'water_status': 'ON'})\n\n# สาดข้อมูลลงไปที่หัวข้อ 'rbru/farm/status'\nclient.publish(b'rbru/farm/status', payload.encode())\nprint('📤 โยนข้อมูลขึ้นไปลอยเหนืออากาศแล้ว')"
            },
            {
                "title": "ตั้งตารอคำสั่ง (Subscribe)",
                "code": "def on_message_received(topic, msg):\n    print(f'📩 มีโทรจิตส่งมาจากคลาวด์หัวข้อ {topic}: คำสั่ง {msg}')\n    \nclient.set_callback(on_message_received)\n# สมัครรอรับข่าวสารเฉพาะรหัสต้นไม้ของเรา\nclient.subscribe(b'rbru/farm/cmd/node1')\nprint('🎧 กำลังดักฟังคำสั่งบนคลาวด์...')"
            }
        ]
    },
    {
        "id": "iot-session-7",
        "title": "รักษาความลับการค้า (IoT Edge Security)",
        "desc": "ข้อมูลสภาพอากาศและเทคนิคการรดน้ำของคุณคือความลับของฟาร์ม! เรียนรู้วิธีเข้ารหัสลับเพื่อป้องกันโจรสลัดไซเบอร์",
        "xr_image": "assets/images/activities/tech_showcase.png",
        "xr_caption": "Cyber Security: กริดสีน้ำเงินสะท้อนโล่ป้องกันมัลแวร์",
        "examples": [
            {
                "title": "เข้ารหัสเซ็นเซอร์ (Hashing)",
                "code": "import uhashlib\nimport ubinascii\n\ndata_str = 'pump:on,secret:1234'\n# ปั่นพาสเวิร์ดให้กลายเป็นรหัสยาวๆ หมุนย้อนกลับไม่ได้\nhash_obj = uhashlib.sha256(data_str.encode())\nencrypted = ubinascii.hexlify(hash_obj.digest())\n\nprint(f'🔐 รหัสตู้เซฟที่คนอื่นอ่านไม่ออก: {encrypted}')"
            },
            {
                "title": "การตรวจสอบลายเซ็น (Digital Signature)",
                "code": "# เมื่อเซิร์ฟเวอร์ได้รับระบบ จะแนบลายเซ็นมาเทียบเคียงแบบสมมาตร\nexpected_signature = b'a5f8...'\nif encrypted == expected_signature:\n    print('✅ คำสั่งนี้ของแท้ สั่งให้ปั๊มน้ำทำงาน!')\nelse:\n    print('❌ แจ้งเตือน: มีการปลอมแปลงคำสั่ง!')"
            },
            {
                "title": "การจัดการตัวแปรลับ (Secrets.py)",
                "code": "# แยกไฟล์รหัสผ่านออกไปจากไฟล์ main.py เพื่อป้องกันความคุ้นชิน\n# ให้สร้างไฟล์ใหม่ชื่อ secrets.py และนำไปเก็บซ่อนในบอร์ด \nimport secrets \nprint('ตู้เซฟถูกเปิดโดยไฟล์ที่ซ่อนอยู่ Password_DB:', secrets.WIFI_PASS)"
            }
        ]
    },
    {
        "id": "iot-session-8",
        "title": "ศูนย์บัญชาการสด (Telemetry Streams)",
        "desc": "ก้าวข้ามการส่งข้อความทีละรอบ ไปสู่มิดเดิลแวร์การส่ง Data Stream ความเร็วสูงรายวินาที เพื่อป้อนให้กับโมเดล AI ในอนาคต",
        "xr_image": "assets/images/activities/iot_orchard.png",
        "xr_caption": "Stream Pipeline: ท่อไฟเบอร์จำลองลำเลียงพิกเซลสีน้ำเงินลอยขึ้นจรดคลาวด์",
        "examples": [
            {
                "title": "ออกแบบโครงข่ายวินาที (Tick Loop)",
                "code": "import time\n\n# ใช้ Time Ticks เพื่อไม่ให้โค้ดค้าง (Non-blocking delay)\nlast_tick = time.ticks_ms()\n\nwhile True:\n    now = time.ticks_ms()\n    if time.ticks_diff(now, last_tick) > 5000: # 5 วินาที\n        print('🔄 ส่ง Telemetry ก้อนใหม่เสร็จสิ้น')\n        last_tick = now\n    \n    # เซ็นเซอร์อื่นๆ และระบบรับคำสั่ง ยังสามารถทำงานต่อไปได้ไม่โดนบล็อก"
            },
            {
                "title": "แพ็คเกจแบบโครงข่ายใหญ่ (Bulk Matrix)",
                "code": "# แทนที่จะส่งทีละเส้น ให้รวม 10 ค่าล่าสุดในอาร์เรย์แล้วส่งทีเดียว\nbulk_data = {'temperature_history': [32.1, 32.2, 32.5, 33.0, 33.1]}\npack = json.dumps(bulk_data)\nprint('📦 เตรียมส่งชุดข้อมูลระดับ Big Data ย่อย 1 ก้อน:', pack)"
            },
            {
                "title": "ตัดการเชื่อมต่อเพื่อป้องระบบรวน (Graceful Exit)",
                "code": "try:\n    # ..loop logic..\n    pass\nexcept KeyboardInterrupt:\n    print('⚠️ หยุดการทำงานจาก Admin... ถอนตัวออกจาก Cloud อย่างปลอดภัย')\n    client.disconnect()\n    wlan.disconnect()"
            }
        ]
    },
    
    # Phase C: Edge AI & Robotics
    {
        "id": "iot-session-9",
        "title": "สมาร์ทวาล์วและรีเลย์ (Robotic Actions)",
        "desc": "ข้อมูลจะไร้ประโยชน์ถ้ามันสั่งการทางกายภาพไม่ได้ นี่คือการเปลี่ยน 0/1 กลับมาเป็นแรงผลักทางกลศาสตร์สวิตซ์ 220V",
        "xr_image": "assets/images/sim/agri_bot.png",
        "xr_caption": "Valve Controller: อนิเมชั่นวงจรไฟสลับจาก 3.3V เหนี่ยวนำเปิด 220V Water Pump",
        "examples": [
            {
                "title": "ตั้งค่า Relay พลังงานสูง",
                "code": "from machine import Pin\n\n# ขา 23 สั่งเปิดโซลิดสเตตรีเลย์ (Solid State Relay)\npump_relay = Pin(23, Pin.OUT)\npump_relay.value(0) # ปกติรีเลย์มักทำงานเมื่อค่าเป็น 0 (Active Low)\nprint('🌊 ปั๊มน้ำขนาดใหญ่กำลังปั๊มน้ำ!')"
            },
            {
                "title": "สร้างฟังก์ชันทดน้ำ (Irrigation Routine)",
                "code": "def water_plant(duration_seconds):\n    print(f'💧 เริ่มรดน้ำเป็นเวลา {duration_seconds} วินาที')\n    pump_relay.value(0)\n    time.sleep(duration_seconds)\n    pump_relay.value(1)\n    print('🚫 ปิดปั๊มเรียบร้อย!')"
            },
            {
                "title": "ระบบป้องกันน้ำแห้งปั๊มระเบิด (Hardware Failsafe)",
                "code": "water_level_sensor = Pin(35, Pin.IN)\n\n# ห้ามสั่งรดน้ำถ้าในแทงก์ไม่มีน้ำ (Sensor กลับค่าเป็นตัวเลข)\nif water_level_sensor.value() == 1:\n    print('⚠️ ปั๊มน้ำทำงานไม่ได้ น้ำในแทงก์หมด!')\nelse:\n    water_plant(10)"
            }
        ]
    },
    {
        "id": "iot-session-10",
        "title": "สลีปโหมดเซฟโลก (Deep Sleep Mastery)",
        "desc": "สมาร์ทฟาร์มของจริงตั้งอยู่กลางป่า! เราต้องใช้แบตเตอรี่และโซลาร์เซลล์ขนาดเล็ก ทำให้บอร์ดต้องเปิดเครื่องแบบเสี้ยววินาที",
        "xr_image": "assets/images/activities/iot_smart_sensor.png",
        "xr_caption": "Power Grid: กราฟิกแสดงการดรอปไฟเลี้ยงชิปประมวลผลจนเหลือ 0.01mA",
        "examples": [
            {
                "title": "ปิดระบบสัญญาณทุกอย่าง (Light Sleep)",
                "code": "import machine\n\nprint('ปิดระบบสมองซีกนอกและไวไฟชั่วคราว เพื่อประหยัดแบตเตอรี่')\nmachine.lightsleep(5000) \nprint('ตื่นแล้ว! สถานะ CPU ปกติ')"
            },
            {
                "title": "วิชาจำศีลลึก (Deep Sleep Configuration)",
                "code": "# เซ็นเซอร์จะตัดไฟตัวเอง 100% (แรมถูกลบ) เพื่อเก็บกระแสไฟนานแรมเดือน\n# และจะบูทตัวเองใหม่เมื่อถึงเวลา\n\nprint('💤 กำลังเข้าสู่โหมดจำศีล (Deep Sleep) 1 ชั่วโมง...')\nmachine.deepsleep(3600 * 1000)"
            },
            {
                "title": "วิธีการปลุกจากเซ็นเซอร์ (Ext0 Wakeup)",
                "code": "import esp32\n\n# ตั้งค่าให้ ESP32 หลับอยู่ แต่ถ้า 'ปุ่มฉุกเฉิน' (หรือเซ็นเซอร์ขโมย) ถูกกด ให้ตื่นทันที!\nwake_pin = Pin(14, mode=Pin.IN, pull=Pin.PULL_UP)\nesp32.wake_on_ext0(pin=wake_pin, level=esp32.WAKEUP_ALL_LOW)\n\nprint('เซ็ตระบบปลุกเมื่อมีคนบุกรุก... เข้าสู่การจำศีลแล้ว!')"
            }
        ]
    },
    {
        "id": "iot-session-11",
        "title": "สมองกลตัดสินใจเบื้องต้น (Edge Rules Engine)",
        "desc": "อย่ารออินเทอร์เน็ต! สวนอัจฉริยะที่แท้จริงต้องรู้จักแก้ปัญหาและสั่งรดน้ำได้เองเมื่อเซิร์ฟเวอร์ล่ม นี่คือหัวใจของ Edge AI",
        "xr_image": "assets/images/pillar_iot.png",
        "xr_caption": "Edge Logic Diagram: ผังงาน Decision Tree ฝังลงตัวชิปขนาด 4MB",
        "examples": [
            {
                "title": "การเขียน Logic ฝังบนชิป (Local Thresholds)",
                "code": "class EdgeEngine:\n    def __init__(self):\n        self.TEMP_MAX = 35.0\n        self.DRY_CRITICAL = 30.0\n        \n    def evaluate(self, current_temp, current_humid):\n        if current_temp > self.TEMP_MAX and current_humid < self.DRY_CRITICAL:\n            return 'ฉุกเฉิน: ร้อนและแห้งจัด สั่งสเปรย์หมอกทันที'\n        return 'สถานการณ์ปกติ'"
            },
            {
                "title": "สลับการควบคุมระหว่างคลาวด์และฮาร์ดแวร์",
                "code": "network_down = True  # จำลองสถานการณ์เน็ตหลุด\nedge_brain = EdgeEngine()\n\nif network_down:\n    print('⚠️ Network Offline: สลับเข้าสู่ระบบ Auto-Pilot บนชิป')\n    action = edge_brain.evaluate(36.5, 20.0)\n    print(f'ผลการตัดสินใจจากชิป: {action}')"
            },
            {
                "title": "เซฟความจำแบบติดทน (Non-Volatile NVS)",
                "code": "import btree\n\n# นำการตัดสินใจบันทึกลง Flash Memory เพื่อให้รอดจากการไฟดับ\ntry:\n    with open('local_db', 'w+b') as f:\n        db = btree.open(f)\n        db[b'last_action'] = b'sprayed_fog_14_30'\n        db.flush()\n        print('💾 บันทึกประวัติลงชิปถาวรเรียบร้อย!')\nexcept:\n    pass"
            }
        ]
    },
    {
        "id": "iot-session-12",
        "title": "จำลองโลกคู่ขนานดิจิทัล (Digital Twin Capstone)",
        "desc": "Capstone: นำทุกอย่างมารวมกัน (เซ็นเซอร์ > MQTT > ลอจิกไร้สาย > ลจิกไฟแรงดันสูง) เพื่อซิงโครไนซ์โลกความจริงกับ RBRU Simulator แบบเรียลไทม์",
        "xr_image": "assets/images/activities/tech_showcase.png",
        "xr_caption": "XR Digital Twin: จำลองต้นฉบับ 3 มิติขยับตามข้อมูลแสงสีและข้อมูล MQTT ในโลกจริง",
        "examples": [
            {
                "title": "โครงสร้างโค้ดบริหารโปรเจค (Main Skeleton)",
                "code": "def run_capstone():\n    print('--- 🌟 Booting RBRU Digital Twin Node 🌟 ---')\n    print('1. Connecting to RBRU Cloud Services...')\n    print('2. Initializing Environmental Sensors...')\n    print('3. Activating Edge AI Safety Guard...')"
            },
            {
                "title": "Synchronizer Loop (หัวใจวัฎจักรส่งข้อมูล)",
                "code": "def the_smart_loop():\n    print('🔄 [Loop Started] Read ADC -> Check Edge Logic -> Publish MQTT -> Deep Sleep')\n    print('...')\n    print('✔️ Digital Twin Web Dashboard received update synchronizing water droplet visuals.')"
            },
            {
                "title": "Launch The System โชว์ผลลัพธ์",
                "code": "if __name__ == '__main__':\n    run_capstone()\n    the_smart_loop()\n    \n    print('👉 (ในห้องทดลองจริง คุณจะได้เห็นภาพโฮโลแกรมต้นไม้ของคุณโตขึ้นในสัดส่วนที่ตรงกันกับเซ็นเซอร์!)')"
            }
        ]
    },
    {
        "id": "iot-session-13",
        "title": "AI วิเคราะห์คุณภาพดิน (NPK & pH)",
        "desc": "Capston Plus: การบูรณาการเซ็นเซอร์วัดค่าธาตุอาหารในดิน (NPK) และกรด-ด่าง (pH) ร่วมกับพลังของ Local AI ในการแปลผล",
        "xr_image": "assets/images/activities/iot_orchard.png",
        "xr_caption": "Soil Insights: แบบจำลองโครงสร้างโมเลกุลธาตุอาหารในดินที่ตรวจพบ",
        "examples": [
            {
                "title": "อ่านค่า NPK ผ่าน Modbus (RS485)",
                "code": "# เซ็นเซอร์ NPK เกรดอุตสาหกรรมมักใช้โปรโตคอล RS485\nfrom machine import UART\n\nuart = UART(2, baudrate=9600, tx=17, rx=16)\n# ส่งคำสั่ง Query ไปยังเซ็นเซอร์ NPK\nquery = b'\\x01\\x03\\x00\\x1e\\x00\\x03\\x65\\xcd'\nuart.write(query)\n\nprint('⏳ กำลังสกัดค่า N-P-K จากหัวโพรบใต้ดิน...')"
            },
            {
                "title": "อัลกอริทึมจัดการค่า pH",
                "code": "# แปลงค่าแรงดันไฟฟ้าจากหัวโพรบเครื่องแก้วเป็นค่า pH 0-14\ndef calculate_ph(voltage):\n    # สมการ Calibration: pH = 7 + ((V_neutral - V_read) / V_slope)\n    return 7 + ((2.5 - voltage) / 0.18)\n\nph_val = calculate_ph(2.8)\nprint(f'🧪 ค่ากรด-ด่างที่ตรวจวัดได้: {ph_val:.2f} pH')"
            },
            {
                "title": "เชื่อมต่อ Local AI (Ollama Integration)",
                "code": "import urequests\n\n# ส่งข้อมูลวิเคราะห์เบื้องต้นไปให้ Gemma 3 ช่วยตัดสินใจ\ndata = {'n': 12, 'p': 5, 'k': 20, 'ph': 5.2}\nprompt = f'ดินมีค่า NPK={data} และ pH={data[\\'ph\\']} ควรปลูกอะไร?'\n\n# หมายเหตุ: ในบอร์ดจริงจะส่งผ่าน Gateway ไปยัง Ollama Server\nprint(f'🤖 AI Recommendation: {prompt}')"
            }
        ]
    }
]

file_path = 'data/iot_sessions.json'
os.makedirs('data', exist_ok=True)
with open(file_path, 'w', encoding='utf-8') as f:
    json.dump(iot_sessions, f, ensure_ascii=False, indent=4)

print(f"✅ Generated {len(iot_sessions)} IoT sessions into {file_path}")
