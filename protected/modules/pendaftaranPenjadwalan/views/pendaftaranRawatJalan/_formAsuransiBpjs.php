<style>
    .hidden {
        display: none;
    }
</style>
<div class="bpjs">
    <?php echo $form->hiddenField($modSep, 'sep_id', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modSep, 'tglsep', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $modSep->tglsep = MyFormatter::formatDateTimeForUser(empty($modSep->tglsep) ? date("Y-m-d") : date("Y-m-d", strtotime($modSep->tglsep)));
            $this->widget('MyDateTimePicker', array(
                'model' => $modSep,
                'attribute' => 'tglsep',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    //'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('class' => 'dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
            )); ?>
            <?php echo $form->error($modSep, 'tglsep'); ?>
        </div>
    </div>
    <?php if (!in_array(strtolower($this->id), array("pendaftaranrawatdarurat", "pendaftaranbayibarulahir", "pendaftaranrawatinapdarirjrd"))) { ?>
        <div class="control-group ">
            <?php echo CHtml::label("Jenis Rujukan", '', array('class' => 'control-label')) ?>
            <div class="controls form-inline">
                <?php
                $act = strtolower($this->id);

                if ($modSep->isNewRecord) {
                    if (in_array($act, array("pendaftaranrawatinapdarirjrd", "pendaftaranbayibarulahir"))) {
                        $modSep->jenisfaskes = 1;
                    } else {
                        $modSep->jenisfaskes = 2;
                    }
                }

                echo $form->radioButtonList($modSep, 'jenisfaskes', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'jenisfaskes', 'onchange' => 'setAsalRujukan()'));

                ?>
            </div>
        </div>
        <?php echo $form->hiddenField($modSep, 'jenisfaskes', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <?php } ?>
    <?php /* if($this->id == "pendaftaranRawatDarurat"){ ?>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanBpjs,'no_rujukan', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($modRujukanBpjs,'no_rujukan',array('placeholder'=>'Ketik Nomor Rujukan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    </div>
</div>
<?php } */ ?>
    <div class="control-group">
        <?php echo CHtml::label("Cari " . $modAsuransiPasien->getAttributeLabel('nopeserta') . " <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#" . CHtml::activeId($modAsuransiPasien, "nopeserta") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modAsuransiPasien,
                'attribute' => 'nopeserta',
                'source' => 'js: function(request, response) {
                                                var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteAsuransi') . '",
                                                   dataType: "json",
                                                   data: {
                                                       nopeserta: request.term,
                                                       penjamin_id: penjamin_id,
                                                       pasien_id: pasien_id,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '").val(ui.item.nopeserta);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
                                            return false;
                                        }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik No. Peserta', 'rel' => 'tooltip', 'title' => 'Ketik No. Peserta', 'maxlength' => 13,
                    'onkeyup' => "setNoBpjs();return $(this).focusNextInputField(event)",
                    'onblur' => "",
                    'class' => 'numbers-only'
                ),
            ));
            ?>
            <?php echo $form->error($modAsuransiPasien, 'nopeserta'); ?>
            <?php echo $form->hiddenField($modAsuransiPasien, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Cari " . $modAsuransiPasien->getAttributeLabel('nokartuasuransi') . " <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modAsuransiPasien,
                'attribute' => 'nokartuasuransi',
                'source' => 'js: function(request, response) {
                                                var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteAsuransiKartu') . '",
                                                   dataType: "json",
                                                   data: {
                                                       nokartuasuransi: request.term,
                                                       penjamin_id: penjamin_id,
                                                       pasien_id: pasien_id,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 1,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '").val(ui.item.nopeserta);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                            $("#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
                                            getAsuransiNoKartu(ui.item.nokartuasuransi);
                                            setAsuransiLama();
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogAsuransiBpjs', 'jsFunction' => 'cekAsuransiBpjs()'),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik No. Kartu Asuransi Bpjs', 'rel' => 'tooltip', 'title' => 'Ketik No. Peserta', 'maxlength' => 13,
                    'onkeyup' => "setNoBpjsReverse();",
                    //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                    'class' => 'numbers-only'
                ),
            ));
            ?>
            <?php echo $form->error($modAsuransiPasien, 'nokartuasuransi'); ?>
        </div>
    </div>
    <?php //echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($modAsuransiPasien, 'namapemilikasuransi', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo CHtml::checkBox('pemilikasuransisesuai', false, array(
                'rel' => 'tooltip',
                'title' => 'Cek untuk disesuaikan dengan Nama Pasien',
                'onchange' => 'if ($(this).is(":checked")) {'
                    . '$("#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '").val($("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val());'
                    . '} else {'
                    . '$("#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '").val(pemilik_bpjs);'
                    . '}',
            )); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo $form->labelEx($modAsuransiPasien, 'jenispeserta_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modAsuransiPasien, 'jenispersertakode_bpjs'); ?>
            <?php echo $form->textField($modAsuransiPasien, 'jenispeserta_bpjs', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php // echo $form->dropDownList($modAsuransiPasien,'jenispeserta_id', CHtml::listData($modAsuransiPasien->getJenisPesertaItems(), 'jenispeserta_id', 'jenispeserta_nama'), 
            //                                      array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
            //                                            )); 
            ?>

            <?php // echo $form->error($modAsuransiPasien, 'jenispeserta_id'); 
            ?>
        </div>
    </div>
    <?php //echo $form->textFieldRow($modAsuransiPasien,'nomorpokokperusahaan',array('placeholder'=>'Nomor Pokok Perusahaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
    ?>
    <?php
    if (isset($statusMenu)) {
        $readOnlyRI = false;
        if (strtolower($this->id) == 'pendaftaranrawatinapdarirjrd') {
            $readOnlyRI = true;
        }
        echo $form->dropDownListRow($modAsuransiPasien, 'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekPerbedaanKelas(this);', 'readonly' => $readOnlyRI));
    } else {
        echo $form->dropDownListRow($modAsuransiPasien, 'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",));
    }
    ?>
    <?php if (strtolower($this->id) == 'pendaftaranrawatinapdarirjrd') {  ?>
        <div class="isnaikkelasRI">
            <div class="control-group">
                <?php echo CHtml::label($modSep->getAttributeLabel('penanggungjwb_naikkls_id') . "<span class='required'>*</span>", 'penanggungjwb_naikkls_id', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modSep, 'klsRawatNaik');
                    echo $form->dropDownList($modSep, 'penanggungjwb_naikkls_id', CHtml::listData(LookupM::model()->findAllByAttributes(array(
                        'lookup_type' => 'bpjs_penanggungjawab_naikkelas',
                    ), array(
                        'order' => 'lookup_urutan'
                    )), 'lookup_value', 'lookup_name'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'inputNamaPenjamin()'));

                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label($modSep->getAttributeLabel('penanggungjwb_naikkls_nama') . "<span class='required'>*</span>", 'penanggungjwb_naikkls_nama', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($modSep, 'penanggungjwb_naikkls_nama', array('placeholder' => 'Nama Penanggungjawab', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'rel' => 'tooltip', 'title' => 'Isi jika pasien naik Kelas', 'disabled' => true));
                    ?>
                </div>
            </div>
        </div>

    <?php } ?>
    <div class="control-group">
        <label class="control-label">Prolanis PRB</label>
        <div class="controls">
            <?php echo CHtml::textField("bpjs_prolanis", "-", array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Dinsos</label>
        <div class="controls">
            <?php echo CHtml::textField("bpjs_dinsos", "-", array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <?php if (!in_array($this->id, array("pendaftaranRawatDarurat", "pendaftaranRawatInapDariRJRD", "pendaftaranBayiBaruLahir"))) : ?>
        <div class="hidables">
            <div class="hidables-content">
                <div class="control-group">
                    <?php echo CHtml::label("Cari " . $modRujukanBpjs->getAttributeLabel('no_rujukan') . " <span class='required'>*</span> <i class=\"icon-search\" onclick=\"$('#dialogNoRujukan #norujukan').val($('#PPAsuransipasienbpjsM_nopeserta').val()); $('#dialogNoRujukan').dialog('open'); cariDataNoRujukan();\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modRujukanBpjs,
                            'attribute' => 'no_rujukan',
                            'options' => array(
                                'focus' => 'js:function( event, ui ) {
                                                     $(this).val("");
                                                     return false;
                                                 }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Ketik Nomor Rujukan',

                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => "",
                                'class' => 'angkahuruf-only'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
                    </div>
                    <?php
                    if (in_array($act, array("pendaftaranrawatjalan"))) {
                        echo CHtml::htmlButton('<i class="icon-search icon-white"></i> Cari No SEP Rawat Inap ', array(
                            'class' => 'btn btn-primary',
                            'onclick' => 'srkCariRiwayatSEPRI();',
                            'rel' => 'tooltip',
                            'title' => 'Klik untuk menambah SRK',
                            'style' => 'margin-left: 20px !important;'
                        ));
                    } ?>
                </div>
                <?php if (!empty($modRujukanBpjs->asalrujukan_id)) {
                ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modRujukanBpjs, 'asalrujukan_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modRujukanBpjs,
                                'asalrujukan_id',
                                CHtml::listData($modRujukanBpjs->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
                                array(
                                    'class' => 'span3 rujukandari_id', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('GetRujukanDari', array('encode' => false, 'namaModel' => 'PPRujukanbpjsT')),
                                        'update' => '#' . CHtml::activeId($modRujukanBpjs, 'rujukandari_id'),
                                    ),
                                    'onchange' => "clearRujukanBpjs();",
                                )
                            ); ?>
                            <?php echo $form->error($modRujukanBpjs, 'asalrujukan_id'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modRujukanBpjs, 'rujukandari_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modRujukanBpjs,
                                'rujukandari_id',
                                CHtml::listData($modRujukanBpjs->getRujukanDariItems($modRujukanBpjs->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
                                array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujukBpjs(); getPPK(this)')
                            ); ?>
                            <?php echo CHtml::htmlButton(
                                '<i class="icon-plus-sign icon-white"></i>',
                                array(
                                    'class' => 'btn btn-primary', 'onclick' => "{addRujukanDari(); $('#dialogAddRujukanDari').dialog('open');}",
                                    'id' => 'btnAddRujukanDari', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modRujukanBpjs->getAttributeLabel('nama_perujuk')
                                )
                            ) ?>
                            <?php echo $form->error($modRujukanBpjs, 'rujukandari_id'); ?>
                        </div>
                    </div>
                <?php } else {
                ?>
                    <div class="control-group ">
                        <?php
                        if ($modSep->jenisfaskes = 1) {
                            $modRujukanBpjs->asalrujukan_id = 5;
                        } else {
                            $modRujukanBpjs->asalrujukan_id = 6;
                        }
                        ?>
                        <?php //echo $form->textField($modRujukanBpjs, 'asalrujukan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
                        ?>
                        <?php echo CHtml::label($modAsuransiPasien->getAttributeLabel('asalrujukan_id') . " <span class='required'>*</span>", 'asalrujukan_id', array('class' => 'control-label required')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modRujukanBpjs,
                                'asalrujukan_id',
                                CHtml::listData(AsalrujukanM::model()->findAllByAttributes(array('asalrujukan_aktif' => True)), 'asalrujukan_id', 'asalrujukan_nama'),
                                array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setKarcis(2);')
                            );
                            ?>
                            <?php //echo $form->hiddenField($modRujukanBpjs, 'asalrujukan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
                            ?>
                            <?php //echo $form->textField($modRujukanBpjs->asalrujukan, 'asalrujukan_nama', array('class' => 'span3', 'readonly' => false));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modRujukanBpjs, 'rujukandari_id', array('class' => 'control-label')); ?>
                        <?php echo $form->hiddenField($modRujukanBpjs, 'rujukandari_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modRujukanBpjs, 'namaperujuk2', array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!in_array($this->id, array("pendaftaranRawatDarurat", "pendaftaranRawatInapDariRJRD", "pendaftaranBayiBaruLahir"))) { ?>
        <div class="control-group">
            <?php echo CHtml::label("PPK Rujukan <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getBpjsPPKRujukan($('#" . CHtml::activeId($modSep, "ppkrujukan") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek PPK Rujukan'></i>", 'ppkrujukan', array('class' => 'control-label')) ?>
            <div class="controls">

                <?php echo $form->textField($modSep, 'ppkrujukan', array('placeholder' => '', 'class' => 'span3 all-caps', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modRujukanBpjs, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

        <div class="control-group ">
            <label class="control-label required" for="PPRujukanbpjsT_tanggal_rujukan">
                Tanggal Rujukan
                <span class="required">*</span>
            </label>
            <div class="controls">
                <?php
                $modRujukanBpjs->tanggal_rujukan = (!empty($modRujukanBpjs->tanggal_rujukan) ? date("d/m/Y H:i:s", strtotime($modRujukanBpjs->tanggal_rujukan)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modRujukanBpjs,
                    'attribute' => 'tanggal_rujukan',
                    'mode' => 'datetime',
                    'options' => array(
                        //                                    'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                )); ?>

                <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
            </div>
        </div>
    <?php } ?>
    <div class="control-group ">
        <label for="PPRujukanbpjsT_kddiagnosa_rujukan" class="control-label">Kode Diagnosa Awal <font color="red">*</font><i class="icon-search" onclick="$('#dialogDiagnosa').dialog('open')" , style="cursor:pointer;" rel='tooltip' title='klik untuk mencari diagnosa rujukan'></i> </label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'model' => $modRujukanBpjs,
                'attribute' => 'kddiagnosa_rujukan',
                'data' => explode(',', $modRujukanBpjs->kddiagnosa_rujukan),
                'debugMode' => true,
                'options' => array(
                    //'bricket'=>false,
                    // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                ),
                'htmlOptions' => array('id' => 'diagnosaRujukanKodeBpjs'),
            ));
            ?>
            <?php echo $form->error($modRujukanBpjs, 'kddiagnosa_rujukan'); ?>
        </div>
    </div>
    <div class="control-group ">
        <label for="PPRujukanbpjsT_diagnosa_rujukan" class="control-label">Diagnosa Awal <font color="red">*</font></label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'model' => $modRujukanBpjs,
                'attribute' => 'diagnosa_rujukan',
                'data' => empty($modRujukanBpjs->diagnosa_rujukan) ? array() : explode(',', $modRujukanBpjs->diagnosa_rujukan),
                'debugMode' => true,
                'options' => array(
                    //'bricket'=>false,
                    // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                ),
                'htmlOptions' => array('id' => 'diagnosaRujukanBpjs'),
            ));
            ?>
            <?php echo $form->error($modRujukanBpjs, 'diagnosa_rujukan'); ?>
        </div>
    </div>
    <?php if (!in_array($this->id, array("pendaftaranRawatInapDariRJRD", "pendaftaranBayiBaruLahir"))) { ?>
        <div class="control-group">
            <label class="control-label">Spesialis/Subspesialis</label>
            <div class="controls">
                <?php echo $form->hiddenField($modSep, 'politujuan_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textField($modSep, 'politujuan', array('readonly' => true, 'class' => 'span3')); ?>
                <?php
                $modSep->poli_eksekutif = $modSep->isNewRecord ? "0" : $modSep->poli_eksekutif;
                echo $form->radioButtonListRow($modSep, 'poli_eksekutif', array(
                    1 => 'Ya', 0 => 'Tidak'
                )); ?>
            </div>
        </div>
    <?php } ?>

    <div class="panel panel-success rujukan" id="skdp" style="margin-bottom: 10px !important; padding: 5px">
        <?php
        $act = strtolower($this->id);
        if ($this->id != "pendaftaranRawatDarurat") {

            $act = strtolower($this->id);
            $judul = "";
            $label_no_surat = "Nomor Surat Kontrol";
            $label_dpjp_kontrol = "DPJP Pemberi Surat Kontrol";

            $labelplaceholder_no_surat = "Nomor Surat Kontrol";
            $labelplaceholder_dpjp_kontrol = "DPJP Pemberi Surat Kontrol";
            $requiredInput = "";

            if (in_array($act, array("pendaftaranrawatinapdarirjrd", "pendaftaranbayibarulahir"))) {
                $judul = "SPRI";
                $label_no_surat = "No. SPRI <span class='required'>*</span>";
                $label_dpjp_kontrol = "DPJP Pemberi SPRI <span class='required'>*</span>";

                $labelplaceholder_no_surat = "No. SPRI";
                $labelplaceholder_dpjp_kontrol = "DPJP Pemberi SPRI";
                $requiredInput = "required";
            }

            echo "<strong>" . $judul . "</strong>";

        ?>
            <div class="control-group">
                <?php echo CHtml::label($label_no_surat, 'Nomor Surat Kontrol', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    if (in_array($act, array("pendaftaranrawatinapdarirjrd"))) {
                        echo $form->textField($modSep, 'no_surat', array('placeholder' => $labelplaceholder_no_surat, 'class' => 'span3 ' . $requiredInput, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', "onKeyPress" => "cariSpriTombol(); return true;"));
                    } else {
                        echo $form->textField($modSep, 'no_surat', array('placeholder' => $labelplaceholder_no_surat, 'class' => 'span3 ' . $requiredInput, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', "onKeyPress" => "cariSuratKontrolTombol(); return true;"));
                    }
                    ?>
                    <?php
                    if (in_array($act, array("pendaftaranrawatinapdarirjrd"))) {
                        echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari Surat Kontrol Pasien", "onclick" => "cariSpri(); return true;"));
                    } else {
                        echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari Surat Kontrol Pasien", "onclick" => "cariSuratKontrol(); return true;"));
                    }
                    ?>
                    <?php
                    if (in_array($act, array("pendaftaranrawatinapdarirjrd"))) {
                        echo "&nbsp;";
                        echo CHtml::htmlButton('<i class="entypo-print"></i> Cetak', array(
                            'class' => 'btn btn-primary', 'id' => 'btn_print_spri',
                            'onclick' => 'cetakSPRIBPJS()', 'style' => "display: none;",
                        ));
                    }
                    ?>

                    <?php
                    if (in_array($act, array("pendaftaranrawatjalan"))) {
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-primary', 'onclick' => 'setDialogSRK();',
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah SRK'
                        ));
                    } ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label($label_dpjp_kontrol, 'nama_dpjp', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modSep, 'nama_dpjp', array('placeholder' => $labelplaceholder_dpjp_kontrol, 'class' => 'span3 ' . $requiredInput, 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($model, 'kode_dpjp') . "').val('')")); ?>
                    <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "$('#dialogDpjp').dialog('open');return true;")); ?>
                    <?php echo $form->hiddenField($modSep, 'kode_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'required' => $requiredInput)); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($modSep, 'jenis_kunjungan', array('class' => 'control-label', 'label' => 'Jenis Kunjungan <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($modSep, 'jenis_kunjungan', LookupM::getItemsUrutan('bpjs_jnskunjungan'), array(
                'class' => 'span3', 'onchange' => 'pilihJenisKunjunganBPJS();'
            )); ?>
            <?php echo $form->dropDownListRow($modSep, 'flag_procedure', LookupM::getItemsUrutan('bpjs_flagprocedure'), array('empty' => '-- Pilih --', 'class' => 'span2')); ?>
            <?php echo $form->dropDownListRow($modSep, 'kode_penunjang', LookupM::getItemsUrutan('bpjs_kdpenunjang'), array('empty' => '-- Pilih --', 'class' => 'span2')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modSep, 'asesmen_pelayanan', array('class' => 'control-label', 'label' => 'Asesmen Pelayanan')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($modSep, 'asesmen_pelayanan', LookupM::getItemsUrutan('bpjs_asesmenpelayanan'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
        </div>
    </div>

    <?php if (!in_array($this->id, array("pendaftaranRawatInapDariRJRD", "pendaftaranBayiBaruLahir"))) { ?>
        <div class="control-group">
            <?php
            $dpjp_req = "";
            if (in_array($act, array("pendaftaranrawatjalan", "pendaftaranrawatdarurat"))) { //, 'pendaftaranpersalinan'))) {
                echo CHtml::label('DPJP yang Melayani <span class="required">*</span>', 'nama_dpjp', array('class' => 'control-label'));
                $dpjp_req = "required";
            } else {
                echo CHtml::label("DPJP yang Melayani", 'nama_dpjp', array('class' => 'control-label'));
            }
            ?>
            <div class="controls">
                <?php echo $form->textField($modSep, 'dpjpygmelayani_nama', array('placeholder' => 'Dokter DPJP', 'class' => 'span3 ' . $dpjp_req, 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($model, 'kode_dpjp') . "').val('')")); ?>
                <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "setCariDPJP(); $('#dialogDpjpMelayani').dialog('open');return true;")); ?>
                <?php echo $form->hiddenField($modSep, 'dpjpygmelayani_kode', array('placeholder' => 'Dokter DPJP', 'class' => 'span3 ' . $dpjp_req, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    <?php } ?>
    <div class="control-group">
        <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modSep, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required numbers-only', 'onblur' => 'cekNoPonselSEP();', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Katarak", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $modSep->katarak = $modSep->isNewRecord ? "0" : $modSep->katarak;
            echo $form->radioButtonList($modSep, 'katarak', array(1 => 'Ya', 0 => 'Tidak')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <?php echo $form->checkBox($modSep, 'cob') . CHtml::label('COB', ''); ?>
        </div>
    </div>


    <?php
    if (Yii::app()->user->getState('isbridging')) {
    ?>

        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::checkBox('isSepManual', '', array('onchange' => 'setSEP(this)')); ?>
                No. SEP
                <!-- <span class="required">*</span> -->
            </label>
            <div class="controls">
                <?php echo $form->textField($modSep, 'nosep', array('placeholder' => 'No. SEP Manual / Otomatis', 'class' => 'span3 nosep', 'disabled' => 'disabled', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($modSep, 'nosep'); ?>
                <?php echo "<i class=\"icon-search\" onclick=\"cekSEP($('#" . CHtml::activeId($modSep, "nosep") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek SEP'></i>"; ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($modSep,'nosep', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
        ?>
        <?php //echo $form->hiddenField($modSep,'ppkpelayanan', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
        ?>
        <?php //echo $form->dropDownListRow($modSep,'jnspelayanan',LookupM::getItems('jenispelayanan'), array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujuk();')); 
        ?>
        <?php echo $form->textAreaRow($modSep, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <?php } ?>

    <div class="control-group">
        <?php echo CHtml::label('Status Kecelakaan <span class="required">*</span>', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $modSep->statuskecelakaan_kode = $modSep->isNewRecord ? "0" : $modSep->statuskecelakaan_kode;
            echo $form->dropDownList($modSep, 'statuskecelakaan_kode', LookupM::getItemsUrutan('bpjs_statuskecelakaan'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
        </div>
    </div>



    <br>
    <?php
    // echo CHtml::link(Yii::t('mds', '{icon} Verifikasi SEP', array('{icon}'=>'<i class="icon-form-check icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Klik tombol untuk memverifikasi data bpjs','class'=>'btn btn-info pull-right','onclick'=>"verifikasiBpjs($(this));",));
    ?>
    <?php
    // echo CHtml::link(Yii::t('mds', '{icon} Terverifikasi', array('{icon}'=>'<i class="icon-form-check icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Data SEP sudah Terverifikasi','class'=>'btn btn-info pull-right verified', 'style'=>'display:none', 'disabled'=>true,));
    ?>


    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogSuratKontrol',
        'options' => array(
            'title' => 'Surat Kontrol',
            'autoOpen' => false,
            'modal' => true,
            'width' => 450,
            'height' => 400,
            'resizable' => false,
        ),
    )); ?>
    <table width="100%" id="tab_sc">
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td id="sc_nama_pasien"></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td id="sc_jeniskelamin"></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td id="sc_tanggal_lahir"></td>
        </tr>
        <tr>
            <td>No. Surat</td>
            <td>:</td>
            <td id="sc_nosurat"></td>
        </tr>
        <tr>
            <td>Tanggal Entri</td>
            <td>:</td>
            <td id="sc_tanggal_entri"></td>
        </tr>
        <tr>
            <td>Tanggal Rencana Kontrol</td>
            <td>:</td>
            <td id="sc_tanggal_rencana"></td>
        </tr>
        <tr>
            <td>Poliklinik Tujuan</td>
            <td>:</td>
            <td id="sc_poli_tujuan"></td>
        </tr>
        <tr>
            <td>Dokter Tujuan Kontrol</td>
            <td>:</td>
            <td id="sc_dokter_kontrol"></td>
        </tr>
        <tr>
            <td>No SEP</td>
            <td>:</td>
            <td id="sc_no_sep"></td>
        </tr>
        <tr>
            <td>Tanggal SEP</td>
            <td>:</td>
            <td id="sc_tgl_sep"></td>
        </tr>
        <tr>
            <td style="color: red; font-weight: bold; text-align: center;" id="sc_status" colspan="3"></td>
        </tr>
        <tr>
            <td style="text-align: center" colspan="3">
                <?php echo CHtml::htmlButton('OK', array('class' => 'btn btn-success', 'onclick' => 'setSuratKontrol();')); ?>
            </td>
        </tr>
    </table>
    <?php
    $this->endWidget();

    ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogSpri',
        'options' => array(
            'title' => 'SPRI',
            'autoOpen' => false,
            'modal' => true,
            'width' => 450,
            'height' => 400,
            'resizable' => false,
        ),
    )); ?>
    <table width="100%" id="tab_sc">
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td id="sc_nama_pasien"></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td id="sc_jeniskelamin"></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td id="sc_tanggal_lahir"></td>
        </tr>
        <tr>
            <td>No. Surat</td>
            <td>:</td>
            <td id="sc_nosurat"></td>
        </tr>
        <tr>
            <td>Tanggal Entri</td>
            <td>:</td>
            <td id="sc_tanggal_entri"></td>
        </tr>
        <tr>
            <td>Tanggal Rencana Inap</td>
            <td>:</td>
            <td id="sc_tanggal_rencana"></td>
        </tr>
        <tr>
            <td>Poliklinik Tujuan</td>
            <td>:</td>
            <td id="sc_poli_tujuan"></td>
        </tr>
        <tr>
            <td>Dokter Tujuan </td>
            <td>:</td>
            <td id="sc_dokter_kontrol"></td>
        </tr>
        <tr>
            <td>No SEP</td>
            <td>:</td>
            <td id="sc_no_sep"></td>
        </tr>
        <tr>
            <td>Tanggal SEP</td>
            <td>:</td>
            <td id="sc_tgl_sep"></td>
        </tr>
        <tr>
            <td style="color: red; font-weight: bold; text-align: center;" id="sc_status" colspan="3"></td>
        </tr>
        <tr>
            <td style="text-align: center" colspan="3">
                <?php echo CHtml::htmlButton('OK', array('class' => 'btn btn-success', 'onclick' => 'setSuratKontrol();')); ?>
            </td>
        </tr>
    </table>
    <?php
    $this->endWidget();

    ?>
</div>

<div class="bpjs-manual hidden">
    <?php
    $read_only = '';
    if (isset($readdata)) {
        $read_only = " readonly = true  ";
    }
    ?>
    <div class="control-group">

        <?php $controller = Yii::app()->controller->id;

        $classNoPst = $controller !== 'pendaftaranRawatDarurat' ? 'control-label required jks_spec' : 'control-label jks_spec';
        $req = $controller !== 'pendaftaranRawatDarurat' ? " <span class='required jks_spec'>*</span>" : "";

        ?>
        <?php echo CHtml::label($modAsuransiPasienNon->getAttributeLabel('nopeserta') . $req, 'nopeserta', array('class' => $classNoPst)) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modAsuransiPasienNon,
                'attribute' => 'nopeserta',
                'source' => 'js: function(request, response) {
                                                    var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                    var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                                                $.ajax({
                                                    url: "' . $this->createUrl('AutocompleteAsuransi') . '",
                                                    dataType: "json",
                                                    data: {
                                                        nopeserta: request.term,
                                                        penjamin_id: penjamin_id,
                                                        pasien_id: pasien_id,
                                                    },
                                                    success: function (data) {
                                                            response(data);
                                                    }
                                                })
                                                }',
                'options' => array(
                    'minLength' => 1,
                    'focus' => 'js:function( event, ui ) {
                                                $(this).val( "");
                                                return false;
                                            }',
                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                $(".asuransipasien_bpjs").val(ui.item.asuransipasien_id);
                                                $(".nopeserta_bpjs").val(ui.item.nokartuasuransi);
                                                $(".nokartuasuransi_bpjs").val(ui.item.nokartuasuransi);
                                                $(".namapemilikasuransi_bpjs").val(ui.item.namapemilikasuransi);
                                                $(".jenispeserta_id_bpjs").val(ui.item.jenispeserta_id);
                                                $(".nomorpokokperusahaan_bpjs").val(ui.item.nomorpokokperusahaan);
                                                $(".namaperusahaan_bpjs").val(ui.item.namaperusahaan);
                                                $(".kelastanggunganasuransi_id_bpjs").val(ui.item.kelastanggunganasuransi_id);
                                                $(".nominal_tanggungan_bpjs").val(formatNumber(ui.item.nominal_tanggungan));
                                                setAsuransiLama();
                                                return false;
                                            }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'No. Peserta', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                    'onkeyup' => "setNoKartuAsuransi(); return $(this).focusNextInputField(event)",
                    'maxlength' => 13,
                    //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                    'class' => 'span3 angkahuruf-only all-caps nopeserta nopeserta_bpjs'
                ),
            ));
            ?>
            <?php echo $form->error($modAsuransiPasienNon, 'nopeserta'); ?>

        </div>
    </div>
    <?php echo $form->hiddenField($modAsuransiPasienNon, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3 asuransipasien_id asuransipasien_bpjs', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    <div class="control-group">
        <?php echo CHtml::label($modAsuransiPasienNon->getAttributeLabel('nokartuasuransi') . $req, 'nokartuasuransi', array('class' => $classNoPst)) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modAsuransiPasienNon,
                'attribute' => 'nokartuasuransi',
                'source' => 'js: function(request, response) {
                                                    var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                    var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                                                $.ajax({
                                                    url: "' . $this->createUrl('AutocompleteAsuransiKartu') . '",
                                                    dataType: "json",
                                                    data: {
                                                        nokartuasuransi: request.term,
                                                        penjamin_id: penjamin_id,
                                                        pasien_id: pasien_id,
                                                    },
                                                    success: function (data) {
                                                            response(data);
                                                    }
                                                })
                                                }',
                'options' => array(
                    'minLength' => 1,
                    'focus' => 'js:function( event, ui ) {
                                                $(this).val( "");
                                                return false;
                                            }',
                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                $(".asuransipasien_id_bpjs").val(ui.item.asuransipasien_id);
                                                $(".nopeserta_bpjs").val(ui.item.nokartuasuransi);
                                                $(".nokartuasuransi_bpjs").val(ui.item.nokartuasuransi);
                                                $(".namapemilikasuransi_bpjs").val(ui.item.namapemilikasuransi);
                                                $(".jenispeserta_id_bpjs").val(ui.item.jenispeserta_id);
                                                $(".nomorpokokperusahaan_bpjs").val(ui.item.nomorpokokperusahaan);
                                                $(".namaperusahaan_bpjs").val(ui.item.namaperusahaan);
                                                $(".kelastanggunganasuransi_id_bpjs").val(ui.item.kelastanggunganasuransi_id);
                                                $(".nominal_tanggungan_bpjs").val(formatNumber(ui.item.nominal_tanggungan));
                                                setAsuransiLama();
                                                return false;
                                            }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogAsuransi', 'jsFunction' => 'cekAsuransi()'),
                'htmlOptions' => array(
                    'placeholder' => 'No. Kartu Asuransi', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                    'onkeyup' => "; return $(this).focusNextInputField(event)",
                    'maxlength' => 13,
                    //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                    'class' => 'span3 angkahuruf-only all-caps nokartuasuransi nokartuasuransi_bpjs'
                ),
            ));
            ?>
            <?php echo $form->error($modAsuransiPasienNon, 'nokartuasuransi'); ?>
        </div>
    </div>
    <?php //echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
    ?>
    <?php //echo $form->textFieldRow($modAsuransiPasien,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3 all-caps', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
    ?>
    <div class="control-group">
        <?php echo CHtml::label($modAsuransiPasienNon->getAttributeLabel('namapemilikasuransi') . $req, 'namapemilikasuransi', array('class' => $classNoPst)) ?>
        <div class="controls">
            <?php echo $form->textField($modAsuransiPasienNon, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3 all-caps namapemilikasuransi namapemilikasuransi_bpjs', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($modAsuransiPasienNon, 'nomorpokokperusahaan', array('placeholder' => 'Nomor Pokok Perusahaan', 'class' => 'span3 nomorpokokperusahaan nomorpokokperusahaan_bpjs', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <div class="control-group">
        <label class="control-label">
            <?php echo $form->labelEx($modAsuransiPasienNon, 'kelastanggunganasuransi_id', array('class' => 'control-label')) ?>
            <?php if (strtolower($this->id) != "pendaftaranrawatdarurat") : ?>
                <!-- <span class="required">*</span> -->
            <?php endif; ?>
        </label>
        <div class="controls">
            <?php
            if (isset($statusMenu)) {
                echo $form->dropDownList($modAsuransiPasienNon, 'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3 kelastanggunganasuransi_id kelastanggunganasuransi_id_bpjs required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekPerbedaanKelas(this);'));
            } else {
                echo $form->dropDownList($modAsuransiPasienNon, 'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3 kelastanggunganasuransi_id kelastanggunganasuransi_id_bpjs required', 'onkeyup' => "return $(this).focusNextInputField(event)"));
            }
            ?>
        </div>
        <div class="controls cekKelas" <?php (!isset($admisi) ? Params::HIDDEN_HARGA : null) ?>>
            <?php // echo CHtml::checkBox('is_kelas', false, array('rel' => 'tooltip', 'title' => 'Klik untuk naik kelas', 'onclick'=>'hakKelas(this)')); 
            ?>
            <!--label>Naik Kelas</label-->
        </div>
    </div>

    <?php echo $form->textFieldRow($modAsuransiPasienNon, 'nominal_tanggungan', array('placeholder' => 'Nominal Tanggungan Asuransi', 'class' => 'span3 integer nominal_tanggungan nominal_tanggungan_bpjs', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
    <?php echo $form->textFieldRow($modAsuransiPasienNon, 'namaperusahaan', array('placeholder' => 'Nama Perusahaan Asuransi', 'class' => 'span3 all-caps namaperusahaan namaperusahaan_bpjs', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <div class="control-group">
        <label class="control-label">Status Konfirmasi</label>
        <div class="controls">

            <?php
            echo CHtml::activeRadioButton($modAsuransiPasienNon, 'status_konfirmasi', array(
                'value' => 1,
                'uncheckValue' => null,
                'id' => 'konfirmasi_sudah',
                'onchange' => '$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", false);',
                // 'onchange'=>'switchOtomatis(this)',
                'class' => 'rb_kon',
                'checked' => 'checked',
            )) . "Sudah ";
            echo CHtml::activeRadioButton($modAsuransiPasienNon, 'status_konfirmasi', array(
                'value' => 0,
                'uncheckValue' => null,
                'onchange' => '$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", true);',
                'class' => 'rb_kon',
                'id' => 'konfirmasi_sudah',
                'checked' => false,
            )) . "Belum ";
            ?>
            <?php //echo $form->checkBox($modAsuransiPasien,'status_konfirmasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'checked'=>false)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modAsuransiPasienNon, 'tgl_konfirmasi2', array('class' => 'control-label tgl_konfirmasi')) ?>
        <div class="controls">
            <?php
            $modAsuransiPasienNon->tgl_konfirmasi = (!empty($modAsuransiPasienNon->tgl_konfirmasi) ? date("d/m/Y H:i:s", strtotime($modAsuransiPasienNon->tgl_konfirmasi)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $modAsuransiPasienNon,
                'attribute' => 'tgl_konfirmasi2',
                'mode' => 'datetime',
                'options' => array(
                    //                                    'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('class' => 'span3 dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
            )); ?>
            <?php echo $form->error($modAsuransiPasienNon, 'tgl_konfirmasi2'); ?>
        </div>
    </div>
</div>

<script>
    function setKodeRuanganBPJS() {
        var ruangan_id = $("#PPPendaftaranT_ruangan_id").val();
        var poliTujuan = $("#PPSepT_politujuan_id").val();

        $.post('<?php echo $this->createUrl('getRuanganSpesialisBPJS') ?>', {
            ruangan_id: $(this).val(),
        }, function(data) {
            if (data.ok == 1) {
                if (data.kode != poliTujuan) {
                    $("#PPSepT_jenis_kunjungan").val(0);
                    $("#PPSepT_asesmen_pelayanan").val(1);
                } else {
                    $("#PPSepT_jenis_kunjungan").val(0);
                    $("#PPSepT_asesmen_pelayanan").val("");
                }
                $("#PPSepT_politujuan").val(data.kode);
            }
        }, 'json');
    }

    function pilihJenisKunjunganBPJS() {
        var jenis = $("#PPSepT_jenis_kunjungan").val();

        if (jenis == "0") {
            $("#PPSepT_flag_procedure").val(null).prop("readonly", true).prop("disabled", true);
            $("#PPSepT_kode_penunjang").val(null).prop("readonly", true).prop("disabled", true);
        } else {
            $("#PPSepT_flag_procedure").prop("readonly", false).prop("disabled", false);
            $("#PPSepT_kode_penunjang").prop("readonly", false).prop("disabled", false);
        }

        if (jenis == "0") {
            $("#PPSepT_asesmen_pelayanan").val("");
            <?php if (strtolower($this->id) == "pendaftaranrawatjalan") : ?>
                $("#skdp").addClass('hidden');
            <?php endif ?>

        }

        if (jenis == "2") {
            $("#PPSepT_asesmen_pelayanan").val(5);
            <?php if (strtolower($this->id) == "pendaftaranrawatjalan") : ?>
                $("#skdp").removeClass('hidden');
            <?php endif  ?>

        }
    }

    function setNoTelpBPJS() {
        $("#PPSepT_no_telpon_peserta").val($("#PPPasienM_no_mobile_pasien").val());
    }

    function setCariDPJP() {
        <?php if (in_array(strtolower($this->id), array("pendaftaranrawatjalan"))) : ?>
            var kode = $("#PPSepT_politujuan").val();

            if (kode != null && kode != "") {
                $("#kode_spesialis_melayani").val(kode);
                cariDataDokterMelayani();
            }
        <?php endif; ?>
    }

    var asalrujukan = <?php echo CJSON::encode(CHtml::listData(AsalrujukanM::model()->findAllByAttributes(array('asalrujukan_id' => array(5, 6))), 'asalrujukan_id', 'asalrujukan_nama')); ?>;

    function setAsalRujukan() {
        var jenisfaskes = $('#<?php echo CHtml::activeId($modSep, 'jenisfaskes'); ?>');
        var asalrujukan_id = $('#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id'); ?>');
        var asalrujukan2 = $('#<?php echo CHtml::activeId($modRujukanBpjs->asalrujukan, 'asalrujukan_nama'); ?>');

        if ($('#PPSepT_jenisfaskes_0').is(':checked')) {
            jenisfaskes.val(1);
            asalrujukan_id.val(5);
            asalrujukan2.val(asalrujukan[5]);
        }

        if ($('#PPSepT_jenisfaskes_1').is(':checked')) {
            jenisfaskes.val(2);
            asalrujukan_id.val(6);
            asalrujukan2.val(asalrujukan[6]);
        }

    }
    $("#PPPasienM_no_mobile_pasien").on("blur", setNoTelpBPJS);
    $("#PPPendaftaranT_ruangan_id").on("change", setKodeRuanganBPJS);

    $(document).ready(function() {
        pilihJenisKunjunganBPJS();
    });

    function inputNamaPenjamin() {
        var penjamin_id_naik = $('#<?php echo CHtml::activeId($modSep, 'penanggungjwb_naikkls_id'); ?>').val();
        if (penjamin_id_naik == 1) {
            $('#<?php echo CHtml::activeId($modSep, 'penanggungjwb_naikkls_nama'); ?>').val("Pribadi");
        } else {
            $('#<?php echo CHtml::activeId($modSep, 'penanggungjwb_naikkls_nama'); ?>').val("");
        }
    }
</script>