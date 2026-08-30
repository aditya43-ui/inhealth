<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jawabankonsul-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Jawaban Konsultasi
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Tanggal dan Jam Jawab</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgljawabpoli',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Sesuai Permohonan Konsultasi, Pada Kasus Ini Dijumpai</label>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model, 'jawaban_konsul', array('class' => 'span8')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Diagnosa</label>
                <div class="controls">
                    <?php
                    echo CHtml::hiddenField("idkelompokdiagnosa", "2", array('readonly' => true, 'class' => 'span1'));
                    echo CHtml::hiddenField("idkelompokdiagnosa_utama1", "1", array('readonly' => true, 'class' => 'span1'));
                    ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'diagnosa_nama',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . Yii::app()->createUrl('ActionAutoComplete/Diagnosa') . '",
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
                                $(this).val( ui.item.diagnosa_nama);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                inputDiagnosa(ui.item.diagnosa_id, ui.item);
                                $("#RJKonsulPoliT_diagnosa_nama").val("");
                                return false;
                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                    ));
                    ?>
                    <?php echo CHtml::activeHiddenField($model, 'diagnosa_id', array('readonly' => true)); ?>
                </div>
            </div>
            <div style="overflow: auto">
                <table class="table table-bordered " id="tbl_diagnosax">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal Diagnosa</th>
                            <th>Kelompok Diagnosa</th>
                            <th>Kasus Diagnosa</th>
                            <th>Dokter</th>
                            <th>Kode Diagnosa</th>
                            <th>Nama Diagnosa</th>
                            <th>Nama Lain</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count((array)$modMorbiditas) > 0) {
                            $i = 0;
                            $status = FALSE;
                            $disabled = FALSE;
                            foreach ($modMorbiditas as $val) {
                                if ($modMorbiditas[$i]['ruangan_id'] != Yii::app()->user->getState('ruangan_id')) {
                                    $status = TRUE;
                                    $disabled = TRUE;
                                } else {
                                    $status = FALSE;
                                    //$disabled = FALSE;
                                    $disabled = TRUE;
                                }

                                $val->tglmorbiditas = MyFormatter::formatDateTimeForUser($val->tglmorbiditas);
                        ?>
                                <tr>
                                    <td class="no_urut"><?php echo $i + 1; ?></td>
                                    <td>
                                        <?php
                                        if ($disabled) {
                                            echo $form->textField($modMorbiditas[$i], "[$i]tglmorbiditas", array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => $disabled));
                                        } else {
                                            $this->widget(
                                                'MyDateTimePicker',
                                                array(
                                                    'model' => $modMorbiditas[$i],
                                                    'attribute' => "[$i]tglmorbiditas",
                                                    'mode' => 'datetime',
                                                    'options' => array(
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions' => array(
                                                        'readonly' => true,
                                                        'class' => 'dtPicker2',
                                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                                    ),
                                                )
                                            );
                                        }

                                        echo $form->hiddenField($modMorbiditas[$i], "[$i]pasienmorbiditas_id");
                                        echo $form->hiddenField($modMorbiditas[$i], "[$i]diagnosa_id");
                                        echo $form->hiddenField($modMorbiditas[$i], "[$i]pegawai_id");
                                        echo $form->hiddenField($modMorbiditas[$i], "[$i]kelompokdiagnosa_id");
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $form->dropDownList($modMorbiditas[$i], "[$i]kelompokdiagnosa_id", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"), array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosa(this);', 'disabled' => $disabled,
                                        ));
                                        echo $form->error($modMorbiditas[$i], "[$i]kelompokdiagnosa_id");
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $form->dropDownList($modMorbiditas[$i], "[$i]kasusdiagnosa", CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type" => "kasusdiagnosa")), "lookup_value", "lookup_name"), array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosa(this);', 'disabled' => $disabled,
                                        ));
                                        echo $form->error($modMorbiditas[$i], "[$i]kasusdiagnosa");
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $form->dropDownList($modMorbiditas[$i], "[$i]pegawai_id", CHtml::listData(DokterV::model()->findAllByAttributes(array(
                                            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                                            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                                        )), "pegawai_id", "namaLengkap"), array(
                                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'disabled' => $disabled,
                                        ));
                                        echo $form->error($modMorbiditas[$i], "[$i]pegawai_id");
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $modMorbiditas[$i]->diagnosa->diagnosa_kode; ?>
                                    </td>
                                    <td>
                                        <?php echo $modMorbiditas[$i]->diagnosa->diagnosa_nama; ?>
                                    </td>
                                    <td>
                                        <?php echo $modMorbiditas[$i]->diagnosa->diagnosa_namalainnya; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php
                                        if (!$status) {
                                            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "javascript:void(0);", array("onclick" => "hapusDiagnosa(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosis"));
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tr id="is_kosong">
                                <td align="center" colspan="8">Data tidak ditemukan</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="control-group">
                <label class="control-label">Saran Tindak Medik / Pengobatan</label>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model, 'saran_tindakan', array('class' => 'span8')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Prof. / dr. / Spesialis</label>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'nama_pegawai',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . Yii::app()->createUrl('ActionAutoComplete/PegawaiRuangan') . '",
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
                                $(this).val( ui.item.nama_pegawai);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $("#triase_id").val(ui.item.triase_id); 
                                $("#RJKonsulPoliT_pegawaikonsul_id").val(ui.item.pegawai_id);
                                return false;
                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogDokter'),
                        'htmlOptions' => array(
                            'onblur' => '
                                if($(this).val() == ""){
                                    $("#RJKonsulPoliT_pegawaikonsul_id").val("");
                                }
                            '
                        ),
                    ));
                    ?>
                    <?php echo CHtml::activeHiddenField($model, 'pegawaikonsul_id', array('readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?= CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => (isset($_GET['sukses'])) ? true : false)); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Daftar Diagnosis 10',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php
$modDiagnosa = new RJDiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['RJDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['RJDiagnosaM'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'giagnosautama-m-grid',
        'dataProvider' => $modDiagnosa->search(),
        'filter' => $modDiagnosa,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function ($data) {

                    $attr = CJSON::encode($data->attributes);

                    return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                        'class' => 'btn-small',
                        'id' => 'selectPasien',
                        'onclick' => "
                        inputDiagnosa(" . $data->diagnosa_id . ", " . $attr . ");
                        $('#RJKonsulPoliT_diagnosa_id').val(" . $data->diagnosa_id . ");
                        $('#RJKonsulPoliT_diagnosa_nama').val('" . $data->diagnosa_nama . "');
                        $('#RJKonsulPoliT_diagnosa_nama').val('');
                        $('#dialogDiagnosa').dialog('close'); return false;"
                    ));
                },
            ),
            'diagnosa_kode',
            array(
                'header' => 'Diagnosis',
                'name' => 'diagnosa_nama',
                'value' => '$data->diagnosa_nama',
            ),
            array(
                'header' => 'Catatan',
                'name' => 'diagnosa_namalainnya',
                'value' => '$data->diagnosa_namalainnya',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Prof. / dr. / Spesialis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$format = new MyFormatter();
$modMedis = new PegawairuanganV('search');
$modMedis->unsetAttributes();
$modMedis->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['RJPegawaiM'])) {
    $modMedis->attributes = $_GET['RJPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modMedis->search(),
    'filter' => $modMedis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => "
                        $('#RJKonsulPoliT_pegawaikonsul_id').val(" . $data->pegawai_id . ");
                        $('#RJKonsulPoliT_nama_pegawai').val('" . $data->nama_pegawai . "');
                        $('#dialogDokter').dialog('close');
                        return false;
                    "
                ));
            },
        ),
        array(
            'header' => 'Nama',
            'filter' => CHtml::activeTextField($modMedis, 'nama_pegawai', array('class' => 'span3')),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>
    var trUraian = new String(<?php echo CJSON::encode($this->renderPartial('konsultasiInternal/_formDiagnosaICDX', array('form' => $form, 'modUraian' => $modUraian), true)); ?>);
    var id_diagnosax = new Array();

    function cekKelDianosa(obj) {
        var ada_utama = 0;
        $('#tbl_diagnosax tbody tr').each(function() {
            kel = $(this).find('select[name$="[kelompokdiagnosa_id]"]').val();
            if (kel == '<?php echo Params::KELOMPOKDIAGNOSA_UTAMA ?>') {
                ada_utama++;
            }
        });
        if (ada_utama > 1 && $(obj).val() == '<?php echo Params::KELOMPOKDIAGNOSA_UTAMA ?>') {
            myAlert("Diagnosis utama tidak boleh lebih dari 1");
            $(obj).val('<?php echo Params::KELOMPOKDIAGNOSA_TAMBAH ?>');
        }
    }

    function hapusDiagnosa(mine) {
        var pasienmorbiditas_id = $(mine).parents('tr').find('input[name$="[pasienmorbiditas_id]"]').val();
        myConfirm("Anda yakin untuk menghapus Diagnosis (ICD X) ini?", "Peringatan", function(r) {
            if (r) {
                if (pasienmorbiditas_id.length > 0) {
                    jQuery.ajax({
                        'url': '<?php echo Yii::app()->createUrl('rawatJalan/diagnosaIX/hapusDiagnosax') ?>',
                        'data': {
                            pasienmorbiditas_id: pasienmorbiditas_id
                        },
                        'type': 'post',
                        'dataType': 'json',
                        'success': function(data) {
                            if (data.status == 'ok') {
                                var temp_diagnosa_id = $(this).parents("tr").find('input[name$="diagnosa_id"]').val();
                                delete id_diagnosax[temp_diagnosa_id];
                                $(mine).parents('tr').remove();
                            } else {
                                myAlert('Data Diagnosis gagal dihapus');
                            }
                        },
                        'cache': false
                    });
                    return false;
                } else {
                    var temp_diagnosa_id = $(mine).parents("tr").find('input[name$="[diagnosa_id]"]').val();
                    delete id_diagnosax[temp_diagnosa_id];
                    $(mine).parents('tr').remove();
                }
            }
        });
    }

    function inputDiagnosa(diagnosa_id, params) {
        var jumlah = 1;
        $('#tbl_diagnosax tbody tr').each(function() {
            kel = $(this).find('select[name$="[kelompokdiagnosa_id]"]').val();
            if (kel == '<?php echo Params::KELOMPOKDIAGNOSA_UTAMA ?>') {
                jumlah++;
            }
        });
        var idKelDiagnosa = $('#idkelompokdiagnosa').val();
        var idKelDiagnosa_utama = $('#idkelompokdiagnosa_utama1').val();
        $('#tbl_diagnosax').children('tbody').find("#is_kosong").remove();

        if (id_diagnosax[diagnosa_id] == undefined) {

            if (jumlah > 1 && idKelDiagnosa_utama == '2' && idKelDiagnosa == idKelDiagnosa_utama) {
                idKelDiagnosa = '<?php echo Params::KELOMPOKDIAGNOSA_TAMBAH ?>';
            }
            var ada_utama = 0;
            $('#tbl_diagnosax tbody tr').each(function() {
                kel = $(this).find('select[name$="[kelompokdiagnosa_id]"]').val();
                if (kel == '<?php echo Params::KELOMPOKDIAGNOSA_UTAMA ?>') {
                    ada_utama = 1;
                }
            });

            if (idKelDiagnosa == '2') {
                $('#idkelompokdiagnosa_utama1').val(idKelDiagnosa);
            }
            $('#tbl_diagnosax').children('tbody').append(trUraian.replace());

            $("#RJPasienMorbiditasT_99_diagnosa_id").val(diagnosa_id);
            $("#tbl_diagnosax tbody tr:last-child .diagnosa_kode").html(params.diagnosa_kode);
            $("#tbl_diagnosax tbody tr:last-child .diagnosa_nama").html(params.diagnosa_nama);
            $("#tbl_diagnosax tbody tr:last-child .diagnosa_namalainnya").html(params.diagnosa_namalainnya);

            if (ada_utama == 1) {
                $("#RJPasienMorbiditasT_99_kelompokdiagnosa_id").val('<?php echo Params::KELOMPOKDIAGNOSA_TAMBAH; ?>');
            } else {
                $("#RJPasienMorbiditasT_99_kelompokdiagnosa_id").val(idKelDiagnosa);
            }

            id_diagnosax.push(diagnosa_id);

            setTimeout(function() {
                renameInput('RJPasienMorbiditasT', 'tglmorbiditas');
                renameInput('RJPasienMorbiditasT', 'kelompokdiagnosa_id');
                renameInput('RJPasienMorbiditasT', 'pegawai_id');

                renameInput('RJPasienMorbiditasT', 'pasienmorbiditas_id');
                renameInput('RJPasienMorbiditasT', 'diagnosa_id');
                renameInput('RJPasienMorbiditasT', 'kasusdiagnosa');
            }, 500);
            id_diagnosax[diagnosa_id] = 'yes';

        } else {
            myAlert("Diagnosis yang Anda input telah terdaftar, silakan cek kembali!");
        }
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#tbl_diagnosax tbody tr').length;
        var i = 0;
        $('#tbl_diagnosax tbody tr').each(function() {
            $(this).find('.no_urut').text(i + 1);
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            jQuery('#RJPasienMorbiditasT_' + i + '_tglmorbiditas').datepicker(
                jQuery.extend({
                        showMonthAfterYear: false
                    },
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd M yy',
                        'maxDate': 'd',
                        'timeText': 'Waktu',
                        'hourText': 'Jam',
                        'minuteText': 'Menit',
                        'secondText': 'Detik',
                        'showSecond': true,
                        'timeOnlyTitle': 'Pilih Waktu',
                        'timeFormat': 'hh:mm:ss',
                        'changeYear': true,
                        'changeMonth': true,
                        'showAnim': 'fold',
                        'yearRange': '-80y:+20y'
                    }
                )
            );
            i++;
        });
    }

    $(document).ready(function() {
        <?php if (count((array)$modMorbiditas)) { ?>
            <?php foreach ($modMorbiditas as $key => $value) { ?>
                id_diagnosax.push(<?= $value->diagnosa->diagnosa_id ?>);
                id_diagnosax[<?= $value->diagnosa->diagnosa_id ?>] = 'yes';
            <?php } ?>
        <?php } ?>
    });
</script>