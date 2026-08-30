<div class="col-sm-6">
	<?php echo CHtml::hiddenField('permintaanpenawaran_id',$modPermintaanPenawaran->permintaanpenawaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
	<?php if(isset($_GET['sukses'])){ ?>
	<?php echo $form->textFieldRow($modPermintaanPenawaran,'nosuratpenawaran',
                array(
                    'readonly'=>true,
                    'class'=>'span3', 
                    'onkeyup'=>"return $(this).focusNextInputField(event)", 
                    'maxlength'=>50)); ?>
	<?php } ?>
        <div class="control-group ">
            <?php echo CHtml::label('Rencana Kebutuhan', 'rencanakebutuhan', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPermintaanPenawaran,'rencanakebfarmasi_id',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modPermintaanPenawaran,
                    'attribute'=>'rencanakebfarmasi_no',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteRencanaKebutuhanFarmasi').'",
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
                                $("#ADPermintaanPenawaranT_rencanakebfarmasi_id").val(ui.item.rencanakebfarmasi_id);
                                $("#ADPermintaanPenawaranT_rencanakebfarmasi_no").val(ui.item.noperencnaan);
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                        'class' => 'span3 custom-only',
                        'placeholder'=>'Pilih Rencana Kebutuhan',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#ADPermintaanPenawaranT_rencanakebfarmasi_id").val(""); '
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogRencanaKebutuhan'),
                )); 
                ?>
            </div>
        </div>
	<?php echo $form->dropDownListRow($modPermintaanPenawaran,'supplier_id',
		CHtml::listData(SupplierM::getSupplierFarmasiItems(), 'supplier_id','supplier_nama'),
                    array( 
                        'onkeyup'=>"return $(this).focusNextInputField(event)", 
                        /*'onChange'=>'setValue();',*/ 
                        'class'=>'supplier_id span3', 
                        'empty'=>'-- Pilih --',)); ?>
	<?php 
	if(isset($_GET['ubah'])){
		$modPermintaanPenawaran->tglpenawaran = MyFormatter::formatDateTimeId($modPermintaanPenawaran->tglpenawaran);
		echo $form->textFieldRow($modPermintaanPenawaran,'tglpenawaran',array('class'=>'span3', 'readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)"));
	}else{ ?>
	<div class="control-group ">
		<?php echo $form->labelEx($modPermintaanPenawaran,'tglpenawaran', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php $format = new MyFormatter();  
					$modPermintaanPenawaran->tglpenawaran = (!empty($modPermintaanPenawaran->tglpenawaran) ? $format->formatDateTimeForUser($modPermintaanPenawaran->tglpenawaran) : null);
					$this->widget('MyDateTimePicker',array(
						'model'=>$modPermintaanPenawaran,
						'attribute'=>'tglpenawaran',
						'mode'=>'datetime',
						'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
							'showOn' => false,
							'maxDate' => 'd',
							'yearRange'=> "-150:+0",
						),
						'htmlOptions'=>
                                                    array(
                                                        //'placeholder'=>'00/00/0000 00:00:00',
                                                        //'class'=>'span3 dtPicker2 datetimemask',
                                                        'class'=>'span3 dtPicker2',
                                                        'onkeyup'=>"return $(this).focusNextInputField(event)"
						),
				)); ?>
		</div>
	</div>
	<?php } ?>
	<?php // echo $form->textFieldRow($modPermintaanPenawaran,'harganettopenawaran',array('class'=>'span3', 'readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)"));?>
	<div class="control-group ">
		<?php echo $form->labelEx($modPermintaanPenawaran, 'ispenawaranmasuk', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($modPermintaanPenawaran,'ispenawaranmasuk', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<?php echo $form->textAreaRow($modPermintaanPenawaran,'keteranganpenawaran',
                array(
                    'placeholder'=>'Ket. Permintaan Penawaran',
                    'class'=>'span3', 
                    'onkeyup'=>"return $(this).focusNextInputField(event)"));?>
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
                                                  $(\"#ADPermintaanPenawaranT_keteranganpenawaran\").blur();
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
                                                  $(\"#ADPermintaanPenawaranT_keteranganpenawaran\").blur();
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

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRencanaKebutuhan',
    'options'=>array(
        'title'=>'Rencana Kebutuhan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));
$modRencana = new ADRencanaKebFarmasiT('search');
$modRencana->unsetAttributes();
if(isset($_GET['ADRencanaKebFarmasiT'])){
    $modRencana->attributes = $_GET['ADRencanaKebFarmasiT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rencanakebutuhan-m-grid',
	'dataProvider'=>$modRencana->search(),
	'filter'=>$modRencana,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#ADPermintaanPenawaranT_rencanakebfarmasi_id\').val($data->rencanakebfarmasi_id);
                                        $(\'#ADPermintaanPenawaranT_rencanakebfarmasi_no\').val(\'$data->noperencnaan\');
                                        $(\'#dialogRencanaKebutuhan\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
                array(
                    'header'=>'No Rencana Kebutuhan',
                    'name'=>'noperencnaan',
                    'type'=>'raw',
                    'value'=>'$data->noperencnaan',
                    'filter' => CHtml::activeTextField($modRencana,'noperencnaan', array())
                ),
                array(
                    'header'=>'Tanggal Rencana Kebutuhan',
                    'name' => 'tglperencanaan',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglperencanaan)',
                    'filter' => false,
                ), 
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".custom-only").keyup(function(){setCustomOnly(this);});'
    . '}',
)); 

$this->endWidget();
?>