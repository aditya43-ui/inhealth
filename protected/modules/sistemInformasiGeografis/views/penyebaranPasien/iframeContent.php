<!DOCTYPE html>
<html>

<head>
  <title>Garut</title>
  <meta charset="utf-8" />

  <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/css/own_style.css">

  <script src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/js/jquery-1.11.1.min.js"></script>
  <script src="http://maps.googleapis.com/maps/api/js"></script>

  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/js/bootstrap.min.js"></script>

  <script src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/js/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/js/bootstrap-select.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/chart/amcharts.js" type="text/javascript"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/chart/serial.js" type="text/javascript"></script>
  <!--<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/php/GIS/js/penyebaran-pasien.js"></script>-->
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
</head>

<body style="background: transparent">
  <div class="row full-height">
    <div class="col-md-12 col-sm-12 col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Filter Tanggal
        </div>
        <div class="panel-body">
          <?php echo $this->renderPartial('_searchIndicator', array('modelMordibitas' => $modelMordibitas, 'format' => $format)); ?>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Peta Administrasi Garut
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-4">
              <div class="panel-container">
                <?php
                $kecamatan = array();
                foreach ($dataMap as $i => $map) {
                  $diagnosa_id = $map['diagnosa_id'];
                  $kecamatan[$diagnosa_id]['diagnosa'][$i]['kecamatan_nama'] = $map['kecamatan_nama'];
                  $kecamatan[$diagnosa_id]['diagnosa'][$i]['latitude'] = isset($map['latitude']) ? $map['latitude'] : null;
                  $kecamatan[$diagnosa_id]['diagnosa'][$i]['longitude'] = isset($map['longitude']) ? $map['longitude'] : null;
                  $kecamatan[$diagnosa_id]['diagnosa'][$i]['jumlah'] = $map['jumlah'];
                ?>

                  <div class="list" onclick="setPasienCoordinate(<?php echo  $map['kecamatan_id']; ?>)">
                    <span href="#" style="color:black;"><?php echo $map['kecamatan_nama']; ?></span>
                    <span style="float:right">
                      <div style="color: black; width: 20px; height: 20px;border-radius: 50%;background-color: white; font-size: 10px;text-align: center;padding-top: 3px;"> <?php echo $map['jumlah']; ?></div>
                    </span>
                  </div>
                  <!--										<div class="tile-entry list-map" style="cursor:pointer;background:rgba(0, 0, 0, 0.15); padding:10px 20px 10px 10px; margin:1px 0" onclick="setKecamatan(this,<?php echo $map['diagnosa_id'] ?>);">
										   <span style="display:inline-block;color:#fff;font-size:11px;"><?php echo $map['diagnosa_nama'] ?></span>
										   <span class="pull-right" style="display:inline-block;color:#fff;margin-top:-8px;font-size:11px;"><?php echo $map['jumlah'] ?></span> 
										</div>-->
                <?php } ?>

              </div>
            </div>
            <div class="col-lg-8">
              <div id="mapPenyebaranPasien" style="height: 475px"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    var markerCount = 0;
    var map;
    var markersArray = [];
    var lat = new Array(); //[-6.9393914, -6.6393914, -5.9393914, -6.3393914, -7.9393914];
    var long = new Array(); //[107.6179629, 105.6179629, 106.6179629, 107.3179629, 107.1179629];

    function initialize() {
      var mapProp = {
        center: new google.maps.LatLng(-6.9393914, 107.6179629),
        zoom: 8,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      map = new google.maps.Map(document.getElementById("mapPenyebaranPasien"), mapProp);
    }

    function addMarkerToMap(lat, long, htmlMarkupForInfoWindow) {
      var jumlah = lat.length;
      var latitude = new Array();
      var longitude = new Array();
      var htmlMarkupForInfoWindows = new Array();
      var marker, i;
      var latAdded, longAdded = 0;
      var infowindow = new google.maps.InfoWindow();
      clearOverlays();
      for (i = 0; i < jumlah; i++) {
        latitude[i] = lat[i];
        longitude[i] = long[i];

        htmlMarkupForInfoWindows[i] = htmlMarkupForInfoWindow[i];
        (latitude[i] == null ? latitude[i] = -6.9393914 : latitude[i]);
        (longitude[i] == null ? longitude[i] = 107.6179629 : latitude[i]);
        var myLatLng = new google.maps.LatLng(latitude[i], longitude[i]);

        var iconBase = '<?php echo Yii::app()->getBaseUrl(true) . '/images/'; ?>';
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(latitude[i], longitude[i]),
          map: map,
          animation: google.maps.Animation.DROP,
          icon: iconBase + 'patient64.png'
        });
        markerCount++;
        console.log(latitude[i]);
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
      for (var i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
      }
    }

    function panTo(lat, long) {
      myLatLng[i] = new google.maps.LatLng(lat, long);
      map.panTo(myLatLng);
    }

    // untuk menampilkan daftar kecamatan berdasarkan diagnosa_id
    function setKecamatan(obj, diagnosa_id) {

      $("#kecamatan").addClass('animation-loading');
      $("#kecamatan").removeAttr('style', 'display:none;');
      $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('GetPenyebaranPasien'); ?>',
        data: {
          diagnosa_id: diagnosa_id
        },
        dataType: "json",
        success: function(data) {
          var latitude = new Array();
          var longitude = new Array();
          var kecamatan_nama = new Array();
          for (i = 0; i < data.length; i++) {
            latitude[i] = data[i].latitude;
            longitude[i] = data[i].longitude;
            kecamatan_nama[i] = data[i].kecamatan_nama;
          }
          addMarkerToMap(latitude, longitude, kecamatan_nama);
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });
    }
    // untuk menampilkan daftar penyebaran pasien (lat,long) berdasarkan kecamatan_id
    function setPasienCoordinate(kecamatan_id) {

      $("#kecamatan").addClass('animation-loading');
      $("#kecamatan").removeAttr('style', 'display:none;');
      $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('GetPenyebaranPasien'); ?>',
        data: {
          kecamatan_id: kecamatan_id
        },
        dataType: "json",
        success: function(data) {
          var latitude = new Array();
          var longitude = new Array();
          //					var kecamatan_nama = new Array();
          var namapasien = new Array();
          for (i = 0; i < data.length; i++) {
            latitude[i] = data[i].latitude;
            longitude[i] = data[i].longitude;
            //						kecamatan_nama[i] = data[i].kecamatan_nama;		
            namapasien = data[i].nama_pasien;
          }
          addMarkerToMap(latitude, longitude, namapasien);
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });
    }

    setTimeout(function() {
      <?php foreach ($dataMap as $i => $map) {
        if (isset($map['latitude']) && isset($map['longitude'])) {
      ?>
          addMarkerToMap(<?php echo $map['latitude'] ?>, <?php echo $map['longitude'] ?>, '<?php echo $map['kecamatan_nama'] ?>');
      <?php }
      } ?>
    }, 6000);
    //		$(function () {
    //			$('#dateStart').datetimepicker({
    //				format: 'LT'
    //			});
    //		});
    $(document).ready(function() {
      //setIframeDashboard();

      $('#dateStart').datetimepicker({
        format: 'mm/dd/yyyy',
      });
      $('#dateEnd').datetimepicker({
        format: 'mm/dd/yyyy',
      });
    });
    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
</body>

</html>