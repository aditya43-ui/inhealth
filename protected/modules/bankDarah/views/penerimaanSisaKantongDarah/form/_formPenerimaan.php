 <div class="control-group">
    <label class="control-label">Nomor Barcode</label>
    <div class="controls">
        <?php echo CHtml::textField("nokantongutama","",array('onblur'=>'loadKantongDarah(this);','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
    </div>
</div>