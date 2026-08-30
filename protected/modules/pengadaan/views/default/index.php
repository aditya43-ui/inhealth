<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sie.css" type="text/css" />
<?php
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
$nama_peg = (!empty(Yii::app()->user->getState('nama_pegawai')) ? Yii::app()->user->getState('nama_pegawai') : Yii::app()->user->getState('nama_pemakai'))
?>
<div class="well">
    <h1><?php echo date('d') . ' ' . MyFormatter::getMonthId(date('m')) . ' ' . date('Y'); ?></h1>
    <h3>Selamat Datang di Modul <?php echo $this->module->id; ?>, <b><?php echo $nama_peg; ?></b></h3>
</div>