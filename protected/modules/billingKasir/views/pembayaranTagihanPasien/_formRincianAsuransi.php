

<div class="control-group">
    <?php echo CHtml::label("Total Tanggungan Asuransi", 'totalsubsidiasuransi',array('class'=>'control-label', 'style'=>'font-weight: bold;')); ?>
    <div class="controls">
        <?php echo CHtml::activeTextField(BKPembayaranpelayananT::model(),'totalsubsidiasuransi',array(
            'readonly'=>true,
            'class'=>'span2 integer-decimal_old integer2 subsidi_asuransi',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'onblur'=>$this->id == 'pembayaranTagihanPasienPenunjang' ? 'hitungSubsidiPenunjang()' : 'hitungJmlpembayaran()',
         )); ?>
    </div>
</div>
