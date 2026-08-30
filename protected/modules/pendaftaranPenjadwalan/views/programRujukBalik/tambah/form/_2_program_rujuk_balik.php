
<div class="col-sm-6">
    <?= $form->hiddenField($model, 'sep_id',['class'=>'sep_id']) ?>
    <?= $form->hiddenField($model, 'pendaftaran_id',['class'=>'pendaftaran_id']) ?>
    
    <div class="control-group required">
        <label class='control-label'>Program PRB<span class='required'>*</span></label>
        <div class="controls">
            <?= $form->hiddenField($model, 'programprb_kode',['class'=>'programprb_kode required']) ?> 
            <?= $form->hiddenField($model, 'programprb_nama',['class'=>'programprb_nama required']) ?> 
            
            <?php                 
            echo $form->hiddenField($model,'sep_id',['class'=>'sep_id']);

            if (!$model->isNewRecord) {
                echo $form->textField($model, 'diagnosabpjskode', array('readonly'=>true));
            } else {

            

            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'diagnosabpjskode',                    
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('autoCompleteDiagnosaPRB') . '",
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
                    'focus' => 'js:function( event, ui ){
                        $(this).val(ui.item.label);
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        pilihDiagnosaPRB(ui.item);
                        return false;
                    }',
                ),
                'htmlOptions' => array(                        
                    'placeholder' => 'ketik program diagnosa prb',                        
                    'class' => 'span3 required diagnosabpjskode',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                    'onblur'=>'if(this.value==""){resetDiagnosaPRB();}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogDiagnosaPRB','jsFunction'=>'$("#dialogDiagnosaPRB").dialog("open");'),
            ));

            }
        ?>                    
        </div>
    </div>
    
    <div class="control-group required">
        <label class='control-label'>Dokter DPJP<span class='required'>*</span></label>
        <div class="controls">
            <?= $form->hiddenField($model, 'dpjp_id',['class'=>'dpjp_id required']) ?>             
            
            <?php                 
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'dpjp_nama',                    
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('autoCompleteDokterDPJP') . '",
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
                    'focus' => 'js:function( event, ui ){
                        $(this).val(ui.item.label);
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        pilihDokterDPJP(ui.item);
                        return false;
                    }',
                ),
                'htmlOptions' => array(                        
                    'placeholder' => 'ketik dokter dpjp',
                    'class' => 'span3 required dpjp_nama',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                    'onblur'=>'if(this.value==""){resetDokterDPJP();}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogDokterDPJP','jsFunction'=>'$("#dialogDokterDPJP").dialog("open");'),
            ));
        ?>                    
        </div>
    </div>
        
    <div class='control-group'>
        <label class='control-label'>Tanggal Pembuatan PRB<span class='required'>*</span></label>
        <div class='controls'>
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglbuat_prb',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",                        
                    ),
                'htmlOptions' => array(
                    'readonly'=>true,
                    'placeholder' => 'pilih tanggal pembuatan prb', 'class' => 'required dtPicker3 span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <?= $form->textAreaRow($model,'saran') ?> 
</div>

<div class="col-sm-6">    
    <?= $form->textAreaRow($model,'keterangan') ?> 
    <?= $form->textFieldRow($model,'user_pembuat',['readonly'=>true]) ?> 
</div>

<div class="clear"></div>