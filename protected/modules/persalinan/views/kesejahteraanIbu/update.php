<?php
$this->breadcrumbs=array(
	'Kesejahteraanibu Ts'=>array('index'),
	$model->kesejahteraanibu_id=>array('view','id'=>$model->kesejahteraanibu_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah KesejahteraanibuT</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
