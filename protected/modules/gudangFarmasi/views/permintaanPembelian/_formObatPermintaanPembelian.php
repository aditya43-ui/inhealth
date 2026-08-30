<style>
    .tab_info {
        width:100%;
    }
    .tab_info td, .tab_info th {
        color: black;
        border: 1px solid black;
        padding: 3px;
    }
    
    .tab_info th, .tab_info .head {
        font-weight: bold;
    }
    
    .info_num {
        text-align: right;
    }
</style>

<div class="col-sm-6">
	<!--<div class="control-group ">-->
		<?php // echo CHtml::label('Golongan Obat', 'obatalkes_nama', array('class'=>'control-label')); ?>
		<!--<div class="controls">-->
            <?php 
//            $kategori = CHtml::listData(LookupM::model()->findAllByAttributes(array(
//                'lookup_type'=>'obatalkes_golongan',
//            ), array(
//                'condition'=>"lookup_kode is not null and trim(lookup_kode) <> ''",
//                'order'=>'lookup_urutan',
//            )), 'lookup_name', 'lookup_value');
//            
//            echo CHtml::dropDownList('oa_kategori_obat', null, $kategori, array('empty'=>'-- Pilih --', 'onchange'=>'setKategoriObat();')); ?>
        <!--</div>-->
    <!--</div>-->
	<div class="control-group ">
            <?php echo CHtml::label('Nama Obat dan Alkes', 'obatalkes_nama', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('obatalkes_id','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php echo CHtml::hiddenField('statusobat','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                            'name'=>'obatalkes_nama',
                            'source'=>'js: function(request, response) {
                                    $.ajax({
                                            url: "'.$this->createUrl('AutocompleteObatAlkes').'",
                                            dataType: "json",
                                            data: {
                                                    term: request.term,
                                            },
                                            success: function (data) {
                                                    response(data);
                                            }
                                    })
                            }',
                            'options'=>array(
                                    'showAnim'=>'fold',
                                    'minLength' => 2,
                                    'focus'=> 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                    }',
                                    'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#obatalkes_id").val(ui.item.obatalkes_id);
                                            $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                viewStokOA(ui.item.obatalkes_id);
                                            return false;
                                    }',
                       ),
                            'htmlOptions'=>array(
                                    'class'=>'',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogObatAlkesSupplier'),
                    )); 
                ?>
            </div>
	</div>	
	<div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::checkBox('berdasarkanMasterOa', false,array('onclick'=>'setValue(this);', 'rel'=>'tootip','title'=>'Ceklis Jika Ingin Menampilkan Semua Data Obat & Alkes dari Master', 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                <label>Berdasarkan Master Obat dan Alkes</label>
            </div>
	</div>
	
	<div class="control-group ">
		<?php //echo CHtml::label('Jumlah', 'qty_input', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php //echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer2')) ?>
			<?php /*echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
				array('onclick'=>'tambahObatAlkes();return false;',
				'class'=>'btn btn-primary',
				'onkeyup'=>"tambahObatAlkes();",
				'rel'=>"tooltip",
				'title'=>"Klik untuk menambahkan resep",));*/ ?>
		</div>
	</div>	
</div>
<div class="col-sm-6">
    <div class="control-group ">
        <?php echo CHtml::label('Jumlah', 'qty_input', array('class'=>'control-label')); ?>
        <div class="controls">
                <?php echo CHtml::textField('qty_input', '1.00', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer-decimal', 'style' => 'text-align:right;width:50px;')) ?>
        </div>
        <div class="controls">
                <?php echo CHtml::textField('ceksatuankecil', '', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbers-only', 'style' => 'text-align:right;')) ?>
        </div>
        <div class="controls">
                <?php echo CHtml::textField('ceksatuanbesar', '', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbers-only', 'style' => 'text-align:right;display:none;')) ?>
        </div>
        <div class="controls">
                <?php echo CHtml::dropDownList('tipesatuan', Params::SATUANOBAT_KECIL ,LookupM::getItems('satuanobat'), array('style'=>'width:120px;', 'onchange'=>'cekTipeSatuan(this);')) ?>
        </div>
        <div class="controls">
                <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                        array('onclick'=>'tambahObatAlkes();return false;',
                        'class'=>'btn btn-primary',
                        'onkeyup'=>"tambahObatAlkes();",
                        'rel'=>"tooltip",
                        'title'=>"Klik untuk menambahkan data",)); ?>
        </div>		
    </div>	
    <table class="tab_info" hidden>
        <tr>
            <th colspan="2">Informasi Stok</th>
        </tr>
        <tr>
            <td class="head">Min Stok</td><td class="info_num" id="info_stok_min"></td>
        </tr>
        <tr>
            <td class="head">Max Stok</td><td class="info_num" id="info_stok_max"></td>
        </tr>
        <tr id="info_head_det">
            <td class="head">Tgl. Kadaluarsa</td>
            <td class="head">Stok Akhir</td>
        </tr>
        <span class="tab_info_content">
            
        </span>
    </table>
</div>
<?php
//========= Dialog buat cari data Alat Kesehatan Supplier =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkesSupplier',
    'options'=>array(
        'title'=>'Master Obat & Alat Kesehatan Supplier "<span id="suppliernama"></span>"',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatAlkes = new GFObatSupplierM('searchDialog');
$modObatAlkes->unsetAttributes();
if(isset($_GET['GFObatSupplierM'])){
    $modObatAlkes->attributes = $_GET['GFObatSupplierM'];    
	$modObatAlkes->jenisobatalkes_id = isset($_GET['GFObatSupplierM']['jenisobatalkes_id'])?$_GET['GFObatSupplierM']['jenisobatalkes_id']:null;
	$modObatAlkes->obatalkes_golongan = isset($_GET['GFObatSupplierM']['obatalkes_golongan'])?$_GET['GFObatSupplierM']['obatalkes_golongan']:null;
	$modObatAlkes->obatalkes_kategori = isset($_GET['GFObatSupplierM']['obatalkes_kategori'])?$_GET['GFObatSupplierM']['obatalkes_kategori']:null;
	$modObatAlkes->obatalkes_nama = isset($_GET['GFObatSupplierM']['obatalkes_nama'])?$_GET['GFObatSupplierM']['obatalkes_nama']:null;	
	$modObatAlkes->satuankecil_id = isset($_GET['GFObatSupplierM']['satuankecil_id'])?$_GET['GFObatSupplierM']['satuankecil_id']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkessupplier-m-grid',
	'dataProvider'=>$modObatAlkes->searchDialog(),
	'filter'=>$modObatAlkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
										$(\'#statusobat\').val(\'supplier\');
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatNama\');
										$(\'#ceksatuankecil\').val(\'$data->satuanKecil\');
										$(\'#ceksatuanbesar\').val(\'$data->satuanBesar\');
										cekTipeSatuan($(\'#tipesatuan\'));
                                        $(\'#dialogObatAlkesSupplier\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
                array(
                    'header'=>'Jenis Obat Alkes',
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
					'value'=>function($data){
						if (!empty($data->obatalkes->jenisobatalkes)){
							return $data->obatalkes->jenisobatalkes->jenisobatalkes_nama;
						}else{
							return '';
						}
					},
                    'filter'=> CHtml::activeHiddenField($modObatAlkes, 'supplier_id',array('class' => 'dialog_supplier_id')).CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                        'condition'=>'jenisobatalkes_aktif = true',
                        'order'=>'jenisobatalkes_nama'
                    )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --')),
                ),
                array(
					'header' => 'Kategori',
                    //'name'=>'obatalkes_kategori',
					'value'=>function($data){
						if (!empty($data->obatalkes->obatalkes_kategori)){
							return $data->obatalkes->obatalkes_kategori;
						}else{
							return '';
						}
					},
                    'filter'=> CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
                ),
                array(
					'header' => 'Golongan',
                    //'name'=>'obatalkes_golongan',
					'value'=>function($data){
						if (!empty($data->obatalkes->obatalkes_golongan)){
							return $data->obatalkes->obatalkes_golongan;
						}else{
							return '';
						}
					},
                    'filter'=> CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
                ),
				array(
					'header' => 'Nama',
					'name' => 'obatalkes_nama',
					'value'=>function($data){						
						return $data->obatalkes->obatalkes_nama;						
					},
				),
                //'obatalkes_nama',
                /*array(
                    'header'=>'Satuan Kecil',
                    //'name'=>'satuankecil_nama',
                    'type'=>'raw',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                    'filter'=>CHtml::activeDropDownList($modObatAlkes, 'satuankecil_id', CHtml::listData(
                   SatuankecilM::model()->findAll(array('condition'=>'satuankecil_aktif = true', 'order'=>'satuankecil_nama asc')), 'satuankecil_id', 'satuankecil_nama'
                    ), array('empty'=>'-- Pilih --')),
                ),*/
				array(
                    'name'=>'hargabelibesar',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatNumberForPrint($data->hargabelibesar)',
                    'filter'=>false,
                    'htmlOptions'=>array('style'=>'text-align: right;'),
                ),
                array(
                    'name'=>'hargabelikecil',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatNumberForPrint($data->hargabelikecil)',
                    'filter'=>false,
                    'htmlOptions'=>array('style'=>'text-align: right;'),
                ),
                array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'value'=>'$data->StokObatRuangan',
                    'filter'=>false,
                    'htmlOptions'=>array('style'=>'text-align: right;'),
                ),

                
	),
        'afterAjaxUpdate'=>'function(id, data){'
                            . 'jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"}); '
                            . 'if (jQuery("#oa_kategori_obat").val() != "") {jQuery("#GFObatSupplierM_obatalkes_golongan").hide();}}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkes',
    'options'=>array(
        'title'=>'Master Obat & Alat Kesehatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatAlkes = new ADObatalkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if(isset($_GET['ADObatalkesM'])){
    $modObatAlkes->attributes = $_GET['ADObatalkesM'];
   // $modObatAlkes->satuankecil_nama = $_GET['ADObatalkesM']['satuankecil_nama'];
   // $modObatAlkes->jenisobatalkes_nama = $_GET['ADObatalkesM']['jenisobatalkes_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modObatAlkes->searchDialog(),
	'filter'=>$modObatAlkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
										$(\'#statusobat\').val(\'masteroa\');
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
										$(\'#ceksatuankecil\').val(\'$data->satuanKecil\');
										$(\'#ceksatuanbesar\').val(\'$data->satuanBesar\');
										cekTipeSatuan($(\'#tipesatuan\'));
                                        viewStokOA($data->obatalkes_id);
                                        return false;"
                                        ))',
                ),
               array(
                    'header'=>'Jenis',
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
                   // 'filter'=>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
                    'filter' => CHtml::dropDownList('ADObatalkesM[jenisobatalkes_id]', $modObatAlkes->jenisobatalkes_id, CHtml::listData($modObatAlkes->getJenisObatAlkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header'=>'Kategori',
                    'name' => 'obatalkes_kategori',
                    'value' => '$data->obatalkes_kategori',
                    'filter' => CHtml::dropDownList('ADObatalkesM[obatalkes_kategori]', $modObatAlkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
                ),                
                array(
                    'header'=>'Golongan',
                    'name' => 'obatalkes_golongan',
                    'value' => '$data->obatalkes_golongan',                    
                    'filter' => CHtml::dropDownList('ADObatalkesM[obatalkes_golongan]', $modObatAlkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
                ),                  
                'obatalkes_nama',                
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                    //'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
                    'filter' => CHtml::dropDownList('ADObatalkesM[satuankecil_id]', $modObatAlkes->satuankecil_id, CHtml::listData($modObatAlkes->getSatuanKecilItems(), 'satuankecil_id', 'satuankecil_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'name'=>'hargajual',
                    'type'=>'raw',
                    'value'=>'"Rp.".MyFormatter::formatNumberForPrint($data->hargajual)',
                    'filter'=>false,
                ),
                array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'value'=>'$data->StokObatRuangan',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
