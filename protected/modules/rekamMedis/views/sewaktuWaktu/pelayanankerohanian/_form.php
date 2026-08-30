<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'pelayanankerohanian-t-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

	
<div class="row-fluid">
    <div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true)), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
		</div>
		

		<div class="control-group">
			<?php echo $form->labelEx($model,'agama' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'agama',array('size'=>60,'maxlength'=>100, 'class'=>'required', 'readonly'=>true)); ?>
			</div>
			<?php echo $form->error($model,'agama'); ?>
		</div>



		<div class="control-group" hidden>
			<?php echo $form->labelEx($model,'pendaftaran_id', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model,'pendaftaran_id'); ?>
			<?php echo $form->error($model,'pendaftaran_id'); ?>
		</div>

	</div>

	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model,'tgl_permintaan', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tgl_permintaan',
					'mode' => 'datetime',
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

	
</div>

<div class="row-fluid">
	<div class="col-sm-12">
		<div class="control-group">
			<label>Bentuk layanan kegiatan kerohanian yang diminta :</label>
		</div>
	</div>
	<div class="col-sm-12">

		<div class='control-group'>
			
			<?php $data = LookupM::getItemsUrutan('layanankerohanian');
			
			if (!empty($model->bentuk_layanan)){
				$model->bentuk_layanan = json_decode($model->bentuk_layanan);	
			}?>
			<div class='controls'>
				<?php $index = 0;
					foreach ($data as $val => $label): 
					
					$det = PelayanankerohanianT::model()->findByAttributes(array(
						'pelayanankerohanian_id'=>$model->pelayanankerohanian_id
					));
					
					if (empty($det)) {
						$det = new PelayanankerohanianT;
						$det->bentuk_layanan = $label;
					}
					
					?>
				<div>
					<?php echo $form->checkBox($model, 'bentuk_layanan['.$index.']', array('value'=>$label)); ?>
					<label ><?= $label ?></label>
				</div>
				<?php $index++; endforeach; ?>
			</div>
		</div>

</div>


<div class="row-fluid">
	<div class="col-sm-12">
		<div class="control-group">
			<?php echo $form->labelEx($model,'petugas_kerohanian', array('class' => 'control-label')); ?>
			<?php echo $form->HiddenField($model,'petugas_kerohanian_id'); ?>
			<div class="controls">
				<?php 
						$this->widget('MyJuiAutoComplete', array(
							'attribute'=>'petugas_kerohanian',
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
									   $("#'.CHtml::activeId($model, 'petugas_kerohanian').'").val(ui.item.label); 
									   return false;
								   }',
						   ),
							'htmlOptions'=>array(
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'class'=>'span3',
								'onblur' => 'if(this.value === "") $("#petugas_kerohanian").val(""); '
							),
							'tombolDialog'=>array('idDialog'=>'diaglogPetugasKerohanian'),
						)); 
					?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'tgl_kedatangan_petugas', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tgl_kedatangan_petugas',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						//'maxDate' => 'd',
					),
					'htmlOptions' => array(
						'readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'class'=>'span3 tgl_persalinan',
					),
				));
				?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'no_hp', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'no_hp', array('class' => 'numbers-only')); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'petugas_bertanggungjawab', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeDropDownList($model,'petugas_bertanggungjawab', array('Dokter'=>'Dokter', 'Perawat'=>'Perawat','Bidan'=>'Bidan'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			
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
			<?php echo $form->labelEx($model,'nama_penerima', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nama_penerima',array('size'=>60,'maxlength'=>200)); ?>
			</div>
		</div>

	</div>
</div>



	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
			<?php
			echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
				$this->createUrl('indexKerohanian',array('pendaftaran_id'=>$model->pendaftaran_id)),
				array('class' => 'btn btn-danger',
					'onclick' => 'return refreshForm(this);'));
			?>
			<?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PeriksafisikT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
			<?php $this->widget('UserTips', array('content' => '')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogPetugasKerohanian',
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
	'id'=>'pegawai-m-grid',
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
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_kerohanian').'\").val(\"$data->NamaLengkap\");  
								  $(\"#PelayanankerohanianT_no_hp\").val(\"$data->nomobile_pegawai\");
									$(\'#diaglogPetugasKerohanian\').dialog(\'close\');return false;"))',
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
    $modPegawaiTriase->jabatan_id = $_GET['RKPegawaiM']['jabatan_id'];
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
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>