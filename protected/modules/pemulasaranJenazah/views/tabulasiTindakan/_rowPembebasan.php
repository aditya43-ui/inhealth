<?php 
    foreach($data as $tindKompId => $tindKomp){
        $cek=false;

        if(!empty($tindKomp['pembebasantarif_id'])){
            $cek=true;
        }
    ?>
        <tr class="detail_komp">
            <td>
                <?php echo CHtml::checkBox("pembebasan[$tindKompId][tindkomponen_id]", $cek, array('class'=>'checklist','value'=>$tindKompId,'onchange'=>'changePembebasan(this, '.$tindKomp['tindakanpelayanan_id'].');')); ?>
                <?php echo CHtml::hiddenField("pembebasan[$tindKompId][tindakanpelayanan_id]", $tindKomp['tindakanpelayanan_id']); ?>
                <?php echo CHtml::hiddenField("pembebasan[$tindKompId][komponentarif_id]", $tindKomp['komponentarif_id']); ?>
                <?php echo CHtml::hiddenField("pembebasan[$tindKompId][pembebasantarif_id]", $tindKomp['pembebasantarif_id']); ?>
            </td>
            <td>
                <?php echo $tindKomp['komponentarif_nama']; ?>
            </td>
            <td>
                <?php echo CHtml::textField("pembebasan[$tindKompId][tarif]", MyFormatter::formatNumberForPrint($tindKomp['tarif_tindakankomp'],2), array('readonly'=>true, 'class'=>'span2 integer-decimal','style'=>'text-align: right')); ?>
            </td>
            <td>
                <?php echo CHtml::textField("pembebasan[$tindKompId][tarif_tindakankomp]", MyFormatter::formatNumberForPrint($tindKomp['jmlpembebasan'],2), array('onblur'=>'hitungTotalPembebasan('.$tindKomp['tindakanpelayanan_id'].');', 'class'=>'span2 integer-decimal','style'=>'text-align: right')); ?>
            </td>
            <td>
                <?php echo CHtml::textField("pembebasan[$tindKompId][tarif_setelahpembebasan]", MyFormatter::formatNumberForPrint(0,2), array('readonly'=>true, 'class'=>'span2 integer-decimal','style'=>'text-align: right')); ?>
            </td>
        </tr>
    <?php 
    } 
?>


