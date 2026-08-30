<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'luka_perineum', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'luka_perineum', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'luka_perineum'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'luka_vagina', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'luka_vagina', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'luka_vagina'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'luka_serviks', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'luka_serviks', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'luka_serviks'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'episiotomi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButtonList($modPemeriksaan,'episiotomi', LookupM::getItems('episiotomi'), array('class'=>'episiotomi','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'ruptura perinei', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPemeriksaan, 'rupturaperinei', LookupM::getItems('rupturaperinei'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'rupturaperinei'); ?>
            </div>
        </div>
    </div>
</div>