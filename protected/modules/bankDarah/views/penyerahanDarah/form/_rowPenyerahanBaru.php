<?php

$submodel = PenyerahandarahT::model()->findByAttributes(array(
    'penyiapandarah_id'=>$detail->penyiapandarah_id
));
$stok = StokkantongdarahT::model()->findByPk($item->stokkantongdarah_id);
$jenis = JeniskantongdarahM::model()->findByPk($stok->jeniskantongdarah_id);

?>
<tr>
    <td>
        <?php 
            $model->ceklis = $detail->ujikompatibilitas_id;            
            echo CHtml::activeCheckBox($model, '[detail]['.$detail->penyiapandarah_id.']ceklis',array('value'=>$detail->ujikompatibilitas_id)) ?>
    </td>
    <td>
        <label> <?php echo $item->nomorbarcode; ?></label>
    </td>    
</tr>