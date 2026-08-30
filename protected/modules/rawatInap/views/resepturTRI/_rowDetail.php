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
		<td hidden>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		</td>
		<td hidden>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur',array('class'=>'qty '.((empty($isRacikan) || $isRacikan == 0) ? "integer2" : ""),'readonly'=>(!empty($isRacikan) && $isRacikan != 0), 'style'=>'width:50px; text-align: right;','onblur'=>'hitungTotal()')); //,'onblur'=>'hitungSubTotal(this)'?>
                        <?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur',array('readonly'=>true, 'class'=>'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]persenppnjual',array('readonly'=>true, 'class'=>'span1 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahppn',array('readonly'=>true, 'class'=>'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true, 'class'=>'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]signa_reseptur', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span2', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</td>
		<td>
			<?php
//                        echo CHtml::activeDropDownList($modResepturDetail, '[ii]etiket', LookupM::getItems('etiket'),array('class'=>'span2'));
                            echo CHtml::activeTextField($modResepturDetail, '[ii]etiket',array('readonly'=>true,'style'=>'width:180px;'));
                        ?>
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
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]rke',array('class'=>'rke','readonly'=>true,'style'=>'width:20px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]therapiobat_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<span name="[ii][obatalkes_kode]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_kode : "") ?></span>/<br>
			<span name="[ii][obatalkes_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_nama : "") ?></span>

		</td>
		<td hidden>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		</td>
		<td hidden>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur',array('class'=>'qty '.((empty($isRacikan) || $isRacikan == 0) ? "integer2" : ""),'readonly'=>(!empty($isRacikan) && $isRacikan != 0), 'style'=>'width:50px; text-align: right;','onblur'=>'hitungTotal()')); //,'onblur'=>'hitungSubTotal(this)'?>
                        <?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?>
		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]kekuatan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]jmlkemasan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]harganetto_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankecil_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankekuatan',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]racikan_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur',array('readonly'=>true, 'class'=>'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]persenppnjual',array('readonly'=>true, 'class'=>'span1 integer-decimal')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahppn',array('readonly'=>true, 'class'=>'span2 integer-decimal')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur',array('readonly'=>true, 'class'=>'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]signa_reseptur',array('readonly'=>true, 'class'=>'inputFormTabel span2')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]etiket',array('readonly'=>true,'style'=>'width:180px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]satuansediaan',array('readonly'=>true,'style'=>'width:50px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]iter',array('readonly'=>true,'style'=>'width:50px;')); ?>
		</td>
		<td>
			<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
	</tr>
<?php } ?>
