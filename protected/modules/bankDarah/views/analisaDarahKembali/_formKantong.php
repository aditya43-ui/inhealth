<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Kantong Darah</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'returdarah_id', array(
                    'class'=>'control-label',
                    'label'=>'No. Kantong Darah'
                )); ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'returdarah_id', array(
                            'class'=>'returdarah_id',
                        ));

                        $no_kantongdarah = "";

                        // --- kondisi jika ada data-nya
                        if (!empty($model->ujikompatibilitas_id)) {
                            $kompat = UjikompatibilitasT::model()->findByPk($model->ujikompatibilitas_id);
                            $no_kantongdarah = $kompat->nomorbarcode;
                        }


                        // --- end

                        $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_kantongdarah',
                                'value'=>$no_kantongdarah,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompleteReturKantong').'",
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
                                            setReturDarah(ui.item);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                    'disabled'=>false,
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span3 no_kantongdarah',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogReturKantong'),
                            ));
                    ?>
            
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_pasien', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no_rekam_medik', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_rekam_medik', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'ruangan_nama', array('class' => 'control-label', 'label'=>'Ruangan')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'ruangan_nama', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'jenis_komponen_darah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'jenis_komponen_darah', array(
                    'readonly'=>true,
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Golongan Darah / Rhesus', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'golongan_darah', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Retur / Penerimaan Darah</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tgl_retur_darah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tgl_retur_darah', array(
                    'readonly'=>true,
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no_retur_darah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_retur_darah', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'asal_darah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'asal_darah', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'keterangan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keterangan', array(
                    'rows'=>3,
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'petugas_penerima_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'petugas_penerima_nama', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>