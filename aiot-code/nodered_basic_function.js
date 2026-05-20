// Node-RED Function Node (JavaScript)
// Input: msg.payload = { "temperature": 28.5, "humidity": 65, "timestamp": "..." }
// Output: msg.payload = { "temp": 28.5, "rh": 65, "status": "OK" }

// 1. การรับข้อมูลจากเซนเซอร์ (Receiving Sensor Data)
let sensorData = msg.payload;

// 2. การตรวจสอบความสมบูรณ์ของข้อมูล (Data Validation)
if (!sensorData || typeof sensorData.temperature === 'undefined') {
    // หากข้อมูลไม่สมบูรณ์ ให้ส่งสถานะผิดพลาด
    msg.payload = { "error": "Invalid Data Received" };
    return null; // หยุดการทำงานของ Flow นี้
}

// 3. การประมวลผลทางฟิสิกส์ (Physics Processing - Example: Calculating Heat Index)
// การคำนวณดัชนีความร้อน (Heat Index) เป็นการประเมินความเสี่ยงทางความร้อน
let temp = sensorData.temperature; // อุณหภูมิ (°C)
let rh = sensorData.humidity;      // ความชื้นสัมพัทธ์ (%)

// สูตร Heat Index (Simplified for demonstration)
let heatIndex = (1.8 * temp) + (0.5 * rh); 

// 4. การตัดสินใจและกำหนดสถานะ (Decision Making and Status Update)
let status = "OK";
if (heatIndex > 30) {
    status = "WARNING: High Heat Index. Recommend Shade.";
} else if (rh < 30) {
    status = "WARNING: Low Humidity. Check for misting.";
}

// 5. การจัดรูปแบบข้อมูลเพื่อส่งออก (Formatting Output Payload)
msg.payload = {
    "temp": temp.toFixed(1), // ปัดทศนิยมเหลือ 1 ตำแหน่ง
    "rh": rh.toFixed(1),
    "heat_index": heatIndex.toFixed(1),
    "status": status,
    "timestamp": new Date().toISOString()
};

// ส่งข้อมูลที่ประมวลผลแล้วไปยัง Node ถัดไป (เช่น MQTT Out Node)
return msg;
