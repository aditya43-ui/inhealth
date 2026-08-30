<style>
    .ubahinline > div > .radio{
        display: inline-block;
        padding-right:10px;
    }
</style>
<span class="span12" style="text-align: center" id="label_status"></span>
<div class="span12">
    <div class="control-group">
        <?php echo CHtml::label("Jenis Donor Darah <span class='required'>*</span>", 'kadar_hb', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->radioButtonList($modSeleksi, 'jenisdonor', LookupM::getItems('jenisdonor'), array('onkeyup' => "return $(this).focusNextInputField(event)",'class'=>'span1 seleksi req'));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tekanan Darah <span class='required'>*</span>", 'tekanandarah', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modSeleksi, 'td_systolic', array('placeholder' => 'systolic', 'class' => 'req span2 numbers-only seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);","maxlength"=>3)); ?>
            &nbsp;&nbsp;&nbsp;<label>/</label>&nbsp;&nbsp;&nbsp;
            <?php echo $form->textField($modSeleksi, 'td_diastoliic', array('placeholder' => 'diastolic', 'class' => 'req span2 numbers-only seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);","maxlength"=>3)); ?>
            &nbsp;&nbsp;&nbsp;<label>mmHg</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kadar Hemoglobin <span class='required'>*</span>", 'kadar_hb', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modSeleksi, 'kadar_hb', array('placeholder' => 'hb', 'class' => 'req span4 float seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);","maxlength"=>3)); ?>
            &nbsp;&nbsp;&nbsp;<label>g/dl</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Suhu Tubuh <span class='required'>*</span>", 'suhu_tubuh', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modSeleksi, 'suhu_tubuh', array('placeholder' => 'suhu', 'class' => 'req span4  float seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);","maxlength"=>3)); ?>
            &nbsp;&nbsp;&nbsp;<label>&#8451;</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Detak Nadi <span class='required'>*</span>", 'detaknadi', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modSeleksi, 'detaknadi', array('placeholder' => 'nadi', 'class' => 'req span4 numbers-only seleksi req', 'onkeyup' => "return $(this).focusNextInputField(event);","maxlength"=>3)); ?>
            &nbsp;&nbsp;&nbsp;<label>x/mnt</label>
        </div>
    </div>
    <div class="control-group ubahinline" >      
        <label class="control-label req">Gol Darah <span class="required">*</span></label>
        <div class="controls">
        <?php echo $form->radioButtonList($modSeleksi, 'gol_darah', array("A" => "A", "B" => "B", "O" => "O", "AB" => "AB"), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    
    <div class="control-group ubahinline" >  
        <label class="control-label req">Rhesus <span class="required">*</span></label>
        <div class="controls">
            <?php echo $form->radioButtonList($modSeleksi, 'rhesus', array("Positif" => "Positif", "Negatif" => "Negatif"), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>
