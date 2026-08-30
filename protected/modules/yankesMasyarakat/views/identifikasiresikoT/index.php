<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Formulir Risk Register</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penelitian-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <div class="row-fluid">
            <div class="row-fluid">
                <div class="col-md-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Periode Manajemen Resiko <span class="required">*</span>', '', array('class' => 'control-label', 'style' => 'margin-top : -10px')) ?>
                        <div class="controls">
                            <?php
                            $cekpegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                            if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KMKP && $cekpegawai->unitkerja_id == Params::UNITKERJA_ID_KMKP) {
                                $periodetrakhir = PerioderiskregisterM::model()->find('perioderiskregister_aktif=TRUE order by periode_akhir DESC');
                                $model->perioderiskregister_id = $periodetrakhir->perioderiskregister_id;
                                $model->perioderiskregister_idnya = $periodetrakhir->perioderiskregister_id;
                                echo $form->dropDownList($model, 'perioderiskregister_idnya', CHtml::listData($model->getSemuaPeriodeResiko(), 'perioderiskregister_id', 'nama_perioderiskregister'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                echo $form->hiddenField($model, 'perioderiskregister_id', array('class' => 'span3'));
                            } else if ($cekpegawai->unitkerja_id != Params::UNITKERJA_ID_KMKP) {
                                $periodetrakhir = PerioderiskregisterM::model()->find('perioderiskregister_aktif=TRUE order by periode_akhir DESC');
                                if (!empty($periodetrakhir)){
                                    $model->perioderiskregister_id = $periodetrakhir->perioderiskregister_id;
                                }
                                echo $form->dropDownList($model, 'perioderiskregister_id', CHtml::listData($model->getSemuaPeriodeResiko(), 'perioderiskregister_id', 'nama_perioderiskregister'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                            } else {
                                echo $form->dropDownList($model, 'perioderiskregister_id', CHtml::listData($model->getSemuaPeriodeResiko(), 'perioderiskregister_id', 'nama_perioderiskregister'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                            }
                            ?>
                        </div>
                    </div>
                                        <div class="control-group">
                        <?php echo CHtml::label('Jenis Risk Manajemen <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
                        <div class="controls">
                            <?php
                            if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPERAWATAN_YANKES && $cekpegawai->unitkerja_id == Params::UNITKERJA_ID_KMKP) {
                                echo $form->dropDownList($model, 'jenisriskmanajemen', LookupM::getItems("jenisriskmanajemen"), array('class' => 'span3 required', 'empty' => '-- Pilih --'));
                            } else if ($cekpegawai->unitkerja_id != Params::UNITKERJA_ID_KMKP) {
                                $model->jenisriskmanajemen = 'Unit Kerja/ Instalasi';
                                $model->jenisriskmanajemennya = 'Unit Kerja/ Instalasi';
                                echo $form->dropDownList($model, 'jenisriskmanajemennya', LookupM::getItems("jenisriskmanajemen"), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'disabled' => true));
                                echo $form->hiddenField($model, 'jenisriskmanajemen', array('class' => 'span3'));
                            } else {
                                echo $form->dropDownList($model, 'jenisriskmanajemen', LookupM::getItems("jenisriskmanajemen"), array('class' => 'span3 required', 'empty' => '-- Pilih --'));
                            }
                            ?>

                        </div>
                    </div>

                </div>
                <div class="col-md-6">    
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
                        <div class="controls">
                            <?php
                            if ($cekpegawai->unitkerja_id != Params::UNITKERJA_ID_KMKP) {
                                $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
                                $model->ruangan_id = $ruangan->ruangan_id;
                                $model->ruangan_nama = $ruangan->ruangan_nama;
                            }
                            echo $form->hiddenField($model, 'ruangan_id', array('class' => 'span3'));
                            //echo $form->dropDownList($model,'ruangan_id', $model->getRuanganUnitKerjaItems(), array('class'=>'span3 required','empty'=>'-- Pilih --')); 
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'ruangan_nama',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteRuangan') . '",
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
                                    'focus' => 'js:function(event, ui ) {
                                        return false;
                                    }',
                                    'select' => 'js:function(event, ui ) {
                                        $("#YKMIdentifikasiresikoT_ruangan_id").val(ui.item.ruangan_id);
                                        $(this).val(ui.item.ruangan_nama);
                                        refreshDialog(); 
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                                    'onblur' => 'if($(this).val() == ""){ $("#YKMIdentifikasiresikoT_ruangan_id").val(""); }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogRuangan'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Unit Kerja', '', array('class' => 'control-label ')) ?>
                        <div class="controls">
                            <?php
                            echo $form->hiddenField($model, 'unitkerja_id', array('class' => 'span3'));
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'namaunitkerja',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompleteUnitKerjaRuangan') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            ruangan_id: $("#YKMIdentifikasiresikoT_ruangan_id").val()
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function(event, ui ) {
                                        return false;
                                    }',
                                    'select' => 'js:function(event, ui ) {
                                        $("#YKMIdentifikasiresikoT_unitkerja_id").val(ui.item.unitkerja_id);
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Ketikkan nama unit kerja',
                                    'onblur' => 'if($(this).val() == ""){ $("#YKMIdentifikasiresikoT_unitkerja_id").val(""); }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogUnitKerja'),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><b>I. Identifikasi Resiko</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formIdentifikasiResiko', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><b>II. Rating Analisis</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formAnalisis', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>III. Evaluasi / Pengolahan Risiko</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formEvaluasi', array(
                        'modEvaluasi' => $modEvaluasi,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disabled = (isset($_GET['sukses'])) ? true : false;
            ?>

            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'submit'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'submit', 'disabled' => true));
            }
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('Index') . '";}); return false;'
            ));
            ?>
            <?php
                echo CHtml::link(Yii::t('mds', '{icon} Petunjuk', array('{icon}' => '<i class="entypo-info-circled"></i>')), $this->createUrl('InformasiIdentifikasiresiko/lihatPetunjuk'), array('class' => 'btn btn-info',
                'target' => 'blank'));
            ?>
        </div>
    </div>
    <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    <?php $this->endWidget(); ?>
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
    'dataProvider' => $modRuangan->searchRuanganTanpaAdm(),
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
$modUnit = new UnitkerjaM('search');
$modUnit->unsetAttributes();
if (isset($_GET['UnitkerjaM']))
{
    $modUnit->attributes = $_GET['UnitkerjaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'unitkerja-m-grid',
    'dataProvider' => $modUnit->searchDialog(),
    'filter' => $modUnit,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data)
            {
                $attr = CJSON::encode($data->attributes);
                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class' => 'btn-small',
                            'id' => 'selectUnitKerja',
                            'onclick' => " $('#YKMIdentifikasiresikoT_unitkerja_id').val($data->unitkerja_id);
                                           $('#YKMIdentifikasiresikoT_namaunitkerja').val('$data->namaunitkerja');
                                           $('#dialogUnitKerja').dialog('close'); return false;"
                ));
            },
        ),
        'namaunitkerja',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
/* ============================== start Grading =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogGrading',
    'options' => array(
        'title' => 'Petunjuk',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 150,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeGrading" width="100%" height="320">
</iframe>

<?php
$this->endWidget();
/* =============================== end Grading ================================ */?>

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
</script>