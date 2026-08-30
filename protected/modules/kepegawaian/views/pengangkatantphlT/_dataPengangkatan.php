<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'pengangkatantphl_noperjanjian',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
        <div class="control-group">
        <?php echo $form->labelEx($model,'pengangkatantphl_tmt', array('class'=>'control-label')) ?>
            <div class="controls">  
               <?php   
                $model->pengangkatantphl_tmt = (!empty($model->pengangkatantphl_tmt) ? date("d/m/Y",strtotime($model->pengangkatantphl_tmt)) : null);
                $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'pengangkatantphl_tmt',
                                        'mode'=>'date',
                                        'options'=> array(
    //                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'showOn' => false,
                                            'maxDate' => 'd',
                                            'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                )); ?>
                <?php echo $form->error($model, 'pengangkatantphl_tmt'); ?>
             </div>
        </div>
        <?php echo $form->textAreaRow($model,'pengangkatantphl_tugaspekerjaan',array('rows'=>7, 'cols'=>70, 'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>    
        <?php echo $form->textFieldRow($model,'pengangkatantphl_nosk',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
    </div>
    <div class="col-sm-6">  
        <div class="control-group">
            <?php echo $form->labelEx($model,'pengangkatantphl_tglsk', array('class'=>'control-label')) ?>
            <div class="controls">  
                <?php   
                $model->pengangkatantphl_tglsk = (!empty($model->pengangkatantphl_tglsk) ? date("d/m/Y",strtotime($model->pengangkatantphl_tglsk)) : null);
                $this->widget('MyDateTimePicker',array(
                                         'model'=>$model,
                                         'attribute'=>'pengangkatantphl_tglsk',
                                         'mode'=>'date',
                                         'options'=> array(
     //                                            'dateFormat'=>Params::DATE_FORMAT,
                                             'showOn' => false,
                                             'maxDate' => 'd',
                                             'yearRange'=> "-150:+0",
                                         ),
                                         'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                         ),
                )); ?>
                <?php echo $form->error($model, 'pengangkatantphl_tglsk'); ?>
             </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'pengangkatantphl_tmtsk', array('class'=>'control-label')) ?>
            <div class="controls">  
                <?php   
                $model->pengangkatantphl_tmtsk = (!empty($model->pengangkatantphl_tmtsk) ? date("d/m/Y",strtotime($model->pengangkatantphl_tmtsk)) : null);
                $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'pengangkatantphl_tmtsk',
                                        'mode'=>'date',
                                        'options'=> array(
    //                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'showOn' => false,
                                            'maxDate' => 'd',
                                            'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                )); ?>
                <?php echo $form->error($model, 'pengangkatantphl_tmtsk'); ?>
             </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'pengangkatantphl_noskterakhir',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
        <?php echo $form->textFieldRow($model,'pengangkatantphl_keterangan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
        <?php //echo $form->textFieldRow($model,'pimpinannama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pimpinannama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pimpinannama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                                }',
                        'select' => 'js:function( event, ui ) {
                                                                    $("#'.Chtml::activeId($model, 'pimpinannama') . '").val(nama_pegawai); 
                                                                    return false;
                                                                }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
                <?php echo $form->error($model, 'pimpinannama'); ?>
            </div>
        </div>
    </div>
</div>