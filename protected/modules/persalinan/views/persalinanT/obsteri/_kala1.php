<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modKala, 'kala_1_waktupemeriksaan', array('class' => 'control-label','label'=>'Waktu Pemeriksaan')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modKala,
                    'attribute' => 'kala_1_waktupemeriksaan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Petugas Pemeriksaan", 'kala_1_petugaspemeriksa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_1_petugaspemeriksa') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_1_petugaspemeriksa_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompletePetugasKala1') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($modKala, 'kala_1_petugaspemeriksa') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama pegawai',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_1_petugaspemeriksa') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugas_kala1'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("PPDS", 'kala_1_ppds_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_1_ppds_id') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_1_ppds_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompletePetugasKala1') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($modKala, 'kala_1_ppds_id') . '").val(ui.item.ppds_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama ppds',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_1_ppds_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPPDS_kala1'),
                ));
                ?>
            </div>
        </div>
      
        <?php echo $form->textAreaRow($modKala, 'kala_i_temuanlaten', array('class' => 'span3')); ?>
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($modKala, 'kala_i_partogram_gariswaspada', array()) ?> <label><?php echo $modKala->getAttributeLabel('kala_i_partogram_gariswaspada'); ?></label>
            </div>
        </div>
        <?php echo $form->textAreaRow($modKala, 'kala_i_masalahlain', array('class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($modKala, 'kala_i_penatalaksaan_masalah_tsb', array('class' => 'span3')); ?>
        <?php echo $form->textFieldRow($modKala, 'kala_i_hasilnya', array('class' => 'span3')); ?>        
    </div>
</div>