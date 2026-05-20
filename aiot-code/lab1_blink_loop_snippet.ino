// (สมมติว่า setup() และ pinMode() ถูกตั้งค่าไว้แล้ว)

void loop() {
  // 1. เปิดไฟ (HIGH)
  digitalWrite(ledPin, HIGH); 
  Serial.println("Warning: ON");
  
  // 2. หน่วงเวลา 200 ms
  delay(200); 
  
  // 3. ปิดไฟ (LOW)
  digitalWrite(ledPin, LOW); 
  Serial.println("Warning: OFF");
  
  // 4. หน่วงเวลา 200 ms
  delay(200); 
}
