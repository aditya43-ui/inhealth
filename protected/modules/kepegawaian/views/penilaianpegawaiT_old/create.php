<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Penilaian Pegawai berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penilaian Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kppenilaianpegawai Ts' => array('index'),
            'Create',
        ); ?>
        <?php echo $this->renderPartial('kepegawaian.views.penilaianpegawaiT._form', array('model' => $model, 'modPegawai' => $modPegawai, 'namapegawai' => '')); ?>
    </div>
</div>