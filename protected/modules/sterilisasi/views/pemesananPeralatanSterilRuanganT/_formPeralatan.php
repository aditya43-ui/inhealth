<div class="row" id="formLinen">
	<div class="col-sm-6">
		<div class="control-group">
			<label class='control-label'>Jenis Peralatan</label>
			<div class="controls">
				<?php echo Chtml::dropDownList('jenis_peralatan','',array('Peralatan'=>'Peralatan','Linen'=>'Linen'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange'=>'peralatanBarang()', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
			</div>
		</div>
                <div id="peralatan">
			<div class="control-group">
				<label class='control-label'>Nama Peralatan</label>
				<div class="controls">
				<?php echo CHtml::hiddenField('barang_id'); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'name'=>'namaPeralatan',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('AutocompletePeralatan').'",
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
										$("#barang_id").val(ui.item.barang_id);
										$("#namaPeralatan").val(ui.item.barang_nama);
										return false;
									}',
							),
							'htmlOptions'=>array(
                                                                'class' => 'span3', 
                                                                'placeholder'=>'Nama Peralatan',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#barang_id").val(""); '
							),
							'tombolDialog'=>array('idDialog'=>'dialogPeralatan'),
						)); 
						?>
				</div>
			</div>
		</div>
		<div id="linen" style="display:none;">
			<div class="control-group">
				<label class='control-label'>Nama Linen</label>
				<div class="controls">
					<?php echo CHtml::hiddenField('linen_id'); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'name'=>'namalinen',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('AutocompleteLinen').'",
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
										$("#linen_id").val(ui.item.linen_id);
										$("#barang_id").val(ui.item.barang_id);
										$("#namalinen").val(ui.item.namalinen);
										return false;
									}',
							),
							'htmlOptions'=>array(
                                                                'class' => 'span3',
                                                                'placeholder'=>'Nama Linen',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#linen_id").val(""); '
							),
							'tombolDialog'=>array('idDialog'=>'dialogLinen'),
						)); 
						?>

				</div>
			</div>
		</div>
	</div>
	
	<div class="col-sm-6">
		<div class="control-group">
			<label class='control-label'>Jumlah</label>
			<div class="controls">
				<?php echo Chtml::textField('jml', '1', array('style'=>'text-align:right;','class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
				&nbsp;&nbsp;&nbsp;
				<?php
				echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
					array('onclick' => 'inputPeralatanLinen();return false;',
						'class' => 'btn btn-primary',
						'onkeypress' => "inputPeralatanLinen();return $(this).focusNextInputField(event)",
						'rel' => "tooltip",
						'title' => "Klik untuk menambahkan Peralatan Sterilisasi",));
				?>	
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		
	</div>
</div>

<?php
//========= Dialog buat cari Peralatan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPeralatan',
    'options' => array(
        'title' => 'Daftar Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));

$modPeralatan = new STBarangV('searchDialog');
$modPeralatan->unsetAttributes();
if (isset($_GET['STBarangV'])){
    $modPeralatan->attributes = $_GET['STBarangV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-v-grid',
    'dataProvider'=>$modPeralatan->searchDialog(),
    'filter'=>$modPeralatan,
  'template'=>"{summary}\n{items}\n{pager}",
  'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
			"id" => "selectRegister",
			"onClick" => "
			  $(\'#barang_id\').val(\'$data->barang_id\');
			  $(\'#namaPeralatan\').val(\'$data->barang_nama\');
			  $(\'#dialogPeralatan\').dialog(\'close\');
			  return false;"))',
        ),
		array(
          'header'=>'Tipe',
		  'name'=>'barang_type',
		  'type'=>'raw',
		  'value'=>'$data->barang_type'
		),
		array(
          'header'=>'Kode',
		  'name'=>'barang_kode',
		  'type'=>'raw',
		  'value'=>'$data->barang_kode'
		),  
		array(
          'header'=>'Nama',
		  'name'=>'barang_nama',
		  'type'=>'raw',
		  'value'=>'$data->barang_nama'
		),/*
		array(
		  'name'=>'golongan_nama',
		  'type'=>'raw',
		  'value'=>'$data->golongan_nama'
		),*/
    
    ),
  'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog buat cari Nama Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLinen',
    'options' => array(
        'title' => 'Daftar Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));

$modLinen = new STLinenM('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['STLinenM'])){
    $modLinen->attributes = $_GET['STLinenM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'linen-m-grid',
    'dataProvider'=>$modLinen->searchDialog(),
    'filter'=>$modLinen,
  'template'=>"{summary}\n{items}\n{pager}",
  'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
        "id" => "selectLinen",
        "onClick" => "
          $(\'#linen_id\').val(\'$data->linen_id\');
		  $(\'#barang_id\').val(\'$data->barang_id\');
          $(\'#namalinen\').val(\'$data->namalinen\');
          $(\'#dialogLinen\').dialog(\'close\');
          return false;"))',
        ),
    
		array(
		  'name'=>'namalinen',
		  'type'=>'raw',
		  'value'=>'$data->namalinen'
		),
		array(
		  'name'=>'noregisterlinen',
		  'type'=>'raw',
		  'value'=>'$data->noregisterlinen'
		),  
		array(
		  'header'=>'Tanggal Register',
		  'type'=>'raw',
		  'value'=>'MyFormatter::formatDateTimeForUser($data->tglregisterlinen)'
		),
//		array(
//		  'header'=>'Barang',
//		  'type'=>'raw',
//		  'value'=>'isset($data->barang_id)?$data->barang->barang_nama:""'
//		),
		array(
		  'header'=>'Bahan',
		  'type'=>'raw',
		  'value'=>'isset($data->bahan)?$data->bahan->bahanlinen_nama:""'
		),
		array(
		  'header'=>'Jenis',
		  'type'=>'raw',
		  'value'=>'isset($data->jenis)?$data->jenis->jenislinen_nama:""'
		),
    
    ),
  'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>