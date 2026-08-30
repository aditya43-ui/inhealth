<div class="row-fluid tile-block">
	<div class="col-md-4" style="padding:0">
		<div class="tile-header">
			<h3 style="color:#fff">Map</h3> <span>Penyebaran Diagnosa Berdasarkan Kecamatan Bulan ini</span> 
		</div>
		<div class="scrollable" data-height="400" data-scroll-position="right" data-rail-color="#fff" data-rail-opacity=".9" data-rail-width="8" data-rail-radius="10" data-autohide="0">
				<?php 
					$kecamatan = array();
					foreach ($dataMap as $i => $map){ 
						
						$diagnosa_id = $map['diagnosa_id'];
						
						$kecamatan[$diagnosa_id]['diagnosa'][$i]['kecamatan_nama'] = $map['kecamatan_nama'];
						$kecamatan[$diagnosa_id]['diagnosa'][$i]['latitude'] = isset($map['latitude']) ? $map['latitude'] : null;
						$kecamatan[$diagnosa_id]['diagnosa'][$i]['longitude'] = isset($map['longitude']) ? $map['longitude'] : null;
						$kecamatan[$diagnosa_id]['diagnosa'][$i]['jumlah'] = $map['jumlah'];					
				?>
				<div class="tile-entry list-map" style="cursor:pointer;background:rgba(0, 0, 0, 0.15); padding:10px 20px 10px 10px; margin:1px 0" onclick="setKecamatan(this,<?php echo $map['diagnosa_id'] ?>);">
				   <span style="display:inline-block;color:#fff;font-size:11px;"><?php echo $map['diagnosa_nama'] ?></span>
				   <span class="pull-right" style="display:inline-block;color:#fff;margin-top:-10px;font-size:11px;"><?php echo $map['jumlah'] ?></span> 
				</div>
			<?php } ?>
		</div>
	</div>

	<div class="col-md-8" style="padding:0">
		<div id="googlemaps" style="height:500px;  color:#000" ></div> 
	</div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var markerCount = 0;
var map;
var markersArray = [];
function initialize() {
	var longitude = <?php echo isset($longitude) ? $longitude : -6.9393914 ; ?>;
	var latitude = <?php echo isset($latitude) ? $latitude : 107.6179629 ; ?>;
    var myLatlng = new google.maps.LatLng(latitude, longitude);
    var map_canvas = document.getElementById('googlemaps');
    var map_options = {
        center: myLatlng,
        zoom: 7,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(map_canvas, map_options);
}   
 
google.maps.event.addDomListener(window, 'load', initialize);   


function addMarkerToMap(lat, long, htmlMarkupForInfoWindow){	
	var jumlah = lat.length;
	var latitude = new Array();
	var longitude = new Array();
	var htmlMarkupForInfoWindows = new Array();
	var marker,i;
	var infowindow = new google.maps.InfoWindow();
	clearOverlays();
	for(i=0; i<jumlah; i++){
		latitude[i] = lat[i];
		longitude[i] = long[i];
		htmlMarkupForInfoWindows[i] = htmlMarkupForInfoWindow[i];
		
		var myLatLng = new google.maps.LatLng(latitude[i], longitude[i]);		
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(latitude[i], longitude[i]),
			map: map,
			animation: google.maps.Animation.DROP,
		});		
		markerCount++;
		
		markersArray.push(marker);		
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {				
				infowindow.setContent(htmlMarkupForInfoWindows[i]);
				infowindow.open(map, marker);
			}
		})(marker, i)); 		
	}        
}

function clearOverlays() {
  for (var i = 0; i < markersArray.length; i++ ) {
   markersArray[i].setMap(null);
  }
}

function panTo(lat, long){
	myLatLng[i] = new google.maps.LatLng(lat, long);		
	map.panTo(myLatLng);
}

// untuk menampilkan daftar kecamatan berdasarkan diagnosa_id
function setKecamatan(obj,diagnosa_id){

    $("#kecamatan").addClass('animation-loading');
    $("#kecamatan").removeAttr('style','display:none;');	
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setKecamatan'); ?>',
        data: {diagnosa_id:diagnosa_id},
        dataType: "json",
        success:function(data){
			var latitude = new Array();
			var longitude = new Array();
			var kecamatan_nama = new Array();
			for(i=0; i<data.length; i++){
				latitude[i]		= data[i].latitude;
				longitude[i]	= data[i].longitude;									
				kecamatan_nama[i]	= data[i].kecamatan_nama;									
			}
			addMarkerToMap(latitude,longitude,kecamatan_nama);			
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

setTimeout(function()
{           
	<?php foreach ($dataMap as $i => $map) { 
		if(isset($map['latitude'])&&isset($map['longitude'])){
	?>
		addMarkerToMap(<?php echo $map['latitude'] ?>, <?php echo $map['longitude'] ?>, '<?php echo $map['kecamatan_nama'] ?>');
	<?php }} ?>
}, 6000);
</script>