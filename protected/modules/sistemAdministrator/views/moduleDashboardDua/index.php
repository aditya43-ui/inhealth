<?php

/**
 * Digunakan untuk menampilkan data dengan template dashboard dua neon
 *
 * @category     views - dashboard
 * @author         Muhammad Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 */

$profil = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));
$konsys = KonfigsystemK::model()->find();
$longitude = !empty($profil->kabupaten->longitude) ? $profil->kabupaten->longitude : Params::DEFAULT_PROFIL_LONGITUDE;
$latitude = !empty($profil->kabupaten->latitude) ? $profil->kabupaten->latitude : Params::DEFAULT_PROFIL_LATITUDE;
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.pie').sparkline('html', {
            type: 'pie',
            borderWidth: 0,
            sliceColors: ['#af5fd8', '#00c0ef', '#55ce63']
        });
        // $(".chart").sparkline([1,2,3,1,2,34,4], {
        //     type: 'pie',
        //     barColor: '#485671',
        //     height: '110px',
        //     barWidth: 10,
        //     barSpacing: 2});

        var map = $("#map");

        map.vectorMap({
            map: 'europe_merc_en',
            zoomMin: '3',
            backgroundColor: '#00a651',
            focusOn: {
                x: 0.5,
                y: 0.8,
                scale: 3
            }
        });


        // Rickshaw
        var seriesData = [
            [],
            []
        ];

        var random = new Rickshaw.Fixtures.RandomData(50);

        for (var i = 0; i < 90; i++) {
            random.addData(seriesData);
        }

        var graph = new Rickshaw.Graph({
            element: document.getElementById("rickshaw-chart-demo-2"),
            height: 217,
            renderer: 'area',
            stroke: false,
            preserve: true,
            series: [{
                color: '#5a1bd0',
                data: seriesData[0],
                name: 'Page Views'
            }, {
                color: '#8f63e8',
                data: seriesData[1],
                name: 'Unique Users'
            }, {
                color: '#b08bf9',
                data: seriesData[1],
                name: 'Bounce Rate'
            }]
        });

        graph.render();

        var hoverDetail = new Rickshaw.Graph.HoverDetail({
            graph: graph,
            xFormatter: function(x) {
                return new Date(x * 1000).toString();
            }
        });

        var legend = new Rickshaw.Graph.Legend({
            graph: graph,
            element: document.getElementById('rickshaw-legend')
        });

        var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight({
            graph: graph,
            legend: legend
        });

        setInterval(function() {
            random.removeData(seriesData);
            random.addData(seriesData);
            graph.update();

        }, 500);
        var bulans = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Donut Chart
        var donut_chart_demo = $("#donut-chart-demo");

        donut_chart_demo.parent().show();

        var donut_chart = Morris.Donut({
            element: 'donut-chart-demo',
            data: [
                <?php foreach ($modChart as $i => $chart) { ?> {
                        label: bulans[<?php echo $chart->bulan; ?> - 1],
                        value: <?php echo $chart->jumlah; ?>
                    },
                <?php } ?>
            ],
            colors: [
                <?php foreach ($modChart as $i => $chart) { ?>
                    getRandomColor(),
                <?php } ?>
            ]
        });

        donut_chart_demo.parent().attr('style', '');


        function getRandomColor() {
            var flat_colors = [
                '#8788fd', '#55ce63',
                '#f7e05a', '#f62d51',
                '#997ad3', '#55ce63',
                '#f7e05a', '#f62d51',
                '#bdc3c7', '#ebebfd',
                '#1abc9c', '#2ecc71',
                '#3498db', '#9b59b6',
                '#34495e', '#f1c40f',
                '#e67e22', '#e74c3c',
            ];
            var index = Math.floor((Math.random() * 10));
            var color = flat_colors[index];
            return color;
        }

    });
</script>
<!--<div class="row">
                        <div class="col-sm-12">
                            <div class="well">
                                <h1>December 18, 2013</h1>
                                <h3>Welcome to the site <b>Art Ramadani</b></h3>
                            </div>
                        </div>
                    </div>-->
<?php
// $modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'))->modul_nama;
$nama_peg = (!empty(Yii::app()->user->getState('nama_pegawai')) ? Yii::app()->user->getState('nama_pegawai') : Yii::app()->user->getState('nama_pemakai'))
?>
<div class="well">
    <?php $format = new MyFormatter(); ?>
    <h1><?php echo date('d') . ' ' . $format->getMonthId(date('m')) . ' ' . date('Y'); ?></h1>
    <h3>Selamat Datang di Modul <?php echo $modul_nama; ?>, <b><?php echo $nama_peg; ?></b></h3>
</div>

<div class="dashboard" style="overflow: hidden;">
    <div class="row">
        <div class="col-sm-4">
            <div class="tile-stats tile-red">
                <div class="icon">
                    <i class="fas fa-walking"></i>
                </div>
                <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo '0'; ?>" data-start="0" class="num">0</div>
                <h3>Kunjungan Pasien</h3>
                <p>Kunjungan pasien hari ini.</p>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="tile-stats tile-green">
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo '0'; ?>" data-start="0" class="num">0</div>
                <h3>Pasien Baru</h3>
                <p>Pasien pengunjung baru hari ini.</p>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="tile-stats tile-aqua">
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo '0'; ?>" data-start="0" class="num">0</div>
                <h3>Pasien Lama</h3>
                <p>Pasien pengunjung lama hari ini.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-chart-pie"></i> Pasien Kunjungan per Tahun
                    </div>

                    <div class="panel-options">
                        <!--<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>-->
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        <!--<a href="#" data-rel="close"><i class="icon-form-silang"></i></a>-->
                    </div>
                </div>
                <div class="panel-body">
                    <div id="donut-chart-demo" class="morrischart" style="height: 280px;"></div>
                    <!--<p style="margin: 0; text-align: center;"><span class="chart"></span></p>-->
                </div>
            </div>

        </div>

        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-users"></i> Pendaftaran Pasien Terbaru
                    </div>

                    <div class="panel-options">
                        <!--<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>-->
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        <!--<a href="#" data-rel="close"><i class="icon-form-silang"></i></a>-->
                    </div>
                </div>
                <div class="panel-body with-table table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-responsive">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama Pasien</th>
                                <th>Status Pasien</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($modUpdatePasien as $updatePasien) { ?>
                                <tr>
                                    <td><?php echo $updatePasien->no_pendaftaran; ?></td>
                                    <td><?php echo $updatePasien->pasien->nama_pasien; ?></td>
                                    <td><?php echo $updatePasien->statuspasien; ?></td>
                                    <td><span class="pie"><?php echo $updatePasien->getJumlahPasienRJ(); ?>,<?php echo $updatePasien->getJumlahPasienRI(); ?>,<?php echo $updatePasien->getJumlahPasienRD(); ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default hidden">
        <div class="panel-heading">
            <div class="panel-title">
                <h4>
                    Real Time Stats
                    <br>
                    <small>current server uptime</small>
                </h4>
            </div>

            <div class="panel-options">
                <!--<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>-->
                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                <!--<a href="#" data-rel="close"><i class="icon-form-silang"></i></a>-->
            </div>
        </div>

        <div class="panel-body">
            <div id="rickshaw-chart-demo-2">
                <div id="rickshaw-legend"></div>
            </div>
        </div>
    </div>

    <?php
    if ($konsys->mapdashboard) {
    ?>
        <div class="row">
            <div class="col-sm-8">
                <div class="panel panel-default" data-collapsed="0">
                    <!--to apply shadow add class "panel-shadow"-->
                    <!--panel head-->
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-map"></i> Peta Penyebaran Pasien Selama Setahun
                        </div>

                        <div class="panel-options">
                            <!--<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-3" class="bg"><i class="entypo-cog"></i></a>-->
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                            <!--<a href="#" data-rel="close"><i class="icon-form-silang"></i></a>-->
                        </div>
                    </div>
                    <div class="panel-body fluid">
                        <?php $this->renderPartial('_mapNew', array('dataMap' => $modMap)); ?>

                        <!--<div id="googlemaps" style="height:450px;width:100%;" class="map"></div>-->
                    </div>
                    <!--<table class="table table-striped table-bordered table-condensed table-responsive">
        <thead>
            <tr>
                <th>Kecamatan</th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>-->
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default" data-collapsed="0">
                    <!--to apply shadow add class "panel-shadow"-->
                    <!--panel head-->
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-map"></i> Kecamatan
                        </div>

                        <div class="panel-options">
                            <!--<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-3" class="bg"><i class="entypo-cog"></i></a>-->
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                            <!--<a href="#" data-rel="close"><i class="icon-form-silang"></i></a>-->
                        </div>
                    </div>
                    <div class="panel-body with-table table-responsive" style="height: 500px;">
                        <!--<div class="scrollable" data-height="550" data-scroll-position="right" data-rail-color="#000" data-rail-opacity=".9" data-rail-width="8" data-rail-radius="10" data-autohide="0">-->
                        <table class="table table-striped table-bordered table-condensed table-responsive">
                            <tbody>
                                <?php foreach ($modMap as $i => $map) { ?>
                                    <tr style="cursor:pointer;" onclick="panTo(<?php echo !empty($map->latitude) ? $map->latitude : "'tidakada'" ?>, <?php echo (!empty($map->longitude)) ? $map->longitude : "'tidakada'"; ?>)">
                                        <td><span style="display:inline-block;"><?php echo $map->kecamatan_nama ?></span> <span class="pull-right" style="display:inline-block; margin-right:10px"><?php echo $map->jumlahpasien ?></span> </td>
                                    </tr>
                                <?php } ?>
                                <!--<tr>
                <td>European Union</td>
            </tr>-->
                            </tbody>
                        </table>
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://maps.google.com/maps/api/js?key=<?php echo $konsys->google_api_key ?>&callback=initialize" async defer></script>
<script type="text/javascript">
    var markerCount = 0;
    var map;

    function initialize() {
        var myLatlng = new google.maps.LatLng(<?php echo $longitude; ?>, <?php echo $latitude; ?>); //latitude,longitude
        var map_canvas = document.getElementById('googlemaps');
        var map_options = {
            center: myLatlng,
            zoom: 15,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(map_canvas, map_options);

        var contentString = '<div id="content">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<h4 id="firstHeading" class="firstHeading"><?php echo $profil->nama_rumahsakit; ?></h4>' +
            '<div id="bodyContent">' +
            '<p><?php echo $profil->alamatlokasi_rumahsakit; ?></p>' +
            '</div>' +
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
            infowindow.open(map, marker);
        });

    }

    google.maps.event.addDomListener(window, 'load', initialize);



    function addMarkerToMap(lat, long, htmlMarkupForInfoWindow) {
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

    function panTo(lat, long) {
        if (lat == 'tidakada' || long == 'tidakada') {
            alert('longitude dan latitude belum di-set!');
            return false;
        }
        var myLatLng = new google.maps.LatLng(long, lat);
        map.panTo(myLatLng);
    }

    setTimeout(function() {
        <?php foreach ($modMap as $i => $map) {
            if (isset($map->latitude) && isset($map->longitude)) {
        ?>
                addMarkerToMap('<?php echo $map->latitude ?>', '<?php echo $map->longitude ?>', '<?php echo $map->kecamatan_nama ?>');
        <?php }
        } ?>
    }, 6000);
</script>
<?php
    }
?>