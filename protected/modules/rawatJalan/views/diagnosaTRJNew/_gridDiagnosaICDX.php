<style>
    tr td .add-on,
    tr td label,
    tr td input {
        margin: 0 !important;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i><b>Tabel Diagnosa Penyakit (ICD 10)
        </div>
    </div>
    <div class="panel-body table-responsive" style="overflow-y: auto;">
        <?php
        
        $is_pasienMorbiditas = PasienmorbiditasR::model()->findByAttributes(array('is_verifikasidiagnosa' => true, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id));
        $status = empty($is_pasienMorbiditas) ? false : true;
        if(!$status){
            echo CHtml::htmlButton(
                '<i class="icon-plus icon-white"></i> Tambah Diagnosa ICD 10',
                array(
                    'onclick' => 'tambahDiagnosax();return false;',
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Diagnosa 10 Pasien",
                )
            );
        }else{
            echo "";
        }
        ?>
        <?php
        echo CHtml::hiddenField("idkelompokdiagnosa", "1", array('readonly' => true, 'class' => 'span1'));
        echo CHtml::hiddenField("idkelompokdiagnosa_utama1", "2", array('readonly' => true, 'class' => 'span1'));
        ?>
        <table class="table table-striped table-condensed" id="tbl_diagnosax">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl. Diagnosa</th>
                    <th>Kelompok Diagnosis</th>
                    <th>Dokter</th>
                    <th>PPDS</th>
                    <th>Kode Diagnosa</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain</th>
                    <th>Kasus Diagnosa</th>
                    <th>Status Diagnosa</th>
                    <!-- <th>Keterangan Diagnosa</th> -->
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$model) > 0) {
                    $i = 0;
                    $x = 1;
                    
                    // echo '<pre>';print_r($model);die;
                    foreach ($model as $val) {
                        // if ($val['ruangan_id']==Yii::app()->user->getState('ruangan_id')){
                        // if ($val['ruangan_id'] == (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modPendaftaran->ruangan_id)) {

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
                                echo $form->hiddenField($model[$i], "[$i]diagnosa_id", array("class" => "row_diagnosa_x_id"));
                                echo $form->hiddenField($model[$i], "[$i]create_ruangan");
                                echo $form->hiddenField($model[$i], "[$i]create_loginpemakai_id");

                                ?>
                            </td>
                            <td>
                                <?php
                                 $condition = '';
                                 if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RD) {
                                     $condition = 'and kelompokdiagnosa_id != 4';
                                 }
                                echo $form->dropDownList(
                                    $model[$i],
                                    "[$i]kelompokdiagnosa_id",
                                    CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE " . $condition), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                                    array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'onchange' => 'cekKelDianosa(this);'
                                    )
                                );
                                echo $form->error($model[$i], "[$i]kelompokdiagnosa_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                // $penunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=> $model[$i]->pendaftaran_id));
                                // if(!empty($penunjang)) {
                                //     $model[$i]->pegawai_id = $penunjang->pegawai;
                                // }
                                echo $form->dropDownList(
                                    $model[$i],
                                    "[$i]pegawai_id",
                                    CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                                    array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 pegawai_id_load',
                                        'readonly' => true
                                    )
                                );
                                echo $form->error($model[$i], "[$i]pegawai_id");
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $form->dropDownList(
                                    $model[$i],
                                    "[$i]ppds_id",
                                    CHtml::listData(PpdsM::model()->findAll(), "ppds_id", "ppds_nama"),
                                    array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => false, 'empty' => '--- Pilih ---'
                                    )
                                );
                                echo $form->error($model[$i], "[$i]ppds_id");
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
                                echo "Keterangan Diagnosa" . "<br>";
                                echo $form->textArea($model[$i], "[$i]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3));

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
                            <td>
                                <?php
                                echo $form->dropDownList(
                                    $model[$i],
                                    "[$i]kasusdiagnosa",
                                    CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type" => "kasusdiagnosa")), "lookup_value", "lookup_name"),
                                    array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosa(this);'
                                    )
                                );
                                echo $form->error($model[$i], "[$i]kasusdiagnosa");
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $form->dropDownList(
                                    $model[$i],
                                    "[$i]statusdiagnosapasien",
                                    LookupM::getItems('statusdiagnosapasien')
                                );
                                echo $form->error($model[$i], "[$i]statusdiagnosapasien");
                                ?>
                            </td>

                            <td style="text-align: center">
                                <?php
                                if(!$status){
                                    echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#", array("onclick" => "hapusDiagnosa(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosis"));
                                }
                               
                                ?>
                            </td>
                        </tr>
                        <script>
                            $(document).ready(function() {
                                var ppds = jQuery('#<?php echo CHtml::activeId($model[$i], "[$i]ppds_id") ?>');
                                jQuery(ppds).multiselect({
                                    includeSelectAllOption: false,
                                    buttonClass: "form-control",
                                    maxHeight: 300,
                                    buttonWidth: '182px',
                                    enableCaseInsensitiveFiltering: true
                                }).hide();

                            });
                        </script>
                <?php
                        $i++;
                    }
                }
                // } else {
                ?>
                <!-- <tr id="is_kosong">
                        <td align="center" colspan="9">Data tidak ditemukan</td>
                    </tr> -->
                <!-- <tr id="is_kosong">
                        <td align="center" colspan="10">Data tidak ditemukan</td>
                    </tr> -->
                <?php
                // }
                ?>
            </tbody>
        </table>
        <?php //echo CHtml::textField("ket_diagnosa", "", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3)); 
        ?>

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
                        myAlert(data.msg);
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
        var cekKelompokDiagnosaUtama = 0;
        $('#tbl_diagnosax tbody tr').each(function() {
            kel = $(this).find('select[name$="[kelompokdiagnosa_id]"]').val();
            if (kel == '<?php echo Params::KELOMPOKDIAGNOSA_UTAMA ?>') {
                jumlah++;
                cekKelompokDiagnosaUtama++;
            }
        });
        console.log(cekKelompokDiagnosaUtama);
        var kelompokdiagnosaklik = $(mine).parents('tr').find('.kelompokdiagnosa').val();
        if(kelompokdiagnosaklik == '') {
            myAlert('Kelompok Diagnosa belum dipilih');
            return false;
        }

        if(kelompokdiagnosaklik == '') {
            var idKelDiagnosa = $('#idkelompokdiagnosa_utama1').val();
        } else {
            var idKelDiagnosa = kelompokdiagnosaklik;
        }   
        var idKelDiagnosa_utama = $('#idkelompokdiagnosa_utama1').val();
        console.log(kelompokdiagnosaklik, 'kelompokdiagnosaklik');
        console.log(idKelDiagnosa_utama, 'idKelDiagnosa_utama');
        console.log(idKelDiagnosa, 'idKelDiagnosa');
        $('#tbl_diagnosax').children('tbody').find("#is_kosong").remove();

        if (id_diagnosax[kode] == undefined) {

            if (jumlah > 1 && idKelDiagnosa_utama == '2' && idKelDiagnosa == idKelDiagnosa_utama) {
                myAlert("Diagnosis utama tidak boleh lebih dari 1. silakan hubungi tim coding untuk verifikasi");
            } else {
                var ada_utama = 0;
                $('#tbl_diagnosax tbody tr').each(function() {
                    kel = $(this).find('select[name$="[kelompokdiagnosa_id]"]').val();
                    pegawai_id = $(this).find('select[name$="[pegawai_id]"]').val();
                    pegawai_idlogin = '<?= Yii::app()->user->getState('pegawai_id') ?>';
                    if (kel == '<?php echo Params::KELOMPOKDIAGNOSA_UTAMA ?>' && pegawai_id == pegawai_idlogin) {
                        ada_utama = 1;
                    }
                });
                // console.log(ada_utama, 'ada utama');return false;
                if (idKelDiagnosa == '2') {
                    $('#idkelompokdiagnosa_utama1').val(idKelDiagnosa);
                }
                $('#tbl_diagnosax').children('tbody').append(trUraian.replace());
                $("#PPPasienMorbiditasT_99_diagnosa_id").val(params);
                var x = 0;
                $(mine).parents('tr').find('td').each(
                    function() {
                        console.log(x);
                        if (x == 2) {
                            $("#PPDiagnosaM_99_diagnosa_kode").val($(this).text());
                            id_diagnosax.push($(this).text());
                        } else if (x == 3) {
                            $("#PPDiagnosaM_99_diagnosa_nama").val($(this).text());
                        } else if (x == 4) {
                            $("#PPDiagnosaM_99_diagnosa_namalainnya").val($(this).text());
                        } else if (x == 5) {
                            if (ada_utama == 1) {
                                $("#PPPasienMorbiditasT_99_kelompokdiagnosa_id").val(idKelDiagnosa);
                            } else {
                                $("#PPPasienMorbiditasT_99_kelompokdiagnosa_id").val(idKelDiagnosa);
                            }
                        } else if (x == 6) {
                            $("#PPPasienMorbiditasT_99_kasusdiagnosa").val($(this).parents('tr').find('#kasusdiagnosa :selected').text());
                            $("#PPPasienMorbiditasT_99_statusdiagnosapasien").val($(this).parents('tr').find('#statusdiagnosapasien :selected').text());
                        } else if (x == 7) {

                            $("#PPPasienMorbiditasT_99_ket_diagnosa").val($(this).parents('tr').find('#ket_diagnosa :selected').text());
                        } else if (x == 7) {

                            $("#PPPasienMorbiditasT_99_ppds_id").val(params);
                        }
                        x++;
                    }
                );
                
                $(mine).parents('table').find('#selectPasien').addClass("animation-loading-1");
                setTimeout(function() {
                    renameInput('PPPasienMorbiditasT', 'tglmorbiditas');
                    renameInput('PPPasienMorbiditasT', 'kelompokdiagnosa_id');
                    renameInput('PPPasienMorbiditasT', 'pegawai_id');
                    renameInput('PPPasienMorbiditasT', 'statusdiagnosapasien');

                    renameInput('PPPasienMorbiditasT', 'pasienmorbiditas_id');
                    renameInput('PPPasienMorbiditasT', 'diagnosa_id');
                    renameInput('PPPasienMorbiditasT', 'kasusdiagnosa');
                    renameInput('PPPasienMorbiditasT', 'ket_diagnosa');
                    renameInput('PPPasienMorbiditasT', 'ppds_id');

                    renameInput('PPDiagnosaM', 'diagnosa_kode');
                    renameInput('PPDiagnosaM', 'diagnosa_nama');
                    renameInput('PPDiagnosaM', 'diagnosa_namalainnya');
                    $(mine).parents('table').find('#selectPasien').removeClass("animation-loading-1");
                }, 500);
                id_diagnosax[kode] = 'yes';

                updateSorotX();
            }
        } else {
            myAlert("Diagnosis yang Anda input telah terdaftar, silakan cek kembali!");
        }


    }

    function updateSorotX() {
        $("#PPdiagnosa-m-grid table tbody tr td").removeClass('sorot');
        $("#tbl_diagnosax tbody tr .row_diagnosa_x_id").each(function() {
            $("#PPdiagnosa-m-grid table tbody #pilih_dialog_" + $(this).val()).parents("tr").find("td").addClass("sorot");
        });
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
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
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




    $(document).ready(function() {
        updateSorotX();
    });
</script>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTambahDiagnosax',
    'options' => array(
        'title' => 'Daftar Diagnosis ICD 10',
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
                'value' => function ($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                        "class" => "btn-small",
                        "id" => "selectPasien",
                        "onClick" => "inputDiagnosa(this," . $data->diagnosa_id . ", \"" . $data->diagnosa_kode . "\");return false;"
                    ))
                        . CHtml::hiddenField('pilih_dialog_x', $data->diagnosa_id, array('id' => 'pilih_dialog_' . $data->diagnosa_id));
                },
            ),
            array(
                'header' => 'Kode DTD',
                'value' => function ($data) {
                    if (!empty($data->dtd_id)) {
                        $dtdM = DtdM::model()->findByPk($data->dtd_id);
                        if (!empty($dtdM)) {
                            echo $dtdM->dtd_kode;
                        }
                    }
                },
                'htmlOptions' => array(
                    'width' => '90px'
                ),

                'filter' => false,
            ),
            'diagnosa_kode',
            'diagnosa_nama',
            'diagnosa_namalainnya',
            array(
                'header' => 'Kelompok Diagnosis',
                'value' => function ($data) {
                    $condition = '';
                    if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RD) {
                        $condition = 'and kelompokdiagnosa_id != 4';
                    }
                    echo CHtml::dropDownList("kelompokdiagnosa", "", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE " . $condition), "kelompokdiagnosa_id","kelompokdiagnosa_nama"), array("class"=>"span2 kelompokdiagnosa", "onchange"=>"diagnosaKelompok(this);", "empty"=>"-- Pilih --"));
                },
                'filter' => false,
                'type' => 'raw',
            ),
            // array(
            //     'header' => 'Kasus Diagnosis',
            //     'value' => 'CHtml::dropDownList("kasusdiagnosa", "", CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type"=>"kasusdiagnosa")), "lookup_value","lookup_name"), array("class"=>"span2"))',
            //     'filter' => false,
            //     'type' => 'raw',
            // ),
            array(
                'header' => 'Status Diagnosis',
                'value' => 'CHtml::dropDownList("statusdiagnosapasien", "", CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type"=>"statusdiagnosapasien")), "lookup_value","lookup_name"), array("class"=>"span2"))',
                'filter' => false,
                'type' => 'raw',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); updateSorotX();}',
    )
);
$this->endWidget();
?>