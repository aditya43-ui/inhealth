<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bataskarakteristik-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'lookup_type'),
));
?>
<style>
    .form-horizontal .control-label {
        width: 155px;
    }
</style>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField("norow", "", array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true, 'class' => 'no_row',)); ?>
        <div class="control-group">
            <?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'diagnosakep_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosakep_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('AutoCompleteDiagnosaKeperawatan') . '",
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.value);
                                        return false;
                                    }',
                        'select' => 'js:function( event, ui ) { 
                                        $("#' . CHtml::activeId($model, 'diagnosakep_id') . '").val(ui.item.diagnosakep_id);
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Kode / Nama Diagnosa',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Luaran Keperawatan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'tingkatluarankeperawatan', LookupM::getItems(' tingkatluarankeperawatan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'refreshTable();')); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid block-tabel">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Tautan SDKI-SLKI</b>
            </div>
        </div>
        <div class="panel-body table-responsive">

            <table id="table-lookup" class="table table-striped table-bordered table-condensed">
                <thead>
                    <th style="text-align:center">Luaran Keperawatan <span style="color: red">*</span></th>
                    <th style="text-align:center">Status</th>
                    <th colspan="2"></th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "#", array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
    ));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tautan SDKI-SLKI', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDetail' => $modDetail, 'modDet' => $modDet)); ?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosaKep = new DiagnosakepM('search');
$modDiagnosaKep->unsetAttributes();
$modDiagnosaKep->diagnosakep_aktif = TRUE;
if (isset($_GET['DiagnosakepM'])) {
    $modDiagnosaKep->attributes = $_GET['DiagnosakepM'];
    $modDiagnosaKep->diagnosakep_aktif = TRUE;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosakep-m-grid',
    'dataProvider' => $modDiagnosaKep->search(),
    'filter' => $modDiagnosaKep,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_id') . '\").val(\'$data->diagnosakep_id\');
                                    $(\"#' . CHtml::activeId($model, 'diagnosakep_nama') . '\").val(\'$data->diagnosakep_nama\');
                                        
                                    $(\'#dialogDiagnosa\').dialog(\'close\');
                                    refreshTable();
                                    return false;"))'
        ),
        array(
            'header' => 'Kode Diagnosa',
            'name' => 'diagnosakep_kode',
            'value' => '$data->diagnosakep_kode',
        ),
        array(
            'header' => 'Diagnosa Keperawatan',
            'type' => 'raw',
            'name' => 'diagnosakep_nama',
            'value' => '$data->diagnosakep_nama',
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'diagnosakep_deskripsi',
            'value' => '$data->diagnosakep_deskripsi',
        ),
        array(
            'header' => 'Status',
            'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
            'filter' => CHtml::dropDownList(
                'diagnosakep_aktif',
                $modDiagnosaKep->diagnosakep_aktif,
                array(
                    '1' => 'Aktif',
                    '0' => 'Tidak Aktif',
                ),
                array('empty' => '-- Pilih --')
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLuaranKeperawatan',
    'options' => array(
        'title' => 'Luaran Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modLuaran = new LuarankeperawatanM('search');
$modLuaran->unsetAttributes();
if (isset($_GET['LuarankeperawatanM'])) {
    $modLuaran->attributes = $_GET['LuarankeperawatanM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'luarankeperawatan-m-grid',
    'dataProvider' => $modLuaran->search(),
    'filter' => $modLuaran,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setLuarankeperawatandialog(" . $data->luarankeperawatan_id . ", '" . $data->luarankeperawatan_nama . "', this); $('#dialogLuaranKeperawatan').dialog('close'); "
                ));
            },
        ),
        array(
            'header' => 'Kode Luaran Keperawatan',
            'name' => 'luarankeperawatan_kode',
            'value' => '$data->luarankeperawatan_kode',
        ),
        array(
            'header' => 'nama Luaran Keperawatan',
            'type' => 'raw',
            'name' => 'luarankeperawatan_nama',
            'value' => '$data->luarankeperawatan_nama',
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'luarankeperawatan_deskripsi',
            'value' => '$data->luarankeperawatan_deskripsi',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>