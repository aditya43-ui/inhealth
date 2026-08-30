<?php
$idTindakanRm = $modTindakanRm->tindakanrm_id;
$namaTindakanRm = $modTindakanRm->tindakanrm_nama;
$jenisTindakanRm = $modTindakanRm->jenistindakanrm->jenistindakanrm_nama;
//$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
?>
<tr id="tindakanrm_<?php echo $idTindakanRm; ?>">
    <td>
        <?php echo $jenisTindakanRm; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTindakanRm->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $namaTindakanRm; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtindakanrm][]", $idTindakanRm,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php //echo $tarif; ?>
        <?php echo CHtml::textField("permintaanPenunjang[inputtariftindakanrm][]", $tarif,array('class'=>'inputFormTabel lebar3 currency','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('class'=>'inputFormTabel lebar1','readonly'=>true)); ?></td>
</tr>
