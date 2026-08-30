<?php
$this->breadcrumbs=array(
	'Indikatorevaluasipenawaran Ms'=>array('index'),
	'Create',
);
?>
<div class="white-container">
    <div class="panel panel-success">
        <div class="panel panel-heading">
            <div class="panel-title"> Tambah <b> Indikator Evaluasi Penawaran </b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>