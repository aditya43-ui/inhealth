<?php
$this->breadcrumbs = array(
	'Obat Alkes Penjamin' => array('admin'),
	$model->obatalkespenjamin_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Obat Alkes Penjamin</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<div class="row-fluid">
		<?php
		$this->widget('ext.bootstrap.widgets.BootDetailView', array(
			'data' => $model,
			'attributes' => array(
				array(
					'label' => 'Jenis Penjamin',
					'type' => 'raw',
					'value' => $model->carabayar->carabayar_nama,
				),
				array(
					'label' => 'Penjamin',
					'type' => 'raw',
					'value' => $model->penjamin->penjamin_nama,
				),
				array(
					'label' => 'Jenis Obat Alkes',
					'type' => 'raw',
					'value' => isset($model->jenisobatalkes->jenisobatalkes_nama)?$model->jenisobatalkes->jenisobatalkes_nama:"-",
				),
				array(
					'label' => 'Margin (%)',
					'type' => 'raw',
					'value' => MyFormatter::formatNumberForPrint((!empty($model->persmargin)?$model->persmargin:0),2),
				),
				array(
					'label' => 'Keringanan (%)',
					'type' => 'raw',
					'value' => MyFormatter::formatNumberForPrint((!empty($model->persdiskon)?$model->persdiskon:0),2),
				),
				array(
					'label' => 'Biaya Administrasi (%)',
					'type' => 'raw',
					'value' => MyFormatter::formatNumberForPrint((!empty($model->biayaadministrasi)?$model->biayaadministrasi:0),2),
				),
			),
		));
		?>

	</div>
	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('index', array('id' => $model->obatalkespenjamin_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Obat Alkes Penjamin', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
		</div>
	</div>
    </div>
</div>
