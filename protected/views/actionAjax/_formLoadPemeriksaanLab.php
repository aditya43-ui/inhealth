<?php
$idPemeriksaanLab = $modPeriksaLab->pemeriksaanlab_id;
$namaPemeriksaanLab = $modPeriksaLab->pemeriksaanlab_nama;
$jenisPemeriksaanLab = $modPeriksaLab->jenispemeriksaan->jenispemeriksaanlab_nama;
$jenisPemeriksaanKel = $modPeriksaLab->jenispemeriksaan->jenispemeriksaanlab_kelompok;
//$tarif = (!empty($modTindakanRuangan->harga_tariftindakan)) ? $modTindakanRuangan->harga_tariftindakan : 0 ;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;

if($tarif>0){
?>
<tr id="periksalab_<?php echo $idPemeriksaanLab; ?>">
    <?php if($jenisPemeriksaanKel==Params::PATOLOGI_KLINIK){ ?>
      <td>
        <?php echo $jenisPemeriksaanLab; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modPeriksaLab->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 currency tarif','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[jenisPemeriksaanKel][]", $jenisPemeriksaanKel,array('class'=>'inputFormTabel lebar3 currency tarif','readonly'=>true)); ?>
      </td>
      <td>
        <?php echo $namaPemeriksaanLab; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputpemeriksaanlab][]", $idPemeriksaanLab,array('class'=>'inputFormTabel','readonly'=>true)); ?>
      </td>
        <!--<td>
            <?php //echo $tarif; ?>
            <?php // echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 currency','readonly'=>true)); ?>
        </td>-->
      <td><?php echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('class'=>'inputFormTabel lebar1 number gty', 'onkeyup'=>'hitungTotal();',)); ?></td>
    
    <?php }else{ ?>
    
      <td>
        <?php echo $jenisPemeriksaanLab; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[idDaftarTindakan][]", $modPeriksaLab->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 currency tarif','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[jenisPemeriksaanKel][]", $jenisPemeriksaanKel,array('class'=>'inputFormTabel lebar3 currency tarif','readonly'=>true)); ?>
      </td>
      <td>
        <?php echo $namaPemeriksaanLab; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputpemeriksaanlab][]", $idPemeriksaanLab,array('class'=>'inputFormTabel','readonly'=>true)); ?>
      </td>
        <!--<td>
            <?php //echo $tarif; ?>
            <?php // echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 currency','readonly'=>true)); ?>
        </td>-->
      <td><?php echo CHtml::textField("permintaanPenunjangAnatomi[inputqty][]", '1',array('class'=>'inputFormTabel lebar1 number gty', 'onkeyup'=>'hitungTotal();',)); ?></td>

    <?php } ?>

</tr>
<?php } ?>
