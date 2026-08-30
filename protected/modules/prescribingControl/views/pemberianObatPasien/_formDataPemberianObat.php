 <div class="col-sm-6">
	<div class="control-group">
		<?php echo $form->labelEx($modPenjualan,'Tanggal Pemberian Obat', array('class'=>'control-label')) ?>
		<div class="controls">
		<?php   
			$this->widget('MyDateTimePicker',array(
							'model'=>$modPenjualan,
							'attribute'=>'tglresep',
							'mode'=>'datetime',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
								'maxDate' => 'd',
								'yearRange'=> "-60:+0",
							),
							'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3  realtime', 'style'=>'width:128px;','onkeypress'=>"return $(this).focusNextInputField(event)"
							),
		)); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($modPenjualan,'No. Pemberian Obat', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($modPenjualan,'noresep',array('readonly'=>true, 'style'=>'width:170px;')); ?><br>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<div class="control-group">
		<label class="control-label" for="namaObat">Obat Alkes</label>
		<div class="controls">
			<div class="input-append" style='display:inline'>
			<?php 
			   $this->widget('MyJuiAutoComplete', array(
								'name'=>'namaObat',
								'source'=>'js: function(request, response) {
											   $.ajax({
												   url: "'.$this->createUrl('ObatReseptur').'",
												   dataType: "json",
												   data: {
													   term: request.term,
													   namaObat: $("#namaObat").val(),
												   },
												   success: function (data) {
														   response(data);
												   }
											   })
											}',
								 'options'=>array(
									   'showAnim'=>'fold',
									   'minLength' => 1,
//                                                   'focus'=> 'js:function( event, ui ) {
//                                                        $(this).val( ui.item.label);
//                                                        return false;
//                                                    }',
									   'select'=>'js:function( event, ui ) {
											$("#idObat").val(ui.item.obatalkes_id); 
											return false;
										}',	
								),
								'tombolDialog'=>array('idDialog'=>'dialogObat'),
								'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
							)); 
			?>
		</div>      
	</div>
	</div>
	<?php echo CHtml::hiddenField('obatalkes_id', '', array('readonly'=>true)) ?>
	<div class="control-group">
		<label class="control-label" for="qty">Jumlah Obat</label>
		<div class="controls">
			<?php echo CHtml::textField('qtyObat', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer')) ?>
			<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
					array('onclick'=>'tambahObatAlkes();return false;',
						  'class' => 'btn btn-danger',
						  'onkeyup'=>"tambahObatAlkes();",
						  'rel'=>"tooltip",
						  'title'=>"Klik untuk menambahkan resep",)); ?>
		</div>
	</div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogObat',
    'options'=>array(
        'title'=>'Pencarian Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modObatDialog = new PCObatAlkesM('searchObatFarmasiRuangan');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['PCObatAlkesM']))
    $modObatDialog->attributes = $_GET['PCObatAlkesM'];
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
    'dataProvider'=>$modObatDialog->searchObatFarmasiRuangan(),
    'filter'=>$modObatDialog,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#namaObat\").val(\"$data->obatalkes_kode - $data->obatalkes_nama\");
                            $(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'name'=>'tglkadaluarsa',
            'filter'=>'',
        ),
        
        array(
          'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ),
        array(
            'header'=>'Generik',
            'name'=>'generik_nama',
            'value'=>'(isset($data->generik->generik_nama) ? $data->generik->generik_nama : "")',
            'filter'=>CHtml::activeTextField($modObatDialog, 'generik_nama').CHtml::activeHiddenField($modObatDialog, 'generik_id'),
        ),
        array(
            'header'=>'HJA Resep',
            'type'=>'raw',
            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
            'filter'=>'',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
            'header'=>'HJA Non Resep',
            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
            'filter'=>'',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>