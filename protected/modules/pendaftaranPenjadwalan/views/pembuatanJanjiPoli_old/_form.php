<style type="text/css">
	.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > li > a{
		cursor: pointer;
	}
</style>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'form-buat-janji-poli',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>

	<?php 
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash('success', "Data janji poli berhasil dibuat!");
		}
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>	
 
	<div class="row">
		<div class="tab-pane active span12" id="tabs-basic">
			<div class="tabbable">
				<ul class="nav nav-tabs" id="tabes">
				  <li class="active" onClick="tab1(this)" id="rekammedik"><a data-toggle="tab">Langkah 1: No. Rekam Medik</a></li>
				  <li onClick="tab1(this)" id="datapasien"><a data-toggle="tab">Langkah 2: Data Pasien</a></li>
				  <li onClick="tab1(this)" id="datapoli"><a data-toggle="tab">Langkah 3: Data Janji Poli
				</ul>
				<div class="tab-content biru">
					<div class="white tab-pane" id="tab1-rekammedik">
						<fieldset class="box" id='fieldsetNoRM'>
							<legend class="rim">Pilih No. Rekam Medik</legend>
							<table cellspacing="3" cellpadding="3" align="center">
								<tr>
									<td align="center" colspan="3"></td>
								</tr>       
								<tr>
									<td align="left">
									<div class="control-group">
										<?php echo CHtml::label("Cari NIP", 'nomorindukpegawai', array('class'=>'control-label'))?>
										<div class="controls">
											<?php 
												$this->widget('MyJuiAutoComplete', array(
//													'name'=>'cari_nomorindukpegawai',
//													'value'=>$modPegawai->nomorindukpegawai,
													// RND-9167
													'model'=>$modPegawai,
													'attribute' => 'nomorindukpegawai',
													'source'=>'js: function(request, response) {
																   $.ajax({
																	   url: "'.$this->createUrl('AutocompletePasienLama').'",
																	   dataType: "json",
																	   data: {
																		   nomorindukpegawai: request.term,
																	   },
																	   success: function (data) {
																			   response(data);
																	   }
																   })
																}',
													 'options'=>array(
														   'minLength' => 3,
															'focus'=> 'js:function( event, ui ) {
																 $(this).val( "");
																 return false;
															 }',
														   'select'=>'js:function( event, ui ) {
																$(this).val( ui.item.value);
																return false;
															}',
													),
													'tombolDialog'=>array('idDialog'=>'dialogPasienBadak'),
													'htmlOptions'=>array('placeholder'=>'NIP','rel'=>'tooltip','title'=>'Ketik NIP untuk mencari pasien',
														'onkeyup'=>"return $(this).focusNextInputField(event)",
					//                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
														'class'=>'span2'),
												)); 
											?>
										</div>
									</div>
									<label class="control-label">
									<div class="label_no">
										<i class="icon-user"></i>            
										<?php echo CHtml::checkBox('isPasienLama', $modPasien->isPasienLama, array('rel'=>'tooltip','title'=>'Pilih jika pasien lama','onclick'=>'pilihNoRm()', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?> No. Rekam Medik    
									</div>
									</label>
									<div class="controls" id="controlNoRekamMedik">
									  <?php $this->widget('MyJuiAutoComplete',array(
												'name'=>'no_rekam_medik',
												'value'=>$model->no_rekam_medik,
												'sourceUrl'=> $this->createUrl('PasienLama'),
												'options'=>array(
												   'showAnim'=>'fold',
												   'style'=>'height:20px;',
												   'minLength' => 2,
												   'focus'=> 'js:function( event, ui ) {
														$("#noRekamMedik").val( ui.item.value );
														return false;
													}',
												   'select'=>'js:function( event, ui ) {
														$(\'#PPBuatJanjiPoliT_pasien_id\').val(ui.item.pasien_id);
														$(\'#no_rekam_medik\').val(ui.item.no_rekam_medik);
														$("#'.CHtml::activeId($modPasien,'jenisidentitas').'").val(ui.item.jenisidentitas);
														$("#'.CHtml::activeId($modPasien,'no_identitas_pasien').'").val(ui.item.no_identitas_pasien);
														$("#'.CHtml::activeId($modPasien,'namadepan').'").val(ui.item.namadepan);
														$("#'.CHtml::activeId($modPasien,'nama_pasien').'").val(ui.item.nama_pasien);
														$("#'.CHtml::activeId($modPasien,'nama_bin').'").val(ui.item.nama_bin);
														$("#'.CHtml::activeId($modPasien,'tempat_lahir').'").val(ui.item.tempat_lahir);
														$("#'.CHtml::activeId($modPasien,'tanggal_lahir').'").val(ui.item.tanggal_lahir);
														$("#'.CHtml::activeId($modPasien,'kelompokumur_id').'").val(ui.item.kelompokumur_id);
														$("#'.CHtml::activeId($modPasien,'jeniskelamin').'").val(ui.item.jeniskelamin);
														setJenisKelaminPasien(ui.item.jeniskelamin);
														setRhesusPasien(ui.item.rhesus);
														loadDaerahPasien(ui.item.propinsi_id, ui.item.kabupaten_id, ui.item.kecamatan_id, ui.item.kelurahan_id);
														$("#'.CHtml::activeId($modPasien,'statusperkawinan').'").val(ui.item.statusperkawinan);
														$("#'.CHtml::activeId($modPasien,'golongandarah').'").val(ui.item.golongandarah);
														$("#'.CHtml::activeId($modPasien,'rhesus').'").val(ui.item.rhesus);
														$("#'.CHtml::activeId($modPasien,'alamat_pasien').'").val(ui.item.alamat_pasien);
														$("#'.CHtml::activeId($modPasien,'rt').'").val(ui.item.rt);
														$("#'.CHtml::activeId($modPasien,'rw').'").val(ui.item.rw);
														$("#'.CHtml::activeId($modPasien,'propinsi_id').'").val(ui.item.propinsi_id);
														$("#'.CHtml::activeId($modPasien,'kabupaten_id').'").val(ui.item.kabupaten_id);
														$("#'.CHtml::activeId($modPasien,'kecamatan_id').'").val(ui.item.kecamatan_id);
														$("#'.CHtml::activeId($modPasien,'kelurahan_id').'").val(ui.item.kelurahan_id);
														$("#'.CHtml::activeId($modPasien,'no_telepon_pasien').'").val(ui.item.no_telepon_pasien);
														$("#'.CHtml::activeId($modPasien,'no_mobile_pasien').'").val(ui.item.no_mobile_pasien);
														$("#'.CHtml::activeId($modPasien,'suku_id').'").val(ui.item.suku_id);
														$("#'.CHtml::activeId($modPasien,'alamatemail').'").val(ui.item.alamatemail);
														$("#'.CHtml::activeId($modPasien,'anakke').'").val(ui.item.anakke);
														$("#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'").val(ui.item.jumlah_bersaudara);
														$("#'.CHtml::activeId($modPasien,'pendidikan_id').'").val(ui.item.pendidikan_id);
														$("#'.CHtml::activeId($modPasien,'pekerjaan_id').'").val(ui.item.pekerjaan_id);
														$("#'.CHtml::activeId($modPasien,'agama').'").val(ui.item.agama);
														$("#'.CHtml::activeId($modPasien,'warga_negara').'").val(ui.item.warga_negara);
														loadUmur(ui.item.tanggal_lahir);
														return false;
													}',

												),
												'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbersOnly'),
												'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
										)); ?>      
									</div>
									</td>
								</tr>                                   			
							</table>  
						</fieldset>
					</div>
					<div class="white tab-pane" id="tab1-datapasien">
						<fieldset class="box" id='fieldsetPasien'>
				    <legend class="rim">Masukan Data Pasien</legend>
				    <div class="row">
				            <div class="col-sm-6">        
				      <!--<div class="control-group">
										<?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
										<div class="controls">
											<?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
																		  array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
																				)); ?>   
											<?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'No. Identitas','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
											<?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
										</div>
								</div>-->
								<div class="control-group">
								   <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
								   <div class="controls inline">

									   <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
																	 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1'
																		   )); ?>   
									   <?php echo $form->textField($modPasien,'nama_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 all-caps','placeholder'=>'Nama Pasien')); ?>            

									   <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
								   </div>
								</div>
								<?php //echo $form->textFieldRow($modPasien,'nama_bin', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alias')); ?>
								<?php //echo $form->textFieldRow($modPasien,'tempat_lahir', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Tempat Lahir')); ?>
				                             
								<div class="control-group">
									<?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
									<div class="controls">
										<?php   
											$this->widget('MyDateTimePicker',array(
												'model'=>$modPasien,
												'attribute'=>'tanggal_lahir',
												'mode'=>'date',
												'options'=> array(
//                                                                  'dateFormat'=>Params::DATE_FORMAT,
													'maxDate' => 'd',
													'onkeyup'=>"js:function(){getUmur(this);}",
													'onSelect'=>'js:function(){getUmur(this);}',
												),
													'htmlOptions'=>array('class'=>'dtPicker4 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
												),
											)); 
										?>
										<?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
									</div>
								</div>
				                              
								<div class="control-group">
									<?php echo $form->labelEx($modPasien,'umur', array('class'=>'control-label')) ?>
									<div class="controls">
										<?php
											$this->widget('CMaskedTextField', array(
											'model' => $modPasien,
											'attribute' => 'umur',
											'mask' => '99 Thn 99 Bln 99 Hr',
											'htmlOptions' => array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'onblur'=>'getTglLahir(this)','placeholder'=>'Umur Pasien')
											));
											?>
										<?php echo $form->error($modPasien, 'umur',array('placeholder'=>'Umur Pasien')); ?>
									</div>
								</div>
								<?php echo $form->radioButtonListInlineRow($modPasien,'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
								<?php //echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

								<!--<div class="control-group">
										<?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>

										<div class="controls">

											<?php echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
																		  array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>   
											<div class="radio inline">
												<div class="form-inline">
												<?php echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
												</div>
										   </div>
											<?php echo $form->error($modPasien, 'golongandarah'); ?>
											<?php echo $form->error($modPasien, 'rhesus'); ?>
										</div>
								</div>-->
								<?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat Lengkap Pasien',)); ?>

								<!--<div class="control-group">
									<?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline ')) ?>

									<div class="controls">
										<?php echo $form->textField($modPasien,'rt', array('placeholder'=>'RT','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>   / 
										<?php echo $form->textField($modPasien,'rw', array('placeholder'=>'RW','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>            
										<?php echo $form->error($modPasien, 'rt'); ?>
										<?php echo $form->error($modPasien, 'rw'); ?>
									</div>
								</div>-->
									<?php //echo $form->textFieldRow($modPasien,'no_telepon_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Telepon Pasien ','class'=>'span4 numbersOnly')); ?>
									<?php echo $form->textFieldRow($modPasien,'no_mobile_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Hp Pasien','class'=>'span4 numbersOnly')); ?>                          
							</div>
				        

				           <!--<div class="col-sm-6">
				                <div class="control-group">
									<?php echo $form->labelEx($modPasien,'propinsi_id', array('class'=>'control-label')) ?>
									<div class="controls">
									<?php $modPasien->propinsi_id = (!empty($modPasien->propinsi_id))?$modPasien->propinsi_id:Yii::app()->user->getState('propinsi_id');?>
									<?php echo $form->dropDownList($modPasien,'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
																	  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
																			'ajax'=>array('type'=>'POST',
																						  'url'=>$this->createUrl('GetKabupaten',array('encode'=>false,'namaModel'=>'PPPasienM')),
																						  'update'=>'#PPPasienM_kabupaten_id',),
																			'onchange'=>"clearKecamatan();clearKelurahan();",)); ?>
								   <?php echo $form->error($modPasien, 'propinsi_id'); ?>
									</div>
								</div>

								<div class="control-group">
									<?php echo $form->labelEx($modPasien,'kabupaten_id', array('class'=>'control-label')) ?>
									<div class="controls">
										<?php $modPasien->kabupaten_id = (!empty($modPasien->kabupaten_id))?$modPasien->kabupaten_id:Yii::app()->user->getState('kabupaten_id');?>
										<?php echo $form->dropDownList($modPasien,'kabupaten_id',CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
																		  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
																				'ajax'=>array('type'=>'POST',
																							  'url'=>$this->createUrl('GetKecamatan',array('encode'=>false,'namaModel'=>'PPPasienM')),
																							  'update'=>'#PPPasienM_kecamatan_id'),
																				'onchange'=>"clearKelurahan();",)); ?>
										<?php echo $form->error($modPasien, 'kabupaten_id'); ?>
									</div>
								</div>

								<div class="control-group">
									<?php echo $form->labelEx($modPasien,'kecamatan_id', array('class'=>'control-label')) ?>
									<div class="controls">
										<?php $modPasien->kecamatan_id = (!empty($modPasien->kecamatan_id))?$modPasien->propinsi_id:Yii::app()->user->getState('kecamatan_id');?>
										<?php echo $form->dropDownList($modPasien,'kecamatan_id',CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
																		  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
																				'ajax'=>array('type'=>'POST',
																							  'url'=>$this->createUrl('GetKelurahan',array('encode'=>false,'namaModel'=>'PPPasienM')),
																							  'update'=>'#PPPasienM_kelurahan_id'))); ?>
										<?php echo $form->error($modPasien, 'kecamatan_id'); ?>
									</div>
								</div>

								 <div class="control-group">
									<?php echo $form->labelEx($modPasien,'kelurahan_id', array('class'=>'control-label')) ?>
									<div class="controls">
										<?php $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->propinsi_id:Yii::app()->user->getState('kelurahan_id');?>
										<?php echo $form->dropDownList($modPasien,'kelurahan_id',CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
																		  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
										<?php echo $form->error($modPasien, 'kelurahan_id'); ?>
									</div>
								</div>

								 <?php echo $form->dropDownListRow($modPasien,'agama', LookupM::getItems('agama'),array('class'=>'span4','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
								 <?php echo $form->dropDownListRow($modPasien,'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
								 <?php echo $form->dropDownListRow($modPasien,'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
								 <?php echo $form->dropDownListRow($modPasien,'warga_negara', LookupM::getItems('warganegara'),array('class'=>'span4','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

				            </div>-->
				    </div>
				    </fieldset>
					</div>
					<div class="white tab-pane" id="tab1-datapoli">
						<fieldset class="box" id='fieldsetPoli'>
							<legend class="rim">Masukan Data Janji Poli</legend>
							
							<div class="row">				
								<div class="control-group">

									<div class="controls inline">
										<?php echo $form->hiddenField($model, 'pasien_id'); ?>
										<?php  echo $form->checkBox($model,'byphone', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
										<i class="icon-phone"></i> <?php echo $model->getAttributeLabel('byphone'); ?>
										<?php echo $form->error($model, 'byphone'); ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($modPasien,'Ruangan <span class="required">*</span> ', array('class'=>'control-label')) ?>
									<div class="controls inline">
										<?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData($model->getRuanganItems(), 
											'ruangan_id', 'ruangan_nama') ,array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>"listDokterRuangan(this.value);",
												'ajax'=>array(),
													'onkeypress'=>"return $(this).focusNextInputField(event)")); ?> 
										<span id="msg_ruangan" style="color:red"></span>
									</div>
								</div>
								<?php echo $form->dropDownListRow($model,'pegawai_id', array() ,array('class'=>'span3','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
								<div class="control-group">
									<?php echo $form->labelEx($model,'tgljadwal', array('class'=>'control-label')) ?>
									<div class="controls inline">
										<?php   
											$this->widget('MyDateTimePicker',array(
												'model'=>$model,
												'attribute'=>'tgljadwal',
												'mode'=>'datetime',
												'options'=> array(
													'dateFormat'=>Params::DATE_FORMAT,
													'minDate' => 'd',
													'onkeypress'=>"js:function(){hariBaru(this);}",
													'onSelect'=>'js:function(){hariBaru(this);}',
													'sideBySide'=>true,
												),
												'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3',
												'onkeypress'=>"return $(this).focusNextInputField(event)"
											 ),
										)); ?>
									</div>
									<span id="msg_tgljadwal" style="color:red; margin-left: 160px;"></span>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model,'harijadwal', array('class'=>'control-label')) ?>
									<div class="controls inline">
										<?php echo $form->textField($model,'harijadwal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>TRUE)); ?>
									</div>
									<span id="msg_harijadwal" style="color:red"></span>
								</div>
								<?php echo $form->textAreaRow($model,'keteranganbuatjanji',array('rows'=>6, 'cols'=>60, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
  	
	<div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['buatjanjipoli_id'])) ? true : (($sukses > 0) ? true : false);
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
			array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disableSave));
		?>
		 <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl($this->id.'/create'), 
					array('class'=>'btn btn-danger',
						'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKarcis();return false",'disabled'=>$disablePrint  )).'&nbsp;'; ?>
	</div>

<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>500,
        'resizable'=>false,
    ),
));

$modDataPasien = new PPPasienM('searchWithDaerah');
$modDataPasien->unsetAttributes();
if(isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pasien-m-grid',
	'dataProvider'=>$modDataPasien->searchWithDaerah(),
	'filter'=>$modDataPasien,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
	array(
		'header'=>'Pilih',
		'type'=>'raw',
		'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
			"id" => "selectPasien",
			"onClick" => "
				$(\"#dialogPasien\").dialog(\"close\");
				$(\"#'.CHtml::activeId($model,'pasien_id').'\").val(\"$data->pasien_id\");
				$(\"#no_rekam_medik\").val(\"$data->no_rekam_medik\");
				$(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
				$(\"#'.CHtml::activeId($modPasien,'jenisidentitas').'\").val(\"$data->jenisidentitas\");
				$(\"#'.CHtml::activeId($modPasien,'no_identitas_pasien').'\").val(\"$data->no_identitas_pasien\");
				$(\"#'.CHtml::activeId($modPasien,'namadepan').'\").val(\"$data->namadepan\");
				$(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
				$(\"#'.CHtml::activeId($modPasien,'nama_bin').'\").val(\"$data->nama_bin\");
				$(\"#'.CHtml::activeId($modPasien,'tempat_lahir').'\").val(\"$data->tempat_lahir\");
				$(\"#'.CHtml::activeId($modPasien,'tanggal_lahir').'\").val(\"$data->tanggal_lahir\");
				$(\"#'.CHtml::activeId($modPasien,'kelompokumur_id').'\").val(\"$data->kelompokumur_id\");
				$(\"#'.CHtml::activeId($modPasien,'jeniskelamin').'\").val(\"$data->jeniskelamin\");
				$(\"#'.CHtml::activeId($modPasien,'statusperkawinan').'\").val(\"$data->statusperkawinan\");
				$(\"#'.CHtml::activeId($modPasien,'golongandarah').'\").val(\"$data->golongandarah\");
				$(\"#'.CHtml::activeId($modPasien,'rhesus').'\").val(\"$data->rhesus\");
				$(\"#'.CHtml::activeId($modPasien,'alamat_pasien').'\").val(\"$data->alamat_pasien\");
				$(\"#'.CHtml::activeId($modPasien,'rt').'\").val(\"$data->rt\");
				$(\"#'.CHtml::activeId($modPasien,'rw').'\").val(\"$data->rw\");
				$(\"#'.CHtml::activeId($modPasien,'propinsi_id').'\").val(\"$data->propinsi_id\");
				$(\"#'.CHtml::activeId($modPasien,'kabupaten_id').'\").val(\"$data->kabupaten_id\");
				$(\"#'.CHtml::activeId($modPasien,'kecamatan_id').'\").val(\"$data->kecamatan_id\");
				$(\"#'.CHtml::activeId($modPasien,'kelurahan_id').'\").val(\"$data->kelurahan_id\");
				$(\"#'.CHtml::activeId($modPasien,'no_telepon_pasien').'\").val(\"$data->no_telepon_pasien\");
				$(\"#'.CHtml::activeId($modPasien,'no_mobile_pasien').'\").val(\"$data->no_mobile_pasien\");
				$(\"#'.CHtml::activeId($modPasien,'suku_id').'\").val(\"$data->suku_id\");
				$(\"#'.CHtml::activeId($modPasien,'alamatemail').'\").val(\"$data->alamatemail\");
				$(\"#'.CHtml::activeId($modPasien,'anakke').'\").val(\"$data->anakke\");
				$(\"#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'\").val(\"$data->jumlah_bersaudara\");
				$(\"#'.CHtml::activeId($modPasien,'pendidikan_id').'\").val(\"$data->pendidikan_id\");
				$(\"#'.CHtml::activeId($modPasien,'pekerjaan_id').'\").val(\"$data->pekerjaan_id\");
				$(\"#'.CHtml::activeId($modPasien,'agama').'\").val(\"$data->agama\");
				$(\"#'.CHtml::activeId($modPasien,'warga_negara').'\").val(\"$data->warga_negara\");
				loadUmur(\"$data->tanggal_lahir\");
				setJenisKelaminPasien(\"$data->jeniskelamin\");
				setRhesusPasien(\"$data->rhesus\");
				loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->pasien_id);

			"))',
		),
		'no_rekam_medik',
		'nama_pasien',
		'nama_bin',
		'alamat_pasien',
		'rw',
		'rt',
		array(
			'name'=>'propinsiNama',
			'value'=>'$data->propinsi->propinsi_nama',
		),
		array(
			'name'=>'kabupatenNama',
			'value'=>'$data->kabupaten->kabupaten_nama',
		),
		array(
			'name'=>'kecamatanNama',
			'value'=>'$data->kecamatan->kecamatan_nama',
		),
		array(
			'name'=>'kelurahanNama',
			'value'=>'(isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : "")',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasienBadak',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
	
	$modDataPasien = new PPPasienM('searchDialog');
    $modDataPasien->unsetAttributes();
    $format = new MyFormatter();
    $modDataPasien->ispasienluar = FALSE;
    if(isset($_GET['PPPasienM'])) {
        $modDataPasien->attributes = $_GET['PPPasienM'];
//        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
        $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
        $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
		if(isset($_GET['PPPasienM']['nomorindukpegawai'])){
			$modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
		}        
    }
	
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'pasienbadak-m-grid',
		'dataProvider'=>$modDataPasien->searchDialogBadak(),
		'filter'=>$modDataPasien,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
					"id" => "selectPasien",
					"onClick" => "
						$(\"#dialogPasienBadak\").dialog(\"close\");
						$(\"#'.CHtml::activeId($model,'pasien_id').'\").val(\"$data->pasien_id\");
						$(\"#no_rekam_medik\").val(\"$data->no_rekam_medik\");
						$(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
						$(\"#'.CHtml::activeId($modPasien,'jenisidentitas').'\").val(\"$data->jenisidentitas\");
						$(\"#'.CHtml::activeId($modPasien,'no_identitas_pasien').'\").val(\"$data->no_identitas_pasien\");
						$(\"#'.CHtml::activeId($modPasien,'namadepan').'\").val(\"$data->namadepan\");
						$(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
						$(\"#'.CHtml::activeId($modPasien,'nama_bin').'\").val(\"$data->nama_bin\");
						$(\"#'.CHtml::activeId($modPasien,'tempat_lahir').'\").val(\"$data->tempat_lahir\");
						$(\"#'.CHtml::activeId($modPasien,'tanggal_lahir').'\").val(\"$data->tanggal_lahir\");
						$(\"#'.CHtml::activeId($modPasien,'kelompokumur_id').'\").val(\"$data->kelompokumur_id\");
						$(\"#'.CHtml::activeId($modPasien,'jeniskelamin').'\").val(\"$data->jeniskelamin\");
						$(\"#'.CHtml::activeId($modPasien,'statusperkawinan').'\").val(\"$data->statusperkawinan\");
						$(\"#'.CHtml::activeId($modPasien,'golongandarah').'\").val(\"$data->golongandarah\");
						$(\"#'.CHtml::activeId($modPasien,'rhesus').'\").val(\"$data->rhesus\");
						$(\"#'.CHtml::activeId($modPasien,'alamat_pasien').'\").val(\"$data->alamat_pasien\");
						$(\"#'.CHtml::activeId($modPasien,'rt').'\").val(\"$data->rt\");
						$(\"#'.CHtml::activeId($modPasien,'rw').'\").val(\"$data->rw\");
						$(\"#'.CHtml::activeId($modPasien,'propinsi_id').'\").val(\"$data->propinsi_id\");
						$(\"#'.CHtml::activeId($modPasien,'kabupaten_id').'\").val(\"$data->kabupaten_id\");
						$(\"#'.CHtml::activeId($modPasien,'kecamatan_id').'\").val(\"$data->kecamatan_id\");
						$(\"#'.CHtml::activeId($modPasien,'kelurahan_id').'\").val(\"$data->kelurahan_id\");
						$(\"#'.CHtml::activeId($modPasien,'no_telepon_pasien').'\").val(\"$data->no_telepon_pasien\");
						$(\"#'.CHtml::activeId($modPasien,'no_mobile_pasien').'\").val(\"$data->no_mobile_pasien\");
						$(\"#'.CHtml::activeId($modPasien,'suku_id').'\").val(\"$data->suku_id\");
						$(\"#'.CHtml::activeId($modPasien,'alamatemail').'\").val(\"$data->alamatemail\");
						$(\"#'.CHtml::activeId($modPasien,'anakke').'\").val(\"$data->anakke\");
						$(\"#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'\").val(\"$data->jumlah_bersaudara\");
						$(\"#'.CHtml::activeId($modPasien,'pendidikan_id').'\").val(\"$data->pendidikan_id\");
						$(\"#'.CHtml::activeId($modPasien,'pekerjaan_id').'\").val(\"$data->pekerjaan_id\");
						$(\"#'.CHtml::activeId($modPasien,'agama').'\").val(\"$data->agama\");
						$(\"#'.CHtml::activeId($modPasien,'warga_negara').'\").val(\"$data->warga_negara\");
						setNip(\"$data->pegawai_id\"); checkedRM(); pilihNoRm();
						loadUmur(\"$data->tanggal_lahir\");
						setJenisKelaminPasien(\"$data->jeniskelamin\");
						setRhesusPasien(\"$data->rhesus\");
						loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->pasien_id);
					"))',
			),
			array(
				'header'=>'NIP',
				'name'=> 'nomorindukpegawai',
				'type'=>'raw',
				'value'=>'$data->pegawai->nomorindukpegawai',
			),
			'no_rekam_medik',
			'nama_pasien',
			'nama_bin',
			array(
				'name'=>'jeniskelamin',
				'type'=>'raw',
				'filter'=> LookupM::model()->getItems('jeniskelamin'),
				'value'=>'$data->jeniskelamin'
			),

//                    array(
//                        'name'=>'tanggal_lahir',
//                        'type'=>'raw',
//                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
//                    ),
			array(
				'name'=>'tanggal_lahir',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
				'filter'=>$this->widget('MyDateTimePicker',array(
						'model'=>$modDataPasien,
						'attribute'=>'tanggal_lahir',
						'mode'=>'date',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
						),
						'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
					),true
				),
				'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
			),
			'alamat_pasien',
			'rw',
			'rt',
			array(
				'header'=>'Nama Kelurahan',
				'name'=>'cari_kelurahan_nama',
				'type'=>'raw',
				'value'=>'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
			),
			array(
				'header'=>'Nama Kecamatan',
				'name'=>'cari_kecamatan_nama',
				'type'=>'raw',
				'value'=>'$data->kecamatan->kecamatan_nama'
			),
			'norm_lama',
			array(
				'name'=>'statusrekammedis',
				'type'=>'raw',
				'filter'=> LookupM::getItems('statusrekammedis'),
				'value'=>'$data->statusrekammedis',
			),
		),
		'afterAjaxUpdate'=>'function(id, data){
			 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
					showMonthAfterYear:false}, 
					jQuery.datepicker.regional[\'id\'], 
				   {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
				   \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
				   \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
			jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});

		}',
    ));
    $this->endWidget();
?>
