<?php if(count((array)$modTindakan) > 0){ ?>
<?php foreach ($modTindakan as $i => $tindakan) { ?>
<?php $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$tindakan->daftartindakan_id,
                                                                        'kelaspelayanan_id'=>$idKelasPelayanan,
                                                                        'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL)); 
            //echo (!empty($modTarif->harga_tariftindakan))? number_format($modTarif->harga_tariftindakan):'0';
        ?>
<tr>
    <td><?php echo CHtml::checkBox("permintaanPenunjang[$i][cbTindakan]", false, array('class'=>'ceklis','onclick'=>'ceklist(this)')) ?></td>
    <td>
        <?php echo $tindakan->daftartindakan->daftartindakan_nama; ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[$i][idDaftarTindakan]", $tindakan->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
        <?php echo CHtml::hiddenField("permintaanPenunjang[$i][tarifPelayanan]", (!empty($modTarif->harga_tariftindakan))? ($modTarif->harga_tariftindakan):'0',array('class'=>'inputFormTabel tarifPelayanan','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("permintaanPenunjang[$i][cyto]", (!empty($modTarif->persencyto_tind))? ($modTarif->persencyto_tind):'0',array('class'=>'inputFormTabel persenCyto','readonly'=>true)); ?>
</tr>
<?php } ?>
    <?php }else{ ?>
<tr>
    <td colspan="2">Data Pelayanan tidak ditemukan</td>
</tr>
<?php } ?>


