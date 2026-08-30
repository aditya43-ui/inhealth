<fieldset id="inputJurnalUmum">
    <legend class="rim2">Jurnal Umum</legend>
    <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'form-jurnal-umum',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event)'
                ),
                'focus'=>'#',
            )
        );
        
        $this->widget('application.extensions.moneymask.MMask',array(
            'element'=>'.currency',
            'currency'=>'PHP',
            'config'=>array(
                'symbol'=>'Rp',
                'defaultZero'=>true,
                'allowZero'=>true,
                'decimal'=>',',
                'thousands'=>'.',
                'precision'=>0,
            )
        ));
        
        $this->widget('application.extensions.moneymask.MMask', array(
            'element' => '.numbersOnly',
            'config' => array(
                'defaultZero' => true,
                'allowZero' => true,
                'decimal' => '.',
                'thousands' => '',
                'precision' => 0,
            )
        ));        
        
        $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <table>
        <tr>
            <td width="50%">
                <?php
                    echo $form->hiddenField(
                        $model,
                        "jurnalrekening_id",
                        array(
                            'class'=>'span1',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'readonly'=>false
                        )
                    );                                
                ?>
                
                <?php echo $form->dropDownListRow($model,'jenisjurnal_id', JenisjurnalM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'tglbuktijurnal', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tglbuktijurnal',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array(
                                    'class'=>'dtPicker2-5 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            ));
                        ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'nobuktijurnal',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
                <?php echo $form->textFieldRow($model,'kodejurnal',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'rekperiod_id', RekperiodM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm')); ?>
                <?php echo $form->textFieldRow($model,'noreferensi',array('class'=>'span3 reqForm numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'tglreferensi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tglreferensi',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array(
                                    'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            ));
                        ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'nobku',array('class'=>'span3 reqForm numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
                <?php echo $form->textAreaRow($model,'urianjurnal',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
    </table>