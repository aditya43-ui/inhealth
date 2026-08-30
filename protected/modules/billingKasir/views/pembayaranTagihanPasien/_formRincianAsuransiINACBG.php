<?php

$ina_vip = "";

if ($kelaspelayanan->kelaspelayanan_id == Params::KELASPELAYANAN_ID_VIP) {
    $readonly = true;
    $ina_vip = "ina_vip";
}

?>

<div class="control-group">
    <?php echo CHtml::label("Total INA ".$kelaspelayanan->kelaspelayanan_nama, 'total_inacbg_2',array('class'=>'control-label', 'style'=>'font-weight: bold;')); ?>
    <div class="controls">
        <?php echo CHtml::activeTextField(BKPembayaranpelayananT::model(),'total_inacbg_2['.$kelaspelayanan->kelaspelayanan_id.']',array(
            'value'=>0,
            'readonly'=>$readonly,
            'class'=>'span2 integer-decimal_old integer2 total_inacbg total_inacbg_form '.$ina_vip,
            'data-index'=>1,
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'onblur'=>'hitungInaKelas()',
         )); ?>
    </div>
</div>
