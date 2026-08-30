<?php
    $konfigFarmasi = KonfigfarmasiK::model()->find();
    $isKondisi = false;
    if(!empty($konfigFarmasi) && $konfigFarmasi->ishargaperpenjamin){
        $isKondisi = true;
    }
?>
<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]r',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <span id="isi-r" name="[ii][isi_r]">R/</span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
    </td>
    <td>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]therapiobat_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]racikan_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][obatalkes_kode]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->kodeobat_inventory : "") ?></span> /<br>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_nama."(".$modObatAlkesPasien->obatalkes_nama.")" : "") ?></span>

    </td>
    <td>
        <?= $modObatAlkesPasien->sumberdana_nama ?? '' ?>
    </td>
    <!-- <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]temp_permintaan_dosis',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); ?>
        
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]satuankekuatan',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span class="satuankekuatan" name="[ii][satuan]">
    </td> -->
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]jmlstok',array('class'=>'qty_stok', 'readonly'=>true,'style'=>'width:50px;')); ?>
    </td>
    <td>
        <?php
            if($modObatAlkesPasien->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
                echo CHtml::activeTextField($modObatAlkesPasien, '[ii]jumlahpermintaan_obatnonracikan', array('readonly' => true, 'style' => 'width:50px;')); 
            } else {
                echo CHtml::activeTextField($modObatAlkesPasien, '[ii]jumlahpermintaan_obatracikan', array('readonly' => true, 'style' => 'width:50px;'));
            }
        ?>
    </td>
    <td class="waktu-ri hide">
    <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]waktupemberian_ranap', array('readonly' => true, 'style' => 'width:50px;', 'class'=>'wakturanap')); ?>
    <?php $dataWaktu = ['Pagi' => 'Pagi', 'Siang' => 'Siang', 'Sore' => 'Sore', 'Malam' => 'Malam'] ?>


                    <?php

                    foreach($dataWaktu as $i => $dt) {
                            echo CHtml::checkBox('FAObatalkesPasienT[ii][' . strtolower($i) .  ']', null, array(
                                'class'=>'cb-waktu', 'onclick'=>'setWaktu();', 'data-val'=>$dt
                            )).CHtml::label($dt, '', array()) . "<br>";
                    }
                    ?>

    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]satuansediaan',array('class'=>'qty_stok', 'readonly'=>true,'style'=>'width:50px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]permintaan_dosis',array('style'=>'width:110px;', 'class'=>'integer-decimal permintaan_dosis')); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td hidden>
        <span name="[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]qty_oa',array('class'=>'qty_jual', 'readonly'=>false,'style'=>'width:50px;')); //,'onblur'=>'hitungSubTotal(this)'?>
        <?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?>
    </td>
		<?php if ($modObatAlkesPasien->racikan_id == 2) {
			?>
		<td>
			<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]administrasi', array('readonly' => true, 'style' => 'width:80px;', 'class' => 'integer-decimal')); ?>
		</td>
		<?php } else { ?>
			<td>
				-
			</td>
		<?php } ?>
   
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]satuan_permintaandosis',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]permintaan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]kekuatan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jmlkemasan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]harganetto_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargasatuan_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'?>

        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaservice'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]hargasatuan_reseptur'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]st_fornas'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakonseling'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jasadokterresep'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakemasan'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]tarifcyto'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidiasuransi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidipemerintah'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidirs'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iurbiaya'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]stokobatalkes_id'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]keterangan'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jasapelayanan_farmasi', array('class'=>'integer-decimal')); ?>

        <?php if($this->id == "penjualanResepRS"){ ?>
            <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]is_obatkronis'); ?>
            <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]formulaobatkronis_id'); ?>
        <?php } ?>

    </td>
    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]total_embalase',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); ?>
    </td>

    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]biayaadministrasi',array('readonly'=>$isKondisi,'style'=>'width:110px;', 'class'=>'integer-decimal','onblur'=>'hitungTotal()')); ?>
    </td>
    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]totalbiayaadministrasi',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); ?>
    </td>
    <td hidden>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]persen_discount',array('readonly'=>$isKondisi, 'style'=>'width:50px;', 'class'=>'integer-decimal','onblur'=>'hitungTotal()')); ?>
    </td>
    <td hidden>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]discount',array('readonly'=>$isKondisi,'style'=>'width:110px;', 'class'=>'integer-decimal','onblur'=>'hitungPersenDiskon()')); ?>
    </td>
    <td hidden>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]ppnpersen',array('readonly'=>true,'style'=>'width:50px;', 'class'=>'integer-decimal')); ?>
    </td>
    <td hidden>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]jumlahppn',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); ?>
    </td>
    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargajual_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); ?>
    </td>
    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]signa_oa',array('readonly'=>false,'style'=>'width:50px;')); ?>
    </td>
    <td>
        <?php
            $readonlyEtiket = true; 
            if(!empty($_GET['sukses']) || $this->id != "penjualanResepRS" || $modObatAlkesPasien->racikan_id == Params::RACIKAN_ID_RACIKAN){
                $readonlyEtiket = true;
            }else{
                $readonlyEtiket = false;
            } 
        ?>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]etiket',array('readonly'=>$readonlyEtiket,'style'=>'width:180px;', 'maxlength'=>100)); ?>
        <?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]ket_penggunaan', LookupM::getItems('etiket'),array('readonly'=>false,'class'=>'span2')); ?>
        <?php //echo CHtml::activeTextField($modObatAlkesPasien, '[ii]ket_penggunaan',array('readonly'=>$readonlyEtiket,'style'=>'width:120px;', 'maxlength'=>100)); ?>
        
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iter',array('readonly'=>true,'style'=>'width:50px;')); ?>
		
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modObatAlkesPasien, '[ii]keterangan', array('class'=>'span3')); ?>
    </td>
    <td>
        <?php //CHtml::activeDateField($modObatAlkesPasien, '[ii]kadaluarsa', array('class'=>'span3')); ?>
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
