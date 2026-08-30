<?php
$profil = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));
$konsys = KonfigsystemK::model()->find();
$konsys->google_api_key;
$longitude = !empty($profil->kabupaten->longitude) ? $profil->kabupaten->longitude : Params::DEFAULT_PROFIL_LONGITUDE;
$latitude = !empty($profil->kabupaten->latitude) ? $profil->kabupaten->latitude : Params::DEFAULT_PROFIL_LATITUDE;
?>
<?php
// $modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'))->modul_nama;
$nama_peg = (!empty(Yii::app()->user->getState('nama_pegawai')) ? Yii::app()->user->getState('nama_pegawai') : Yii::app()->user->getState('nama_pemakai'))
?>
<div class="well">
    <h1><?php echo date('d') . ' ' . MyFormatter::getMonthId(date('m')) . ' ' . date('Y'); ?></h1>
    <h3>Selamat Datang di Modul <?php echo $modul_nama; ?>, <b><?php echo $nama_peg; ?></b></h3>
</div>
<div class="dashboard" style="overflow: hidden;">
    <div class="row">
        <?php $this->renderPartial('_kolom', array('dataKolom' => $dataKolom)); ?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->renderPartial('_charts', array(
                'dataKolom' => $dataKolom,
                'dataAreaChart' => $dataAreaChart,
                'dataLineChart' => $dataLineChart,
                'dataDonutChart' => $dataDonutChart,
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartPie', array('dataPieChart' => $dataPieChart)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartBar', array('dataBarChart' => $dataBarChart)); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_table', array('dataTable' => $dataTable)); ?>
        </div>
    </div>
    <?php
    if ($konsys->mapdashboard == true) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-map"></i> Peta
                </div>
                <div class="panel-options">
                    <a data-rel="collapse" href="#">
                        <i class="entypo-down-open"></i>
                    </a>
                    <a data-rel="reload" href="#">
                        <i class="entypo-arrows-ccw"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body fluid">
                <?php $this->renderPartial('_mapNew', array('dataMap' => $dataMap, 'profil' => $profil, 'konsys' => $konsys, 'longitude' => $longitude, 'latitude' => $latitude)); ?>
            </div>
        </div>
    <?php } ?>
</div>