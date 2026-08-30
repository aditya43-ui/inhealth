var map = L.map('map', {
			zoomControl:true, maxZoom:19,
		}).fitBounds([[-7.83072299312,107.145438622],[-6.89656604012,108.611546062]]);
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
			fillColor: '#fff9c4',
			weight: 1.3,
			dashArray: '',
			opacity: 1.0,
			fillOpacity: 1.0
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
	this._div.innerHTML = '<h2>Garut</h2>Peta Penyebaran Penyakit '
};
title.addTo(map);
var legend = L.control({position: 'bottomright'});
legend.onAdd = function (map) {
	var div = L.DomUtil.create('div', 'info legend');
	div.innerHTML = "<h3>Keterangan</h3><table><tr><td><div class='garut'></div></td><td>:</td><td>Darah Administrasi Garut</td></tr><tr><td><div class='region-affected'></div></td><td>:</td><td>Daerah Terkena Dampak</td></tr></table>";
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
