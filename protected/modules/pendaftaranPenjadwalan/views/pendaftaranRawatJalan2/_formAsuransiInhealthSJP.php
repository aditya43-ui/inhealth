<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppsep-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
));
?>
<div class="row" id="content-inhealth">
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
                        echo $form->hiddenField($model, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($model, 'penjamin_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($model, 'carabayar_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($model, 'ruangan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo $form->hiddenField($modSepInhealthT, 'tglsep', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
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
                    <i class="entypo-user"></i> Data <b>Asuransi Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label("Cari " . $modAsuransiPasienInhealth->getAttributeLabel('nopeserta') . " <span class='required'>*</span>", 'nopeserta', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modAsuransiPasienInhealth, 'nopeserta', array('placeholder' => 'No. Peserta', 'class' => 'numbers-only span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo CHtml::link("<i class='entypo-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek peserta", "onclick" => "EligibilitasPeserta($('#" . CHtml::activeId($modAsuransiPasienInhealth, "nopeserta") . "').val());return true;")); ?>
                        <?php echo $form->error($modAsuransiPasienInhealth, 'nopeserta'); ?>
                        <?php echo $form->hiddenField($modAsuransiPasienInhealth, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Cari " . $modAsuransiPasienInhealth->getAttributeLabel('nokartuasuransi') . " <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modAsuransiPasienInhealth,
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val( "");
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'nopeserta') . '").val(ui.item.nopeserta);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                    $("#' . CHtml::activeId($modAsuransiPasienInhealth, 'kelastanggunganasuransi_id') . '").val(ui.item.kelastanggunganasuransi_id);
                                    setAsuransiLama();
                                    return false;
                                }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogAsuransiInhealth', 'jsFunction' => 'cekAsuransiInhealth()'),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Kartu Asuransi Inhealth', 'rel' => 'tooltip', 'title' => 'No. Peserta',
                                'onkeyup' => "; return $(this).focusNextInputField(event)",
                                'class' => 'numbers-only span3', 'maxlength' => 13
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modAsuransiPasienInhealth, 'nokartuasuransi'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modAsuransiPasienInhealth, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo Chtml::label('Kelas Tanggungan Asuransi', 'kelastanggunganasuransi_nama', array('class' => 'control-label')); ?></div>
                <div class="controls">
                    <?php
                    echo $form->textField($modAsuransiPasienInhealth, 'kelastanggunganasuransi_nama', array('placeholder' => 'Kelas Tanggungan Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
                    echo $form->hiddenField($modAsuransiPasienInhealth, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pangajuan SJP</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->textFieldRow($modRujukanInhealth, 'no_rujukan', array('placeholder' => 'Kode rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <label class="control-label">
                        Tanggal Rujukan
                        <span class="required">*</span>
                    </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modRujukanInhealth,
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
                        <?php echo $form->error($modRujukanInhealth, 'tanggal_rujukan'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($modRujukanInhealth, 'asalrujukan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modRujukanInhealth,
                            'asalrujukan_id',
                            CHtml::listData($modRujukanInhealth->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => 'PPRujukanInhealthT')),
                                    'update' => '#' . CHtml::activeId($modRujukanInhealth, 'rujukandari_id'),
                                ),
                                'onchange' => ""
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRujukanInhealth, 'rujukandari_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modRujukanInhealth,
                            'rujukandari_id',
                            CHtml::listData($modRujukanInhealth->getRujukanDariItems($modRujukanInhealth->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
                            array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujukInhealth();getPPKInhealth(this);')
                        ); ?>
                    </div>
                </div>
                <?php echo $form->hiddenField($modSepInhealthT, 'jnspelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($modSepInhealthT, 'ppkrujukan', array('placeholder' => 'Kode ppk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($modRujukanInhealth, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <label class="control-label">
                        No. SJP <span class="required">*</span>
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($modSepInhealthT, 'nosep', array('placeholder' => 'Otomatis', 'class' => 'span3 nosep required', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->error($modSepInhealthT, 'nosep'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Diagnosa Utama <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modSepInhealthT,
                            'attribute' => 'diagnosaawal',
                            'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetDiagnosaInhealth') . '",
                                   dataType: "json",
                                   data: {
                                       term: request.term,
                                       param: "mixed",
                                   },
                                   success: function (data) {
                                       response(data);
                                   }
                               })
                           }',
                            'options' => array(
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                   $(this).val(ui.item.diagnosa_kode);
                                   return false;
                               }',
                                'select' => 'js:function( event, ui ) {
                                   $(this).val(ui.item.diagnosa_kode);
                                   return false;
                               }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode/Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Diagnosa Tambahan</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modSepInhealthT,
                            'attribute' => 'kodediagnosatambahan',
                            'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetDiagnosaInhealth') . '",
                                   dataType: "json",
                                    data: {
                                        term: request.term,
                                        param: "mixed",
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                               })
                           }',
                            'options' => array(
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                   $(this).val(ui.item.diagnosa_kode);
                                   return false;
                               }',
                                'select' => 'js:function( event, ui ) {
                                   $(this).val(ui.item.diagnosa_kode);
                                   return false;
                               }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode/Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Kecelakaan</label>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modSepInhealthT,
                            'lakalantas',
                            array('0' => "Tidak/Biasa", '1' => "Kecelakaan Kerja", '2' => "Kecelakaan Lalu Lintas"),
                            array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Informasi Tambahan</label>
                    <div class="controls">
                        <?php echo $form->textArea($modSepInhealthT, 'catatansep', array('placeholder' => 'Informasi tambahan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
    </div>
    <div class="span12">
        <?php
        if (empty($modSepInhealthT->sep_id)) {
            echo CHtml::link(Yii::t('mds', '{icon} Verifikasi SJP', array('{icon}' => '<i class="icon-form-check icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Klik tombol untuk memverifikasi SJP', 'class' => 'btn btn-info verifikasi_bpjs', 'onclick' => "verifikasiSjp(this,'baru');",));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print SJP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSJPInhealth(3, " . $modSepInhealthT->sep_id . ");return false", 'disabled' => FALSE));
        }
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php echo $this->renderPartial(
    $this->path_view . '_jsFunctionInhealth',
    array(
        'model' => $model,
        'modRujukanInhealth' => $modRujukanInhealth,
        'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
        'modSepInhealthT' => $modSepInhealthT,
        'modPasien' => $modPasien
    )
);
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAsuransiInhealth',
    'options' => array(
        'title' => 'Pencarian Asuransi Pasien BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
$modAsuransiPasienInhealth = new PPAsuransipasienbpjsM('search');
$modAsuransiPasienInhealth->unsetAttributes();
if (isset($_GET['PPAsuransipasieninhealthM'])) {
    $modAsuransiPasienInhealth->attributes = $_GET['PPAsuransipasieninhealthM'];
    isset($_GET['PPAsuransipasieninhealthM']['pasien_id']) ? $modAsuransiPasienInhealth->pasien_id = $_GET['PPAsuransipasieninhealthM']['pasien_id'] : '';
    isset($_GET['PPAsuransipasieninhealthM']['penjamin_id']) ? $modAsuransiPasienInhealth->penjamin_id = $_GET['PPAsuransipasieninhealthM']['penjamin_id'] : '';
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'asuransiinhealth-m-grid',
    'dataProvider' => $modAsuransiPasienInhealth->searchDialog(),
    'filter' => $modAsuransiPasienInhealth,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectAsuransi",
                "onClick" => "
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'nopeserta') . '\").val(\"$data->nopeserta\");
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                    $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                    getAsuransiNoKartu(\'$data->nopeserta\');
                    setAsuransiLama()
                    $(\"#dialogAsuransiInhealth\").dialog(\"close\");
                "))',
        ),
        'nokartuasuransi',
        'nopeserta',
        array(
            'header' => 'Nama Pemilik Asuransi',
            'value' => '$data->namapemilikasuransi',
            'filter' => CHtml::activeHiddenField($modAsuransiPasienInhealth, 'pasien_id', array(
                'readonly' => true
            )) . "" . CHtml::activeHiddenField($modAsuransiPasienInhealth, 'penjamin_id', array(
                'readonly' => true
            )) . "" . CHtml::activeTextField($modAsuransiPasienInhealth, 'namapemilikasuransi', array()),
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        'namaperusahaan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>