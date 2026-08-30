<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Obat dan Alkes', 'obatalkes_nama', array('class' => 'col-sm-4 control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
                <?php echo CHtml::hiddenField('jenisobatalkes_nama'); ?>
                <?php echo CHtml::hiddenField('tglkadaluarsa'); ?>
                <?php echo CHtml::hiddenField('stokoa'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'obatalkes_nama',
                    'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
							dataType: "json",
							data: {
								term: request.term,
								ruangan_id: $("#GFPesanobatalkesT_ruangan_id").val()
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
                        'placeholder' => 'Nama Obat & Kesehatan',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'span4',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObatAlkes', 'idTombol' => 'tombolDialogObatAlkes'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jumlah', 'qty_input', array('class' => 'col-sm-2 control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('qty_input', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')) ?>
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahObatAlkes();return false;',
                        'class' => 'btn btn-primary',
                        'onkeyup' => "tambahObatAlkes();",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Obat dan Alkes",
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
        'title' => 'Daftar Stok',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 500,
        'resizable' => false,
    ),
));
$modObatAlkes = new GFInfostokobatalkesruanganV('searchDataObat');
$modObatAlkes->unsetAttributes();
//$modObatAlkes = $model->ruangan_id;
if (isset($_GET['GFInfostokobatalkesruanganV'])) {
    $modObatAlkes->attributes = $_GET['GFInfostokobatalkesruanganV'];
    //$modObatAlkes->jenisobatalkes_nama = isset($_GET['GFObatalkesM']['jenisobatalkes_nama'])?$_GET['GFObatalkesM']['jenisobatalkes_nama']:null;
    //$modObatAlkes->satuankecil_nama = isset($_GET['GFObatalkesM']['satuankecil_nama'])?$_GET['GFObatalkesM']['satuankecil_nama']:null;    
    // $modObatAlkes->ruangan_id = $_GET['GFPesanobatalkesT']['ruangan_id'];
    //$_GET['GFPesanobatalkesT']['ruangan_id'] = $_GET['GFInfostokobatalkesruanganV']['ruangan_id'];

}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchDataObat(),
    'filter' => $modObatAlkes,
    // 'template'=>"{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            /*'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#jenisobatalkes_nama\').val(\'$data->jenisobatalkes_nama\');
                                        $(\'#tglkadaluarsa\').val(\'$data->tglkadaluarsa\');                                        
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',*/
            'value' => function ($data) use (&$modObatAlkes) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "selectObat",
                    "onClick" => '
                                        $(\'#obatalkes_id\').val("' . $data->obatalkes_id . '");
                                        $(\'#obatalkes_nama\').val("' . $data->obatalkes_nama . '");
                                        $(\'#jenisobatalkes_nama\').val("' . $data->jenisobatalkes_nama . '");
                                        $(\'#tglkadaluarsa\').val("' . $data->tglkadaluarsa . '");
                                        $(\'#stokoa\').val("' . $data->getStokObatRuanganPemesan($modObatAlkes->ruangan_id) . '");
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;'
                ));
            }
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '$data->jenisobatalkes_nama',
            'filter' =>  CHtml::activeHiddenField($modObatAlkes, 'instalasi_id', array('class' => 'dialog_instalasi_id')) . CHtml::activeHiddenField($modObatAlkes, 'ruangan_id', array('class' => 'dialog_ruangan_id')) . CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_golongan',
            'type' => 'raw',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'type' => 'raw',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --')),
        ),
        'obatalkes_nama',
        /*
                 array(
                    'header' => 'Tgl. Kedaluwarsa',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)'
                ),
                 * 
                 */
        //'obatalkes_kategori',
        // yang bawah
        //'obatalkes_golongan',
        //yangbawah
        /*
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                    'filter'=>  CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_id','satuankecil_nama'),
                ),
                 * 
                 */
        // dicomment karena RND-5732
        //                array(
        //                    'name'=>'hargajual',
        //                    'type'=>'raw',
        //                    'value'=>'MyFormatter::formatNumberForPrint($data->hargajual)',
        //                    'filter'=>false,
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => '$data->getStokObatRuanganPemesan(' . $modObatAlkes->ruangan_id . ')." ".$data->satuankecil_nama',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>