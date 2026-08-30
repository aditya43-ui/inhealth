<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'pendapatlain-t-form',
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
				<label>Dengan ini menyatakan permintaan untuk mendapatkan second opinion atas:</label>
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

		<div class="control-group">
			<?php echo $form->labelEx($model,'dokter_opinion' , array('class' => 'control-label')); ?>
			
			<div style="inline">
				<div class="inputdokter">
					<div class="controls">
						<?php echo $form->textField($model,'inputdokter',array('size'=>60,'maxlength'=>200)); ?>
					</div>
				</div>

				<div class="pilihdokter">
					<div class="controls">
						<?php 
								$this->widget('MyJuiAutoComplete', array(
									'attribute'=>'dokter_opinion',
									'id'=>'dokter_opinion',
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
											$("#'.CHtml::activeId($model, 'petugasruangan_id').'").val(ui.item.pegawai_id);
											$("#dokter_opinion").val(ui.item.label); 
											return false;
										}',
								),
									'htmlOptions'=>array(
										'onkeyup'=>"return $(this).focusNextInputField(event)",
										'class'=>'span3',
										'onblur' => 'if(this.value === "") $("#petugasruangan_id").val(""); '
									),
									'tombolDialog'=>array('idDialog'=>'diaglogPetugasruangan'),
								)); 
							?>
						</div>
					</div>
				&nbsp;
				<?php echo $form->checkbox($model,'is_luar', array('onClick'=>'cekLuar()')); ?> <label>Dari luar</label>
			</div>
		</div>


		<div class="control-group">
			<?php echo $form->labelEx($model,'petugas_tanggungjawab', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeDropDownList($model,'petugas_tanggungjawab', array('Perawat'=>'Perawat','Bidan'=>'Bidan'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			
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


		<div class="control-group">
			<?php echo $form->labelEx($model,'penerima_informasi', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeDropDownList($model,'penerima_informasi', array('Pasien'=>'Pasien','Keluarga'=>'Keluarga'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'cekMenyatakan();')); ?>
			
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'nama_penerima' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nama_penerima',array('size'=>60,'maxlength'=>200)); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<label>Saya memahami perlunya dan manfaat second opinion tersebut sebagaimana telah dijelaskan kepada saya. Saya juga
				menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti dan selalu berkembang, maka perbedaan pendapat ahli adalah biasa
				terjadi dalam dunia kedokteran. <br>Saya menyadari beban biaya second opinion menjadi tanggung jawab saya</label>
			</div>
		</div>


		
	</div>
</div>

		




	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->formpendapatlain_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('indexPendapatLain',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->formpendapatlain_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('indexPendapatLain',array('pendaftaran_id'=>$model->pendaftaran_id)),
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
$modPegawaiTriase->kelompokpegawai_id = array(Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_DOKTER_PART_TIME);
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
                    
                    if(!empty($h)){
                        return $j->jabatan_nama;
                    }else{
                        return '-';
                    }
                },
                'filter' => Chtml::activeDropDownList($modPegawaiTriase, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
            ),                
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>



<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogPetugasruangan',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new RKPegawaiM('searchPegawaiTriase');
$modPegawai->unsetAttributes();
$modPegawai->kelompokpegawai_id = array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,Params::KELOMPOKPEGAWAI_ID_DOKTER_PART_TIME);
if(isset($_GET['RKPegawaiM'])){
    $modPegawai->attributes = $_GET['RKPegawaiM'];
    $modPegawai->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
    $modPegawai->jabatan_id = $_GET['RKPegawaiM']['jabatan_id'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugasruangan-m-grid',
	'dataProvider'=>$modPegawai->searchPegawaiTriase(),
	'filter'=>$modPegawai,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugasruangan_id').'\").val(\"$data->pegawai_id\");  
								  $(\"#dokter_opinion\").val(\"$data->NamaLengkap\");
									$(\'#diaglogPetugasruangan\').dialog(\'close\');return false;"))',
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
                    
                    if(!empty($j)){
                        return $j->jabatan_nama;
                    }else{
                        return '-';
                    }
                },
                'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
            ),              
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
