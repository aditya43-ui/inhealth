<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('daftarPasien/index'),
    'Konsultasi Gizi',
);
?>
<?php

if (isset($_GET['sukses']) && $_GET['sukses'] == 1) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
}


$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jawabankonsul-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Konsultasi <b>Gizi Pasien</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    echo $this->renderPartial('konsultasiInternal/_permohonan', 
        array('modPendaftaran' => $modPendaftaran, 
            'modPasien' => $modPasien, 
            'model' => $modKonsul, 
            'pasienMorbiditas' => $pasienMorbiditas
        )
    ); 
    ?>
    <?php
        echo $this->renderPartial('konsultasiInternal/_jawaban', 
            array('modPendaftaran' => $modPendaftaran, 
                'modPasien' => $modPasien, 
                'model' => $modKonsul, 
                // 'modUraian' => $modUraian, 
                'modMorbiditas' => $modMorbiditas
            )
        );
        /* 
    ?>
        <div class="control-group">
            <table style="width: 100%">
                <tr>
                    <td>
                        <label class=""><br>Sesuai Permohonan Konsultasi, Pada Kasus Ini
                            Dijumpai</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo CHtml::activeTextArea($modKonsul, 'uraian_konsuljawaban', array('readonly'=>!$modKonsul->isNewRecord,'style' => 'width: 100%;', 'rows' =>12)); ?>
                    </td>
                </tr>
            </table>
            <div class="controls">
            </div>
        </div>
        */ ?>
        <?php /*
        <div class="form-actions">
            <?= CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => !$modKonsul->isNewRecord)); ?>
        </div>
        */ ?>
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
$modDiagnosa = new DiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
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
                        $('#KonsulpoliT_pegawaikonsul_id').val(" . $data->pegawai_id . ");
                        $('#KonsulpoliT_nama_pegawai').val('" . $data->nama_pegawai . "');
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
    var trUraian = new String(<?php echo CJSON::encode($this->renderPartial('konsultasiInternal/_formDiagnosaICDX', array('form' => $form, 'modUraian' => new PasienmorbiditasT), true)); ?>);
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
        <?php /* if (count((array)$modMorbiditas)) { ?>
            <?php foreach ($modMorbiditas as $key => $value) { ?>
                id_diagnosax.push(<?= $value->diagnosa->diagnosa_id ?>);
                id_diagnosax[<?= $value->diagnosa->diagnosa_id ?>] = 'yes';
            <?php } ?>
        <?php } */ ?>
    });
</script>