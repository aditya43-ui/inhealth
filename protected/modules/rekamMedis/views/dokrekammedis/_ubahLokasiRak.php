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
    <?php echo CHtml::label('No. Dokumen RK', 'nodokumenrm', array('class'=>'control-label')) ?>
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
    <?php echo CHtml::label('Lokasi Rak Lama', 'lokasirak_nama', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('lokasirak_nama','lokasirak_nama',array('readonly'=>true)); ?>
    </div>
</div>
<?php echo $form->dropDownListRow($model,'lokasirak_id',CHtml::listData($model->getLokasirakItems(),'lokasirak_id','lokasirak_nama'),array('empty'=>'-- Pilih --','class'=>'span2 required')); ?>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'cekSubmit();'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPasien()
    {
        var idpasien = $('#temp_lokasirak').val();
        // myAlert(idpasien);

        $.post("<?php echo $this->createUrl('PasienDokumen')?>", { idpasien: idpasien },
            function(data){
                $('#DokrekammedisM_dokrekammedis_id').val(data.dokrekammedis_id);
                $('#DokrekammedisM_warnadokrm_id').val(data.warnadokrm_id);
                $('#np').val(data.nama_pasien);
                $('#nodokumenrm').val(data.nodokumenrm);
                $('#DokrekammedisM_pasien_id').val(data.pasien_id);
                $('#lokasirak_nama').val(data.lokasirak_nama);
        }, "json");

    }
	
	function cekSubmit(){
		var lokasirak = $("#<?php echo CHtml::activeid($model,'lokasirak_id'); ?>");
		
		lokasirak.removeClass('error');
		if (lokasirak.val() == ''){
			myAlert("Lokasi Rak Wajib Diisi");
			lokasirak.addClass('error');
			return false;
		}else{
			$("#lokasirakdialog").submit();
		}
	}
	
    loadDataPasien();
</script>