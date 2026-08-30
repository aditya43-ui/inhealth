<?php
$idTindakan = $modTindakan->tindakanrm_id;
$namaTindakan = $modTindakan->tindakanrm_nama;
$jenisTindakan = $modTindakan->jenistindakanrm->jenistindakanrm_nama;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
$persen_cyto = (!empty($modTarif->persencyto_tind)) ? $modTarif->persencyto_tind : 0 ;
$idDaftarTindakan=$modTindakan->daftartindakan_id;
?>

<tr id="tindakan_<?php echo $idTindakan; ?>">
    <td>
        <?php echo $jenisTindakan; ?> / 
        <br/>
        <span><?php echo $namaTindakan; ?></span>
        <?php echo CHtml::hiddenField("RMTindakanPelayananT[daftartindakan_id][]", $idDaftarTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("RMTindakanPelayananT[kelaspelayanan_id][]", $idKelasPelayanan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("tindakanrm_id[]", $idTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::textField("RMTindakanPelayananT[tarif_tindakan][]", $tarif,array('class'=>'inputFormTabel lebar3 currency','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("RMTindakanPelayananT[qty_tindakan][]", '1',array('class'=>'inputFormTabel lebar1')); ?></td>
    <td><?php echo CHtml::dropDownList('RMTindakanPelayananT[satuantindakan][]','KALI',LookupM::getItems('satuantindakan'),array('style'=>'width:70px;','empty'=>'-Pilih-','id'=>'satuan')) ?></td>
    <td>
        <?php echo CHtml::dropDownList('RMTindakanPelayananT[cyto_tindakan][]',0,array(1=>'Ya',0=>'Tidak'),array('style'=>'width:70px;','onchange'=>'hitungCyto('.$idTindakan.',this.value)')) ?>
        <?php echo CHtml::hiddenField("RMTindakanPelayananT[persencyto_tind][]", $persen_cyto,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("RMTindakanPelayananT[tarif_cyto][]", '0',array('class'=>'inputFormTabel lebar3')); ?></td>
</tr>
