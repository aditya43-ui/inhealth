<?php echo CHtml::hiddenField("jenisJabatan",'',array('readonly'=>true)) ?>
<div class="row-fluid">
    <span id="papa">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'pegawaipa_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawaipa_id', array('readonly' => true, 'class' => 'span4 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'pegawaipa_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
//                $this->widget('MyJuiAutoComplete', array(
//                    'model'=>$model,
//                    'attribute' => 'pegawaipa_nama',
//                    'source' => 'js: function(request, response) {
//                        $.ajax({
//                                url: "' . $this->createUrl('/actionAutoComplete/getPejabatPengadaan') . '",
//                                dataType: "json",
//                                data: {
//                                    term: request.term,                                                                                 
//                                    jabatan_pengadaan:"'.Params::JABATAN_PENGADAAN_PA.'"
//                                },
//                                success: function (data) {
//                                    response(data);
//                                }
//                        })
//                     }',
//                    'options' => array(
//                        'showAnim' => 'fold',
//                        'minLength' => 3,
//                        'focus' => 'js:function( event, ui ) {
//                            $(this).val(ui.item.label);
//                            return false;
//                        }',
//                        'select' => 'js:function( event, ui ) {                            
//                            setPejabatPengadaan(ui.item,"'.Params::JABATAN_PENGADAAN_PA.'");
//                            return false;
//                        }',
//                    ),
//                    'tombolDialog'=>array("idDialog"=>'dialogPA','jsFunction'=>'refreshPejabatPA();$("#dialogPA").dialog("open")'),
//                    'htmlOptions'=>array(   
//                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'pegawaipa_id').'").val("")}',
//                        'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Pejabat PA '),
//                ));
                ?>
            </div>
        </div>
    </div>
    </span>
    <span id="pakpa">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'pegawaikpa_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawaikpa_id', array('readonly' => true, 'class' => 'span4 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                //echo $form->textField($model, 'pegawaikpa_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pegawaikpa_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/getPejabatPengadaan') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,                                                                                 
                                    jabatan_pengadaan:"'.Params::JABATAN_PENGADAAN_KPA.'"
                                },
                                success: function (data) {
                                    response(data);
                                }
                        })
                     }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {                            
                            setPejabatPengadaan(ui.item,"'.Params::JABATAN_PENGADAAN_KPA.'");
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogPA','jsFunction'=>'refreshPejabatKPA();$("#dialogPA").dialog("open")'),
                    'htmlOptions'=>array(   
                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'pegawaikpa_id').'").val("")}',
                        'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Pejabat KPA '),
                ));
                ?>
            </div>
        </div>
    </div>
    </span>
    <div class="col-md-12" id="ppk">
        <div class="control-group">
            <?php echo $form->labelEx($model,'pegawaippk_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawaippk_id', array('readonly' => true, 'class' => 'span4 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pegawaippk_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/getPejabatPengadaan') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,                                                                                 
                                    jabatan_pengadaan:"'.Params::JABATAN_PENGADAAN_PPK.'"
                                },
                                success: function (data) {
                                    response(data);
                                }
                        })
                     }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {                            
                            setPejabatPengadaan(ui.item,"'.Params::JABATAN_PENGADAAN_PPK.'");
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogPPK','jsFunction'=>'refreshPejabatPPK();$("#dialogPA").dialog("open")'),
                    'htmlOptions'=>array(   
                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'pegawaippk_id').'").val("")}',
                        'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Pejabat PPK '),
                ));
                //echo $form->textField($model, 'pegawaippk_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
</div>