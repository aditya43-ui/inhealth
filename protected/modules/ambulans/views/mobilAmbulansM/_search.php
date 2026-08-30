<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'mobilambulance-m-search',
    'type' => 'horizontal',
    'focus' => '#inventarisaset',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Inventaris Aset</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'inventarisaset_id', array('id' => 'inventarisaset_id')) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'inventarisaset',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . Yii::app()->createUrl('ActionAutoComplete/Barang') . '",
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
                        'focus' => 'js:function( event, ui )
                            {
                            $(this).val(ui.item.barang_nama);
                            return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                            $("#alatmedis_noaset").val(ui.item.barang_id);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3',
                        'readonly' => false,
                        'placeholder' => 'No. Aset',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogbarang'),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Kode</label>
            <div class="controls">
                <?php echo $form->textField(
                    $model,
                    'mobilambulans_kode',
                    array('size' => 20, 'maxlength' => 20, 'class' => 'span3', 'placeholder' => 'Kode')
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">No. Polisi</label>
            <div class="controls">
                <?php echo $form->textField(
                    $model,
                    'nopolisi',
                    array('size' => 20, 'maxlength' => 20, 'class' => 'span3', 'placeholder' => 'No. Polisi')
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'jeniskendaraan',
            CHtml::listData($model->JenisKendaraanItems, 'lookup_name', 'lookup_value'),
            array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)
        ); ?>
        <?php echo $form->textFieldRow(
            $model,
            'isibbmliter',
            array('class' => 'span3', 'placeholder' => 'Isi BBM / liter')
        ); ?>
        <?php echo $form->textFieldRow(
            $model,
            'hargabbmliter',
            array('class' => 'span3', 'placeholder' => 'Harga BBM / liter')
        ); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'mobilambulans_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox(
                    $model,
                    'mobilambulans_aktif',
                    array('checked' => 'mobilambulans_aktif', 'id' => 'aktif')
                ); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'Cari')
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

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogbarang',
    'options' => array(
        'title' => 'Pencarian No. Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modBarang = new AMBarangM('searchDialog');
$modBarang->unsetAttributes();
if (isset($_GET['AMBarangM'])) {
    $modBarang->attributes = $_GET['AMBarangM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modBarang->searchDialog(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectbarang",
                                                    "onClick" => "\$(\"#inventarisaset_id\").val($data->barang_id);
                                                                          \$(\"#inventarisaset\").val(\"$data->barang_nama\");
                                                                          \$(\"#dialogbarang\").dialog(\"close\");"
                                             )
                             )',
        ),
        'barang_type',
        'barang_kode',
        'barang_nama',
        'barang_satuan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
