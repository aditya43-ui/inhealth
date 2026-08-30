<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'lokasirakdialog',
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
<?php echo $form->hiddenField($model, 'dokrekammedis_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'pasien_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'warnadokrm_id',array('readonly'=>true)); ?>
<div class="control-group">
    <?php echo CHtml::label('No. Dokumen RM', 'nodokumenrm', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('nodokumenrm','nodokumenrm',array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np','np',array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Lokasi Sub Rak Lama', 'subrak_nama', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('subrak_nama','subrak_nama',array('readonly'=>true)); ?>
    </div>
</div>
<?php echo $form->dropDownListRow($model,'subrak_id',CHtml::listData($model->getSubrakItems(),'subrak_id','subrak_nama'),array('empty'=>'-- Pilih --','class'=>'span2')); ?>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPasien()
    {
        var idpasien = $('#temp_subrak').val();
        // myAlert(idpasien);

        $.post("<?php echo Yii::app()->createUrl('ActionAjax/PasienDokumen')?>", { idpasien: idpasien },
            function(data){
                $('#DokrekammedisM_dokrekammedis_id').val(data.dokrekammedis_id);
                $('#DokrekammedisM_warnadokrm_id').val(data.warnadokrm_id);
                $('#np').val(data.nama_pasien);
                $('#nodokumenrm').val(data.nodokumenrm);
                $('#DokrekammedisM_pasien_id').val(data.pasien_id);
                $('#subrak_nama').val(data.subrak_nama);
        }, "json");


    }
    loadDataPasien();
</script>