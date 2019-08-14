#include<SPI.h> //Auxiliar da Ethernet
#include<Ethernet.h>
#include "DHT.h" 
#include <Wire.h> 
#include <LiquidCrystal_I2C.h> 
#include<String.h> 
#include <EEPROM.h>
//#include <Timing.h>

#define espacoEEPROM 1000   //1Kb para todos os Arduinos com ATMega328P
#define DHTPIN A1 // pino que estamos conectado
#define DHTTYPE DHT11 // DHT 11
#define Water_Level_Sensor 4 // Sensor nivel de agua 
#define PINO_ZC 2 // Pino digital 2 Rele Lampadas
#define PINO_DIM 9 // Pino digital 9 Rele Lampadas

byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};
byte servidor[] = {192, 168, 1, 4}; // IP Servidor (banco de dados)

IPAddress ip(192, 168, 1, 3); // IP Servidor no Arduiono
#define portaHTTP 80 //Porta do servidor
EthernetServer server(80);
EthernetClient clienteArduino;


DHT dht(DHTPIN, DHTTYPE);
LiquidCrystal_I2C lcd(0x27, 16, 2); 

int dl = 1000; //Delay luz
int releagua = 6;  //  Pino digital onde será ligado e desligado o RElÉ.
int buttonState = 1; // variável para ler o status do sensor Nivel de Agua;
int relemotor = 3; // Variavel do motor de rolagem 
boolean ciclo;
int cont = 1;
int teste = 0;
volatile long luminosidade =100 ;  // 0 a 100 
String readString = String(30);
//Timing timerBD;
//Timing timerContador;


void zeroCross()  { 
if (ciclo == true){
  if (luminosidade>100) luminosidade=100;
  if (luminosidade<0) luminosidade=0;
  long t1 = 8200L * (100L - luminosidade) / 100L;      
  delayMicroseconds(t1);   
  digitalWrite(PINO_DIM, HIGH);  
  delayMicroseconds(6);      // t2
  digitalWrite(PINO_DIM, LOW);   
}}

void setup() {
  Serial.begin(9600);
   Ethernet.begin(mac);
    if(Ethernet.begin(mac) == 0){
      Serial.println("Falha ao conectar a Rede");
      Ethernet.begin(mac);}
      else {Serial.print("Conectado a rede, no ip: ");
            Serial.println(Ethernet.localIP());}

 lcd.begin();
  dht.begin();

//   timerBD.begin(0); 
//  timerContador.begin(0);

 pinMode(Water_Level_Sensor, INPUT); // Sensor de Agua 
 pinMode(releagua, OUTPUT);  // Define o Pino Digita como saída.
 pinMode(relemotor, OUTPUT);  // Define o pino digital como saida.
 //comecar com o rele desligado
digitalWrite(releagua, LOW);
digitalWrite(relemotor, LOW);

pinMode(PINO_DIM, OUTPUT);
  attachInterrupt(0, zeroCross, RISING);
 
 ciclo = EEPROM.read(0);

boasVindas();
}

void loop() {
  float umidade = dht.readHumidity();
  float temperatura= dht.readTemperature();
   buttonState = digitalRead(Water_Level_Sensor);

  if(ciclo == true){
    lcd.backlight();
    lcd.setCursor(0, 0); // Definição da linha
    lcd.print("Umidade: "); //Linha de cima do LCD
    lcd.print(umidade); // Umidade
    lcd.print(" %"); // Simbolo de umidade do ar
    lcd.setCursor(0, 1); // Definição da linha 
    lcd.print("TEMP: "); // Linha de baixo do LCD
    lcd.print(temperatura); // Temperatura
    lcd.write(B11011111); //Simbolo de graus celsius
    lcd.print("C   "); // Continuação do simbolo


  rolagemPHP();
  lampadas();
 nivelAgua();
 sentdata();
 delay(2000);

  }
  else if(ciclo == false){
 //  Serial.println("Sem ciclo");
    lcd.setCursor(0, 0); // Definição da linha
    lcd.print("Chocadeira  UFSM");
    lcd.setCursor(0, 1); // Definição da linha
    lcd.print("Inicie um ciclo");   
  }

 receivedata();
  
}

void  nivelAgua(){
  if (buttonState == HIGH) {    
 // Serial.println( "NÍVEL DE ÁGUA - BAIXO");
  digitalWrite(releagua, HIGH); //Aciona relé
  }
  else { 
 // Serial.println( "NÍVEL DE ÁGUA - ALTO" );
  digitalWrite(releagua, LOW); //Desliga relé
  }

}

void lampadas(){
  float temperatura= dht.readTemperature();
  
  if (temperatura < 35.00){  
    luminosidade=90;
    delay(dl);}
    
  if (temperatura >= 33.00 && temperatura <=35.00){
    luminosidade=50;
   delay(dl);}
    
  if (temperatura >= 36.00 && temperatura <=37.00){
    luminosidade=35;
    delay(dl);}
    
  if (temperatura >= 38.00 && temperatura <= 39){
    luminosidade=25;
    delay(dl);}
    
  if (temperatura>= 40){
    luminosidade=0;
    delay(dl);}
} 



void receivedata(){
  EthernetClient client = server.available();


 if(client)
 {
  while(client.connected())
  {
    if(client.available())
    {
      char c = client.read();

      if(readString.length() < 30){
        readString += (c);
      }

      if(c == '\n'){
        Serial.print(readString);

        if(readString.indexOf("iniciarCiclo") >= 0){
         ciclo = true;
         EEPROM.write(0, ciclo);
        }
        else if(readString.indexOf("encerarCiclo") >= 0){
         ciclo = false;
         EEPROM.write(0, ciclo);
        }
        if(readString.indexOf("ligar") >= 0){
          digitalWrite(relemotor, HIGH);
        //  delay(2000);
          //digitalWrite(relemotor, LOW);
        }
        if(readString.indexOf("off") >= 0){
          digitalWrite(relemotor, LOW);
        }
                
        readString = "";
        
        client.stop();
    }
   }
  }
 }
}

 void rolagemPHP(){

    Serial.println("Atualizando Status");

  if(clienteArduino.connect(servidor,80)){


     clienteArduino.print("GET /Chocadeira2.0/comunicaArduino.php");
                                               
    clienteArduino.println(" HTTP/1.0");

     
    clienteArduino.println("Host: 192.168.1.4");
    clienteArduino.println("Connection:close");
    clienteArduino.println();
    clienteArduino.stop();
  }else {
    Serial.println("Falha no Comunicação");
    clienteArduino.stop();
  }
 }

 
 void sentdata(){
    float umidade = dht.readHumidity();
  float temperatura= dht.readTemperature();
  
    Serial.println("Conectando ao servidor e enviando dados");
    Serial.println("Temperatura: ");
    Serial.print(temperatura);
    Serial.print("Umidade: ");
    Serial.println(umidade);
    Serial.print("Luminosidade: ");
    Serial.println(luminosidade);
    
    
  if(clienteArduino.connect(servidor,80)){

   // clienteArduino.println("GET /chocadeira/salvardados.php HTTP/1.0");
     clienteArduino.print("GET /Chocadeira2.0/salvardados.php?");
     clienteArduino.print("temperatura=");
      clienteArduino.print(temperatura);
       clienteArduino.print("&umidade=");
        clienteArduino.print(umidade);
         clienteArduino.print("&luminosidade=");
          clienteArduino.print(luminosidade);
           clienteArduino.print("&bomba=");
            clienteArduino.print(buttonState);        
        clienteArduino.println(" HTTP/1.0");
          clienteArduino.println("Host: 192.168.1.4");
         clienteArduino.println("Connection:close");
         clienteArduino.println();
         clienteArduino.stop();
   
  }else {
    Serial.println("Falha na conexao com o servidor");
    clienteArduino.stop();
  }
 }


void boasVindas(){
      lcd.backlight();
      lcd.setCursor(0,0); 
      lcd.print("  Start Sistem");
      lcd.setCursor(0,1); 
      lcd.print("    ufsm.br");
      delay(3000);
    
      lcd.clear();

      lcd.setCursor(0,0); 
      lcd.print("Chocadeira v3.0");
      lcd.setCursor(0,1);
      for( int i=0 ; i<16 ; i++ )
      {
        lcd.print(".");
        delay(250);
      }
    
      lcd.clear();
 }
