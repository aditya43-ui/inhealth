<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<table id="formPembayaran">
<?php echo $form->hiddenField($model,'tandabuktikeluar_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <tr>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model,'tglbayarjasa', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'tglbayarjasa',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'nobayarjasa', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'nobayarjasa',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'totaltarif',array('readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'totaljasa',array('readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'totalbayarjasa',array('readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'totalsisajasa',array('readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>

