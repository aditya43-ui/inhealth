<?php echo $form->textFieldRow($modSetor,'nostruksetor',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <div class='control-label'>Tanggal Setor ke Bank</div>
    <div class="controls">  
        <?php
            $this->widget('MyDateTimePicker',
                array(
                    'model'=>$modSetor,
                    'attribute'=>'tgldisetor',
                    'mode'=>'date',
                    'options'=>array(
                        'dateFormat'=>Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array('readonly' => true,
                    'onkeypress'=>"return $(this).focusNextInputField(event)"),
                )
            );
        ?>
    </div>
</div>                
<?php echo $form->textFieldRow($modSetor,'namabank',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modSetor,'atasnama',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modSetor,'norekening',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modSetor,'jumlahsetoran',array('class'=>'span3 currency','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->hiddenField($modSetor,'ygmenyetor_id'); ?>
<?php echo $form->hiddenField($modSetor,'create_loginpemakai_id'); ?>
