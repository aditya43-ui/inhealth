<?php
$this->breadcrumbs=array(
	'Indikatorevaluasipenawaran Ms'=>array('index'),
	$model->indikatorevaluasipenawaran_id=>array('view','id'=>$model->indikatorevaluasipenawaran_id),
	'Update',
);

?>
<div class="white-container">
    <div class="panel panel-success">
        <div class="panel panel-heading">
            <div class="panel-title"> Ubah <b> Indikator Evaluasi Penawaran </b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
