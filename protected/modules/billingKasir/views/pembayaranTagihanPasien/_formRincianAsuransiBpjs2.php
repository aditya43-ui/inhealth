<div class="form_inacbg">
    <div class="control-group">
        <?php echo CHtml::label("Inacbg Kelas Pelayanan",'inacbg_kelaspelayanan',array('class'=>'control-label', 'style'=>'font-weight: bold;')); ?>
        <div class="controls">
            <?php echo CHtml::textField('inacbg_kelaspelayanan', 0, array(
                'readonly'=>true,
                'class'=>'span2 integer-decimal_old integer2 subsidi_asuransi subsidi_bpjs',
                'onkeyup'=>"return $(this).focusNextInputField(event);",
                'style'=>'font-weight:bold;',
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Inacbg Kelas Tanggungan",'inacbg_kelastanggungan',array('class'=>'control-label', 'style'=>'font-weight: bold;')); ?>
        <div class="controls">
            <?php echo CHtml::textField('inacbg_kelastanggungan', 0, array(
                'readonly'=>true,
                'class'=>'span2 integer-decimal_old integer2 subsidi_asuransi subsidi_bpjs',
                'onkeyup'=>"return $(this).focusNextInputField(event);",
                'style'=>'font-weight:bold;',
            )); ?>
        </div>
    </div>
</div>
