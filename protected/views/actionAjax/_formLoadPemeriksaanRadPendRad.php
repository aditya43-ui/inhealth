<?php
$idPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_id;
$namaPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_nama;
$jenisPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_jenis;
//$persencyto = (!empty($modTindakanRuangan->persencyto_tind)) ? $modTindakanRuangan->persencyto_tind : 0 ;
$persencyto = 10;
//$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
if ($tarif > 0){
?>
<tr id="periksarad_<?php echo $idPemeriksaanRad; ?>">
    <td>
        <?php echo CHtml::checkBox("permintaanPenunjang[0][cbPemeriksaan]", true, array('value'=>$idPemeriksaanRad, 'onclick'=>'myAlert("Silakan klik tombol \'Pilih Pemeriksaan Radiologi\' untuk membatalkan pemeriksaan"); $(this).attr("checked",true);')); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[0][idDaftarTindakan]", $modPeriksaRad->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $jenisPemeriksaanRad;
              echo CHtml::hiddenField("permintaanPenunjang[0][jenisPemeriksaanNama]", $jenisPemeriksaanRad,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <br/>
        <?php echo $namaPemeriksaanRad; 
              echo CHtml::hiddenField("permintaanPenunjang[0][pemeriksaanNama]", $namaPemeriksaanRad,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[0][inputpemeriksaanrad]", $idPemeriksaanRad,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php //echo $tarif; ?>
        <?php echo CHtml::textField("permintaanPenunjang[0][inputtarifpemeriksaanrad]", $tarif,array('class'=>'inputFormTabel lebar2-5 currency tarifRad','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[0][inputqty]", '1',array('class'=>'inputFormTabel number lebar1 qtyRad', 'onkeyup'=>'hitungCytoRad(this); hitungTotalRad();')); ?></td>
    <td><?php echo CHtml::dropDownList("permintaanPenunjang[0][satuan]", '', LookupM::getItems('satuantindakan'),array('class'=>'inputFormTabel lebar3 satuanRad',)); ?></td>
    <td>
        <?php echo CHtml::dropDownList("permintaanPenunjang[0][cyto]", '0',array('1'=>'Ya','0'=>'Tidak'),array('class'=>'inputFormTabel lebar2-5 isCytoRad', 'onchange'=>'hitungCytoRad(this); hitungTotalRad();')); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[0][persencyto]", $persencyto,array('class'=>'inputFormTabel lebar2 persenCytoRad','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[0][tarifcyto]", '0',array('class'=>'inputFormTabel lebar2-5 currency cytoRad','readonly'=>true, 'onkeyup'=>'hitungTotalRad();')); ?></td>
</tr>
<?php } ?>