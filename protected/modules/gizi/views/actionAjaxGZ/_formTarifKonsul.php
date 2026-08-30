<?php
    $idKelasPelayan = $modTindakan->kelaspelayanan_id;
    $criteria = new CDbCriteria;
    $criteria->select = 'daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, t.daftartindakan_id, daftartindakan_m.daftartindakan_konsul,
                        daftartindakan_m.kelompoktindakan_id,daftartindakan_m.kategoritindakan_id,daftartindakan_m.kategoritindakan_id, t.tariftindakan_id,
                        t.kelaspelayanan_id, t.komponentarif_id, t.jenistarif_id, t.perdatarif_id, t.harga_tariftindakan, t.persendiskon_tind, t.hargadiskon_tind, t.persencyto_tind';
    
    $criteria->compare('daftartindakan_m.daftartindakan_konsul',true);
    $criteria->compare('t.kelaspelayanan_id',$idKelasPelayan,true);
    
    $criteria->join = 'LEFT JOIN daftartindakan_m ON t.daftartindakan_id = daftartindakan_m.daftartindakan_id';
    
    $tarifTindakan = TariftindakanM::model()->findAll($criteria);
   
    ?>
<?php
//    $cyto = $tarifTindakan->persencyto_tind;
//    $totCyto = ($cyto*$tarifTindakan->harga_tariftindakan)/100;
//    if($modTindakan->harga_tariftindakan<=0){
//       echo "<script> myAlert('Tarif Kosong');window.close();</script>";
//    } else {
//      
//    }  
?>
<?php
    foreach($modTindakan as $i=>$data){
       $totCyto = (($data->persencyto_tind * $data->harga_tariftindakan) / 100);
?>
    <tr id="periksalab_<?php echo $idKelasPelayan; ?>">
        <td><?php echo CHtml::checkBox('GZTindakanKomponenT[cek][]',true);?></td>    
        <td>
            <?php echo $data->daftartindakan_nama; ?>
            <br>
        </td>
        <td>
            <?php echo CHtml::hiddenField("GZTindakanKomponenT[$idKelasPelayan][daftartindakan_id]", $data->daftartindakan_id,array('class'=>'inputFormTabel lebar1','readonly'=>true)); ?>
            <?php // echo CHtml::hiddenField("GZTindakanKomponenT[$idKelasPelayan][komponentarif_id]", $data->komponentarif_id,array('class'=>'inputFormTabel lebar1','readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("GZTindakanKomponenT[$idKelasPelayan][kelaspelayanan_id]", $idKelasPelayan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
            <?php echo CHtml::textField("GZTindakanKomponenT[$idKelasPelayan][tarif_tindakan]", $data->harga_tariftindakan,array('class'=>'inputFormTabel lebar2','readonly'=>true)); ?>
        </td>
        <td><?php echo CHtml::textField("GZTindakanKomponenT[$idKelasPelayan][qty_tindakan]", '1',array('class'=>'inputFormTabel lebar1')); ?></td>
        <td><?php echo CHtml::dropDownList("GZTindakanKomponenT[$idKelasPelayan][satuantindakan]",'',LookupM::getItems('satuantindakan'),array('style'=>'width:70px;','id'=>'satuan')) ?></td>
        <td><?php echo CHtml::dropDownList("GZTindakanKomponenT[$idKelasPelayan][cyto_tindakan]",0,array(1=>'Ya',0=>'Tidak'),array('style'=>'width:70px', 'class'=>'cyto_tindakan', 'onClick'=>'cekcyto(this,'.$data->daftartindakan_id.')')) ?></td>
        <td><?php echo CHtml::textField("GZTindakanKomponenT[$idKelasPelayan][tarif_cyto]", $totCyto,array('class'=>'inputFormTabel lebar2 cyto_'.$data->daftartindakan_id, 'style' => 'display:none')); ?></td>
    </tr>
<?php } ?>