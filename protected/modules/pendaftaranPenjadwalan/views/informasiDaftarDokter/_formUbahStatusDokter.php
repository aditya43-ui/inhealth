<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahstatusdokter-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
	$this->widget('bootstrap.widgets.BootAlert'); 
?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pegawai_id',array('readonly'=>true)); ?>
<table>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('NIP', 'nomorindukpegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nomorindukpegawai',array('readonly'=>true)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Nama Dokter', 'nama_pegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_pegawai',array('readonly'=>true)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Alamat', 'alamat_pegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'alamat_pegawai',array('readonly'=>true)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('No. Telepon', 'notelp_pegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'notelp_pegawai',array('readonly'=>true)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'pegawai_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Save', array('{icon}'=>'<i class="entypo-check"></i>')), 
			array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')
		);
    ?>
    <?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-check"></i>')), 
			array('class'=>'btn btn-danger', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	function closeDialog(){
		window.parent.$('#dialogUbahStatusDokter').dialog('close');
	}
</script>
