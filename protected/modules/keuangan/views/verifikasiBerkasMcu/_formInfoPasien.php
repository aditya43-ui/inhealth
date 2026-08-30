<div class="row">
    <div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("No. Pendaftaran ", 'no_pendaftaran', array('class'=>'control-label ')); ?>
			<div class="controls">
				<?php echo CHtml::hiddenField('pendaftaran_id',$modPendaftaran->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				<?php 
					$this->widget('MyJuiAutoComplete', array(
						'name'=>'no_pendaftaran',
						'value'=>$modPendaftaran->no_pendaftaran,
						'source'=>'js: function(request, response) {
									   $.ajax({
										   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
										   dataType: "json",
										   data: {
											   no_pendaftaran: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
						 'options'=>array(
							   'minLength' => 4,
								'focus'=> 'js:function( event, ui ) {
									 $(this).val( "");
									 return false;
								 }',
							   'select'=>'js:function( event, ui ) {
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik);
									return false;
								}',
						),
						'tombolDialog'=>array('idDialog'=>'dialogPasien'),
						'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data kunjungan',
							'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
						),
					)); 
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("No. Rekam Medik ", 'no_rekam_medik', array('class'=>'control-label ')); ?>
			<div class="controls">
				<?php echo CHtml::hiddenField('pasien_id',$modPasien->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				<?php // echo CHtml::textField('no_rekam_medik',$modPasien->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				<?php 
					$this->widget('MyJuiAutoComplete', array(
									'name'=>'no_rekam_medik',
									'value'=>$modPasien->no_rekam_medik,
									'source'=>'js: function(request, response) {
												   $.ajax({
													   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
													   dataType: "json",
													   data: {
														   no_rekam_medik: request.term,
														   instalasi_id: $("#instalasi_id").val(),
													   },
													   success: function (data) {
															   response(data);
													   }
												   })
												}',
									 'options'=>array(
										   'minLength' => 4,
											'focus'=> 'js:function( event, ui ) {
												 $(this).val( "");
												 return false;
											 }',
										   'select'=>'js:function( event, ui ) {
												$(this).val( ui.item.value);
												setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik);
												return false;
											}',
									),
									'htmlOptions'=>array('placeholder'=>'No. Rekam Medik','rel'=>'tooltip','title'=>'No. rekam medik untuk mencari data kunjungan',
										'onkeyup'=>"return $(this).focusNextInputField(event)",
										'class'=>'numbers-only',
										),
								)); 
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('tanggal_lahir',$modPasien->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Nama Pasien ", 'nama_pasien', array('class'=>'control-label ')); ?>
			<div class="controls">
				<?php echo CHtml::hiddenField('namadepan',$modPasien->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
				<?php 
					$this->widget('MyJuiAutoComplete', array(
						'name'=>'nama_pasien',
						'value'=>$modPasien->nama_pasien,
						'source'=>'js: function(request, response) {
									   $.ajax({
										   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
										   dataType: "json",
										   data: {
											   nama_pasien: request.term,
											   instalasi_id: $("#instalasi_id").val(),
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
						 'options'=>array(
							   'minLength' => 2,
								'focus'=> 'js:function( event, ui ) {
									 $(this).val( "");
									 return false;
								 }',
							   'select'=>'js:function( event, ui ) {
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik);
									return false;
								}',
						),
						'htmlOptions'=>array('placeholder'=>'Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
							'onkeyup'=>"return $(this).focusNextInputField(event)",
						),
					)); 
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('nama_bin',$modPasien->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('jeniskelamin',$modPasien->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</div>
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogPasien = new KUPasienM('searchPasienVerifikasiMcu');
    $modDialogPasien->unsetAttributes();
    $modDialogPasien->idInstalasi = Params::INSTALASI_ID_RJ;
    if(isset($_GET['KUPasienM'])) {
        $modDialogPasien->attributes = $_GET['KUPasienM'];
        $modDialogPasien->idInstalasi = (isset($_GET['KUPasienM']['idInstalasi']) ? $_GET['KUPasienM']['idInstalasi'] : null);
        $modDialogPasien->no_pendaftaran = (isset($_GET['KUPasienM']['no_pendaftaran']) ? $_GET['KUPasienM']['no_pendaftaran'] : "");
        $modDialogPasien->tgl_pendaftaran_cari = (isset($_GET['KUPasienM']['tgl_pendaftaran_cari']) ? $_GET['KUPasienM']['tgl_pendaftaran_cari'] : "");
        $modDialogPasien->instalasi_nama = (isset($_GET['KUPasienM']['instalasi_nama']) ? $_GET['KUPasienM']['instalasi_nama'] : "");
        $modDialogPasien->carabayar_nama = (isset($_GET['KUPasienM']['carabayar_nama']) ? $_GET['KUPasienM']['carabayar_nama'] : "");
        $modDialogPasien->ruangan_nama = (isset($_GET['KUPasienM']['ruangan_nama']) ? $_GET['KUPasienM']['ruangan_nama'] : "");
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'datakunjungan-grid',
		'dataProvider'=>$modDialogPasien->searchPasienVerifikasiMcu(),
		'filter'=>$modDialogPasien,
		'template'=>"{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectPendaftaran",
								"onClick" => "
									setInfoPasien($data->pendaftaran_id, \"\", \"\");
									$(\"#dialogPasien\").dialog(\"close\");
								"))',
			),
			'no_pendaftaran',
			array(
				'name'=>'tgl_pendaftaran',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
				'filter'=> false,
			),
			array(
				'name'=>'no_rekam_medik',
				'type'=>'raw',
				'value'=>'$data->no_rekam_medik',
			),
			'nama_pasien',
			array(
				'name'=>'jeniskelamin',
				'type'=>'raw',
				'filter'=>LookupM::model()->getItems('jeniskelamin'),
			),
			array(
				'name'=>'instalasi_id',
				'value'=>'$data->instalasi_nama',
				'type'=>'raw',
				'filter'=>CHtml::activeHiddenField($modDialogPasien,'idInstalasi'),
			),
			array(
				'name'=>'ruangan_nama',
				'type'=>'raw',
			),
			array(
				'name'=>'carabayar_nama',
				'type'=>'raw',
				'value'=>'$data->carabayar_nama',
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();

////======= end pendaftaran dialog =============
?>

