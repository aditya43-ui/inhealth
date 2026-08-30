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
<?php echo $form->hiddenField($model, 'dokrekammedis_id',array('readonly'=>true, 'class'=>'sr_dokrekammedis_id')); ?>
<?php echo $form->hiddenField($model, 'pasien_id',array('readonly'=>true, 'class'=>'sr_pasien_id')); ?>
<?php echo $form->hiddenField($model, 'warnadokrm_id',array('readonly'=>true, 'class'=>'sr_warnadokrm_id')); ?>
<div class="control-group">
    <?php echo CHtml::label('No. Dokumen RK', 'nodokumenrm', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('nodokumenrm','nodokumenrm',array('readonly'=>true, 'class'=>'sr_nodokumenrm')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np','np',array('readonly'=>true, 'class'=>'sr_np')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Lokasi Sub Rak Lama', 'subrak_nama', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('subrak_nama','subrak_nama',array('readonly'=>true, 'class'=>'sr_subrak_nama')); ?>
    </div>
</div>
<?php echo $form->dropDownListRow($model,'subrak_id',CHtml::listData($model->getSubrakItems(),'subrak_id','subrak_nama'),array('empty'=>'-- Pilih --','class'=>'span2 sr_eubrak_nama')); ?>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPasien()
    {
        var idpasien = $('#temp_subrak').val();
        // myAlert(idpasien);

        $.post("<?php echo $this->createUrl('PasienDokumen')?>", { idpasien: idpasien },
            function(data){
                $('.sr_dokrekammedis_id').val(data.dokrekammedis_id);
                $('.sr_warnadokrm_id').val(data.warnadokrm_id);
                $('.sr_np').val(data.nama_pasien);
                $('.sr_nodokumenrm').val(data.nodokumenrm);
                $('.sr_pasien_id').val(data.pasien_id);
                $('.sr_subrak_nama').val(data.subrak_nama);
        }, "json");

    }
    loadDataPasien();
</script>