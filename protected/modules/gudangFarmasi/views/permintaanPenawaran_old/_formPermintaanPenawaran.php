<div class="col-sm-6">
	<?php echo CHtml::hiddenField('permintaanpenawaran_id',$modPermintaanPenawaran->permintaanpenawaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
	<?php if(isset($_GET['sukses'])){ ?>
			<?php echo $form->textFieldRow($modPermintaanPenawaran,'nosuratpenawaran',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
	<?php } ?>
	<?php echo $form->dropDownListRow($modPermintaanPenawaran,'supplier_id',
												 CHtml::listData(SupplierM::getSupplierFarmasiItems(), 'supplier_id','supplier_nama'),
												 array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", /*'onChange'=>'setValue();',*/ 'class'=>'supplier_id', 
												 'empty'=>'-- Pilih --',)); ?>
	<?php 
	if(isset($_GET['ubah'])){
		$modPermintaanPenawaran->tglpenawaran = MyFormatter::formatDateTimeId($modPermintaanPenawaran->tglpenawaran);
		echo $form->textFieldRow($modPermintaanPenawaran,'tglpenawaran',array('class'=>'span3', 'readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)"));
	}else{ ?>
		<div class="control-group">
			<?php echo $form->labelEx($modPermintaanPenawaran,'tglpenawaran', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $format = new MyFormatter();  
						$modPermintaanPenawaran->tglpenawaran = (!empty($modPermintaanPenawaran->tglpenawaran) ? $format->formatDateTimeForUser($modPermintaanPenawaran->tglpenawaran) : null);
						$this->widget('MyDateTimePicker',array(
							'model'=>$modPermintaanPenawaran,
							'attribute'=>'tglpenawaran',
							'mode'=>'datetime',
							'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
								'showOn' => false,
								'maxDate' => 'd',
								'yearRange'=> "-150:+0",
							),
							'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
							),
					)); ?>
			</div>
		</div>
	<?php } ?>
	<?php // echo $form->textFieldRow($modPermintaanPenawaran,'harganettopenawaran',array('class'=>'span3', 'readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)"));?>
</div>
<div class="col-sm-6">
	<?php echo $form->textAreaRow($modPermintaanPenawaran,'keteranganpenawaran',array('placeholder'=>'Ket. Permintaan Penawaran','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)"));?>
	<div class="control-group">
		<?php echo $form->labelEx($modPermintaanPenawaran, 'ispenawaranmasuk', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($modPermintaanPenawaran,'ispenawaranmasuk', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
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

$modPegawaiMengetahui = new GFPegawaiM('search');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['GFPegawaiM'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->search(),
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
                                                  $(\"#'.CHtml::activeId($modPermintaanPenawaran,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPenawaran,'pegawaimengetahui_nama').'\").val(\"$data->nama_pegawai\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
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

$modPegawaiMenyetujui = new GFPegawaiM('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['GFPegawaiM'])) {
    $modPegawaiMenyetujui->attributes = $_GET['GFPegawaiM'];
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
                                                  $(\"#'.CHtml::activeId($modPermintaanPenawaran,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPenawaran,'pegawaimenyetujui_nama').'\").val(\"$data->nama_pegawai\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
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