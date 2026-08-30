<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Nama Obat & Kesehatan', 'obatalkes_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <?php echo CHtml::hiddenField('stokobatalkes_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'obatalkes_nama',
                'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
							dataType: "json",
							data: {
								term: request.term,
								ruangan_id: $("#' . CHtml::activeId($model, 'ruanganasal_id') . '").val(),
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
							$("#stokobatalkes_id").val(ui.item.stokobatalkes_id);
							$("#obatalkes_nama").val(ui.item.obatalkes_nama);
							return false;
						}',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Obat & Kesehatan',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Jumlah', 'qty_input', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('qty_input', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')) ?>
            <?php echo CHtml::htmlButton(
                '<i class="icon-plus icon-white"></i>',
                array(
                    'onclick' => 'tambahObatAlkes();return false;',
                    'class' => 'btn btn-primary',
                    'onkeyup' => "tambahObatAlkes();",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan resep",
                )
            ); ?>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Obat dan Alkes <span id="ruangannama-asal"></span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 500,
        'resizable' => false,
    ),
));
$modObatAlkes = new GFInformasikartustokobatalkesV('search');
$modObatAlkes->unsetAttributes();
if (isset($_GET['GFInformasikartustokobatalkesV'])) {
    $modObatAlkes->attributes = $_GET['GFInformasikartustokobatalkesV'];
    $modObatAlkes->transaksi = isset($_GET['GFInformasikartustokobatalkesV']['transaksi']) ? $_GET['GFInformasikartustokobatalkesV']['transaksi'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchDialogPemusnahan(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#stokobatalkes_id\').val($data->stokobatalkes_id);
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
            'filter' => CHtml::activeHiddenField($modObatAlkes, 'ruangan_id', array('readonly' => true)),
        ),
        array(
            'header' => 'Transaksi',
            'type' => 'raw',
            'value' => '$data->NamaTransaksi',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'transaksi', $modObatAlkes->getTransaksiMasukItems(), array('empty' => '')),
        ),
        array(
            'name' => 'create_time',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->create_time)',
            'filter' => false,
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'name' => 'satuankecil_nama',
            'type' => 'raw',
            'filter' => CHtml::listData(GFSatuanKecilM::getItems(), 'satuankecil_nama', 'satuankecil_nama'),
        ),
        'nobatch',
        array(
            'name' => 'tglkadaluarsa',
            'type' => 'raw',
            'value' => 'date("d/m/Y",strtotime($data->tglkadaluarsa))',
            'filter' => CHtml::activeTextField($modObatAlkes, 'tglkadaluarsa', array('class' => 'datemask', 'placeholder' => 'cth:15/01/2020', 'onkeyup' => 'return $(this).focusNextInputField(event)')),
        ),
        array(
            'header' => 'HPP (Rp)',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint(round($data->HPP))',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Harga Jual Apotek (Rp)',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint(round($data->HargaJualApotek))',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Stok',
            'type' => 'raw',
            'value' => '$data->StokObatBatch',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){$("#obatalkes-m-grid .datemask").mask("99/99/9999");jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>