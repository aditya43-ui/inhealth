<?php
$konfigFarmasi = KonfigfarmasiK::model()->find();
$isCekPenjaminOa = false;
if ($konfigFarmasi->ishargaperpenjamin == true) {
	$isCekPenjaminOa = true;
}

if (isset($_GET['reseptur_id'])) {
?>
	<?php echo CHtml::errorSummary($modResepturDetail); ?>
	<tr>
		<?php //print_r($modResepturDetail);exit(); 
		?>
		<td>
			<span id="isi-r" name="[ii][isi_r]">R/</span>
		</td>
		<td>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]rke', array('class'=>'rke', 'readonly' => true, 'style' => 'width:50px;')); ?>
			<span name="[ii][resep_ke]" class="resep_ke"><?php echo $modResepturDetail->rke ?></span>
		</td>
		<td>
			<span name="[ii][obatalkes_kode]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_kode : "") ?></span> /<br>
			<?php //if($modResepturDetail->obatalkes_id == 7862){?>
				<!-- <span name="[ii][obatalkes_nama]"><?php //echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_nama."(".$modResepturDetail->obatalkes_nama.")" : "") ?></span> -->
			<?php //}else{?>
				<span name="[ii][obatalkes_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_nama : "") ?></span>
			<?php //}?>
		</td>
		<td hidden>
			<?php //echo CHtml::activeTextArea($modResepturDetail, '[ii]obatalkes_nama', array('class' => 'obatalkes span3')); ?>
			<!-- <span name="[ii][obatalkes_nama]"><?php //echo (!empty($modResepturDetail->obatalkes_nama) ? $modResepturDetail->obatalkes_nama : "") ?></span> -->
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]obatlain_nama', array('readonly' => false, 'style' => 'width:110px;')); ?>
		</td>
		<td hidden>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		</td>
		<td hidden>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php
				if($modResepturDetail->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
					echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahpermintaan_obatnonracikan', array('readonly' => true, 'style' => 'width:50px;')); 
				} else {
					echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahpermintaan_obatracikan', array('readonly' => true, 'style' => 'width:50px;'));
				}
			?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]satuansediaan', array('readonly' => true, 'style' => 'width:50px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]iter', array('readonly' => true, 'style' => 'width:50px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]permintaan_temp', array('readonly' => false, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaan_reseptur', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'span2')); ?>
			<?php echo " " . $modResepturDetail->satuankekuatan; ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargasatuan_reseptur', array('readonly' => true, 'class' => 'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]penjualanresep_id', array('readonly' => true, 'class' => 'span2 penjualanresep_id')); //,'onblur'=>'hitungSubTotal(this)'
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]is_obatkronis',array('class'=>'')); ?>
			
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_pembilang', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_penyebut', array('readonly' => true, 'style' => 'width:110px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur', array('class' => 'qty ' . ((empty($isRacikan) || $isRacikan == 0) ? "" : ""), 'readonly' => false, 'style' => 'width:50px; text-align: right', 'onblur' => 'hitungTotal()')); //,'onblur'=>'hitungSubTotal(this)'
			?>
			<?php echo " " . $modResepturDetail->obatalkes->satuankecil->satuankecil_nama; ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur', array('readonly' => true, 'class' => 'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'
			?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur', array('readonly' => true, 'class' => 'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]totalbiayaadministrasi', array('readonly' => true, 'class' => 'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'
			?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]persdiskon', array('readonly' => true, 'class' => 'span1 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahdiskon', array('readonly' => true, 'class' => 'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]persenppnjual', array('readonly' => true, 'class' => 'span1 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'
			?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahppn', array('readonly' => true, 'class' => 'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'
			?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur', array('readonly' => true, 'class' => 'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok', array('readonly' => true, 'style' => 'width:50px;')); ?>
		</td>
		<td>
			<?php //echo CHtml::activeDropDownList($modResepturDetail, '[ii]signa_reseptur', LookupM::getItems('signa_oa'),array('empty'=>'-- Pilih --','class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); 
			?>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]signa_reseptur', array('class'=>'signa_reseptur','readonly' => false, 'style' => 'width:100px;')); ?>
		</td>
		<td>
			<?php // echo CHtml::activeDropDownList($modResepturDetail, '[ii]etiket', LookupM::getItems('etiket'),array('class'=>'span2')); 
			?>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]etiket', array('readonly' => false, 'style' => 'width:180px;', 'class' => 'span4 etiket')); ?>

		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlkemasan_reseptur', array('readonly' => true, 'style' => 'width:110px;')); ?>
		</td>
		
		
		<td>
			<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]resepturketerangan', array('class' => 'keterangan span3')); ?>
		</td>
		<td>
			<center>
				<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-remove"></i></a>
			</center>
		</td>
	</tr>

<?php } else { ?>
	<tr>
		<?php //print_r($modResepturDetail); exit(); 
		?>
		<td>
			<?php echo CHtml::hiddenField('no_urut', 0, array('readonly' => true, 'class' => 'span1 integer2', 'style' => 'width:20px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]r', array('class' => 'r', 'readonly' => true, 'style' => 'width:20px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]penjualanresep_id', array('readonly' => true, 'class' => 'span2 penjualanresep_id')); //,'onblur'=>'hitungSubTotal(this)'
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]rke', array('readonly' => true, 'class' => 'rke', 'style' => 'width:50px;')); ?>
			<span id="isi-r" name="[ii][isi_r]">R/</span>
		</td>
		<td>
			<span name="resep_ke" class="resep_ke"><?php echo $modResepturDetail->rke ?></span>
		</td>
		<?php
		if (isset($paketobat)) {?>
			<td>
				<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
				<span name="[ii][obatalkes_kode]" class="obatalkes_kode"><?php echo $modResepturDetail->obatalkes_kode ?></span> /<br>
				<span name="[ii][obatalkes_nama]" class="obatalkes_nama"><?php echo $modResepturDetail->obatalkes_nama ?></span>

			</td>
			<?php if(!empty($modResepturDetail->obatlain_nama)){?>
				<td hidden>
					<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]obatlain_nama', array('class' => 'obatalkes span3')); ?>
				</td>
			<?php }else{?>
				<td hidden>
					<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]obatlain_nama', array('readonly' => true, 'class' => 'obatalkes span3')); ?>
				</td>
			<?php }?>
		<?php } else { ?>
			<td>
				
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]therapiobat_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<span name="[ii][obatalkes_kode]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->obatalkes_kode : "") ?></span> /<br>
			
			<span name="[ii][obatalkes_nama]">
				<?php echo $modResepturDetail->obatalkes->obatalkes_nama ?>
			</span>
			
			<span name="[ii][therapiobat_nama]" class="hide"><?php echo $modResepturDetail->therapiobat_nama ?></span>

			</td>
			<?php if(!empty($modResepturDetail->obatlain_nama)){?>
				<td hidden>
					<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]obatlain_nama', array('class' => 'obatalkes span3')); ?>
				</td>
			<?php }else{?>
				<td hidden>
					<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]obatlain_nama', array('readonly' => true, 'class' => 'obatalkes span3')); ?>
				</td>
			<?php }?>
		<?php } ?>
		<td hidden>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]sumberdana_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		</td>
		<td hidden>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahpermintaan_obatracikan', array('readonly' => true, 'style' => 'width:50px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]satuansediaan', array('readonly' => true, 'style' => 'width:50px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]iter', array('readonly' => true, 'style' => 'width:50px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]permintaan_temp', array('readonly' => false, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaan_reseptur', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]kekuatan_reseptur', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]harganetto_reseptur', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankecil_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankekuatan', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]racikan_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]tglkadaluarsa', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargasatuan_reseptur', array('readonly' => true, 'class' => 'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]st_fornas', array('readonly' => true, 'class' => 'span2'));
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]is_permitaandosispecahan', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_pembilang', array('readonly' => true, 'style' => 'width:110px;')); ?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_penyebut', array('readonly' => true, 'style' => 'width:110px;')); ?>
				<span class="satuankekuatan" name="[ii][satuan]">
					<?php if (!isset($salin)) {
						echo " " . $modResepturDetail->satuankekuatan;
					} ?>
				</span>
		</td>
		<td>
			<?php
			echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur', array('class' => 'qty ' . ((empty($isRacikan) || $isRacikan == 0) ? "integer2" : ""), 'readonly' => false, 'style' => 'width:50px; text-align: right;', 'onblur' => 'hitungTotal()')); //,'onblur'=>'hitungSubTotal(this)'
			echo " " . (!empty($paketobat) &&  $paketobat == true ? $satuan_nama : $modResepturDetail->satuankecil->satuankecil_nama);
			?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]biayaadministrasi', array('readonly' => $isCekPenjaminOa, 'class' => 'span2 integer-decimal', 'onblur' => 'hitungTotal()')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]totalbiayaadministrasi', array('readonly' => true, 'class' => 'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]persdiskon', array('class' => 'span1 integer-decimal', 'onblur' => 'hitungTotal()')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahdiskon', array('class' => 'span2 integer-decimal', 'onblur' => 'hitungPersenDiskon()')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]persenppnjual', array('readonly' => true, 'class' => 'span1 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahppn', array('readonly' => true, 'class' => 'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur', array('readonly' => true, 'class' => 'span2 integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'
			?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargajual_reseptur', array('readonly' => true, 'class' => 'span2 integer-decimal')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok', array('readonly' => true, 'style' => 'width:50px;')); ?>
		</td>

		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]signa_reseptur', array('class'=>'signa_reseptur','readonly' => false, 'style' => 'width:100px;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]etiket', array('readonly' => false, 'style' => 'width:180px;', 'class' => 'span4 etiket')); ?>
		</td>
		<td hidden>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlkemasan_reseptur', array('readonly' => true, 'style' => 'width:110px;')); ?>
		</td>
		
		
		<td>
			<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]resepturketerangan', array('class' => 'keterangan span3')); ?>
		</td>
		<td>
			<center>
				<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);"><i class="icon-remove"></i></a>
			</center>
		</td>
	</tr>
<?php } ?>