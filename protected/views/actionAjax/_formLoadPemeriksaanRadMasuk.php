<?php
$idPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_id;
$namaPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_nama;
$jenisPemeriksaanRad = $modPeriksaRad->pemeriksaanrad_jenis;
$persencyto = (!empty($modTarif->persencyto_tind)) ? $modTarif->persencyto_tind : 0 ;
//$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
?>
<tr id="periksarad_<?php echo $idPemeriksaanRad; ?>">
    <td>
        <?php echo $jenisPemeriksaanRad;
              echo CHtml::hiddenField("permintaanPenunjang[0][jenisPemeriksaanNama]", $jenisPemeriksaanRad,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[0][idDaftarTindakan]", $modPeriksaRad->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <br/>
        <?php echo $namaPemeriksaanRad; 
              echo CHtml::hiddenField("permintaanPenunjang[0][pemeriksaanNama]", $namaPemeriksaanRad,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[0][inputpemeriksaanrad]", $idPemeriksaanRad,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php //echo $tarif; ?>
        <?php echo CHtml::textField("permintaanPenunjang[0][inputtarifpemeriksaanrad]", $tarif,array('class'=>'inputFormTabel lebar2-5 currency tarif','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[0][inputqty]", '1',array('class'=>'inputFormTabel lebar1 number qty', 'onkeyup'=>'hitungCyto(this); hitungTotal();')); ?></td>
    <td><?php echo CHtml::dropDownList("permintaanPenunjang[0][satuan]", '', LookupM::getItems('satuantindakan'),array('class'=>'inputFormTabel lebar3',)); ?></td>
    <td>
        <?php echo CHtml::dropDownList("permintaanPenunjang[0][cyto]", '0',array('1'=>'Ya','0'=>'Tidak'),array('class'=>'inputFormTabel lebar2-5 isCyto','onchange'=>'hitungCyto(this); hitungTotal();')); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[0][persencyto]", $persencyto,array('class'=>'inputFormTabel lebar2 persenCyto','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("permintaanPenunjang[0][tarifcyto]", '',array('class'=>'inputFormTabel lebar2-5 cyto','readonly'=>true, 'onkeyup'=>'hitungTotal();')); ?></td>
</tr>
