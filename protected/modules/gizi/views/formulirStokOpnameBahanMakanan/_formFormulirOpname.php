<div class="row form-horizontal">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglformulir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tglformulir', array('class' => 'span3', 'readonly' => true)) ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model, 'noformulir', array('readonly'=>true,'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'totalvolume', array('class' => 'span1 integer2', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'text-align:right;')); ?>
        <?php // echo (Params::cekHiddenHargaGudangFarmasi()==true)?$form->textFieldRow($model, 'totalharga', array('class' => 'span2 integer2', 'readonly' => true,'onkeyup' => "return $(this).focusNextInputField(event);", 'text-align:right;')):$form->passwordFieldRow($model, 'totalharga', array('class' => 'span2 integer2', 'readonly' => true,'onkeyup' => "return $(this).focusNextInputField(event);", 'text-align:right;')); 
        ?>
    </div>
</div>