<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="white-container">
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'nama_pj', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPenanggungJawab, 'nama_pj', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'no_identitas', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPenanggungJawab, 'no_identitas', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'jeniskelamin', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPenanggungJawab, 'jeniskelamin', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'hubungankeluarga', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPenanggungJawab, 'hubungankeluarga', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'tgllahir_pj', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPenanggungJawab, 'tgllahir_pj', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'no_teleponpj', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPenanggungJawab, 'no_teleponpj', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'no_mobilepj', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPenanggungJawab, 'no_mobilepj', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($modPenanggungJawab, 'alamat_pj', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modPenanggungJawab, 'alamat_pj', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>

    </div>
</div>