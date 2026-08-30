<?php 
    foreach($data as $tindKompId => $tindKomp){
        $cek=false;
        $disabled=false;

        if(!empty($tindKomp['pembebasantarif_id'])){
            $cek=true;
            $disabled=true;
        }
    ?>
        <tr class="detail_komp">
            <td>
                <?php echo CHtml::checkBox("Returtagihan[$tindKompId][tindkomponen_id]", $cek, array('class'=>'checklist','value'=>$tindKompId,'onchange'=>'changeReturTagihan(this, '.$tindKomp['tindakanpelayanan_id'].');','disabled'=>$disabled)); ?>
                <?php echo CHtml::hiddenField("Returtagihan[$tindKompId][tindakansudahbayar_id]", $tindKomp['tindakansudahbayar_id']); ?>
                <?php echo CHtml::hiddenField("Returtagihan[$tindKompId][komponentarif_id]", $tindKomp['komponentarif_id']); ?>
                <?php echo CHtml::hiddenField("Returtagihan[$tindKompId][pembebasantarif_id]", $tindKomp['pembebasantarif_id']); ?>
            </td>
            <td>
                <?php echo $tindKomp['komponentarif_nama']; ?>
            </td>
            <td>
                <?php echo CHtml::textField("Returtagihan[$tindKompId][tarif]", number_format($tindKomp['tarif_tindakankomp'], 0, ".", ","), array('readonly'=>true, 'class'=>'span2 integer','style'=>'text-align: right')); ?>
            </td>
            <td>
                <?php echo CHtml::textField("Returtagihan[$tindKompId][hargaretur]", number_format($tindKomp['jmlpembebasan'], 0, ".", ","), array('onblur'=>'hitungTotalRetur('.$tindKomp['tindakanpelayanan_id'].');', 'class'=>'span2 integer','style'=>'text-align: right')); ?>
            </td>
            <td>
                <?php echo CHtml::textField("Returtagihan[$tindKompId][tarif_setelahretur]", 0, array('readonly'=>true, 'class'=>'span2 integer','style'=>'text-align: right')); ?>
            </td>
        </tr>
    <?php 
    } 
?>


