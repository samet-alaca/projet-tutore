const mqtt = require('mqtt');
const mysql = require('mysql');
const express = require('express');
const bodyParser = require('body-parser');
const http = require('http');

var client = mqtt.connect('mqtt://iot.eclipse.org');
var app = express();

var connection = mysql.createConnection({
	host: 'localhost',
	user: 'root',
	password: '',
	database: 'tutore-dev'
});

app.use((request, response, next) => {
	response.setHeader('Access-Control-Allow-Origin', 'http://samet.nelva.fr');
	next();
});

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.post('/', (request, response, next) => {
	if(request.body.hasOwnProperty('subscribe')) {
		console.log('subscribed to ' + request.body.subscribe);
		client.subscribe(request.body.subscribe);
	}
	response.end();
});

app.listen(3123);
connection.connect();

serialize = function(obj) {
	var str = [];
	for(var p in obj)
	if (obj.hasOwnProperty(p)) {
		str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
	}
	return str.join("&");
}

function statecheck(data) {
	var state = {
		health: true,
		details: {
			light: 0,
			temp: 0,
			moisture: 0,
			ph: 0
		}
	};
	connection.query("SELECT plant FROM sensors WHERE id = ?", [data.sensor], function(error, results) {
		if(results.length > 0) {
			http.get('http://samet.nelva.fr/plantsAPI/?db=plant&table=data&column=ScientificName&value=' + results[0].plant, (response) => {
				let plant = '';
				response.on('data', (chunk) => {
					plant += chunk;
				});
				response.on('end', () => {
					plant = JSON.parse(plant)[0];
					if(plant.ShadeTolerance == 'Tolerant') {
						if(data.light < 400) {
							state.health = false;
							state.details.light = 1;
						}
					}
					if(plant.ShadeTolerance == 'Intermediate') {
						if(data.light < 1500) {
							state.health = false;
							state.details.light = 1;
						}
					}
					if(plant.ShadeTolerance == 'Intolerant') {
						if(data.light < 110000) {
							state.health = false;
							state.details.light = 1;
						}
					}

					if(plant.TemperatureMinimum > data.temp) {
						state.health = false;
						state.details.temp = 1;
					}

					if(plant.pH_Minimum > data.pH) {
						state.health = false;
						state.details.ph = 1;
					}
					if(plant.pH_Maximum < data.pH) {
						state.health = false;
						state.details.ph = 1;
					}

					if(plant.MoistureUse == 'Low') {
						if(data.moisture < 60) {
							state.health = false;
							state.details.moisture = 1;
						}
					}
					if(plant.MoistureUse == 'Medium') {
						if(data.moisture < 30) {
							state.health = false;
							state.details.moisture = 1;
						}
					}
					if(plant.MoistureUse == 'High') {
						if(data.moisture < 10) {
							state.health = false;
							state.details.moisture = 1;
						}
					}
					checkout(data, state);
				});
      		});
		}
	});
}

function checkout(data, state) {
	if(!state.health) {
		console.log("Plant from sensor " + data.sensor + " is not healthy");
		connection.query("SELECT parameter, healthy, unhealthy_since, notified FROM users, sensors WHERE users.id = sensors.owner AND sensors.id = ?", [data.sensor], function(error, results) {
			if(results.length > 0) {
				if(results[0].healthy) {
					connection.query("UPDATE sensors SET healthy = 0, unhealthy_since = ? WHERE id = ?", [data.stamp, data.sensor]);
				} else if(!results[0].notified) {
					var params = JSON.parse(results[0].parameter);
					if(data.stamp - results[0].unhealthy_since > params.time_lim * 60000) {
						console.log("Notification sent");
						var getParams = serialize({
							sensor: data.sensor,
							light: state.details.light,
							temp: state.details.temp,
							moisture: state.details.moisture,
							ph: state.details.ph
						});
						http.get('http://samet.nelva.fr/health-check/?' + getParams);
						connection.query("UPDATE sensors SET notified = 1 WHERE id = ?", [data.sensor]);
					}
					else {
						var d = Math.round(((params.time_lim * 60000) - (data.stamp - results[0].unhealthy_since)) / 1000);
						console.log("Notification will be sent in : " + d + 's');
					}
				}
			}
		});
	} else {
		console.log("Plant from sensor " + data.sensor + " is healthy");
		connection.query("UPDATE sensors SET healthy = 1, unhealthy_since = NULL, notified = 0 WHERE id = ?", [data.sensor]);
	}
}

client.on('message', (topic, message) => {
	var data = Buffer.from(message, 'hex').toString();
	data = data.split('$').join('"');
	try {
		var data = JSON.parse(data);
		if(data.hasOwnProperty('sensor')) {
			console.log('Data received from sensor ' + data.sensor);
			if(!data.hasOwnProperty('temp')) { data.temp = NULL; }
			if(!data.hasOwnProperty('moisture')) { data.moisture = NULL; }
			if(!data.hasOwnProperty('light')) { data.light = NULL; }
			if(!data.hasOwnProperty('pH')) { data.pH = NULL; }
			if(!data.hasOwnProperty('stamp')) { data.stamp = Date.now() }
			connection.query("INSERT INTO sensors_data SET ?", data);
		}
		statecheck(data);
	}
	catch(error) {
		console.log(error);
	}
});
