<div class="row form-horizontal">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Bahan', 'namalinen', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('bahanperawatan_id'); ?>
                <?php echo CHtml::hiddenField('bahanperawatan_jenis'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'bahanperawatan_nama',
                    'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompleteBahanPerawatan') . '",
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
                        'focus' => 'js:function( event, ui ) {
								$(this).val("");
								return false;
							}',
                        'select' => 'js:function( event, ui ) {
								$(this).val(ui.item.value);
								$("#bahanperawatan_id").val(ui.item.bahanperawatan_id);
								$("#bahanperawatan_nama").val(ui.item.bahanperawatan_nama);
								$("#bahanperawatan_jenis").val(ui.item.bahanperawatan_jenis);
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Bahan Perawatan',
                        'onkeypress' => 'if(this.value === "") $("#bahanperawatan_id").val(""); $("#bahanperawatan_jenis").val(""); $("#bahanperawatan_id").val(""); ',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBahanPerawatan'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jumlah', 'qty_input', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('jumlah', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Satuan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('satuan', 'satuan', CHtml::listData(LASatuankecilM::model()->findAll(), 'satuankecil_nama', 'satuankecil_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'onclick' => 'tambahBahanPerawatan();return false;',
                    'class' => 'btn btn-primary',
                    'onkeyup' => "tambahBahanPerawatan();",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan bahan yang digunakan",
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBahanPerawatan',
    'options' => array(
        'title' => 'Bahan Perawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 400,
        'resizable' => true,
    ),
));
$modBahanLinen = new LABahanperawatanM('searchDialog');
$modBahanLinen->unsetAttributes();
if (isset($_GET['LABahanperawatanM'])) {
    $modBahanLinen->attributes = $_GET['LABahanperawatanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modBahanLinen->searchDialog(),
    'filter' => $modBahanLinen,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
						"id" => "selectObat",
						"onClick" => "
							$(\'#bahanperawatan_id\').val($data->bahanperawatan_id);
							$(\'#bahanperawatan_jenis\').val(\'$data->bahanperawatan_jenis\');
							$(\'#bahanperawatan_nama\').val(\'$data->bahanperawatan_nama\');
							$(\'#dialogBahanPerawatan\').dialog(\'close\');
							
							return false;"
					))',
        ),
        'bahanperawatan_jenis',
        'bahanperawatan_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>