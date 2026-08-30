<?php
$idOperasi = $modOperasi->operasi_id;
$namaOperasi = $modOperasi->operasi_nama;
$kegiatanOperasi = $modOperasi->kegiatanoperasi->kegiatanoperasi_nama;
$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$persen_cyto = (!empty($modTindakanRuangan->persencyto_tind)) ? $modTindakanRuangan->persencyto_tind : 0 ;
$idDaftarTindakan=$modOperasi->daftartindakan_id;
?>

<?php
     $tarifTindakan=TariftindakanM::model()->findAll('daftartindakan_id='.$idDaftarTindakan.' AND kelaspelayanan_id='.$idKelasPelayan.'');
//     foreach($tarifTindakan AS $data):
//      $tabelTindKomp .=CHtml::hiddenField("BSTindakanKomponenT[komponentarif_id][".$idOperasi."][]", $data['komponentarif_id'],array('readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[tarif_tindakankomp][".$idOperasi."][]", $data['harga_tariftindakan'],array('readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[tarifcyto_tindakankomp][".$idOperasi."][]", 0,array('readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[subsidiasuransikomp][".$idOperasi."][]", 0,array('readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[subsidipemerintahkomp][".$idOperasi."][]",0,array('readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[subsidirumahsakitkomp][".$idOperasi."][]", 0,array('readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[iurbiayakomp][".$idOperasi."][]",0,array('readonly'=>true));
//     endforeach; 
?>
<tr id="operasi_<?php echo $idOperasi; ?>">
    <td><?php echo CHtml::checkBox('ceklis[]',true,array('value'=>$idOperasi));?></td>    
    <td>
        <?php echo $kegiatanOperasi; ?>
        <?php echo $tabelTindKomp ?>
        <br/>
        <span><?php echo $namaOperasi; ?></span>
        <?php echo CHtml::hiddenField("BSTindakanPelayananT[daftartindakan_id][".$idOperasi."]", $idDaftarTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("BSTindakanPelayananT[kelaspelayanan_id][".$idOperasi."]", $idKelasPelayan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("operasi_id[".$idOperasi."]", $idOperasi,array('class'=>'inputFormTabel','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::textField("BSTindakanPelayananT[tarif_tindakan][".$idOperasi."]", $tarif,array('class'=>'inputFormTabel lebar3','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("BSTindakanPelayananT[qty_tindakan][".$idOperasi."]", '1',array('class'=>'inputFormTabel lebar3')); ?></td>
    <td><?php echo CHtml::dropDownList('BSTindakanPelayananT[satuantindakan]['.$idOperasi.']','KALI',LookupM::getItems('satuantindakan'),array('style'=>'width:70px;','empty'=>'-Pilih-')) ?></td>
    <td>
        <?php echo CHtml::dropDownList('BSTindakanPelayananT[cyto_tindakan]['.$idOperasi.']',0,array(1=>'Ya',0=>'Tidak'),array('style'=>'width:70px;','onchange'=>'hitungCyto('.$idOperasi.',this.value)')) ?>
        <?php echo CHtml::hiddenField("BSTindakanPelayananT[persencyto_tind][".$idOperasi."]", $persen_cyto,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("BSTindakanPelayananT[tarif_cyto][".$idOperasi."]", '0',array('class'=>'inputFormTabel lebar3')); ?></td>
</tr>
