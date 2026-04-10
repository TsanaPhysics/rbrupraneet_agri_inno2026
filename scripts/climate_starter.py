#!/usr/bin/env python3
"""
RBRU-Praneet Digital Agri-Innovation Center
Workshop 1: Climate Data Hacking Starter Script
-----------------------------------------------
This script calculates the Heat Index to assess risks for durian orchards.
"""

import math

def calculate_heat_index(temp_c, humidity_percent):
    """
    Simulates a refined Heat Index calculation for agricultural use.
    Logic: Feeling = Temperature + (Relative Humidity Adjustment)
    """
    # Simple agricultural approximation
    adjustment = 0.05 * humidity_percent
    heat_index = temp_c + adjustment
    return heat_index

def analyze_risk(hi):
    """Provides a recommendation based on the heat index."""
    if hi > 38:
        return "CRITICAL: High risk of flower drop. Activate misting system."
    elif hi > 34:
        return "WARNING: Moderate heat stress. Monitor soil moisture closely."
    else:
        return "NORMAL: Conditions are optimal for durian growth."

def main():
    print("--- RBRU Climate Intelligence Tool ---")
    
    # User Input Simulation
    try:
        t = float(input("Enter current temperature (°C): "))
        h = float(input("Enter relative humidity (%): "))
        
        # Process
        hi = calculate_heat_index(t, h)
        risk_message = analyze_risk(hi)
        
        # Result
        print(f"\nResulting Heat Index: {hi:.2f}°C")
        print(f"Advisory: {risk_message}")
        
    except ValueError:
        print("Error: Please enter valid numerical values.")

if __name__ == "__main__":
    main()
