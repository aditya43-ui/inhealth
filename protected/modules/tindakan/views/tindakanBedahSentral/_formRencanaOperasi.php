<div class="control-group">
	<?php echo CHtml::label('Tgl. Tindakan <span class="required">*</span>','Tanggal',array('class'=>'control-label required')); ?>
	<div class="controls">
			<?php   
					$this->widget('MyDateTimePicker',array(
									'model'=>$modTindakan,
									'attribute'=>'tgl_tindakan',
									'mode'=>'datetime',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
			)); ?>
			<?php echo $form->error($modTindakan, 'tgl_tindakan'); ?>
	</div>
</div>
<?php // echo $form->textFieldRow($modTindakan,'norencanaoperasi',array('readonly'=>true)) ?>
<?php // echo $form->dropDownListRow($modTindakan,'kamarruangan_id', CHtml::listData($modTindakan->getKamarKosongItems(4), 'kamarruangan_id', 'KamarDanTempatTidur') , 
//							   array('empty'=>'-- Pilih --',
//											'onkeypress'=>"return $(this).focusNextInputField(event)",
//											'class'=>'span3'
//								   )); ?>
<div class="control-group">
	<?php echo CHtml::label('Dokter Pelaksana 1 <span class="required">*</span>','dokter',array('class'=>'control-label required')) ?>
	<div class="controls">
		<?php echo $form->dropDownList($modTindakan,'dokterpemeriksa1_id', CHtml::listData($modTindakan->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pelaksana 1 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
		<?php echo $form->error($modTindakan, 'dokterpemeriksa1_id'); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label('Dokter Pelaksana 2','dokter',array('class'=>'control-label')) ?>
	<div class="controls">
		<?php echo $form->dropDownList($modTindakan,'dokterpemeriksa2_id', CHtml::listData($modTindakan->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pelaksana 2 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
		<?php echo $form->error($modTindakan, 'dokterpemeriksa2_id'); ?>
	</div>
</div>

<?php echo $form->dropDownListRow($modTindakan,'dokteranastesi_id', CHtml::listData($modTindakan->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modTindakan,'dokterpendamping_id', CHtml::listData($modTindakan->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modTindakan,'suster_id', CHtml::listData($modTindakan->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modTindakan,'bidan_id', CHtml::listData($modTindakan->getBidanItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php // echo $form->dropDownListRow($modTindakan,'statusoperasi', LookupM::getItems('statusoperasi'), array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','disabled'=>true )); ?>   
<?php echo $form->textAreaRow($modTindakan,'keterangantindakan',array('class'=>'span3')) ?>