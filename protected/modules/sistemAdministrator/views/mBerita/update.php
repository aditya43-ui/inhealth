<?php
$this->breadcrumbs=array(
	'Samberita Ms'=>array('index'),
	$model->mberita_id=>array('view','id'=>$model->mberita_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Berita</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>