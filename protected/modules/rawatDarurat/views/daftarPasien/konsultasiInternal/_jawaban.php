
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Jawaban Konsultasi
        </div>
    </div>
    <?php 
    if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
    ?>
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
                    <?php echo CHtml::activeTextArea($model, 'jawaban_konsul', array('class' => 'span8', 'readonly' => false)); ?>
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
    <?php }else{ ?>

        <div class="panel-body">
        <div class="col-sm-12">
        <!-- <div class="control-group"> -->
                <!-- <label class="control-label">Tanggal dan Jam Jawab</label> -->
                <!-- <div class="controls"> -->
                    <div class="hidden">
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
                <!-- </div> -->
            <!-- </div> -->
        <div class="panel-body form-horizontal">
        <div class="col-sm-12">
            <br/>
            <div>Dari pemeriksaan pada pasien, dijumpai:</div>
            <br/>
            <br/>
        </div>
        <div class="col-sm-12">
            <div class="control-group">
                <div class="controls uraian_konsuljawaban" style="width:80%;">
                    <?php //echo CHtml::activeTextArea($model, 'uraian_konsuljjawaban', array('style' => 'width: 900px; height: 200px; ')); ?>
                    <?php

                        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                        if($peg->kelompokpegawai_id !== Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                            $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'uraian_konsuljawaban', 'toolbar' => 'mini', 'height' => '200px'));
                        } else {
                            echo CHtml::activeTextArea($model, 'uraian_konsuljawaban', array('style' => 'min-width: 1000px; min-height: 250px; ', 'readonly' => true));
                        }
                    
                    ?>
                    <?php ?>
                        <?php //echo $form->error($model, 'uraian_konsuljjawaban'); ?>
                </div>
            </div>
        </div>

        </div>
        <div class="form-actions">
            <?= CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => (isset($_GET['sukses'])) ? true : false)); ?>
        </div>
    </div>
    <?php } ?>
</div>
