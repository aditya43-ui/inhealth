<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Obat & Alkes', 'obatalkes_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
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
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Jumlah', 'qty_input', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('qty_input', '1,00', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer-decimal')) ?>
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahObatAlkes();return false;',
                        'class' => 'btn btn-primary',
                        'onkeyup' => "tambahObatAlkes();",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Obat/Alkes",
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Stok Obat Alkes ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 600,
        'resizable' => false,
    ),
));

// $modObatAlkesVv = new ADObatalkesV('searchDialog');
// $modObatAlkesVv->unsetAttributes();
// // $modObatAlkesVv->obatalkes_aktif = true;
// if (isset($_GET['ADObatalkesM'])) {
//     $modObatAlkesVv->attributes = $_GET['ADObatalkesM'];
//     // $modObatAlkesVv->supplier_nama = $_GET['ADObatalkesM']['supplier_nama'];
//     // var_dump($modObatAlkesVv->supplier_naam);die;
//     // $modObatAlkesVv->satuankecil_nama = $_GET['ADObatalkesM']['satuankecil_nama'];
//     // $modObatAlkesVv->jenisobatalkes_nama = $_GET['ADObatalkesM']['jenisobatalkes_nama'];
// }
// echo "<pre>";
// var_dump($modObatAlkesVv->searchDialog()->data);die;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkesVv->searchDialog(),
    'filter' => $modObatAlkesVv,
    'template' => "{summary}\n{items}\n{pager}",
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
            'header' => 'Supplier',
            'name' => 'supplier_nama',
            'value' => '$data->supplier_nama',
        ),
        // array(
        //     'header'=>'Jenis',
        //     'name'=>'jenisobatalkes_id',
        //     'type'=>'raw',
        //     'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
        //     'filter'=>  CHtml::activeDropDownList($modObatAlkesVv, 'jenisobatalkes_nama', 
        //             CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true order by jenisobatalkes_nama asc'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), 
        //             array('empty'=>'-- Pilih --')),
        // ),
        array(
            'name' => 'obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatAlkesVv, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatAlkesVv, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        'obatalkes_nama',
        array(
            'header' => 'Tgl. Kadaluarsa',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
        ),
        array(
            'header' => 'Harga Netto',
            'type' => 'raw',
            'value' => '"Rp. ".MyFormatter::formatNumberForPrint($data->harganetto,2)',
            'filter' => false,
            'htmlOptions' => array(
                'style' => 'text-align: right',
            )
        ),
        // array(
        //     'header'=>'Stok',
        //     'type'=>'raw',
        //     // 'value'=>'$data->StokObatRuangan." ".$data->satuankecil->satuankecil_nama',
        // 	'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))." ".$data->satuankecil->satuankecil_nama',
        //     'htmlOptions'=>array(
        //         'style'=>'text-align: right',
        //     )
        // ),


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>