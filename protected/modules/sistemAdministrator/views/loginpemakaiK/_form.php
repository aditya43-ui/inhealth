<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'loginpemakai-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAPegawaiM_nama_pegawai',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return cekSubmit();'),
    'method' => 'POST',
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.')
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->hiddenField($model, 'is_email');
        echo $form->hiddenField($model, 'is_phonenumber');
        ?>
        <?php echo $form->radioButtonListInlineRow($model, 'jenispemakai', array('pegawai' => 'Pegawai', 'pasien' => 'Pasien', 'ppds' => 'PPDS'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'pilihPemakai(this);')); ?>
        <div class="pegawai">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'pegawai_id');
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'SAPegawaiM[nama_pegawai]',
                        'value' => $model->pegawai_id,
                        'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('autoCompletePegawai') . '",
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
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
                                                $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id)
                                                return false;
                                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                        'htmlOptions' => array('placeholder' => 'Pegawai', "rel" => "tooltip", "title" => "Klik untuk mencari pegawai", 'onkeyup' => "return $(this).focusNextInputField(event)"),
                    )); ?>

                </div>
            </div>
        </div>
        <div class="pasien">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pasien_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'pasien_id');
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'SAPegawaiM[nama_pasien]',
                        'value' => $model->pegawai_id,
                        'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('AutocompletePasien') . '",
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
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
                                                $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id)
                                                return false;
                                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPasien'),
                        'htmlOptions' => array("rel" => "tooltip", "title" => "Klik untuk mencari pasien", 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Rekam Medik'),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="ppds">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'ppds_id', array('class' => 'control-label ppds_id')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'ppds_id');
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'PpdsM[ppds_nama]',
                        'value' => !empty($model->ppds_id) ? $model->ppds->ppds_nama : null,
                        'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('autoCompletePpds') . '",
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
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
                                                $("#' . CHtml::activeId($model, 'ppds_id') . '").val(ui.item.ppds_id)
                                                return false;
                                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPpds'),
                        'htmlOptions' => array('placeholder' => 'PPDS', "rel" => "tooltip", "title" => "Klik untuk mencari PPDS", 'onkeyup' => "return $(this).focusNextInputField(event)"),
                    )); ?>

                </div>
            </div>
        </div>
        <?php
        //            echo $form->errorSummary($model);
        echo $form->textFieldRow($model, 'nama_pemakai', array('onblur' => 'nospaces(this);', 'hint' => $model->getAttributeLabel('nama_pemakai') . ' tidak boleh menggunakan "spasi"', 'placeholder' => 'Username', 'class' => 'span3 username-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'onkeyup' => "return $(this).focusNextInputField(event)"));
        if ($model->is_email) {
            echo '<div class="control-group">
      <label class="control-label"></label><div class="controls"><div class="informasi-dikirim">Informasi Tentang User Akun dikirim ke Email</div></div></div>';
        } elseif ($model->is_phonenumber) {
            echo '<div class="control-group"><label class="control-label"></label><div class="controls"><div class="informasi-dikirim">Informasi Tentang User Akun dikirim ke Nomor Handphone</div></div></div>';
        } else {
            echo '<div class="control-group"><label class="control-label"></label><div class="controls"><div class="informasi-dikirim"></div></div></div>';
        }
        ?>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'new_password', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                echo $form->passwordField($model, 'new_password', array('placeholder' => 'Kata Kunci Baru', 'class' => 'span3',  'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 200, 'onchange' => 'checkPass(this,8)'));
                echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array(
                    'class' => 'btn btn-primary', "data-toggle" => "tooltip", "data-placement" => "top", "title" => "",
                    "data-original-title" => "<span style='text-align:left;'>Cara Pengisian Password<br>"
                        . "1. minimal terdiri dari 8 karakter,<br> "
                        . "2. minimal mengandung satu huruf kecil,<br> "
                        . "3. minimal mengandung satu huruf kapital,<br> "
                        . "4. minimal mengandung satu angka,<br> "
                        . "5. minimal mengandung satu simbol dash (-),<br>"
                        . "Contoh : <b>AxY12-092Nnsb</b></span> ", "data-html" => true
                )); ?>
                <br>
                <span id="reset_password-error2" style="color:#cc2424" hidden></span>
            </div>
        </div>
        <?php
        //echo $form->passwordFieldRow($model,'new_password',array('class'=>'span3',  'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200));
        echo $form->passwordFieldRow($model, 'new_password_repeat', array('placeholder' => 'Ulangi Kata Kunci', 'class' => 'span3',  'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 200));
        ?>

        <div class="control-group">
                <?php echo CHtml::label('Coder Nik', 'coder_nik', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'coder_nik', array('class'=>'span3', 'maxlength'=>50));
                    ?>
                </div>
            </div>
    </div>
</div>

<div class="ruangan">
    <div class="control-group">
        <?php echo $form->labelex($model, 'ruangan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php

            $this->widget(
                'application.extensions.emultiselect.EMultiSelect',
                array('sortable' => true, 'searchable' => true)
            );
            echo CHtml::dropDownList(
                'ruangan_id[]',
                '',
                CHtml::listData(RuanganM::model()->findAll(array('condition' => 'ruangan_aktif = TRUE', 'order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
            );
            ?>
            <?php echo $form->error($model, 'ruangan') ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelex($model, 'modul', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php

            $this->widget(
                'application.extensions.emultiselect.EMultiSelect',
                array('sortable' => true, 'searchable' => true)
            );
            echo CHtml::dropDownList(
                'modul_id[]',
                '',
                CHtml::listData(ModulK::model()->findAll(array('condition' => 'modul_aktif = TRUE', 'order' => 'modul_nama')), 'modul_id', 'modul_nama'),
                array('multiple' => 'multiple', 'key' => 'modul_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
            );
            ?>
            <?php echo $form->error($model, 'modul') ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/loginpemakaiK/admin'),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
    ); ?>

    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Login Pemakai', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/sistemAdministrator/loginpemakaiK/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>

    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>

</div>
<?php $this->endWidget(); ?>

<?php

$js = <<< JSCRIPT
   kosongkanPassword();

   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);

?>
<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new SAPegawaiM();
$modPegawai->attributes = isset($_GET['SAPegawaiM']) ? $_GET['SAPegawaiM'] : null;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapegawai-m-grid',
    'dataProvider' => $modPegawai->searchPegawaiNoUser(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',

            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                          "onClick"=>"
                                            $(\"#idPegawai\").val(\"$data->pegawai_id\");
                                            $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                            $(\"#SAPegawaiM_nama_pegawai\").val(\"$data->NamaLengkap\");
                                            $(\"#dialogPegawai\").dialog(\"close\");
                                            "
                                     ))',
        ),
        'nomorindukpegawai',
        array(
            'header' => 'Gelar Depan',
            'name' => 'gelardepan',
            'value' => '$data->gelardepan',
            'filter' => CHtml::dropDownList('SAPegawaiM[gelardepan]', $modPegawai->gelardepan,  LookupM::getItems('gelardepan'), array('empty' => '-- Pilih --'))
        ),
        'nama_pegawai',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::dropDownList('SAPegawaiM[jeniskelamin]', $modPegawai->jeniskelamin,  LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        'tempatlahir_pegawai',
        array(
            'header' => 'Tanggal Lahir',
            'value' => '$data->tgl_lahirpegawai',
            'filter' => false,
        ),
        array(
            'header' => 'Jabatan',
            'value' => 'isset($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => CHtml::dropDownList('SAPegawaiM[jabatan_id]', $modPegawai->jabatan_id, CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = true ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php $this->endWidget(); ?>

<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPasien = new SAPasienM('searchDialog');
if (isset($_GET['SAPasienM'])) {
    $modPasien->attributes = $_GET['SAPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapasien-m-grid',
    'dataProvider' => $modPasien->searchPasienNoUser(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',

            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                "onClick"=>"
                                  $(\"#pasien_id\").val(\"$data->pasien_id\");
                                  $(\"#' . CHtml::activeId($model, 'pasien_id') . '\").val(\"$data->pasien_id\");
                                  $(\"#SAPegawaiM_nama_pasien\").val(\"$data->nama_pasien\");
                                  $(\"#dialogPasien\").dialog(\"close\");
                                  "
                           ))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::dropDownList('SAPasienM[jeniskelamin]', $modPegawai->jeniskelamin,  LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Tanggal Lahir',
            'value' => '$data->tanggal_lahir',

        ),
        'alamat_pasien',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php $this->endWidget(); ?>

<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPpds',
    'options' => array(
        'title' => 'Data PPDS',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM();
$modPpds->attributes = isset($_GET['PpdsM']) ? $_GET['PpdsM'] : null;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sappds-m-grid',
    'dataProvider' => $modPpds->searchDialogPPDS(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',

            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                          "onClick"=>"
                                            $(\"#' . CHtml::activeId($model, 'ppds_id') . '\").val(\"$data->ppds_id\");
                                            $(\"#PpdsM_ppds_nama\").val(\"$data->ppds_nama\");
                                            $(\"#dialogPpds\").dialog(\"close\");
                                            "
                                     ))',
        ),
        
        'ppds_nik',
        'ppds_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php $this->endWidget(); ?>

<?php

/** digunakan untuk memilih email atau nomor telpon/hanphone (sebagai alat penerima informasi user akun)
 *  created by M Iqbal Laksana
 */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogVerifikasi',
    'options' => array(
        'title' => 'Verifikasi User',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 200,
        'height' => 200,
        'resizable' => false,
    ),
));

echo CHtml::radioButtonList('verifikasi', '1', array('0' => 'Nomor Telpon', '1' => 'Email'), array('labelOptions' => array('style' => 'display:inline')));

$this->endWidget();
?>

<script type="text/javascript">
    function nospaces(t) {
        if (t.value.match(/\s/g)) {
            myAlert('Maaf, inputan tidak diperbolehkan menggunakan spasi');
            t.value = t.value.replace(/\s/g, '');
        }
    }

    function pilihPemakai(obj) {
        var jenis_pemakai = $('#<?php CHtml::activeId($model, 'jenispemakai'); ?>').val();
        $('input[name$="[jenispemakai]"][type="radio"]').each(function() {
            if ($(obj).is(':checked')) {
                if (obj.value == 'pegawai') {
                    $('.pegawai').show();
                    $('.pasien').hide();
                    $('.ruangan').show();
                    $('.ppds').hide();
                } else if (obj.value == 'ppds') {
                    $('.pegawai').hide();
                    $('.pasien').hide();
                    $('.ruangan').show();
                    $('.ppds').show();
                } else {
                    $('.pegawai').hide();
                    $('.pasien').show();
                    $('.ruangan').hide();
                    $('.hide').hide();
                }
            }
        });
    }

    function cekSubmit() {
        var confirm = $("#<?php echo CHtml::activeId($model, 'new_password') ?>");
        var reconfirm = $("#<?php echo CHtml::activeId($model, 'new_password_repeat') ?>");
        //alert(confirm);

        confirm.attr("style", '');
        reconfirm.attr("style", '');
        if (checkPass(confirm, 8)) {
            if (reconfirm.val() == confirm.val()) {
                return requiredCheck($("#loginpemakai-k-form"));
            } else {
                confirm.attr("style", 'border:1px solid red;');
                reconfirm.attr("style", 'border:1px solid red;');
                myAlert("Maaf, Ulangi Kata Kunci tidak sama dengan password baru");
                return false;
            }
        } else {
            confirm.attr("style", 'border:1px solid red;');
            myAlert("Maaf, inputan password tidak sesuai cara pengisian password");
            return false;
        }
    }

    $(document).ready(function() {
        var jenis_pemakai = $('#<?php CHtml::activeId($model, 'jenispemakai'); ?>').val();
        $('input[name$="[jenispemakai]"][type="radio"]').each(function() {
            if ($(this).is(':checked')) {
                if (this.value == 'pegawai') {
                    $('.pegawai').show();
                    $('.pasien').hide();
                    $('.ruangan').show();
                    $('.ppds').hide();
                } else if (this.value == 'ppds') {
                    $('.pegawai').hide();
                    $('.pasien').hide();
                    $('.ruangan').show();
                    $('.ppds').show();
                } else {
                    $('.pegawai').hide();
                    $('.pasien').show();
                    $('.ruangan').hide();
                    $('.hide').hide();
                }
            }
        });

    });
</script>