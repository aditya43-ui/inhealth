
	<?php echo $form->errorSummary($modKesimpulan); ?>
	<div style="text-align: right;">
		<span style='text-align: right; font-weight: bold'>Total</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $form->textField($modKesimpulan,'totalpenilaian',array('class'=>'numbers-only','style'=>'width:130px','onkeypress'=>'$(this).focusNextInputField(event)','readonly'=>true)) ?>
		<br><br>
		<span style='text-align: right; font-weight: bold'>Rata-rata Penilaian</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $form->textField($modKesimpulan,'ratapenilaian',array('class'=>'numbers-only','style'=>'width:130px','onkeypress'=>'$(this).focusNextInputField(event)','readonly'=>true)) ?>
	</div>
	<br><br>	
	<div class="row">
		<div class="col-sm-4">
			<div class="control-group">
					<?php echo $form->labelEx($modKesimpulan,'tglkesimpulan', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php   
						  $modKesimpulan->tglkesimpulan = (!empty($modKesimpulan->tglkesimpulan) ? date("d/m/Y H:i:s",strtotime($modKesimpulan->tglkesimpulan)) : null);
							$this->widget('MyDateTimePicker',array(
                            'model'=>$modKesimpulan,
                            'attribute'=>'tglkesimpulan',
                            'mode'=>'datetime',
                            'options'=> array(
                                'showOn' => false,
//                                'maxDate' => 'd',
                                'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                    )); ?>
						</div>
				</div>
		
						<?php echo $form->labelEx($modKesimpulan, 'pegawai_pemberisaran', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->hiddenField($modKesimpulan, 'pegawai_pemberisaran'); ?>
							<?php
							$this->widget('MyJuiAutoComplete', array(
								'model'=>$modKesimpulan,
								'attribute' => 'pegawai_pemberisaran_nama',
								'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
										$("#'.Chtml::activeId($modKesimpulan, 'pegawai_pemberisaran') . '").val(ui.item.pegawai_pemberisaran); 
										return false;
									}',
								),
								'htmlOptions' => array(
									'placeholder'=>'',
									'class'=>'pegawai_pemberisaran_nama',
									'onkeyup'=>"return $(this).focusNextInputField(event)",
									'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modKesimpulan, 'pegawai_pemberisaran') . '").val(""); '
								),
								'tombolDialog' => array('idDialog' => 'dialogPegawaiPemberiSaran'),
							));
							?>
						</div>		
		</div>
		<div class="col-sm-4">
			<?php echo $form->textAreaRow($modKesimpulan,'kesimpulan',array('rows'=>3, 'cols'=>50, 'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class="col-sm-4">	
			<?php echo $form->textAreaRow($modKesimpulan,'saran',array('rows'=>3, 'cols'=>50, 'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiPemberiSaran',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM;
if (isset($_GET['PegawaiM']))
    $modPegawai->attributes = $_GET['PegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->search(),
	'filter'=>$modPegawai,
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
										  $(\"#'.CHtml::activeId($modKesimpulan,'pegawai_pemberisaran').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modKesimpulan,'pegawai_pemberisaran_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiPemberiSaran\").dialog(\"close\"); 
										  return false;
								"))',
		),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'jeniskelamin',
        'statusperkawinan',
        array(
            'header'=>'Jabatan',
            'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>