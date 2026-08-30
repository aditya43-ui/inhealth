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
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;',  'class' =>'rke')); ?>
    </td>
    <td>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]therapiobat_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]racikan_id',array('readonly'=>true,'style'=>'width:110px;', 'class' =>'racikan_id')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][obatalkes_kode]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->kodeobat_inventory : "") ?></span> /<br>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_nama : "") ?></span>

    </td>
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
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]satuansediaan',array('class'=>'qty_stok', 'readonly'=>true,'style'=>'width:50px;')); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td hidden>
        <span name="[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]qty_oa',array('class'=>'qty_jual', 'readonly'=>true,'style'=>'width:50px;')); //,'onblur'=>'hitungSubTotal(this)'?>
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
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]permintaan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]kekuatan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jmlkemasan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]harganetto_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargasatuan_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'?>

        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]hargasatuan_reseptur'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]st_fornas'); ?>

        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaservice'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakonseling'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jasadokterresep'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakemasan'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]tarifcyto'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidiasuransi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidipemerintah'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidirs'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iurbiaya'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]stokobatalkes_id'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jasapelayanan_farmasi', array('class'=>'integer-decimal')); ?>

    <!-- </td> -->
<!--    <td> -->

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
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]persen_discount',array('readonly'=>$isKondisi,'style'=>'width:50px;', 'class'=>'integer-decimal','onblur'=>'hitungTotal()')); ?>
    </td>
    <td hidden>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]discount',array('readonly'=>$isKondisi,'style'=>'width:110px;', 'class'=>'integer-decimal','onblur'=>'hitungPersenDiskon()')); ?>
    </td>
    <td hidden>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]ppnpersen',array('readonly'=>false,'style'=>'width:50px;', 'class'=>'integer-decimal', 'onblur'=>'hitungTotal()')); ?>
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
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]etiket',array('readonly'=>true,'style'=>'width:180px;')); ?>
         <?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]ket_penggunaan', LookupM::getItems('etiket'),array('readonly'=>false,'class'=>'span2')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iter',array('readonly'=>true,'style'=>'width:50px;')); ?>
		<?php //echo CHtml::activeTextField($modObatAlkesPasien, '[ii]ket_penggunaan',array('readonly'=>true,'style'=>'width:120px;')); ?>
    </td>

    <td>
        <?php echo CHtml::activeTextArea($modObatAlkesPasien, '[ii]keterangan', array('class'=>'keterangan span3')); ?>
    </td>
    <td>
    	<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-remove"></i></a>
    </td>
</tr>
