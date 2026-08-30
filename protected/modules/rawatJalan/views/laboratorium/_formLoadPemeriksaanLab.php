<?php
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;

if($tarif>0){
?>
<tr id="periksalab_<?php echo $modTarif->pemeriksaanlab_id; ?>">
    <?php if($modTarif->jenispemeriksaanlab_kelompok == Params::PATOLOGI_KLINIK){ ?>
      <td>
        <?php echo $modTarif->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
    </td>
    <td>
        <?php 
        echo $modTarif->pemeriksaanlab_nama; 
        if (!empty($paket)) {
            echo '</br>('.$paket->tipepaket_nama.')';
        }
        ?>
        <?php echo CHtml::HiddenField("permintaanPenunjang[inputpemeriksaanlab][]", $modTarif->pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php

    if($modTarif->isdouble == true){
        echo CHtml::textField("permintaanPenunjang[inputqty][]", '2',array('readonly'=>false,'class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal2();',));      
    }else{
         echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('readonly'=>false,'class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal();',));
    } ?>
        <?php // echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo MyFormatter::formatNumberForPrint($tarif); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::checkBox("permintaanPenunjang[is_cito][]", false, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);', 'class' => 'cek-cito')) ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[cito_true][]", "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>

    </td>
    <td>
        <?php
            echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalPeriksa(' . $modTarif->pemeriksaanlab_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan kirim pasien', 'data-placement' => 'left'));
        ?>
    </td>
    
    <?php }else{ ?>
    
      <td>
        <?php echo $modTarif->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[idDaftarTindakan][]", $modTarif->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php // echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $modTarif->pemeriksaanlab_nama; ?>
        <?php echo CHtml::HiddenField("permintaanPenunjangAnatomi[inputpemeriksaanlab][]", $modTarif->pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
  
    <td><?php

    if($modTarif->isdouble == true){
        echo CHtml::textField("permintaanPenunjang[inputqty][]", '2',array('readonly'=>false,'class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal2();',));      
    }else{
         echo CHtml::textField("permintaanPenunjang[inputqty][]", '1',array('readonly'=>false,'class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal();',));
    } ?>
     <?php // echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo MyFormatter::formatNumberForPrint($tarif); ?>
        <?php echo CHtml::textField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::checkBox("permintaanPenunjangAnatomi[is_cito][]", false, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);', 'class' => 'cek-cito')) ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[cito_true][]", "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>

    </td>
    <td>
        <?php
            echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalPeriksa(' . $modTarif->pemeriksaanlab_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan kirim pasien', 'data-placement' => 'left'));
        ?>
    </td>
    <!-- <td>
        <?php //$modTarifTindakan = TariftindakanM::model()->findByAttributes(array('jenistarif_id' => $modTarif->jenistarif_id)); ?>
        <?php //echo CHtml::activeHiddenField($modTarifTindakan, "totaltarifakhir_cyto", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
        <?php //echo CHtml::activeHiddenField($modTarifTindakan, "hargatariftindakan", array('readonly'=>true,'class'=>'inputFormTabel currency')) ?>
    </td> -->
    
    <?php } ?>

</tr>
<?php } ?>
