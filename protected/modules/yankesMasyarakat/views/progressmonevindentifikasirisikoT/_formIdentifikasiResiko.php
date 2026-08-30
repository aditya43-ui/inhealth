<div class="row-fluid lookdisable">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Periode Manajemen Resiko ', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                if (!empty($model->identifikasiresiko_id)) {
                    echo CHtml::textField('perioderegister_nama', $model->periode->nama_perioderiskregister, array('class' => 'span3', 'readonly' => true));
                } else {
                    echo $form->dropDownList($model, 'perioderiskregister_id', CHtml::listData($model->getPeriodeResikoItems(), 'perioderiskregister_id', 'nama_perioderiskregister'), array('empty' => '-- Pilih --', 'class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    ));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'ruangan_id', array('class' => 'span3'));
                //echo $form->dropDownList($model,'ruangan_id', $model->getRuanganUnitKerjaItems(), array('class'=>'span3 required','empty'=>'-- Pilih --')); 
                if ((Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPERAWATAN_YANKES) || (Yii::app()->user->getState('ruangan_id') == $model->ruangan_id)) {
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
                                        $("#YKMIdentifikasiresikoT_ruangan_nama").val(ui.item.ruangan_nama);
                                        return false;
                                    }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                            'onblur' => 'if($(this).val() == ""){ $("#YKMIdentifikasiresikoT_ruangan_id").val(""); }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogRuangan'),
                    ));
                } else {
                    echo $form->textField($model, 'ruangan_nama', array('class' => 'span3'));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Unit Kerja <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'unitkerja_id', array('class' => 'span3'));
                if ((Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPERAWATAN_YANKES) || (Yii::app()->user->getState('ruangan_id') == $model->ruangan_id)) {
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
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                            'onblur' => 'if($(this).val() == ""){ $("#YKMIdentifikasiresikoT_unitkerja_id").val(""); }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogUnitKerja'),
                    ));
                } else {
                    echo $form->textField($model, 'namaunitkerja', array('class' => 'span3'));
                }
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Sumber Resiko ', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'sumber_resiko', LookupM::getItems("sumber_riskregister"), array('class' => 'span3 ', 'empty' => '-- Pilih --')); ?>
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


    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Dekripsi Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'deskripsiresiko', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> Dampak Risiko </label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'dampakrisiko', LookupM::getItems('dampakrisiko'), array('class' => 'span3', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penyebab', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'penyebabresiko', array('class' => 'span3')); ?>
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
</script>