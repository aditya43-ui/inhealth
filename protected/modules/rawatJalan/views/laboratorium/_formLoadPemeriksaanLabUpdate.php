<?php

$periksa = PemeriksaanlabM::model()->findByPk($item->pemeriksaanlab_id);
$jenis = JenispemeriksaanlabM::model()->findByPk(($periksa->jenispemeriksaanlab_id));
// var_dump($item->attributes); die;

$tarif = (!empty($item->tarif_pelayananan)) ? $item->tarif_pelayananan : 0;

if($tarif>0){
?>
<tr id="periksalab_<?php echo $periksa->pemeriksaanlab_id; ?>">
    <?php if($jenis->jenispemeriksaanlab_kelompok == Params::PATOLOGI_KLINIK){ ?>
      <td>
        <?php echo $jenis->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $periksa->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
    </td>
    <td>
        <?php 
        echo $periksa->pemeriksaanlab_nama; 
        if (!empty($paket)) {
            echo '</br>('.$paket->tipepaket_nama.')';
        }
        ?>
        <?php echo CHtml::HiddenField("permintaanPenunjang[inputpemeriksaanlab][]", $periksa->pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php
         echo CHtml::textField("permintaanPenunjang[inputqty][]", $item->qtypermintaan, array('readonly'=>false,'class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal();',));
    ?>
        <?php // echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>

    <td>
        <?php echo MyFormatter::formatNumberForPrint($tarif); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::checkBox("permintaanPenunjang[is_cito][]", $item->is_cito, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);', 'class' => 'cek-cito')) ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[cito_true][]", "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>

    </td>
    <td>
        <?php
            echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalPeriksa(' . $periksa->pemeriksaanlab_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan kirim pasien', 'data-placement' => 'left'));
        ?>
    </td>
    
    <?php }else{ ?>
    
    <td>
        <?php echo $jenis->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[idDaftarTindakan][]", $item->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php // echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $periksa->pemeriksaanlab_nama; ?>
        <?php echo CHtml::HiddenField("permintaanPenunjangAnatomi[inputpemeriksaanlab][]", $item->pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
  
    <td><?php
        echo CHtml::textField("permintaanPenunjangAnatomi[inputqty][]", $item->qtypermintaan,array('readonly'=>false,'class'=>'inputFormTabel lebar1 integer gty span1', 'onkeyup'=>'hitungTotal2();',));      
    ?>
     <?php // echo CHtml::hiddenField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo MyFormatter::formatNumberForPrint($tarif); ?>
        <?php echo CHtml::textField("permintaanPenunjangAnatomi[inputtarifpemeriksaanlab][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::checkBox("permintaanPenunjangAnatomi[is_cito][]", $item->is_cito, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);', 'class' => 'cek-cito')) ?>
        <?php echo CHtml::hiddenField("permintaanPenunjangAnatomi[cito_true][]", "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>

    </td>
    <td>
        <?php
            echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalPeriksa(' . $item->pemeriksaanlab_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan kirim pasien', 'data-placement' => 'left'));
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
