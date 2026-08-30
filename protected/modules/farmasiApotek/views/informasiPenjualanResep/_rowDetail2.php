<tr>
    <?php //print_r($modObatAlkesPasien);exit(); ?>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]r',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <span id="isi-r" name="[ii][isi_r]">R/</span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]rke',array('readonly'=>true,'style'=>'width:20px;')); ?>
    </td>
    <td>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]racikan_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]therapiobat_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]obatalkespasien_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][obatalkes_kode]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_kode : "") ?></span>/<br>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->obatalkes_nama."(".$modObatAlkesPasien->obatalkes_nama.")"  : "") ?></span>
        
    </td>
    <td hidden>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->obatalkes->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td hidden>
        <span name="[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <td>
        <?php 
        if ($modObatAlkesPasien->racikan_id == Params::RACIKAN_ID_RACIKAN) {
            $modObatAlkesPasien->qty_oa = number_format($modObatAlkesPasien->qty_oa, 2, ",", "");
        } else {
            $modObatAlkesPasien->qty_oa = ceil($modObatAlkesPasien->qty_oa);
        }
        echo CHtml::activeTextField($modObatAlkesPasien, '[ii]qty_oa',array('class'=>'qty_jual '.($modObatAlkesPasien->racikan_id == Params::RACIKAN_ID_RACIKAN ? 'float3' : 'integer2'), 'readonly'=>false,'style'=>'width:50px;', 'onblur'=>'hitungSubTotal(this);')); //,'onblur'=>'hitungSubTotal(this)'?>
        <?php echo (!empty($modObatAlkesPasien->obatalkes->satuankecil_id) ? $modObatAlkesPasien->obatalkes->satuankecil->satuankecil_nama : "") ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]jmlstok',array('class'=>'qty_stok', 'readonly'=>true,'style'=>'width:50px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]permintaan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]kekuatan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jmlkemasan_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]harganetto_oa',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargasatuan_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer2')); //,'onblur'=>'hitungSubTotal(this)'?>
        
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaservice'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakonseling'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]jasadokterresep'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayakemasan'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]biayaadministrasi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]tarifcyto'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidiasuransi'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidipemerintah'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]subsidirs'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iurbiaya'); ?>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]stokobatalkes_id'); ?>

    </td>
<!--<td>
        <?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]discount',array('style'=>'width:50px;', 'class'=>'integer2')); //, 'onblur'=>'hitungSubTotal(this)' ?>
    </td>-->
    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]hargajual_oa',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer2')); ?>
    </td>
    <td>
    	<?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]signa_oa',array('readonly'=>false,'style'=>'width:50px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modObatAlkesPasien, '[ii]etiket',array('readonly'=>false,'style'=>'width:180px;')); ?>
		<?php echo CHtml::activeHiddenField($modObatAlkesPasien, '[ii]iter',array('readonly'=>true,'style'=>'width:50px;')); ?>
		<?php echo CHtml::activeDropDownList($modObatAlkesPasien, '[ii]ket_penggunaan', LookupM::getItems('etiket'),array('readonly'=>false,'class'=>'span2')); ?>
    </td>

    <td>
    	<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>