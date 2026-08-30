<!DOCTYPE html>
<html>
	<head>
		<title>Garut</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
		<link rel="stylesheet" href="css/MarkerCluster.css" />
		<link rel="stylesheet" href="css/MarkerCluster.Default.css" />
		<link rel="stylesheet" type="text/css" href="css/own_style.css">
		<link rel="stylesheet" href="css/label.css" />
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">

		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

		<script src="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
		<script src="js/leaflet-hash.js"></script>
		<script src="js/label.js"></script>
		<script src="js/Autolinker.min.js"></script>
		<script src="js/leaflet.markercluster.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>


		<script src="js/moment.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
		<script src="js/amcharts.js" type="text/javascript"></script>
        <script src="js/pie.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/penyebaran-diagnosa.js"></script>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	</head>
	<body>
		<div class="row full-height" >
			<div class="col-md-7">
				<div class="panel panel-primary">
					<div class="panel-heading">
		    		Peta Administrasi Garut
		  		</div>
					<div class="panel-body">
						<div id="map" style="height: 600px"></div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Filter Tanggal
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class='input-group date' id='dateStart'>
									<input type='text' class="form-control" placeholder="start date" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class='input-group date' id='dateEnd'>
									<input type='text' class="form-control" placeholder="end date" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						Tipe Penyebaran
					</div>
					<div class="panel-body">
						<select id="select-penyakit" class="selectpicker show-tick" data-width="100%">
							<option value="jumpasien">Jumlah Pasien</option>
							<option value="usia">Usia</option>
						</select>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						Penyebaran Jumlah Pasien Kecamatan Cisurupan per Desa/Kel
					</div>
					<div class="panel-body">
						<div id="chartdiv" style="width: 100%; height: 345px;"></div>
					</div>
				</div>
			</div>
		</div>

		<script src="data/exp_KecamatanJavaBPSJune2010.js"></script>
		<script>
		var map = L.map('map', {
			zoomControl:true, maxZoom:19
		}).fitBounds([[-9.64247661486,105.822860505],[-5.08197426791,111.687290266]]);
		var hash = new L.Hash(map);
		var additional_attrib = '';
		var feature_group = new L.featureGroup([]);
		var raster_group = new L.LayerGroup([]);
		var basemap_0 = L.tileLayer('http://{s}.www.toolserver.org/tiles/bw-mapnik/{z}/{x}/{y}.png', {
			attribution: additional_attrib + '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors,<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
		});
		basemap_0.addTo(map);
		var layerOrder=new Array();
		function pop_KecamatanJavaBPSJune2010(feature, layer) {
			var popupContent = '<table><tr><th scope="row">PROVINSI</th><td>' + Autolinker.link(String(feature.properties['PROVINSI'])) + '</td></tr><tr><th scope="row">KABKOT</th><td>' + Autolinker.link(String(feature.properties['KABKOT'])) + '</td></tr><tr><th scope="row">KECAMATAN</th><td>' + Autolinker.link(String(feature.properties['KECAMATAN'])) + '</td></tr>	<th scope="row">KodeBPS</th><td>' + Autolinker.link(String(feature.properties['KodeBPS'])) + '</td></tr></table>';
			layer.bindPopup(popupContent);
		}

		function doStyleKecamatanJavaBPSJune2010(feature) {
				//console.log(feature);
				var retDefault = {
					color: '#afb38a',
					fillColor: '#f0f4c3',
					weight: 1.3,
					dashArray: '',
					opacity: 1.0,
					fillOpacity: 1.0
				}
				var rangeOfKec = parseInt(feature.properties.KECNO);
				console.log(rangeOfKec);
				if (rangeOfKec<50) {
					retDefault = {
						color: '#afb38a',
						fillColor: '#e6ee9c',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else if (rangeOfKec<100) {
					retDefault = {
						color: '#afb38a',
						fillColor: '#ffff00',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else if (rangeOfKec<100) {
					retDefault = {
						color: '#afb38a',
						fillColor: '#dce775',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else if (rangeOfKec<150) {
					retDefault = {
						color: '#afb38a',
						fillColor: '#d4e157 ',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else if (rangeOfKec<200) {
					retDefault = {
						color: '#afb38a',
						fillColor: '#cddc39',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else if (rangeOfKec<250) {
					retDefault = {
						color: '#c0ca33',
						fillColor: '#cddc39',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else if (rangeOfKec<300) {
					retDefault = {
						color: '#c0ca33',
						fillColor: '#afb42b',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else if (rangeOfKec<350) {
					retDefault = {
						color: '#c0ca33',
						fillColor: '#9e9d24',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}else {
					retDefault = {
						color: '#c0ca33',
						fillColor: '#827717',
						weight: 1.3,
						dashArray: '',
						opacity: 1.0,
						fillOpacity: 1.0
					}
				}


				return retDefault;

		}
		var exp_KecamatanJavaBPSJune2010JSON = new L.geoJson(exp_KecamatanJavaBPSJune2010,{
			onEachFeature: pop_KecamatanJavaBPSJune2010,
			style: doStyleKecamatanJavaBPSJune2010
		});
		layerOrder[layerOrder.length] = exp_KecamatanJavaBPSJune2010JSON;
		for (index = 0; index < layerOrder.length; index++) {
			feature_group.removeLayer(layerOrder[index]);feature_group.addLayer(layerOrder[index]);
		}
		//add comment sign to hide this layer on the map in the initial view.
		feature_group.addLayer(exp_KecamatanJavaBPSJune2010JSON);

		feature_group.addTo(map);
		var title = new L.Control();
		title.onAdd = function (map) {
			this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
			this.update();
			return this._div;
		};
		title.update = function () {
			this._div.innerHTML = '<h2>Garut</h2>Peta Penyebaran Pasien '
		};
		title.addTo(map);
		var legend = L.control({position: 'bottomright'});
		legend.onAdd = function (map) {
			var div = L.DomUtil.create('div', 'info legend');
			div.innerHTML = '<h3>Keterangan</h3><table> <tr> <td> <div class="a0_50"></div></td><td>:</td><td>kurang 500</td></tr><tr> <td> <div class="a50_100"></div></td><td>:</td><td>500 - 1.000</td></tr><tr> <td> <div class="a100_150"></div></td><td>:</td><td>1.000 - 1.500</td></tr><td> <div class="a150_200"></div></td><td>:</td><td>1.500 - 2.000</td></tr><tr> <td> <div class="a200_250"></div></td><td>:</td><td>2.000 - 2.500</td></tr><tr> <td> <div class="a250_300"></div></td><td>:</td><td>2.500 - 3.000</td></tr><tr> <td> <div class="a300_350"></div></td><td>:</td><td>3.000 - 3.500</td></tr><tr> <td> <div class="a350_400"></div></td><td>:</td><td>3.500 - 4.000</td></tr><tr> <td> <div class="a400_more"></div></td><td>:</td><td>4.000 lebih</td></tr></table>';
    		return div;
		};
		legend.addTo(map);
	var baseMaps = {
		'OSM Black & White': basemap_0
	};
		//L.control.layers(baseMaps,{"KecamatanJavaBPSJune2010": exp_KecamatanJavaBPSJune2010JSON},{collapsed:false}).addTo(map);
		function updateOpacity(value) {
	}
		L.control.scale({options: {position: 'bottomleft',maxWidth: 100,metric: true,imperial: false,updateWhenIdle: false}}).addTo(map);
	</script>
	<style>
		.a0_50 {
			border: solid #f0f4c3 1px;
			border-radius: 50%;
			background-color: #f0f4c3;
			width: 15px;
			height: 15px;
		}
		.a50_100 {
			border: solid #e6ee9c 1px;
			border-radius: 50%;
			background-color: #e6ee9c;
			width: 15px;
			height: 15px;
		}
		.a100_150 {
			border: solid #dce775 1px;
			border-radius: 50%;
			background-color: #dce775;
			width: 15px;
			height: 15px;
		}
		.a150_200 {
			border: solid #d4e157 1px;
			border-radius: 50%;
			background-color: #d4e157;
			width: 15px;
			height: 15px;
		}
		.a200_250 {
			border: solid #cddc39 1px;
			border-radius: 50%;
			background-color: #cddc39;
			width: 15px;
			height: 15px;
		}
		.a250_300 {
			border: solid #c0ca33 1px;
			border-radius: 50%;
			background-color: #c0ca33;
			width: 15px;
			height: 15px;
		}
		.a300_350 {
			border: solid #afb42b 1px;
			border-radius: 50%;
			background-color: #afb42b;
			width: 15px;
			height: 15px;
		}
		.a350_400 {
			border: solid #9e9d24 1px;
			border-radius: 50%;
			background-color: #9e9d24;
			width: 15px;
			height: 15px;
		}
		.a400_more {
			border: solid #827717 1px;
			border-radius: 50%;
			background-color: #827717;
			width: 15px;
			height: 15px;
		}

	</style>
</body>
</html>
