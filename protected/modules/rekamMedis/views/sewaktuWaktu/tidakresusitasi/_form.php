<style>
	.table_pengisi, tr, td{
		vertical-align:top;
		padding: 10px;
	}

</style>
<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'tidakresusitasi-t-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

	
<div class="row-fluid">
	<div class="col-sm-12">
		<div class="control-group" hidden>
			<?php echo $form->labelEx($model,'pendaftaran_id', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model,'pendaftaran_id'); ?>
			<?php echo $form->error($model,'pendaftaran_id'); ?>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<label>Yang bertanda tangan dibawah ini :</label>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'nama_lengkap' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nama_lengkap',array('size'=>60,'maxlength'=>200, 'class'=>'required')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'tanggal_lahir' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tanggal_lahir',
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
			<?php echo $form->labelEx($model,'alamat' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'alamat',array('size'=>60,'maxlength'=>200)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'hubunganpasien' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'hubunganpasien',array('size'=>60,'maxlength'=>200)); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<label>Dengan ini menyatakan bahwa saya membuat keputusan dan menyetujui untuk tidak dilakukan:</label>
			</div>
		</div>

		<div class="col-sm-12">

			<div class='control-group'>
				
				<?php $data = LookupM::getItemsUrutan('keputusanresusitasi');
				
				if (!empty($model->bentuk_layanan)){
					$model->bentuk_layanan = json_decode($model->bentuk_layanan);	
				}?>
				<div class='controls'>
					<?php $index = 0;
						foreach ($data as $val => $label): 
						
						
						?>
					<div>
						<?php echo $form->checkBox($model, 'isikeputusan['.$index.']', array('value'=>$label)); ?>
						<label ><?= $label ?></label>
					</div>
					<?php $index++; endforeach; ?>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<label>Terhadap Pasien :</label>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'nama_pasien' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'nama_pasien',array('size'=>60,'maxlength'=>200, 'readonly'=>true)); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'tanggal_lahir' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $modPasien,
					'attribute' => 'tanggal_lahir',
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
			<?php echo $form->labelEx($modPasien,'no_rekam_medik' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'no_rekam_medik',array('size'=>60,'maxlength'=>200, 'readonly'=>true)); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'alamat_pasien' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'alamat_pasien',array('size'=>60,'maxlength'=>200, 'readonly'=>true)); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<label>Saya menyatakan bahwa jika jantung saya berhenti mendetak atau jika saya berheti bernafas, tidak ada prosedur
				medis untuk mengembalikan sistem pernapasan atau berfungsi kembali jantung akan dilakukan oleh staf rumah sakit,
				namun tidak terbatas pada staf layanan medis darurat.<br>
				Saya memahami bahwa keputusan ini tidak mencegah saya menerima pelayanan kesehatan lainnya seperti pemberian
				manuver heimlich atau pemberian oksigen, dan kebutuhan dasar medis manusia lainnya.<br>
				Saya memberikan izin agar informasi ini diberikan kepada seluruh staf rumah sakit, saya memahami bahwa saya
				dapat mencabut keputusan ini setiap saat</label>
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
							<div class="panel-title">Data Pengisi</div>
						</div>
						<div class="panel-body">
							<div class="control-group">
								<?php echo $form->labelEx($model,'pasienmenyatakan', array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::activeDropDownList($model,'pasienmenyatakan', array('Pasien'=>'Pasien','Keluarga'=>'Keluarga'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'onchange'=>'cekMenyatakan();')); ?>
								
								</div>
							</div>

							<div class="control-group">
								<?php echo $form->labelEx($model,'nama_menyatakan' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo $form->textField($model,'nama_menyatakan',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>

						</div>
					</div>
				</td>
				<td>
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">Saksi 1</div>
						</div>
						<div class="panel-body">
							<div class="control-group">
								<?php echo $form->labelEx($model,'saksi1' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo $form->textField($model,'saksi1',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>

						</div>
					</div>

					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">Saksi 2</div>
						</div>
						<div class="panel-body">

							<div class="control-group">
								<?php echo $form->labelEx($model,'saksi2', array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo $form->HiddenField($model,'saksi2'); ?>
									<?php 
											$this->widget('MyJuiAutoComplete', array(
												'attribute'=>'nama_saksi2',
												'id'=>'nama_saksi2',
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
														   $("#'.CHtml::activeId($model, 'saksi2').'").val(ui.item.pegawai_id);
														   $("#nama_saksi2").val(ui.item.label); 
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
			</tr>
		
		</table>
</div>




	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->tidakdilakukanresusitasi_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexTidakResusitasi',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->tidakdilakukanresusitasi_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexTidakResusitasi',array('pendaftaran_id'=>$model->pendaftaran_id)),
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
					"onClick" => "$(\"#'.CHtml::activeId($model, 'saksi2').'\").val(\"$data->pegawai_id\");  
								  $(\"#nama_saksi2\").val(\"$data->NamaLengkap\");
									$(\'#diaglogPetugas\').dialog(\'close\');return false;"))',
			),
			// 'gelardepan',
   //          array(
   //              'name'=>'nama_pegawai',
   //              'header'=>'Nama Dokter',
   //          ),
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Pegawai',
                'value'=>'isset($data->NamaLengkap) ? $data->NamaLengkap : ""',
            ),
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'type'=>'raw',
                'value' => function($data){
                    $j = JabatanM::model()->findByPk($data->jabatan_id);
                    
                    if(!empty($j)){
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
            'jeniskelamin',             
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


