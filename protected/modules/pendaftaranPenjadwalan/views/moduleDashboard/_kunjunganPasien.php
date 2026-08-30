<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/fonts.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/neon.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/custom.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.css">

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/neon-custom.js'); ?>

<style>
    .panel-heading {
        background: none repeat scroll 0 0 #428bca !important;
        color: #eee !important;
    }
</style>
<div class="row">
    <div class="col-sm-8">

        <div class="panel panel-primary" id="charts_env">

            <div class="panel-heading">
                <div class="panel-title with-tabs">
                    <i class="entypo-users"></i> Pasien Kunjungan per Tahun
                </div>

                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="#area-chart" data-toggle="tab">Area Chart</a></li>
                        <li class="active"><a href="#line-chart" data-toggle="tab">Line Chart</a></li>
                        <li class=""><a href="#pie-chart" data-toggle="tab">Pie Chart</a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-content">

                    <div class="tab-pane" id="area-chart">
                        <div id="area-chart-demo" class="morrischart" style="height: 280px;"></div>
                    </div>

                    <div class="tab-pane active" id="line-chart">
                        <div id="line-chart-demo" class="morrischart" style="height: 280px;"></div>
                    </div>

                    <div class="tab-pane" id="pie-chart">
                        <div id="donut-chart-demo" class="morrischart" style="height: 280px;"></div>
                    </div>

                </div>

            </div>

            <table class="table table-striped table-bordered table-condensed table-responsive">

                <thead>
                    <tr>
                        <th width="50%" class="col-padding-1">
                            <div class="pull-left">
                                <div class="h4 no-margin">Pasien Rujukan</div>
                                <small><?php echo isset($pasienRujukan->jumlah) ? $pasienRujukan->jumlah : 0; ?></small>
                            </div>
                            <span class="pull-right pageviews">
                                <?php
                                if (isset($pasienRujukan->jumlah)) {
                                    $data = str_split($pasienRujukan->jumlah);
                                    echo implode(",", $data);
                                }
                                ?>
                            </span>
                        </th>
                        <th width="50%" class="col-padding-1">
                            <div class="pull-left">
                                <div class="h4 no-margin">Pasien Antrian</div>
                                <small><?php echo isset($pasienAntrian->jumlah); ?></small>
                            </div>
                            <span class="pull-right uniquevisitors">
                                <?php
                                if (isset($pasienAntrian->jumlah)) {
                                    $data = str_split($pasienAntrian->jumlah);
                                    echo implode(",", $data);
                                }
                                ?>
                            </span>
                        </th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>
    <div class="col-sm-4">

        <div class="panel panel-primary hidden">
            <div class="panel-heading">
                <div class="panel-title with-tabs">
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
                    <!--<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>-->
                </div>
            </div>

            <div class="panel-body">
                <div id="rickshaw-chart-demo">
                    <div id="rickshaw-legend"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-4">

        <div class="panel panel-primary">
            <table class="table table-striped table-bordered table-condensed table-responsive">
                <thead>
                    <tr>
                        <th class="padding-bottom-none text-center">
                            <br>
                            <br>
                            <span class="monthly-sales"></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="panel-heading">
                            <h4 style="color:#fff">Kunjungan Pasien Dalam Sebulan</h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <div class="col-sm-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Pendaftaran Pasien Terbaru
                </div>
                <div class="panel-options">
                    <a data-rel="collapse" href="#">
                        <i class="entypo-down-open"></i>
                    </a>
                    <a data-rel="reload" href="#">
                        <i class="entypo-arrows-ccw"></i>
                    </a>
                    <a data-rel="close" href="#">
                        <i class="entypo-cancel"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body with-table">
                <table class="table table-striped table-bordered table-condensed table-responsive">
                    <thead>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td>Tanggal Pendaftaran</td>
                            <td>Nama Pasien</td>
                            <td>Jenis Kelamin</td>
                            <td>Status Pasien</td>
                            <td>Activity Kunjungan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modUpdatePasien as $updatePasien) { ?>
                            <tr>
                                <td><?php echo $updatePasien->no_pendaftaran; ?></td>
                                <td><?php echo MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($updatePasien->tgl_pendaftaran))); ?></td>
                                <td><?php echo $updatePasien->pasien->nama_pasien; ?></td>
                                <td><?php echo $updatePasien->pasien->jeniskelamin; ?></td>
                                <td><?php echo $updatePasien->statuspasien; ?></td>
                                <td><?php echo $updatePasien->getJumlahKunjungan(); ?> Kali Berkunjung</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $this->renderPartial('_jsFunctionsKunjunganPasien', array('modPasienbulan' => $modPasienbulan, 'modChart' => $modChart)); ?>
<!--Bottom Scripts SCRIPT INI HARUS TETAP BERADA DI BAWAH-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/gsap/main-gsap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/joinable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/resizeable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-api.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/vendor/d3.v3.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/raphael-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/morris.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.peity.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.sparkline.min.js"></script>
<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/toastr.js"></script>-->
<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-chat.js"></script>-->
<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-demo.js"></script>-->
<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/custom.js"></script>-->
<!--End Bottom Scripts-->