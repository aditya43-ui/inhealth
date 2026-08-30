
var type='';
$(function(){
	$('#dateStart').datetimepicker({
	});
	$('#dateEnd').datetimepicker({
	});
	$(document).on('change', '#select-penyakit', function(){
		type = $('#select-penyakit option:selected').val();

		//$('.list-parent').removeClass('active');
		//$(this).parent().addClass('active');
		var district_boundary = new L.geoJson();
		district_boundary.addTo(map);
		var feature_group = new L.featureGroup([]);
		// $.ajax({
		// 	dataType: "json",
		// 	url: "data/exp_KecamatanJavaBPSJune2010.js",
		// 	success: function(data) {
		// 	    $(data.features).each(function(key, data) {
		// 	        district_boundary.addData(data);
		// 	        district_boundary.setStyle({
		// 				color: '#afb38a',
		// 				fillColor: '#9c27b0',
		// 				weight: 1.3,
		// 				dashArray: '',
		// 				opacity: 1.0,
		// 				fillOpacity: 1.0
		// 			});
		// 	    });
		// 	}
		// });

		//alert('tes');
		var exp_KecamatanJavaBPSJune2010JSON = new L.geoJson(exp_KecamatanJavaBPSJune2010,{
			onEachFeature: pop_KecamatanJavaBPSJune2010,
			style: doStylePenyakit
		});
		layerOrder[layerOrder.length] = exp_KecamatanJavaBPSJune2010JSON;

		feature_group.addLayer(exp_KecamatanJavaBPSJune2010JSON);

		feature_group.addTo(map);
	});


		var chart;
        var legend;

        var chartData = [
            {
                "desakel": "Balewangi",
                "value": 260
            },
            {
                "desakel": "Cidatar",
                "value": 201
            },
            {
                "desakel": "Cipaganti",
                "value": 65
            },
            {
                "desakel": "Cisero",
                "value": 39
            },
            {
                "desakel": "Karamatwangi",
                "value": 19
            },
            {
                "desakel": "Pamulihan",
                "value": 10
            },
            {
                "desakel": "Pangauban",
                "value": 260
            },
            {
                "desakel": "Simpangsari",
                "value": 201
            },
            {
                "desakel": "Sirnagalih",
                "value": 65
            },
            {
                "desakel": "Sirnajaya",
                "value": 39
            },
            {
                "desakel": "Situsari",
                "value": 19
            },
            {
                "desakel": "Sukatani",
                "value": 10
            },
            {
                "desakel": "Sikawargi",
                "value": 19
            },
            {
                "desakel": "Tambakbaya",
                "value": 10
            }

        ];

        createFromToFields();

            // create from/to field values programatically
            function createFromToFields(){
                for(var i = 0; i < chartData.length; i++){
                    var value = chartData[i].value;
                    chartData[i].fromValue = value - value * 0.2;
                    chartData[i].toValue = value + value * 0.2;
                }
            }


            AmCharts.ready(function () {
                var chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                //chart.path = "../amcharts/";
                chart.categoryField = "desakel";
                //chart.dataDateFormat = "YYYY-MM-DD";

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                //categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                //categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                categoryAxis.gridAlpha = 0;
                categoryAxis.tickLength = 0;
                categoryAxis.axisAlpha = 0;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.dashLength = 4;
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);


                // FROM GRAPH
                var fromGraph = new AmCharts.AmGraph();
                fromGraph.type = "line";
                fromGraph.valueField = "fromValue";
                fromGraph.lineAlpha = 0;
                fromGraph.showBalloon = false;
                chart.addGraph(fromGraph);

                // TO GRAPH
                var toGraph = new AmCharts.AmGraph();
                toGraph.type = "line";
                toGraph.valueField = "toValue";
                toGraph.lineAlpha = 0;
                toGraph.fillAlphas = 0.2;
                toGraph.fillToGraph = fromGraph;
                toGraph.showBalloon = false;
                chart.addGraph(toGraph);


                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.type = "line";
                graph.valueField = "value";
                graph.lineColor = "#000000";
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("chartdiv");
            });
        //$('div.amcharts-chart-div a').remove();
        setTimeout(function(){$('div.amcharts-chart-div a').remove();}, 1000)

});

doStylePenyakit = function(feature) {


		var rangeOfKec = parseInt(feature.properties.KECNO);
				//console.log(rangeOfKec);
			retDefault = {
				color: '#afb38a',
				fillColor: '#fff9c4',
				weight: 1.3,
				dashArray: '',
				opacity: 1.0,
				fillOpacity: 1.0
			}
			if (type=="reset") {
				unsetStyleMap();
			}else {
				retDefault = stylingMap(rangeOfKec, type);
			}

		return retDefault;

}
unsetStyleMap = function() {
	var retDefault = {
		color: '#afb38a',
		fillColor: '#fff9c4',
		weight: 1.3,
		dashArray: '',
		opacity: 1.0,
		fillOpacity: 1.0
	}
	return retDefault;
}
stylingMap = function(a, type) {
	//console.log(a);
	var ret;
	switch (type) {
		case 'one': {
			if (a<50) {
				ret = {
					color: '#afb38a',
					fillColor: '#ef5350',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}else {
				ret = {
					color: '#afb38a',
					fillColor: '#fff9c4',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}
			break;
		}
		case 'two': {
			if (a>=50&&a<100) {
				ret = {
					color: '#afb38a',
					fillColor: '#ef5350',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}else {
				ret = {
					color: '#afb38a',
					fillColor: '#fff9c4',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}
			break;
		}
		case 'three': {
			if (a>=100&&a<150) {
				ret = {
					color: '#afb38a',
					fillColor: '#ef5350',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}else {
				ret = {
					color: '#afb38a',
					fillColor: '#fff9c4',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}
			break;
		}
		case 'four': {
			if (a>=150&&a<200) {
				ret = {
					color: '#afb38a',
					fillColor: '#ef5350',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}else {
				ret = {
					color: '#afb38a',
					fillColor: '#fff9c4',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}
			break;
		}
		case 'five': {
			if (a>=200&&a<250) {
				ret = {
					color: '#afb38a',
					fillColor: '#ef5350',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}else {
				ret = {
					color: '#afb38a',
					fillColor: '#fff9c4',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}
			break;
		}
		case 'six': {
			if (a>=250&&a<300) {
				ret = {
					color: '#afb38a',
					fillColor: '#ef5350',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}else {
				ret = {
					color: '#afb38a',
					fillColor: '#fff9c4',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}
			break;
		}
		case 'seven': {
			if (a>=300) {
				ret = {
					color: '#afb38a',
					fillColor: '#ef5350',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}else {
				ret = {
					color: '#afb38a',
					fillColor: '#fff9c4',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
			}
			break;
		}
	}
	/*if (a<100) {
		ret = {
			color: '#afb38a',
			fillColor: '#ef5350',
			weight: 1.3,
			dashArray: '',
			opacity: 1.0,
			fillOpacity: 1.0
		}
	}else if (a<200) {
		ret = {
			color: '#afb38a',
			fillColor: '#fff9c4',
			weight: 1.3,
			dashArray: '',
			opacity: 1.0,
			fillOpacity: 1.0
		}
	}else  {
		ret = {
			color: '#afb38a',
			fillColor: '#fff9c4',
			weight: 1.3,
			dashArray: '',
			opacity: 1.0,
			fillOpacity: 1.0
		}
	}*/
	return ret;
}
stylingMapTwo = function(a) {
	//console.log(a);
	var ret;
	if (a<100) {
		ret = {
			color: '#afb38a',
			fillColor: '#fff9c4',
			weight: 1.3,
			dashArray: '',
			opacity: 1.0,
			fillOpacity: 1.0
		}
	}else if (a<200) {
		ret = {
			color: '#afb38a',
			fillColor: '#fff9c4',
			weight: 1.3,
			dashArray: '',
			opacity: 1.0,
			fillOpacity: 1.0
		}
	}else  {
		ret = {
			color: '#afb38a',
			fillColor: '#ef5350',
			weight: 1.3,
			dashArray: '',
			opacity: 1.0,
			fillOpacity: 1.0
		}

	}
	return ret;
}
var markerGroup = new L.MarkerClusterGroup();
markerGroup.on('click', function(ev) {
    alert('tes');
});
