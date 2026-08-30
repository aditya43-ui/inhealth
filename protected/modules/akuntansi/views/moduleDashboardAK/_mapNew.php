<!--Leaflet-->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<div id="mapid" style="height: 500px; color: #000;"></div>

<script type="text/javascript">
    var mymapDashboard;
    $(document).ready(function() {
        mymapDashboard = L.map('mapid').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 8);
        setTimeout(function() {
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 15,
                attribution: 'Map data &copy; <a href="https:///"></a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(mymapDashboard);
            <?php if (count($dataMap) > 0) {
                $arrayPsm = array();
                foreach ($dataMap as $i => $bar) { ?>
                    var greenIcon = new L.Icon({
                        iconUrl: '<?php echo Yii::app()->baseUrl; ?>/js/leaflet/images/marker-icon-2x-green.png',
                        shadowUrl: '<?php echo Yii::app()->baseUrl; ?>/js/leaflet/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    L.marker([<?php echo $bar['latitude'] ?>, <?php echo $bar['longitude'] ?>], {
                            icon: greenIcon
                        }).addTo(mymapDashboard)
                        .bindPopup("<b>Kabupaten " + <?php $bar['kabupaten_nama'] ?> + "</b><br>" + <?php echo $bar['jumlah'] ?> + ' Pasien').openPopup();

                <?php } ?>
            <?php  }  ?>
        }, 3000);


        //    mymapDashboard.on('click', onMapClick);


    });

    function onMapClick(e) {
        L.popup()
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(mymapDashboard);
    }

    function setKabupaten(obj, kabupaten) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetKabupaten'); ?>',
            data: {
                kabupaten: kabupaten
            },
            dataType: "json",
            success: function(data) {
                if (data.pasien == 0) {
                    toastr.error("Kecamatan belum di set koordinatnya", "Perhatian!");
                    return false;
                }
                $.each(data.loadpasien, function(index, value) {
                    var greenIcon = new L.Icon({
                        iconUrl: '<?php echo Yii::app()->baseUrl; ?>/js/leaflet/images/marker-icon-2x-green.png',
                        shadowUrl: '<?php echo Yii::app()->baseUrl; ?>/js/leaflet/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    L.marker([value.latitude, value.longitude], {
                            icon: greenIcon
                        }).addTo(mymapDashboard)
                        .bindPopup("<b>Kecamatan " + value.kecamatan_nama + "</b><br>" + value.jumlah + ' Pasien').openPopup();
                });
                return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
</script>