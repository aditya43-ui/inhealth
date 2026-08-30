<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
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
<?php echo $form->hiddenField($model, 'pendaftaran_id',array('readonly'=>true)); ?>
<div class="control-group">
    <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('no_pendaftaran','no_pendaftaran',array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np','np',array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Ruangan', 'ruangan_nama', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('ruangan_nama','ruangan_nama',array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Dokter Periksa', 'dp', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('dp','dp',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($model,'pegawai_id',
            CHtml::listData(
                $model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai'
            ),
            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
        );
?>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo Yii::app()->createUrl('ActionAjax/getDataPendaftaranRI'); ?>", { pendaftaran_id: pendaftaran_id },
            function(data){
                $('#no_pendaftaran').val(data.no_pendaftaran);
                $('#PasienadmisiT_pendaftaran_id').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#ruangan_nama').val(data.ruangan_nama);
                var dokter = (data.gelardepan == null ? "dr.": data.gelardepan) + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
                listDokterRuangan(data.ruangan_id);
            },
        "json");
    }
    loadDataPendaftaran();
    
    function listDokterRuangan(idRuangan)
    {
        $.post("<?php echo Yii::app()->createUrl('actionDynamic/listDokterRuangan')?>", { idRuangan: idRuangan },
            function(data){
                $('#PasienadmisiT_pegawai_id').html(data.listDokter);
        }, "json");
    }    
</script>