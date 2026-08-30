<?php
$periksa = PemeriksaanradM::model()->findByPk($item->pemeriksaanrad_id);
$jenis = JenispemeriksaanradM::model()->findByPk($periksa->jenispemeriksaanrad_id);
$tarif = (!empty($item->tarif_pelayananan)) ? $item->tarif_pelayananan : 0;

if($tarif>0){
?>
<tr id="periksarad_<?php echo $item->pemeriksaanrad_id; ?>">
    <td>
        <?php echo $jenis->jenispemeriksaanrad_nama; ?>
        <?php // echo CHtml::hiddenField("permintaanPenunjang[permintaankepenunjang_id][]", $item->permintaankepenunjang_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $item->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php 
        echo $periksa->pemeriksaanrad_nama; 
        if (!empty($paket)) {
            echo '</br>('.$paket->tipepaket_nama.')';
        }
        
        ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputpemeriksaanrad][]", $item->pemeriksaanrad_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <!--<td>
        <?php //echo $tarif; ?>
        <?php //echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>-->
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", $item->qtypermintaan, array('readonly'=>false, 'class'=>'inputFormTabel integer lebar1 qty span1', 'onkeyup'=>'hitungTotal();')); 
        echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true));
    ?>
        
    </td>
</tr>
<?php } ?>
