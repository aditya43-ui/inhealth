<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Infeksi", 'inveksi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'nifas_inveksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'nifas_inveksi'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'laktasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'nifas_laktasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'nifas_laktasi'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'febris puerperalis', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'nifas_febris', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'nifas_febris'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'lain-lain', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'nifas_lainlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'nifas_lainlain'); ?>
            </div>
        </div>
    </div>
</div>