<style>
	.table_pengisi, tr, td{
		vertical-align:top;
		padding: 10px;
	}

	.isian{
		margin-left : 10px;
	}

</style>
<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'tindakanrestraint-t-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>





	
<div class="row-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Pengkajian Fisik dan Mental</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'kesadaran' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'kesadaran',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'gcs_eye' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'gcs_eye',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'gcs_verbal' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'gcs_verbal',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'gcs_motorik' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'gcs_motorik',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'tekanandarah' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'tekanandarah',array('size'=>60,'maxlength'=>200)); ?> mmHg
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'pernapasan' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'pernapasan',array('size'=>60,'maxlength'=>200, 'class'=>'numbers-only')); ?> x/menit
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'suhu' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'suhu',array('size'=>60,'maxlength'=>200, 'class'=>'float')); ?> &#176;C
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'nadi' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'nadi',array('size'=>60,'maxlength'=>200, 'class'=>'float')); ?> x/menit
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'skala_nyeri' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'skala_nyeri',array('size'=>60,'maxlength'=>200, 'class'=>'numbers-only')); ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>


	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Hasil Observasi</div>
		</div>
		<div class="panel-body">
			<div class='control-group'>
				<?php $data = array("Pasien gelisah atau delirium dan berontak",
									"Pasien tidak koperatif",
									"Ketidak mampuan dalam mengikuti perintah atau tidak meninggalkan tempat tidur",
									"Pasien koperatif"
				);
			
				if (!empty($model->hasilobservasi)){
					$model->hasilobservasi = json_decode($model->hasilobservasi);	
				}?>
				<div class='controls'>
					<?php $index = 0;
						foreach ($data as $val => $label): ?>
					<div>
						<?php echo $form->checkBox($model, 'hasilobservasi['.$index.']', array('value'=>$label, 'class'=>'pilihanresus')); ?>
						<label ><?= $label ?></label>
					</div>
					<?php $index++; endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Penilaian dan Order Dokter</div>
		</div>
		<div class="panel-body">
			<div class='control-group'>
				<label>A. Restrain Non Farmakologi</label>
			</div>
			<div class='control-group'>
				<?php $data = array("Restrain tempat tidur atau bed rail",
									"Restrain pergelangan tangan",
									"Tangan kiri",
									"Tangan Kanan",
									"Restrain Pergelangan Kaki",
									"Kaki kiri",
									"Kaki kanan",
									"Lain - lain"
				);
			
				if (!empty($model->restrain_nonfarmotologi)){
					$model->restrain_nonfarmotologi = json_decode($model->restrain_nonfarmotologi);	
				}?>
				<div class='controls'>
					<?php $index = 0;
						foreach ($data as $val => $label): ?>
					<div>
						<?php if ($label == 'Lain - lain'){?>
							<?php echo $form->checkBox($model, 'restrain_nonfarmotologi['.$index.']', array('value'=>$label, 'class'=>'lain', 'onClick'=>'cekKeterangan();')); ?>
							<label ><?= $label ?></label>
							<?php echo $form->textField($model,'keterangan_lainnya',array('size'=>60,'maxlength'=>200)); ?>
						<?php } else {?>
							<?php echo $form->checkBox($model, 'restrain_nonfarmotologi['.$index.']', array('value'=>$label, 'class'=>'pilihanresus')); ?>
							<label ><?= $label ?></label>
						<?php }?>
					</div>
					<?php $index++; endforeach; ?>
				</div>
			</div>
			<div class='control-group'>
				<label>B. Restrain Farmakologi</label>
				<?php echo $form->textField($model,'restrain_farmatologi',array('size'=>60,'maxlength'=>200)); ?>
			</div>
			
		</div>
	</div>

	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Restrain Dilanjutkan</div>
		</div>
		<div class="panel-body">
			<div style="margin-left:30px">
			<div class="control-group">
				<?php echo $form->checkbox($model,'restraindilanjutkan'); ?>&nbsp;<label>Ya ( lanjutkan ke pengkajian lanjutan di catatan
					perkembangan terintegrasi dan di observasi di form observasi khusus )
				</label>
			</div>
			<div class="control-group">
				<?php echo $form->checkbox($model,'restraintidak_dilanjutkan'); ?>&nbsp;<label>Tidak ( Penghentian Restrain )
				</label>
			</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($model,'pemberi_informasi', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php 
							$this->widget('MyJuiAutoComplete', array(
								'attribute'=>'pemberi_informasi',
								'model' => $model,
								'source'=>'js: function(request, response) {
									$.ajax({
										url: "'.$this->createUrl('getPegawai').'",
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
										$(this).val( ui.item.label);
										return false;
									}',
									'select'=>'js:function( event, ui ) {
										$("#'.CHtml::activeId($model, 'pemberi_informasi').'").val(ui.item.label); 
										return false;
									}',
							),
								'htmlOptions'=>array(
									'onkeyup'=>"return $(this).focusNextInputField(event)",
									'class'=>'span3',
									'onblur' => 'if(this.value === "") $("#petugas_kerohanian").val(""); '
								),
								'tombolDialog'=>array('idDialog'=>'diaglogPetugas'),
							)); 
						?>
				</div>
			</div>

			<div class="control-group">
				<?php echo $form->labelEx($model,'penerima_informasi' , array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($model,'penerima_informasi',array('size'=>60,'maxlength'=>200)); ?>
				</div>
			</div>


		</div>
	</div>
</div>



	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->pelepasanrestrain_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPelepasanTindakanRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->pelepasanrestrain_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPelepasanTindakanRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
			}?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->




<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogPetugas',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#'.CHtml::activeId($model, 'pemberi_informasi').'\").val(\"$data->NamaLengkap\");
									$(\'#diaglogPetugas\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<script>

function formatdecimal(){
	$('.suhu').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
}
    
    
</script>