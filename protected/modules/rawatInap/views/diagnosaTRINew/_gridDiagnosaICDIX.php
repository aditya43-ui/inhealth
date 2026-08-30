<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Prosedur Tindakan (ICD 9) CM</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div style="margin:3px;">
            <?php
            echo CHtml::htmlButton(
                '<i class="icon-plus icon-white"></i> Tambah Diagnosa ICD 9 CM',
                array(
                    'onclick' => 'tambahDiagnosaix();return false;',
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Diagnosa ICD 9 CM Pasien",
                )
            );
            ?>
        </div>
        <table class="table table-striped table-condensed" id="tbl_diagnosaix">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl. Diagnosa</th>
                    <th>Kelompok Diagnosis</th>
                    <th>Dokter</th>
                    <th>Kode Diagnosa</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain Diagnosa</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$model) > 0) {
                    $i = 0;
                    $status = FALSE;
                    $disabled = FALSE;
                    foreach ($model as $val) {
                        if ($model[$i]['ruangan_id'] != Yii::app()->user->getState('ruangan_id')) {
                            $status = TRUE;
                            $disabled = TRUE;
                        } else {
                            $status = FALSE;
                            $disabled = FALSE;
                        }

                        if(isset($_GET['salin'])){
                            $model[$i]['pasienmorbiditas_id'] = null;
                            $model[$i]['pegawai_id'] = Yii::app()->user->getState('pegawai_id');
                        }
                ?>
                        <tr>
                            <td class="no_urut"><?php echo $i + 1; ?></td>
                            <td>
                                <?php
                                if ($disabled) {
                                    echo $form->textField($model[$i], "[$i]tglmorbiditas", array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => $disabled));
                                } else {
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
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                        )
                                    );
                                }

                                echo $form->hiddenField($model[$i], "[$i]pasienmorbiditas_id");
                                echo $form->hiddenField($model[$i], "[$i]diagnosaicdix_id", array("class"=>"row_diagnosa_ix_id"));
                                echo $form->hiddenField($model[$i], "[$i]pegawai_id");
                                echo $form->hiddenField($model[$i], "[$i]kelompokdiagnosa_id");
                                echo $form->hiddenField($model[$i], "[$i]pasienicd9cm_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $form->dropDownList(
                                    $model[$i],
                                    "[$i]kelompokdiagnosa_id",
                                    CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                                    array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'disabled' => $disabled
                                    )
                                );
                                echo $form->error($model[$i], "[$i]kelompokdiagnosa_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $form->dropDownList(
                                    $model[$i],
                                    "[$i]pegawai_id",
                                    DokterV::model()->getDropDokterByRuangan(),
                                    array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'disabled' => $disabled
                                    )
                                );
                                echo $form->error($model[$i], "[$i]pegawai_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                $this->widget(
                                    'MyJuiAutoComplete',
                                    array(
                                        'name' => "DiagnosaicdixM[$i][diagnosaicdix_kode]",
                                        'sourceUrl' => $this->createUrl('getDiagnosaixM&param=kode'),
                                        'value' => $model[$i]->diagnosatindakan->diagnosaicdix_kode,
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                                    $(this).val( ui.item.diagnosaicdix_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
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
                                            'class' => 'span2 ui-autocomplete-input',
                                            'readonly' => $status,
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
                                        'name' => "DiagnosaicdixM[$i][diagnosaicdix_nama]",
                                        'sourceUrl' => $this->createUrl('getDiagnosaixM&param=nama'),
                                        'value' => $model[$i]->diagnosatindakan->diagnosaicdix_nama,
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                                    $(this).val( ui.item.diagnosaicdix_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
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
                                            'class' => 'span2 ui-autocomplete-input',
                                            'readonly' => $status,
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
                                        'name' => "DiagnosaicdixM[$i][diagnosaicdix_namalainnya]",
                                        'sourceUrl' => $this->createUrl('getDiagnosaixM&param=lainnya'),
                                        'value' => $model[$i]->diagnosatindakan->diagnosaicdix_namalainnya,
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                                    $(this).val( ui.item.diagnosaicdix_namalainnya);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
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
                                            'class' => 'span2 ui-autocomplete-input',
                                            'readonly' => $status,
                                        )
                                    )
                                );
                                ?>
                            </td>
                            <td style="text-align: center">
                                <?php
                                if (!$status) {
                                    echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "javascript:void(0);", array("onclick" => "hapusDiagnosaix(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosis"));
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
</div>

<?php
if(isset($_GET['salin'])){
    $modUraian->pegawai_id = Yii::app()->user->getState('pegawai_id');
}else{
    $modUraian->pegawai_id = $modPendaftaran->pegawai_id;
}
$modUraian->kelompokdiagnosa_id = 1;
?>
<script type="text/javascript">
    var trUraianix = new String(<?php echo CJSON::encode($this->renderPartial($path_view . '_formDiagnosaICDIX', array('form' => $form, 'modUraian' => $modUraian), true)); ?>);

    function setDiagnosaix() {
        var xxx = null;
        $('#tbl_diagnosaix tbody tr').each(function() {
            xxx = $(this).find('input[name$="[diagnosaicdix_kode]"]').val();
            id_diagnosax[xxx] = 'yes';
        });
    }
    setDiagnosaix();

    function tambahDiagnosaix() {
        $('#dialogTambahDiagnosaix').dialog("open");
    }

    function hapusDiagnosaix(mine) {
        var pasienicd9cm_id = $(mine).parents('tr').find('input[name$="[pasienicd9cm_id]"]').val();
        //        if(pasienicd9cm_id.length > 0)
        if (pasienicd9cm_id != '') {
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('/perawatanIntensif/diagnosaTPINew/hapusDiagnosaix') ?>',
                'data': {
                    pasienicd9cm_id: pasienicd9cm_id
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'ok') {
                        var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosa_kode"]').val();
                        delete id_diagnosax[temp_diagnosaicdix_kode];
                        $(mine).parents('tr').remove();
                    } else {
                        myAlert('Data Diagnosis gagal dihapus');
                    }
                },
                'cache': false
            });
            return false;
        } else {
            var temp_diagnosaicdx_kode = $(mine).parents('tr').find('input[name$="[diagnosa_kode]"]').val();
            delete id_diagnosax[temp_diagnosaicdx_kode];
            $(mine).parents('tr').remove();
        }
    }

    function inputDiagnosaix(mine, params, kode) {
        $('#tbl_diagnosaix').children('tbody').find("#is_kosong").remove();
        if (id_diagnosax[kode] == undefined) {
            $('#tbl_diagnosaix').children('tbody').append(trUraianix.replace());
            $("#PPPasienMorbiditasix_99_diagnosaicdix_id").val(params);
            $("#PPPasienMorbiditasix_99_kelompokdiagnosa_id").val(2);
            var x = 0;
            $(mine).parents('tr').find('td').each(
                function() {
                    if (x == 2) {
                        $("#DiagnosaicdixM_99_diagnosaicdix_kode").val($(this).text());
                        $("#diagnosaicdix_kode_temp").val($(this).text());
                        id_diagnosax.push($(this).text());
                    } else if (x == 3) {
                        $("#DiagnosaicdixM_99_diagnosaicdix_nama").val($(this).text());
                    } else if (x == 4) {
                        $("#DiagnosaicdixM_99_diagnosaicdix_namalainnya").val($(this).text());
                    }
                    x++;
                }
            );
            $(mine).parents('table').find('#selectPasien').addClass("animation-loading-1");
            setTimeout(function() {

                renameInputix('PPPasienMorbiditasix', 'tglmorbiditas');
                renameInputix('PPPasienMorbiditasix', 'kelompokdiagnosa_id');
                renameInputix('PPPasienMorbiditasix', 'pegawai_id');

                renameInputix('PPPasienMorbiditasix', 'pasienmorbiditas_id');
                renameInputix('PPPasienMorbiditasix', 'diagnosaicdix_id');
                renameInputix('PPPasienMorbiditasix', 'pasienicd9cm_id');

                renameInputix('DiagnosaicdixM', 'diagnosaicdix_kode');
                renameInputix('DiagnosaicdixM', 'diagnosaicdix_nama');
                renameInputix('DiagnosaicdixM', 'diagnosaicdix_namalainnya');
                $(mine).parents('table').find('#selectPasien').removeClass("animation-loading-1");
                updateSorotIX();
            }, 500);
            id_diagnosax[kode] = 'yes';
        } else {
            myAlert("Diagnosis yang Anda input telah terdaftar, silakan cek kembali!");
        }


    }
    
    function updateSorotIX() {
        $("#diagnosaix-m-grid table tbody tr td").removeClass('sorot');
        $("#tbl_diagnosaix tbody tr .row_diagnosa_ix_id").each(function() {
            $("#diagnosaix-m-grid table tbody #pilih_dialog_ix_" + $(this).val()).parents("tr").find("td").addClass("sorot");
        });
    }

    function renameInputix(modelName, attributeName) {
        var trLength = $('#tbl_diagnosaix tbody tr').length;
        var i = 0;
        $('#tbl_diagnosaix tbody tr').each(function() {
            $(this).find('.no_urut').text(i + 1);
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            jQuery('#PPPasienMorbiditasix_' + i + '_tglmorbiditas').datepicker(
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

            jQuery('#DiagnosaicdixM_' + i + '_diagnosaicdix_kode').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function(event, ui) {
                    return false;
                },
                'select': function(event, ui) {
                    var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosaicdix_kode_temp"]').val();
                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined) {
                        delete id_diagnosax[temp_diagnosaicdix_kode];

                        $(this).val(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_id]"]').val(ui.item.diagnosaicdix_id);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_nama]"]').val(ui.item.diagnosaicdix_nama);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_namalainnya]"]').val(ui.item.diagnosaicdix_namalainnya);

                        id_diagnosax.push(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode_temp]"]').val(ui.item.diagnosaicdix_kode);
                    } else {
                        myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                    }
                    return false;
                },
                'source': '<?php echo $this->createUrl('/perawatanIntensif/diagnosaTPINew/getDiagnosaixM&param=kode'); ?>'
            });

            jQuery('#DiagnosaicdixM_' + i + '_diagnosaicdix_nama').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function(event, ui) {
                    return false;
                },
                'select': function(event, ui) {
                    var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosaicdix_kode_temp"]').val();
                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined) {
                        delete id_diagnosax[temp_diagnosaicdix_kode];

                        $(this).val(ui.item.diagnosaicdix_nama);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_id]"]').val(ui.item.diagnosaicdix_id);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode]"]').val(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_namalainnya]"]').val(ui.item.diagnosaicdix_namalainnya);

                        id_diagnosax.push(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode_temp]"]').val(ui.item.diagnosaicdix_kode);
                    } else {
                        myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                    }
                    return false;
                },
                'source': '<?php echo $this->createUrl('/perawatanIntensif/diagnosaTPINew/getDiagnosaixM&param=nama'); ?>'
            });

            jQuery('#DiagnosaicdixM_' + i + '_diagnosaicdix_namalainnya').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function(event, ui) {
                    return false;
                },
                'select': function(event, ui) {
                    var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosaicdix_kode_temp"]').val();
                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined) {
                        delete id_diagnosax[temp_diagnosaicdix_kode];

                        $(this).val(ui.item.diagnosaicdix_namalainnya);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_id]"]').val(ui.item.diagnosaicdix_id);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode]"]').val(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_nama]"]').val(ui.item.diagnosaicdix_nama);

                        id_diagnosax.push(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode_temp]"]').val(ui.item.diagnosaicdix_kode);
                    } else {
                        myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                    }
                    return false;
                },
                'source': '<?php echo $this->createUrl('/perawatanIntensif/diagnosaTPINew/getDiagnosaixM&param=lainnya'); ?>'
            });

            i++;
        });
    }
    
    $(document).ready(function() {
        updateSorotIX();
    });
</script>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTambahDiagnosaix',
    'options' => array(
        'title' => 'Daftar Diagnosis  ICD 9 CM',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
$modDiagnosaix = new DiagnosaicdixM();
$modDiagnosaix->unsetAttributes();
if (isset($_GET['DiagnosaicdixM'])) {
    $modDiagnosaix->attributes = $_GET['DiagnosaicdixM'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'diagnosaix-m-grid',
        'dataProvider' => $modDiagnosaix->searchDialog(),
        'filter' => $modDiagnosaix,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                    "id" => "selectPasien",
                    "onClick" => "inputDiagnosaix(this,".$data->diagnosaicdix_id.", \"".$data->diagnosaicdix_kode."\");return false;"))
                            .CHtml::hiddenField('pilih_dialog_ix', $data->diagnosaicdix_id, array('id'=>'pilih_dialog_ix_'.$data->diagnosaicdix_id));
                },
            ),
            array(
                'name' => 'diagnosaicdix_nourut',
                'value' => '$data->diagnosaicdix_nourut',
                'filter' => false,
            ),
            'diagnosaicdix_kode',
            'diagnosaicdix_nama',
            'diagnosaicdix_namalainnya',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); updateSorotIX();}',
    )
);
$this->endWidget();
?>