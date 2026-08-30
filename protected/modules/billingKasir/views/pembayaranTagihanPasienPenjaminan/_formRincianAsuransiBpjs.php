<?php

$kelas = KelaspelayananM::model()->findByPk($kelaspelayanan_id);

?>

<div class="control-group hidden">
    <?php echo CHtml::label("INA ".$kelas->kelaspelayanan_nama,'tanggungan_'.$kelaspelayanan_id,array('class'=>'control-label', 'style'=>'font-weight: bold;')); ?>
    <div class="controls">
        <?php echo CHtml::textField('subsidiasuransi['.$kelaspelayanan_id.']', 0, array(
            'readonly'=>$carabayar_id <> Params::CARABAYAR_ID_BPJS,
            'data-kelaspelayanan_id'=>$kelaspelayanan_id,
            'data-weight'=>Params::kelasPelayananNilai($kelaspelayanan_id),
            'data-idx'=>$idx,
            'class'=>'span2 integer-decimal_old integer2 subsidi_asuransi subsidi_bpjs',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'style'=>'font-weight:bold;',
            'onblur'=>'hitungJmlpembayaran()',
        )); ?>
    </div>
</div>
