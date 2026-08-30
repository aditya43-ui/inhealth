<!--<div class="row tile-block">
	<div class="col-sm-3" style="padding:0">
		<div class="tile-header">
			<h3 style="color:#fff">Map</h3> <span>Peta Penyebaran Wilayah Pasien</span> 
		</div>
		<div class="scrollable" data-height="400" data-scroll-position="right" data-rail-color="#fff" data-rail-opacity=".9" data-rail-width="8" data-rail-radius="10" data-autohide="0">
        <?php 
//					$kecamatan = array();
//					foreach ($dataMap as $i => $map){ 
//												
//						$kecamatan[$i]['kecamatan_nama'] = $map['kecamatan_nama'];
//						$kecamatan[$i]['latitude'] = isset($map['latitude']) ? $map['latitude'] : "'tidakada'";
//						$kecamatan[$i]['longitude'] = isset($map['longitude']) ? $map['longitude'] : "'tidakada'";
//						$kecamatan[$i]['jumlah'] = $map['jumlah'];					
				?>
				<div class="tile-entry list-map" style="cursor:pointer;background:rgba(0, 0, 0, 0.15); padding:10px 20px 10px 10px; margin:1px 0" onclick="setKecamatan(this,<?php // echo $map['kecamatan_nama'] ?>);">
				   <span style="display:inline-block;color:#fff;font-size:11px;"><?php // echo $map['kecamatan_nama'] ?></span>
				   <span class="pull-right" style="display:inline-block;color:#fff;margin-top:-10px;font-size:11px;"><?php // echo $map['jumlah'] ?></span> 
				</div>
			<?php // } ?>
		</div>
	</div>

	<div class="col-sm-9" style="padding:0">
		<div id="googlemaps" style="height:500px;  color:#000"></div> 
	</div>
</div>-->
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
function setKecamatan(obj,kecamatan_nama){

    $("#kecamatan").addClass('animation-loading');
    $("#kecamatan").removeAttr('style','display:none;');	
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setKecamatan'); ?>',
        data: {kecamatan_nama:kecamatan_nama},
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
		addMarkerToMap(<?php echo (!empty($map['latitude'])?$map['latitude']:"'tidakada'"); ?>, <?php echo (!empty($map['longitude'])?$map['longitude']:"'tidakada'"); ?>, '<?php echo $map['kecamatan_nama'] ?>');
	<?php }} ?>
}, 6000);
</script>