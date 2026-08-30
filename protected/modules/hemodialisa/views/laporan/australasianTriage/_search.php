<div class="search-form" style="">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type' => 'horizontal',
	'id' => 'searchLaporan',
	'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
		));
?>
<style>
	table{
		margin-bottom: 0px;
	}
	.form-actions{
		padding:4px;
		margin-top:5px;
	}
	.nav-tabs>li>a{display:block; cursor:pointer;}
	.nav-tabs > .active a:hover{cursor:pointer;}
</style>
<div class="row-fluid">
	<div class="span8">
		<fieldset class="box2">
			<legend class="rim">Berdasarkan Tanggal Pendaftaran</legend>
			<?php echo CHtml::hiddenField('type', ''); ?>
			<?php //echo CHtml::hiddenField('src', ''); ?>
			<div class = 'control-label'>Tanggal Pendaftaran</div>
			<div class="controls">  
				<?php
					$model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : date('d M Y');
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_awal',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
				?>
			</div> 
			<?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
			<div class="controls">  
				<?php
				$model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : date('d M Y');
				$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_akhir',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d'
						),
						'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
		</fieldset>

	</div>
	
</div>
<div class="form-actions">
	<?php
	
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
	
	echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); 
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/LaporanAustralasianTriage'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location.href = ;}); return false;'));  ?>

</div>
</div>    
<?php
	$this->endWidget();
?>