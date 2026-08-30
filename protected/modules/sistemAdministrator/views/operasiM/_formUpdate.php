<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bsoperasi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#daftartindakan_nama',
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label" for="bidang">Daftar Tindakan</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'daftartindakan_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(

                    'name' => 'daftartindakan_nama',
                    'value' => $model->daftartindakan->daftartindakan_nama,
                    //                                        'value'=>$model->getDaftarTindakanNama($model->daftartindakan_id),
                    'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompleteDaftarTindakan') . '",
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
                                                    $("#daftartindakan_id").val(ui.item.daftartindakan_id);
                                                    $("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
                                                    return false;
                                                }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Daftar Tindakan",
                        'class' => 'span4',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownlistRow($model, 'kegiatanoperasi_id',  CHtml::listData(SAKegiatanOperasiM::model()->getAllItems(), 'kegiatanoperasi_id', 'kegiatanoperasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'operasi_kode', array('placeholder' => 'Operasi kode', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'operasi_nama', array('placeholder' => 'Operasi nama', 'class' => 'span4', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'operasi_namalainnya', array('placeholder' => 'Nama lain operasi', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->checkBoxRow($model, 'operasi_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<table style="width: 100%; border: none;">
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
</table>
<?php //echo $form->dropDownlistRow($model,'daftartindakan_id',  CHtml::listData(DaftartindakanM::model()->getAllItems(), 'daftartindakan_id', 'daftartindakan_nama'),array('empty'=>'-- Pilih --','class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Operasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTindakanRad = new DaftartindakanM('search');
$modTindakanRad->unsetAttributes();
if (isset($_GET['DaftartindakanM']))
    $modTindakanRad->attributes = $_GET['DaftartindakanM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modTindakanRad->search(),
    'filter' => $modTindakanRad,
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
                                "id" => "selectTindakan",
                                "onClick" => "
                                $(\"#SAOperasiM_daftartindakan_id\").val(\'$data->daftartindakan_id\');
                                $(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
                                $(\'#dialogTindakan\').dialog(\'close\');return false;"))'
        ),
        array(
            'name' => 'kelompoktindakan_nama',
            'header' => 'Kelompok Tindakan',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('DaftartindakanM[kelompoktindakan_nama]', $modTindakanRad->kelompoktindakan_nama, CHtml::listData(KelompoktindakanM::model()->findAll("kelompoktindakan_aktif = TRUE ORDER BY kelompoktindakan_nama"), 'kelompoktindakan_nama', 'kelompoktindakan_nama'), array('empty' => '--Pilih')),
            'value' => '$data->kelompoktindakan->kelompoktindakan_nama',
        ),
        //'kelompoktindakan_nama',
        array(
            'name' => 'kategoritindakan_nama',
            'header' => 'Kategori Tindakan',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('DaftartindakanM[kategoritindakan_nama]', $modTindakanRad->kategoritindakan_nama, CHtml::listData(KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama"), 'kategoritindakan_nama', 'kategoritindakan_nama'), array('empty' => '-- Pilih --')),
            'value' => '$data->kategoritindakan->kategoritindakan_nama',
        ),
        //'kategoritindakan_nama',
        'daftartindakan_kode',
        'daftartindakan_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAOperasiM_operasi_namalainnya').value = nama.value.toUpperCase();
    }
</script>