# Firmware
This directory contains the firmware for the ESP8266 units. The structure here is for PlatformIO, but it should be fairly easy to change to any other
system (e.g. Arduino IDE).

Note that you need to add your `own WiFiDetails.h` in `include` which provides `STASSID`, `STAPSK`, `ENDPOINT`, and `SECRET`.
