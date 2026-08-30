<?php
	if(isset($_GET['sukses'])){
		Yii::app()->user->setFlash('success',"Data berhasil disimpan");              
	}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahPoliklinik-form',
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
<?php echo $form->errorSummary($modPendaftaran); ?>
<?php echo $form->hiddenField($modPendaftaran, 'pendaftaran_id',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($modPendaftaran, 'no_pendaftaran',array('readonly'=>true)); ?>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($modPasien, 'nama_pasien',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($modPendaftaran,'ruangan_id',
        CHtml::listData($modPendaftaran->getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
        array('empty'=>'-- Pilih --')
    );
?>
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
		if(isset($_GET['sukses'])){
			echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus();return false",'disabled'=>FALSE  )).'&nbsp;';
		}
	?>
</div>
<?php $this->endWidget(); ?>
<script>
/**
 * print status
 */
function printStatus()
{
    window.open('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printStatus',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}	
</script>
