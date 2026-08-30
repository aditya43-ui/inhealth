<?php
$this->breadcrumbs=array(
    'PejabatpengadaanM Ms'=>array('index'),
    $model->pejabatpengadaan_id=>array('view','id'=>$model->pejabatpengadaan_id),
    'Update',
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Pejabat Pengadaan</b></div>
    </div>
    <div class="panel-body">

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modDet'=>$modDet,'cekDet'=> $cekDet,'modUnit'=> $modUnit,'cekUnit'=> $cekUnit)); ?>
    </div>
</div>
