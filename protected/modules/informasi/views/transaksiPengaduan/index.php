<?php $linkHalaman = CustomFunction::getUrlByMenuID(3194); ?>
<?php
/**
 * untuk Transaksi pengaduan
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @author Elsa Diah P <elsadiahp.@gmail.com>
 * 
 */
?>
<style type="text/css">
    table tr td.rights {
        text-align: right;
        padding-right: 10px;
        width: 100px;
    }

    table tr td img {
        width: 50px;
    }

    table tr td {
        vertical-align: middle;
        padding: 0 10px;
    }

    .foricon {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 10px;
        font-weight: bold;
        text-align: center;
        font-size: 10px;
        min-width: 100px;
        cursor: pointer;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2);
    }

    .foricon:hover {
        background-color: #3093c7;
    }

    .iconactive {
        background-color: #3093c7;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengaduan Pelayanan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $sukses = null;
        if (isset($_GET['sukses'])) {
            $sukses = $_GET['sukses'];
        }
        if ($sukses > 0)
            Yii::app()->user->setFlash('success', "Transaksi Pengaduan Pelayanan berhasil disimpan!");
        ?>
        <?php
        $this->breadcrumbs = array(
            'Transaksi Pengaduan Pelayanan',
        );
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'inputPengaduan-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Pengaduan / Survei</label>
                    <div class="controls">
                        <?php $model->kepuasanpasien_tgl = MyFormatter::formatDateTimeForUser($model->kepuasanpasien_tgl); ?>
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'kepuasanpasien_tgl',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3 kepuasanpasien_tgl'),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Media Pengaduan / Survei <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'mediapengaduan', LookupM::getItemsUrutan('media_pengaduan'), array('class' => 'form-control span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Kategori Pengaduan</label>
                    <div class="controls">
                        <?php 
                            echo $form->dropDownList($model, 'kategoripengaduan_id', KategoriPengaduanM::getKategoriPengaduanItems(), array(
                                'empty' => '-- Pilih --',
                                'class' => 'span3 kategoripengaduan_id',
                                'onchange' => 'setDate(this);'));
                        ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'kp_namapelapor', array('placeholder' => 'Nama Pelapor', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'kp_noidentitasn_pelapor', array('placeholder' => 'No. Identitas Pelapor', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'kp_alamat_pelapor', array('placeholder' => 'Alamat', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
                <?php echo $form->textFieldRow($model, 'kp_hp_pelapor', array('placeholder' => 'Nomer HP', 'class' => 'span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <?php echo CHtml::label("Uraian Keluhan <span class='required'>*</span>", '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'kp_deskripsi_aduan', array('placeholder' => 'Uraian Keluhan', 'rows' => 5, 'cols' => 50, 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Tindakan Awal", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'kp_tindakawal_desk', array('placeholder' => 'Tindakan Awal', 'rows' => 5, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Tindakan Lanjut", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'kp_tindaklanjut_desk', array('placeholder' => 'Tindakan Lanjut', 'rows' => 5, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">No Rekam Medik <span class='required'>*</span></label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'no_rekam_medik',
                            'value' => $model->no_rekam_medik,
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasien') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
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
                                            $(this).val( ui.item.value);
                                            setPasien(ui.item.pasien_id, ui.item.no_rekam_medik, ui.item.nama_pasien);
                                            return false;
                                        }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPasien'),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'numbers-only span3',
                                'required' => 'required'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'no_rekam_medik'); ?>
                        <?php echo $form->hiddenField($model, 'pasien_id', array('readonly' => true)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                <div class="control-group">
                    <label class="control-label">Instalasi Terkait Pengaduan <span class="required">*</span></label>
                    <div class="controls" style="margin-top:1%">
                        <?php
                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data); }',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Ruangan <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'ruangan_id',
                            CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'),
                            array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih  --',)
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Target Tanggal Penyelesaian</label>
                    <div class="controls">
                        <?php $model->kp_tindaklanjut_tgl = MyFormatter::formatDateTimeForUser($model->kp_tindaklanjut_tgl); ?>
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'kp_tindaklanjut_tgl',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                // 'disabled' => true
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3 kp_tindaklanjut_tgl'),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-poll"></i> Survei Kepuasan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table>
                    <?php
                    if ($model->isNewRecord) {
                        $modLayananSurvie = LayanansurveiM::model()->findAll('layanansurvei_aktif = true ORDER BY layanansurvei_nama ASC');
                    } else {
                        $modLayananSurvie = LayanansurveiM::model()->findAllByAttributes(array(
                            'layanansurvei_id' => $model->layanansurvei_id,
                        ));
                    }
                    if (count((array)$modLayananSurvie) > 0) {
                        foreach ($modLayananSurvie as $i => $dataSurvei) {
                            $layanansurvei_id = $dataSurvei->layanansurvei_id;
                    ?>
                            <tr>
                                <td>
                                    <?php echo $dataSurvei->layanansurvei_nama; ?>
                                    <?php echo CHtml::hiddenField('layanansurveiicon[' . $i . '][layanansurvei_id]', $dataSurvei->layanansurvei_id, ['class' => 'layanansurvei_id']); ?>
                                </td>
                                <td>
                                    <div class="foricon iconsurvei_<?php echo $i; ?> <?php echo $model->kp_sangatpuas == 1 ? 'iconactive' : ''; ?>" onclick="sangatPuas(<?php echo $i; ?>, this);">
                                        <img src='data/images/informasi/newemoticon/sangatpuas.png' height="40">
                                        <br>SANGAT PUAS
                                        <?php echo CHtml::hiddenField('layanansurveiicon[' . $i . '][kp_sangatpuas]', $model->kp_sangatpuas, array('readonly' => true, 'class' => "kp_sangatpuas")); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="foricon iconsurvei_<?php echo $i; ?> <?php echo $model->kp_puas == 1 ? 'iconactive' : ''; ?>" onclick="puas(<?php echo $i; ?>, this);">
                                        <img src='data/images/informasi/newemoticon/puas.png' height="40">
                                        <br>PUAS
                                        <?php echo CHtml::hiddenField('layanansurveiicon[' . $i . '][kp_puas]', $model->kp_puas, array('readonly' => true, 'class' => "kp_puas")); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="foricon iconsurvei_<?php echo $i; ?> <?php echo $model->kp_tidakpuas == 1 ? 'iconactive' : ''; ?>" onclick="tidakPuas(<?php echo $i; ?>, this);">
                                        <img src='data/images/informasi/newemoticon/tidakpuas.png' height="40">
                                        <br>TIDAK PUAS
                                        <?php echo CHtml::hiddenField('layanansurveiicon[' . $i . '][kp_tidakpuas]', $model->kp_tidakpuas, array('readonly' => true, 'class' => "kp_tidakpuas")); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="foricon iconsurvei_<?php echo $i; ?> <?php echo $model->kp_sangattidakpuas == 1 ? 'iconactive' : ''; ?>" onclick="sangattidakPuas(<?php echo $i; ?>, this);">
                                        <img src='data/images/informasi/newemoticon/sangattidakpuas.png' height="40">
                                        <br>SANGAT TIDAK PUAS
                                        <?php echo CHtml::hiddenField('layanansurveiicon[' . $i . '][kp_sangattidakpuas]', $model->kp_sangattidakpuas, array('readonly' => true, 'class' => "kp_sangattidakpuas")); ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo CHtml::textArea(
                                        'layanansurveiicon[' . $i . '][keterangankepuasan]',
                                        $model->isNewRecord ? '' : $model->keterangankepuasan,
                                        array('placeholder' => 'Catatan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
                                    ); ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class='form-actions'>
            <?php
            $disableSave = false;
            if (isset($_GET['sukses'])) {
                $disableSave = true;
            }
            ?>
            <?php
            if (@$_GET['sukses'] == 1) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                    'class' => 'btn btn-danger', 'type' => 'button',
                    'title' => 'Simpan',
                    'disable' => true,
                    'onclick' => "return false",
                    'style' => 'cursor:not-allowed;'
                ));
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                    'title' => 'Simpan',
                    'class' => 'btn btn-danger',
                    'type' => 'submit',
                    'onclick' => 'return cek()',
                    'id' => 'btn_simpan',
                ));
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            }
            ?>
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
    </div>
</div>
<?php
if (@$_GET['SUKSES'] == 1) {
    $kepuasanpasien_id = $_GET['kepuasanpasien_id'];;
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $js = <<< JSCRIPT
function print(caraPrint)
{
	window.open("${urlPrint}"+"&kepuasanpasien_id="+${kepuasanpasien_id},"",'location=_new, width=850px, height=600px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDataPasien = new INPasienM('searchDialog');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['INPasienM'])) {
    $modDataPasien->attributes = $_GET['INPasienM'];
    $modDataPasien->tanggal_lahir =  isset($_GET['INPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['INPasienM']['tanggal_lahir']) : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modDataPasien->searchDialog(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasien(\"$data->pasien_id\", \"$data->no_rekam_medik\", \"$data->nama_pasien\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modDataPasien,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
            }',
));
$this->endWidget();
?>
<script>
    function setPasien(pasien_id, no_rekam_medik, nama_pasien) {
        $('#no_rekam_medik').val(no_rekam_medik);
        $('#INKepuasanpasienT_pasien_id').val(pasien_id);
        $('#INKepuasanpasienT_nama_pasien').val(nama_pasien);
    }

    function sangatPuas(index, obj) {
        $(".iconsurvei_" + index).removeClass("iconactive");
        $(obj).addClass("iconactive");
        $(".kp_sangatpuas").eq(index).val("1");
        $(".kp_puas").eq(index).val("0");
        $(".kp_tidakpuas").eq(index).val("0");
        $(".kp_sangattidakpuas").eq(index).val("0");
    }

    function puas(index, obj) {
        $(".iconsurvei_" + index).removeClass("iconactive");
        $(obj).addClass("iconactive");
        $(".kp_sangatpuas").eq(index).val("0");
        $(".kp_puas").eq(index).val("1");
        $(".kp_tidakpuas").eq(index).val("0");
        $(".kp_sangattidakpuas").eq(index).val("0");
    }

    function tidakPuas(index, obj) {
        $(".iconsurvei_" + index).removeClass("iconactive");
        $(obj).addClass("iconactive");
        $(".kp_sangatpuas").eq(index).val("0");
        $(".kp_puas").eq(index).val("0");
        $(".kp_tidakpuas").eq(index).val("1");
        $(".kp_sangattidakpuas").eq(index).val("0");
    }

    function sangattidakPuas(index, obj) {
        $(".iconsurvei_" + index).removeClass("iconactive");
        $(obj).addClass("iconactive");
        $(".kp_sangatpuas").eq(index).val("0");
        $(".kp_puas").eq(index).val("0");
        $(".kp_tidakpuas").eq(index).val("0");
        $(".kp_sangattidakpuas").eq(index).val("1");
    }

    function cek() {
        var kp_sangatpuas = $(".kp_sangatpuas").val();
        var kp_puas = $(".kp_puas").val();
        var kp_tidakpuas = $(".kp_tidakpuas").val();
        var kp_sangattidakpuas = $(".kp_sangattidakpuas").val();
        if (kp_sangatpuas != 0 || kp_puas != 0 || kp_tidakpuas != 0 | kp_sangattidakpuas != 0) {
            formSubmit(this, event);
        } else {
            alert('Survei Kepuasan wajib diisi');
        }
    }

    function setDate() {
        var id = $(".kategoripengaduan_id").val();
        var tgl = $(".kepuasanpasien_tgl").val();
        
        $.ajax({
            type : 'POST',
            url: '<?php echo $this->createUrl('getDate'); ?>',
            data : {
                id : id,
                tgl : tgl
            },
            dataType: 'json',
            success: function(data){
                $(".kp_tindaklanjut_tgl").val(data.kp_tindaklanjut_tgl)
            },
            error : function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    $(document).ready(function() {
        <?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr("readonly", true);
            $(".btn-mini, .add-on").detach();
            <?php
            $konsys = KonfigsystemK::model()->find();
            if ($konsys->is_nodejsaktif) { ?>
                <?php if (!empty($konsys->nodejs_host)) {  ?>
                    var chatServer = '<?php echo $konsys->nodejs_host; ?>';
                    var chatPort = '<?php echo $konsys->nodejs_port; ?>';
                <?php } else {  ?>
                    var chatServer = 'localhost';
                    var chatPort = '3000';
                <?php  } ?>
                socket = io.connect(chatServer + ':' + chatPort, {
                    secure: true
                });
                socket.emit('senddasboard', {
                    my: 'data'
                });
            <?php } ?>
        <?php } ?>
    })
</script>
<script>
    $(document).ready(function() {
        $("#INKepuasanpasienT_kp_namapelapor").focus();
    });
</script>
