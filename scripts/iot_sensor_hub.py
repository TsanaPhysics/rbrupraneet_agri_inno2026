#!/usr/bin/env python3
"""
RBRU-Praneet Digital Agri-Innovation Center (2026)
Workshop 3: AI-IoT Prototyping (Advanced 12-Hour Edition)
-----------------------------------------------
This MicroPython-compatible script implements industrial IoT standards:
Secure Payload Hashing, Digital Twin logic, and Deep Sleep power management.
"""

# import machine # for machine.deepsleep()
# import hashlib
# import time

class SecureAgriNode:
    def __init__(self, node_id, secret_key="RBRU2026"):
        self.node_id = node_id
        self.secret_key = secret_key
        self.sleep_interval_ms = 3600000 # 1 Hour

    def get_secure_payload(self, moisture, temp):
        """Advanced: SHA-256 Hashing for data integrity validation."""
        raw_string = f"{self.node_id}:{moisture}:{temp}:{self.secret_key}"
        # Simulating hashlib.sha256(raw_string.encode()).hexdigest()
        fake_hash = "f3a2c4e..." + str(hash(raw_string))[-8:]
        return {
            "node": self.node_id,
            "data": {"moist": moisture, "temp": temp},
            "hash": fake_hash
        }

    def process_digital_twin_sync(self):
        """Simulates bidirectional sync with a 3D Digital Twin Hub."""
        print(f"📡 Syncing with Digital Twin Command Hub...")
        print(" - Downloading Shadow State: Pump_Override = NONE")
        print(" - Uploading Telemetry: OK")

    def enter_power_save(self):
        """Hardware Logic: Transition CPU to Deep Sleep mode."""
        print(f"💤 Mission Complete. Entering Deep Sleep for {self.sleep_interval_ms/1000/60:.0f} mins.")
        print(" - Sensors: Powered Down")
        print(" - Wi-Fi: Disconnected")
        # machine.deepsleep(self.sleep_interval_ms)

def main():
    print("--- RBRU-Praneet Industrial IoT Node ---")
    node = SecureAgriNode("ESPINNO_FIELD_04")
    
    # 1. Sample Phase
    moisture = 42.5
    temp = 31.8
    
    # 2. Security Phase
    payload = node.get_secure_payload(moisture, temp)
    
    # 3. Synchronicity Phase
    node.process_digital_twin_sync()
    
    # 4. Result Output
    print("\n" + "🔋" * 20)
    print(f"Packet ID: {payload['node']}")
    print(f"Security Hash: {payload['hash']}")
    print(f"Field Data: {payload['data']}")
    print("🔋" * 20)
    
    # 5. Optimization Phase
    node.enter_power_save()

if __name__ == "__main__":
    main()
