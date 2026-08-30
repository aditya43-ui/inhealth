<div class="control-group">
    <?php echo CHtml::label("Nama Bank Pengirim",'bank_id',array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
            $modBank = BankM::model()->findAll('bank_aktif = true ORDER BY namabank ASC');
            echo $form->dropDownList($modTandabukti, 'bank_id', CHtml::listData($modBank, 'bank_id', 'namabank'), array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank(this);',
                'onkeyup' => "return $(this).focusNextInputField(event);"));
        ?>
    </div>
</div>
<?php // echo CHtml::activeHiddenField($modTandabukti, 'melalubank',array('readonly'=>true, 'class'=>'span3')); ?>
<?php echo $form->textFieldRow($modTandabukti, 'denganrekening', array('class' => 'span3',
        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($modTandabukti, 'bank_nama', array('class' => 'span3',
    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>