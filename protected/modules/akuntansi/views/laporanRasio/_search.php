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
	#bulan.checkbox{
		display:inline-block;
		margin-left:100px;
	}

</style>
<fieldset class="box">
	<legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
	<div class="row">
	<div class="col-sm-4">
	<div class='control-group tahun'>
		<?php echo CHtml::label('Periode Posting', 'periodeposting_id', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php
			echo $form->dropDownList($model, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll("periodeposting_aktif = TRUE ORDER BY tglperiodeposting_awal ASC"),'periodeposting_id','periodeposting_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'prompt'=>'-- Pilih --'));
			?>
		</div>
	</div>
		
		<?php /*
	<div class='control-group tahun'>
		<?php echo CHtml::label('Unit Kerja', 'unitkerja_id', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php
			echo $form->dropDownList($model, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(),'unitkerja_id','namaunitkerja'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'prompt'=>'-- Pilih --'));
			?>
		</div>
	</div>
		 * 
		 */ ?>
</div>
</div>
</fieldset>

    
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		$this->createUrl($this->id.'/Index'), 
		array('class' => 'btn btn-default',
			'onclick'=>'return refreshForm(this);')); 
	
	echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinoutNonGrafik',true);
	?>
</div>
<?php $this->endWidget(); ?>