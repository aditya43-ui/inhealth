<?php
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
if($tarif>0){
?>
<tr id="tindakanrm_<?php echo $modTarif->tindakanrm_id; ?>">
    <td>
        <?php echo $modTarif->jenistindakanrm_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $modTarif->tindakanrm_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtindakanrm][]", $modTarif->tindakanrm_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php //echo $tarif; ?>
        <?php echo CHtml::textField("permintaanPenunjang[inputtariftindakanrm][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('class'=>'inputFormTabel lebar1 qty','readonly'=>true, 'onkeyup'=>'hitungTotal()')); ?></td>
</tr>
<?php } ?>