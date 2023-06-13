#include <WiFi.h>
#include "DHT.h"

#define DHTPIN 16
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);

const char* ssid = "bssm_free";
const char* password = "bssm_free";
const char* host = "10.150.150.110";

// 버튼과 LED에 연결된 핀 번호를 정의합니다.
const int BUTTON_PIN = 5;
const int LED_PIN = 17;
const int RELAY_PIN = 18;

// 이전 버튼 상태를 저장하는 변수를 선언합니다.
int previousButtonState = HIGH;

// LED의 현재 상태를 저장하는 변수를 선언합니다.
bool ledState = LOW;
bool relayState = LOW;

WiFiClient client;

void setup() {
  Serial.begin(115200);
  dht.begin();
  // 버튼 핀을 입력으로 설정합니다.
  pinMode(BUTTON_PIN, INPUT);

  // LED 핀을 출력으로 설정합니다.
  pinMode(LED_PIN, OUTPUT);
  pinMode(RELAY_PIN, OUTPUT);
  digitalWrite(RELAY_PIN, relayState);

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) { //와이파이가 연결될 때 까지 무한루프
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  // put yourmain code here, to run repeatedly:
  // 1회 서버에 request
  // 1.클라이언트가 서버에 접속한다

  if (!client.connect(host, 80)) {
    Serial.println("connection failed");
    return;
  }
  Serial.println("서버와 연결되었습니다!");

  // 버튼의 현재 상태를 읽어옵니다.
  int buttonState = digitalRead(BUTTON_PIN);

  // 버튼의 상태가 이전과 다를 경우에만 실행합니다.
  if (buttonState != previousButtonState) {
    // 버튼이 눌렸을 때만 동작합니다.
    if (buttonState == LOW) {
      // LED 상태를 반전시킵니다.
      ledState = !ledState;
      relayState = !relayState;
      // LED를 켜거나 끕니다.
      digitalWrite(LED_PIN, ledState);  
      digitalWrite(RELAY_PIN, relayState);
      // 현재 LED 상태를 시리얼 모니터에 출력합니다.
      Serial.println(ledState);
      Serial.println(ledState ? "LED ON" : "LED OFF");
    }
  }

  // 이전 버튼 상태를 업데이트합니다.
  previousButtonState = buttonState;

  //2.클라이언트가 서버에 request를 전송한다.

  float humi = dht.readHumidity();
  float temp = dht.readTemperature();

  Serial.println(ledState);
  Serial.println(humi);
  Serial.println(temp);

  String url = "/smarthome_front/insert.php?tem_status=" + String(temp) + "&hum_status=" + String(humi) + "&led_status=" + String(ledState);
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Connection: close\r\n\r\n");

  //3.서버가 클라이언트에게 response를 전송한다.
  unsigned long t = millis(); //생존시간
  while(1){
    if(client.available()) break;
    if(millis() - t > 10000) break;
  }

  //응답이 왔거나 시간안에 응답이 안왔다!
  Serial.println("응답이 도착했습니다.");
  while(client.available()){
    Serial.write(client.read());
  }

  //4.둘 사이의 연결이 끊어진다!
  Serial.println("연결이 해제되었습니다!");
  delay(100);
}