<div class="row-fluid">
	<div class = "col-sm-6">
		<?php echo CHtml::hiddenField('penerimaanbarang_id',$modPenerimaanBarang->penerimaanbarang_id, array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo $form->hiddenField($modPenerimaanBarang,'permintaanpembelian_id', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo $form->hiddenField($modPenerimaanBarang,'harganetto', array('class'=>'span3 integer','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo $form->hiddenField($modPenerimaanBarang,'totalharga', array('class'=>'span3 integer','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo $form->hiddenField($modPenerimaanBarang,'persendiscount', array('class'=>'span3 integer','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo $form->hiddenField($modPenerimaanBarang,'jmldiscount', array('class'=>'span3 integer','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php if(isset($_GET['sukses'])) { ?>
		   <?php echo $form->textFieldRow($modPenerimaanBarang,'noterima', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
		<?php } ?>
		<div class="control-group ">
				<?php echo CHtml::label('Tanggal Pembelian','tglterima', array('class'=>'control-label')) ?>
				   <div class="controls">
						<?php   
							$modPenerimaanBarang->tglterima = (!empty($modPenerimaanBarang->tglterima) ? date("d/m/Y H:i:s",strtotime($modPenerimaanBarang->tglterima)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modPenerimaanBarang,
								'attribute'=>'tglterima',
								'mode'=>'datetime',
								'options'=> array(
	//                                            'dateFormat'=>Params::DATE_FORMAT,
//									'showOn' => false,
									'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('readonly'=>true,'placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
						)); ?>
				   </div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('No. Kuitansi','nosuratjalan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modPenerimaanBarang,'nosuratjalan', array('placeholder'=>'Ketik No. Kuitansi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>	
			</div>
		</div>
   </div>
	<div class = "col-sm-6">
		<div class="control-group ">
				<?php echo CHtml::label('Tanggal Kuitansi','tglsuratjalan', array('class'=>'control-label')) ?>
				  <div class="controls">
					   <?php   
						   $modPenerimaanBarang->tglsuratjalan = (!empty($modPenerimaanBarang->tglsuratjalan) ? date("d/m/Y H:i:s",strtotime($modPenerimaanBarang->tglsuratjalan)) : null);
						   $this->widget('MyDateTimePicker',array(
							   'model'=>$modPenerimaanBarang,
							   'attribute'=>'tglsuratjalan',
							   'mode'=>'datetime',
							   'options'=> array(
   //                                            'dateFormat'=>Params::DATE_FORMAT,
//								   'showOn' => false,
								   'maxDate' => 'd',
								   'yearRange'=> "-150:+0",
							   ),
							   'htmlOptions'=>array('readonly'=>true,'placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
							   ),
					   )); ?>
				  </div>
	   </div>
		<div class="control-group">
			<?php echo $form->dropDownListRow($modPenerimaanBarang,'supplier_id',
			 CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
			 array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
			 'empty'=>'-- Pilih --')); ?>
		</div>
	</div>
</div>
<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new FAPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['FAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['FAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchDialog(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new FAPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['FAPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['FAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
	'filter'=>$modPegawaiMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>