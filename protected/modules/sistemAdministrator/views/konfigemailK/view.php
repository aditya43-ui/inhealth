<?php
$this->breadcrumbs=array(
	'Konfigemail Ks'=>array('index'),
	$model->konfigemail_id,
);

$this->menu=array(
	array('label'=>'List KonfigemailK','url'=>array('index')),
	array('label'=>'Create KonfigemailK','url'=>array('create')),
	array('label'=>'Update KonfigemailK','url'=>array('update','id'=>$model->konfigemail_id)),
	array('label'=>'Delete KonfigemailK','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->konfigemail_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage KonfigemailK','url'=>array('admin')),
);
?>

<h1>View KonfigemailK #<?php echo $model->konfigemail_id; ?></h1>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'konfigemail_id',
		'konfigemail_host',
		'konfigemail_port',
		'konfigemail_smtp_auth',
		'konfigemail_username',
		'konfigemail_password',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'profilrs_id',
		'konfigemail_smtp_secure',
		'konfigemail_ishtml',
	),
)); ?>
