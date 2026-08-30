<?php  ?>
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
<?php echo $form->errorSummary(array($model,$modUbahDokter)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<?php echo $form->textFieldRow($model, 'no_pendaftaran',array('readonly'=>true)); ?>
<div class="control-group ">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np','np',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($model,'ruangan_id',
        CHtml::listData($model->getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
        array('empty'=>'-- Pilih --','disabled'=>'disabled')
    );
?>
<div class="control-group ">
    <?php echo CHtml::label('Dokter Lama', 'dp', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('dp','dp',array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Dokter Baru', 'db', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
		?>

    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Alasan Perubahan', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modUbahDokter,'alasanperubahandokter', LookupM::getItems('alasanperubahandokter'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:220px')); ?>   

    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Keterangan', 'k', array('class'=>'control-label')) ?>
    <div class="controls">
       <?php echo $form->hiddenField($modUbahDokter,'dokterlama_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
       <?php echo $form->textArea($modUbahDokter,'keterangan',array('placeholder'=>'Keterangan Perubahan Dokter','rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			array('class'=>'btn btn-danger', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo $this->createUrl('getDataPendaftaranHD'); ?>", { pendaftaran_id: pendaftaran_id},
            function(data){
                $('#<?php echo CHtml::activeId($model,"no_pendaftaran"); ?>').val(data.no_pendaftaran);
                $('#<?php echo CHtml::activeId($model,"pendaftaran_id"); ?>').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#<?php echo CHtml::activeId($model,"ruangan_id"); ?>').val(data.ruangan_id);
                var dokter = data.gelardepan + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
				$('#HDUbahdokterR_dokterlama_id').val(data.pegawai_id);
                listDokterRuangan(data.ruangan_id);
            },
        "json");
    }
    loadDataPendaftaran();
    
    function listDokterRuangan(idRuangan)
    {
        $.post("<?php echo $this->createUrl('listDokterRuangan')?>", { idRuangan: idRuangan },
            function(data){
                $('#<?php echo CHtml::activeId($model,"pegawai_id"); ?>').html(data.listDokter);
        }, "json");
    }    
	function closeDialog(){
		window.parent.$('#editDokterPeriksa').dialog('close');
	}
</script>