<tr>
	<td style="text-align: center;">
		<?php
		if ($this->is_trracikan) {
			echo CHtml::link('<i class="icon-form-plus"></i>', 'javascript:void(0);', array('onclick' => 'tambahObatalkesRacikan(this,0);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah Obat Alkes dengan R = ' . $modResepturDetail->rke));
		}
		?>
	</td>
	<td style="text-align: center;">
		<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]resepturdetail_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]racikan_id', array('readonly' => false, 'style' => 'width:110px;')); ?>
		<?php //echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargasatuan_reseptur', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]harganetto_reseptur', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]hargajual_reseptur', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'integer-decimal')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]stokobatalkes_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
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
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]rke', array('readonly' => false, 'style' => 'width:20px;')); ?>
	</td>
	<?php
	if (!empty($this->is_trracikan)) { ?>
		<td>
			<span name="[ii][racikan_nama]">Obat Racikan</span>
		</td>
	<?php } else { ?>
		<td>
			<span name="[ii][racikan_nama]">Non Racikan</span>
		</td>
	<?php } ?>
	<td>
        <span name="[ii][obatalkes_kode]" class="kodeobat"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->obatalkes_kode : "") ?></span> /<br>
        <span name="[ii][obatalkes_nama_label]" class="namaobat"><?php echo (!empty($modResepturDetail->obatalkes_id) ? $modResepturDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
	<td>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]obatalkes_id', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'required')); ?>
		<?php
		//  $this->widget('MyJuiAutoComplete', array(
		// 	'model' => $modResepturDetail,
		// 	'attribute' => '[ii]obatalkes_nama',
		// 	'tombolDialog' => array('idDialog' => 'dialogOa', 'jsFunction' => "setDialogOA(this,1);"),
		// 	'htmlOptions' => array('placeholder' => 'Ketik Nama Obat', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'value' => ''),
		// )); ?>
		<?php $this->widget('MyJuiAutoComplete', array(
			'model' => $modResepturDetail,
			'attribute' => '[ii]obatalkes_nama_api',
			'tombolDialog' => array('idDialog' => 'dialogOaAPI', 'jsFunction' => "setDialogOAApi(this,1);"),
			'htmlOptions' => array('placeholder' => 'Ketik Nama Obat', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'value' => ''),
		)); ?>
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
				<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]formulaobatkronis_id', FormulaobatkronisM::getDropdown(), array('class' => 'span2 formulaobatkronis_id username', 'empty' => '-- Pilih --', 'readonly' => $disable, 'disabled' => $disable, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
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
			echo CHtml::hiddenField('FAResepturDetailT[ii][formulariumobat_id]', $modResepturDetail->formulariumobat_id, ['class' => 'formulariumobat_id', 'onkeyup' => "return $(this).focusNextInputField(event)"]);
			?>
			<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]is_tanggungan', array('class' => 'is_tanggungan span1 username', 'readonly' => true, 'style' => 'text-align: right;')); 
			?>
		<?php } ?>
	</td>
	<td><span name="[ii][sumberdana_nama]"></td>
	<td nowrap>
		<?php 
			if($this->is_trracikan) {
				echo CHtml::activeTelField($modResepturDetail, '[ii]jumlahpermintaan_obatracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
			} else {
				echo CHtml::activeTelField($modResepturDetail, '[ii]jumlahpermintaan_obatnonracikan', array('readonly' => false, 'style' => 'width:150px; text-align: right;'));
			}
		?>
	</td>

	<td>
		<?php if($this->is_trracikan) { ?>
			<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]satuansediaan', LookupM::getItems('sediaanobatracikan'), array('readonly' => false, 'class' => 'span2', 'empty' => '-- Pilih --')); ?>
		<?php } else { ?>
			<span name="[ii][satuansediaan]"> - </span>
		<?php } ?>
	</td>

	<td class="waktu-ri waktu-ranap">
				<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]waktupemberian_ranap', array('readonly' => true, 'style' => 'width:50px;', 'class'=>'wakturanap')); ?>
    			<?php $dataWaktu = ['Pagi' => 'Pagi', 'Siang' => 'Siang', 'Sore' => 'Sore', 'Malam' => 'Malam'] ?>

    			<?php
    			foreach($dataWaktu as $i => $dt) {
    			        echo CHtml::checkBox('RJResepturDetailT[ii][' . strtolower($i) .  ']', null, array(
    			            'class'=>'cb-waktu', 'onclick'=>'setWaktuVerif(this);', 'data-val'=>$dt
    			        )).CHtml::label($dt, '', array()) . '&emsp;';
    			}
    			?>
    	</td>
	
	<td nowrap>
		<?php echo CHtml::activeTelField($modResepturDetail, '[ii]permintaan_reseptur', array('readonly' => false, 'style' => 'width:50px; text-align: right;', 'class' => ''));?>
		<?php echo $modResepturDetail->satuankekuatan;?>

	</td>
	<td nowrap>
	
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]jmlstok', array('class' => 'stok', 'readonly' => true, 'style' => 'width:50px; text-align: right;', 'onblur' => 'hitungSubTotal(this);')); ?>
		<span class="satuan"></span>
		
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_reseptur', array('readonly' => true, 'style' => 'width:50px; text-align: right; display: none;')); //,'onblur'=>'hitungSubTotal(this)'
		?><span class="satuan nama-satuan"></span>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]qty_dilayani', array('class' => 'qty', 'readonly' => false, 'style' => 'width:50px; text-align: right;', 'value' => $modResepturDetail->qty_reseptur, 'onblur' => 'hitungSubTotal(this); ceklist(this);setRiwayat(this);')); ?><span class="satuan"></span>
	</td>

	<td hidden>
		<span name="[ii][sumberdana_nama]"><?php echo (!empty($modResepturDetail->sumberdana_id) ? $modResepturDetail->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]sumberdana_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]satuankecil_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
	</td>
	<?php if ($this->is_trracikan) {
			?>
		<td>
			<?php echo CHtml::activeTextField($modResepturDetail, '[ii]administrasi', array('readonly' => true, 'style' => 'width:80px;', 'class' => 'integer-decimal')); ?>
		</td>
		<?php } else { ?>
			<td>
				-
			</td>
		<?php } ?>
	<!-- <td nowrap> -->
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]is_permitaandosispecahan', array('class' => 'is_permintaadosispecahan', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_penyebut', array('class' => 'permintaandosis_penyebut', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]permintaandosis_pembilang', array('class' => 'permintaandosis_pembilang', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]jmlstok', array('class' => 'stok', 'readonly' => true, 'style' => 'width:50px; text-align: right;', 'onblur' => 'hitungSubTotal(this);')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]jml_min', array('class' => 'jml_min', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
		<?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]jml_max', array('class' => 'jml_max', 'readonly' => true, 'style' => 'width:50px; text-align: right;')); ?>
                <?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]subjenis_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
                <?php echo CHtml::activeHiddenField($modResepturDetail, '[ii]subjenis_nama', array('readonly' => true, 'style' => 'width:110px;')); ?>
		<!-- <span class="satuan"></span> -->
	<!-- </td> -->
	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]hargasatuan_reseptur', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal')); ?>
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
        <?php echo CHtml::activeTextField($modResepturDetail, '[ii]subtotal', array('readonly' => true, 'style' => 'width:120px;', 'class' => 'integer-decimal')); ?>
    </td>

	<td>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]signa_reseptur', array('readonly' => false, 'class' => 'inputFormTabel span3', 'style' => 'width:100px;', 'onkeypress' => "return $(this).focusNextInputField(event)","onblur"=>'setRiwayat(this);')); ?>
	</td>
	<td nowrap>
		<?php echo CHtml::activeDropDownList($modResepturDetail, '[ii]ket_penggunaan', LookupM::getItems('etiket'), array('readonly' => false, 'class' => 'span2 ket_penggunaan',"onchange"=>'setRiwayat(this);')); ?>
		<br>
		<?php echo CHtml::activeTextField($modResepturDetail, '[ii]etiket', array('readonly' => false, 'style' => 'width:180px;', 'class' => 'span4')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[ii][etiket][0]', empty($etiket[0]) ? "" : $etiket[0], LookupM::getItems('signa_oa'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[ii][etiket][1]', empty($etiket[1]) ? "" : $etiket[1], LookupM::getItems('etiket_1'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail) . '[ii][etiket][2]', empty($etiket[2]) ? "" : $etiket[2], LookupM::getItems('etiket_2'), array('class'=>'ket_penggunaan','style' => 'width:100px;', 'data-toggle' => 'tooltip', 'title' => 'Cara Penggunaan Obat',"onchange"=>'setRiwayat(this);')); ?>
		<?php //echo CHtml::dropDownList(get_class($modResepturDetail).'[ii][ket_penggunaan][3]', empty($etiket[3]) ? "" : $etiket[3], LookupM::getItems('etiket_4'), array('style' => 'width:100px; display:none;', 'data-toggle'=>'tooltip', 'title'=>'Cara Penggunaan Obat')); 
		?>
		<?php //echo CHtml::activeDropDownList($modResepturDetail,'[ii]ket_penggunaan', LookupM::getItems('penggunaan_oa'), array('class' => 'inputFormTabel col-sm-12', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty'=>'-- Pilih --')); 
		?>
	</td>
	<td>
		<?php
		$therapi = TherapiobatM::model()->findAll('therapiobat_aktif = true order by therapiobat_nama');
		$tlist = CHtml::listData($therapi, 'therapiobat_id', 'therapiobat_nama');

		echo CHtml::activeDropDownList($modResepturDetail, '[ii]therapiobat_id', $tlist, array('empty' => '-- Pilih --')) ?>
	</td>
	<td>
		<?php echo CHtml::activeTextArea($modResepturDetail, '[ii]resepturketerangan', array('class' => 'keterangan span3')); ?>
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