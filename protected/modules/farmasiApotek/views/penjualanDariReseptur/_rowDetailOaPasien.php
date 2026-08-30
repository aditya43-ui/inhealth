<?php

$satuan = !empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "";
// var_dump("Kicker", $modObatAlkesPasien->subtotal); die;
$racikan_id = !empty($modObatAlkesPasien->racikan_id) ? $modObatAlkesPasien->racikan->racikan_nama : 0;
?>
<tr>
	<td></td>
	<td>  
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]is_verifikasiapoteker', array('readonly' => true, 'style' => 'width:90px;border:none')); ?>
		<?php 
			$status = '';
			if($modObatAlkesPasien->is_verifikasiapoteker == '1') {
				$status = 'DI SETUJUI';
			} else if($modObatAlkesPasien->is_verifikasiapoteker == '0') {
				$status = 'TIDAK DISETUJUI';
			} else if($modObatAlkesPasien->is_verifikasiapoteker == 'null') {
				$status = 'BATAL VERIFIKASI';
			}
		?>
		<?php echo CHtml::TextField('status', $status, array('readonly' => true, 'style' => 'width:100px;border:none;', 'id' => '', 'class' => 'statusVerifikasi')); ?>
	</td>
	<td>
		<div class="dropdown">
			<button class="dropbtn" type="button">Opsi <i class="fa fa-arrow-right"></i></button>
			<div class="dropdown-content">
				<a href="javascript::" onclick="verifikasi(this, '1')"><i class="fa fa-check" style="color: green;"></i> Setujui</a>
				<a href="javascript::" onclick="verifikasi(this, '0')"><i class="fa fa-times" style="color: red;"></i> Tidak Disetujui</a>
				<?php if($modObatAlkesPasien->is_verifikasiapoteker == '1' || $modObatAlkesPasien->is_verifikasiapoteker == '0') : ?>
					<a href="javascript::" onclick="verifikasi(this, 'null')"><i class="fa fa-times" style="color: orange;"></i> Batal Verifikasi</a>
				<?php endif; ?>
			</div>
		</div>
	</td>
	<td>
		<span id="isi-r" name="[ii][isi_r]">R/</span>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]rke', array('readonly' => true, 'style' => 'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]satuankekuatan', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]satuansediaan', array('readonly' => true, 'style' => 'width:110px;')); ?>

	</td>
	<td>
		<span name="[ii][racikan_nama]"><?php echo (!empty($modObatAlkesPasien->racikan_id) ? $modObatAlkesPasien->racikan->racikan_nama : "") ?></span>
	</td>
	<td>
		<?php if (isset($modDetailReseptur[$iii])) { ?>
			<span name="[ii][obatalkes_kode]" class="kodeobat"><?php echo (!empty($modObatAlkesPasien->obatalkes_id) ? $modObatAlkesPasien->obatalkes->kodeobat_inventory : "") ?></span> /<br>
			<span name="[ii][obatalkes_nama_label]" class="namaobat"><?php echo (!empty($modDetailReseptur[$iii]->obatalkes_id) ? $modDetailReseptur[$iii]->obatalkes_nama." (".$modDetailReseptur[$iii]->obatlain_nama.") " : "") ?></span>
		<?php } else { ?>
			<span name="[ii][obatalkes_kode]"> - </span> /<br>
			<span name="[ii][obatalkes_nama_label]"> - </span>
		<?php } ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]obatalkes_nama', array('readonly' => true, 'class' => 'span3', 'value' => $modDetailReseptur[$iii]->obatalkes_nama)); //,'onblur'=>'hitungSubTotal(this)'
		?>
		<?php
		if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) { ?>
			</br>
			<?php echo Chtml::activeCheckBox($modObatAlkesPasien, '[ii]is_obatkronis', array('uncheckValue' => null, 'onclick' => 'ceklist(this)', 'class' => 'is_obatkronis', 'disabled' => true)) ?> <label>Obat Kronis</label>
			<?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]formulaobatkronis_id', FormulaobatkronisM::getDropdown(), array('class' => 'span2 formulaobatkronis_id', 'empty' => '-- Pilih --', 'readonly' => true, 'disabled' => true)); ?>
		<?php } ?>
	</td>
	<td>
		<?= $modObatAlkesPasien->sumberdana_nama ?? '' ?>
	</td>
	<td nowrap>
		<?php 
		
		if($modObatAlkesPasien->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
			echo CHtml::activeTelField($modObatAlkesPasien, '[ii]jumlahpermintaan_obatnonracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
		} else {
			echo CHtml::activeTelField($modObatAlkesPasien, '[ii]jumlahpermintaan_obatracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
		}
		?>
	</td>
	<td nowrap>
		<?php
		if (isset($modDetailReseptur[$iii])) {
			echo CHtml::activeTextField($modDetailReseptur[$iii], '[ii]qty_reseptur', array('readonly' => true, 'style' => 'width:50px; text-align: right;')); //,'onblur'=>'hitungSubTotal(this)'
		} else { ?>
			<span name="[ii][obatalkes_kode]"> - </span>
		<?php } ?>
		<?php echo $satuan; ?>
	</td>
	<td nowrap>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]qty_dilayani', array('class' => 'qty', 'readonly' => false, 'style' => 'width:50px; text-align: right;', 'value' => $modObatAlkesPasien->qty_oa, 'onblur' => 'hitungSubTotal(this);')); ?>
		<?php echo $satuan; ?>
	</td>
	<td hidden>
		<span name="[ii][sumberdana_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
	</td>
	<!--td>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td-->
	<td>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargasatuan_oa', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]total_embalase', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]persen_discount', array('readonly' => true, 'style' => 'width:50px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]discount', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]persenppnjual', array('readonly' => true, 'style' => 'width:50px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]jumlahppn', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]subtotal', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal', 'value' => $modObatAlkesPasien->hargajual_oa)); ?>
	</td>

	<td>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]signa_oa', array('readonly' => false, 'class' => 'inputFormTabel span3', 'style' => 'width:100px;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
	</td>
	<td nowrap>
		<?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]ket_penggunaan', LookupM::getItems('etiket'), array('readonly' => true, 'class' => 'span2')); ?>
		<br>
		<br>
		<?php $etiket = explode(" - ", $modObatAlkesPasien->etiket); ?>
		<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]etiket', array('readonly' => false, 'style' => 'width:180px;', 'class' => 'span4')); ?>
		<?php //echo CHtml::dropDownList(get_class($modObatAlkesPasien) . '[ii][etiket][0]', empty($etiket[0]) ? "" : $etiket[0], LookupM::getItems('signa_oa'), array('style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
		<?php //echo CHtml::dropDownList(get_class($modObatAlkesPasien) . '[ii][etiket][1]', empty($etiket[1]) ? "" : $etiket[1], LookupM::getItems('etiket_1'), array('style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
		<?php //echo CHtml::dropDownList(get_class($modObatAlkesPasien) . '[ii][etiket][2]', empty($etiket[2]) ? "" : $etiket[2], LookupM::getItems('etiket_2'), array('style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat')); ?>
		<?php //echo CHtml::dropDownList(get_class($modObatAlkesPasien).'[ii][etiket][3]', empty($etiket[3]) ? "" : $etiket[3], LookupM::getItems('etiket_4'), array('style' => 'width:100px;display:none;', 'data-toggle'=>'tooltip', 'title'=>'Cara Penggunaan Obat')); 
		?>
	</td>
	<td>
		<?php
		$therapi = TherapiobatM::model()->findAll('therapiobat_aktif = true order by therapiobat_nama');
		$tlist = CHtml::listData($therapi, 'therapiobat_id', 'therapiobat_nama');

		echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]therapiobat_id', $tlist, array('empty' => '-- Pilih --')) ?>
	</td>
	<td>
		<?php echo CHtml::activeTextArea($modObatAlkesPasien, '[ii]keterangan', array('class' => 'keterangan span3')); ?>
	</td>
	<td>
	<?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modObatAlkesPasien,
                    'attribute' => '[ii]kadaluarsa',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3 exp_date', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
	</td>
	<td>
		<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-remove"></i></a>
	</td>
</tr>