<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly'=>true,'class'=>'span3')); ?>

<div class="control-group">
	<?php echo CHtml::label('Ruangan','ruangan_id',array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->dropDownList($modPasienMasukPenunjang,'ruangan_id', CHtml::listData(RORuanganM::model()->findAll("instalasi_id = 6 and ruangan_aktif = true order by ruangan_nama"), 'ruangan_id', 'ruangan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>
	</div>
</div>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(ROPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span4')); ?>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(ROPendaftaranT::model()->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanRad();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang,'kelaspelayanan_id'); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>&emsp;
		<?= CHtml::activeCheckBox($modPasienMasukPenunjang, 'ceklis', array('title'=>'Klik untuk masukan nama dokter luar.' , 'id' =>'ceklis'))?>
    </div>
</div>
<div class="control-group">
	<?php echo CHtml::label('Dokter Luar', 'dokterluar', array('class' => 'control-label', "id"=>"judul")); ?>
	<div class="controls">
	    <?php echo $form->textField($modPasienMasukPenunjang, 'dokterluar',  array('id'=>'dokter','onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4', 'style'=>"display:none;")); ?>
	</div>
</div>
<!-- <div class="control-group">
	<?php // echo CHtml::label('PPDS','ppds_id',array('class'=>'control-label')); ?>
	<div class="controls">
		<?php // echo $form->dropDownList($modPasienMasukPenunjang,'ppds_id', CHtml::listData(PpdsM::model()->findAll('ppds_aktif = true'), 'ppds_id', 'ppds_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>
	</div>
</div> -->
<!-- <div class="control-group">
	<?php // echo CHtml::label('Radiografer','perawat_id',array('class'=>'control-label')); ?>
	<div class="controls">
		<?php // echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(ROPegawaiM::model()->getTenagaRads($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>
	</div>
</div> -->
<div class="control-group hide">
	<?php echo CHtml::label('Tgl. Rencana Pemeriksaan','tgl_tindakan', array('class'=>'control-label')) ?>
	<div class="controls">
		<?php 
		$modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modTindakan->tgl_tindakan);
		$this->widget('MyDateTimePicker',array(
							'name'=>'tgl_tindakan_semua',
						   'mode'=>'datetime',
						   'options'=> array(
						   'dateFormat'=>Params::DATE_FORMAT,
						),
						   'htmlOptions'=>array('readonly'=>true,'class'=>'span3',
						   'onkeypress'=>"return $(this).focusNextInputField(event)"),
		)); 

		$tindakan = new TindakanpelayananT;
		$tgl_tindakan = date('Y-m-d H:i:s');

		if(isset($_GET['pasienmasukpenunjang_id'])) {
			$tindakan = TindakanpelayananT::model()->find("pasienmasukpenunjang_id = " . $_GET['pasienmasukpenunjang_id']);
			$tgl_tindakan = $tindakan->tgl_tindakan;
		}


		?>
	</div> 
	<div class="controls hide">
    	 <?php echo $form->checkBox($modPasienMasukPenunjang, 'is_elektif', array('id'=>'is_elektif')); ?>
    	<label for="is_elektif">Pemeriksaan Elektif</label>
	</div>
</div> 

<script>
	$('#tgl_tindakan_semua').val('<?php echo MyFormatter::formatDateTimeForUser($tgl_tindakan)?>');

	$(document).ready(function() {
    var pegawai_id = jQuery('#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id') ?>');
	    jQuery(pegawai_id).multiselect({
	        includeSelectAllOption: false,
	        buttonClass: "form-control",
	        maxHeight: 300,
	        buttonWidth: '240px',
	        enableCaseInsensitiveFiltering: true
	    }).hide();

	});
</script>
