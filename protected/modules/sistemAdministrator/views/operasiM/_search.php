<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'bsoperasi-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownlistRow(
            $model,
            'kegiatanoperasi_id',
            CHtml::listData(SAKegiatanOperasiM::model()->getAllItems(), 'kegiatanoperasi_id', 'kegiatanoperasi_nama'),
            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
        ); ?>
        <div class="control-group">
            <label class="control-label" for="bidang">Daftar Tindakan</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('daftartindakan_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'daftartindakan_nama',
                    //                                            'value'=>$model->daftartindakan->daftartindakan_nama,
                    'value' => $model->getDaftarTindakanNama($model->daftartindakan_id),
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
                                                    $("#SAOperasiM_daftartindakan_nama").val(ui.item.daftartindakan_nama);
                                                    return false;
                                                }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Daftar Tindakan",
                        'class' => 'span3',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'operasi_kode', array('placeholder' => 'Kode Operasi', 'class' => 'span3', 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'operasi_nama', array('placeholder' => 'Nama Operasi', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'operasi_namalainnya', array('placeholder' => 'Nama Lain Operasi', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->checkBoxRow($model, 'operasi_aktif', array('checked' => 'checked')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
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
                                $(\"input[id=SAOperasiM_daftartindakan_nama]\").val(\'$data->daftartindakan_nama\');
                                $.fn.yiiGridView.update(\"bsoperasi-m-grid\", {
					data: $(\"#bsoperasi-m-grid .filters input, #bsoperasi-m-grid .filters select\").serialize()
				});
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