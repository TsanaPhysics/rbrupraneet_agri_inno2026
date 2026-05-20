// Function Node Code (JavaScript) - Data Transformation Example
// โค้ดนี้รับค่าความชื้น (msg.payload) และแปลงเป็นสถานะภาษาไทย

// 1. ตรวจสอบว่าค่าที่เข้ามาเป็นตัวเลขหรือไม่
let moistureValue = parseFloat(msg.payload);

// 2. กำหนดค่าเกณฑ์ (Thresholds)
const CRITICAL_LOW = 20; // ระดับวิกฤต (เปอร์เซ็นต์)
const LOW = 40;          // ระดับต่ำ (เปอร์เซ็นต์)

let statusText = ""; // ตัวแปรสำหรับเก็บข้อความสถานะ

// 3. การใช้โครงสร้างเงื่อนไข (Conditional Logic)
if (isNaN(moistureValue)) {
    statusText = "⚠️ ไม่พบข้อมูลความชื้น";
} else if (moistureValue < CRITICAL_LOW) {
    // กรณีวิกฤต: ต้องแจ้งเตือนทันที
    statusText = `🚨 วิกฤต! ความชื้นต่ำมาก (${moistureValue.toFixed(2)}%) ต้องรดน้ำด่วน!`;
} else if (moistureValue < LOW) {
    // กรณีต่ำ: ควรเริ่มเฝ้าระวัง
    statusText = `💧 ความชื้นต่ำ (${moistureValue.toFixed(2)}%) ควรตรวจสอบระบบ`;
} else if (moistureValue >= 70) {
    // กรณีสูง: อาจจะมากเกินไป
    statusText = `💦 ความชื้นสูงมาก (${moistureValue.toFixed(2)}%) อาจต้องระบายน้ำ`;
} else {
    // กรณีปกติ
    statusText = `✅ ความชื้นอยู่ในระดับปกติ (${moistureValue.toFixed(2)}%)`;
}

// 4. ปรับปรุง Message Object
// เราจะส่งข้อความสถานะภาษาไทยนี้ออกไปแทนค่าตัวเลขเดิม
msg.payload = statusText;

// 5. ส่ง Message Object ที่ถูกจัดรูปแบบแล้วออกไป
return msg;
