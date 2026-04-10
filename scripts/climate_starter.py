#!/usr/bin/env python3
"""
RBRU-Praneet Digital Agri-Innovation Center (2026)
Workshop 1: Climate Data Hacking (Advanced 12-Hour Edition)
-----------------------------------------------
This script implements advanced agricultural analytics including moving 
averages for trend detection and logic-based cropping advisors.
"""

import math
import statistics

class ClimateIntelligence:
    def __init__(self, location="Chanthaburi"):
        self.location = location
        self.history = []

    def log_reading(self, temp, humidity):
        """Logs a new climate reading for time-series analysis."""
        self.history.append({'temp': temp, 'humidity': humidity})
        # Keep only last 10 readings for local moving average
        if len(self.history) > 10:
            self.history.pop(0)

    def calculate_heat_index(self, temp_c, humidity_percent):
        """Refined Heat Index for agricultural threshold monitoring."""
        adjustment = 0.05 * humidity_percent
        return temp_c + adjustment

    def detect_anomalies(self, current_temp):
        """Advanced: Detects if current reading is an outlier compared to history."""
        if len(self.history) < 3:
            return False
            
        temps = [r['temp'] for r in self.history]
        avg = sum(temps) / len(temps)
        std_dev = statistics.stdev(temps) if len(temps) > 1 else 0
        
        # Anomaly if current temp is > 2 standard deviations from mean
        return abs(current_temp - avg) > (2 * std_dev)

    def get_cropping_advisor(self, hi, humidity, stage="fruiting"):
        """Logic-based advisory system for specific crop stages."""
        if stage == "flowering":
            if hi > 38 or humidity > 85:
                return "🚨 CRITICAL: High risk of flower drop! Activate misting and mist-cooling."
            return "✨ OPTIMAL: Conditions are excellent for pollination."
        
        elif stage == "fruiting":
            if hi > 35:
                return "⚠️ WARNING: Heat stress may affect fruit size. Increase irrigation."
            return "✅ NORMAL: Growth conditions are stable."
        
        return "ℹ️ STATUS: Monitoring environmental parameters."

def main():
    print("--- RBRU-Praneet Climate Intelligence Platform (v2.0) ---")
    ai = ClimateIntelligence()
    
    # Simulating historical data
    historical_temps = [31.5, 32.0, 31.8, 32.2, 33.1]
    for ht in historical_temps:
        ai.log_reading(ht, 75)
    
    try:
        t = float(input("Enter current temperature (°C): "))
        h = float(input("Enter relative humidity (%): "))
        s = input("Enter crop stage (flowering/fruiting): ").lower() or "fruiting"
        
        # Analytics
        hi = ai.calculate_heat_index(t, h)
        is_anomaly = ai.detect_anomalies(t)
        advisory = ai.get_cropping_advisor(hi, h, s)
        
        # Results Output
        print("\n" + "="*45)
        print(f"📍 Location: {ai.location}")
        print(f"📊 Heat Index: {hi:.2f}°C")
        print(f"🔍 Anomaly Detection: {'⚠️ OUTLIER DETECTED' if is_anomaly else '✅ STABLE TREND'}")
        print(f"💡 Advisor: {advisory}")
        print("="*45)
        
    except ValueError:
        print("Error: Please enter valid numerical inputs.")

if __name__ == "__main__":
    main()
