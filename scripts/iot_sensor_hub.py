#!/usr/bin/env python3
"""
RBRU-Praneet Digital Agri-Innovation Center
Workshop 3: AI-IoT Prototyping Starter Script
---------------------------------------------
This script is designed for MicroPython (ESP32).
Logic: Sensor Sampling -> Edge Decisions -> MQTT Upload
"""

# import machine  # Only for ESP32
# import time
# from umqtt.simple import MQTTClient

class AgriSensorNode:
    def __init__(self, node_id):
        self.node_id = node_id
        self.mqtt_broker = "broker.hivemq.com"
        
    def read_soil_moisture(self):
        """Simulates an ADC reading from Pin 34."""
        # raw_val = adc.read()
        # In simulation, we return a healthy 55%
        return 55.0
    
    def process_logic(self, moisture):
        """Edge AI Decision Logic."""
        if moisture < 40:
            return "ON"  # Activate Relay
        return "OFF"
    
    def display_status(self, moisture, pump_state):
        print(f"--- Node: {self.node_id} ---")
        print(f"Moisture: {moisture}% | Pump: {pump_state}")

def main():
    # Initialize Node
    my_node = AgriSensorNode("ESP32_Durian_01")
    
    print("Node successfully initialized. Starting monitoring loop...")
    
    # Processing Loop
    moisture = my_node.read_soil_moisture()
    pump_state = my_node.process_logic(moisture)
    my_node.display_status(moisture, pump_state)
    
    # MQTT Publish Simulation
    print(f"Publishing to {my_node.mqtt_broker} Topic: rbru/agri/data")
    print("Data packet: {'id': 'ESP32_Durian_01', 'moist': 55.0}")

if __name__ == "__main__":
    main()
