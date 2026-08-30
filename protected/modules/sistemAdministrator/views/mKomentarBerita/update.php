<?php
$this->breadcrumbs=array(
	'Samberitakomentar Ts'=>array('index'),
	$model->mberitakomentar_id=>array('view','id'=>$model->mberitakomentar_id),
	'Update',
);

?>
<fieldset class='box'>
    <legend class="rim">Ubah Berita Komentar</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>