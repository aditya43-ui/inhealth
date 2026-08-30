<?php
$this->breadcrumbs=array(
	'Samberitakomentar Ts'=>array('index'),
	'Create',
);
?>
<fieldset class="box">
    <legend class="rim">Tambah Komentar Berita</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>