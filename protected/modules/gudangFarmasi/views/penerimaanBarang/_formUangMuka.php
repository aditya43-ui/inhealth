<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">            
            <?php echo $form->labelEx($modUangMuka,'namabank',array("class"=>"control-label"));?>
			<div class="controls">
			   <?php echo $form->textField($modUangMuka,'namabank',array('readonly'=>FALSE,'class'=>'span2 all-caps', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modUangMuka,'norekening',array("class"=>"control-label"));?>
			<div class="controls">
			   <?php echo $form->textField($modUangMuka,'norekening',array('readonly'=>FALSE,'class'=>'span2 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modUangMuka,'rekatasnama',array("class"=>"control-label"));?>
			<div class="controls">
			   <?php echo $form->textField($modUangMuka,'rekatasnama',array('readonly'=>FALSE,'class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
        </div>
    </div>
    <div class="col-sm-6">
		<div class="control-group ">
			<label class='control-label'>            
				<?php echo CHtml::checkBox('termasukUangMuka',false,array('onclick'=>'persenUangMuka(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))?>
				Persen Uang Muka
			</label>
			<div class="controls">
			   <?php echo $form->textField($modUangMuka,'persenuangmuka',array('readonly'=>FALSE,'class'=>'span2 float2', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onblur'=>'setUangMuka(this);','maxLength'=>3)); ?>
			</div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modUangMuka,'jumlahuang',array("class"=>"control-label"));?>
			<div class="controls">
			   <?php echo $form->textField($modUangMuka,'jumlahuang',array('readonly'=>FALSE,'class'=>'span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onblur'=>'setPersenUangMuka(this);')); ?>
			</div>
        </div>        
    </div>
</div>