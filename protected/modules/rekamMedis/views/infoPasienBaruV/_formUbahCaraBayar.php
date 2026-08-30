<div id="formubahcarabayar">
	<table>
		<tr>
			<td><?php echo CHtml::Label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?></td>
			<td>: 
				<?php echo $modPendaftaran->no_pendaftaran;?>
				<?php echo CHtml::activeHiddenField($model, 'pendaftaran_id',array('readonly'=>true))?>
			</td>
		</tr>
		<tr>
			<td><?php echo CHtml::Label('Tgl. Pendaftaran','tgl_pendaftaran', array('class'=>'control-label')) ?></td>
			<td>: 
				<?php echo $modPendaftaran->tgl_pendaftaran;?>
				<?php echo CHtml::activeHiddenField($model, 'tglubahcarabayar',array('value'=>date('d/m/Y H:i:s'),'readonly'=>true))?>
			</td>
		</tr>
		<tr>
			<td><?php echo CHtml::Label('Jenis Penjamin Asal','carabayar_id', array('class'=>'control-label')) ?></td>
			<td>: 
				<?php echo $modPendaftaran->carabayar->carabayar_nama;?>
				<?php echo CHtml::activeHiddenField($model, 'carabayar_id',array('readonly'=>true))?>
			</td>
		</tr>
		<tr>
			<td><?php echo CHtml::Label('Penjamin Asal','penjamin_id', array('class'=>'control-label')) ?></td>
			<td>: 
				<?php echo $modPendaftaran->penjamin->penjamin_nama;?>
				<?php echo CHtml::activeHiddenField($model, 'penjamin_id',array('readonly'=>true))?>
			</td>
		</tr>
		<tr>
			<td><?php echo CHtml::Label('Jenis Penjamin <span class="required">*</span>','carabayar_id', array('class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeDropDownList($modPendaftaran,'carabayar_id',CHtml::listData(RKCarabayarM::getItems(), 'carabayar_id', 'carabayar_nama'),array('class'=>'span3 required', 'onchange'=>'setDropdownPenjamin(this.value);','onkeyup'=>"return $(this).focusNextInputField(event);")); ?> </td>
		</tr>
		<tr>
			<td><?php echo CHtml::Label('Penjamin <span class="required">*</span>','penjamin_id', array('class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeDropDownList($modPendaftaran,'penjamin_id',CHtml::listData(RKPenjaminpasienM::getItems($modPendaftaran->carabayar_id), 'penjamin_id', 'penjamin_nama'),array('class'=>'span3 required', 'onchange'=>'setFormAsuransiPasien();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?></td>
		</tr>
		<tr>
			<td><?php echo CHtml::activeLabel($model,'alasanperubahan', array('label'=>'Alasan Perubahan <span class="required">*</span>','class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeTextArea($model,'alasanperubahan',array('class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></td>
		</tr>
</table>
<div id="formasuransipasien">
<!--Di-load via ajax-->

</div>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'ubahCaraBayar('.$modPendaftaran->pendaftaran_id.',1)')); ?>
</div>
