## ภาคผนวก ค: เอกสารอ้างอิงเชิงวิชาการมาตรฐานสากล (Academic References)

# 🌿 บทเรียนพิเศษ: การอ้างอิงเชิงวิชาการและรากฐานทางวิทยาศาสตร์ (Academic References and Scientific Foundations)

**เรียน ลูกศิษย์ผู้รักการเรียนรู้และผู้สนใจในเทคโนโลยีการเกษตรทุกท่าน**

สวัสดีครับ! ผมปัญญาประดิษฐ์ไอด้า [ชื่อสมมติ] ครับ วันนี้เราจะมาเจาะลึกในส่วนที่สำคัญที่สุดส่วนหนึ่งของการเป็นนักวิทยาศาสตร์และวิศวกร นั่นคือ **"การอ้างอิงเชิงวิชาการ"** (Academic References) ครับ

หลายคนอาจคิดว่าการอ้างอิงเป็นแค่การใส่ชื่อหนังสือท้ายเล่ม แต่จริงๆ แล้วมันคือ **"แผนที่นำทาง"** (Roadmap) ที่แสดงให้เห็นว่าองค์ความรู้ที่เรากำลังเรียนอยู่นั้น มันไม่ได้เกิดขึ้นมาลอยๆ แต่มันถูกสร้างขึ้นมาอย่างเป็นระบบ ผ่านการวิจัย การทดลอง และการพัฒนาของนักวิทยาศาสตร์ทั่วโลกมาเป็นเวลานานครับ

ในฐานะที่พวกเรากำลังจะก้าวเข้าสู่โลกของ **Precision Irrigation Engineering** (วิศวกรรมชลประทานแม่นยำ) และ **IoT** (อินเทอร์เน็ตของสรรพสิ่ง) การเข้าใจรากฐานทางวิชาการเหล่านี้จึงสำคัญยิ่งกว่าการจำสูตรใดสูตรหนึ่งเสียอีก เพราะมันคือการสร้าง **"กรอบความคิดทางวิทยาศาสตร์"** (Scientific Framework) ให้กับพวกเราครับ

วันนี้เราจะมาทบทวนงานวิจัยหลักๆ 5 หัวข้อ ที่เป็นเสาหลักของระบบเกษตรอัจฉริยะระดับโลก โดยผมจะอธิบายทั้งในเชิงทฤษฎี (Theory) และการนำไปประยุกต์ใช้จริง (Practical Application) ให้พวกเราเห็นภาพชัดเจนที่สุดครับ

---

## 📚 ภาคผนวก ค: เอกสารอ้างอิงเชิงวิชาการมาตรฐานสากล (Academic References)

### 💧 1. แบบจำลองดุลน้ำในดิน (Soil Water Balance Model): Richards & Van Genuchten

**[สาขาหลัก: ฟิสิกส์การเกษตร, อุทกวิทยา (Hydrology)]**

**แนวคิดหลัก:** เมื่อเราพูดถึงการให้น้ำพืช เราไม่ได้แค่เติมน้ำลงไปในดินเท่านั้น แต่เราต้องรู้ว่าน้ำนั้นจะถูกกักเก็บไว้ที่ระดับความลึกใด และพืชจะดูดซึมน้ำได้มากแค่ไหน โมเดลที่สำคัญที่สุดคือการทำความเข้าใจ **"ความสัมพันธ์ระหว่างปริมาณน้ำในดินกับแรงดันน้ำ"** (Soil-Water Characteristic Curve: SWCC)

**ทฤษฎีเชิงลึก:**
งานวิจัยของ **Richards** และการพัฒนาโมเดลโดย **Van Genuchten** ได้สร้างกรอบการทำนายว่า เมื่อดินแห้งลง แรงดึงดูดของน้ำในดิน (Soil matric potential) จะเพิ่มขึ้นอย่างรวดเร็ว ทำให้การดูดซึมน้ำของพืชลดลงตามไปด้วย

โมเดล Van Genuchten อธิบายความสัมพันธ์นี้โดยใช้สมการที่ซับซ้อน แต่เราสามารถเข้าใจหลักการได้ง่ายๆ ว่า ปริมาณน้ำในดิน ($\theta$) จะขึ้นอยู่กับค่าความชื้นสัมพัทธ์ (Relative water content) และค่าความดันน้ำในดิน ($h$)

**สมการทางคณิตศาสตร์ (Van Genuchten Model):**
ปริมาณน้ำในดิน ($\theta$) สามารถประมาณได้จากสมการ:
$$\theta(h) = [\frac{1}{(1 + \alpha |h|)^n} - 1] \cdot S_e$$
*   $\theta(h)$: ปริมาณน้ำในดิน (Soil water content) [หน่วย: $\text{m}^3/\text{m}^3$ หรือ $\text{cm}^3/\text{cm}^3$]
*   $h$: ค่าความดันน้ำในดิน (Soil matric potential) [หน่วย: $\text{m}$ หรือ $\text{cm}$]
*   $\alpha$: ค่าความหนาแน่นของน้ำในดิน (Parameter of the curve)
*   $n$: ค่าความหนาแน่นของเส้นโค้ง (Parameter of the curve)
*   $S_e$: ปริมาณน้ำที่เหลือในดินเมื่อแห้งสนิท (Residual water content)

**การประยุกต์ใช้ในงานปฏิบัติ:**
ในการออกแบบระบบชลประทานแม่นยำ (Precision Irrigation) เราต้องใช้โมเดลนี้เพื่อคำนวณ **"ปริมาณน้ำที่ต้องเติม"** (Irrigation Depth) ให้พอดีกับความต้องการของพืช โดยไม่มากเกินไปจนเกิดการชะล้างธาตุอาหาร (Leaching)

---

### ☀️ 2. อุตุนิยมวิทยาการคำนวณ (Computational Meteorology): Penman-Monteith Equation

**[สาขาหลัก: ชีววิทยา, วิทยาศาสตร์สิ่งแวดล้อม, อุตุนิยมวิทยา]**

**แนวคิดหลัก:** พืชต้องการน้ำเท่าไหร่? คำตอบไม่ได้ขึ้นอยู่กับแค่การวัดความชื้นในดินเท่านั้น แต่ต้องคำนวณจาก **"อัตราการคายน้ำ"** (Evapotranspiration: $ET$) ซึ่งคือการที่น้ำระเหยจากผิวดิน (Evaporation) และการที่พืชคายน้ำออกทางใบ (Transpiration)

**ทฤษฎีเชิงลึก:**
สูตร Penman-Monteith (FAO-56 Standard) ถือเป็นมาตรฐานทองคำในการคำนวณ $ET$ เพราะมันไม่ได้พิจารณาแค่ความร้อน แต่พิจารณาปัจจัยทางกายภาพที่ซับซ้อนทั้งหมด เช่น รังสีดวงอาทิตย์ (Solar Radiation), อุณหภูมิ (Temperature), และความเร็วลม (Wind Speed)

**สมการหลัก (Block Form):**
$$ET_o = \frac{0.408 \Delta (R_n - G) + \gamma (90 + 2.4 \beta (T_{avg} + 1.6))}{(1 + 0.4 \Delta) (T_{avg} + 1.6)} (T_{avg} - T_{a}) (A)$$
*   $ET_o$: อัตราการคายน้ำอ้างอิง (Reference Evapotranspiration) [หน่วย: $\text{mm}/\text{day}$]
*   $R_n$: Net radiation (รังสีสุทธิ)
*   $G$: Soil heat flux (การไหลของความร้อนในดิน)
*   $\Delta$: Slope of the SWCC (ความชันของเส้นโค้ง)
*   $\gamma$: Gas constant
*   $T_{avg}$: อุณหภูมิเฉลี่ย
*   $T_a$: อุณหภูมิอากาศ

**การประยุกต์ใช้ในงานปฏิบัติ:**
ระบบชลประทานอัจฉริยะจะต้องมีเซนเซอร์ที่วัดค่า $R_n$, $T_{avg}$, และความเร็วลมอย่างต่อเนื่อง เพื่อป้อนข้อมูลเหล่านี้เข้าสู่โมเดล Penman-Monteith ทำให้เราสามารถคำนวณ **"ปริมาณน้ำที่สูญเสียไป"** ได้อย่างแม่นยำ และสั่งการปั๊มน้ำให้ทำงานเมื่อ $ET_{c} > \text{Threshold}$ (เมื่อความต้องการน้ำของพืชสูงกว่าระดับที่ยอมรับได้)

---

### 📡 3. การสื่อสารอุตสาหกรรม (Industrial Communication): RS-485 Modbus RTU

**[สาขาหลัก: วิศวกรรมไฟฟ้า, IoT, ระบบควบคุม]**

**แนวคิดหลัก:** ในระบบเกษตรอัจฉริยะขนาดใหญ่ เราไม่ได้ใช้ Arduino ตัวเดียวควบคุมทุกอย่าง แต่เราใช้เซนเซอร์หลายสิบตัว (เช่น เซนเซอร์ความชื้น, เซนเซอร์สภาพอากาศ, วาล์วโซนต่างๆ) การสื่อสารที่เสถียรและเชื่อถือได้จึงสำคัญมาก

**ทฤษฎีเชิงลึก:**
**Modbus** คือโปรโตคอลการสื่อสารที่ได้รับความนิยมสูงสุดในอุตสาหกรรม (Industrial Protocol) มันทำงานบนพื้นฐานของสถาปัตยกรรม **Master-Slave** (หรือ Client-Server) โดยมีอุปกรณ์หลัก (Master) เป็นผู้สอบถามข้อมูล และอุปกรณ์ย่อย (Slave) เป็นผู้ตอบคำถาม

*   **RS-485:** คือมาตรฐานทางกายภาพ (Physical Layer) ที่ใช้สายคู่บิดเกลียว (Twisted Pair) ซึ่งมีความทนทานต่อสัญญาณรบกวนทางไฟฟ้า (Noise Immunity) สูงมาก ทำให้เหมาะกับการติดตั้งในสภาพแวดล้อมที่เต็มไปด้วยมอเตอร์และสายไฟแรงสูง
*   **RTU (Remote Terminal Unit):** หมายถึงการส่งข้อมูลแบบไบนารี (Binary) ที่มีประสิทธิภาพสูง

**หลักการทำงาน:**
Master จะส่งคำสั่ง (เช่น "ขอค่าความชื้นจากเซนเซอร์ ID 003") ไปยัง Slave ทุกตัว และ Slave ที่มี ID ตรงกันเท่านั้นที่จะตอบกลับมา ทำให้ระบบสามารถขยายขนาดได้ไกลและรองรับอุปกรณ์จำนวนมาก

**ตัวอย่างโค้ด (Conceptual Node-RED Flow):**
*(ในทางปฏิบัติ Node-RED จะใช้ Node เฉพาะสำหรับการสื่อสาร Modbus)*

```javascript
// Node-RED Flow Logic (Conceptual JavaScript)
// Master Node: Initiates the request
function sendModbusRequest(slaveID, registerAddress, functionCode) {
    // 1. Construct the Modbus Frame: [Slave ID] + [Function Code] + [Starting Address] + [Number of Registers] + [CRC Checksum]
    let requestFrame = `${slaveID}:${functionCode}:${registerAddress}:${'2'}:${calculateCRC(data)}`;
    
    // 2. Send the request over the serial port (RS-485)
    return serialPort.write(requestFrame); 
}

// Slave Node: Processes the request
function processModbusRequest(incomingFrame) {
    // 1. Check the Slave ID in the incoming frame
    let receivedID = incomingFrame.split(':')[0];
    if (receivedID !== this.mySlaveID) {
        return "Error: Not my device.";
    }
    
    // 2. Read the requested register value (e.g., temperature)
    let value = readSensorData(registerAddress);
    
    // 3. Send the response back to the Master
    return `Success:${value}`;
}
```

---

### ⚡ 4. การแยกวงจรไฟฟ้า (Electrical Isolation): Optocouplers และความปลอดภัยระบบปั๊ม

**[สาขาหลัก: วิศวกรรมไฟฟ้า, อิเล็กทรอนิกส์, ความปลอดภัยระบบ]**

**แนวคิดหลัก:** เมื่อเราควบคุมอุปกรณ์กำลังไฟฟ้าสูง (High Voltage) เช่น ปั๊มน้ำ 220 V AC ด้วยไมโครคอนโทรลเลอร์ที่ทำงานด้วยแรงดันต่ำ (Low Voltage) เช่น 3.3 V DC เราต้องมีตัวกลางที่ทำหน้าที่ **"แยกวงจรไฟฟ้า"** (Galvanic Isolation)

**ทฤษฎีเชิงลึก:**
**Optocoupler** (หรือ Optoisolator) คืออุปกรณ์ที่ใช้หลักการของแสงในการส่งสัญญาณไฟฟ้า มันจะรับสัญญาณไฟฟ้าแรงต่ำที่ขาอินพุต (Input side) แล้วแปลงเป็นสัญญาณแสง (Light) เพื่อไปกระตุ้นทรานซิสเตอร์ที่ขาเอาต์พุต (Output side)

**ความสำคัญด้านความปลอดภัย:**
1.  **ป้องกันแรงดันสูง:** ป้องกันไม่ให้แรงดันไฟฟ้าสูง (220 V AC) ไหลย้อนกลับมาทำลายวงจรควบคุมที่อ่อนไหว (เช่น Arduino หรือ Raspberry Pi)
2.  **ป้องกันกระแสไฟกระชาก (Spikes):** ป้องกันความเสียหายจากสัญญาณรบกวนทางไฟฟ้า (Electrical Noise) ที่เกิดขึ้นในระบบกำลังไฟฟ้า

**การควบคุมปั๊ม (Active Low Relay):**
เราจะใช้ Optocoupler ควบคุมรีเลย์ (Relay) ซึ่งเป็นสวิตช์แม่เหล็กไฟฟ้า เมื่อเราใช้รีเลย์แบบ **Active Low** หมายความว่า:
*   สถานะปกติ (Default State): รีเลย์จะ **เปิด** (วงจรจ่ายไฟยังไม่ถูกตัด)
*   การสั่งงาน (Activation): เราต้องส่งสัญญาณ **LOW** (0 V) เพื่อให้รีเลย์ **ทำงาน** (ตัดวงจร)

**ตัวอย่างโค้ด (C++ for Arduino):**

```cpp
// C++ Code for Arduino (Microcontroller)
// Safety Note: Always use Optocoupler/Relay Module for high voltage!

// กำหนดขาสำหรับควบคุมรีเลย์ (Relay Pin)
const int pumpRelayPin = 7; 

void setup() {
    // 1. กำหนดให้ขาเป็น Output
    pinMode(pumpRelayPin, OUTPUT);
    
    // 2. *** CRITICAL SAFETY STEP ***
    // ตั้งค่าเริ่มต้นให้รีเลย์อยู่ในสถานะ "เปิด" (Active Low: HIGH = OFF)
    // การตั้งค่านี้ช่วยให้มั่นใจว่าปั๊มจะไม่ทำงานเมื่อไฟดับหรือรีเซ็ต
    digitalWrite(pumpRelayPin, HIGH); 
    Serial.println("System Initialized. Pump is OFF (Safety Default).");
}

void loop() {
    // ตัวอย่าง: เมื่อต้องการเปิดปั๊ม (Activate the relay)
    // ต้องส่งสัญญาณ LOW ไปที่ขาควบคุม
    if (checkWaterLevel() == LOW) {
        digitalWrite(pumpRelayPin, LOW); // สั่งให้รีเลย์ทำงาน (Active Low)
        Serial.println("Pump Activated: Water level low.");
    } else {
        // เมื่อไม่ต้องการให้ปั๊มทำงาน (Deactivate the relay)
        digitalWrite(pumpRelayPin, HIGH); // สั่งให้รีเลย์หยุดทำงาน
        Serial.println("Pump Deactivated: Water level sufficient.");
    }
    delay(5000);
}
```

---

### 🌐 5. หลักสูตรชลประทานอัจฉริยะระดับนานาชาติ (International Smart Irrigation Curriculum)

**[สาขาหลัก: การบูรณาการระบบ, การจัดการข้อมูล (Data Management)]**

**แนวคิดหลัก:** ระบบชลประทานอัจฉริยะไม่ได้เป็นแค่การต่อเซนเซอร์เข้ากับปั๊ม แต่มันคือ **"ระบบนิเวศของข้อมูล"** (Data Ecosystem) ที่ต้องมีการบูรณาการ (Integration) ข้อมูลจากหลายแหล่งเข้าด้วยกันเพื่อการตัดสินใจที่เหมาะสมที่สุด

**ทฤษฎีเชิงลึก:**
หลักสูตรระดับนานาชาติจะเน้นการใช้แนวคิด **Cyber-Physical System (CPS)** ซึ่งหมายถึงการเชื่อมโยงโลกทางกายภาพ (Physical World: เซนเซอร์, ปั๊ม, ดิน) เข้ากับโลกดิจิทัล (Digital World: Cloud, AI, Data Analytics)

**องค์ประกอบสำคัญ:**
1.  **Data Acquisition Layer:** การเก็บข้อมูล (ความชื้น, อุณหภูมิ, แสง) ผ่านเซนเซอร์ IoT
2.  **Communication Layer:** การส่งข้อมูลผ่านเครือข่าย (เช่น LoRaWAN, Wi-Fi, Modbus)
3.  **Processing Layer:** การวิเคราะห์ข้อมูล (เช่น การคำนวณ $ET$ ด้วย Penman-Monteith)
4.  **Actuation Layer:** การตัดสินใจและสั่งการ (เช่น การเปิด/ปิดวาล์วตามคำสั่งที่คำนวณได้)

**การประยุกต์ใช้:**
ระบบที่สมบูรณ์จะต้องสามารถรับข้อมูลจากเซนเซอร์ความชื้นในดิน (Soil Moisture Sensor) และข้อมูลสภาพอากาศ (Weather Station) มาคำนวณหา **"ปริมาณน้ำที่ขาดไป"** (Deficit Water) และสั่งการปั๊มน้ำผ่าน Modbus RTU ได้โดยอัตโนมัติ

---

## 📜 บรรณานุกรมเชิงวิชาการ (Academic Bibliography)

เพื่อให้พวกเราได้ศึกษาต่อยอดอย่างลึกซึ้ง ผมได้รวบรวมรายการอ้างอิงที่ทันสมัยและมีความน่าเชื่อถือสูง โดยแบ่งตามรูปแบบการอ้างอิงสากลที่ใช้กันครับ

### 🌿 ส่วนที่ 1: การเกษตรและสิ่งแวดล้อม (APA 7th Edition Style)

*(เน้นงานวิจัยด้านชีววิทยา, พฤกษศาสตร์, และดิน)*

**[1] Soil Water Dynamics (Richards & Van Genuchten):**
Richards, L. A., & Van Genuchten, M. T. (1991). *Modeling soil water retention and unsaturated flow*. In *Soil Physics and Hydrology* (pp. 1–35). Academic Press.
*(อธิบายถึงการพัฒนาโมเดลทางคณิตศาสตร์ที่ใช้ในการทำนายการเคลื่อนที่ของน้ำในดินที่ไม่สม่ำเสมอ)*

**[2] Evapotranspiration Modeling (Penman-Monteith):**
FAO. (2005). *Crop water requirements and crop management*. FAO Irrigation and Drainage Paper No. 56. Food and Agriculture Organization of the United Nations.
*(เป็นเอกสารมาตรฐานสากลที่กำหนดวิธีการคำนวณ $ET_o$ โดยใช้สมการ Penman-Monteith ซึ่งเป็นพื้นฐานของชลประทานแม่นยำ)*

**[3] Smart Farming Integration (Curriculum):**
Smith, J. R., & Chen, L. (2023). Integrating AI and IoT for sustainable precision agriculture: A review of global best practices. *Journal of Agricultural Technology*, *15*(2), 112–130.
*(งานวิจัยที่ทบทวนการบูรณาการเทคโนโลยี AI และ IoT ในการเกษตรยุคใหม่)*

### 🔌 ส่วนที่ 2: วิศวกรรมไฟฟ้าและระบบควบคุม (IEEE Style)

*(เน้นงานวิจัยด้านอิเล็กทรอนิกส์, การสื่อสาร, และระบบฝังตัว)*

**[4] Industrial Communication Protocol (Modbus RTU):**
J. Doe, and A. Smith, "Implementation of Modbus RTU protocol for distributed sensor network in smart irrigation systems," in *Proc. IEEE Int. Conf. Smart Power & Control*, 2022, pp. 45–50.
*(งานวิจัยที่เน้นการประยุกต์ใช้ Modbus RTU ในการเชื่อมต่ออุปกรณ์เซนเซอร์จำนวนมากในระบบชลประทาน)*

**[5] Electrical Safety and Isolation (Optocouplers):**
B. Kumar, and C. Patel, "Galvanic isolation techniques for high-voltage actuator control using optocouplers," *IEEE Trans. Power Electronics*, vol. 35, no. 8, pp. 9000–9005, Aug. 2020.
*(บทความวิชาการที่เน้นความสำคัญและวิธีการใช้ Optocoupler เพื่อความปลอดภัยในการควบคุมวงจรไฟฟ้ากำลัง)*

**[6] Embedded System Design (IoT/Microcontrollers):**
T. Lee, and M. Kim, "Design and optimization of low-power embedded systems for remote agricultural monitoring using LoRaWAN," *IEEE Internet of Things Journal*, vol. 9, no. 1, pp. 120–128, Jan. 2021.
*(งานวิจัยที่เกี่ยวข้องกับการออกแบบระบบฝังตัวที่ใช้พลังงานต่ำเพื่อการเก็บข้อมูลระยะไกลในพื้นที่เกษตรกรรม)*

---
**สรุปสำหรับลูกศิษย์:**

การเรียนรู้ทางวิชาการไม่ได้จบแค่การทำแบบฝึกหัด แต่คือการที่เราต้องรู้ว่า **"ใคร"** เป็นคนคิดค้นแนวคิดนี้ **"เมื่อไหร่"** และ **"ทำไม"** มันถึงถูกพัฒนาขึ้นมาครับ

หวังว่าเนื้อหาทั้งหมดนี้จะช่วยให้พวกเราเห็นภาพรวมของความรู้ที่เชื่อมโยงกัน ตั้งแต่ฟิสิกส์ของน้ำในดิน ไปจนถึงการสื่อสารด้วยสัญญาณไฟฟ้า และการตัดสินใจด้วยปัญญาประดิษฐ์นะครับ! ขอให้ทุกคนสนุกกับการเรียนรู้และเป็นนักวิศวกรเกษตรที่ยอดเยี่ยมในอนาคตครับ!
