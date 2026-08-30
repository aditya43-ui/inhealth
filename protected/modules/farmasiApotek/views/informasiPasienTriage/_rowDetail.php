<?php
    $konfigFarmasi = KonfigfarmasiK::model()->find();
    $isKondisi = false;
    if(!empty($konfigFarmasi) && $konfigFarmasi->ishargaperpenjamin){
        $isKondisi = true;
    }
?>
<tr>
    <td>
        <?php echo CHtml::activeTextField($modPemakaianObat, '[ii]tgl_resep',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal')); //,'onblur'=>'hitungSubTotal(this)'?>  </td>
    <td>
        <?php echo CHtml::activeTextField($modPemakaianObat, '[ii]noresep_triage',array('readonly'=>true, 'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modPemakaianObat, '[ii]obatalkes_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modPemakaianObat, '[ii]petugasfarmasi_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modPemakaianObat, '[ii]hargasatuan_reseptur',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modPemakaianObat, '[ii]sumberdana_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
		<?php echo CHtml::activeHiddenField($modPemakaianObat, '[ii]stfornas',array('readonly'=>true,'style'=>'width:110px;')); ?>
		
    </td>
    <td>
    	<?php echo CHtml::activeTextField($modPemakaianObat, '[ii]nobed_triage',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td>
        <?= $modPemakaianObat->nama_pasien ?>
    </td>
    <td>
    	<?= $modPemakaianObat->petugasfarmasi_nama ?>
    </td>
    <td>
        <?php echo CHtml::activetextField($modPemakaianObat, '[ii]petugas_pengambil_obat',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo  $modPemakaianObat->obatalkes_nama ?? ""; ?></span>
    </td>
    <td>
        <span name="[ii][jumlah]"><?php echo  CHtml::activeTextField($modPemakaianObat, '[ii]jumlah',array('readonly'=>true,'style'=>'width:110px;', 'class'=>'integer-decimal'));; ?></span>
    </td>
    <td>
        <span name="[ii][keterangan]"><?php echo  CHtml::activeTextField($modPemakaianObat, '[ii]keterangan',array('readonly'=>true,'style'=>'width:110px;'));; ?></span>
    </td>
    <td>
    	<a onclick="batalObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-remove"></i></a>
    </td>
</tr>
