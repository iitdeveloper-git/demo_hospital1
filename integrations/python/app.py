from flask import Flask, request, jsonify
import random

app = Flask(__name__)

@app.route('/api/predict-severity', methods=['POST'])
def predict_severity():
    data = request.get_json() or {}
    symptoms = data.get('symptoms', [])
    
    # Calculate a severity score based on symptom parameters
    score = len(symptoms) * 15 + random.randint(0, 10)
    score = min(100, max(0, score))
    
    if score > 75:
        level = "Critical (Code Blue Warning)"
    elif score > 40:
        level = "Moderate Care Needed"
    else:
        level = "Mild Care"

    return jsonify({
        "status": "success",
        "severity_score": score,
        "severity_level": level,
        "notes": "Calculated by AarogyaCare Python CDSS microservice."
    })

if __name__ == '__main__':
    app.run(port=5000)
