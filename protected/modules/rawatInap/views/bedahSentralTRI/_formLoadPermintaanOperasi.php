<?php
$idOperasi = $modOperasi->operasi_id;
$namaOperasi = $modOperasi->operasi_nama;
$kegiatanOperasi = $modOperasi->kegiatanoperasi->kegiatanoperasi_nama;
//$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$idDaftarTindakan=$modOperasi->daftartindakan_id;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
//if($tarif>0){
?>

<tr id="operasi_<?php echo $idOperasi; ?>">  
    <td>
        <?php echo $kegiatanOperasi; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $idDaftarTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo $namaOperasi; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputoperasi][]", $idOperasi,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td hidden>
        <?php echo CHtml::textField("permintaanPenunjang[inputtarifoperasi][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('class'=>'inputFormTabel span1 integer qty', 'onkeyup'=>'hitungTotal()', 'style'=>'text-align:right;')); ?></td>
    
</tr>
<?php //} ?>