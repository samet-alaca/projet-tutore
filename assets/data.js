jQuery(function() {
	
	setInterval(updateCharts,240000);
	updateCharts();
	function updateCharts(){
  $.post(location.href, { chartjs: true }).done((data) => {
 
	var data = JSON.parse(data);
	var data_light = [];
	var data_pH = [];
	var data_moisture = [];
	var data_temp = [];
	var data_stamp = [];
	console.log(data.length);
	if (data.length > 144){
		for(i = data.length-144; i < data.length; i++){
			console.log(i);
		data_light.push(parseInt(data[i].light));
		data_pH.push(parseInt(data[i].pH));
		data_moisture.push(parseInt(data[i].moisture));
		data_temp.push(parseInt(data[i].temp));
		var date = new Date(parseInt(data[i].stamp));
		date = date.getDate() + "/" + (date.getMonth()+1) + " " + date.getHours() + ":" + date.getMinutes();
		data_stamp.push(date);
	}

	}
	else{
	for(i = 0; i < data.length; i++) {
		data_light.push(parseInt(data[i].light));
		data_pH.push(parseInt(data[i].pH));
		data_moisture.push(parseInt(data[i].moisture));
		data_temp.push(parseInt(data[i].temp));
		var date = new Date(parseInt(data[i].stamp));
		date = date.getDate() + "/" + (date.getMonth()+1) + " " + date.getHours() + ":" + date.getMinutes();
		data_stamp.push(date);
	}
	}
	
	
	var ctx = document.getElementById("myLineChart").getContext('2d');
	
	 var randomScalingFactor = function() {
        return Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5));
    };
var myLineChart = new Chart(ctx, {
    type: 'line',
        data: {
            labels: data_stamp,
            datasets: [{
				
                label: "Humidité",
                fill: false,
                data: data_moisture,
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor:'rgba(54, 162, 235, 1)',

				
            }, 
	
			{
                label: "Température",
                fill: false,
                data: data_temp,
				backgroundColor: 'rgba(255, 99, 132, 0.2)',
				borderColor:'rgba(255,99,132,1)',
            }, 
			
			{
                label: "pH",
                fill: false,
                data: data_pH,
				backgroundColor:  'rgba(75, 192, 192, 0.2)',
				borderColor:'rgba(75, 192, 192, 1)',
            }, 
			
			{
                label: "Luminosité",
                fill: false,
                data: data_light,
				backgroundColor: 'rgba(255, 206, 86, 0.2)',
				borderColor:'rgba(255, 206, 86, 1)',
            }]
        },
	options: {
            responsive: true,
            title:{
                display:true,
                text:'Statistiques des dernières 24h'
            },
            scales: {
                xAxes: [{
                    display: true,
                }],
                yAxes: [{
                    display: true,
                }]
            },
			bezierCurve: true,
			elements: {
            line: {
                tension: 0.5, // disables bezier curves
            }
        }
        }
});
	
	
	
	
	
	
  });
}});
