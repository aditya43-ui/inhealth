<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapemeriksaanalatrad-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Alat Medis <span class="required">*</span>', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'alatmedis_id'); ?>
                <?php
                $model->alatmedis_nama = !empty($model->alatmedis_id) ? $model->alatmedis->alatmedis_nama : "";
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'alatmedis_nama',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('AutocompleteAlatmedis') . '",
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
                            $(this).val( ui.item.label);
                            return false;
                    }',
                        'select' => 'js:function( event, ui ) { 
                            $("#' . CHtml::activeId($model, 'alatmedis_id') . '").val(ui.item.alatmedis_id);
                            $("#alatmedis_nama").val(ui.item.alatmedis_nama);
                            return false;
                    }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Alat Medis',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogAlatmedis'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_kode', array('placeholder' => 'Kode', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pemeriksaanalatrad_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="SAPemeriksaanalatradM_pemeriksaanalatrad_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_nama', array('placeholder' => 'Nama Pemeriksaan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanalatrad_aetitle', array('placeholder' => 'Title', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->dropDownListRow($model, 'rumusdosis_radiasi', LookupM::getItemsUrutan('listrumus_dosisradiasi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Alat Radiologi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlatmedis',
    'options' => array(
        'title' => 'Daftar Alatmedis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));

$modAlatmedis = new SAAlatmedisM('search');
$modAlatmedis->unsetAttributes();
if (isset($_GET['SAAlatmedisM'])) {
    $modAlatmedis->attributes = $_GET['SAAlatmedisM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'alatmedis-m-grid',
    'dataProvider' => $modAlatmedis->searchDialog(),
    'filter' => $modAlatmedis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
"#",
array(
"class"=>"btn-small", 
"id" => "selectAlatmedis",
"onClick" => "
$(\"#' . CHtml::activeId($model, 'alatmedis_id') . '\").val(\'$data->alatmedis_id\');
$(\"#' . CHtml::activeId($model, 'alatmedis_nama') . '\").val(\'$data->alatmedis_nama\');

$(\'#dialogAlatmedis\').dialog(\'close\');return false;"))'
        ),
        'alatmedis_id',
        'jenisalatmedis.jenisalatmedis_nama',
        'instalasi.instalasi_nama',
        'alatmedis_nama',
        'alatmedis_namalain',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>