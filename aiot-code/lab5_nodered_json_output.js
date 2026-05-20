// Function Node Code (JavaScript) - JSON Output Example

// 1. ดึงค่าความชื้นที่เข้ามา (สมมติว่าเข้ามาใน msg.payload)
let moistureValue = parseFloat(msg.payload);

// 2. กำหนดตัวแปรสำหรับเก็บสถานะ
let status = "";
let message_th = "";

// 3. การใช้โครงสร้างเงื่อนไข (Conditional Logic)
if (isNaN(moistureValue)) {
    status = "Error";
    message_th = "ไม่สามารถอ่านค่าความชื้นได้";
} else if (moistureValue < 20) {
    status = "Critical";
    message_th = "วิกฤต! ความชื้นต่ำมาก";
} else if (moistureValue < 40) {
    status = "Low";
    message_th = "ต่ำกว่าปกติ ควรเฝ้าระวัง";
} else {
    status = "Normal";
    message_th = "ความชื้นอยู่ในระดับปกติ";
}

// 4. สร้าง Object JSON ตามที่โจทย์กำหนด
let outputObject = {
    status: status,
    value: moistureValue,
    message_th: message_th
};

// 5. กำหนด Object นี้เป็น Payload ใหม่ และส่งออก
msg.payload = outputObject;

return msg;
