<div class="row-fluid tile-block">
	<div class="col-sm-3" style="padding:0">
		<div class="tile-header">
			<h3 style="color:#fff">Peta</h3> <span> Penyebaran Wilayah Pasien</span> 
		</div>
		<div class="scrollable" data-height="400" data-scroll-position="right" data-rail-color="#fff" data-rail-opacity=".9" data-rail-width="8" data-rail-radius="10" data-autohide="0">
			  <?php foreach ($dataMap as $i => $map) { ?>
				<div class="tile-entry list-map" style="cursor:pointer;background:rgba(0, 0, 0, 0.15); padding:10px 20px 10px 10px; margin:1px 0" onclick="panTo(<?php echo isset($map['garis_latitude']) ? (!empty($map['garis_latitude'])?$map['garis_latitude']:"'tidakada'") : (!empty($map['latitude'])?$map['latitude']:"'tidakada'") ?>, <?php echo isset($map['garis_latitude']) ? (!empty($map['garis_longitude'])?$map['garis_longitude']:"'tidakada'") : (!empty($map['longitude'])?$map['longitude']:"'tidakada'") ?>)"> 
				   <span style="display:inline-block;color:#fff;font-size:11px;"><?php echo isset($map['kecamatan_nama']) ? $map['kecamatan_nama'] : "Tidak Diset" ?></span> <span class="pull-right" style="display:inline-block;color:#fff;font-size:11px;"><?php echo $map['jumlah'] ?></span> 
			   </div> 
			<?php } ?>
		</div>
	</div>

	<div class="col-sm-9" style="padding:0">
		<div id="googlemaps" style="height:500px;  color:#000"></div> 
	</div>

</div>

<script src="https://maps.google.com/maps/api/js?key=<?php echo $konsys->google_api_key ?>&callback=initialize" async defer></script>
<script type="text/javascript">
var markerCount = 0;
var map;
var markersArray = [];
function initialize() {
    var myLatlng = new google.maps.LatLng(<?php echo $longitude; ?>, <?php echo $latitude; ?>);//latitude,longitude
    var map_canvas = document.getElementById('googlemaps');
    var map_options = {
        center: myLatlng,
        zoom: 15,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(map_canvas, map_options);

    var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h4 id="firstHeading" class="firstHeading"><?php echo $profil->nama_rumahsakit; ?></h4>'+
      '<div id="bodyContent">'+      
      '<p><?php echo $profil->alamatlokasi_rumahsakit; ?></p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: "<?php echo $profil->nama_rumahsakit; ?>"
  });

  google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
}   
 
google.maps.event.addDomListener(window, 'load', initialize);   
 

 

function addMarkerToMap(lat, long, htmlMarkupForInfoWindow){
    if(lat=="tidakada"&&long=="tidakada"){
        alert('longitude dan latitude belum di-set!'); return false;
    }
    var infowindow = new google.maps.InfoWindow();
    var myLatLng = new google.maps.LatLng(lat, long);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        animation: google.maps.Animation.DROP,
    });

    markerCount++;

    google.maps.event.addListener(marker, 'click', (function(marker, markerCount) {
        return function() {
            infowindow.setContent(htmlMarkupForInfoWindow);
            infowindow.open(map, marker);
        }
    })(marker, markerCount)); 

        
}

function panTo(lat, long){
    var myLatLng = new google.maps.LatLng(lat, long);
    map.panTo(myLatLng);
}

setTimeout(function()
    {           
        <?php foreach ($dataMap as $i => $map) {
            if(isset($map['latitude']) && isset($map['longitude'])){
        ?>
            addMarkerToMap(<?php echo isset($map['garis_latitude']) ? (!empty($map['garis_latitude'])?$map['garis_latitude']:"'tidakada'") : (!empty($map['latitude'])?$map['latitude']:"'tidakada'"); ?>, <?php echo isset($map['garis_longitude']) ? (!empty($map['garis_longitude'])?$map['garis_longitude']:"'tidakada'") : (!empty($map['longitude'])?$map['longitude']:"'tidakada'"); ?>, '<?php echo $map['kecamatan_nama'] ?>');
        <?php }} ?>
    }, 6000);
</script>