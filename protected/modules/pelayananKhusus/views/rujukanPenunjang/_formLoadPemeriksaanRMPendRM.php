<?php
$idTindakanRM = $modPeriksaRM->tindakanrm_id;
$namaTindakan = $modPeriksaRM->tindakanrm_nama;
$jenisTindakan = $modPeriksaRM->jenistindakanrm->jenistindakanrm_nama;
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0 ;
$persen_cyto = (!empty($modTarif->persencyto_tind)) ? $modTarif->persencyto_tind : 0 ;
$idDaftarTindakan = $modPeriksaRM->daftartindakan_id;
if ($tarif > 0){
?>

<tr id="tindakan_<?php echo $idTindakanRM; ?>">
    <td><?php echo CHtml::checkBox('ceklis[]',true,array('value'=>$idTindakanRM,'class'=>'ceklis'));?></td>    
    <td>
        <?php echo $jenisTindakan; ?>
        <br/>
        <span><?php echo $namaTindakan; ?></span>
        <?php echo CHtml::hiddenField("RMTindakanPelayananT[daftartindakan_id][".$idTindakanRM."]", $idDaftarTindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("RMTindakanPelayananT[kelaspelayanan_id][".$idTindakanRM."]", $idKelasPelayanan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("tindakanrm_id[".$idTindakanRM."]", $idTindakanRM,array('class'=>'inputFormTabel','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::textField("RMTindakanPelayananT[tarif_tindakan][".$idTindakanRM."]", $tarif,array('class'=>'inputFormTabel lebar3','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("RMTindakanPelayananT[qty_tindakan][".$idTindakanRM."]", '1',array('class'=>'inputFormTabel lebar3','readonly'=>true)); ?></td>
    <td><?php echo CHtml::dropDownList('RMTindakanPelayananT[satuantindakan]['.$idTindakanRM.']','KALI',LookupM::getItems('satuantindakan'),array('style'=>'width:70px;','empty'=>'-Pilih-')) ?></td>
    <td>
        <?php echo CHtml::dropDownList('RMTindakanPelayananT[cyto_tindakan]['.$idTindakanRM.']',0,array(1=>'Ya',0=>'Tidak'),array('style'=>'width:70px;','onchange'=>'hitungCyto('.$idTindakanRM.',this.value)')) ?>
        <?php echo CHtml::hiddenField("RMTindakanPelayananT[persencyto_tind][".$idTindakanRM."]", $persen_cyto,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php echo CHtml::textField("RMTindakanPelayananT[tarif_cyto][".$idTindakanRM."]", '0',array('class'=>'inputFormTabel lebar3')); ?></td>
</tr>
<?php } ?>