<?php if(isset($_GET['reseptur_id'])){ ?>
	
	<tr>
		<?php //print_r($modResepturDetail);exit(); ?>
		<td>
			<span id="isi-r" name="[ii][isi_r]">R/</span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
		</td>
		<td>
			<span name="[ii][obatalkes_kode]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_kode : "") ?></span>/<br>
			<span name="[ii][obatalkes_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_nama : "") ?></span>

		</td>
		<td>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		</td>
		<td>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur',array('readonly'=>true,'style'=>'width:50px;')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer')); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]signa_reseptur', LookupM::getItems('signa_oa'),array('readonly'=>true,'class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]etiket', LookupM::getItems('etiket'),array('class'=>'span2')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]iter',array('readonly'=>true,'style'=>'width:50px;')); ?>
		</td>
		<td>
			<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
	</tr>

<?php }else{ ?>
	<tr>
		<?php //print_r($modResepturDetail);exit(); ?>
		<td>
			<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]r',array('readonly'=>true,'style'=>'width:20px;')); ?>
			<span id="isi-r" name="[ii][isi_r]">R/</span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]therapiobat_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<span name="[ii][obatalkes_kode]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_kode : "") ?></span>/<br>
			<span name="[ii][obatalkes_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_nama : "") ?></span>

		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		</td>
		<td>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur',array('readonly'=>true,'style'=>'width:50px;')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]kekuatan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]jmlkemasan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]harganetto_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankecil_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankekuatan',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]racikan_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuansediaan',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer')); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]signa_reseptur', LookupM::getItems('signa_oa'),array('readonly'=>true,'class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]etiket', LookupM::getItems('etiket'),array('class'=>'span2')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]iter',array('readonly'=>true,'style'=>'width:50px;')); ?>
		</td>
		<td>
			<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
	</tr>
<?php } ?>
