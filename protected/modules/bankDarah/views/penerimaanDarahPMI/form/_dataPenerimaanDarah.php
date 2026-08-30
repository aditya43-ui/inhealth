<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Penerimaan Darah</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tgl_penerimaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_penerimaan',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class'=>'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'tgl_penerimaan'); ?>
                            </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no_penerimaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_penerimaan', array(
                        'readonly'=>true, 
                        'class'=>'span3',
                        'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo CHtml::label("No. Permintaan PMI<span class='required'>*</span>", 'no_penerimaan_pmi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_penerimaan_pmi', array(                        
                        'class'=>'span3 required',
                        'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            
            <?php echo $form->textFieldRow($model,'suhu_diterima',array('class' => 'span3 float2')) ?>
        </div>
        <div class="col-sm-6">   
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'keterangan_penerimaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keterangan_penerimaan', array(
                        'rows'=>3, 
                        'class'=>'span3',
                        'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            
            <?php echo $form->textFieldRow($model,'petugas_pmi',array('class' => 'span3')) ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'petugas_penerima_id', array(
                    'class'=>'control-label',
                )); ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'petugas_penerima_id', array(
                            'class'=>'petugas_penerima_id',
                        ));

                        $petugas_penerima_nama = "";

                        // --- kondisi jika ada data-nya

                        if (!empty($model->petugas_penerima_id)) {
                            $peg = PegawaiM::model()->findByPk($model->petugas_penerima_id);
                            $model->petugas_penerima_nama = $peg->nama_pegawai;
                        }
                        echo $form->textField($model, 'petugas_penerima_nama', array(
                            'class'=>'span3',
                            'disabled' => true,
                            'onblur'=>'return false;',
                        )); 

                        
                    ?>
            
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'petugas_mengetahui_id', array(
                    'class'=>'control-label',
                )); ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'petugas_mengetahui_id', array(
                            'class'=>'petugas_mengetahui_id',
                        ));

                        $petugas_mengetahui_nama = "";

                        // --- kondisi jika ada data-nya

                        if (!empty($model->petugas_mengetahui_id)) {
                            $peg = PegawaiM::model()->findByPk($model->petugas_mengetahui_id);
                            $petugas_mengetahui_nama = $peg->nama_pegawai;
                        }

                        // --- end

                        $this->widget('MyJuiAutoComplete', array(
                                'name'=>'petugas_mengetahui_nama',
                                'value'=>$petugas_mengetahui_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompletePetugasMengetahui').'",
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
                                            $(this).val(ui.item.nama_pegawai);
                                            $(this).parents(".controls").find(".petugas_mengetahui_id").val(ui.item.value);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                    'disabled'=>false,
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span3 petugas_mengetahui_nama',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialog_mengetahui'),
                            ));
                    ?>
            
                </div>
            </div>
        </div>
    </div>
</div>