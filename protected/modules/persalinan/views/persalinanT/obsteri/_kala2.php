<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modKala, 'kala_2_waktupemeriksaan', array('class' => 'control-label','label'=>'Waktu Pemeriksaan')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modKala,
                    'attribute' => 'kala_2_waktupemeriksaan',
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
            <?php echo CHtml::label("Petugas Pemeriksaan", 'kala_2_petugaspemeriksa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_2_petugaspemeriksa') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_2_petugaspemeriksa_nama',
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
                            $("#' . Chtml::activeId($modKala, 'kala_2_petugaspemeriksa') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama pegawai',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_2_petugaspemeriksa') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugas_kala2'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("PPDS", 'kala_2_ppds_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_2_ppds_id') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_2_ppds_nama',
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
                            $("#' . Chtml::activeId($modKala, 'kala_2_ppds_id') . '").val(ui.item.ppds_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama ppds',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_2_ppds_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPPDS_kala2'),
                ));
                ?>
            </div>
        </div>
      

        <div class="control-group">
            <?php echo CHtml::label('Episotomi :', '', array('class' => 'control-label')) ?>
            <div class="controls">
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_ii_is_episotomi', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')); ?> <label>Ya Indikasi,</label>
            </div>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_ii_episotomo_indikasi', array('class' => 'span3 txtlain', 'readonly' => true)) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_ii_is_episotomi', array('uncheckValue' => null, 'value' => false)); ?> <label>Tidak</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Pendamping pada saat persalinan :', '', array('class' => 'control-label', 'style'=>'width: 200px')) ?>
            <div class="control-group">
                <div class="controls">
                    <?php echo $form->checkBox($modKala, 'kala_ii_suami') ?> <label>Suami</label>
                    <?php echo $form->checkBox($modKala, 'kala_ii_teman') ?> <label>Teman</label>
                    <?php echo $form->checkBox($modKala, 'kala_ii_tidak_ada') ?> <label>Tidak Ada</label>
                    <br />
                    <?php echo $form->checkBox($modKala, 'kala_ii_keluarga') ?> <label>Keluarga</label>
                    <?php echo $form->checkBox($modKala, 'kala_ii_dukun') ?> <label>Dukun</label>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Gawat Janin :', '', array('class' => 'control-label')) ?>
            <div class="controls">

            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_ii_is_gawatjanin', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')); ?> <label>Ya, tindakan yang dilakukan</label>
                <br>
                <?php echo $form->textArea($modKala, 'kala_ii_gawatjanin_tindakan', array('readonly' => true, 'class' => 'txtlain')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_ii_is_gawatjanin', array('uncheckValue' => null, 'value' => false)); ?> <label>Tidak</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($modKala, 'kala_ii_isperiksadjj',array('onchange'=>'setPeriksadjj_kala2(this)')) ?> <label>Pemantauan DJJ setiap 5-10 menit selama Kala II</label>
                <br />
                <label>Hasil</label>
                <?php echo $form->textArea($modKala, 'kala_ii_hasilpemantauandjj', array('class' => 'span3','readonly'=>true)); ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Distosia Bahu :', '', array('class' => 'control-label')) ?>
            <div class="controls">

            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_ii_is_distosiabahu', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')); ?> <label>Ya, tindakan yang dilakukan</label>
                <br>
                <?php echo $form->textArea($modKala, 'kala_ii_distosiabahu_tindakan', array('class' => 'txtlain')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_ii_is_distosiabahu', array('uncheckValue' => null, 'value' => false)); ?> <label>Tidak</label>
            </div>
        </div>
        <?php echo $form->textAreaRow($modKala, 'kala_ii_masalahlain', array('')) ?>
        <?php echo $form->textAreaRow($modKala, 'kala_ii_penatalaksaan_masalah_tsb', array('maxlength' => 150)) ?>
        <?php echo $form->textAreaRow($modKala, 'kala_ii_hasilnya', array('maxlength' => 150)) ?>        
        <div class="control-group">
            <?php echo CHtml::label('Pendarahan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_ii_jmlpendarahan', array('class' => 'span2 integer-decimal')); ?> <label>cc</label>
            </div>
        </div>        
    </div>
</div>