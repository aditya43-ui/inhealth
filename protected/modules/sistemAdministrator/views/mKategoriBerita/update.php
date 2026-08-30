<?php
$this->breadcrumbs=array(
	'Samkategoriberita Ms'=>array('index'),
	$model->mkategoriberita_id=>array('view','id'=>$model->mkategoriberita_id),
	'Update',
);

?>
<fieldset class="box">
    <legend class="rim">Ubah Kategori Berita</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>