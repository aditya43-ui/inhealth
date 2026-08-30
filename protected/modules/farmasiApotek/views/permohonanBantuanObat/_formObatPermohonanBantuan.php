<div class="control-group">
    <?php echo CHtml::label('Nama Obat & Kesehatan', 'obatalkes_nama', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::hiddenField('obatalkes_id', '', array('onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'obatalkes_nama',
            'source' => 'js: function(request, response) {
                           $.ajax({
                               url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
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
                        $(this).val("");
                        return false;
                    }',
                'select' => 'js:function( event, ui ) {
                        $(this).val(ui.item.value);
                        $("#obatalkes_id").val(ui.item.obatalkes_id);
                        $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                        return false;
                    }',
            ),
            'htmlOptions' => array(
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
            ),
            'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
        ));
        ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Jumlah', 'qty_input', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::textField('qty_input', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')) ?>
        <?php echo CHtml::htmlButton(
            '<i class="icon-plus icon-white"></i>',
            array(
                'onclick' => 'tambahObatAlkes();return false;',
                'class' => 'btn btn-danger',
                'onkeyup' => "tambahObatAlkes();",
                'rel' => "tooltip",
                'title' => "Klik untuk menambahkan resep",
            )
        ); ?>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Obat dan Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 600,
        'resizable' => false,
    ),
));

$modObatAlkes = new FAObatalkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if (isset($_GET['FAObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['FAObatalkesM'];
    $modObatAlkes->satuankecil_nama = $_GET['FAObatalkesM']['satuankecil_nama'];
    $modObatAlkes->jenisobatalkes_nama = $_GET['FAObatalkesM']['jenisobatalkes_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchDialog(),
    'filter' => $modObatAlkes,
    'template' => "{items}\n{pager}",
    //        'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
        ),
        'obatalkes_nama',
        'obatalkes_kategori',
        'obatalkes_golongan',
        array(
            'name' => 'satuankecil_id',
            'type' => 'raw',
            'value' => '$data->satuankecil->satuankecil_nama',
            'filter' =>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
        ),
        // dicomment karena RND-5732
        //                array(
        //                    'header' => 'Harga Jual (Rp)',
        //                    'name'=>'hargajual',
        //                    'type'=>'raw',
        //                    'value'=>'MyFormatter::formatNumberForPrint($data->hargajual)',
        //                    'filter'=>false,
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => '$data->StokObatRuangan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>