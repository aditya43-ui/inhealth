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
	<div class="control-group">
		<?php echo $form->labelEx($modPermintaanPenawaran, 'ispenawaranmasuk', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($modPermintaanPenawaran,'ispenawaranmasuk', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<?php echo $form->textAreaRow($modPermintaanPenawaran,'keteranganpenawaran',array('placeholder'=>'Ket. Permintaan Penawaran','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)"));?>
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

$modPegawaiMengetahui = new ADPegawaiM('search');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['ADPegawaiM'])) {
    $modPegawaiMengetahui->attributes = $_GET['ADPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchMengetahui(),
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
                    'filter'=>Chtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                    'filter'=>Chtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only'))
                ),
                array(
                    'header'=>'Jabatan',
                    'name' => 'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                    'value'=>'!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '         $(".numbers-only").keyup(function(){setNumbersOnly(this);});$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
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

$modPegawaiMenyetujui = new ADPegawaiM('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['ADPegawaiM'])) {
    $modPegawaiMenyetujui->attributes = $_GET['ADPegawaiM'];
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
                    'filter'=>Chtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                    'filter'=>Chtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai', array('class' => 'hurufs-only'))
                ),
                 array(
                    'header'=>'Jabatan',
                    'name' => 'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMenyetujui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                    'value'=>'!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '         $(".numbers-only").keyup(function(){setNumbersOnly(this);});$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>