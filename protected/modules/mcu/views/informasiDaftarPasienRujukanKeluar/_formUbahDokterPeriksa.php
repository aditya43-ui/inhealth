<?php
	if(isset($_GET['sukses'])){
		Yii::app()->user->setFlash('success',"Data berhasil disimpan");              
	}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahDokterPemeriksa-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pasiendirujukkeluar_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'tgldirujuk',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'nosuratrujukan',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($modPasien, 'no_rekam_medik',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($modPasien, 'nama_pasien',array('readonly'=>true)); ?>
<div class="control-group">
	<div class="control-label"> Rumah Sakit Tujuan</div>
	<div class="controls">
		<?php echo $form->textField($model, 'rumahsakitrujukan',array('readonly'=>true)); ?>
	</div>
</div>
<?php echo $form->textFieldRow($model, 'dokterpemeriksa',array('readonly'=>false)); ?>

<div class="form-actions">
    <?php
		if(isset($_GET['sukses'])){
			$disabledSave = true;
		}else{
			$disabledSave = false;
		}
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)','disabled'=>$disabledSave));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>
<script>
function closeDialog(){
	window.parent.$('#dialogUbahDokterPeriksa').dialog('close');
}
</script>
