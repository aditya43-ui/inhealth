<fieldset class="box">
    <legend class="rim">Informasi Pasien</legend>
<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'id'=>'ubahpasien-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#PPPasienM_jenisidentitas',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
    )
);
$this->widget('bootstrap.widgets.BootAlert');
?>
	<div class="row">
		<div class="col-sm-4">
			<?php echo $form->textFieldRow($modPendaftaran,'no_rekam_medik',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <?php echo $form->textFieldRow($modPendaftaran,'no_pendaftaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <?php echo $form->textFieldRow($modPendaftaran,'nama_pasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <?php echo $form->textFieldRow($modPendaftaran,'nama_bin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <?php echo $form->textFieldRow($modPendaftaran,'jeniskelamin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
		</div>
		<div class="col-sm-4">
			<div class="control-group">
                <?php echo $form->labelEx($modPendaftaran,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modPendaftaran,
                                            'attribute'=>'tgl_pendaftaran',
                                            'mode'=>'date',
                                            'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onkeypress'=>"return $(this).focusNextInputField(event)"),
                    )); ?>
                    <?php echo $form->error($modPendaftaran, 'tgl_pendaftaran'); ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($modPendaftaran,'alamat_pasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <?php echo $form->textFieldRow($modPendaftaran,'umur',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <?php echo $form->textFieldRow($modPendaftaran,'jeniskasuspenyakit_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
		</div>
		<div class="col-sm-4">
			<?php echo $form->textFieldRow($modPendaftaran,'ruangan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <?php echo $form->textFieldRow($modPendaftaran,'kelaspelayanan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <div class="control-group">
                <div class="control-label">
                    <?= $modPendaftaran->getAttributeLabel('carabayar_id')?>/
                    <?= $modPendaftaran->getAttributeLabel('penjamin_id')?>
                </div>
                <div class="controls">
                    <?php echo $form->textField($modPendaftaran,'carabayar_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
                    <?php echo $form->textField($modPendaftaran,'penjamin_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPendaftaran,'nama_pegawai',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
            <div class="control-group">
                <div class="control-label">
                    Cara Masuk / Rujuk
                </div>
                <div class="controls">
                    <?php echo $form->textField($modPendaftaran,'caramasuk_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
                    <?php echo $form->textField($modPendaftaran,'nama_perujuk',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6,'readonly'=>TRUE)); ?>
                </div>
            </div>
		</div>
	</div>
<?php $this->endWidget();?>
</fieldset>