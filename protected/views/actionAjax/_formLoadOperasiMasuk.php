<?php
$idOperasi = $modOperasi->operasi_id;
$namaOperasi = $modOperasi->operasi_nama;
$kegiatanOperasi = $modOperasi->kegiatanoperasi->kegiatanoperasi_nama;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
$persen_cyto = (!empty($modTarif->persencyto_tind)) ? $modTarif->persencyto_tind : 0 ;
$idDaftarTindakan=$modOperasi->daftartindakan_id;
?>

<?php
    $i=0;
     $tarifTindakan=TariftindakanM::model()->findAll('daftartindakan_id='.$idDaftarTindakan.' AND kelaspelayanan_id='.$idKelasPelayanan.'');

     foreach($tarifTindakan AS $data):
      $i=0;   
//      $tabelTindKomp .=CHtml::hiddenField("BSTindakanKomponenT[komponentarif_id][".$idOperasi."][]", $data['komponentarif_id'],array('class'=>'inputFormTabel','readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[tarif_tindakankomp][".$idOperasi."][]", $data['harga_tariftindakan'],array('class'=>'inputFormTabel','readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[tarifcyto_tindakankomp][".$idOperasi."][]", 0,array('class'=>'inputFormTabel','readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[subsidiasuransikomp][".$idOperasi."][]", 0,array('class'=>'inputFormTabel','readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[subsidipemerintahkomp][".$idOperasi."][]",0,array('class'=>'inputFormTabel','readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[subsidirumahsakitkomp][".$idOperasi."][]", 0,array('class'=>'inputFormTabel','readonly'=>true))
//       .CHtml::hiddenField("BSTindakanKomponenT[iurbiayakomp][".$idOperasi."][]",0,array('class'=>'inputFormTabel','readonly'=>true));
      $i++;
      endforeach; 
   if($i>0){  
?>
<tr id="operasi_<?php echo $idOperasi; ?>">
    <td>
        <?php echo $kegiatanOperasi; ?>
        <?php //echo $tabelTindKomp ?>
        <br/>
        <span><?php echo $namaOperasi; ?></span>
        <?php echo CHtml::hiddenField("BSTindakanPelayananT[daftartindakan_id][]", $idDaftarTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("BSTindakanPelayananT[kelaspelayanan_id][]", $idKelasPelayanan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("operasi_id[]", $idOperasi,array('class'=>'inputFormTabel','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::textField("BSTindakanPelayananT[tarif_tindakan][]", $tarif,array('class'=>'inputFormTabel lebar3 currency','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("BSTindakanPelayananT[qty_tindakan][]", '1',array('class'=>'inputFormTabel lebar1')); ?></td>
    <td><?php echo CHtml::dropDownList('BSTindakanPelayananT[satuantindakan][]','KALI',LookupM::getItems('satuantindakan'),array('style'=>'width:70px;','empty'=>'-Pilih-','id'=>'satuan')) ?></td>
    <td>
        <?php echo CHtml::dropDownList('BSTindakanPelayananT[cyto_tindakan][]',0,array(1=>'Ya',0=>'Tidak'),array('style'=>'width:70px;','onchange'=>'hitungCyto('.$idOperasi.',this.value)')) ?>
        <?php echo CHtml::hiddenField("BSTindakanPelayananT[persencyto_tind][]", $persen_cyto,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("BSTindakanPelayananT[tarif_cyto][]", '0',array('class'=>'inputFormTabel lebar3')); ?></td>
</tr>
<?php
   }
   ?>
