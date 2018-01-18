package metier;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Random;
import java.util.concurrent.TimeUnit;

public class sensor {
	
	private String id;
	
	private int sendFrequency;
	
	private int tempValue;
	private int moistureValue;
	private int lightValue;
	private double phValue;
	

	private variation tempVariation;
	private variation moistureVariation;
	private variation lightVariation;
	private variation phVariation;
	
	
	public variation getTempVariation() {
		return tempVariation;
	}



	public void setTempVariation(variation tempVariation) {
		this.tempVariation = tempVariation;
	}



	public variation getMoistureVariation() {
		return moistureVariation;
	}



	public void setMoistureVariation(variation moistureVariation) {
		this.moistureVariation = moistureVariation;
	}



	public variation getLightVariation() {
		return lightVariation;
	}



	public void setLightVariation(variation lightVariation) {
		this.lightVariation = lightVariation;
	}



	public variation getPhVariation() {
		return phVariation;
	}



	public void setPhVariation(variation phVariation) {
		this.phVariation = phVariation;
	}	
	
	
	public sensor(String id, int tempValue, int moistureValue, int lightValue, float phValue) {
		this.id = id;
		this.tempValue = tempValue;
		this.moistureValue = moistureValue;
		this.lightValue = lightValue;
		this.phValue = phValue;
	}
	
	
	
	public String getId() {
		return id;
	}

	public int getSendFrequency() {
		return sendFrequency;
	}



	public void setSendFrequency(int sendFrequency) {
		this.sendFrequency = sendFrequency;
	}



	public void setId(String id) {
		this.id = id;
	}

	public int getTempValue() {
		return tempValue;
	}

	public void setTempValue(int tempValue) {
		this.tempValue = tempValue;
	}

	public int getMoistureValue() {
		return moistureValue;
	}

	public void setMoistureValue(int moistureValue) {
		this.moistureValue = moistureValue;
	}

	public int getLightValue() {
		return lightValue;
	}

	public void setLightValue(int lightValue) {
		this.lightValue = lightValue;
	}

	public double getPhValue() {
		return phValue;
	}

	public void setPhValue(int phValue) {
		this.phValue = phValue;
	}
	
	public void display(){
		System.out.println("Sensor : " +this.id);
		System.out.println("Temperature : " +this.tempValue+"°C");
		System.out.println("Moisture : " +this.moistureValue+"%");
		System.out.println("Light : " +this.lightValue+" lux");
		System.out.println("pH : " +this.phValue);		
		System.out.println("------------------------");
	}
	
	public void newValues(){
		Random rand = new Random();
		int min,max;
		
		min=this.getTempValue()-this.tempVariation.getLesserValue();
		max=this.getTempValue()+this.tempVariation.getUpperValue();
		this.tempValue=rand.nextInt(max - min + 1) + min;
		
		min=this.getMoistureValue()-this.moistureVariation.getLesserValue();
		max=this.getMoistureValue()+this.moistureVariation.getUpperValue();
		this.moistureValue=rand.nextInt(max - min + 1) + min;
		
		min=this.getLightValue()-this.lightVariation.getLesserValue();
		max=this.getLightValue()+this.lightVariation.getUpperValue();
		this.lightValue=rand.nextInt(max - min + 1) + min;
		
		double minpH,maxpH;
		minpH=this.getPhValue()-this.phVariation.getLesserValue();
		maxpH=this.getPhValue()+this.phVariation.getUpperValue();
		this.phValue=minpH + (maxpH - minpH) * rand.nextDouble();
		double result=Math.round(this.phValue * Math.pow(10, 2)) / Math.pow(10, 2);
		this.phValue=result;
		
	}
	
	public String getTimeStamp() {
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.SSS");
		Date now = new Date();
		String strDate = sdf.format(now);
		return strDate;
	}
	
	public void start() throws InterruptedException{
		int baseTemp=this.getTempValue();
		int baseMoisture=this.getMoistureValue();
		int baseLight=this.getLightValue();
		double basepH=this.getPhValue();
		while(true){
			TimeUnit.SECONDS.sleep(this.sendFrequency);
			this.newValues();
			String topic="plantes/idclient";
			String JSON="{\"temp\":"+this.tempValue+",\"moisture\":"+this.moistureValue+",\"light\":"+this.lightValue+",\"pH\":"+this.phValue+",\"time stamp\":\""+getTimeStamp()+"\"}";
			//System.out.println(JSON);
			//this.display();
			//DONT FORGET TO mosquitto_sub -v -t 'plantes/idclient'
			String command = "C:\\Program Files (x86)\\mosquitto\\mosquitto_pub -t '"+topic+"' -m '"+JSON+"'";
			System.out.println(command);
			Runtime runtime = Runtime.getRuntime();
			Process process = null;
			try
			{
			process = runtime.exec(command);
			} catch(Exception err) {;}
			
			this.tempValue=baseTemp;
			this.moistureValue=baseMoisture;
			this.lightValue=baseLight;
			this.phValue=basepH;
		}
	}
	
	
	
}
