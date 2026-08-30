<?php
$profil = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));
$konsys = KonfigsystemK::model()->find();
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
        <div class="col-sm-12">
            <?php $this->renderPartial('_charts', array(
                'dataKolom' => $dataKolom,
                'dataAreaChart' => $dataAreaChart,
                'dataLineChart' => $dataLineChart,
                'dataDonutChart' => $dataDonutChart,
            )); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartPie', array('dataPieChart' => $dataPieChart)); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartBar', array('dataBarChart' => $dataBarChart)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php
            $this->renderPartial($this->path_view . '_todolist', array(
                'modTodolist' => $modTodolist,
                'dataProviderTodolist' => $dataProviderTodolist,
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_table', array('dataTable' => $dataTable)); ?>
        </div>
    </div>
    <?php if ($konsys->mapdashboard) { ?>
        <?php
        $this->renderPartial('_map', array('dataMap' => $dataMap, 'profil' => $profil, 'konsys' => $konsys, 'longitude' => $longitude, 'latitude' => $latitude)); ?>
    <?php } ?>
</div>