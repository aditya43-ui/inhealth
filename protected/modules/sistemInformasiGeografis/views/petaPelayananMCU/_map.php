<div class="row tile-block">
	<div class="col-md-3" style="padding:0">
		<div class="tile-header">
			<h3 style="color:#fff">Legend</h3> <span>Penyebaran Pasien <br>Berdasarkan Hasil Medical Check Up<br>Dari Tanggal <?php echo MyFormatter::formatDateTimeForUser($tgl_awal); ?> s/d <?php echo MyFormatter::formatDateTimeForUser($tgl_akhir); ?> </span> 
		</div>
		<div class="scrollable" data-height="400" data-scroll-position="right" data-rail-color="#fff" data-rail-opacity=".9" data-rail-width="8" data-rail-radius="10" data-autohide="1">
			<?php if(count((array)$dataMap)>0){ foreach ($dataMap as $i => $map){ ?>
				<div class="tile-entry list-map" style="cursor:pointer;background:rgba(0, 0, 0, 0.15); padding:10px 10px 10px 10px; margin:1px 0" onclick="setPasien(this,<?php echo $map['diagnosa_id'] ?>);">
				   <span style="display:inline-block;color:#fff;font-size:11px;"><?php echo $map['diagnosa_nama'] ?></span>
				   <span class="pull-right" style="display:inline-block;color:#fff;margin-top:-8px;font-size:11px;"><?php echo $map['jumlah'] ?> Pasien</span> 
				</div>
			<?php } } ?>
		</div>
	</div>

	<div class="col-md-9" style="padding:0">
		<div id="googlemaps" style="height:500px;  color:#000"></div> 
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print()','disabled'=>true,"title"=>"Tombol akan aktif jika terdapat data pada maps")); ?>
</div>

<?php 
$urlPrint=  Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/print&tgl_awal='.$tgl_awal."&tgl_akhir=".$tgl_akhir);
$jsx = <<< JSCRIPT
function print()
{
	var diagnosa_id = $("#berdasarkan_diagnosa_id").val();
    window.open("${urlPrint}&diagnosa_id="+diagnosa_id,"",'left=100,top=100,width=1200px,scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 

<?php echo CHtml::hiddenField('berdasarkan_diagnosa_id', '', array('readonly'=>true)); ?>
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
				if (marker.getAnimation() != null) {
					marker.setAnimation(null);
				}else{
					marker.setAnimation(google.maps.Animation.BOUNCE);
					setTimeout(function(){
						marker.setAnimation(null);
					},1500);
				}
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

function setPasien(obj,diagnosa_id){

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setPasien'); ?>',
        data: {diagnosa_id:diagnosa_id,tgl_awal:'<?php echo $tgl_awal; ?>',tgl_akhir:'<?php echo $tgl_akhir; ?>'},
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
			$('#berdasarkan_diagnosa_id').val(data[0].diagnosa_id);
			$('.btn-info').attr('disabled',false);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
</script>