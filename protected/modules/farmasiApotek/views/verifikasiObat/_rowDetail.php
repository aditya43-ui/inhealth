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
	<td style="text-align: center;">
		<?php
		if ($modResepturDetail->racikan_id == Params::RACIKAN_ID_RACIKAN) {
			echo CHtml::link('<i class="icon-form-plus"></i>', 'javascript:void(0);', array('onclick' => 'tambahObatalkesRacikan(this,0);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah Obat Alkes dengan R = ' . $modResepturDetail->rke));
		}
		?>
	</td>
	<td style="text-align: center;">
		<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini" hidden><i class="icon-form-silang"></i></a>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]resepturdetail_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]racikan_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php // echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargasatuan_reseptur',array('class' =>'hargasatuan_reseptur','readonly'=>true,'style'=>'width:110px;')); 
		?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]harganetto_reseptur', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargajual_reseptur', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]stokobatalkes_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]st_fornas', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankekuatan', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuansediaan', array('readonly' => true, 'style' => 'width:110px;')); ?>

	</td>
	<td>  
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]is_verifkasiapoteker', array('readonly' => true, 'style' => 'width:90px;border:none')); ?>
		<?php 
			$status = '';
			if($modResepturDetail->is_verifkasiapoteker == '1') {
				$status = 'DI SETUJUI';
			} else if($modResepturDetail->is_verifkasiapoteker == '0') {
				$status = 'TIDAK DISETUJUI';
			} else if($modResepturDetail->is_verifkasiapoteker == 'null') {
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
				<?php if($modResepturDetail->is_verifkasiapoteker == '1' || $modResepturDetail->is_verifkasiapoteker == '0') : ?>
					<a href="javascript::" onclick="verifikasi(this, 'null')"><i class="fa fa-times" style="color: orange;"></i> Batal Verifikasi</a>
				<?php endif; ?>
			</div>
		</div>
	</td>
	<td>
		<span id="isi-r" name="[ii][isi_r]">R/</span>
	</td>
	<td width="10%">
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]rke', array('readonly' => true, 'style' => 'width:20px;')); ?>
	</td>
	<td>
		<span name="[ii][racikan_nama]"><?php echo (!empty($modResepturDetail->racikan_id) ? $modResepturDetail->racikan->racikan_nama : "") ?></span>
	</td>
	<td>
		<span name="[ii][obatalkes_kode]"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->kodeobat_inventory : "") ?></span> /<br>
		<span name="[ii][obatalkes_nama_label]" class="namaobat"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->obatalkes_nama."(".$modResepturDetail->obatlain_nama.")" : "") ?></span>
	</td>
	<td>
		<span name="[ii][jenisobat]"><?= $modResepturDetail->sumberdana->sumberdana_nama ?? '' ?></span>
	</td>
	<td nowrap hidden>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]jml_min', array('class' => 'jml_min', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		<?php //echo CHtml::activeHiddenField($modResepturDetail, '[ii]is_permitaandosispecahan', array('class' => 'is_permintaadosispecahan', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); 
		?>
		<?php //echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_penyebut', array('class' => 'permintaandosis_penyebut', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); 
		?>
		<?php //echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_pembilang', array('class' => 'permintaandosis_pembilang', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); 
		?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]jml_max', array('class' => 'jml_max', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		<?php //echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok',array('class'=>'stok span1','readonly'=>true,'style'=>'text-align: right;','onblur'=>'hitungSubTotal(this);')); 
		?>
		<?php echo $satuan; ?>
	</td>
	<td>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]tglkadaluarsa', array('readonly' => true, 'class' => 'tglkadaluarsa')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]tglkadalprev', array('readonly' => true, 'class' => 'tglkadalprev')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id', array('readonly' => true, 'class' => 'required obatalkes_id')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]subjenis_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]subjenis_nama', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php $this->widget('MyJuiAutoComplete', array(
			'model' => $modResepturDetail,
			'attribute' => '[ii]obatalkes_nama_api',
			'tombolDialog' => array('idDialog' => 'dialogOaAPI', 'jsFunction' => "setDialogOAApi(this,0);"),
			'htmlOptions' => array('placeholder' => 'Ketik nama obat alkes', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3','value' => $modResepturDetail->ObatAlkesNama),
		)); ?>
		<?php //CHtml::activeTextField($modResepturDetail, '[ii]obatalkes_nama_api', ['value' => $modResepturDetail->ObatAlkesNama, 'readonly' => true])?>
	
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
				<?php echo Chtml::activeCheckBox($modResepturDetail, '[ii]is_obatkronis', array('uncheckValue' => null, 'onclick' => 'ceklist(this)', 'class' => 'is_obatkronis username', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?> <label>Obat Kronis</label>
				<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]formulaobatkronis_id', FormulaobatkronisM::getDropdown(), array('class' => 'span2 formulaobatkronis_id username', 'empty' => '-- Pilih --', 'readonly' => $disable, 'disabled' => $disable, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange'=>'setMinMax(this);')); ?>
			</div>
			<?php endif; ?>
			<?php
			echo CHtml::checkBox('FAResepturDetailT[ii][is_tanggungan_pasien]', array('value' => 1), array(
				'template' => '<div class="radio-inline">{input}{label} </div>',
				'uncheckValue' => null,
				'checked' => false,
				'nilai' => 1,
				'onclick' => 'cek_tanggungan(this)',
				'class' => 'is_tanggungan_radio is_tanggungan_pasien'
			)) . "<label> Ditanggung Pasien </label>";
			echo CHtml::hiddenField('FAResepturDetailT[ii][formulariumobat_id]', $modResepturDetail->formulariumobat_id, ['class' => 'formulariumobat_id', 'disabled' => $disable, 'onkeyup' => "return $(this).focusNextInputField(event)"]);
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]is_tanggungan', array('class' => 'is_tanggungan span1 username', 'readonly' => true, 'style' => 'text-align: right;')); 
			?>
		<?php } ?>
	</td>
	<td nowrap>
		<?php 
			if($modResepturDetail->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
				echo CHtml::activeTelField($modResepturDetail, '[ii]jumlahpermintaan_obatnonracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
			} else {
				echo CHtml::activeTelField($modResepturDetail, '[ii]jumlahpermintaan_obatracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
			}
		?>
	</td>
	<td>
		<?php 
			if (!empty($modResepturDetail->satuansediaan)) {
				if($modResepturDetail->racikan_id == Params::RACIKAN_ID_RACIKAN){
					echo CHtml::activeDropDownList($modResepturDetail, '[ii]satuansediaan', LookupM::getItems('sediaanobatracikan'), array('readonly' => false, 'class' => 'span2', 'empty' => '-- Pilih --'));
				}
			} else {
		?>
				<span name="[ii][satuansediaan]"> - </span>
		<?php } ?>
	</td>
	<td nowrap>
		<?php echo CHtml::activeTelField($modResepturDetail, '[ii]permintaan_reseptur', array('readonly' => false, 'style' => 'width:50px; text-align: right;', 'class' => ''));?>
		<?php echo $modResepturDetail->satuankekuatan;?>

	</td>
	<td nowrap>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok', array('class' => 'stok', 'readonly' => true, 'style' => 'width:50px; text-align: right;', 'onblur' => 'hitungSubTotal(this);')); ?>
		<?php echo $satuan; ?>
	</td>
	<td nowrap>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur', array('readonly' => false, 'style' => 'width:50px; text-align: right;')); //,'onblur'=>'hitungSubTotal(this)'
		?>
                <span class="nama-satuan"><?php echo $satuan; ?></span>
	</td>
	<?php if (!isset($takaranresep)) { ?>
		<td nowrap>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_dilayani', array('class' => 'qty span1' . $rclass, 'readonly' => false, 'style' => 'width:50px; text-align: right;', 'value' => $modResepturDetail->qty_reseptur, 2, ",", "", 'onblur' => 'hitungSubTotal(this); ceklist(this);setRiwayat(this);')); ?>
			<?php echo $satuan; ?>
		</td>
	<?php } else { ?>
		<td nowrap>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_dilayani', array('class' => 'qty span1' . $rclass, 'readonly' => false, 'style' => 'width:50px; text-align: right;', 'onblur' => 'hitungSubTotal(this); ceklist(this);setRiwayat(this);')); ?>
			<?php echo $satuan; ?>
		</td>
	<?php } ?>

	<td hidden>
		<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]sumberdana_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankecil_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
	</td>
	<!--td>
			<span name="[ii][satuankecil_nama]"><?php echo (!empty($modResepturDetail->obatalkes->satuankecil_id) ? $modResepturDetail->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
		</td>-->
		<?php if ($modResepturDetail->racikan_id == 2) {
			?>
		<td>
			<?php echo CHtml::activeTextField($modReseptur, '[ii]administrasi', array('readonly' => true, 'style' => 'width:80px;', 'class' => 'integer-decimal')); ?>
		</td>
		<?php } else { ?>
			<td>
				-
			</td>
		<?php } ?>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'hargasatuan_reseptur integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]total_embalase', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]biayaadministrasi', array('style' => 'width:120px;', 'class' => 'integer-decimal', 'onblur' => 'hitungTotal();')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]totalbiayaadministrasi', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]persen_discount', array('style' => 'width:50px;', 'class' => 'integer-decimal', 'onblur' => 'hitungTotal();')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]discount', array('style' => 'width:110px;', 'class' => 'integer-decimal', 'onblur' => 'hitungPersenDiskon();')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]ppnpersen', array('readonly' => true, 'style' => 'width:50px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jumlahppn', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]subtotal', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal subtotal')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]subtotal_kronis', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal subtotal_kronis')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]subtotal_inacbg', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal subtotal_inacbg')); ?>
	</td>

	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]signa_reseptur', array('readonly' => false, 'class' => 'inputFormTabel span3', 'style' => 'width:100px;', 'onkeypress' => "return $(this).focusNextInputField(event)","onblur"=>'setRiwayat(this);')); ?>
		<?php
		// $this->widget('MyJuiAutoComplete', array(
		// 	'name'=>'signa_reseptur',
		// 	'value'=>'',
		// 	'source'=>'js: function(request, response) {
		// 		$.ajax({
		// 		url: "'.$this->createUrl('getSignaFarmasi').'",
		// 		dataType: "json",
		// 		data: {
		// 			term: request.term,
		// 		},
		// 		success: function (data) {
		// 			response(data);
		// 		}
		// 		})
		// 	}',
		// 	'options'=>array(
		// 		'showAnim'=>'fold',
		// 		'minLength' => 1,
		// 		'focus'=> 'js:function( event, ui ) {
		// 				$(this).val( ui.item.value);
		// 				return false;
		// 			}',
		// 		'select'=>'js:function( event, ui ) {
		// 				$("#signa").val(ui.item.value);
		// 				is_signa_select = true;
		// 				return false;
		// 			}',
		//
		// 		'close'=>'js:function(event, ui) {
		// 			if (!is_signa_select) {
		// 				$(this).val("");
		// 			}
		// 			is_signa_select = false;
		// 		}'
		// 	),
		// 	'htmlOptions'=>array(
		// 		'class'=>'inputFormTabel span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'id'=>'signa'
		// 	),
		// ));
		?>
		<?php
		// echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
		// 	'class'=>'btn btn-green',
		// 	'onclick'=>'form_tambah_signa();', 'data-toggle'=>'tooltip', 'title'=>'Tambah Signa',
		// ));
		?>
		<?php //echo CHtml::activeDropDownList($modResepturDetail, '[ii]signa_reseptur', LookupM::getItems('signa_oa'),array('readonly'=>false,'class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); 
		?>
	</td>
	<td nowrap>
		<?php

		$etiket = explode(" - ", $modResepturDetail->etiket);

		echo CHtml::activeDropDownList($modResepturDetail, '[ii]ket_penggunaan', LookupM::getItems('etiket'), array('readonly' => false, 'class' => 'span2 ket_penggunaan',"onchange"=>'setRiwayat(this);')); ?>
		<br>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]etiket', array('readonly' => false, 'style' => 'width:180px;', 'class' => 'span4')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[ii][etiket][0]', empty($etiket[0]) ? "" : $etiket[0], LookupM::getItems('signa_oa'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[ii][etiket][1]', empty($etiket[1]) ? "" : $etiket[1], LookupM::getItems('etiket_1'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[ii][etiket][2]', empty($etiket[2]) ? "" : $etiket[2], LookupM::getItems('etiket_2'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php ////echo CHtml::dropDownList(get_class($modResepturDetail).'[ii][etiket][3]', empty($etiket[3]) ? "" : $etiket[3], LookupM::getItems('etiket_4'), array('style' => 'width:100px; display: none;', 'data-toggle'=>'tooltip', 'title'=>'Cara Penggunaan Obat')); 
		?>

	</td>
	<td>
		<?php
		$therapi = TherapiobatM::model()->findAll('therapiobat_aktif = true order by therapiobat_nama');
		$tlist = CHtml::listData($therapi, 'therapiobat_id', 'therapiobat_nama');

		echo CHtml::activeDropDownList($modResepturDetail, '[ii]therapiobat_id', $tlist, array('empty' => '-- Pilih --', 'readonly' => false)) ?>
	</td>
	<td>
		<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]resepturketerangan', array('class' => 'keterangan span3', 'readonly' => true)); ?>
	</td>
	<td>
	<?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modResepturDetail,
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
</tr>