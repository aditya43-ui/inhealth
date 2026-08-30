<?php
$this->breadcrumbs=array(
	'Samkategoriberita Ms'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
    <legend class="rim">Tambah Kategori Berita</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>