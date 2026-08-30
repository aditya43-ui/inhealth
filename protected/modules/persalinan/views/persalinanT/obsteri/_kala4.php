<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modKala, 'kala_4_waktupemeriksaan', array('class' => 'control-label','label'=>'Waktu Pemeriksaan')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modKala,
                    'attribute' => 'kala_4_waktupemeriksaan',
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
            <?php echo CHtml::label("PPDS", 'kala_4_ppds_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_4_ppds_id') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_4_ppds_nama',
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
                            $("#' . Chtml::activeId($modKala, 'kala_4_ppds_id') . '").val(ui.item.ppds_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama ppds',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_4_ppds_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPPDS_kala4'),
                ));
                ?>
            </div>
        </div>
      
        <div class="control-group">
            <?php echo CHtml::label('Keadaan Umum', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modKala, 'kala_iv_keadaanumum', array('class' => 'span3')) ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'anemia', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'kala4_anemia', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'kala4_anemia'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->LabelEx($modPemeriksaan, 'tekanan darah', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'kala4_systolic', array('class' => 'span1 numbersOnly systolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'setTekanan(this);', 'style' => 'text-align: right;')); ?><label>Mm</label>
                <?php
                echo $form->textField($modPemeriksaan, 'kala4_diastolic', array('onblur' => '', 'readonly' => false, 'class' => 'span1 numbersOnly diastolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'setTekanan(this);', 'style' => 'text-align: right;')); ?><label>Hg</label>
                &nbsp;
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::Label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $modPemeriksaan->kala4_tekanandarah = empty($modPemeriksaan->kala4_tekanandarah) ? "000 / 000" : $modPemeriksaan->kala4_tekanandarah;
                $this->widget('CMaskedTextField', array(
                    'model' => $modPemeriksaan,
                    'attribute' => 'kala4_tekanandarah',
                    'mask' => '999 / 999',
                    'placeholder' => '000 / 000',
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 td', 'style' => 'width:60px;', 'onkeypress' => "return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                ));
                ?> <label>Mm/Hg</label>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                <?php echo CHtml::textField('tekananDarah', '', array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->LabelEx($modPemeriksaan, 'mean arteri pressure', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modPemeriksaan, 'kala4_meanarteripressure', array('readonly' => true, 'class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Denyut Nadi", 'kala4_detaknadi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'kala4_detaknadi', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?> <label>/ Menit</label>
                <?php echo $form->error($modPemeriksaan, 'kala4_detaknadi'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
    <div class="control-group">
            <?php echo CHtml::label("Petugas Pemeriksaan", 'kala_4_petugaspemeriksa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_4_petugaspemeriksa') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_4_petugaspemeriksa_nama',
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
                            $("#' . Chtml::activeId($modKala, 'kala_4_petugaspemeriksa') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama pegawai',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_4_petugaspemeriksa') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugas_kala4'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'pernapasan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'kala4_pernapasan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?><label>x/ Menit</label>
                <?php echo $form->error($modPemeriksaan, 'kala4_pernapasan'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'tinggi fundus uteri', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'tinggifundus_uteri', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 25));
                ?>
                <?php echo $form->error($modPemeriksaan, 'tinggifundus_uteri'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'kontraksi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'kala4_kontraksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'kala4_kontraksi'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Masalah lain, sebutkan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_iv_masalah_lain', array('class' => 'span4')) ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Penatalaksanaan masalah tersebut :', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modKala, 'kala_iv_penatalaksaan_masalah_tsb', array('class' => 'span4')) ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Hasilnya :', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_iv_hasilnya', array('class' => 'span4')) ?>
            </div>
        </div>
    </div>
</div>