<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
            <label class="control-label" for="namaObat">Obat dan Alkes</label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaObatNonRacik',
                    'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
                        'select' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							$("#obatalkes_id").val(ui.item.obatalkes_id);
							$("#obatalkes_kode").val(ui.item.obatalkes_kode);
							 return false;
						}',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObat', 'idTombol' => 'tombolDialogOa'),
                    'htmlOptions' => array(
                        "rel" => "tooltip",
                        "rel" => "tooltip",
                        "placeholder" => "Obat dan Alkes",
                        'class' => 'span3 custom-only',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label" for="qty">Jumlah</label>
            <div class="controls">
                <?php echo CHtml::textField('qtyNonRacik', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only', 'style' => 'text-align:right;')) ?>
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'onclick' => 'tambahObat(this);return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "tambahObat(this);return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Obat dan Alkes",
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Stok Obat Alkes ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modObatDialog = new InfostokobatalkesruanganV('search');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['InfostokobatalkesruanganV'])) {
    $modObatDialog->attributes = $_GET['InfostokobatalkesruanganV'];
    if (isset($_GET['FAObatalkesM']['therapiobat_id'])) {
        $modObatDialog->therapiobat_id = $_GET['FAObatalkesM']['therapiobat_id'];
    }
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $modObatDialog->searchObat(),
    'filter' => $modObatDialog,
    //'template' => "{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#namaObatNonRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeDropDownList($modObatDialog, 'jenisobatalkes_id', CHtml::listData(
                JenisobatalkesM::model()->findAll(array(
                    'condition' => 'jenisobatalkes_aktif = true',
                    'order' => 'jenisobatalkes_nama',
                )),
                'jenisobatalkes_id',
                'jenisobatalkes_nama'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'filter' =>  CHtml::activeDropDownList($modObatDialog, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' =>  CHtml::activeDropDownList($modObatDialog, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_nama',
            'filter' => CHtml::activeTextField($modObatDialog, 'obatalkes_nama', array('class' => 'custom-only'))
        ),

        //                array(
        //                    'name'=>'sumberdana_id',
        //                    'type'=>'raw',
        //                    'value'=>'$data->sumberdana->sumberdana_nama',
        //                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))." ".$data->satuankecil_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
));

$this->endWidget();
?>