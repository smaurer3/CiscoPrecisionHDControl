#!/usr/bin/python
import serial

# Define the VISCA inquiry command
visca_inquiry = bytes.fromhex('01 01 81 09 06 12 FF')

# Open the serial port
ser = serial.Serial('/dev/ttyUSB0', 9600, timeout=0.5)

# Send the VISCA inquiry command to the camera
ser.write(visca_inquiry)

# Read the response from the camera
response = ser.read(5)

# Print the response as hex bytes
print('Response:', ' '.join(f'{b:02x}' for b in response))

# Close the serial port
ser.close()
