#!/usr/bin/env python3
"""
RBRU-Praneet Digital Agri-Innovation Center
Workshop 2: CNN for Plant Disease Starter Script
------------------------------------------------
This script demonstrates image preprocessing and model inference logic.
"""

import os

# Note: In a real environment, students would use:
# import cv2
# import tensorflow as tf

def preprocess_image(image_path):
    """Simulates image reading and normalization."""
    basename = os.path.basename(image_path)
    print(f"--- Processing: {basename} ---")
    
    # Simulating OpenCV steps:
    # 1. Read
    # 2. Resize to (128, 128)
    # 3. Normalize pixels (0-1 range)
    print("Normalizing pixel values...")
    return f"Processed_{basename}"

def mock_inference(processed_image):
    """Simulates a CNN model's prediction."""
    # Dummy probability output
    # Categories: [Normal, Leaf Spot, Red Rust]
    probabilities = [0.05, 0.90, 0.05]
    
    # Get the index of the highest probability
    prediction_idx = 1
    labels = ["Healthy Leaf", "Leaf Spot Detected", "Red Rust Detected"]
    
    return labels[prediction_idx], probabilities[prediction_idx]

def main():
    print("--- RBRU Plant Vision Hub ---")
    
    # Test simulation
    test_leaf = "durian_leaf_01.jpg"
    
    processed = preprocess_image(test_leaf)
    result, confidence = mock_inference(processed)
    
    print("-" * 30)
    print(f"FINDING: {result}")
    print(f"CONFIDENCE: {confidence * 100:.2f}%")
    print("-" * 30)
    print("Next Step: Apply fungicide targeting Leaf Spot if confidence > 80%.")

if __name__ == "__main__":
    main()
