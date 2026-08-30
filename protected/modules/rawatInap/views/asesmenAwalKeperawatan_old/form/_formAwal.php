<div class="col-sm-6">
   <div class="control-group">
        <?php echo $form->labelEx($model,'tgl_asesmen_keperawatan',array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_asesmen_keperawatan',
                        'value'=>null,
                        'mode' => 'datetime',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class'=>'span3 htpd',
                        ),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
                    <?php echo CHtml::label('Diagnosa Masuk RS <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'diagnosa_masuk', array('readonly' => true));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'diagnosa_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/diagnosa') . '",
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
                                              $("#RIAsesmenAwalKeperawatanT_diagnosa_nama").val(ui.item.diagnosa_nama);
                                              $("#RIAsesmenAwalKeperawatanT_diagnosa_masuk").val(ui.item.diagnosa_id);
                                                    return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
//                                          $("#RIAsesmenAwalKeperawatanT_diagnosa_nama").val(ui.item.diagnosa_nama);
//                                          $("#RIAsesmenAwalKeperawatanT_diagnosa_masuk").val(ui.item.diagnosa_id);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('placeholder' => 'Nama Diagnosa', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'onblur' => 'if(this.value == ""){$("#RIAsesmenAwalKeperawatanT_diagnosa_masuk").val("");}'),
                            'tombolDialog' => array('idDialog' => 'diagnosa-dialog'),
                        ));
                        ?>
                    </div>
                </div> 
    <div class="control-group">
        <label class="control-label"> Alasan Masuk RS <span class="required"> * </span></label>
        <div class="controls">
            <?php echo $form->textArea($model,'alasan_masuk',array('class'=>'autogrow required span3')); ?>
        </div>
    </div>
     
</div>


<div class="col-sm-6">
    <?php echo $form->textAreaRow($model,'riwayat_kesehatan',array('class'=>'autogrow')); ?>
    
    <div class="control-group">
        <label class="control-label">Pernah Dirawat</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'pernahdirawat_ya',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'pernahdirawat_tidak').'").removeAttr("checked");
                }
            ')); ?> <label>Ya</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'pernahdirawat_tidak',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'pernahdirawat_ya').'").removeAttr("checked");
                }
            ')); ?> <label>Tidak</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Obat dari Rumah</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'obatdarirumah_ada',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'obatdarirumah_tidakada').'").removeAttr("checked");
                }
            ')); ?> <label>Ada</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'obatdarirumah_tidakada',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'obatdarirumah_ada').'").removeAttr("checked");
                }
            ')); ?> <label>Tidak Ada</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Berasal dari Daerah Endemik Malaria</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'dariedemikmalaria_ya',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'dariedemikmalaria_tidak').'").removeAttr("checked");
                }
            ')); ?> <label>Ya</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'dariedemikmalaria_tidak',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'dariedemikmalaria_ya').'").removeAttr("checked");
                }
            ')); ?> <label>Tidak</label>
        </div>
    </div>
</div>