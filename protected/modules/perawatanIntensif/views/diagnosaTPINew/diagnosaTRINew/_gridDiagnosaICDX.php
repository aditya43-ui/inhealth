<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Diagnosa (ICD 10)</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        echo CHtml::htmlButton(
            '<i class="icon-plus icon-white"></i> Tambah Diagnosa 10',
            array(
                'onclick' => 'tambahDiagnosax();return false;',
                'class' => 'btn btn-primary',
                'rel' => "tooltip",
                'title' => "Klik untuk menambahkan Diagnosa 10 Pasien",
            )
        );
        ?>
        <?php
        echo CHtml::hiddenField("idkelompokdiagnosa", "2", array('readonly' => true, 'class' => 'span1'));
        echo CHtml::hiddenField("idkelompokdiagnosa_utama1", "1", array('readonly' => true, 'class' => 'span1'));
        ?>

        <table class="table table-striped table-condensed" id="tbl_diagnosax">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl. Diagnosa</th>
                    <th>Kelompok Diagnosis</th>
                    <th>Dokter</th>
                    <th>Kode Diagnosa</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$model) > 0) {
                    $i = 0;
                    foreach ($model as $val) {
                        //                    if($model[$i]['ruangan_id'] == (isset($modAdmisi->ruangan_id)?$modAdmisi->ruangan_id:$modPendaftaran->ruangan_id)){
                ?>
                        <tr>
                            <td class="no_urut"><?php echo $i + 1; ?></td>
                            <td>
                                <?php
                                $this->widget(
                                    'MyDateTimePicker',
                                    array(
                                        'model' => $model[$i],
                                        'attribute' => "[$i]tglmorbiditas",
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'class' => 'dtPicker2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )
                                );
                                echo $form->hiddenField($model[$i], "[$i]pasienmorbiditas_id");
                                echo $form->hiddenField($model[$i], "[$i]diagnosa_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $form->dropDownList($model[$i], "[$i]kelompokdiagnosa_id", CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"), array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosa(this);'
                                ));
                                echo $form->error($model[$i], "[$i]kelompokdiagnosa_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $form->dropDownList($model[$i], "[$i]pegawai_id", CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"), array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                                ));
                                echo $form->error($model[$i], "[$i]pegawai_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                $this->widget(
                                    'MyJuiAutoComplete',
                                    array(
                                        'name' => "PPDiagnosaM[$i][diagnosa_kode]",
                                        'sourceUrl' => $this->createUrl('getDiagnosaM&param=kode'),
                                        'value' => $model[$i]->diagnosa->diagnosa_kode,
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                                                    $(this).val( ui.item.diagnosa_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_nama]"]\').val(ui.item.diagnosa_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_namalainnya]"]\').val(ui.item.diagnosa_namalainnya);
                                                }else{
                                                    myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                                                }
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => 'Kode Diagnosis',
                                            'aria-haspopup' => "true",
                                            'aria-autocomplete' => 'list',
                                            'role' => 'textbox',
                                            'autocomplete' => 'off',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span2 ui-autocomplete-input'
                                        )
                                    )
                                );
                                ?>
                            </td>
                            <td>
                                <?php
                                $this->widget(
                                    'MyJuiAutoComplete',
                                    array(
                                        'name' => "PPDiagnosaM[$i][diagnosa_nama]",
                                        'sourceUrl' => $this->createUrl('getDiagnosaM&param=nama'),
                                        'value' => $model[$i]->diagnosa->diagnosa_nama,
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                                                    $(this).val( ui.item.diagnosa_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_kode]"]\').val(ui.item.diagnosa_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_namalainnya]"]\').val(ui.item.diagnosa_namalainnya);
                                                }else{
                                                    myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                                                }
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => 'Nama Diagnosis',
                                            'aria-haspopup' => "true",
                                            'aria-autocomplete' => 'list',
                                            'role' => 'textbox',
                                            'autocomplete' => 'off',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span2 ui-autocomplete-input'
                                        )
                                    )
                                );
                                ?>
                            </td>
                            <td>
                                <?php
                                $this->widget(
                                    'MyJuiAutoComplete',
                                    array(
                                        'name' => "PPDiagnosaM[$i][diagnosa_namalainnya]",
                                        'sourceUrl' => $this->createUrl('getDiagnosaM&param=lainnya'),
                                        'value' => $model[$i]->diagnosa->diagnosa_namalainnya,
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                                                    $(this).val( ui.item.diagnosa_namalainnya);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_kode]"]\').val(ui.item.diagnosa_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_nama]"]\').val(ui.item.diagnosa_nama);
                                                }else{
                                                    myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                                                }
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => 'Nama Lainnya Diagnosis',
                                            'aria-haspopup' => "true",
                                            'aria-autocomplete' => 'list',
                                            'role' => 'textbox',
                                            'autocomplete' => 'off',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span2 ui-autocomplete-input'
                                        )
                                    )
                                );
                                ?>
                            </td>
                            <td style="text-align: center; width: 60px;">
                                <?php
                                echo CHtml::link("<i class='icon-form-silang'></i>", "#", array("onclick" => "hapusDiagnosa(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosis"));
                                ?>
                            </td>
                        </tr>
                    <?php
                        $i++;
                        //                    }
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
</div>

<?php
$modUraian->pegawai_id = $modPendaftaran->pegawai_id;
//    $modUraian->kelompokdiagnosa_id = 1;
?>
<script type="text/javascript">
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

    var trUraian = new String(<?php echo CJSON::encode($this->renderPartial($path_view . '_formDiagnosaICDX', array('form' => $form, 'modUraian' => $modUraian), true)); ?>);
    var id_diagnosax = new Array();

    function diagnosaKelompok(obj) {
        var idkelompok = $(obj).val();
        $('#idkelompokdiagnosa').val(idkelompok);
    }

    function setDiagnosax() {
        var xxx = null;
        $('#tbl_diagnosax tbody tr').each(function() {
            xxx = $(this).find('input[name$="[diagnosa_kode]"]').val();
            id_diagnosax[xxx] = 'yes';
        });
    }
    setDiagnosax();

    function tambahDiagnosax() {
        $('#dialogTambahDiagnosax').dialog("open");
    }

    function hapusDiagnosa(mine) {
        var pasienmorbiditas_id = $(mine).parents('tr').find('input[name$="[pasienmorbiditas_id]"]').val();
        if (pasienmorbiditas_id.length > 0) {
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('perawatanIntensif/diagnosaTPINew/hapusDiagnosax') ?>',
                'data': {
                    pasienmorbiditas_id: pasienmorbiditas_id
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'ok') {
                        var temp_diagnosa_kode = $(this).parents("tr").find('input[name$="diagnosa_kode"]').val();
                        delete id_diagnosax[temp_diagnosa_kode];
                        $(mine).parents('tr').remove();
                    } else {
                        myAlert('Data Diagnosis gagal dihapus');
                    }
                },
                'cache': false
            });
            return false;
        } else {
            var temp_diagnosaicdx_kode = $(mine).parents("tr").find('input[name$="[diagnosa_kode]"]').val();
            //            myAlert(temp_diagnosaicdx_kode);
            delete id_diagnosax[temp_diagnosaicdx_kode];
            $(mine).parents('tr').remove();
        }
    }

    function inputDiagnosa(mine, params, kode) {
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

        if (id_diagnosax[kode] == undefined) {

            if (jumlah > 1 && idKelDiagnosa_utama == '2' && idKelDiagnosa == idKelDiagnosa_utama) {
                myAlert("Diagnosis utama tidak boleh lebih dari 1. silakan hubungi tim coding untuk verifikasi");
            } else {
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
                $("#PPPasienMorbiditasT_99_diagnosa_id").val(params);
                var x = 0;
                $(mine).parents('tr').find('td').each(
                    function() {
                        if (x == 2) {
                            $("#PPDiagnosaM_99_diagnosa_kode").val($(this).text());
                            id_diagnosax.push($(this).text());
                        } else if (x == 3) {
                            $("#PPDiagnosaM_99_diagnosa_nama").val($(this).text());
                        } else if (x == 4) {
                            $("#PPDiagnosaM_99_diagnosa_namalainnya").val($(this).text());
                        } else if (x == 5) {
                            if (ada_utama == 1) {
                                $("#PPPasienMorbiditasT_99_kelompokdiagnosa_id").val('<?php echo Params::KELOMPOKDIAGNOSA_TAMBAH; ?>');
                            } else {
                                $("#PPPasienMorbiditasT_99_kelompokdiagnosa_id").val(idKelDiagnosa);
                            }
                        } else if (x == 6) {
                            $("#PPPasienMorbiditasT_99_kasusdiagnosa").val($(this).parents('tr').find('#kasusdiagnosa :selected').text());
                        }
                        x++;
                    }
                );
                $(mine).parents('table').find('#selectPasien').addClass("animation-loading-1");
                setTimeout(function() {
                    renameInput('PPPasienMorbiditasT', 'tglmorbiditas');
                    renameInput('PPPasienMorbiditasT', 'kelompokdiagnosa_id');
                    renameInput('PPPasienMorbiditasT', 'pegawai_id');

                    renameInput('PPPasienMorbiditasT', 'pasienmorbiditas_id');
                    renameInput('PPPasienMorbiditasT', 'diagnosa_id');
                    renameInput('PPPasienMorbiditasT', 'kasusdiagnosa');

                    renameInput('PPDiagnosaM', 'diagnosa_kode');
                    renameInput('PPDiagnosaM', 'diagnosa_nama');
                    renameInput('PPDiagnosaM', 'diagnosa_namalainnya');
                    $(mine).parents('table').find('#selectPasien').removeClass("animation-loading-1");
                }, 500);
                id_diagnosax[kode] = 'yes';
            }
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
            jQuery('#PPPasienMorbiditasT_' + i + '_tglmorbiditas').datepicker(
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

            jQuery('#PPDiagnosaM_' + i + '_diagnosa_kode').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function(event, ui) {
                    return false;
                },
                'select': function(event, ui) {
                    return false;
                },
                'source': '<?php echo $this->createUrl('perawatanIntensif/diagnosaTPINew/getDiagnosaM&param=kode'); ?>'
            });

            jQuery('#PPDiagnosaM_' + i + '_diagnosa_nama').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function(event, ui) {
                    return false;
                },
                'select': function(event, ui) {
                    return false;
                },
                'source': '<?php echo $this->createUrl('perawatanIntensif/diagnosaTPINew/getDiagnosaM&param=nama'); ?>'
            });

            jQuery('#PPDiagnosaM_' + i + '_diagnosa_namalainnya').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function(event, ui) {
                    return false;
                },
                'select': function(event, ui) {
                    return false;
                },
                'source': '<?php echo $this->createUrl('perawatanIntensif/diagnosaTPINew/getDiagnosaM&param=lainnya'); ?>'
            });

            i++;
        });
    }
</script>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTambahDiagnosax',
    'options' => array(
        'title' => 'Daftar Diagnosis 10',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
$modDiagnosa = new PPDiagnosaM('searchDialog');
$modDiagnosa->unsetAttributes();
if (isset($_GET['PPDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'PPdiagnosa-m-grid',
        'dataProvider' => $modDiagnosa->searchDialog(),
        'filter' => $modDiagnosa,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                    "id" => "selectPasien",
                    "onClick" => "inputDiagnosa(this,$data->diagnosa_id, \'$data->diagnosa_kode\');return false;"))',
            ),
            array(
                'name' => 'diagnosa_nourut',
                'value' => '$data->diagnosa_nourut',
                'filter' => false,
            ),
            'diagnosa_kode',
            'diagnosa_nama',
            'diagnosa_namalainnya',
            array(
                'header' => 'Kelompok Diagnosis',
                'value' => 'CHtml::dropDownList("kelompokdiagnosa", "", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id","kelompokdiagnosa_nama"), array("class"=>"span2", "onchange"=>"diagnosaKelompok(this);", "empty"=>"-- Pilih --"))',
                'filter' => false,
                'type' => 'raw',
            ),
            array(
                'header' => 'Kasus Diagnosis',
                'value' => 'CHtml::dropDownList("kasusdiagnosa", "", CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type"=>"kasusdiagnosa")), "lookup_value","lookup_name"), array("class"=>"span2"))',
                'filter' => false,
                'type' => 'raw',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);
$this->endWidget();
?>