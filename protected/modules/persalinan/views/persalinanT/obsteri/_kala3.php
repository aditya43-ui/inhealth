<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modKala, 'kala_3_waktupemeriksaan', array('class' => 'control-label','label'=>'Waktu Pemeriksaan')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modKala,
                    'attribute' => 'kala_3_waktupemeriksaan',
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
            <?php echo CHtml::label("Petugas Pemeriksaan", 'kala_3_petugaspemeriksa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_3_petugaspemeriksa') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_3_petugaspemeriksa_nama',
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
                            $("#' . Chtml::activeId($modKala, 'kala_3_petugaspemeriksa') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama pegawai',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_3_petugaspemeriksa') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugas_kala3'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("PPDS", 'kala_3_ppds_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modKala,'kala_3_ppds_id') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modKala,
                    'attribute' => 'kala_3_ppds_nama',
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
                            $("#' . Chtml::activeId($modKala, 'kala_3_ppds_id') . '").val(ui.item.ppds_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama ppds',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modKala, 'kala_3_ppds_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPPDS_kala3'),
                ));
                ?>
            </div>
        </div>
      
        <div class="control-group">
            <?php echo CHtml::label('Inisiasi Menyusui Dini', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_isimd', array('uncheckValue' => null, 'value' => 'Ya', 'class' => 'kala_iii_isimd', 'onchange'=>'changeismenyusuidini_kala3()')); ?> <label>Ya</label>
                <br/>
                <?php echo $form->radioButton($modKala, 'kala_iii_isimd', array('uncheckValue' => null, 'value' => 'Tidak', 'class' => 'kala_iii_isimd', 'onchange'=>'changeismenyusuidini_kala3()')); ?> <label>Tidak</label>
                <br/>
                <?php echo CHtml::label('Alasannya', '',array()); ?>
                <?php echo $form->textArea($modKala, 'kala_iii_alasantidak_imd', array('class' => 'span3', 'readonly' => true)) ?>
            </div>
        </div>     
        <div class="control-group">
            <?php echo CHtml::label('Lama kala III :', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_iii_lama', array('class' => 'span1')) ?> <label>menit</label>
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Pemberian Oksitosin 10 U/IM', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_beri_olsitosin', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')) ?> <label>Ya, waktu </label>
                <?php echo $form->textField($modKala, 'kala_iii_beri_olsitosin_waktu', array('class' => 'span1 txtlain', 'readonly' => true)) ?>
                <label>menit sesudah persalinan</label>
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_beri_olsitosin', array('uncheckValue' => null, 'value' => false, 'class' => 'adatext')) ?> <label>Tidak</label>
                <br/>
                <label>Alasannya</label>
                <?php echo $form->textArea($modKala, 'kala_iii_alasan_tidak_beri_olsitosin', array('class' => 'span3 txtlain', 'readonly' => true)) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <label>Penjepitan tali pusar</label>
                <?php echo $form->textField($modKala, 'kala_iii_penjepitaltalipusar', array('class' => 'span3', 'readonly' => true)) ?>
                <label>menit setelah bayi lahir</label>
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Pemberian Ulang Oksitosin(2x)?', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_beri_ulang_oksitosin', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')) ?> <label>Ya, alasan</label>
                <?php echo $form->textField($modKala, 'kala_iii_beri_ulang_oksitosin_alasan', array('class' => 'span3 txtlain', 'readonly' => true)) ?>
                <br/>
                <?php echo $form->radioButton($modKala, 'kala_iii_is_beri_ulang_oksitosin', array('uncheckValue' => null, 'value' => false)) ?> <label>Tidak</label>
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Penegangan tali pusat terkendali', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_penegangan_tali_pusat', array('uncheckValue' => null, 'value' => true)) ?> <label>Ya</label>
                <br />
                <?php echo $form->radioButton($modKala, 'kala_iii_is_penegangan_tali_pusat', array('uncheckValue' => null, 'value' => false, 'class' => 'adatext')) ?> <label>Tidak</label>
                <br />
                <label>Alasan</label>
                <?php echo $form->textArea($modKala, 'kala_iii_tidak_penegangan_talipusat_alasan', array('class' => 'span3 txtlain', 'readonly' => false)) ?>
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Massage Fundus Uteri', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_masase_fundusuteri', array('uncheckValue' => null, 'value' => true)) ?> <label>Ya</label>
                <br/>
                <?php echo $form->radioButton($modKala, 'kala_iii_is_masase_fundusuteri', array('uncheckValue' => null, 'value' => false, 'class' => 'adatext')) ?> <label>Tidak</label>
                <br/>
                <label>Alasan</label>
                <?php echo $form->textArea($modKala, 'kala_iii_masase_fundusuteri_alasantidak', array('class' => 'span4 txtlain', 'readonly' => false)) ?>
            </div>
        </div>

        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Plasenta lahir lengkap (intact)', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_plasenta_lahirlengkap', array('uncheckValue' => null, 'value' => true)) ?> <label>Ya</label>
                <br>
                <?php echo $form->radioButton($modKala, 'kala_iii_is_plasenta_lahirlengkap', array('uncheckValue' => null, 'value' => false, 'class' => 'adatext')) ?> <label>Tidak, Tindakan yang dilakukan</label>
                <br>
                <?php echo $form->textArea($modKala, 'kala_iii_plasenta_lahirlengkap_tidak_ket', array('class' => 'span4 txtlain', 'readonly' => true)) ?>
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Plasenta tidak lahir > 30 menit', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_plasenta_tidak_lahirlebih30mnt', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')) ?> <label>Ya, tindakan :</label>
                <br>
                <?php echo $form->textArea($modKala, 'kala_iii_plasenta_tidak_lahirlebih30mnt_ya_ket', array('class' => 'span4 txtlain', 'readonly' => true)) ?>
                <br>
                <?php echo $form->radioButton($modKala, 'kala_iii_is_plasenta_tidak_lahirlebih30mnt', array('uncheckValue' => null, 'value' => false, 'class' => 'adatext')) ?> <label>Tidak</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Laserasi:', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_laserasi', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')) ?> <label>Ya, dimana :</label>
                <?php echo $form->textField($modKala, 'kala_iii_laserasi_ya_dimana', array('class' => 'span4 txtlain', 'readonly' => true)) ?>
                <br />
                <?php echo $form->radioButton($modKala, 'kala_iii_is_laserasi', array('uncheckValue' => null, 'value' => false)) ?> <label>Tidak</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Jika laserasi perineum', '', array('class' => 'control-label')) ?>
            <div class="controls">
            </div>
        </div>
        <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label', 'style'=>'width:50px')) ?>
            <?php echo CHtml::label('Derajat', '', array('class' => 'control-label', 'style'=>'width:70px')) ?>
            <div class="controls">
                <?php echo $form->radioButtonList($modKala, 'kala_iii_laserasi_perineum_derajat',array('1'=>'1','2'=>'2','3'=>'3','4'=>'4'), array('class' => 'kala_iii_laserasi_perineum_derajat')) ?>
            </div>
        </div>

        <div class="control-group pilih-cb">
        <?php echo CHtml::label('', '', array('class' => 'control-label', 'style'=>'width:50px')) ?>
            <?php echo CHtml::label('Tindakan', '', array('class' => 'control-label', 'style'=>'width:70px')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_laserasi_perineum_penjahitan', array('uncheckValue' => null, 'value' => 0)) ?> <label>Penjahitan, tanpa anestesi</label> <br/>
                <?php echo $form->radioButton($modKala, 'kala_iii_is_laserasi_perineum_penjahitan', array('uncheckValue' => null, 'value' => 1)) ?> <label>Penjahitan, dengan anestesi</label><br/>
                <?php echo $form->radioButton($modKala, 'kala_iii_is_laserasi_perineum_penjahitan', array('uncheckValue' => null, 'value' => 2, 'class' => 'adatext')) ?> <label>Tidak dijahit, alasan</label><br/>
                <?php echo $form->textArea($modKala, 'kala_iii_tidak_laserasi_perineum_penjahitan_alasan', array('class' => 'span4 txtlain', 'readonly' => true)) ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('PMTCT (Prevention Mother to Child Transmissin)', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_pmtct', array('uncheckValue' => null, 'value' => 'Ya', 'class' => 'kala_iii_pmtct', 'onchange'=>'changeispmtct_kala3()')); ?> <label>Ya</label>
                <br/>
                <?php echo $form->radioButton($modKala, 'kala_iii_pmtct', array('uncheckValue' => null, 'value' => 'Tidak', 'class' => 'kala_iii_pmtct', 'onchange'=>'changeispmtct_kala3()')); ?> <label>Tidak</label>
                <br/>
                <label>Alasan</label>
                <?php echo $form->textArea($modKala, 'kala_iii_isalasantindakpmtct', array('class' => 'span3', 'readonly' => true)) ?>
            </div>
        </div>
        <div class="control-group pilih-cb">
            <?php echo CHtml::label('Atoni uteri:', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($modKala, 'kala_iii_is_atoni_uteri', array('uncheckValue' => null, 'value' => true, 'class' => 'adatext')) ?> <label>Ya, tindakan :</label>
                <br>
                <?php echo $form->textArea($modKala, 'kala_iii_ya_atoni_uteri_tindakan', array('class' => 'span4 txtlain', 'readonly' => true)) ?><br>
                <?php echo $form->radioButton($modKala, 'kala_iii_is_atoni_uteri', array('uncheckValue' => null, 'value' => false)) ?> <label>Tidak</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jumlah Pendarahan :', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_iii_jumlah_pendarahan', array('class' => 'span2 numbers-only')) ?>
            </div>
            <div class="controls">
                <label>ml</label>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label('Masalah lain, sebutkan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_iii_masalah_lain', array('class' => 'span4')) ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Penatalaksanaan masalah tersebut :', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modKala, 'kala_iii_penatalaksaan_masalah_tsb', array('class' => 'span4')) ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Hasilnya :', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKala, 'kala_iii_hasilnya', array('class' => 'span4')) ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="col-sm-6">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
                Plasenta
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
                <div class="control-group">
                    <?php
                    echo $form->labelEx($modPemeriksaan, 'lahir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaan,
                            'attribute' => 'plasenta_lahir',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'spontanitas', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'plasentaspontanitas', LookupM::getItems('plasenta_spontanitas'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'plasentaspontanitas'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'kelengkapan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'plasentakelengkapan', LookupM::getItems('plasenta_kelengkapan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'plasentakelengkapan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'berat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'plasenta_berat', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'><label>gram</label></div>
                        <?php echo $form->error($modPemeriksaan, 'plasenta_berat'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'diameter', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'plasenta_diameter', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'><label>cm</label></div>
                        <?php echo $form->error($modPemeriksaan, 'plasenta_diameter'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
                Tali Pusat
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'insersi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_insersi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_insersi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'panjang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_panjang', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'><label>cm</label></div>
                        <?php echo $form->error($modPemeriksaan, 'pusar_panjang'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'kelengkapan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'pusar_kelengkapan', LookupM::getItems('plasenta_kelengkapan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_kelengkapan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'robekan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_robekan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_robekan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaan, 'lain-lain', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_lainlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_lainlain'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>