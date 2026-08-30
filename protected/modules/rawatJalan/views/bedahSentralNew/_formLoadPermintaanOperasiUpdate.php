<?php

$modOperasi = OperasiM::model()->findByPk($item->operasi_id);
$idOperasi = $modOperasi->operasi_id;
$namaOperasi = $modOperasi->operasi_nama;
$kegiatanOperasi = $modOperasi->kegiatanoperasi->kegiatanoperasi_nama;
$tarif = (!empty($item->tarif_pelayananan)) ? $item->tarif_pelayananan : 0;
$idDaftarTindakan=$modOperasi->daftartindakan_id;
?>
<tr id="operasi_<?php echo $idOperasi; ?>" class="tr-operasi">  
    <td>
        <?php echo $kegiatanOperasi; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $idDaftarTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $namaOperasi; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputoperasi][]", $idOperasi,array('class'=>'inputFormTabel operasi_id','readonly'=>true)); ?>
    </td>
    <td hidden>
        <?php echo CHtml::textField("permintaanPenunjang[inputtarifoperasi][]", $tarif,array('class'=>'inputFormTabel lebar3 integer','readonly'=>true)); ?>
    </td>
    <td hidden>
        <?php echo CHtml::dropDownList("permintaanPenunjang[detailoperasi][]", '', CHtml::listData(DetailOperasiM::model()->findAll(" operasi_id = ".$idOperasi." ORDER BY detailoperasi_nama ASC "), 'detailoperasi_id', 'detailoperasi_nama'), array('empty' => '-- Pilih --')); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('class'=>'inputFormTabel lebar1 integer')); ?></td>
    
</tr>
