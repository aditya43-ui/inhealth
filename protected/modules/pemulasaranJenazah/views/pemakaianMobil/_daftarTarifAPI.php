<style type="text/css">
    .desimal, .numbers-only, .currency{
        text-align: right;
    }
</style>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<label class="control-label">Asal</label>
			<div class="controls">
				<?php echo CHtml::TextField('FromsearchTextField', 'Pricilla Medical Center', array('class' => 'span3','readonly'=>true)); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Destinasi/Tujuan</label>
			<div class="controls">
				<?php echo CHtml::TextField('FromsearchTextField2', '', array('class' => 'span3')); ?>
				<?php echo CHtml::hiddenField('alamat_value', '', array('class' => 'span3','readonly'=>true)); ?>
			</div>
		</div>
                <div class="control-group">
			<label class="control-label">Jarak</label>
			<div class="controls">
				<?php echo CHtml::TextField('km_text', '', array('readonly' => true, 'class' => 'span2')); ?>
				<?php echo CHtml::hiddenField('km_value', '', array('readonly' => true, 'class' => 'span1')); ?>
			</div>
		</div>	
		<div class="control-group">
			<label class="control-label">Durasi</label>
			<div class="controls">
				<?php echo CHtml::TextField('durasi', '', array('readonly' => true, 'class' => 'span2')); ?>
			</div>
		</div>	
	</div>
    
	<div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Pelayanan Mobil Jenazah</label>
                <div class="controls">
                    <?php echo $form->dropDownList($modPemakaian,'pelayanan_ambulan', 
                            CHtml::listData(KomponenunitM::model()->findAll('komponenunit_id='.Params::KOMPONENUNIT_ID_MOBIL_JENAZAH
                                                                            .' OR komponenunit_id='.Params::KOMPONENUNIT_ID_MOBIL_TANPAGAWAT
                                                                            .' OR komponenunit_id='.Params::KOMPONENUNIT_ID_MOBIL_GAWAT
                                                                            .' OR komponenunit_id='.Params::KOMPONENUNIT_ID_MOBIL_VIP
                                                                            .' OR komponenunit_id='.Params::KOMPONENUNIT_ID_AMBULANS
                                                                        ),'komponenunit_id','komponenunit_nama'),
                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 
                                    'empty'=>'-- Pilih --', 'onchange'=>'setTarifAmbulans();')); ?>
                    <?php echo CHtml::activeHiddenField($modPemakaian,'daftartindakanId',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jasa Sarana</label>
                <div class="controls">
                    <?php echo CHtml::TextField('jasa_sarana', '', array('readonly' => false, 'class' => 'span2 integer2', 'onblur'=>'hitungTotalTarifAmbulan();')); ?>
                    <?php // echo $form->textField($modPemakaian,'jasa_sarana',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>                
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Harga BBM</label>
                <div class="controls">
                    <?php echo CHtml::TextField('harga_bbm', '', array('readonly' => true, 'class' => 'span2 integer2', 'onblur'=>'hitungTotalTarifAmbulan();')); ?>
                    <?php // echo $form->textField($modPemakaian,'harga_bbm',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>                
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">BHP</label>
                <div class="controls">
                    <?php echo CHtml::TextField('bhp', '', array('readonly' => false, 'class' => 'span2 integer2', 'onblur'=>'hitungTotalTarifAmbulan();')); ?>
                    <?php // echo $form->textField($modPemakaian,'bhp',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>                
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jasa Pengemudi</label>
                <div class="controls">
                    <?php echo CHtml::TextField('jasa_pengemudi', '', array('readonly' => false, 'class' => 'span2 integer2', 'onblur'=>'hitungTotalTarifAmbulan();')); ?>
                    <?php // echo $form->textField($modPemakaian,'jasa_pengemudi',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>                
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">
                    Jasa Pendamping 
                    <?php echo CHtml::activecheckBox($modPemakaian, 'isPendamping', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekPendamping()','data-original-title'=>'Cek jika menggunakan pendamping')); ?>
              </label>
                <div class="controls">
                    <?php echo CHtml::TextField('jasa_pendamping', '', array('readonly' => false, 'class' => 'span2 integer2', 'onblur'=>'cekPendamping();')); ?>
                    <?php // echo $form->textField($modPemakaian,'jasa_pendamping',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>                
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">
                    Jasa Dokter 
                    <?php echo CHtml::activecheckBox($modPemakaian, 'isDokter', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekDokter()','data-original-title'=>'Cek jika menggunakan dokter')); ?>
              </label>
                <div class="controls">
                    <?php echo CHtml::TextField('jasa_dokter', '', array('readonly' => false, 'class' => 'span2 integer2', 'onblur'=>'cekDokter();')); ?>
                    <?php // echo $form->textField($modPemakaian,'jasa_dokter',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>                
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Biaya Tol</label>
                <div class="controls">
                    <?php echo CHtml::TextField('biaya_tol', '', array('readonly' => false, 'class' => 'span2 integer2', 'onblur'=>'hitungTotalTarifAmbulan();')); ?>
                    <?php // echo $form->textField($modPemakaian,'total_tarif',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>                
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Tarif</label>
                <div class="controls">
                    <?php echo CHtml::TextField('total_tarif', '', array('readonly' => true, 'class' => 'span2 integer2')); ?>
                    <?php // echo $form->textField($modPemakaian,'total_tarif',array('class'=>'span2 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>                
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Tambah', array('{icon}'=>'<i class="entypo-check"></i>')), 'javascript:void(0);', array('class' => 'btn btn-danger','onclick'=>"inputTarifAmbulansAPI();return false"));?>
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 'javascript:void(0);', array('class' => 'btn btn-default','onclick'=>"reset();return false"));?>
                </div>
            </div>
	</div>
	<!--<div class="col-sm-12">-->
        <div class="">
		<div id="googlemaps" style="height:400px; width: 100%; color:#000"></div> 
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBW-_isQxhcuKczz8eDdDDgV-UmQnQ5mm8"></script>
<script type="text/javascript">
	var markerCount = 0;
	var map;
	var markersArray = [];
        var markers2 = [];
        var markers = [];

	function initialize() {
		var myLatlng = new google.maps.LatLng(-7.663525, 112.89971000000003);
		var map_canvas = document.getElementById('googlemaps');
		var map_options = {
			center: myLatlng,
			zoom: 8,
			scrollwheel: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			country: 'id'
		}
		map = new google.maps.Map(map_canvas, map_options);
		var fromt = document.getElementById('FromsearchTextField');
		var fromt2 = document.getElementById('FromsearchTextField2');
		var autocomplete = new google.maps.places.Autocomplete(fromt);
		var autocomplete2 = new google.maps.places.Autocomplete(fromt2);

		// Create the search box and link it to the UI element.
		var input = document.getElementById('FromsearchTextField');
		var input2 = document.getElementById('FromsearchTextField2');
		var searchBox = new google.maps.places.SearchBox(input);
//        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		var searchBox2 = new google.maps.places.SearchBox(input2);
//        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input2);

		var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
		directionsDisplay.setMap(map);

		// Bias the SearchBox results towards current map's viewport.
		map.addListener('bounds_changed', function () {
			searchBox.setBounds(map.getBounds());
		});
		map.addListener('bounds_changed', function () {
			searchBox2.setBounds(map.getBounds());
		});

		var markers = [];
		// Listen for the event fired when the user selects a prediction and retrieve
		// more details for that place.
		searchBox.addListener('places_changed', function () {
			var places = searchBox.getPlaces();

			if (places.length == 0) {
				return;
			}

			// Clear out the old markers.
			markers.forEach(function (marker) {
				marker.setMap(null);
			});
			markers = [];

			// For each place, get the icon, name and location.
			var bounds = new google.maps.LatLngBounds();
			places.forEach(function (place) {
				if (!place.geometry) {
					console.log("Returned place contains no geometry");
					return;
				}
				var icon = {
					url: place.icon,
					size: new google.maps.Size(71, 71),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(17, 34),
					scaledSize: new google.maps.Size(25, 25)
				};

				// Create a marker for each place.
				markers.push(new google.maps.Marker({
					map: map,
					icon: google.maps.Animation.DROP,
					title: place.name,
					position: place.geometry.location
				}));

				if (place.geometry.viewport) {
					// Only geocodes have viewport.
					bounds.union(place.geometry.viewport);
				} else {
					bounds.extend(place.geometry.location);
				}
			});
			map.fitBounds(bounds);

		});

		var markers2 = [];
		searchBox2.addListener('places_changed', function () {

			$("#alamat_value").val($("#FromsearchTextField2").val());
			
			var places = searchBox2.getPlaces();

			if (places.length == 0) {
				return;
			}

			// Clear out the old markers.
			markers2.forEach(function (marker) {
				marker.setMap(null);
			});
			markers2 = [];

			// For each place, get the icon, name and location.
			var bounds = new google.maps.LatLngBounds();
			places.forEach(function (place) {
				if (!place.geometry) {
					console.log("Returned place contains no geometry");
					return;
				}
				var icon = {
					url: place.icon,
					size: new google.maps.Size(71, 71),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(17, 34),
					scaledSize: new google.maps.Size(25, 25)
				};

				// Create a marker for each place.
				//markers2.push(new google.maps.Marker({
//              map: map,
//              icon: google.maps.Animation.DROP,
//              title: place.name,
//              position: place.geometry.location
//            }));

				if (place.geometry.viewport) {
					// Only geocodes have viewport.
					bounds.union(place.geometry.viewport);
				} else {
					bounds.extend(place.geometry.location);
				}
//				myAlert(place.geometry.location);
			});
			map.fitBounds(bounds);

			//Untuk fungsi direction dari A ke B
			var origin = $("#FromsearchTextField").val();
			var destination = $("#FromsearchTextField2").val();
			directionsService.route({
//			origin: "Bandung City, West Java, Indonesia",
//			destination: "jakarta, id",
				origin: origin,
				destination: destination,
				travelMode: 'DRIVING'
			}, function (response, status) {
				if (status === 'OK') {
					directionsDisplay.setDirections(response);
				} else {
//			  window.alert('Directions request failed due to ' + status);
					myAlert("Cek kembali inputan asal dan destinasi tujuan tempat");
				}
			});
			
			var distanceService = new google.maps.DistanceMatrixService();
			distanceService.getDistanceMatrix({
                origins: [origin],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                durationInTraffic: true,
                avoidHighways: false,
                avoidTolls: false
            },
            function (response, status) {
                if (status !== google.maps.DistanceMatrixStatus.OK) {
                    console.log('Error:', status);
                } else {
                    $("#km_text").val(response.rows[0].elements[0].distance.text);
                    $("#km_value").val(response.rows[0].elements[0].distance.value);
                    $("#durasi").val(response.rows[0].elements[0].duration.text);

                    if($("#PJPemakaianambulansT_pelayanan_ambulan").val() != ""){
                         setTarifAmbulans();
                    }
 //				   $("#distance").text(response.rows[0].elements[0].distance.text).show();
 //				   $("#duration").text(response.rows[0].elements[0].duration.text).show();
                }
            });

		});

	}

	google.maps.event.addDomListener(window, 'load', initialize);

	function reset(){
		$("#FromsearchTextField2").val('');
		$("#km_text").val('');
		$("#km_value").val('');
		$("#durasi").val('');
		$("#alamat_value").val('');
                setMapOnAll(null);
	}
        
        /*Clear semua map*/
    function setMapOnAll(map) {
        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];
        markers2.forEach(function (marker) {
            marker.setMap(null);
        });
        markers2 = [];
    }

    /*Hitung jarak dan durasi berdasrkan perubahan pin manual*/
    function computeTotalDistance(result) {
        var myroute = result.routes[0];
//        console.log(myroute);
        for (var i = 0; i < myroute.legs.length; i++) {
            $("#km_value").val(myroute.legs[i].distance.value);
            $("#km_text").val(myroute.legs[i].distance.text);
            $("#durasi").val(myroute.legs[i].duration.text);
            $("#FromsearchTextField").val(myroute.legs[i].start_address);
            $("#FromsearchTextField2").val(myroute.legs[i].end_address);
            if($("#PJPemakaianambulansT_pelayanan_ambulan").val() != ""){
                setTarifAmbulans();
            }
        }
    }
	
</script>