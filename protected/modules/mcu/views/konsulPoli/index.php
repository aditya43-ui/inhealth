<?php
$this->breadcrumbs=array(
	'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert'); ?>


<!--<legend class="rim">Tabel Konsultasi Poliklinik</legend>-->
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($modKonsul,'catatan_dokter_konsul'),
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary(array($modKonsul,$modelPendaftaran)); ?>
<?php $this->renderPartial($this->path_view.'_rowKonsulPoli',array('modKonsul'=>$modKonsul)); ?>
<?php $this->endWidget(); ?>
<script>
$(document).ready(function(){
	$('#tabel-konsultasi tbody').each(function(){
		jQuery('input[name$="[tglkonsulpoli]"]').datetimepicker(
			jQuery.extend(
				{
					showMonthAfterYear:false
				}, 
				jQuery.datepicker.regional['id'],
				{
					'dateFormat':'dd M yy',
					'maxDate':'d',
					'timeText':'Waktu',
					'hourText':'Jam',
					'minuteText':'Menit',
					'secondText':'Detik',
					'showSecond':true,
					'timeOnlyTitle':'Pilih Waktu',
					'timeFormat':'hh:mm:ss',
					'changeYear':true,
					'changeMonth':true,
					'showAnim':'fold',
					'yearRange':'-80y:+20y'
				}
			)
		);
	});
});	
</script>