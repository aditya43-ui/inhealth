<style>
	.table_pengisi, tr, td{
		vertical-align:top;
		padding: 10px;
	}

</style>
<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'penundaankelambatan-t-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model,'tanggal_pengisian' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tanggal_pengisian',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						//'maxDate' => 'd',
					),
					'htmlOptions' => array(
						'readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'class'=>'span3',
					),
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'pukul' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'pukul',
					'mode' => 'time',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						//'maxDate' => 'd',
					),
					'htmlOptions' => array(
						'readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'class'=>'span3',
					),
				));
				?>
			</div>
		</div>

	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model,'unit', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeDropDownList($model,'unit', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true)), 'instalasi_nama', 'instalasi_nama'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'onchange'=>'cekMenyatakan();')); ?>
			
			</div>
		</div>

	</div>
</div>
<div class="row-fluid">


	<div class="col-sm-12">
		<div class="control-group" hidden>
			<?php echo $form->labelEx($model,'pendaftaran_id', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model,'pendaftaran_id'); ?>
			<?php echo $form->error($model,'pendaftaran_id'); ?>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<label>1. Pelayanan/tindakan yang mengalami penundaan atau keterlambatan</label>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'pelayanantindakan','toolbar'=>'mini','height'=>'200px'));?>
			</div>
		</div>


		<br>
		<div class="row">
			<div class="col-sm-12">
				<label>2. Alasan/Penyebab Penundaan atau Keterlambatan pelayanan/tindakan</label>
			</div>
		</div>


		<div class="row">
			<div class="col-sm-12">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'alasanpenundaan','toolbar'=>'mini','height'=>'200px'));?>
			</div>
		</div>

		<br>
		<div class="row">
			<div class="col-sm-12">
				<label>3. Solusi Alternatif Lain beserta waktu Pelayanan/tindakan dapat dilaksanakan kembali</label>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
			<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'solusialternatif','toolbar'=>'mini','height'=>'200px'));?>
			</div>
		</div>

		
		
	</div>	
</div>
<div class="row-fluid">
		<table width="100%" class="table_pengisi">
			<tr>
				<td width="50%">
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">Pemberi Informasi</div>
						</div>
						<div class="panel-body">
							<div class="control-group">
								<?php echo $form->labelEx($model,'pemberi_informasi', array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::activeDropDownList($model,'pemberi_informasi', array('DPJP'=>'DPJP','PPA'=>'PPA'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'onchange'=>'')); ?>
								
								</div>
							</div>

							<div class="control-group">
								<?php echo $form->labelEx($model,'petugas_id', array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo $form->HiddenField($model,'petugas_id'); ?>
									<?php 
											$this->widget('MyJuiAutoComplete', array(
												'attribute'=>'petugas_nama',
												'id'=>'petugas_nama',
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
														$("#'.CHtml::activeId($model, 'petugas_id').'").val(ui.item.pegawai_id);
														$("#petugas_nama").val(ui.item.label); 
														return false;
													}',
											),
												'htmlOptions'=>array(
													'onkeyup'=>"return $(this).focusNextInputField(event)",
													'class'=>'span3',
													'onblur' => 'if(this.value === "") $("#petugas_id").val(""); '
												),
												'tombolDialog'=>array('idDialog'=>'diaglogPetugas'),
											)); 
										?>
								</div>
							</div>

						</div>
					</div>
				</td>
				<td>
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">Penerima Informasi</div>
						</div>
						<div class="panel-body">
							<div class="control-group">
								<?php echo $form->labelEx($model,'penerima_informasi', array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::activeDropDownList($model,'penerima_informasi', array('Pasien'=>'Pasien','Keluarga'=>'Keluarga'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'onchange'=>'cekMenyatakan();')); ?>
								
								</div>
							</div>

							<div class="control-group">
								<?php echo $form->labelEx($model,'nama_penerima' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo $form->textField($model,'nama_penerima',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>

						</div>
					</div>

					
				</td>
			</tr>
		
		</table>
</div>




	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->penundaandankelambatan_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPenundaanKelambatan',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->penundaandankelambatan_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPenundaanKelambatan',array('pendaftaran_id'=>$model->pendaftaran_id)),
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
//========= Dialog buat cari data Pegawai Triase =========================
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
								  $(\"#petugas_nama\").val(\"$data->NamaLengkap\");
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
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'type'=>'raw',
                'value' => function($data){
                    $j = JabatanM::model()->findByPk($data->jabatan_id);
                    
                    if(!empty($j)) {
                        return $j->jabatan_nama;
                    }else{
                        return '-';
                    }
                },
                'filter' => Chtml::activeDropDownList($modPegawaiTriase, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
            ),
            array(
                'header' => 'Kelompok Pegawai',
                'name' => 'kelompokpegawai_id',
                'type'=>'raw',
                'value' => function($data){
                    $k = KelompokpegawaiM::model()->findByPk($data->kelompokpegawai_id);
                    
                    if(!empty($k)){
                        return $k->kelompokpegawai_nama;
                    }else{
                        return '-';
                    }
                },
                'filter' => Chtml::activeDropDownList($modPegawaiTriase, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif = TRUE ORDER BY kelompokpegawai_nama ASC"), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --'))
            ),              
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


