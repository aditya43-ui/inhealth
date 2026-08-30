<div class="panel panel-shadow panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Diagnosa (ICD X)</b>
        </div>
    </div>
    <?php
    echo CHtml::hiddenField("idkelompokdiagnosa", "2", array('readonly' => true, 'class' => 'span1'));
    echo CHtml::hiddenField("idkelompokdiagnosa_utama1", "1", array('readonly' => true, 'class' => 'span1'));
    ?>
    <div class="panel-body table-responsive">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Diagnosa ICD X</label>
                <div class="controls">
                    <?php // echo CHtml::activeTextField($modKunjungan, 'no_pendaftaran', array('readonly'=>true)); 
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'diagnosa_icdx_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('getDiagnosaM') . '",
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
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                inputDiagnosa(ui.item.diagnosa_id, ui.item);
                                $("#diagnosa_icdx_nama").val("");
                                return false;
                            }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
                        'tombolDialog' => array('idDialog' => 'dialogTambahDiagnosax', 'idTombol' => 'tombolDialogDiagnosaICDX'),
                    ));

                    ?>
                </div>
            </div>
        </div>


        <div class="block-tabel">
            <table class="table table-striped table-condensed" id="tbl_diagnosax">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tgl. Diagnosa</th>
                        <th>Kelompok Diagnosis</th>
                        <th>Kasus Diagnosis</th>
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
                        $status = FALSE;
                        $disabled = FALSE;
                        // echo '<pre>';print_r($model);die;
                        foreach ($model as $val) {
                            if ($model[$i]['ruangan_id'] != Yii::app()->user->getState('ruangan_id')) {
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
                                    echo $form->hiddenField($model[$i], "[$i]diagnosa_id");
                                    echo $form->hiddenField($model[$i], "[$i]pegawai_id");
                                    echo $form->hiddenField($model[$i], "[$i]kelompokdiagnosa_id");
                                    echo "<br>";
                                    echo "Keterangan Diagnosa"."<br>";
                                    echo $form->textArea($model[$i], "[$i]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $form->dropDownList(
                                        $model[$i],
                                        "[$i]kelompokdiagnosa_id",
                                        CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosa(this);', 'disabled' => $disabled,
                                        )
                                    );
                                    echo $form->error($model[$i], "[$i]kelompokdiagnosa_id");
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $form->dropDownList(
                                        $model[$i],
                                        "[$i]kasusdiagnosa",
                                        CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type" => "kasusdiagnosa")), "lookup_value", "lookup_name"),
                                        array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosa(this);', 'disabled' => $disabled,
                                        )
                                    );
                                    echo $form->error($model[$i], "[$i]kasusdiagnosa");
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $form->dropDownList(
                                        $model[$i],
                                        "[$i]pegawai_id",
                                        CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                                        array(
                                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'disabled' => $disabled,
                                        )
                                    );
                                    echo $form->error($model[$i], "[$i]pegawai_id");
                                    ?>
                                </td>
                                <td>
                                    <?php echo empty($model[$i]->diagnosa->diagnosa_kode)? NULL :$model[$i]->diagnosa->diagnosa_kode; ?>
                                </td>
                                <td>
                                    <?php echo empty($model[$i]->diagnosa->diagnosa_nama)? NULL:$model[$i]->diagnosa->diagnosa_nama; ?>
                                </td>
                                <td>
                                    <?php echo empty($model[$i]->diagnosa->diagnosa_namalainnya)? NULL:$model[$i]->diagnosa->diagnosa_namalainnya; ?>
                                </td>
                                <td hidden>
                                    <?php //echo $form->textField($model[$i], "[$i]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3)); ?>
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
                        <?php
        //$i = 99;
    ?>
    <tr>
        <td class="no_urut">1</td>
        <td id="input_field">
            <?php
                $this->widget('MyDateTimePicker',
                    array(
                        'model'=>$modUraian,
                        'attribute'=>"[0]tglmorbiditas",
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>true,
                            'value'=>date("Y-m-d H:i:s"),
                            'class'=>'dtPicker2',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                        ),
                    )
                );
                echo $form->hiddenField($modUraian,"[0]pasienmorbiditas_id");
                echo $form->hiddenField($modUraian,"[0]diagnosa_id", array("class"=>"row_diagnosa_x_id"));
                echo $form->hiddenField($modUraian,"[0]kasusdiagnosa");
                echo "Keteragan Diagnosa".":<br>";
                echo $form->textArea($modUraian, "[0]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3));
            ?>
        </td>
        <td>
            <?php
                echo $form->dropDownList($modUraian,"[0]kelompokdiagnosa_id", CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','onchange'=>'cekKelDianosa(this);'
                ));
                echo $form->error($modUraian, "[0]kelompokdiagnosa_id");
            ?>
        </td>
        <td>
            <?php
                echo $form->dropDownList($modUraian,"[0]pegawai_id", CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                ));
            ?>
        </td>
        <td>
          <?php
                echo $form->textField($modUraian,'[0]diagnosa_kode',
                array('readonly'=>true,'class'=>'span2')
            );
                // $this->widget('MyJuiAutoComplete',
                //     array(
                //         'name'=>"PPDiagnosaM[$i][diagnosa_kode]",
                //         'sourceUrl'=> $this->createUrl('getDiagnosaM&param=kode'),
                //         'options'=>array(
                //             'showAnim'=>'fold',
                //             'minLength' => 4,
                //             'focus'=> 'js:function( event, ui ){
                //                 return false;
                //             }',
                //             'select'=>'js:function( event, ui ){
                //                 return false;
                //             }',
                //         ),
                //         'htmlOptions'=>array(
                //             'placeholder'=>'Kode Diagnosis',
                //             'aria-haspopup'=>"true",
                //             'aria-autocomplete'=>'list',
                //             'role'=>'textbox',
                //             'autocomplete'=>'off',
                //             'onkeypress'=>"return $(this).focusNextInputField(event)",
                //             'class'=>'span2 ui-autocomplete-input'
                //         )
                //     )
                // );
                // echo chtml::hiddenField('diagnosaicdix_kode_temp');
            ?>
        </td>
        <td>
          <?php
                echo $form->textField($modUraian,'[0]diagnosa_nama',
                array('readonly'=>true,'class'=>'span2')
            );
            ?>
        </td>
        <td>
          <?php
                echo $form->textField($modUraian,'[0]diagnosa_namalainnya',
                array('readonly'=>true,'class'=>'span2')
            );
            ?>        
        </td>
        <td>
            <?php
                echo $form->textField($modUraian,'[0]statusdiagnosapasien',
                array('readonly'=>true,'class'=>'span2')
            );
            ?>
        </td>
        <td hidden>
            <?php //echo $form->textField($modUraian, "[0]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3)); ?>
        </td>
        <td style="text-align: center">
            <?php
                echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#",array("onclick"=>"hapusDiagnosa(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Diagnosa"));
            ?>
        </td>
    </tr>
                        <!-- <tr id="is_kosong">
                            <td align="center" colspan="10">Data tidak ditemukan</td>
                        </tr> -->
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
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

        if (id_diagnosax[params.diagnosa_kode] == undefined) {

            if (jumlah > 1 && idKelDiagnosa_utama == '2' && idKelDiagnosa == idKelDiagnosa_utama) {
                idKelDiagnosa = '<?php echo Params::KELOMPOKDIAGNOSA_TAMBAH ?>'
                // myAlert("Diagnosis utama tidak boleh lebih dari 1. silakan hubungi tim coding untuk verifikasi");
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

            $("#PPPasienMorbiditasT_99_diagnosa_id").val(diagnosa_id);
            $("#tbl_diagnosax tbody tr:last-child .diagnosa_kode").html(params.diagnosa_kode);
            $("#tbl_diagnosax tbody tr:last-child .diagnosa_nama").html(params.diagnosa_nama);
            $("#tbl_diagnosax tbody tr:last-child .diagnosa_namalainnya").html(params.diagnosa_namalainnya);

            if (ada_utama == 1) {
                $("#PPPasienMorbiditasT_99_kelompokdiagnosa_id").val('<?php echo Params::KELOMPOKDIAGNOSA_TAMBAH; ?>');
                $("#PPPasienMorbiditasT_99_ket_diagnosa").val($(this).parents('tr').find('#ket_diagnosa :selected').text());
            } else {
                $("#PPPasienMorbiditasT_99_kelompokdiagnosa_id").val(idKelDiagnosa);
                $("#PPPasienMorbiditasT_99_ket_diagnosa").val($(this).parents('tr').find('#ket_diagnosa :selected').text());
            }

            id_diagnosax.push(params.diagnosa_kode);

            setTimeout(function() {
                renameInput('PPPasienMorbiditasT', 'tglmorbiditas');
                renameInput('PPPasienMorbiditasT', 'kelompokdiagnosa_id');
                renameInput('PPPasienMorbiditasT', 'pegawai_id');

                renameInput('PPPasienMorbiditasT', 'pasienmorbiditas_id');
                renameInput('PPPasienMorbiditasT', 'diagnosa_id');
                renameInput('PPPasienMorbiditasT', 'kasusdiagnosa');
                renameInput('PPPasienMorbiditasT', 'ket_diagnosa');

                renameInput('PPDiagnosaM', 'diagnosa_kode');
                renameInput('PPDiagnosaM', 'diagnosa_nama');
                renameInput('PPDiagnosaM', 'diagnosa_namalainnya');
            }, 500);
            id_diagnosax[params.diagnosa_kode] = 'yes';

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
                    $(this).val(ui.item.diagnosa_kode);
                    $(this).parents("tr").find(".inp_diagnosa_id").val(ui.item.diagnosa_id);
                    $(this).parents("tr").find(".inp_diagnosa_nama").val(ui.item.diagnosa_nama);
                    $(this).parents("tr").find(".inp_diagnosa_namalainnya").val(ui.item.diagnosa_namalainnya);
                    return false;
                },
                'source': '<?php echo $this->createUrl('getDiagnosaM&param=kode'); ?>'
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
                'source': '<?php echo $this->createUrl('rawatJalan/diagnosaIX/getDiagnosaM&param=nama'); ?>'
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
                'source': '<?php echo $this->createUrl('rawatJalan/diagnosaIX/getDiagnosaM&param=lainnya'); ?>'
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
        'height' => 720,
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

                    $attr = CJSON::encode($data->attributes);

                    return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                        'class' => 'btn-small',
                        'id' => 'selectPasien',
                        'onclick' => "inputDiagnosa(" . $data->diagnosa_id . ", " . $attr . "); $('#dialogTambahDiagnosax').dialog('close'); return false;"
                    ));
                },
            ),
            /*
                array(
                    'name'=>'diagnosa_nourut',
                    'value'=>'$data->diagnosa_nourut',
                    'filter'=>false,
                ),*/
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
            ), /*
				array(
					'header'=>'Kelompok Diagnosis',
					'value'=>'CHtml::dropDownList("kelompokdiagnosa", "", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id","kelompokdiagnosa_nama"), array("class"=>"span2", "onchange"=>"diagnosaKelompok(this);", "empty"=>"-- Pilih --"))',
					'filter'=>false,
					'type'=>'raw',
				),
				array(
					'header'=>'Kasus Diagnosis',
					'value'=>'CHtml::dropDownList("kasusdiagnosa", "", CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type"=>"kasusdiagnosa")), "lookup_value","lookup_name"), array("class"=>"span2"))',
					'filter'=>false,
					'type'=>'raw',
				), */
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);
$this->endWidget();
?>