<div class="row tile-block">
	<div class="col-md-12" style="padding:1px">
		<div id="googlemaps" style="height:500px;  color:#000"></div> 
	</div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">	
var markerCount = 0;
var map;
var markersArray = [];
function initialize() {
	var longitude = <?php echo isset($longitude) ? $longitude : 117.48004 ; ?>; // Jika kosong tembak ke koordinat Bontang
	var latitude = <?php echo isset($latitude) ? $latitude : 0.12086 ; ?>;
    var myLatlng = new google.maps.LatLng(latitude, longitude);
    var map_canvas = document.getElementById('googlemaps');
    var map_options = {
        center: myLatlng,
        zoom: 14,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.HYBRID
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

function setPasien(obj,kecamatan_id){

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setPasien'); ?>',
        data: {kecamatan_id:kecamatan_id,tgl_awal:'<?php echo $tgl_awal; ?>',tgl_akhir:'<?php echo $tgl_akhir; ?>'},
        dataType: "json",
        success:function(data){
			var latitude = new Array();
			var longitude = new Array();
			var data_pasien = new Array();
			for(i=0; i<data.length; i++){
				latitude[i]		= data[i].latitude;
				longitude[i]	= data[i].longitude;									
				data_pasien[i]	= data[i].nama_pasien+"<br><b>"+data[i].alamat_pasien+"</b>";
			}
			addMarkerToMap(latitude,longitude,data_pasien);
			$('#berdasarkan_kecamatan_id').val(data[0].kecamatan_id);
			$('.btn-info').attr('disabled',false);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

$(document).ready(function() {
	setTimeout(function(){           
		setPasien(null,<?php echo $_GET['kecamatan_id']; ?>);
	}, 5000); // diset segini karena antisipasi koneksi inet (diasumsikan 5 detik sudah bisa load google maps)
});
</script>