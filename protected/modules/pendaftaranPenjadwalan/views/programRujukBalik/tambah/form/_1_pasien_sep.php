
<div class="col-sm-6">
    <div class="control-group required">
        <label class="control-label">No. SEP<span class="required">*</span></label>        
        <div class="controls">
            <?php                 
            echo $form->hiddenField($model,'sep_id',['class'=>'sep_id required']);
            echo $form->hiddenField($model,'tglsep',['class'=>'tglsep required']);
            echo $form->hiddenField($model,'jnspelayanan',['class'=>'jnspelayanan required']);

            if (!$model->isNewRecord) {
                echo $form->textField($model, 'nosep', array('readonly'=>true));
            } else {

            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nosep',                    
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('autoCompleteCariSep') . '",
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
                        setPasienSep(ui.item);
                        return false;
                    }',
                ),
                'htmlOptions' => array(                        
                    'placeholder' => 'ketik noo sep',                        
                    'class' => 'span3 required nosep',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                    'onblur'=>'if(this.value==""){resetPasienSep();}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogCariSep','jsFunction'=>'$("#dialogCariSep").dialog("open");refGridPasienSep();'),
            ));
            }
        ?>                    
        </div>
    </div>
    <?= $form->textFieldRow($model ,'no_pendaftaran',['class'=>'no_pendaftaran','disabled'=>true]) ?>
    <?= $form->textFieldRow($model ,'no_rekam_medik',['class'=>'no_rekam_medik','disabled'=>true]) ?>
    <?= $form->textFieldRow($model ,'tgl_pendaftaran',['class'=>'tgl_pendaftaran','disabled'=>true]) ?>
    <?= $form->textFieldRow($model ,'nokartuasuransi',['class'=>'nokartuasuransi','disabled'=>true]) ?>
</div>

<div class="col-sm-6">
    <?= $form->textFieldRow($model ,'nama_pasien',['class'=>'nama_pasien','disabled'=>true]) ?>
    <?= $form->textFieldRow($model ,'tanggal_lahir',['class'=>'tanggal_lahir','disabled'=>true]) ?>
    <?= $form->textFieldRow($model ,'jeniskelamin',['class'=>'jeniskelamin','disabled'=>true]) ?>
    <?= $form->textAreaRow($model ,'alamat_pasien',['class'=>'alamat_pasien','disabled'=>true]) ?>
    <div class="control-group required">
        <label class="control-label">Alamat Email<span class="required">*</span></label>        
        <div class="controls">
        <?php                 
            echo $form->textField($model,'alamatemail',['class'=>'alamat_email required']); ?>
        </div>
    </div>
</div>

<div class="clear"></div>