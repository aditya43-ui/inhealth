<?php
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;

if($tarif>0){
?>
<tr id="periksarad_<?php echo $modTarif->pemeriksaanrad_id; ?>">
    <td>
        <?php echo $modTarif->jenispemeriksaanrad_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $modTarif->pemeriksaanrad_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputpemeriksaanrad][]", $modTarif->pemeriksaanrad_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('class'=>'inputFormTabel integer lebar1 qty span1', 'onkeyup'=>'hitungTotal();')); ?></td>    
    <td>
        <?php echo MyFormatter::formatNumberForPrint($tarif); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>    
    <td class="lbl-subtotal"><?php echo MyFormatter::formatNumberForPrint($tarif); ?></td>
    <td>
        <?php echo CHtml::checkBox("permintaanPenunjang[is_cito][]", false, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);')) ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[cito_true][]", "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>
    </td>
</tr>
<?php } ?>
