<?php
$this->breadcrumbs=array(
	'Isi Persetujuan'=>array('index'),
	$model->persetujuanumumisi_id=>array('view','id'=>$model->persetujuanumumisi_id),
	'Ubah',
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Ubah <b>Isi Persetujuan</b>
        </div>
    </div>
    <div class="panel-body">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        
    </div>
</div>
