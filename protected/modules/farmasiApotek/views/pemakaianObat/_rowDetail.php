<?php if (empty($modPemakaianObatDetail->pemakaianobatdetail_id)): ?>
<tr>
    <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    <td>
        <?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]obatalkes_id'); ?>
		<?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]stokobatalkes_id'); ?>
        <span name="[ii][obatalkes_kode]"><?php echo (!empty($modPemakaianObatDetail->obatalkes_id) ? $modPemakaianObatDetail->obatalkes->obatalkes_kode : "") ?></span>        
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPemakaianObatDetail->obatalkes_id) ? $modPemakaianObatDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td hidden>
		<?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][satuankecil_nama]"><?php echo (!empty($modPemakaianObatDetail->satuankecil_id) ? $modPemakaianObatDetail->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemakaianObatDetail, '[ii]qty_satuanpakai',array('readonly'=>true,'style'=>'width:50px;')); //,'onblur'=>'hitungSubTotal(this)'?>
        <?php echo (!empty($modPemakaianObatDetail->satuankecil_id) ? $modPemakaianObatDetail->satuankecil->satuankecil_nama : "") ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modPemakaianObatDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;')); ?>
    </td>
    <td>
		<?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]harganetto_satuanpakai',array('readonly'=>true)); ?>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modPemakaianObatDetail, '[ii]harga_satuanpakai',array('readonly'=>true,'style'=>'width:100px;', 'class'=>'integer2')):CHtml::activePasswordField($modPemakaianObatDetail, '[ii]harga_satuanpakai',array('readonly'=>true,'style'=>'width:100px;', 'class'=>'integer2')); //,'onblur'=>'hitungSubTotal(this)'?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modPemakaianObatDetail, '[ii]subtotal',array('readonly'=>true,'style'=>'width:100px;', 'class'=>'integer2')):CHtml::activePasswordField($modPemakaianObatDetail, '[ii]subtotal',array('readonly'=>true,'style'=>'width:100px;', 'class'=>'integer2')); //,'onblur'=>'hitungSubTotal(this)'?>
    </td>
	<?php if(!isset($_GET['sukses'])){ ?>
		<td>
			<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
	<?php } ?>
</tr>
<?php else : ?>
<tr>
    <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    <td>
        <?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]obatalkes_id'); ?>
		<?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]stokobatalkes_id'); ?>
        <span name="[ii][obatalkes_kode]"><?php echo (!empty($modPemakaianObatDetail->obatalkes) ? $modPemakaianObatDetail->obatalkes->obatalkes_kode : "") ?></span> 
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPemakaianObatDetail->obatalkes) ? $modPemakaianObatDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td hidden>
		<?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <span name="[ii][satuankecil_nama]"><?php echo (!empty($modPemakaianObatDetail->satuankecil_id) ? $modPemakaianObatDetail->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <td style="text-align: right;">
        <?php echo $modPemakaianObatDetail->qty_satuanpakai; ?>
        <?php echo (!empty($modPemakaianObatDetail->satuankecil_id) ? $modPemakaianObatDetail->satuankecil->satuankecil_nama : "") ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modPemakaianObatDetail, '[ii]jmlstok',array('readonly'=>true,'style'=>'width:50px;')); ?>
    </td>
    <td style="text-align: right;">
	<?php echo CHtml::activeHiddenField($modPemakaianObatDetail, '[ii]harganetto_satuanpakai',array('readonly'=>true)); ?>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?'Rp'.MyFormatter::formatNumberForPrint($modPemakaianObatDetail->harga_satuanpakai):"Hidden"; ?>
    </td>
    <td style="text-align: right;">
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?'Rp'.MyFormatter::formatNumberForPrint($modPemakaianObatDetail->subtotal):"Hidden"; ?>
    </td>
	<?php if(!isset($_GET['sukses'])){ 
            if (empty($nobatal)) { ?>
		<td>
			<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
            <?php } ?>
	<?php } ?>
</tr>
<?php endif; ?>
