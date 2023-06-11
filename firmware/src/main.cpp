#include <Arduino.h>
#include <Wire.h>
#include <AHTxx.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include "WiFiDetails.h"

const char* location = "jenny_bedroom"; // CHANGE FOR EACH DEVICE
                               // and make sure it agrees with what the website
                               // is looking for (i.e. exists in web/locations.php)

const char* ssid = STASSID;
const char* password = STAPSK;
const char* endpoint = ENDPOINT;
const char* secret = SECRET;

AHTxx sensor(AHTXX_ADDRESS_X38, AHT2x_SENSOR);

const uint8_t sda = 0; // SDA GPIO, D3
const uint8_t scl = 2; // SCL GPIO, D4

void logData();
bool sendHTTPPost(float temp, float humidity);

void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);

  Serial.println();
  Serial.println();
  Serial.print(F("Connecting to "));
  Serial.println(ssid);

  /* Explicitly set the ESP8266 to be a WiFi-client, otherwise, it by default,
     would try to act as both a client and an access-point and could cause
     network-issues with your other WiFi-devices on your WiFi-network. */
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(F("."));
  }

  Serial.println(F(""));
  Serial.println(F("WiFi connected"));
  Serial.println(F("IP address: "));
  Serial.println(WiFi.localIP());

  // Enable temperature sensor:
  while (sensor.begin(sda, scl) != true) {
    Serial.println(F("AHT2x not yet connected..."));
    delay(5000);
  }

  Serial.println(F("AHT2x OK!"));
}

void loop() {
  logData();
  delay(1000 * 60 * 5); // Wait 5 minutes between samples
}

// put function definitions here:
void logData() {
  float temp = sensor.readTemperature();
  if (temp == AHTXX_ERROR) {
    sensor.softReset();
  }

  float humidity = sensor.readHumidity(AHTXX_USE_READ_DATA);
  if (humidity == AHTXX_ERROR) {
    sensor.softReset();
  }

  sendHTTPPost(temp, humidity);

}

// For Reference:
// https://stackoverflow.com/questions/65963963/sending-post-request-to-php-file-via-arduino

bool sendHTTPPost(float temp, float humidity) {
  WiFiClient client;
  HTTPClient http;
  http.begin(client, endpoint);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  char buf [200];
  snprintf(buf, 200, "location=%s&temperature=%f&humidity=%f&secret=%s", 
    location, temp, humidity, secret);
  Serial.println(buf);
  int httpCode = http.POST(buf);

  if (httpCode > 0) {
      Serial.printf("[HTTP] POST... code: %d\n", httpCode);

      if (httpCode == HTTP_CODE_OK) {
        const String& payload = http.getString();
        Serial.println(F("received payload:\n<<"));
        Serial.println(payload);
        Serial.println(F(">>"));
      }
    } else {
      Serial.printf("[HTTP] POST... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }

  http.end();

  return true;

}