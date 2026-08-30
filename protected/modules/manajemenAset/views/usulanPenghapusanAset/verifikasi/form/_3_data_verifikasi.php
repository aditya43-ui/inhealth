<div class="col-sm-6">
    <?= $form->textFieldRow($model,'tanggal_verifikasi',['class'=>'span3','readonly'=>true]) ?>        
    <div class="control-group ">        
        <label class="control-label">Lokasi Sementara</label>
        <div class="controls">
            <?php 
                $model->lokasi_id = null;
                echo $form->hiddenField($model, 'lokasisementara_id',['class'=>'lokasisementara_id required']); ?>   
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,                                        
                'attribute' => 'lokasisementara_nama',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('/actionAutoComplete/GetLokasiAset') . '",
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
                            setLokasi(ui.item)
                            return false;
                    }',
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => "Ketik Nama lokasi sementara ",
                    'class' => 'span3 lokasisementara_nama required',
                    'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasisementara_id') . '").val("")}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogLokasi'),    
            ));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6">    
    <?= $form->hiddenField($model,'pegverifikasi_id') ?>
    <?= $form->textFieldRow($model,'pegverifikasi_nama',['class'=>'span3','readonly'=>true]) ?>    
</div>