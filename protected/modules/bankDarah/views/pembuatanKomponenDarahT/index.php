<?php

/**
 * - digunakan sebagai Transaksi Komponen Darah
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pembuatankantongdaraj-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pembuatan Komponen darah berhasil disimpan!");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Pembuatan <b>Komponen Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b> Kantong Darah </b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("No. Barcode Kantong <i style='color: red'> * </i>", "", array(
                            'class' => 'control-label'
                        )); ?>
                        <div class="controls komponen">
                            <?php
                            if (empty($modKantong->kantongdarah_id)) {
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modKantong,
                                    'attribute' => 'nomorbarcode',
                                    'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('AutocompleteKantongDarah') . '",
                                        dataType: "json",
                                        data: {
                                            nomorbarcode: request.term,
                                        },
                                        success: function (data) {
                                                response(data);
                                        }
                                    })
                                }',
                                    'options' => array(
                                        'minLength' => 3,
                                        'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nomorbarcode);
                                    return false;
                                }',
                                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nomorbarcode);
                                    $("#' . CHtml::activeId($modKantong, 'nomorbarcode') . '").val(ui.item.nomorbarcode);
                                    $("#' . CHtml::activeId($modKantong, 'nama_jenis') . '").val(ui.item.nama_jenis);
                                    $("#' . CHtml::activeId($modKantong, 'tglpencatatan') . '").val(ui.item.tglpencatatan);
                                    $("#' . CHtml::activeId($modKantong, 'gol_darah') . '").val(ui.item.gol_darah);
                                    $("#' . CHtml::activeId($modKantong, 'rhesus') . '").val(ui.item.rhesus);
                                    $("#' . CHtml::activeId($modKantong, 'ruangandaftar_nama') . '").val(ui.item.ruangandaftar_nama);
                                    $("#' . CHtml::activeId($modKantong, 'ruangancatat_id') . '").val(ui.item.ruangancatat_id);
                                    $("#' . CHtml::activeId($modKantong, 'komponendarah_id') . '").val(ui.item.komponendarah_id);
                                    $("#' . CHtml::activeId($modKantong, 'terimakantongdarah_id') . '").val(ui.item.terimakantongdarah_id);
                                    $("#' . CHtml::activeId($modKantong, 'kantongdarah_id') . '").val(ui.item.kantongdarah_id);
                                    $("#' . CHtml::activeId($modKantong, 'daftarpendonor_id') . '").val(ui.item.daftarpendonor_id);
                                    setKomponenDarah(ui.item.komponendarah_id);
                                    return false;
                                }',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogKantongDarah'),
                                    'htmlOptions' => array(
                                        'placeholder' => 'No. Barcode Darah', 'class' => 'span3 all-caps required', 'rel' => 'tooltip', 'title' => 'No. Permintaan Darah',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                    ),
                                ));
                                echo CHtml::activeHiddenField($modKantong, 'ruangancatat_id', array('readonly' => 'true'));
                            } else {
                                if (isset($_GET['sukses'])) {
                                    echo $form->textField($modKantong, 'nomorbarcode', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nomor Barcode Kantong'));
                                } else {
                                    echo $form->textField($modKantong, 'nomorbarcode', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nomor Barcode Kantong'));
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Jenis Kantong Darah", "", array(
                            'class' => 'control-label'
                        )); ?>
                        <div class="controls komponen">
                            <?php echo $form->textField($modKantong, 'nama_jenis', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Jenis Kantong Darah')); ?>
                            <?php echo $form->hiddenField($modKantong, 'terimakantongdarah_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Jenis Kantong Darah')); ?>
                            <?php echo $form->hiddenField($modKantong, 'kantongdarah_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Jenis Kantong Darah')); ?>
                            <?php echo $form->hiddenField($modKantong, 'daftarpendonor_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Jenis Kantong Darah')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Tgl. Penerimaan Kantong", "", array(
                            'class' => 'control-label'
                        )); ?>
                        <div class="controls komponen">
                            <?php echo $form->textField($modKantong, 'tglpencatatan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tanggal Penerimaan Kantong Darah')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Golongan Darah", "", array(
                            'class' => 'control-label'
                        )); ?>
                        <div class="controls komponen">
                            <?php echo $form->textField($modKantong, 'gol_darah', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Golongan Darah')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Rhesus", "", array(
                            'class' => 'control-label'
                        )); ?>
                        <div class="controls komponen">
                            <?php echo $form->textField($modKantong, 'rhesus', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Rhesus')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Ruangan Asal", "", array(
                            'class' => 'control-label'
                        )); ?>
                        <div class="controls komponen">
                            <?php echo $form->textField($modKantong, 'ruangandaftar_nama', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Ruangan Asal')); ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-plus-square"></i> Pembuatan <b> Komponen Darah </b>
                </div>

            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php
                        if (!empty($modKomponenDarah->komponendarah_id)) {
                            if ($modKomponenDarah->komponendarah_id == 7) {
                        ?>
                                <?php
                                echo CHtml::label("WB <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label'
                                ));
                                ?>
                                <div class="controls komponen">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_wb', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                            <?php
                            } else if ($modKomponenDarah->komponendarah_id == 8 || $modKomponenDarah->komponendarah_id == 10) {
                            ?>
                                <?php
                                echo CHtml::label("PRC <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label'
                                ));
                                ?>
                                <div class="controls komponen">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_prc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                            <?php
                            } else if ($modKomponenDarah->komponendarah_id == 9 || $modKomponenDarah->komponendarah_id == 11 || $modKomponenDarah->komponendarah_id == 13) {
                            ?>
                                <?php
                                echo CHtml::label("FFP <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label'
                                ));
                                ?>
                                <div class="controls komponen">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_ffp', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                            <?php
                            } else if ($modKomponenDarah->komponendarah_id == 14 || $modKomponenDarah->komponendarah_id == 12) {
                            ?>
                                <?php
                                echo CHtml::label("TC <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label'
                                ));
                                ?>
                                <div class="controls komponen">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_tc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                            <?php
                            } elseif ($modKomponenDarah->komponendarah_id == 15) {
                                echo CHtml::label("PCR <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label'
                                )); ?>
                                <div class="controls komponen">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_pcr', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                            <?php } elseif ($modKomponenDarah->singkatan_komp == Params::KOMPONEN_DARAH_CRY) {
                                echo CHtml::label(Params::KOMPONEN_DARAH_CRY . " <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label'
                                )); ?>
                                <div class="controls komponen">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_cry', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                            <?php }
                        } else {
                            ?>
                            <?php echo CHtml::activeHiddenField($modelKantongDetail, 'kantongdarah_id', array('readonly' => 'true')); ?>
                            <?php
                            echo CHtml::label("WB <i style='color: red'> * </i>", "", array(
                                'class' => 'control-label komp komponen_wb'
                            ));
                            ?>
                            <div class="controls komp komponen_wb">
                                <?php echo CHtml::activeRadioButtonList($model, 'komponen_wb', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('class' => 'komponen_wb komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                            </div>
                            <?php
                            echo CHtml::label("PRC <i style='color: red'> * </i>", "", array(
                                'class' => 'control-label komp komponen_prc'
                            ));
                            ?>
                            <div class="controls komp komponen_prc">
                                <?php echo CHtml::activeRadioButtonList($model, 'komponen_prc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('class' => 'komponen_prc komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                            </div>
                            <?php
                            echo CHtml::label("FFP <i style='color: red'> * </i>", "", array(
                                'class' => 'control-label komp komponen_ffp'
                            ));
                            ?>
                            <div class="controls komp komponen_ffp">
                                <?php echo CHtml::activeRadioButtonList($model, 'komponen_ffp', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('class' => 'komponen_ffp komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                            </div>
                            <?php
                            echo CHtml::label("TC <i style='color: red'> * </i>", "", array(
                                'class' => 'control-label komp komponen_tc'
                            ));
                            ?>
                            <div class="controls komp komponen_tc">
                                <?php echo CHtml::activeRadioButtonList($model, 'komponen_tc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('class' => 'komponen_tc komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                            </div>
                            <?php
                            echo CHtml::label("PCR <i style='color: red'> * </i>", "", array(
                                'class' => 'control-label komp komponen_pcr'
                            ));
                            ?>
                            <div class="controls komp komponen_pcr">
                                <?php echo CHtml::activeRadioButtonList($model, 'komponen_pcr', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('class' => 'komponen_pcr komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                            </div>
                            <?php
                            echo CHtml::label(Params::KOMPONEN_DARAH_CRY . " <i style='color: red'>* </i>", "", array(
                                'class' => 'control-label komp komponen_cry'
                            ));
                            ?>
                            <div class="controls komp komponen_cry">
                                <?php echo CHtml::activeRadioButtonList($model, 'komponen_cry', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('class' => 'komponen_cry komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="control-group">
                        <?php
                        echo CHtml::label("Keterangan", "", array(
                            'class' => 'control-label'
                        ));
                        ?>
                        <div class="controls komponen">
                            <?php echo $form->textArea($model, 'periksakomp_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Keterangan')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php
                        echo CHtml::label("Volume <i style='color: red'> * </i>", "", array(
                            'class' => 'control-label'
                        ));
                        ?>
                        <div class="controls komponen">
                            <?php echo $form->textField($model, 'volume', array('class' => 'span3 numbers-only required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Volume')); ?> <label> ml</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php
                        echo CHtml::label("Tgl. Kedaluwarsa <i style='color: red'> * </i>", "", array(
                            'class' => 'control-label'
                        ));
                        ?>
                        <div class="controls komponen">
                            <?php
                            $model->tglkadaluarsa = (!empty($model->tglkadaluarsa) ? date("d M Y H:i:s", strtotime($model->tglkadaluarsa)) : null);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglkadaluarsa',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3 dtPicker3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php
                echo CHtml::label("Waktu Pembuatan Komponen <i style='color: red'> * </i> ", "", array(
                    'class' => 'control-label'
                ));
                ?>
                <div class="controls komponen">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglperiksakompdarah',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'span3 dtPicker3 realtime required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php
                echo CHtml::label("Petugas Komponen <i style='color: red'> * </i>", "", array(
                    'class' => 'control-label'
                ));
                ?>
                <div class="controls komponen">
                    <?php echo $form->hiddenField($model, 'petugasperiksakomp_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textField($model, 'petugasperiksakomp_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'disabled' => true)); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="col-sm-12">
            <div class="form-actions">
                <?php
                if (isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger submit', 'disabled' => true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                        'class' => 'btn btn-danger submit',
                        'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'
                    ));
                }
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Komponen', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => $model->isNewRecord, 'class' => 'btn btn-info', 'onclick' => "printBarcodeKomponen();return false"));

                if (isset($_GET['frame'])) {
                    if (isset($_GET['sukses'])) {
                        echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-danger', 'onclick' => 'window.history.go(-2); return false;', 'style' => 'color: white;'));
                    } else {
                        echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-danger', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
                    }
                }

                ?>
            </div>
        </div>

    </div>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Petugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipelaksana-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'petugasperiksakomp_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'petugasperiksakomp_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogPetugas\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>

<?php
//========= Dialog buat cari data Kantong Darah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Pencarian Data Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 600,
        'resizable' => false,
    ),
));
$modDialogPermintaan = new InfokantongdarahV('searchTransaksi');
$modDialogPermintaan->unsetAttributes();
if (isset($_GET['InfokantongdarahV'])) {
    $modDialogPermintaan->attributes = $_GET['InfokantongdarahV'];
    $modDialogPermintaan->nomorbarcode = $_GET['InfokantongdarahV']['nomorbarcode'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datapermintaan-grid',
    'dataProvider' => $modDialogPermintaan->searchTransaksi(),
    'filter' => $modDialogPermintaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectKantongDarah",
                "onClick" => "
                    $(\'#' . CHtml::activeId($modKantong, 'nomorbarcode') . '\').val(\'$data->nomorbarcode\');
                    $(\'#' . CHtml::activeId($modKantong, 'nama_jenis') . '\').val(\'$data->nama_jenis\');
                    $(\'#' . CHtml::activeId($modKantong, 'tglpencatatan') . '\').val(\'$data->tglpencatatan\');
                    $(\'#' . CHtml::activeId($modKantong, 'gol_darah') . '\').val(\'$data->gol_darah\');
                    $(\'#' . CHtml::activeId($modKantong, 'rhesus') . '\').val(\'$data->rhesus\');
                    $(\'#' . CHtml::activeId($modKantong, 'ruangandaftar_nama') . '\').val(\'$data->ruangandaftar_nama\');
                    $(\'#' . CHtml::activeId($modKantong, 'ruangancatat_id') . '\').val(\'$data->ruangancatat_id\');
                    $(\'#' . CHtml::activeId($modKantong, 'ruangancatat_id') . '\').val(\'$data->ruangancatat_id\'); 
                    $(\'#' . CHtml::activeId($modKantong, 'komponendarah_id') . '\').val(\'$data->komponendarah_id\'); 
                    $(\'#' . CHtml::activeId($modKantong, 'kantongdarah_id') . '\').val(\'$data->kantongdarah_id\'); 
                    $(\'#' . CHtml::activeId($modKantong, 'terimakantongdarah_id') . '\').val(\'$data->terimakantongdarah_id\'); 
                    $(\'#' . CHtml::activeId($modKantong, 'daftarpendonor_id') . '\').val(\'$data->daftarpendonor_id\'); 
                    setKomponenDarah(\"$data->komponendarah_id\");         
                    $(\"#dialogKantongDarah\").dialog(\"close\");
                "))',
        ),
        array(
            'header' => 'No. Barcode',
            'filter' => CHtml::activeTextField($modKantong, 'nomorbarcode'),
            'value' => '$data->nomorbarcode'
        ),
        array(
            'header' => 'Golongan Darah',
            'name' => 'gol_darah',
            'value' => '$data->gol_darah'
        ),
        array(
            'header' => 'Rhesus',
            'name' => 'rhesus',
            'value' => '$data->rhesus'
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//======= end kantong darah dialog =============
?>

<script type="text/javascript">
    function setDataPegawai(params) {
        $.ajax({
            type: 'POST',
            url: "<?php echo $this->createUrl('getDataPegawai'); ?>",
            data: {
                idPegawai: params
            },
            dataType: "json",
            success: function(data) {
                $("#PeriksakomponendarahT_petugasperiksakomp_id").val(data.pegawai_id);
                $("#PeriksakomponendarahT_petugasperiksakomp_nama").val(data.namaLengkap);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data pegawai tidak ditemukan!");
                setPegawaiReset();
                $("#PeriksakomponendarahT_petugasperiksakomp_nama").focus();
            }
        });
    }

    function setPegawaiReset() {
        $("#PeriksakomponendarahT_petugasperiksakomp_id").val("");
        $("#PeriksakomponendarahT_petugasperiksakomp_nama").val("");
        $("#PeriksakomponendarahT_petugasperiksakomp_nama").focus();
    }

    /** Fungsi untuk disabled/hide komponen darah berdasarkan komponen_id */
    function setKomponenDarah(komponendarah_id) {
        $('.komp').hide();
        if (komponendarah_id == 7) {
            $('.komponen_wb').show();
        } else if (komponendarah_id == 8 || komponendarah_id == 10) {
            $('.komponen_prc').show();
        } else if (komponendarah_id == 9 || komponendarah_id == 11 || komponendarah_id == 13) {
            $('.komponen_ffp').show();
        } else if (komponendarah_id == 14 || komponendarah_id == 12) {
            $('.komponen_tc').show();
        } else if (komponendarah_id == 15) {
            $('.komponen_pcr').show();
        } else if (komponendarah_id == <?php echo Params::KOMPONEN_DARAH_ID_CRY; ?>) {
            $('.komponen_cry').show();
        }
    }

    function printBarcodeKomponen() {
        window.open('<?php echo $this->createUrl('/bankDarah/kantongDarah/PrintBarcodeKomponen', array('kantongdarah_id' => $modKantong->kantongdarah_id, 'daftarpendonor_id' => $modKantong->daftarpendonor_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }

    $(document).ready(function() {
        $('.komp').hide();
    })
</script>