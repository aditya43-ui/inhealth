<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppsep-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#' . CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta'),
));
?>
<div class="row" id="content-bpjs">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Kunjungan Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <div class="control-label"><?php echo Chtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')); ?></div>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true));
                        echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($model, 'penjamin_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($model, 'carabayar_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($model, 'ruangan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        if (!empty($model->pasienadmisi_id)) {
                            echo $form->hiddenField($modAdmisi, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        } else {
                            echo $form->hiddenField($model, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo Chtml::label('No. Rekam Medik', 'no_rekam_medik', array('class' => 'control-label')); ?></div>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPasien, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true));
                        echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($modPasien, 'no_mobile_pasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo Chtml::label('Nama Pasien', 'no_rekam_medik', array('class' => 'control-label')); ?></div>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPasien, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo Chtml::label('Ruangan Perawatan', 'ruangan_id', array('class' => 'control-label')); ?></div>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'ruangan_nama', array('placeholder' => 'Ruangan Perawatan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Peserta BPJS</b>
                </div>
            </div>
            <div class="panel-body">
                <div id="rujukanBpjs" style="display: <?php echo ($pelayanan == 'RJ' || $pelayanan == 'RI') ? 'block' : 'none' ?>">
                    <div class="control-group">
                        <div class="control-label"><?php echo Chtml::label('Jenis Rujukan', 'jenis_rujukan', array('class' => 'control-label')); ?></div>
                        <div class="controls form-inline">
                            <?php
                            echo $form->radioButtonList($modSep, 'jenisfaskes', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Cari " . $modRujukanBpjs->getAttributeLabel('no_rujukan') . " <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
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
                                    'placeholder' => 'Nomor Rujukan', 'class' => ($pelayanan == 'RJ' || $pelayanan == 'RI') ? 'span3 required' : 'span3',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => "",
                                ),
                                'tombolDialog' => array('idDialog' => 'no_rujukan', 'jsFunction' => "getRujukanNoRujukan($('#" . CHtml::activeId($modRujukanBpjs, "no_rujukan") . "').val());"),
                            ));
                            ?>
                            <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="PPRujukanbpjsT_tanggal_rujukan">
                            Tanggal Rujukan
                            <span class="required">*</span>
                        </label>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modRujukanBpjs,
                                'attribute' => 'tanggal_rujukan',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                            ));
                            ?>
                            <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Cari " . $modAsuransiPasien->getAttributeLabel('nopeserta') . " <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modAsuransiPasien, 'nopeserta', array('placeholder' => 'No. Peserta', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo CHtml::link("<i class='entypo-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek peserta", "onclick" => "getAsuransiNoKartu($('#" . CHtml::activeId($modAsuransiPasien, "nopeserta") . "').val());return true;")); ?>
                        <?php echo $form->error($modAsuransiPasien, 'nopeserta'); ?>
                        <?php echo $form->hiddenField($modAsuransiPasien, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Cari " . $modAsuransiPasienBpjs->getAttributeLabel('nokartuasuransi') . " <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modAsuransiPasienBpjs,
                            'attribute' => 'nokartuasuransi',
                            'source' => 'js: function(request, response) {
                                var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                var pasien_id = $("#' . CHtml::activeId($modPasien, 'pasien_id') . '").val();
                           $.ajax({
                                   url: "' . Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/AutocompleteAsuransiKartu') . '",
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
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') . '").val(ui.item.nopeserta);
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                    $("#' . CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
                                    getAsuransiNoKartu(ui.item.nokartuasuransi);
                                    setAsuransiLama();
                                    return false;
                            }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogAsuransiBpjs', 'jsFunction' => 'cekAsuransiBpjs()'),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Kartu Asuransi BPJS', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                                'onkeyup' => "; return $(this).focusNextInputField(event)",
                                //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                                'class' => 'numbers-only span3'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modAsuransiPasienBpjs, 'nokartuasuransi'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modAsuransiPasienBpjs, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class="control-group">
                    <div class="control-label"><?php echo Chtml::label('Jenis Peserta', 'jenispeserta_nama', array('class' => 'control-label')); ?></div>
                    <div class="controls">
                        <?php
                        echo $form->textField($modAsuransiPasienBpjs, 'jenispeserta_nama', array('placeholder' => 'Jenis Peserta', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
                        echo $form->hiddenField($modAsuransiPasienBpjs, 'jenispeserta_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($modAsuransiPasienBpjs, 'kodefeskestk1', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($modAsuransiPasienBpjs, 'nama_feskestk1', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo Chtml::label('Kelas Tanggungan Asuransi', 'kelastanggunganasuransi_nama', array('class' => 'control-label')); ?></div>
                    <div class="controls">
                        <?php
                        echo $form->textField($modAsuransiPasienBpjs, 'kelastanggunganasuransi_nama', array('placeholder' => 'Kelas Tanggungan Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
                        echo $form->hiddenField($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Cari " . $modSep->getAttributeLabel('ppkrujukan') . " <span class='required'>*</span>", 'ppkrujukan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modSep,
                            'attribute' => 'ppkrujukan',
                            'source' => 'js: function(request, response) {
                           $.ajax({
                               url: "' . Yii::App()->createUrl('asuransi/Sep/AutocompleteItemSEP') . '",
                               dataType: "json",
                               data: {
                                   term: request.term,
                                   item: "ppk",
                               },
                               success: function (data) {
                                   response(data);
                               }
                           })
                       }',
                            'options' => array(
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.kode);
                                return false;
                            }',
                                'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.kode);
                                getRujukanDari(ui.item.kode);
                                return false;
                            }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode PPK', 'rel' => 'tooltip', 'title' => 'Ketik kode ppk untuk mencari data ppk', 'class' => 'span3 required',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modSep, 'ppkrujukan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRujukanBpjs, 'asalrujukan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modRujukanBpjs, 'asalrujukan_id', CHtml::listData($modRujukanBpjs->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'), array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => 'PPRujukanbpjsT')),
                                'update' => '#' . CHtml::activeId($modRujukanBpjs, 'rujukandari_id'),
                            ),
                            'onchange' => "clearRujukanBpjs();",
                        ));
                        ?>
                        <?php echo $form->error($modRujukanBpjs, 'asalrujukan_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRujukanBpjs, 'rujukandari_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modRujukanBpjs, 'rujukandari_id', CHtml::listData($modRujukanBpjs->getRujukanDariItems(), 'rujukandari_id', 'namaperujuk'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujukBpjs();'));
                        ?>
                        <?php echo $form->error($modRujukanBpjs, 'rujukandari_id'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modRujukanBpjs, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>SEP Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                if (Yii::app()->user->getState('isbridging')) {
                ?>
                    <?php echo $form->hiddenField($modSep, 'sep_id', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->hiddenField($modSep, 'tglsep', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                    <div class="control-group">
                        <label for="PPRujukanbpjsT_kddiagnosa_rujukan" class="control-label">Kode Diagnosa Rujukan <span class="required">*</span></label>
                        <div class="controls">
                            <?php
                            /*$this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                'model' => $modRujukanBpjs,
                                'attribute' => 'kddiagnosa_rujukan',
                                'data' => explode(',', $modRujukanBpjs->kddiagnosa_rujukan),
                                'debugMode' => true,
                                'options' => array(
                                    'addontab' => true,
                                    'maxitems' => 10,
                                    'input_min_size' => 0,
                                    'cache' => true,
                                    'newel' => true,
                                    'addoncomma' => true,
                                    'select_all_text' => "",
                                    'autoFocus' => true,
                                ),
                                'htmlOptions' => array('id' => 'diagnosaRujukanKodeBpjsSEP'),
                            ));*/
                            ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modRujukanBpjs,
                                'attribute' => 'kddiagnosa_rujukan',
                                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . Yii::app()->createUrl('asuransi/Sep/AutocompleteItemSEP') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           item: "diagnosa",
                                       },
                                       success: function (data) {
                                           response(data);
                                       }
                                   })
                               }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                       $(this).val(ui.item.kode);
                                       return false;
                                   }',
                                    'select' => 'js:function( event, ui ) {
                                       $(this).val(ui.item.kode);
                                       $("#' . CHtml::activeId($modRujukanBpjs, 'diagnosa_rujukan') . '").val(ui.item.nama);
                                       return false;
                                   }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ),
                            ));
                            ?>
                            <?php echo $form->error($modRujukanBpjs, 'kddiagnosa_rujukan'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="PPRujukanbpjsT_diagnosa_rujukan" class="control-label">Diagnosa Rujukan <span class="required">*</span></label>
                        <div class="controls">
                            <?php
                            /*$this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                'model' => $modRujukanBpjs,
                                'attribute' => 'diagnosa_rujukan',
                                'data' => explode(',', $modRujukanBpjs->diagnosa_rujukan),
                                'debugMode' => true,
                                'options' => array(
                                    'addontab' => true,
                                    'maxitems' => 10,
                                    'input_min_size' => 0,
                                    'cache' => true,
                                    'newel' => true,
                                    'addoncomma' => true,
                                    'select_all_text' => "",
                                    'autoFocus' => true,
                                ),
                                'htmlOptions' => array('id' => 'diagnosaRujukanBpjsSEP'),
                            ));*/
                            ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modRujukanBpjs,
                                'attribute' => 'diagnosa_rujukan',
                                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . Yii::app()->createUrl('asuransi/Sep/AutocompleteItemSEP') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           item: "diagnosa",
                                       },
                                       success: function (data) {
                                           response(data);
                                       }
                                   })
                               }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                       $(this).val(ui.item.nama);
                                       return false;
                                   }',
                                    'select' => 'js:function( event, ui ) {
                                       $(this).val(ui.item.nama);
                                       $("#' . CHtml::activeId($modRujukanBpjs, 'kddiagnosa_rujukan') . '").val(ui.item.kode);
                                       return false;
                                   }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ),
                            ));
                            ?>
                            <?php echo $form->error($modRujukanBpjs, 'diagnosa_rujukan'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            No. SEP
                            <span class="required">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $form->textField($modSep, 'nosep', array('placeholder' => 'No. SEP Manual / Otomatis', 'class' => 'span3 nosep', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            <?php echo $form->error($modSep, 'nosep'); ?>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($modSep, 'ppkpelayanan', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownList($modSep, 'jnspelayanan', array('2' => "Rawat Jalan", '1' => "Rawat Inap"), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujuk();', 'style' => 'display:none;',)); ?>
                    <div class="panel panel-success" id="skdp" style="display: <?php echo ($pelayanan == 'RJ') ? 'block' : 'none' ?>">
                        <div class="control-group">
                            <?php echo CHtml::label("Nomor Surat Kontrol", 'Nomor Surat Kontrol', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modSep, 'no_surat', array('placeholder' => 'Nomor Surat Kontrol', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6, 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Dokter DPJP", 'nama_dpjp', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modSep, 'nama_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($modSep, 'kode_dpjp') . "').val('')")); ?>
                                <?php echo CHtml::link("<i class='entypo-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "$('#dialogDpjp').dialog('open');return true;")); ?>
                                <?php echo $form->hiddenField($modSep, 'kode_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group form-inline">
                        <?php echo CHtml::label("Poli Eksekutif", 'Eksekutif', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->radioButtonList($modSep, 'poli_eksekutif', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                    <div class="control-group form-inline">
                        <?php echo CHtml::label("COB", 'COB', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->hiddenField($modSep, 'cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                            echo $form->hiddenField($modSep, 'no_asuransi_cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                            echo $form->hiddenField($modSep, 'namaasuransi_cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                            echo $form->textField($modSep, 'status_nosep', array('class' => 'span1', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                            ?>
                        </div>
                    </div>
                    <div class="control-group form-inline">
                        <?php echo CHtml::label("Katarak", 'Katarak', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->radioButtonList($modSep, 'katarak', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-suplesi',
                        'content' => array(
                            'content-suplesi' => array(
                                'header' => '<b>Kecelakaan Lalu Lintas</b>',
                                'isi' => $this->renderPartial($this->path_view . '._formSuplesi', array(
                                    'form' => $form,
                                    'model' => $modSep,
                                ), true),
                                'active' => $modSep->lakalantas,
                            ),
                        ),
                        'htmlOptions' => array(),
                    ));
                    ?>
                    <div class="control-group">
                        <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modSep, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>
                    <?php echo $form->textAreaRow($modSep, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-actions" id="tombol">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data SEP Pasien berhasil disimpan!");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        if (!isset($modSep->sep_id)) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Verifikasi SEP', array(
                '{icon}' => '<i class="entypo-check"></i>'
            )), array(
                'class' => 'btn btn-info btn-ver-sep',
                'type' => 'button', 'onclick' => "verifikasiBpjs($(this));"
            ));
        }
        ?>
        <?php
        if (isset($modSep->sep_id)) {
            echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array(
                'class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE
            ));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array(
                '{icon}' => '<i class="entypo-check"></i>'
            )), array(
                'class' => 'btn btn-primary btn-sep', 'style' => 'display:none;',
                'type' => 'button', 'onclick' => 'simpanProsesSEP();'
            ));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array(
                '{icon}' => '<i class="entypo-cancel"></i>'
            )), array(
                'class' => 'btn btn-danger',
                'type' => 'button', 'onclick' => 'batalDialog("dialog-proses-sep");'
            ));
        }
        ?>
        <?php
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAsuransiBpjs',
    'options' => array(
        'title' => 'Pencarian Asuransi Pasien BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
$modCariAsuransiPasienBpjs = new PPAsuransipasienbpjsM('search');
$modCariAsuransiPasienBpjs->unsetAttributes();
if (isset($_GET['PPAsuransipasienbpjsM'])) {
    $modCariAsuransiPasienBpjs->attributes = $_GET['PPAsuransipasienbpjsM'];
    isset($_GET['PPAsuransipasienbpjsM']['pasien_id']) ? $modCariAsuransiPasienBpjs->pasien_id = $_GET['PPAsuransipasienbpjsM']['pasien_id'] : '';
    isset($_GET['PPAsuransipasienbpjsM']['penjamin_id']) ? $modCariAsuransiPasienBpjs->penjamin_id = $_GET['PPAsuransipasienbpjsM']['penjamin_id'] : '';
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'asuransibpjs-m-grid',
    'dataProvider' => $modCariAsuransiPasienBpjs->searchDialog(),
    'filter' => $modCariAsuransiPasienBpjs,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectAsuransi",
                        "onClick" => "
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') . '\").val(\"$data->nopeserta\");
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                            $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                            getAsuransiNoKartu(\'$data->nopeserta\');
                            setAsuransiLama()
                            $(\"#dialogAsuransiBpjs\").dialog(\"close\");
                        "))',
        ),
        'nokartuasuransi',
        'nopeserta',
        array(
            'header' => 'Nama Pemilik Asuransi',
            'value' => '$data->namapemilikasuransi',
            'filter' => CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'pasien_id', array(
                'readonly' => true
            )) . "" . CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'penjamin_id', array(
                'readonly' => true
            )) . "" . CHtml::activeTextField($modCariAsuransiPasienBpjs, 'namapemilikasuransi', array()),
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        'namaperusahaan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pencarian Diagnosa Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDiagnosa = new PPDiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['PPDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectPasien",
                "onClick" => "
                    setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                    $(\"#dialogDiagnosa\").dialog(\"close\");
                "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosaBpjs',
    'options' => array(
        'title' => 'Pencarian Diagnosa Rujukan BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDiagnosa');
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSuplesi',
    'options' => array(
        'title' => 'Pencarian Suplesi Jasa Raharja',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianSuplesi');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDpjp',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDpjp');
$this->endWidget();
?>

<?php
echo $this->renderPartial($this->path_view . '_jsFunctionsSEP', array(
    'model' => $model,
    'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab,
    'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien,
    'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep
));
?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctionSuplesi', array('model' => $modSep)); ?>