 <fieldset>
<legend> Data Penilaian Pegawai </legend>
<table>
    <tbody>
        <tr>
            <td colspan ="2">
                <div class="control-group">
                    <?php // echo $form->labelEx($modNilai, 'tglpenilaian', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$modNilai,
                                                'attribute'=>'tglpenilaian',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?> 
                    </div>
                </div>
                
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modNilai, 'periodepenilaian', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$modNilai,
                                                'attribute'=>'periodepenilaian',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?> 
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modNilai, 'sampaidengan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$modNilai,
                                                'attribute'=>'sampaidengan',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?> 
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->textFieldRow($modNilai, 'kesetiaan', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modNilai, 'prestasikerja', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modNilai, 'tanggungjawab', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modNilai, 'ketaatan', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modNilai, 'kejujuran', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modNilai, 'kerjasama', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modNilai, 'prakarsa', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modNilai, 'kepemimpinan', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                </td>
            <td>
                <?php echo $form->textFieldRow($modNilai, 'jumlahpenilaian', array('class' => 'span3 totalNilai', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                 <?php echo $form->textFieldRow($modNilai,'nilairatapenilaian',array('class'=>'span3 rataNilai', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>True)); ?>
            <?php echo $form->textFieldRow($modNilai,'performanceindex',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </tfoot>
</table>

<table>
    <tr>
        <td>
            <?php echo $form->textAreaRow($modNilai,'penilaianpegawai_keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modNilai, 'tanggal_keberatanpegawai', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modNilai,
                                        'attribute'=>'tanggal_keberatanpegawai',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                 <?php echo $form->textArea($modNilai,'keberatanpegawai',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modNilai, 'diterimatanggalpegawai', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modNilai,
                                        'attribute'=>'diterimatanggalpegawai',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modNilai, 'diterimatanggalatasan', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modNilai,
                                        'attribute'=>'diterimatanggalatasan',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($modNilai, 'tanggapanpejabat', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modNilai,
                                        'attribute'=>'tanggal_tanggapanpejabat',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                 <?php echo $form->textArea($modNilai,'tanggapanpejabat',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modNilai, 'keputusanatasan', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modNilai,
                                        'attribute'=>'tanggal_keputusanatasan',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                 <?php echo $form->textArea($modNilai,'keputusanatasan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </td>
    </tr>
</table>

            
<table>
    <tr>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($modNilai, 'penilainama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$modNilai,
                        'attribute' => 'penilainama',
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
                                                                        $("#'.Chtml::activeId($modNilai, 'penilainama') . '").val(nama_pegawai); 
                                                                        return false;
                                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPenilai'),
                    ));
                    ?>
                    <?php echo $form->error($modNilai, 'penilainama'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modNilai,'penilainip',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($modNilai,'penilaipangkatgol',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($modNilai,'penilaijabatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($modNilai,'penilaiunitorganisasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($modNilai, 'pimpinannama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$modNilai,
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
                                                                        $("#'.Chtml::activeId($modNilai, 'pimpinannama') . '").val(nama_pegawai); 
                                                                        return false;
                                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPimpinan'),
                    ));
                    ?>
                    <?php echo $form->error($modNilai, 'pimpinannama'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modNilai,'pimpinannip',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($modNilai,'pimpinanpangkatgol',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($modNilai,'pimpinanjabatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($modNilai,'pimpinanunitorganisasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </td>
    </tr>
</table>
 </fieldset>