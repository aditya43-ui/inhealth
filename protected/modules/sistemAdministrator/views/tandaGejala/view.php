<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Tanda dan Gejala</b>
        </div>
    </div>
    <div class="panel-body">

	<?php
	$this->breadcrumbs = array(
		'Lookup Ms' => array('index'),
		$model->tandagejala_id,
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
                            'label' => 'Jenis Tanda dan Gejala',
                            'value' =>  !empty($model->kelompoktandagejaladaftar_id) ? $model->kelompoktandagejaladaftar->jenistandagejala->jenistandagejala_nama.' - '.$model->kelompoktandagejaladaftar->jenistandagejala->subjenistandagejala_nama : '',
			),
			array(
                            'label' => 'Tanda dan Gejala',
                            'value' =>  $model->kelompoktandagejaladaftar->tandagejalaDaftar->tandagejala_daftar_nama,
			),
			array(
                            'label'=>'Status',
                            'type'=>'raw',
                            'value'=>($model->tandagejala_aktif == 1) ? "Aktif" : "Tidak Aktif",
			),
		),
	));
	?>
	<?php //echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->tandagejala_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')).'&nbsp;'; ?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tanda dan Gejala', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
$this->widget('UserTips', array('type' => 'view'));
?>
</div>
</div>