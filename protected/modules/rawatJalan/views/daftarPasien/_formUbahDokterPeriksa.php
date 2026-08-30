<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<style>
    .form-horizontal .control-label{
        width: 180px;
    }
</style>
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
    <?php echo Yii::t('mds','&nbsp;&nbsp;Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model,$modUbahDokter)); ?>
<div class="control-group">
                        <?php echo CHtml::label('&nbsp;&nbsp;Tanggal Pengalihan','tglubahdokter', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modUbahDokter,
                                                    'attribute'=>'tglubahdokter',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'realtime dtPicker3'),
                            )); 
                                     ?>
                        </div>
                    </div>
<?php echo $form->hiddenField($model, 'pendaftaran_id',array('readonly'=>true)); ?>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nomor Pendaftaran <span class="required">*</span>', 'no_pendaftaran', array('class'=>'control-label required')) ?>
<div class="controls">
<?php echo $form->textField($model, 'no_pendaftaran',array('style'=>'white-space: nowrap;','readonly'=>true)); ?>
</div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nama Pasien', 'np', array('class'=>'control-label')) ?>
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
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Dokter Lama', 'dp', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('dp','dp',array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Dokter Baru', 'db', array('class'=>'control-label')) ?>
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
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Alasan Perubahan', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modUbahDokter,'alasanperubahandokter', LookupM::getItems('alasanperubahandokter'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'float:left; width:220px')); ?>   

    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Keterangan', 'k', array('class'=>'control-label')) ?>
    <div class="controls">
       <?php echo $form->hiddenField($modUbahDokter,'dokterlama_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
       <?php echo $form->textArea($modUbahDokter,'keterangan',array('placeholder'=>'Keterangan Perubahan Dokter','rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo ($menu == 'RD' ? $this->createUrl('getDataPendaftaranRD') : $this->createUrl('getDataPendaftaranRJ')); ?>", { pendaftaran_id: pendaftaran_id },
            function(data){
                $('#RJPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                $('#RJPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#RJPendaftaranT_ruangan_id').val(data.ruangan_id);
                var dokter = data.gelardepan + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
				$('#RJUbahdokterR_dokterlama_id').val(data.pegawai_id);
                listDokterRuangan(data.ruangan_id, data.pegawai_id);
            },
        "json");
    }
    loadDataPendaftaran();
    
    function listDokterRuangan(idRuangan, idPegawai)
    {
        $.post("<?php echo $this->createUrl('listDokterRuangan')?>", { idRuangan: idRuangan, idPegawai },
            function(data){
                $('#RJPendaftaranT_pegawai_id').html(data.listDokter);
        }, "json");
    }    
	function closeDialog(){
		window.parent.$('#editDokterPeriksa').dialog('close');
	}
</script>