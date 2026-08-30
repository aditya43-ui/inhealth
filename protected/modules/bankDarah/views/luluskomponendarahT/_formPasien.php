<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Kantong Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Nomor Barcode", 'kantongdarah_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php if (!empty($_GET['nomorbarcode']) && !empty($_GET['frame'])) {
                            echo $form->textField($modKantong, 'nomorbarcode', array('class' => 'span3', 'readonly' => true));
                        } else {
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'nomorbarcode',
                                'source' => 'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "' . $this->createUrl('AutocompletePermintaanDarah') . '",
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
                                                             $(this).val( "");
                                                             return false;
                                                         }',
                                    'select' => 'js:function( event, ui ) {
                                                            $(this).val( ui.item.nomorbarcode);
                                                            $("#InfokantongdarahV_nomorbarcode").val( ui.item.nomorbarcode );
                                                            $("#InfokantongdarahV_kantongdarah_id").val( ui.item.kantongdarah_id );
                                                            $("#InfokantongdarahV_nama_jenis").val(ui.item.nama_jenis );
                                                            $("#InfokantongdarahV_tglpencatatan").val(ui.item.tglpencatatan );
                                                            $("#InfokantongdarahV_gol_darah").val(ui.item.gol_darah );
                                                            $("#InfokantongdarahV_ruangandaftar_nama").val(ui.item.ruangandaftar_nama );
                                                            $("#InfokantongdarahV_singkatan_komp").val(ui.item.singkatan_komp);
                                                            $("#InfokantongdarahV_hasil_uji").val( ui.item.hasil_uji );
                                                            $("#InfokantongdarahV_jeniskantongdarah_id").val( ui.item.jeniskantongdarah_id );
                                                            $("#InfokantongdarahV_komponendarah_id").val( ui.item.komponendarah_id );
                                                            $("#InfokantongdarahV_skriningimltd_id").val( ui.item.skriningimltd_id);
                                                            $("#InfokantongdarahV_hbsag").val( ui.item.hbsag);
                                                            $("#InfokantongdarahV_antihiv").val( ui.item.antihiv);
                                                            $("#InfokantongdarahV_antihvc").val( ui.item.antihvc);
                                                            $("#InfokantongdarahV_sifilis").val( ui.item.sifilis);
                                                            $("#InfokantongdarahV_komponen_tc").val(ui.item.komponen_tc);
                                                            $("#InfokantongdarahV_komponen_pcr").val(ui.item.komponen_pcr);
                                                            $("#InfokantongdarahV_komponen_ffp").val(ui.item.komponen_ffp);
                                                            $("#InfokantongdarahV_komponen_prc").val(ui.item.komponen_prc);
                                                            $("#InfokantongdarahV_komponen_wb").val(ui.item.komponen_wb);
                                                            return false;
                                                        }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPermintaanDarah'),
                                'htmlOptions' => array(
                                    'placeholder' => 'No. Barcode Darah', 'class' => 'span3 required', 'rel' => 'tooltip', 'title' => 'No. Permintaan Darah',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ),
                            ));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Kantong Darah", 'nama_jenis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modKantong, 'nomorbarcode', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'kantongdarah_id', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'jeniskantongdarah_id', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'komponendarah_id', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->textField($modKantong, 'nama_jenis', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'skriningimltd_id', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'komponen_ffp', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'komponen_tc', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'komponen_wb', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'komponen_prc', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modKantong, 'komponen_pcr', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Penerimaan Kantong", 'tglpencatatan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'tglpencatatan', array('readonly' => true, 'class' => 'span3')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Ruangan Asal", 'ruangandaftar_nama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'ruangandaftar_nama', array('readonly' => true, 'class' => 'span3')) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Golongan Darah", 'gol_darah', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'gol_darah', array('readonly' => true, 'class' => 'span3')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Rhesus", 'rhesus', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'rhesus', array('readonly' => true, 'class' => 'span3')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Volume", 'volume', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'volume', array('readonly' => true, 'class' => 'span3')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Hasil / Kesimpulan <b>Pengujian Sebelumnya</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label("Skrining IMLTD", 'nomorbarcode', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKantong, 'hasilskrining', array('readonly' => true, 'class' => 'span3')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Konfirmasi Gol. Darah", 'hasil_uji', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKantong, 'hasil_uji', array('readonly' => true, 'class' => 'span3')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Komponen Darah", 'singkatan_komp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKantong, 'singkatan_komp', array('readonly' => true, 'class' => 'span1')) ?>
                /
                <?php echo $form->textField($modKantong, 'hasilkomponen', array('readonly' => true, 'class' => 'span2')) ?>

            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Kantong Darah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPermintaanDarah',
    'options' => array(
        'title' => 'Pencarian Data Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogPermintaan = new InfokantongdarahV('searchTransaksiLulus');
if (isset($_GET['InfokantongdarahV'])) {
    $modDialogPermintaan->attributes = $_GET['InfokantongdarahV'];
    $modDialogPermintaan->nomorbarcode = $_GET['InfokantongdarahV']['nomorbarcode'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datapermintaan-grid',
    'dataProvider' => $modDialogPermintaan->searchTransaksiLulus(),
    'filter' => $modDialogPermintaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                if (!empty($data->periksakomponendarah_id)) {
                    $periksa = PeriksakomponendarahT::model()->findByPk($data->periksakomponendarah_id);
                    if (!empty($periksa)) {
                        if (!empty($periksa->volume)) {
                            $volume = $periksa->volume;
                        } else {
                            $volume = '';
                        }
                    } else {
                        $volume = '';
                    }
                } else {
                    $volume = '';
                }
                echo CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectPermintaan",
                    "onClick" => "
                                            $('#nomorbarcode').val('" . $data->nomorbarcode . "');
                                            $('#InfokantongdarahV_nomorbarcode').val('" . $data->nomorbarcode . "');
                                            $('#InfokantongdarahV_nama_jenis').val('" . $data->nama_jenis . "');
                                            $('#InfokantongdarahV_kantongdarah_id').val('" . $data->kantongdarah_id . "');
                                            $('#InfokantongdarahV_tglpencatatan').val('" . MyFormatter::formatDateTimeforUser($data->tglpencatatan) . "');
                                            $('#InfokantongdarahV_gol_darah').val('" . $data->gol_darah . "');
                                            $('#InfokantongdarahV_rhesus').val('" . $data->rhesus . "');
                                            $('#InfokantongdarahV_ruangandaftar_nama').val('" . $data->ruangandaftar_nama . "');
                                            $('#InfokantongdarahV_singkatan_komp').val('" . $data->singkatan_komp . "');
                                            $('#InfokantongdarahV_hasil_uji').val('" . $data->hasil_uji . "');
                                            $('#InfokantongdarahV_jeniskantongdarah_id').val('" . $data->jeniskantongdarah_id . "');
                                            $('#InfokantongdarahV_komponendarah_id').val('" . $data->komponendarah_id . "');
                                            $('#InfokantongdarahV_sifilis').val('" . $data->sifilis . "');
                                            $('#InfokantongdarahV_hbsag').val('" . $data->hbsag . "');
                                            $('#InfokantongdarahV_antihiv').val('" . $data->antihiv . "');
                                            $('#InfokantongdarahV_antihvc').val('" . $data->antihvc . "');
                                            $('#InfokantongdarahV_skriningimltd_id').val('" . $data->skriningimltd_id . "');
                                            $('#InfokantongdarahV_komponen_ffp').val('" . $data->komponen_ffp . "');
                                            $('#InfokantongdarahV_komponen_tc').val('" . $data->komponen_tc . "');
                                            $('#InfokantongdarahV_komponen_prc').val('" . $data->komponen_prc . "');
                                            $('#InfokantongdarahV_komponen_wb').val('" . $data->komponen_wb . "');
                                            $('#InfokantongdarahV_komponen_pcr').val('" . $data->komponen_pcr . "');
                                            $('#InfokantongdarahV_volume').val('" . $volume . "');
                                            setSkrining();
                                            $('#dialogPermintaanDarah').dialog('close');
                                        "
                ));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'No. Barcode',
            'name' => 'nomorbarcode',
            'value' => '$data->nomorbarcode'
        ),
        array(
            'header' => 'Golongan Darah / Rhesus',
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
////======= end kantong darah dialog =============
?>
<script>
    function setSkrining(obj) {
        var L = $("#InfokantongdarahV_skriningimltd_id").val();
        var k = $("#InfokantongdarahV_singkatan_komp").val();
        var A = $('#InfokantongdarahV_skriningimltd_id').val();
        var antihiv = $('#InfokantongdarahV_antihiv').val();
        var antihvc = $('#InfokantongdarahV_antihvc').val();
        var hbsag = $('#InfokantongdarahV_hbsag').val();
        var sifilis = $('#InfokantongdarahV_sifilis').val();
        var ffp = $("#InfokantongdarahV_komponen_ffp").val();
        var tc = $("#InfokantongdarahV_komponen_tc").val();
        var wb = $("#InfokantongdarahV_komponen_wb").val();
        var pcr = $("#InfokantongdarahV_komponen_pcr").val();
        var prc = $("#InfokantongdarahV_komponen_prc").val();

        var total = " ";
        if (antihiv == true || antihvc == true || hbsag == true || sifilis == true) {
            total = "reaktif";
            $("#<?php echo CHtml::activeId($modKantong, 'hasilskrining') ?>").val("Reaktif").attr('readonly', true);
        } else {
            total = "non reaktif";
            if (L != "") {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilskrining') ?>").val("Non Reaktif").attr('readonly', true);
            } else {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilskrining') ?>").val(" ").attr('readonly', true);
            }
        }
        if (k == "FFP") {
            $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(ffp).attr('readonly', true);
        } else if (k == "TC") {
            $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(tc).attr('readonly', true);
        } else if (k == "PRC") {
            $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(prc).attr('readonly', true);
        } else if (k == "WB") {
            $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(wb).attr('readonly', true);
        } else if (k == "PCR") {
            $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(pcr).attr('readonly', true);
        } else {
            $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(" ").attr('readonly', true);
        }
    }

    $(document).ready(function() {
        setSkrining();
    });
</script>