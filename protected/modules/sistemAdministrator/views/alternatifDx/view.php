<div class="white-container">
    <legend class="rim2">Lihat <b>Alternatif Diagnosa</b></legend>
	<?php
	$this->breadcrumbs = array(
		'Lookup Ms' => array('index'),
		$model->alternatifdx_id,
	);

	$this->menu = array(
			//        array('label'=>Yii::t('mds','View').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	);

	$this->widget('bootstrap.widgets.BootAlert');
	?>

	<?php
	$this->widget('ext.bootstrap.widgets.BootDetailView', array(
		'data' => $model,
		'attributes' => array(
			array(
				'label' => 'Diagnosa Keperawatan',
				'value' => $model->diagnosakep->diagnosakep_nama,
			),
			array(
				'label'=>'Indikator',
				'type'=>'raw',
				'value'=>$model->alternatifdx_nama,
			),
			array(
				'label'=>'Status',
				'type'=>'raw',
				'value'=>($model->alternatifdx_aktif == 1) ? "Aktif" : "Tidak Aktif",
			),
		),
	));
	?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')), $this->createUrl('update', array('id' => $model->alternatifdx_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)).'&nbsp;'; ?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Alternatif Diagnosa', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
$this->widget('UserTips', array('type' => 'view'));
?>
</div>