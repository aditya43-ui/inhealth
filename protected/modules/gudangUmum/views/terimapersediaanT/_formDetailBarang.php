<div id="formDetailBarang" class="row">
	<div class="col-sm-6">		
		<div class="control-group ">
			<label class='control-label'>Barang</label>
			<div class="controls">
				<?php echo CHtml::hiddenField('idBarang'); ?>
				<?php
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'namaBarang',
						'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . Yii::app()->createUrl('ActionAutoComplete/barang') . '",
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
								$(this).val( ui.item.label);
								return false;
							}',
							'select' => 'js:function( event, ui ) {
								$("#idBarang").val(ui.item.barang_id); 
								return false;
							}',
						),
						'htmlOptions' => array(
							'onkeypress' => "return $(this).focusNextInputField(event)",
							'class' => 'span3 custom-only',
						),
						'tombolDialog' => array('idDialog' => 'dialogBarang'),
					));
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group ">
			<label class='control-label'>Jumlah</label>
			<div class="controls">
				<?php echo Chtml::textField('jumlah', MyFormatter::formatNumberForPrint(1,2), array('class' => 'span1 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event)", "style"=>'text-align: right;')); ?>                
				<?php echo Chtml::dropDownList('satuan', '', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
				<?php
					echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
					array('onclick' => 'inputBarang();return false;',
						'class' => 'btn btn-primary',
						'onkeypress' => "inputBarang();return $(this).focusNextInputField(event)",
						'rel' => "tooltip",
						'title' => "Klik untuk menambahkan Barang",));
				?>
			</div>
		</div>		
	</div>
</div>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modBarang = new BarangV('search');

$modBarang->unsetAttributes();

//$modPegawai->ruangan_id = 0;
if (isset($_GET['BarangV'])){
    $modBarang->attributes = $_GET['BarangV'];
  //  $modBarang->subsubkelompok_id = $_GET['BarangV']['subsubkelompok_id'];
    $modBarang->barang_aktif = true;
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->search(),
    'filter'=>$modBarang,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        ////'barang_id',
        /*
        array(
                        'name'=>'barang_id',
                        'value'=>'$data->barang_id',
                        'filter'=>false,
                ),
         * 
         */
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#idBarang\').val(\'$data->barang_id\');
                                        $(\'#namaBarang\').val(\'$data->barang_nama\');
                                        $(\'#satuan\').val(\'$data->barang_satuan\');
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"))',
        ),
        /*array(
            'name'=>'golongan_id',
            'value'=>'$data->golongan_nama',
            'filter'=> CHtml::dropDownList('BarangV[golongan_id]',$modBarang->golongan_id,CHtml::listData(GolonganM::model()->findAll(array(
                'condition'=>'golongan_aktif = true',
                'order'=>'golongan_nama',
            )), 'golongan_id', 'golongan_nama'),array('empty'=>'--Pilih--'))
        ),
        array(
            'name'=>'bidang_id',
            'value'=>'$data->bidang_nama',
            'filter'=>  CHtml::dropDownList('BarangV[bidang_id]',$modBarang->bidang_id,CHtml::listData(BidangM::model()->findAll(array(
                'condition'=>'bidang_aktif = true',
                'order'=>'bidang_nama',
            )), 'bidang_id', 'bidang_nama'),array('empty'=>'--Pilih--'))
        ),
        array(
            'name'=>'kelompok_id',
            'value'=>'$data->kelompok_nama',
            'filter'=>   CHtml::dropDownList('BarangV[kelompok_id]',$modBarang->kelompok_id,CHtml::listData(KelompokM::model()->findAll(array(
                'condition'=>'kelompok_aktif = true',
                'order'=>'kelompok_nama',
            )), 'kelompok_id', 'kelompok_nama'),array('empty'=>'--Pilih--'))
        ),
        array(
            'name'=>'subkelompok_id',
            'value'=>'$data->subkelompok_nama',
            'filter'=>  CHtml::dropDownList('BarangV[subkelompok_id]',$modBarang->subkelompok_id,CHtml::listData(SubkelompokM::model()->findAll(array(
                'condition'=>'subkelompok_aktif = true',
                'order'=>'subkelompok_nama',
            )), 'subkelompok_id', 'subkelompok_nama'),array('empty'=>'--Pilih--'))
        ),
        array(
            'name'=>'subsubkelompok_id',
            'value'=>'$data->subkelompok_nama',
            'filter'=>  CHtml::dropDownList('BarangV[subsubkelompok_id]',$modBarang->subsubkelompok_id,CHtml::listData(SubkelompokM::model()->findAll(array(
                'condition'=>'subkelompok_aktif = true',
                'order'=>'subkelompok_nama',
            )), 'subkelompok_id', 'subkelompok_nama'),array('empty'=>'--Pilih--'))
        ),*/
        
//        'bidang_id',          
        array(
            'header' => 'Tipe Barang',
            'name' => 'barang_type',
            'value' => '$data->barang_type',            
            'filter' => CHtml::dropDownList('BarangV[barang_type]', $modBarang->barang_type, LookupM::getItems('barangumumtype'), array('empty' => '-- Pilih --'))
          ),
        array(
            'header' => 'Kode Barang',
            'name' => 'barang_kode',
            'value' => '$data->barang_kode',            
          ),
        'barang_nama',
//        'barang_satuan',
        array(
            'name'=>'barang_satuan',
            'filter'=>  CHtml::dropDownList('BarangV[barang_satuan]',$modBarang->barang_satuan,LookupM::getItems('satuanbarang'),array('empty'=>'--Pilih--')),
            'value'=>'$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_bahan',
//        'barang_namalainnya',
        
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
