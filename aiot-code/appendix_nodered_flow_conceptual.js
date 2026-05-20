// Node-RED Flow Logic (Conceptual JavaScript)
// Master Node: Initiates the request
function sendModbusRequest(slaveID, registerAddress, functionCode) {
    // 1. Construct the Modbus Frame: [Slave ID] + [Function Code] + [Starting Address] + [Number of Registers] + [CRC Checksum]
    let requestFrame = `${slaveID}:${functionCode}:${registerAddress}:${'2'}:${calculateCRC(data)}`;
    
    // 2. Send the request over the serial port (RS-485)
    return serialPort.write(requestFrame); 
}

// Slave Node: Processes the request
function processModbusRequest(incomingFrame) {
    // 1. Check the Slave ID in the incoming frame
    let receivedID = incomingFrame.split(':')[0];
    if (receivedID !== this.mySlaveID) {
        return "Error: Not my device.";
    }
    
    // 2. Read the requested register value (e.g., temperature)
    let value = readSensorData(registerAddress);
    
    // 3. Send the response back to the Master
    return `Success:${value}`;
}
