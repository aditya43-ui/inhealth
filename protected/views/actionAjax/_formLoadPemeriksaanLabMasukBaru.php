<?php
$idPemeriksaanLab = $modPeriksaLab->pemeriksaanlab_id;
$namaPemeriksaanLab = $modPeriksaLab->pemeriksaanlab_nama;
$jenisPemeriksaanLab = $modPeriksaLab->jenispemeriksaan->jenispemeriksaanlab_nama;
$jenisPemeriksaanLabKelompok=$modPeriksaLab->jenispemeriksaan->jenispemeriksaanlab_kelompok;
$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$idDaftarTindakan=$modPeriksaLab->daftartindakan_id;
$idTindakan = $modTindakanPelayanan->tindakanpelayanan_id;
$cyto = $modTindakanRuangan->persencyto_tind;
$totCyto = ($cyto*$tarif)/100;

if($tarif< 0){
   echo 'tarif kosong';
} else {

?>

<?php
    $i=0;
     $tarifTindakan=TariftindakanM::model()->findAll('daftartindakan_id='.$idDaftarTindakan.' AND kelaspelayanan_id='.$idKelasPelayan.'');
     $tabelTindKomp = '';
     foreach($tarifTindakan AS $data):
      $tabelTindKomp .=CHtml::hiddenField("LKTindakanKomponenT[".$idPemeriksaanLab."][$i][komponentarif_id]", $data['komponentarif_id'],array('class'=>'inputFormTabel','readonly'=>true))
       .CHtml::hiddenField("LKTindakanKomponenT[".$idPemeriksaanLab."][$i][tarif_tindakankomp]", $data['harga_tariftindakan'],array('class'=>'inputFormTabel','readonly'=>true))
       .CHtml::hiddenField("LKTindakanKomponenT[".$idPemeriksaanLab."][$i][tarifcyto_tindakankomp]", 0,array('class'=>'inputFormTabel','readonly'=>true))
       .CHtml::hiddenField("LKTindakanKomponenT[".$idPemeriksaanLab."][$i][subsidiasuransikomp]", 0,array('class'=>'inputFormTabel','readonly'=>true))
       .CHtml::hiddenField("LKTindakanKomponenT[".$idPemeriksaanLab."][$i][subsidipemerintahkomp]",0,array('class'=>'inputFormTabel','readonly'=>true))
       .CHtml::hiddenField("LKTindakanKomponenT[".$idPemeriksaanLab."][$i][subsidirumahsakitkomp]", 0,array('class'=>'inputFormTabel','readonly'=>true))
       .CHtml::hiddenField("LKTindakanKomponenT[".$idPemeriksaanLab."][$i][iurbiayakomp]",0,array('class'=>'inputFormTabel','readonly'=>true));
      $i++;
      endforeach; 
   if($i>0){  
?>
<tr id="periksalab_<?php echo $idPemeriksaanLab; ?>">
    <td>
        <?php //echo $jenisPemeriksaanLab; ?>
        <span><?php echo $namaPemeriksaanLab; ?></span>
        <?php echo $tabelTindKomp ?>
        <br/>
        <?php echo CHtml::hiddenField("periksalab_id[]", $idPemeriksaanLab,array('class'=>'inputFormTabel','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::hiddenField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][pemeriksaanlab_id]", $idPemeriksaanLab,array('class'=>'inputFormTabel lebar1 pemeriksaanlab_id','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][jenispemeriksaanlab_kelompok]", $jenisPemeriksaanLabKelompok,array('class'=>'inputFormTabel lebar1','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][daftartindakan_id]", $idDaftarTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][kelaspelayanan_id]", $idKelasPelayan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::textField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][tarif_tindakan]", $tarif,array('class'=>'inputFormTabel lebar2 currency tarif','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][qty_tindakan]", '1',array('class'=>'inputFormTabel lebar1 number qty', 'onkeyup'=>'hitungCyto(this); hitungTotal();')); ?></td>
    <td><?php echo CHtml::dropDownList("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][satuantindakan]",'',LookupM::getItems('satuantindakan'),array('style'=>'width:70px;','id'=>'satuan')) ?></td>
    <td>
        <?php echo CHtml::dropDownList("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][cyto_tindakan]",0,array(1=>'Ya',0=>'Tidak'),array('class'=>'isCyto','style'=>'width:70px;','onclick'=>'cyto_tarif(this,'.$idPemeriksaanLab.')','onchange'=>'hitungCyto(this); hitungTotal();')) ?>
        <?php //echo CHtml::hiddenField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][persencyto]", $cyto,array('class'=>'inputFormTabel lebar2 persenCyto','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("PemeriksaanLab[$jenisPemeriksaanLabKelompok][$idPemeriksaanLab][tarif_cyto]", $totCyto,array('class'=>'inputFormTabel lebar2  cyto cyto_tarif_'.$idPemeriksaanLab,'style'=>'display:none', 'readonly'=>true,'onkeyup'=>'hitungTotal();')); ?></td>
    <td>
        <?php
            echo CHtml::link("<span class='icon-trash'>&nbsp;</span>",'',array("rel"=>"tooltip","title"=>"Klik untuk menghapus data Tindakan dari Database",'href'=>'','onclick'=>'deleteTindakan(this,'.$idDaftarTindakan.','.$idPemeriksaanLab.','.$idTindakan.');return false;','style'=>'text-decoration:none;'));
        ?>
    </td>
</tr>
<?php
   }
}
   ?>
