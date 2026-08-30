<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'pasiekabur-t-form',
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
				<label>Saya yang bertanda tangan dibawah ini :</label>
			</div>
		</div>
		<!-- <div class="control-group">
			<?php //echo $form->labelEx($model,'nama_lengkap' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php //echo $form->textField($model,'nama_lengkap',array('size'=>60,'maxlength'=>200, 'class'=>'required')); ?>
			</div>
		</div> -->
		<div class="control-group">
			<?php echo $form->labelEx($model,'nama_lengkap', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php 
						$this->widget('MyJuiAutoComplete', array(
							'attribute'=>'nama_lengkap',
							'id'=>'nama_lengkap',
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
									   $("#nama_lengkap").val(ui.item.label); 
									   return false;
								   }',
						   ),
							'htmlOptions'=>array(
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'class'=>'span3',
								'onblur' => 'if(this.value === "") $("#nama_lengkap").val(""); '
							),
							'tombolDialog'=>array('idDialog'=>'diaglogNamaLengkap'),
						)); 
					?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'jabatan' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'jabatan',array('size'=>60,'maxlength'=>200,'readonly'=>true)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'nip' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nip',array('size'=>60,'maxlength'=>200,'readonly'=>true)); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<label>Dengan ini menyatakan bahwa pada hari ini. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tanggal dan jam <span color="red">*</span></label>
			</div>
			<div class="col-sm-8">
					<div class="control-group">
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tanggal_pengisian',
								'mode' => 'datetime',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									//'maxDate' => 'd',
								),
								'htmlOptions' => array(
									'readonly' => true,
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'class'=>'span3 required',
								),
							));
							?>
						</div>
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label>WITA terdapat Pasien Kabur dari Ruangan Saya dengan identitas :</label>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'nama_pasien' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'nama_pasien',array('size'=>60,'maxlength'=>200, 'class'=>'required','readonly'=>true)); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'no_rekam_medik' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'no_rekam_medik',array('size'=>60,'maxlength'=>200, 'class'=>'required','readonly'=>true)); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($modPendaftaran,'ruangan_nama' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPendaftaran,'ruangan_nama',array('size'=>60,'maxlength'=>200, 'class'=>'required')); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'ciri_khusus' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textArea($model,'ciri_khusus',array()); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'penyebab_kabur' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textArea($model,'penyebab_kabur',array()); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'kepala_tanggungjawab', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeDropDownList($model,'kepala_tanggungjawab', array('Kepala Perawatan'=>'Kepala Perawatan','Kepala Ruangan'=>'Kepala Ruangan'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			
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
			<?php echo $form->labelEx($model,'petugasruangan_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->HiddenField($model,'petugasruangan_id'); ?>
				<?php 
						$this->widget('MyJuiAutoComplete', array(
							'attribute'=>'petugas_nama_ruangan',
							'id'=>'petugas_nama_ruangan',
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
									   $("#petugas_nama_ruangan").val(ui.item.label); 
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
	</div>
</div>

		




	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
			<?php
			echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
				$this->createUrl('indexPasienKabur',array('pendaftaran_id'=>$model->pendaftaran_id)),
				array(
					'class' => 'btn btn-danger',
					'onclick' => 'return refreshForm(this);'));
			?>
			<?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PeriksafisikT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
			<?php $this->widget('UserTips', array('content' => '')); ?>
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
if(isset($_GET['RKPegawaiM'])){
    $modPegawai->attributes = $_GET['RKPegawaiM'];
    $modPegawai->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
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
								  $(\"#petugas_nama_ruangan\").val(\"$data->NamaLengkap\");
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
                'filter' => Chtml::activeDropDownList($modPegawai, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif = TRUE ORDER BY kelompokpegawai_nama ASC"), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --'))
            ),               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>



<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogNamaLengkap',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiNamaLengkap = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiNamaLengkap->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiNamaLengkap->attributes = $_GET['RKPegawaiM'];
    $modPegawaiNamaLengkap->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugasnamalengkap-m-grid',
	'dataProvider'=>$modPegawaiNamaLengkap->searchPegawaiTriase(),
	'filter'=>$modPegawaiNamaLengkap,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#nama_lengkap\").val(\"$data->NamaLengkap\");  
								  $(\"#'.CHtml::activeId($model, 'jabatan').'\").val(\"$data->JabatanNama\"); 
								  $(\"#'.CHtml::activeId($model, 'nip').'\").val(\"$data->nomorindukpegawai\"); 
									$(\'#diaglogNamaLengkap\').dialog(\'close\');return false;"))',
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
                'filter' => Chtml::activeDropDownList($modPegawaiNamaLengkap, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
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
                'filter' => Chtml::activeDropDownList($modPegawaiNamaLengkap, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif = TRUE ORDER BY kelompokpegawai_nama ASC"), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --'))
            ),              
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
