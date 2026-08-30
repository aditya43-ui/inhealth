<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Obat dan Alkes', 'obatalkes_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <?php echo CHtml::hiddenField('qty_stok', 0); ?>
            <?php //echo CHtml::hiddenField('satuankecil_id'); 
            ?>
            <?php //echo CHtml::hiddenField('satuankecil_nama'); 
            ?>
            <?php //echo CHtml::hiddenField('sumberdana_id'); 
            ?>
            <?php //echo CHtml::hiddenField('hargajual'); 
            ?>
            <?php //echo CHtml::hiddenField('harganetto'); 
            ?>
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
							$("#qty_stok").val(ui.item.qty_stok);
							$("#satuankecil_id").val(ui.item.satuankecil_id);
							$("#satuankecil_nama").val(ui.item.satuankecil_nama);
							$("#hargajual").val(ui.item.hargajual);
							$("#harganetto").val(ui.item.harganetto);
							$("#obatalkes_nama").val(ui.item.obatalkes_nama);
							$("#sumberdana_id").val(ui.item.sumberdana_id);
							return false;
						 }',
                ),
                'htmlOptions' => array(
                    'class' => 'custom-only', 'placeholder' => 'Obat dan Alkes',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
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
                    'onclick' => 'tambahObatAlkesPasien(this);return false;',
                    'class' => 'btn btn-danger',
                    'onkeyup' => "tambahObatAlkesPasien(this);",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Obat dan Alkes",
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
        //'title'=>'Obat dan Alkes',
        'title' => 'Stok Obat Alkes ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 600,
        'resizable' => false,
    ),
));
$modObatAlkes = new InfostokobatalkesruanganV('searchObat');
$modObatAlkes->unsetAttributes();
if (isset($_GET['InfostokobatalkesruanganV'])) {
    $modObatAlkes->attributes = $_GET['InfostokobatalkesruanganV'];
    //$modObatAlkes->jenisobatalkes_nama = $_GET['InfostokobatalkesruanganV']['jenisobatalkes_nama'];
    // $modObatAlkes->satuankecil_nama = $_GET['InfostokobatalkesruanganV']['satuankecil_nama'];
    //    $modObatAlkes->sumberdana_nama = $_GET['LBObatalkesM']['sumberdana_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchObat(),
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
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
                                        $(\'#satuankecil_id\').val($data->satuankecil_id);
                                        $(\'#satuankecil_nama\').val(\'$data->satuankecil_nama\');
                                        $(\'#hargajual\').val($data->hargajual);
                                        $(\'#harganetto\').val($data->harganetto);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => function ($data) {
                return (!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "");
            },
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(
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
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                'empty' => '-- Pilih --'
            ))
        ),
        array(
            'name' => 'obatalkes_nama',
            'filter' => CHtml::activeTextField($modObatAlkes, 'obatalkes_nama', array('class' => 'custom-only'))
        ),

        //  'obatalkes_kategori',
        // 'obatalkes_golongan',
        // array(
        //    'name'=>'satuankecil_id',
        //    'type'=>'raw',
        //     'value'=>'$data->satuankecil->satuankecil_nama',
        //    'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
        // ),
        //                array(
        //                    'name'=>'sumberdana_id',
        //                    'type'=>'raw',
        //                    'value'=>'$data->sumberdana->sumberdana_nama',
        //                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => 'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))." ".$data->satuankecil_nama',
        ),


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
));

$this->endWidget();
?>