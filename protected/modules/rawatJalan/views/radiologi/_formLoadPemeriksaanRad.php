<?php
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;

if($tarif>0){
?>
<tr id="periksarad_<?php echo $modTarif->pemeriksaanrad_id; ?>">
    <td>
        <?php echo $modTarif->jenispemeriksaanrad_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php // echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
        <?php // echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
    </td>
    <td>
        <?php 
        echo $modTarif->pemeriksaanrad_nama; 
        if (!empty($paket)) {
            echo '</br>('.$paket->tipepaket_nama.')';
        }
        
        ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputpemeriksaanrad][]", $modTarif->pemeriksaanrad_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <!--<td>
        <?php //echo $tarif; ?>
        <?php //echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>-->
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('readonly'=>false, 'class'=>'inputFormTabel integer lebar1 qty span1', 'onkeyup'=>'hitungTotal();')); 
        echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true));
    ?>
        
    </td>
</tr>
<?php } ?>
