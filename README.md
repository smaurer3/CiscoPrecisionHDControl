# CiscoPrecisionHDControl
Control Cisco Precision HD Cameras.

Basic code to control a Cisco/Tanberg Precision HD camera from a serial port.  Creates a websocket server for you to send json commands to control the camera.

It also stores preset positions for the camera as these cameras don't have presets built in.

Tested on a Raspberry Pi 3B+ with a USB to serial adapter.

Much of the code was written by ChatGPT, although I then tweaked it and added the preset functionality cause I couldn'd think of how to explain what I wanted to do in 
terms where ChatGPT would write the intended outcome, I could only think of it as programming code so figured it would be easier to write myself.
