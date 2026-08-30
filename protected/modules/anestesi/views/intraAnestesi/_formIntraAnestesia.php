<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modIntraAnestesi,'nointraanestesi',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <div class="control-group ">
		<?php echo $form->labelEx($modIntraAnestesi,'tglintraanestesi', array('class'=>'control-label')) ?>
		<div class="controls">  
			<?php 
				$modIntraAnestesi->tglintraanestesi = (!empty($modIntraAnestesi->tglintraanestesi) ? date("d/m/Y H:i:s",strtotime($modIntraAnestesi->tglintraanestesi)) : date("d/m/Y H:i:s"));
				$this->widget('MyDateTimePicker',array(
					'model'=>$modIntraAnestesi,
					'attribute'=>'tglintraanestesi',
					'mode'=>'datetime',
					'options'=> array(
					'dateFormat'=>Params::DATE_FORMAT,
					'maxDate'=>'d',   
							),
					'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3 datetimemask',
					'onkeypress'=>"return $(this).focusNextInputField(event)"),
				)); 
			?>
		</div>
	</div>
    </div>
    <div class="col-sm-6">
        <?php // echo $form->checkBoxRow($modIntraAnestesi,'isdarurat',array()); ?>
        <div class="control-group">
                <?php echo CHtml::label("",'isdarurat', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'isdarurat',array('checked'=>'isdarurat')); ?> <label>Darurat</label>
                </div>				
            </div>
    </div>
</div>