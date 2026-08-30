<?php
$this->breadcrumbs=array(
	'Isi Persetujuan'=>array('index'),
	'Tambah',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Tambah <b>Isi Persetujuan</b>
        </div>
    </div>
    <div class="panel-body">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        
    </div>
</div>

