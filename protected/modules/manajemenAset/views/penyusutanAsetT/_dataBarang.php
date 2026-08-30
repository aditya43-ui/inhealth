<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'barang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('barang_id', '', array('readonly' => true)); ?>
                <?php echo CHtml::hiddenField('inv_id', '', array('readonly' => true)); ?>
                <?php echo CHtml::hiddenField('nama_inv', '', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaBarang',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteBarang') . '",
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
									$("#barang_id").val(ui.item.barang_id);
									$("#namaBarang").val(ui.item.barang_nama);
									$("#' . CHtml::activeId($model, 'hargaperolehan') . '").val(ui.item.barang_harganetto);
									setAutoLoad(ui.item.barang_id);
									return false;
								}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama Barang',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#barang_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBarangSusut'),
                ));
                ?>

            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'kodeInventarisasi', array('class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true)); ?>
        <?php echo $form->textFieldRow($model, 'noRegister', array('class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true)); ?>
    </div>
    <div class="span6">
        <?php echo $form->textFieldRow($model, 'hargaperolehan', array('class' => 'span3 integer-decimal', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true)); ?>
        <div class="control-group ">
            <?php echo CHtml::label('Tanggal Perolehan Barang', 'tglPerolehanBarang', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tglPerolehanBarang', array('class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'umurekonomis', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'umurekonomis', array('class' => 'span3 integer', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true, 'value' => '1')); ?>
                <?php echo CHtml::activeLabel($model, 'tahun') ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarangSusut',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => false,
    ),
));

$modBarang = new MABarangM('searchDialog');
$modBarang->unsetAttributes();
if (isset($_GET['MABarangV'])) {
    $modBarang->attributes = $_GET['MABarangV'];
}
$modBarang->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barangsusut-t-grid',
    'dataProvider' => $modBarang->searchDialog(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $load = $data->attributes;
                $load['barang_harganetto'] = MyFormatter::formatNumberForUser($data->barang_harganetto, 2);
                $res = json_encode($load);
                
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>', "javascript:;", array("class" => "btn-small",
                            "onclick" => 'setAutoLoad(' . $res . ');'));
            },
        ),
        'barang_nama',
        'barang_kode',
        'barang_ekonomis_thn',
        'barang_harganetto',
        [
            'header' => 'Harga Netto',
            'value' => function($data) {
                return MyFormatter::formatUang($data->barang_harganetto, "Rp.", 2);
            },
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>