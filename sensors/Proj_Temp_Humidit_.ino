#include <dht.h>


/*Branchements préalables :
Brancher le capteur sur votre breadbord;
Branche les fils comme montré sur l'image présente dans le dossier Capteur_Temp_Humidité
N'oubliez pas d'inclure la librairie DHTLib.zip fournie dans le dossier Capteur_Temp_Humidité
Pour cela allez dans Croquis->Inclure une bibliothèque->Ajouter la bibliothèque ZIP et sélectionnez la bibliothèque
5V : broche  Milieu
GND2: broche droite
PortDigital 3: broche  gauche
*/

dht DHT;

#define DHT11_PIN 3   //le modèle de la carte et le pin digitale de la carte arduino utilisé

void setup(){
		//initialisation 
  Serial.begin(9600);           
}

void loop()
{
  delay(1000); //pause de 1 secondes entre chaque mesure
  int chk = DHT.read11(DHT11_PIN);
  Serial.print("Température = ");
  Serial.println(DHT.temperature);
  Serial.print("Humidité = ");
  Serial.println(DHT.humidity);
}

