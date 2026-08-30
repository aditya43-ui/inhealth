<div class="row-fluid lookdisable">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Sumber Resiko <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'sumber_resiko', LookupM::getItems("sumber_riskregister"), array('class' => 'span3 required', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Tipe Manajemen Resiko <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'tiperesiko_id', CHtml::listData($model->getTipeResikoItems(), 'tiperesiko_id', 'tiperesiko_nama'), array('class' => 'span3 required',
                    'ajax' => array('type' => 'POST',
                        'dataType' => "json",
                        'url' => $this->createUrl('/actionDynamic/GetSubTipe', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "subtiperesiko_id") . '").html(data.drop);}',
                    ),
                    'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sub Tipe Manajemen Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'subtiperesiko_id', Chtml::listData(SubtiperesikoM::model()->findAllByAttributes(array('subtiperesiko_aktif' => true)), 'subtiperesiko_id', 'subtiperesiko_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Deskripsi Resiko <span class="required">*</span>', 'deskripsiresiko', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'deskripsiresiko', array('class' => 'span3 required')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">        
        <div class="control-group">
            <?php echo CHtml::label('Dampak Resiko <span class="required">*</span>', 'dampakrisiko', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'dampakrisiko', LookupM::getItems('dampakrisiko'), array('class' => 'span3 required', 'empty' => '-- Pilih --'))?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penyebab Resiko <span class="required">*</span>', 'penyebabresiko', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'penyebabresiko', array('class' => 'span3 required')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Existing Control', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'existing_control', array('class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRuangan',
    'options' => array(
        'title' => 'Daftar Ruangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modRuangan = new RuanganM('search');
$modRuangan->unsetAttributes();
$modRuangan->ruangan_aktif = true;
if (isset($_GET['RuanganM'])) {
    $modRuangan->attributes = $_GET['RuanganM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruangan-m-grid',
    'dataProvider' => $modRuangan->searchDialog(),
    'filter' => $modRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attr = CJSON::encode($data->attributes);
                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class' => 'btn-small',
                            'id' => 'selectRuangan',
                            'onclick' => " $('#YKMIdentifikasiresikoT_ruangan_id').val($data->ruangan_id);
                                           $('#YKMIdentifikasiresikoT_ruangan_nama').val('$data->ruangan_nama');
                                           refreshDialog(); 
                                           $('#dialogRuangan').dialog('close'); return false;"
                ));
            },
        ),
        'ruangan_nama',
        array(
            'header' => 'Instalasi',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modRuangan, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                                'condition' => 'instalasi_aktif = true',
                                'order' => 'instalasi_nama asc',
                            )), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                echo $data->instalasi_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogUnitKerja',
    'options' => array(
        'title' => 'Daftar Unit Kerja',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modUnit = new UnitkerjaruanganM('search');
$modUnit->unsetAttributes();
if (isset($_GET['UnitkerjaruanganM'])) {
    $modUnit->attributes = $_GET['UnitkerjaruanganM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'unitkerja-m-grid',
    'dataProvider' => $modUnit->searchUnitKerjaRuangan(),
    'filter' => $modUnit,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attr = CJSON::encode($data->attributes);
                $modUnit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class' => 'btn-small',
                            'id' => 'selectRuangan',
                            'onclick' => " $('#YKMIdentifikasiresikoT_unitkerja_id').val($data->unitkerja_id);
                                           $('#YKMIdentifikasiresikoT_namaunitkerja').val('$modUnit->namaunitkerja');
                                           $('#dialogUnitKerja').dialog('close'); return false;"
                ));
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modUnit, 'ruangan_id', array('class' => 'ruangan_id'))
            . CHtml::activeDropDownList($modUnit, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(array(
                                'condition' => 'unitkerja_aktif = true',
                                'order' => 'namaunitkerja asc',
                            )), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                echo $data->unitkerja->namaunitkerja;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<script>
    function refreshDialog() {
        var ruangan = $("#YKMIdentifikasiresikoT_ruangan_id").val();
        var def = '';
        if (ruangan == "") {
            def = 'ada';
        }

        $(".ruangan_id").val(ruangan);

        setTimeout(function () {
            $("#dialogUnitKerja").removeClass('animation-loading-1');

            $.fn.yiiGridView.update('unitkerja-m-grid', {
                data: {
                    "UnitkerjaruanganM[ruangan_id]": ruangan,
                    "UnitkerjaruanganM[default]": def,
                }
            });
        }, 500);
    }

    function selectSubTipe() {
        $("#YKMIdentifikasiresikoT_subtiperesiko_id").val($("#YKMIdentifikasiresikoT_tiperesiko_id :selected").data('nama'));
    }

    function pilihPeluang(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('/yankesMasyarakat/RiskregisterT/getBobotPeluang'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMIdentifikasiresikoT_peluang_skor').val(data.return);
                    hitungRPN();
                }, "json");
    }

    function pilihKonsekuensi(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('/yankesMasyarakat/RiskregisterT/getBobotKonsekuensi'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMIdentifikasiresikoT_konsekuensi_skor').val(data.return);
                    hitungRPN();
                }, "json");
    }

    function pilihDetectability(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('/yankesMasyarakat/RiskregisterT/getBobotDetectability'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMIdentifikasiresikoT_detectability_skor').val(data.return);
                    hitungRPN();
                }, "json");
    }

    function pilihPeluangSisa(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('/yankesMasyarakat/RiskregisterT/getBobotPeluang'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMRiskregisterM_peluang_skor_rpnsisa').val(data.return);
                    hitungRPNSisa();
                }, "json");
    }

    function pilihKonsekuensiSisa(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('/yankesMasyarakat/RiskregisterT/getBobotKonsekuensi'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMRiskregisterM_konsekuensi_skor_rpnsisa').val(data.return);
                    hitungRPNSisa();
                }, "json");
    }

    function pilihDetectabilitySisa(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('yankesMasyarakat/RiskregisterT/getBobotDetectability'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMRiskregisterM_detectability_skor_rpnsisa').val(data.return);
                    hitungRPNSisa();
                }, "json");
    }

    function hitungRPNSisa() {
        var konsekuensi_id = $("#YKMIdentifikasiresikoT_konsekuensi_id").val();
        var peluang_id = $("#YKMIdentifikasiresikoT_peluang_id").val();
        var detectability_id = $("#YKMIdentifikasiresikoT_detectability_id").val();
        var nilai_konsekuensi = $("#YKMIdentifikasiresikoT_konsekuensi_skor").val();
        var nilai_peluang = $("#YKMIdentifikasiresikoT_peluang_skor").val();
        var nilai_detectability = $("#YKMIdentifikasiresikoT_detectability_skor").val();
        if (nilai_konsekuensi == 0) {
            nilai_konsekuensi = 1;
        }
        if (nilai_peluang == 0) {
            nilai_peluang = 1;
        }
        if (nilai_detectability == 0) {
            nilai_detectability = 1;
        }
        var total = parseInt(nilai_konsekuensi) * parseInt(nilai_peluang) * parseInt(nilai_detectability);
        if (konsekuensi_id == "" && peluang_id == "" && detectability_id == "") {
            total = 0;
        }
        $("#YKMIdentifikasiresikoT_rpn_score").val(total);
    }

    function hitungRPN() {
        var konsekuensi_id = $("#YKMIdentifikasiresikoT_konsekuensi_id").val();
        var peluang_id = $("#YKMIdentifikasiresikoT_peluang_id").val();
        var detectability_id = $("#YKMIdentifikasiresikoT_detectability_id").val();
        var nilai_konsekuensi = $("#YKMIdentifikasiresikoT_konsekuensi_skor").val();
        var nilai_peluang = $("#YKMIdentifikasiresikoT_peluang_skor").val();
        var nilai_detectability = $("#YKMIdentifikasiresikoT_detectability_skor").val();
        if (nilai_konsekuensi == 0) {
            nilai_konsekuensi = 1;
        }
        if (nilai_peluang == 0) {
            nilai_peluang = 1;
        }
        if (nilai_detectability == 0) {
            nilai_detectability = 1;
        }

        var total = parseInt(nilai_konsekuensi) * parseInt(nilai_peluang) * parseInt(nilai_detectability);
        if (konsekuensi_id == "" && peluang_id == "" && detectability_id == "") {
            total = 0;
        }
        $("#YKMIdentifikasiresikoT_rpn_score").val(total);
    }

    function loadTingkatRisiko() {
        var konsekuensi_id = $("#YKMIdentifikasiresikoT_konsekuensi_id").val();
        var peluang_id = $("#YKMIdentifikasiresikoT_peluang_id").val();

        if (konsekuensi_id != "" && peluang_id != "") {
            $.post('<?php echo $this->createUrl('/yankesMasyarakat/RiskregisterT/getTingkatRisiko'); ?>', {
                konsekuensi_id: konsekuensi_id, peluang_id: peluang_id},
                    function (data) {
                        $('#YKMIdentifikasiresikoT_tingkatrisiko_nama').val(data.return);
                    }, "json");
        } else {
            $('#YKMIdentifikasiresikoT_tingkatrisiko_nama').val("");
        }
    }
</script>
