<div class="col-sm-6">
    <div class="control-group">
        <?php echo Chtml::label("No. Rencana", 'renkebbahanmakanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'renkebbahanmakanan_id',array('readonly'=>true)); ?>
            <?php echo $form->textField($model, 'renkebbahanmakanan_no',array('readonly'=>true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tgl. Rencana","",array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'renkebbahanmakanan_tgl',array('readonly'=>true,'empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Sumber Dana <span class='required'>*</span>","",array('class'=>'control-label')) ?>
        <div class="controls">
                <?php echo $form->hiddenField($model, 'sumberdana_id',array('class' => 'required span3','readonly'=>true)); ?>
                <?php echo $form->textField($model, 'sumberdanabhn',array('readonly'=>true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
