<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pencarian Data Permintaan Darah</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("No. Permintaan ITD<span class='required'>*</span> ",'no_permintaan', array('class' => 'control-label')) ?>
                <div class="controls">
        <?php
            echo $form->hiddenField($permintaan, 'permintaandarahpmi_id', array(
                'class'=>'permintaandarahpmi_id',
            ));
                
            $no_permintaan = $permintaan->no_permintaan;
                
            // --- kondisi jika ada data-nya
                
              
                
            // --- end
               
            if (empty($permintaan->permintaandarahpmi_id)){
            $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_permintaan',
                    'value'=>$no_permintaan,
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('autocompletePermintaanDarah').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                     'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 3,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.no_permintaan);
                                $(this).parents(".controls").find(".permintaandarahpmi_id").val(ui.item.value);
                                setPermintaan(ui.item.value);
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                        'disabled'=>false,
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span3 required no_permintaan',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialog_permintaan'),
                ));
            }else{
                echo $form->textField($permintaan,'no_permintaan',array('readonly'=>true, 'class'=>'span3'));
            }
        ?>
            
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("Tanggal Permintaan <span class='required'>*</span> ",'no_permintaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($permintaan, 'tgl_permintaan', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($permintaan, 'petugas_nama', array('class' => 'control-label', 'label'=>'Petugas')) ?>
                <div class="controls">
                    <?php echo $form->textField($permintaan, 'petugas_nama', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <?php // echo $form->textFieldRow($model,'suhu_diterima',array('class' => 'span3 float2')) ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($permintaan, 'instalasi_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                <?php echo $form->textField($permintaan, 'instalasi_nama', array(
                'readonly'=>true, 
                'class'=>'span3',
                'onblur'=>'return false;',
                )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($permintaan, 'ruangan_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                <?php echo $form->textField($permintaan, 'ruangan_nama', array(
                'readonly'=>true, 
                'class'=>'span3',
                'onblur'=>'return false;',
                )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($permintaan, 'keterangan_permintaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($permintaan, 'keterangan_permintaan', array(
                    'rows'=>3,
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>