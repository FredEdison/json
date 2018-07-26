#include <SPI.h>
#include <ESP8266WiFi.h>
#include <Adafruit_NeoPixel.h>
#include <ArduinoJson.h>


// Define Pinouts for the functions as discussed by Derek 1,2,5,6

#define PIN D1  // Define PIN1 as PIN1 on the Board
#define PIN2 D2  // Define PIN2 as PIN2 on the Board
#define PIN5 D5  // Define PIN5 as PIN5 on the Board
#define PIN6 D6  // Define PIN6 as PIN6 on the Board

// START EDITING HERE FOR WIFI INFROMATION

const char* ssid     = "ANGMAR";
const char* password = "Becker50";   // your network password (use for WPA, or use as key for WEP)
int keyIndex = 0;            // your network key Index number (needed only for WEP)
String devid="Fred 1";  //USED TO BRING IN DATA FROM SERVER

// STOP EDITING HERE FOR WIFI INFROMATION


// WAIT TIME CONFIGURATION

int waittime = 1; // 15 secs

// Parameter 1 = number of pixels in strip
// Parameter 2 = Arduino pin number (most are valid)
// Parameter 3 = pixel type flags, add together as needed:
//   NEO_KHZ800  800 KHz bitstream (most NeoPixel products w/WS2812 LEDs)
//   NEO_KHZ400  400 KHz (classic 'v1' (not v2) FLORA pixels, WS2811 drivers)
//   NEO_GRB     Pixels are wired for GRB bitstream (most NeoPixel products)
//   NEO_RGB     Pixels are wired for RGB bitstream (v1 FLORA pixels, not v2)
//   NEO_RGBW    Pixels are wired for RGBW bitstream (NeoPixel RGBW products)

// START ADJUSTING THE  NUMBER OF LEDS IN EACH STRIP IN PARAMETER 1

Adafruit_NeoPixel strip1 = Adafruit_NeoPixel(24, 4, NEO_GRB + NEO_KHZ800);
Adafruit_NeoPixel strip2 = Adafruit_NeoPixel(24, 14, NEO_GRB + NEO_KHZ800);
Adafruit_NeoPixel strip3 = Adafruit_NeoPixel(24, 12, NEO_GRB + NEO_KHZ800);
Adafruit_NeoPixel strip4 = Adafruit_NeoPixel(24, 5, NEO_GRB + NEO_KHZ800);

// END ADJUSTING THE  NUMBER OF LEDS IN EACH STRIP IN PARAMETER 1



int status = WL_IDLE_STATUS;
// if you don't want to use DNS (and reduce your sketch size)
// use the numeric IP instead of the name for the server:
//IPAddress server(74,125,232,128);  // numeric IP for Google (no DNS)
char server[] = "www.frededison.com";    // name address for Google (using DNS)
String data="";

// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
WiFiClient client;

void setup() {
  
  //Initialize serial and wait for port to open:
  Serial.begin(115200);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }

    

  WiFi.begin(ssid, password);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println("Connected to wifi");
  printWifiStatus();
  
  // Init all Strips  to Off on start.
  strip1.begin();
  strip1.show(); // Initialize all pixels to 'off' for stip 1
  strip2.begin();
  strip2.show(); // Initialize all pixels to 'off' for stip 2
  strip3.begin();
  strip3.show(); // Initialize all pixels to 'off' for stip 3
  strip4.begin();
  strip4.show(); // Initialize all pixels to 'off' for stip 4
  //strip1.setBrightness(40);
  //strip2.setBrightness(40);
}

void loop() {
  
  // if there are incoming bytes available
  // from the server, read them and print them:
 if (!client.connected()) {
  data="NoData";
  Serial.println("\nStarting connection to server...");
  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.println("connected to server");
    // Make a HTTP request:
    if (devid=="Fred 1"){
     Serial.println("Fred 1");
    client.println("GET /control/fred1.json HTTP/1.1");
    }
    if (devid=="Fred 2"){
    Serial.println("Fred 2");
    client.println("GET /control/fred2.json HTTP/1.1");
    }
    if (devid=="Fred 3"){
    Serial.println("Fred 3");
    client.println("GET /control/fred3.json HTTP/1.1");
    }
    client.println("Host: www.frededison.com");
    client.println("Connection: close");
    client.println();
  }
 }
  //data="";
  if (client.connected()) {

//Serial.println(client);
// Check HTTP status
  char status[24] = {0};
   Serial.println("Line1");
  client.readBytesUntil('\r', status, sizeof(status));
   
 // Serial.println(line);
  if (strcmp(status, "HTTP/1.1 200 OK") != 0) {
    Serial.print(F("Unexpected response: "));
    Serial.println(status);
    client.stop();
    return;
  }

  // Skip HTTP headers
  char endOfHeaders[] = "\r\n\r\n";
  if (!client.find(endOfHeaders)) {
    Serial.println(F("Invalid response"));
   return;
  }

 
 const size_t bufferSize = JSON_OBJECT_SIZE(2) + 64*JSON_OBJECT_SIZE(3) + 2*JSON_OBJECT_SIZE(24) + 1080;
  DynamicJsonBuffer jsonBuffer(bufferSize);

  // Parse JSON object
  JsonObject& root = jsonBuffer.parseObject(client);
  if (!root.success()) {
    Serial.println(F("Parsing failed!"));
    return;
  }

  // Extract values
  
   //root.printTo(Serial);
   //Serial.println("");
   Serial.println("Starting to parse Data");
   //Serial.println(int(root["from_led"]));
   //colorWipe(strip.Color(int(root["R"]),int(root["G"]),int(root["B"])),50,int(root["from_led"]),int(root["to_led"]));
   //Serial.println("Starting Loop for 31 Leds");
   for(uint8_t i=0; i<24; i++) {

    //Serial.println("Getting Data for Led"+i);
    
    JsonObject& DataA =root["Data A"][String(i)+"A"];
    
    uint32_t c1 = strip1.Color(int(DataA["R"]),int(DataA["G"]),int(DataA["B"]));
    strip1.setPixelColor(i, c1);
    strip1.show();
    Serial.printf("A %d with %d \n",i,c1);
    


    JsonObject& DataB =root["Data B"][String(i)+"B"];
    uint32_t c2 = strip2.Color(int(DataB["R"]),int(DataB["G"]),int(DataB["B"]));
    strip2.setPixelColor(i, c2);
    Serial.printf("B %d with %d \n",i,c2);
    strip2.show();
    
    

   JsonObject& DataC =root["Data C"][String(i)+"C"];
    
    uint32_t c3 = strip3.Color(int(DataC["R"]),int(DataC["G"]),int(DataC["B"]));
    strip3.setPixelColor(i, c3);
    strip3.show();
    Serial.printf("C %d with %d \n",i,c3);
    


    JsonObject& DataD =root["Data D"][String(i)+"D"];
    uint32_t c4 = strip4.Color(int(DataD["R"]),int(DataD["G"]),int(DataD["B"]));
    strip4.setPixelColor(i, c4);
    Serial.printf("D %d with %d \n",i,c4);
    strip4.show();
    
    
    
       
   
   }
   
   client.stop();

 
  }
  // if the server's disconnected, stop the client:
  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting from server.");
    client.stop();

    // do nothing forevermore:
   // while (true);
  }
  delay (waittime);
}


void printWifiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}





