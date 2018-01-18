/*
 De gauche à droite :
 1ere broche->port 5V
 2e broche-> port GND
 3e broche->port digital 6
 4e broche->port A0
 */

byte humidity_sensor_pin = A0;
byte humidity_sensor_vcc = 6;

void setup() {
  // Initialisation de l'humidité
  pinMode(humidity_sensor_vcc, OUTPUT);
  digitalWrite(humidity_sensor_vcc, LOW);

  //Démarrage du setup
  while (!Serial);
  delay(1000); //pause de 1 sec 
  Serial.begin(9600);
}

int read_humidity_sensor() {
  digitalWrite(humidity_sensor_vcc, HIGH); //lecture de l'humidité relative
  delay(500);
  int value = analogRead(humidity_sensor_pin);
  digitalWrite(humidity_sensor_vcc, LOW);
  return 1023 - value;
}

void loop() {
  Serial.print("Humidité du sol: ");
  Serial.println(read_humidity_sensor()); 
  delay(1000);
}
