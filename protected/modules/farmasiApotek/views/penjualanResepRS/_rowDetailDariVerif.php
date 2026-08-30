<?php

$satuan = !empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "";
$rclass = 'nonracikan';

// $modResepturDetail->hargasatuan_reseptur = number_format($modResepturDetail->hargasatuan_reseptur, 2, ",", ".");

// var_dump($modResepturDetail->attributes); die;

if ($modResepturDetail->racikan_id == 1) {
	// $modResepturDetail->qty_reseptur = number_format($modResepturDetail->qty_reseptur, 2, ",", "");
	$rclass = 'racikan';
}


// var_dump($modResepturDetail->attributes); die;

?>
<tr row-data="0">
	<td>
		<span id="isi-r" name="[ii][isi_r]">R/</span>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']rke', array('readonly' => true, 'style' => 'width:20px;')); ?>
	</td>
	<td>
		<span name="[ii][obatalkes_kode]" class="kodeobat"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->kodeobat_inventory : "") ?></span> /<br>
		<span name="[ii][obatalkes_nama_label]" class="namaobat"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->obatalkes_nama."(".$modResepturDetail->obatlain_nama.")" : "") ?></span>
	</td>
	<td><?php echo $modResepturDetail->sumberdana->sumberdana_nama ?? '-' ?></td>
	<td>
		<?php 
			echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']jmlstok',array('class'=>'stok span1','readonly'=>true,'style'=>'text-align: right;','onblur'=>'hitungSubTotal(this);'));
		?>
	</td>
	<td nowrap hidden>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']jml_min', array('class' => 'jml_min', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']jml_max', array('class' => 'jml_max', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		
		<?php echo $satuan; ?>


		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']tglkadaluarsa', array('readonly' => true, 'class' => 'tglkadaluarsa')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']tglkadalprev', array('readonly' => true, 'class' => 'tglkadalprev')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']obatalkes_id', array('readonly' => true, 'class' => 'required obatalkes_id')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']subjenis_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']subjenis_nama', array('readonly' => true, 'style' => 'width:110px;')); ?>
	
		<?php
		$disable = true;
		if ($modPendaftaran->carabayar_id != Params::CARABAYAR_ID_MEMBAYAR) {
			if ($modResepturDetail->is_obatkronis == true) {
				$disable = false;
			}
		?>
			<?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS): ?> 
			<div class="row-kronis">
				</br>
				<?php echo Chtml::activeCheckBox($modResepturDetail, '[' . $ii .']is_obatkronis', array('uncheckValue' => null, 'onclick' => 'ceklist(this)', 'class' => 'is_obatkronis username', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?> <label>Obat Kronis</label>
				<?php echo CHtml::activeDropDownList($modResepturDetail, '[' . $ii .']formulaobatkronis_id', FormulaobatkronisM::getDropdown(), array('class' => 'span2 formulaobatkronis_id username', 'empty' => '-- Pilih --', 'readonly' => $disable, 'disabled' => $disable, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
			</div>
			<?php endif; ?>
			<?php
			echo CHtml::checkBox('FAResepturDetailT[' . $ii .'][is_tanggungan_pasien]', array('value' => 1), array(
				'template' => '<div class="radio-inline">{input}{label} </div>',
				'uncheckValue' => null,
				'checked' => false,
				'nilai' => 1,
				'onclick' => 'cek_tanggungan(this)',
				'class' => 'is_tanggungan_radio is_tanggungan_pasien'
			)) . "<label> Ditanggung Pasien </label>";
			echo CHtml::hiddenField('FAResepturDetailT[' . $ii .'][formulariumobat_id]', $modResepturDetail->formulariumobat_id, ['class' => 'formulariumobat_id', 'disabled' => $disable, 'onkeyup' => "return $(this).focusNextInputField(event)"]);
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii .']is_tanggungan', array('class' => 'is_tanggungan span1 username', 'readonly' => true, 'style' => 'text-align: right;')); 
			?>
		<?php } ?>
	</td>
	<td nowrap>
		<?php 
			if($modResepturDetail->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
				echo CHtml::activeTelField($modResepturDetail, '[' . $ii .']jumlahpermintaan_obatnonracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
			} else {
				echo CHtml::activeTelField($modResepturDetail, '[' . $ii .']jumlahpermintaan_obatracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
			}
		?>
	</td>
	<?php
	if (!empty($modResepturDetail->satuansediaan)) { ?>
		<td>
			<?php if($modResepturDetail->racikan_id == Params::RACIKAN_ID_RACIKAN):?>
				<?php echo CHtml::activeDropDownList($modResepturDetail, '[' . $ii .']satuansediaan', LookupM::getItems('sediaanobatracikan'), array('readonly' => false, 'class' => 'span2', 'empty' => '-- Pilih --')); ?>
			<?php endif; ?>
		</td>
	<?php } else { ?>
		<td>
			<span name="[ii][satuansediaan]"> - </span>
		</td>
	<?php } ?>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']permintaan_dosis', array('readonly' => false, 'style' => 'width:50px; text-align: right;', 'onblur' => 'hitungTotal(this)')); ?>
	</td>
	<td nowrap>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']qty_reseptur', array('readonly' => false, 'style' => 'width:50px; text-align: right;', 'onblur' => 'hitungTotal(this)')); //,'onblur'=>'hitungSubTotal(this)'
		?>
                <span class="nama-satuan"><?php echo $satuan; ?></span>
	</td>
	<td hidden>
		<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']sumberdana_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']satuankecil_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[' . $ii . ']resepturdetail_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
	</td>
	
	<?php if ($modResepturDetail->racikan_id == 2) {
		?>
	<td>
		<?php echo CHtml::activeTextField($modReseptur, '[' . $ii . ']administrasi', array('readonly' => true, 'style' => 'width:80px;', 'class' => 'integer-decimal')); ?>
	</td>
	<?php } else { ?>
		<td>
			-
		</td>
	<?php } ?>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']hargasatuan_reseptur', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'hargasatuan_reseptur integer-decimal')); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']total_embalase', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']biayaadministrasi', array('style' => 'width:120px;', 'class' => 'integer-decimal', 'onblur' => 'hitungTotal();')); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']totalbiayaadministrasi', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']persen_discount', array('style' => 'width:50px;', 'class' => 'integer-decimal', 'onblur' => 'hitungTotal();')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']discount', array('style' => 'width:110px;', 'class' => 'integer-decimal', 'onblur' => 'hitungPersenDiskon();')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']ppnpersen', array('readonly' => true, 'style' => 'width:50px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']jumlahppn', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']subtotal', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal')); ?>
	</td>

	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']signa_reseptur', array('readonly' => false, 'class' => 'inputFormTabel span3', 'style' => 'width:100px;', 'onkeypress' => "return $(this).focusNextInputField(event)","onblur"=>'setRiwayat(this);')); ?>

	</td>
	<td nowrap>
		<?php

		$etiket = explode(" - ", $modResepturDetail->etiket);

		echo CHtml::activeDropDownList($modResepturDetail, '[' . $ii . ']ket_penggunaan', LookupM::getItems('etiket'), array('readonly' => false, 'class' => 'span2 ket_penggunaan',"onchange"=>'setRiwayat(this);')); ?>
		<br>
		<?php echo CHtml::activeTextField($modResepturDetail, '[' . $ii . ']etiket', array('readonly' => false, 'style' => 'width:180px;', 'class' => 'span4')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[' . $ii . '][etiket][0]', empty($etiket[0]) ? "" : $etiket[0], LookupM::getItems('signa_oa'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[' . $ii . '][etiket][1]', empty($etiket[1]) ? "" : $etiket[1], LookupM::getItems('etiket_1'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[' . $ii . '][etiket][2]', empty($etiket[2]) ? "" : $etiket[2], LookupM::getItems('etiket_2'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php ////echo CHtml::dropDownList(get_class($modResepturDetail).'[' . $ii . '][etiket][3]', empty($etiket[3]) ? "" : $etiket[3], LookupM::getItems('etiket_4'), array('style' => 'width:100px; display: none;', 'data-toggle'=>'tooltip', 'title'=>'Cara Penggunaan Obat')); 
		?>

	</td>
	<td>
		<?php echo CHtml::activeTextArea($modResepturDetail, '[' . $ii . ']resepturketerangan', array('class' => 'keterangan span3')); ?>
	</td>
	<td>
		<?php
			$this->widget('MyDateTimePicker', array(
				'model' => $modResepturDetail,
				'attribute' => '[' . $ii . ']kadaluarsa',
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