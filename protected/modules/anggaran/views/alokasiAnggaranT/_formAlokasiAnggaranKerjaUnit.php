<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'Sumber Anggaran', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'sumberanggaran_id',array('readonly'=>true)); ?>
				<?php echo $form->hiddenField($model, 'realisasianggpenerimaan_id',array('readonly'=>true)); ?>
				<?php echo CHtml::hiddenField('termin_ke','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('nilaipenerimaan','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('sisaanggaran','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'sumberanggarannama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteSumberAnggaran') . '",
										   dataType: "json",
										   data: {
											   sumberanggaran_nama: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'sumberanggaran_id') . '").val(ui.item.sumberanggaran_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'sumberanggarannama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'sumberanggaran_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogSumberAnggaran'),
				));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo $form->labelEx($model, 'Program Kerja', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'subkegiatanprogram_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'subkegiatanprogram_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteProgramKerja') . '",
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
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'subkegiatanprogram_id') . '").val(ui.item.subkegiatanprogram_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'programkerja',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'subkegiatanprogram_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogProgramKerja'),
				));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo $form->labelEx($model, 'Nilai Alokasi', array('class' =>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nilaiygdialokasikan',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('apprrencanggaran_id','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('programkerja_id','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('subprogramkerja_id','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('kegiatanprogram_id','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('subkegiatanprogram_id','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::hiddenField('nilaipengeluaran','',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>				
			</div>
			<div style="margin-left:265px; margin-top: -5px;">
				<?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),
						array('onclick'=>'tambahAlokasi();return false;',
							  'onkeypress'=>'tambahAlokasi();return false;',
							  'class' => 'btn btn-danger',
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk tambah",)); ?>
			</div> 
		</div>
	</div>
	
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'sisaanggaran', array('class' =>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'sisaanggaran',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'Nilai Pengeluaran', array('class' =>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nilaipengeluaran',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<span id="digit"></span>
			</div>
		</div>
	</div>
</div>

<?php 
//========= Dialog buat cari data Sumber Anggaran =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSumberAnggaran',
    'options'=>array(
        'title'=>'Pencarian Sumber Anggaran',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modSumberAnggaran = new AGRealisasianggpenerimaanT('search');
$modSumberAnggaran->unsetAttributes();
if(isset($_GET['AGRealisasianggpenerimaanT'])) {
    $modSumberAnggaran->attributes = $_GET['AGRealisasianggpenerimaanT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sumberanggaran-grid',
	'dataProvider'=>$modSumberAnggaran->search(),
	'filter'=>$modSumberAnggaran,
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
										  $(\"#'.CHtml::activeId($model,'sumberanggaran_id').'\").val(\"$data->SumberanggaranId\");
										  $(\"#'.CHtml::activeId($model,'sumberanggarannama').'\").val(\"$data->SumberanggaranNama\");
										  $(\"#'.CHtml::activeId($model,'realisasianggpenerimaan_id').'\").val(\"$data->realisasianggpenerimaan_id\");
										  $(\"#termin_ke\").val(\"$data->penerimaanke\");
										  $(\"#nilaipenerimaan\").val(\"$data->realisasipenerimaan\");
										  $(\"#sisaanggaran\").val(\"$data->SisaAnggaran\");
										  $(\"#dialogSumberAnggaran\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'Sumber Anggaran',
			'filter'=>  CHtml::activeTextField($modSumberAnggaran, 'sumberanggarannama'),
			'value'=>'$data->renanggpenerimaan->sumberanggaran->sumberanggarannama',
		),
		array(
			'header'=>'Termin Ke-',
			'value'=>'$data->penerimaanke',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
		),
		array(
			'header'=>'Nilai Penerimaan',
			'value'=>'MyFormatter::formatNumberForPrint($data->realisasipenerimaan)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
		),
		array(
			'header'=>'Sisa Anggaran',
			'value'=>'MyFormatter::formatNumberForPrint($data->SisaAnggaran)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
		),
	),
		'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
$this->endWidget();
//========= end Sumber Anggaran dialog =============================
?>

<?php 
//========= Dialog buat cari data Program Kerja =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogProgramKerja',
    'options'=>array(
        'title'=>'Data Program Kerja',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modProgramKerja = new AGInformasialokasianggaranV('searchProgramKerja');
$modProgramKerja->unsetAttributes();
if(isset($_GET['AGInformasialokasianggaranV'])) {
    $modProgramKerja->attributes = $_GET['AGInformasialokasianggaranV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'programkerja-grid',
	'dataProvider'=>$modProgramKerja->searchProgramKerjaAlokasi(),
	'filter'=>$modProgramKerja,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'No. ',
					'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:center; width:5px;'),
                ),
                array(
                    'header'=>'Program Kerja',
					'type'=>'raw',
					'value'=>'$this->grid->owner->renderPartial("_detail",array(
					"programkerja_kode"=>$data->programkerja_kode,
					"programkerja_nama"=>$data->programkerja_nama,
					"subprogramkerja_kode"=>$data->subprogramkerja_kode,
					"subprogramkerja_nama"=>$data->subprogramkerja_nama,
					"kegiatanprogram_kode"=>$data->kegiatanprogram_kode,
					"kegiatanprogram_nama"=>$data->kegiatanprogram_nama,
					"subkegiatanprogram_kode"=>$data->subkegiatanprogram_kode,
					"subkegiatanprogram_nama"=>$data->subkegiatanprogram_nama),true)',
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
				array(
					'header'=>'Bulan',
					'value'=>'MyFormatter::formatMonthForUser($data->tglapprrencanggaran)',
				),
				array(
					'header'=>'Nilai Pengeluaran',
					'value'=>'MyFormatter::formatNumberForPrint($data->nilaiygdisetujui)',
					'htmlOptions'=>array('style'=>'text-align:right;')
				),
                 array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectProgramKerja",
                                    "onClick" => "
                                                  $(\"#apprrencanggaran_id\").val(\"$data->apprrencanggaran_id\");
                                                  $(\"#programkerja_id\").val(\"$data->programkerja_id\");
                                                  $(\"#subprogramkerja_id\").val(\"$data->subprogramkerja_id\");
                                                  $(\"#kegiatanprogram_id\").val(\"$data->kegiatanprogram_id\");
                                                  $(\"#subkegiatanprogram_id\").val(\"$data->subkegiatanprogram_id\");
                                                  $(\"#nilaipengeluaran\").val(\"$data->nilaiygdisetujui\");
                                                  $(\"#'.CHtml::activeId($model,'subkegiatanprogram_id').'\").val(\"$data->subkegiatanprogram_id\");
                                                  $(\"#'.CHtml::activeId($model,'subkegiatanprogram_nama').'\").val(\"$data->subkegiatanprogram_nama\");
                                                  $(\"#'.CHtml::activeId($model,'nilaipengeluaran').'\").val(\"$data->nilaiygdisetujui	\");
												  formatNumberSemua();
                                                  $(\"#dialogProgramKerja\").dialog(\"close\"); 
                                                  return false;
                                        "))',
					'htmlOptions'=>array('style'=>'text-align:center; width:10px;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Program Kerja dialog =============================
?>