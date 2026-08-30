<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pencarian-form',
	'type'=>'horizontal',
)); ?>

	<div class="row">
		<div class="col-sm-4">
				<div class="control-group">
					<?php echo $form->labelEx($modPenilaianPegawai,'tglpenilaian', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php   
								$this->widget('MyDateTimePicker',array(
														'model'=>$modPenilaianPegawai,
														'attribute'=>'tglpenilaian',
														'mode'=>'date',
														'options'=> array(
															'showOn' => false,
															// 'maxDate' => 'd',
															'yearRange'=> "-150:+0",
														),
														'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
														),
								)); ?>
						</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="control-group">
					<?php echo $form->labelEx($modPenilaianPegawai,'sampaidengan', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php   
								$this->widget('MyDateTimePicker',array(
														'model'=>$modPenilaianPegawai,
														'attribute'=>'sampaidengan',
														'mode'=>'date',
														'options'=> array(
															'showOn' => false,
															// 'maxDate' => 'd',
															'yearRange'=> "-150:+0",
														),
														'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
														),
								)); ?>
						</div>
				</div>
			</div>
			<div class="col-sm-4">
					<div class="control-group">
						<?php echo $form->labelEx($modPenilaianPegawai, 'pegawai_id', array('class' => 'control-label','label'=>'Nama Pegawai')); ?>
						<div class="controls">
							<?php echo $form->hiddenField($modPenilaianPegawai, 'pegawai_id',array('value'=>isset($_GET['id']) ? $_GET['id'] : "")) ?>
							<?php
							$this->widget('MyJuiAutoComplete', array(
								'model'=>$modPenilaianPegawai,
								'attribute' => 'pegawai_nama',
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
										$("#'.Chtml::activeId($modPenilaianPegawai, 'pegawai_id') . '").val(ui.item.pegawai_id); 
										return false;
									}',
								),
								'htmlOptions' => array(
									'placeholder'=>'',
									'class'=>'pegawai_nama',
									'onkeyup'=>"return $(this).focusNextInputField(event)",
									'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPenilaianPegawai, 'pegawai_id') . '").val(""); '
								),
								'tombolDialog' => array('idDialog' => 'dialogPegawai'),
							));
							?>
						</div>
					</div>
				</div>
		
	</div>

	<!--div class="form-actions">
		<?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); ?>
	</div>-->
	<div class="form-actions">
		<?php 
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onkeypress'=>'searchPenerimaan();','onclick'=>'searchPenerimaan()')); 
		?>
		<?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			$this->createUrl($this->id.'/index'), 
			array('class' => 'btn btn-default',
				  'onclick'=>'return refreshForm(this);'));  
		?>
	</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
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
										  $(\"#'.CHtml::activeId($modPenilaianPegawai,'pegawai_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modPenilaianPegawai,'pegawai_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawai\").dialog(\"close\"); 
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