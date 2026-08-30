<div class="row tile-block">
	<div class="col-md-4" style="padding:0">
		<div class="tile-header">
			<h3 style="color:#fff">Map</h3> <span>Penyebaran Pasien Selama Setahun</span> 
		</div>
		<div class="scrollable" data-height="400" data-scroll-position="right" data-rail-color="#fff" data-rail-opacity=".9" data-rail-width="8" data-rail-radius="10" data-autohide="0">
			  <?php foreach ($dataMap as $i => $map) { ?>
				<div class="tile-entry list-map" style="cursor:pointer;background:rgba(0, 0, 0, 0.15); padding:10px 20px 10px 10px; margin:1px 0" onclick="panTo(<?php echo $map['latitude'] ?>, <?php echo $map['longitude'] ?>)"> 
				   <span style="display:inline-block;color:#fff;font-size:11px;"><?php echo $map['kecamatan_nama'] ?></span> <span class="pull-right" style="display:inline-block;color:#fff;font-size:11px;"><?php echo $map['jumlah'] ?></span> 
			   </div> 
			<?php } ?>
		</div>
	</div>

	<div class="col-md-8" style="padding:0">
		<div id="googlemaps" style="height:500px;  color:#000"></div> 
	</div>

</div>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCKaKWoGgPIaCh-xDEeJMFoDrEaXaW9PUI&callback=initialize" async defer></script>
<script type="text/javascript">
var markerCount = 0;
var map;
var markersArray = [];
 
function initialize() {
    var longitude = <?php echo isset($longitude) ? $longitude : 140.68102769999996 ; ?>;//-6.9393914
    var latitude = <?php echo isset($latitude) ? $latitude : -2.565139843601719; ?>;// 107.6179629
    var myLatlng = new google.maps.LatLng(latitude, longitude);
    var map_canvas = document.getElementById('googlemaps');
    var map_options = {
        center: myLatlng,
        zoom: 8,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(map_canvas, map_options);
}   
 
google.maps.event.addDomListener(window, 'load', initialize);   
 

 

function addMarkerToMap(lat, long, htmlMarkupForInfoWindow){
    var marker,i;
    if(lat==null&&long==null){
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
    markersArray.push(marker);  
    google.maps.event.addListener(marker, 'click', (function(marker, markerCount) {
        return function() {
            infowindow.setContent(htmlMarkupForInfoWindow);
            infowindow.open(map, marker);
        }
    })(marker, markerCount)); 

        
}

function panTo(lat, long, kecamatan){
    var myLatLng = new google.maps.LatLng(lat, long);
    map.panTo(myLatLng);
    clearOverlays()
    addMarkerToMap(lat, long, kecamatan);
}
var i = 0
function clearOverlays() {
  for (i; i < markersArray.length; i++ ) {
   markersArray[i].setMap(null);
  }
}
</script>