<?php
$idPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_id;
$namaPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_nama;
$jenisPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_jenis;
//$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;

if($tarif>0){
?>
<tr id="periksarad_<?php echo $idPemeriksaanRad; ?>">
    <td>
        <?php echo $jenisPemeriksaanRad; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modPeriksaRad->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 currency tarif','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $namaPemeriksaanRad; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputpemeriksaanrad][]", $idPemeriksaanRad,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
<!--    <td>
        <?php //echo $tarif; ?>
        <?php // echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 currency','readonly'=>true)); ?>
    </td>-->
    <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('class'=>'inputFormTabel number lebar1 qty', 'onkeyup'=>'hitungTotal();')); ?></td>
</tr>
<?php } ?>
