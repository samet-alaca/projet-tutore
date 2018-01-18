package main;

import java.io.IOException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

import metier.sensor;
import metier.variation;

public class main {

	public static void main(String[] args) throws InterruptedException, IOException {
		sensor s = new sensor("idcaptor1", 20, 30, 400, 7);
		s.setSendFrequency(3);
		s.setTempVariation(new variation(5,5));
		s.setMoistureVariation(new variation(5,5));
		s.setLightVariation(new variation(50,50));
		s.setPhVariation(new variation(2,2));
		s.start();
		
		//mosquitto_sub -v -t 'plantes/idclient'
		/*String command = "C:\\Program Files (x86)\\mosquitto\\mosquitto_pub -t 'plantes/idclient' -m '{\"temp\":19,\"moisture\":25,\"light\":356,\"pH\":8.6,\"time stamp\":\"2017-12-06 21:42:25.291\"}'";
		Runtime runtime = Runtime.getRuntime();
		Process process = null;
		try
		{
		process = runtime.exec(command);
		} catch(Exception err) {;}*/



	}

}
