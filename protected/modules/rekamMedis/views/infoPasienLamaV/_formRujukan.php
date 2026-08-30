 <?php echo $form->errorSummary($modRujukan); ?>
<fieldset class="">

        <?php echo $form->dropDownListRow($modRujukan,'asalrujukan_id', CHtml::listData($modRujukan->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modRujukan,'no_rujukan', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modRujukan,'nama_perujuk', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        
        <div class="control-group">
            <?php echo $form->labelEx($modRujukan,'tanggal_rujukan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$modRujukan,
                                        'attribute'=>'tanggal_rujukan',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                )); ?>
                <?php 
                echo $form->error($modRujukan, 'tanggal_rujukan'); ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($modRujukan,'diagnosa_rujukan', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?> 
	<div class="control-group">
                <?php echo $form->labelEx($modRujukan, 'diagnosa_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                            'model'=>$modRujukan,
                            'attribute'=>'diagnosa_rujukan',
                            'data'=> explode(',', $modRujukan->diagnosa_rujukan),   
                            'debugMode'=>true,
                            'options'=>array(
                                //'bricket'=>false,
                                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                                'addontab'=> true, 
                                'maxitems'=> 10,
                                'input_min_size'=> 0,
                                'cache'=> true,
                                'newel'=> true,
                                'addoncomma'=>true,
                                'select_all_text'=> "", 
                                'autoFocus'=>true,
                            ),
                            'htmlOptions'=>array('id'=>'diagnosaRujukan'),
                        ));
                    ?>
                    <?php echo $form->error($modRujukan, 'diagnosa_rujukan'); ?>
            </div>
</div>
</fieldset>
