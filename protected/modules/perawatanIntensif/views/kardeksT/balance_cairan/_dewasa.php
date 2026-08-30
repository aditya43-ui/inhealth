<div class="col-sm-6">
	<?php 
    $arr_konstanta = array();
    for ($i = 0; $i < 50; $i++) {
        $arr_konstanta[$i] = $i;
    }
    
    
    echo $form->dropDownListRow($model,'balance_konstanta',$arr_konstanta,array('class'=>'span1 float2 balance_konstanta', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'balance_beratbadan',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'balance_beratbadan',array('class'=>'span1 float2 balance_beratbadan', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <label>Kg</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model,'balance_iwl_jam',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'balance_iwl_jam',array('readonly'=>true,'class'=>'span1 float2 balance_iwl_jam', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <label>x</label>
            <?php echo $form->dropDownList($model,'balance_jam', array(1=>1, 2=>2, 3=>3, 4=>4,5=>5,6=>6, 7=>7,8=>8,9=>9,10=>10,11=>11,12=>12, 13=>13,14=>14,15=>15,16=>16,17=>17,18=>18,19=>19,20=>20,21=>21,22=>22,23=>23,24=>24), array('class'=>'span1 balance_jam', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'balance_iwl',array('readonly'=>true, 'class'=>'span2 float2 balance_iwl', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model,'balance_total_intake',array('class'=>'span2 float2neg balance_total_intake', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_output',array('class'=>'span2 float2neg balance_total_output', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_sekarang',array('readonly'=>true, 'class'=>'span2 float2 balance_total_sekarang', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_sebelum',array('class'=>'span2 float2neg balance_total_sebelum', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_komulatif',array('class'=>'span2 float2neg balance_total_komulatif', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <?php echo $form->textFieldRow($model,'balance_cairanmasuk',array('readonly'=>false, 'class'=>'span2 float2 balance_cairanmasuk', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php 
        $model->balance_konstanta_suhu = 10;
        echo $form->labelEx($model,'balance_konstanta_suhu',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'balance_konstanta_suhu',array('readonly'=>true,'class'=>'span1 float2 balance_konstanta_suhu', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <label>%</label>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'balance_kenaikan_suhu',array('class'=>'span2 float2 balance_kenaikan_suhu', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_iwl_kenaikan_suhu',array('readonly'=>true, 'class'=>'span2 float2 balance_iwl_kenaikan_suhu', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    
</div>	