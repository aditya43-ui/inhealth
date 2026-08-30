<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kelompokfaktorrisiko-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Faktor Risiko', 'jenisfaktorrisiko_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisfaktorrisiko_id', JenisfaktorrisikoM::getDropDownJenis(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'refreshTable()')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Faktor Risiko', 'tandagejala_daftar_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'faktorrisiko_daftar_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'faktorrisiko_daftar_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteFaktorRisiko') . '",
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
                                        $("#' . CHtml::activeId($model, 'faktorrisiko_daftar_id') . '").val(ui.item.faktorrisiko_daftar_id);
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Tanda dan Gejala',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDaftarFaktorRisiko', 'jsFunction' => 'setCeklisGejala();'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelompokfaktorrisikodaftar_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelompokfaktorrisikodaftar_aktif', array('checked' => 'kelompokfaktorrisikodaftar_aktif')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid block-tabel">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>SIKI</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table id="table-risiko" class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="text-align: center">Faktor Risiko<span style="color: red">*</span></th>
                        <th style="text-align: center">Status</th>
                        <th style="text-align: center">Hapus</th>
                    </tr>
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
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "#", array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
    ));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Faktor Risiko', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Buka dialog buat cari data daftar faktor risiko =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarFaktorRisiko',
    'options' => array(
        'title' => 'Daftar Faktor Risiko',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modFaktorRisiko = new FaktorrisikoDaftarM('search');
$modFaktorRisiko->unsetAttributes();
if (isset($_GET['FaktorrisikoDaftarM'])) {
    $modFaktorRisiko->attributes = $_GET['FaktorrisikoDaftarM'];
    $modFaktorRisiko->faktorrisiko_daftar_nama = !empty($_GET['FaktorrisikoDaftarM']['faktorrisiko_daftar_nama']) ? $_GET['FaktorrisikoDaftarM']['faktorrisiko_daftar_nama'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'faktorrisikodaftar-m-grid',
    'dataProvider' => $modFaktorRisiko->search(),
    'filter' => $modFaktorRisiko,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array(
                'class' => 'check_all_produk', 'onchange' => 'setSemuaGejala(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::checkBox('check', false, array(
                    'faktorrisiko_daftar_id' => $data["faktorrisiko_daftar_id"],
                    'onchange' => 'setGejala(this);',
                    'class' => 'pilih',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputGejala();'))
        ),
        array(
            'header' => 'Nama Risiko',
            'type' => 'raw',
            'name' => 'faktorrisiko_daftar_nama',
            'value' => '$data->faktorrisiko_daftar_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekListKantong();}',
));

$this->endWidget();
//========= Tutup dialog buat cari data daftar faktor risiko =========================
?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDet' => $modDet)); ?>