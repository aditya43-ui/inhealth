<div class="control-group ">
    <?php echo CHtml::label('Nama Bahan dan Alat Kesehatan', 'obatalkes_nama', array('class'=>'control-label')); ?>
    <div class="controls">
	<?php echo CHtml::hiddenField('obatalkes_id'); ?>
	<?php echo CHtml::hiddenField('obatalkes_kode'); ?>
	<?php echo CHtml::hiddenField('qty_stok' ,0); ?>
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
					   'minLength' => 3,
					   'focus'=> 'js:function( event, ui ) {
							$(this).val("");
							return false;
						}',
					   'select'=>'js:function( event, ui ) {
							$(this).val(ui.item.value);
							$("#obatalkes_id").val(ui.item.obatalkes_id);
							$("#obatalkes_kode").val(ui.item.obatalkes_kode);
							$("#qty_stok").val(ui.item.qty_stok);
							$("#qty_input").val(ui.item.kemasanterkecil);
							$("#jmlkemasa").val(ui.item.kemasanterkecil);
							$("#obatalkes_nama").val(ui.item.obatalkes_nama);
							setSatuanObat(ui.item.obatalkes_id);
							totalKonversi();
							return false;
						}',
				),
				'htmlOptions'=>array(
					'onkeyup'=>"return $(this).focusNextInputField(event)",
				),
				'tombolDialog'=>array('idDialog'=>'dialogObatAlkes'),
			)); 
        ?>
    </div>
</div>

<div class="control-group ">
    <?php echo CHtml::label('jumlah', 'qty_input', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);totalKonversi();','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 float')) ?>
		/ <?php echo CHtml::textField('jmlkemasan', '1', array('readonly'=>false,'onblur'=>'$("#jmlkemasan").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 float','readonly'=>true)) ?> <span id="satuanterkecil_nama"></span> = 
		<?php echo CHtml::textField('jmlkonversi', '1', array('readonly'=>false,'onblur'=>'$("#jmlkonversi").val(this.value);totalJumlah();','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 float')) ?> <span id="satuankecil_nama"></span>
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                array('onclick'=>'tambahObatAlkesPasien(this);return false;',
                      'class'=>'btn btn-primary',
                      'onkeyup'=>"tambahObatAlkesPasien(this);",
                      'rel'=>"tooltip",
                      'title'=>"Klik untuk menambahkan resep",)); ?>
    </div>
</div>

<div class="block-tabel">
	<h6>Tabel <b>Pemakaian Bahan</b></h6>
	<table class="items table table-striped table-condensed" id="table-pemakaian-bahan">        
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Obat Alkes</th>
				<th>Jumlah</th>
				<th>Batal</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkes',
    'options'=>array(
        'title'=>'Obat & Alat Kesehatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));
echo "Menampilkan 10 Data";
$modObatAlkes = new ATObatalkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if(isset($_GET['ATObatalkesM'])){
    $modObatAlkes->attributes = $_GET['ATObatalkesM'];
    $modObatAlkes->jenisobatalkes_nama = $_GET['ATObatalkesM']['jenisobatalkes_nama'];
    $modObatAlkes->satuankecil_nama = $_GET['ATObatalkesM']['satuankecil_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modObatAlkes->searchDialog(),
	'filter'=>$modObatAlkes,
	//'template'=>"{summary}\n{items}\n{pager}",
	'template'=>"\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectObat",
				"onClick" => "
					$(\'#obatalkes_id\').val($data->obatalkes_id);
					$(\'#obatalkes_kode\').val(\'$data->obatalkes_kode\');
					$(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
					$(\'#satuankecil_id\').val($data->satuankecil_id);
					$(\'#satuankecil_nama\').val(\'$data->SatuanKecilNama\');
					$(\'#hargajual\').val($data->hargajual);
					$(\'#harganetto\').val($data->harganetto);
					$(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
					$(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
					$(\'#qty_input\').val(\'$data->kemasanterkecil\');
					$(\'#jmlkemasan\').val(\'$data->kemasanterkecil\');
					$(\'#dialogObatAlkes\').dialog(\'close\');										
					setSatuanObat($data->obatalkes_id);
					totalKonversi();
					return false;"
					))',
		),
		array(
			'name'=>'jenisobatalkes_id',
			'type'=>'raw',
			'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
			'filter'=>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
		),
		'obatalkes_nama',
		'obatalkes_kategori',
		'obatalkes_golongan',
		array(
			'name'=>'satuankecil_id',
			'type'=>'raw',
			'value'=>'$data->satuankecil->satuankecil_nama',
			'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
		),
		array(
			'header'=>'Jumlah Stok',
			'type'=>'raw',
			'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))',
		),  
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
