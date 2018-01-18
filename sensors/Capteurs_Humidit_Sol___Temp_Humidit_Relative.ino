#include <dht.h>


/*
 Pour les branchements des capteurs, se référer aux  .ino des dossiers Capteur_Temp_Humidité et Capteur Humidité du sol
 
 */

byte humidity_sensor_pin = A0;
byte humidity_sensor_vcc = 6;

dht DHT;

#define DHT11_PIN 3   //le modèle de la carte et le pin digitale de la carte arduino utilisé


int read_humidity_sensor() {
  digitalWrite(humidity_sensor_vcc, HIGH);
  delay(500);
  int value = analogRead(humidity_sensor_pin);
  digitalWrite(humidity_sensor_vcc, LOW);
  return 1023 - value;
}

void HumidSolLoop() {
  Serial.print("Humidité du sol: ");
  Serial.println(read_humidity_sensor()); 
  delay(1000);
}

void TempHumidLoop()
{
  delay(1000); //pause de 1 secondes entre chaque mesure
  int chk = DHT.read11(DHT11_PIN);
  Serial.print("Température = ");
  Serial.println(DHT.temperature);
  Serial.print("Humidité relative = ");
  Serial.println(DHT.humidity);
  Serial.print("\n");
}




void setup() {
  pinMode(humidity_sensor_vcc, OUTPUT);
  digitalWrite(humidity_sensor_vcc, LOW);

  // Setup Serial
  while (!Serial);
  delay(2000);
  Serial.begin(9600);   
  

}

void loop() {
  TempHumidLoop();
  HumidSolLoop();

}


