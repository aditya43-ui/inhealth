<?php
$this->breadcrumbs=array(
	'Reseptur',
);

$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RESEPTUR</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));

?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'periksahd-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
//        'focus'=>'#namaObatNonRacik',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'list-rujukankeluar',
            'content'=>array(
                'content-detailpasien'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Hemodialisis Pasien')).'<b> Tabel Riwayat Hemodialisis</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_listHD',array(
                            'modRiwayatHD'=>$modRiwayatHD,
                            'modPeriksaHD'=>$modPeriksaHD,
                            ),true),
                    'active'=>true,
                    ),   
                ),
        )); ?>
<div class="row-fluid">
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Jenis dan Resep HD</legend>
			<div class="span12">
				<div class="control-group ">
					<?php echo CHtml::label('Peresepan HD <span class="required">*</span>','jenis_hd', array('class'=>'control-label required')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($modPeriksaHD,'jenishd_id',CHtml::listData(JenishdM::model()->findAll('jenishd_aktif is TRUE'), 'jenishd_id', 'jenishd_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'--Pilih--'));?>
					</div>
				</div>
				<div class="control-group ">
					<?php // echo CHtml::label('Resep HD <span class="required">*</span>','resep_hd', array('class'=>'control-label required')) ?>
					<div class="controls">
						<?php //  echo $form->dropDownList($modPeriksaHD,'jenishd_id',CHtml::listData(ResephdM::model()->findAll('resephd_aktif is TRUE'), 'resephd_id', 'resephd_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'--Pilih--'));?>
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset class="box row-fluid">
			<legend class="rim">Akses Vaskular <span class="required">*</span></legend>
			<div class="span12">
				<div class="form-inline">
					<?php echo $form->radioButtonList($modPeriksaHD, 'aksesvaskular_id', HDPeriksahdT::getAksesVaskular(), array('separator' => '','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputRequire aksesvaskular_id')); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Jenis Dialisat <span class="required">*</span></legend>
			<div class="span12">
				<div class="form-inline">
					<?php echo $form->radioButtonList($modPeriksaHD, 'jenisdialisat_id', HDPeriksahdT::getJenisDialisat(), array('separator' => '','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputRequire jenisdialisat_id')); ?>
				</div>
			</div>
			<div class="span12">
				<div class="control-group " style="margin-left:-55px">
					 <?php echo CHtml::label('Suhu Dialisat','Suhu', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'suhudialisis_c', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float'));?> &#8451;
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Penggunaan Dialeser</legend>
			<div class="span12">
				<div class="control-group ">
					 <?php echo CHtml::label('Tanggal Penggunaan Awal <span class="required">*</span>','', array('class'=>'control-label required')) ?>
					<div class="controls">
						<?php   
						$this->widget('MyDateTimePicker',array(
							'model'=>$modPeriksaHD,
							'attribute'=>'tglpenggunaanawal',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
								'maxDate' => 'd',
								'yearRange'=> "-60:+0",
							),
							'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2', 'onkeypress'=>"return $(this).focusNextInputField(event)"
							),
						)); ?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Tanggal Penggunaan Dialiser <span class="required">*</span>','tanggal', array('class'=>'control-label required')) ?>
					<div class="controls">
						<?php   
						$this->widget('MyDateTimePicker',array(
							'model'=>$modPeriksaHD,
							'attribute'=>'periksahd_tgl',
							'mode'=>'datetime',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
								'maxDate' => 'd',
								'yearRange'=> "-60:+0",
							),
							'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
							),
						)); ?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Penggunaan Ke- <span class="required">*</span>','Penggunaan', array('class'=>'control-label required')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'dialiserke', array('value'=>$jmlDialisat,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer','readonly'=>false));?>
					</div>
				</div>
				
				<div class="control-group ">
					 <?php echo CHtml::label('Perawat <span class="required">*</span>','Perawat', array('class'=>'control-label required')) ?>
					<div class="controls">
						<?php echo $form->hiddenField($modPeriksaHD,'pegawai_id', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer'));?>
						<?php 
							$this->widget('MyJuiAutoComplete', array(
								'name'=>'perawat',
								'attribute'=>'perawat',
								'model'=>$modPeriksaHD,
								'source'=>'js: function(request, response) {
											   $.ajax({
												   url: "'.$this->createUrl('AutoCompletePegawaiPerawat').'",
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
									   'minLength' => 4,
									   'focus'=> 'js:function( event, ui ) {
											$(this).val( ui.item.label);
											return false;
										}',
									   'select'=>'js:function( event, ui ) {
											$("#HDPeriksahdT_pegawai_id").val(ui.item.value); 
											return false;
										}',
								),
								'tombolDialog'=>array('idDialog'=>'dialogPerawat'),
								'htmlOptions'=>array('placeholder'=>'Ketik Nama Perawat','title'=>'Ketikan Nama Perawat/Pegawai')
							)); 
						?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
            <fieldset class="box" id="label-sleed">
            <legend class="rim"><span class="labelsleed">HD SLED</span></legend>
			<div class="span12"> 
                <div class="control-group">
                    <?php echo CHtml::label('Teknik HD','teknik_hd', array('class'=>'control-label')) ?>
                    <div class="controls">
                    <?php echo $form->dropDownList($modPeriksaHD,'teknik_hd', LookupM::getItems('teknis_hd'),array('empty'=>'-- Pilih --','onchange' => 'labelsleed1(this);return false;')); ?>           
                    </div>
                </div>
				<div class="control-group ">
					 <?php echo CHtml::label('Aliran Darah (QB)','Aliran', array('class'=>'control-label')) ?>
					<div class="controls form-inline">
						
						<?php echo $form->dropDownList($modPeriksaHD,'kec_darah_qb', array('< 150'=>'< 150','150 - 199'=>'150 - 199','200 - 249'=>'200 - 249','> 250'=>'> 250'),array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:100px')); ?> ml/Menit

                    </div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Aliran Dialisat (QD)','Aliran', array('class'=>'control-label')) ?>
					<div class="controls form-inline">
						<?php echo $form->textField($modPeriksaHD,'kec_dialisat_qd', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float'));?> ml/Menit
					</div>
				</div>
				<div class="control-group ">
					<?php echo CHtml::label('Lama Pemakaian', '', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($modPeriksaHD,'lamahd_jam', LookupM::getItems('lamadialiser'),  
										array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:100px')); ?>   

					</div>
				</div>
<!--				<div class="control-group ">
					 <?php //echo CHtml::label('Lama Dialisat','Lama', array('class'=>'control-label')) ?>
					<div class="controls form-inline">
						<?php //echo $form->textField($modPeriksaHD,'lamahd_jam', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> Jam
					</div>
				</div>-->
				<div class="control-group ">
					 <?php echo CHtml::label('UF Goal','Lama', array('class'=>'control-label')) ?>
					<div class="controls form-inline">
						<?php echo $form->textField($modPeriksaHD,'uf_goal', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float'));?> cc
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Penggunaan Heparin</legend>
			<div class="span12">
				<div class="control-group ">
					<?php echo CHtml::label('Dosis Sirkulasi','sirkulasi', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_heparin_dosissirkulasi', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkHeparin("heparin_dosissirkulasi")'))?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'heparin_dosissirkulasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float','readonly'=>true));?>
					</div>
				</div>
				<div class="control-group ">
					<?php echo CHtml::label('Dosis Awal','dosis', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_heparin_dosisawal', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkHeparin("heparin_dosisawal")'))?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'heparin_dosisawal', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float','readonly'=>true));?>
					</div>
				</div>
				<div class="control-group ">
					<?php echo CHtml::label('Kontinyu','Kontinyu', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_heparin_continyu', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkHeparin("heparin_continyu")'))?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'heparin_continyu', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float','readonly'=>true));?>
					</div>
				</div>
				<div class="control-group ">
					<?php echo CHtml::label('Intermiten','Intermiten', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_heparin_intermiten', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkHeparin("heparin_intermiten")'))?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'heparin_intermiten', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float','readonly'=>true));?>
					</div>
				</div>
				<div class="control-group ">
					<?php echo CHtml::label('LMWH','LMWH', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_heparin_lmwh', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkHeparin("heparin_lmwh")'))?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'heparin_lmwh', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 float','readonly'=>true));?>
					</div>
				</div>
				<div class="control-group ">
					<?php echo CHtml::label('Tanpa Heparin','tanpa', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_tanpaheparin_nama', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkHeparin("tanpaheparin_nama")'))?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'tanpaheparin_nama', array('placeholder'=>'alasan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true));?>
						<?php echo $form->textField($modPeriksaHD,'tanpaheparin_jml', array('placeholder'=>'jml','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 float','readonly'=>true));?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Berat Badan</legend>
			<div class="span12">
				<div class="control-group ">
					 <?php echo CHtml::label('BB Pra Hemodialisa','Pra', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'bb_pra_hd_kg', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 float'));?> Kg
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('BB Post Hemodialisa','Post', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'bb_post_hd_kg', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 float'));?> Kg
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('BB Kering','Kering', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'bb_kering_kg', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 float'));?> Kg
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Profiling</legend>
			<div class="span12">
				<div class="control-group ">
					 <?php echo CHtml::label('Ultrafiltrasi','Ultrafiltrasi', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_ultrafiltrasi',array('onclick'=>'checkProfiling("is_ultrafiltrasi")')); ?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'ultrafiltrasi_mode', array('placeholder'=>'mode','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','readonly'=>true));?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Iso UF','iso_uf', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_iso_uf_ml',array('onclick'=>'checkProfiling("is_iso_uf_ml")')); ?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'iso_uf_ml', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer','readonly'=>true));?> ml
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Lama Iso','lama_uso', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_lama_uso_uf',array('onclick'=>'checkProfiling("is_lama_uso_uf")')); ?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'lama_uso_uf', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer','readonly'=>true));?> jam
					</div>
				</div>
				
				<div class="control-group ">
					 <?php echo CHtml::label('Natrium','Natrium', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_natrium',array('onclick'=>'checkProfiling("is_natrium")')); ?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'natrium_mode', array('placeholder'=>'mode','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','readonly'=>true));?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Bicarbonat','Bicarbonat', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBox($modPeriksaHD,'is_bicarbonat',array('onclick'=>'checkProfiling("is_bicarbonat")')); ?>&nbsp;&nbsp;&nbsp;
						<?php echo $form->textField($modPeriksaHD,'bicarbonat_mode', array('placeholder'=>'mode','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','readonly'=>true));?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Dosis Obat Erithropoetin dan Injeksi</legend>
			<div class="span12">
				<div class="control-group ">
					 <?php echo CHtml::label('Hemapo','Hemapo', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php // echo $form->textField($modPeriksaHD,'obat_hemapo', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> 
						<?php echo $form->dropDownList($modPeriksaHD,'obat_hemapo', array('0'=>'--Pilih--','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('class'=>'span2')); ?>
						<?php echo $form->textField($modPeriksaHD,'obat_hemapo_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'ui 1x/Minggu'));?> 
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Recormon','Recormon', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php // echo $form->textField($modPeriksaHD,'obat_recormon', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> 
						<?php echo $form->dropDownList($modPeriksaHD,'obat_recormon', array('0'=>'--Pilih--','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('class'=>'span2')); ?>
						<?php echo $form->textField($modPeriksaHD,'obat_recormon_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'ui 1x/Minggu'));?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Eprex','Eprex', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php // echo $form->textField($modPeriksaHD,'obat_eprex', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> 
						<?php echo $form->dropDownList($modPeriksaHD,'obat_eprex', array('0'=>'--Pilih--','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('class'=>'span2')); ?>
						<?php echo $form->textField($modPeriksaHD,'obat_eprex_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'ui 1x/Minggu'));?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Epotrex','Epotrex', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php // echo $form->textField($modPeriksaHD,'obat_epotrex', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> 
						<?php echo $form->dropDownList($modPeriksaHD,'obat_epotrex', array('0'=>'--Pilih--','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('class'=>'span2')); ?>
						<?php echo $form->textField($modPeriksaHD,'obat_epotrex_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'ui 1x/Minggu'));?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Epodion','Epodion', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php // echo $form->textField($modPeriksaHD,'obat_epodion', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> 
						<?php echo $form->dropDownList($modPeriksaHD,'obat_epodion', array('0'=>'--Pilih--','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('class'=>'span2')); ?>
						<?php echo $form->textField($modPeriksaHD,'obat_epodion_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'ui 1x/Minggu'));?>
					</div>
				</div> 
                
                <div class="control-group ">
					 <?php echo CHtml::label('Renogen','Renogen', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php // echo $form->textField($modPeriksaHD,'obat_epodion', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> 
						<?php echo $form->dropDownList($modPeriksaHD,'obat_renogen', array('0'=>'--Pilih--','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000'),array('class'=>'span2')); ?>
						<?php echo $form->textField($modPeriksaHD,'obat_renogen_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'ui 1x/Minggu'));?>
					</div>
				</div>
			
				<div class="control-group ">
					 <?php echo CHtml::label('Prep Besi','Prep', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'injeksi_preb_besi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?>
						<?php echo $form->textField($modPeriksaHD,'injeksi_preb_besi_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'Ampul'));?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Asam Amino','Asam', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php // echo $form->textField($modPeriksaHD,'injeksi_asamamir', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 integer'));?> 
						<?php echo $form->dropDownList($modPeriksaHD,'injeksi_asamamir', array('0'=>'--Pilih--','200'=>'200','250'=>'250'),array('class'=>'span2')); ?>
						<?php echo $form->textField($modPeriksaHD,'injeksi_asamamir_stn', array('placeholder'=>'satuan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','readonly'=>true,'value'=>'ml'));?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Transfusi Darah</legend>
			<div class="span12">
				<div class="control-group ">
					 <?php echo CHtml::label('Jenis Transfusi Darah','Transfusi', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($modPeriksaHD,'jenistransfusi_id',CHtml::listData(JenistransfusiM::model()->findAll(), 'jenistransfusi_id', 'jenistransfusi_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'--Pilih--'));?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Jumlah Labu','Lab', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'jmllabudarah', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'integer span2'));?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Penyulit</legend>
			<div class="span12">
				<div class="controls">
					Klinis :
					<?php echo CHtml::activecheckBoxList($modPeriksaHD, 'periksahd_penyulit', LookupM::getItems('penyulit_klinis'), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
					<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<?php echo $form->textField($modPeriksaHD,'periksahd_penyulitLainnya', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','placeholder'=>'Klinis Lainnya','title'=>'Isi jika Klinis Lainnya dipilih'));?>
				</div>
			</div>
			<div class="span12">
				<div class="controls">
					Teknis : 
					<?php echo CHtml::activecheckBoxList($modPeriksaHD, 'penyulit_teknis', LookupM::getItems('penyulit_teknis'), array('separator' => '&nbsp;&nbsp;&nbsp;', 'onkeypress' => "return $(this).focusNextInputField(event)"));?>
					<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<?php echo $form->textField($modPeriksaHD,'penyulit_teknisLainnya', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','placeholder'=>'Teknis Lainnya', 'title'=>'Isi jika Teknis Lainnya dipilih'));?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span6">
		<fieldset class="box row-fluid">
			<legend class="rim">Perhitungan Adekuasi</legend>
			<div class="span12">
				<div class="control-group ">
					 <?php echo CHtml::label('Predialysis BUN','Predialysis', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'pre_dialisis_bun', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'float span3'));?> mg/dl
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Postdialysis BUN','Postdialysis', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'post_dialisis_bun', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'float span3'));?> mg/dl
					</div>
				</div>
				<div class="control-group ">
					<div class="controls">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo CHtml::htmlButton(Yii::t('mds','Hitung',array('')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'hitungAdekuasi()')); ?>
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Urea Reduction Ratio','Reduction', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'adekuasi_urr', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'float span3'));?> %
					</div>
				</div>
				<div class="control-group ">
					 <?php echo CHtml::label('Kt/V','Kt/V', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPeriksaHD,'adekuasi_kt_v', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'float span3'));?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="form-actions">
            
		<?php
		if(isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
						array('class'=>'btn btn-primary', 'id'=>'btn_submit','disabled'=>true))."&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']), array(
				'class'		 => 'btn btn-danger',
				'onclick'	 => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']).'";}); return false;'
                ))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRecordTerakhir(\'PRINT\')'))."&nbsp"; 
                
		}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
						array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'id'=>'btn_submit', 'onclick'=>'cekInsert();', 'onKeypress'=>'cekInsert();', 'disabled'=>(isset($_GET['sukses']))? true : false))."&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']), array(
                    'class'		 => 'btn btn-danger',
                    'onclick'	 => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']).'";}); return false;',
                    'disabled'=>true))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>'disabled'))."&nbsp"; 
		}
		?>
				<?php    $content = $this->renderPartial('hemodialisa.views.tips.transaksi',array(),true);
						$this->widget('UserTips',array('type'=>'admin','content'=>$content)); ?>
		</div>
	</div>
    

	<?php
           $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
           $urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printHemodialisa&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&periksahd_id='.$modPeriksaHD->periksahd_id);
$js = <<< JSCRIPT
function print(caraPrint,idReseptur)
{
    window.open("${urlPrint}&idReseptur="+idReseptur+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

</div>
<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//========= Dialog buat cari data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat',
    'options' => array(
        'title' => 'Pencarian Perawat/Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPegawai = new HDPegawaiM('searchDialog');
$modPegawai->unsetAttributes();
if (isset($_GET['HDPegawaiM'])) {
    $modPegawai->attributes = $_GET['HDPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modPegawai->searchDialogPerawat(),
    'filter' => $modPegawai,
    'template' => "\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPegawai",
                "onClick" => "
				  $(\"#HDPeriksahdT_pegawai_id\").val(\"$data->pegawai_id\");
                  $(\"#perawat\").val(\"$data->NamaLengkap\");
                  $(\"#dialogPerawat\").dialog(\"close\");    
            "))',
        ),
        'nomorindukpegawai',
        'NamaLengkap',
        'jeniskelamin',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end pegawai dialog =============================
?>

<script type="text/javascript">
	
	$(document).ready(function(){
		
		if($('#HDPeriksahdT_heparin_dosisawal').val() > 0){
			document.getElementById("HDPeriksahdT_heparin_dosisawal").readOnly = false;
			 document.getElementById("HDPeriksahdT_is_heparin_dosisawal").checked = true;
		}
		if($('#HDPeriksahdT_heparin_continyu').val() > 0){
			document.getElementById("HDPeriksahdT_heparin_continyu").readOnly = false;
			 document.getElementById("HDPeriksahdT_is_heparin_continyu").checked = true;
		}
		if($('#HDPeriksahdT_heparin_intermiten').val() > 0){
			document.getElementById("HDPeriksahdT_heparin_intermiten").readOnly = false;
			 document.getElementById("HDPeriksahdT_is_heparin_intermiten").checked = true;
		}
		if($('#HDPeriksahdT_heparin_lmwh').val() > 0){
			document.getElementById("HDPeriksahdT_heparin_lmwh").readOnly = false;
			 document.getElementById("HDPeriksahdT_is_heparin_lmwh").checked = true;
		}
		if($('#HDPeriksahdT_tanpaheparin_nama').val() > 0){
			document.getElementById("HDPeriksahdT_tanpaheparin_nama").readOnly = false;
			document.getElementById("HDPeriksahdT_tanpaheparin_jml").readOnly = false;
			document.getElementById("HDPeriksahdT_is_tanpaheparin_nama").checked = true;
		}
		
		if($('#HDPeriksahdT_ultrafiltrasi_mode').val() != ""){
			document.getElementById("HDPeriksahdT_ultrafiltrasi_mode").readOnly = false;
		}
		if($('#HDPeriksahdT_natrium_mode').val() != ""){
			document.getElementById("HDPeriksahdT_natrium_mode").readOnly = false;
		}
		if($('#HDPeriksahdT_bicarbonat_mode').val() != ""){
			document.getElementById("HDPeriksahdT_bicarbonat_mode").readOnly = false;
		} 
                $('form').bind('click keyup select change', function(event) { 
                    cekDisabled(this); 
                }); 
                
                $(document).on('click keyup select change',function(){  
                     cekDisabled('form'); 
                });
		cekDisabled('form');
	});
	
	function cekInsert(){
		$(".integer").each(function(){
			$(this).val(parseInt(unformatNumber($(this).val())));
		});
		$(".float").each(function(){
			$(this).val(parseFloat(unformatNumber($(this).val())));
		});

		if (!$("input[name='HDPeriksahdT[aksesvaskular_id]']:checked").val()) {
			myAlert("Akses Vaskular Masih Kosong"); 
			return false;
		}
		if (!$("input[name='HDPeriksahdT[jenisdialisat_id]']:checked").val()) {
			myAlert("Jenis Dialisat Masih Kosong"); 
			return false;
		}
		$('#periksahd-t-form').submit();
	}
	function checkHeparin(param){
		if(param=="heparin_dosissirkulasi"){
			if ($("#HDPeriksahdT_is_heparin_dosissirkulasi").is(":checked")){
				document.getElementById("HDPeriksahdT_heparin_dosissirkulasi").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_heparin_dosissirkulasi").readOnly = true;
				document.getElementById("HDPeriksahdT_heparin_dosissirkulasi").value = 0;
			}
		}else if(param=="heparin_dosisawal"){
			if ($("#HDPeriksahdT_is_heparin_dosisawal").is(":checked")){
				document.getElementById("HDPeriksahdT_heparin_dosisawal").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_heparin_dosisawal").readOnly = true;
				document.getElementById("HDPeriksahdT_heparin_dosisawal").value = 0;
			}
		}else if (param=="heparin_continyu"){
			if ($("#HDPeriksahdT_is_heparin_continyu").is(":checked")){
				document.getElementById("HDPeriksahdT_heparin_continyu").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_heparin_continyu").readOnly = true;
				document.getElementById("HDPeriksahdT_heparin_continyu").value = 0;
			}
		}else if (param=="heparin_intermiten"){
			if ($("#HDPeriksahdT_is_heparin_intermiten").is(":checked")){
				document.getElementById("HDPeriksahdT_heparin_intermiten").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_heparin_intermiten").readOnly = true;
				document.getElementById("HDPeriksahdT_heparin_intermiten").value = 0;
			}
		}else if (param=="heparin_lmwh"){
			if ($("#HDPeriksahdT_is_heparin_lmwh").is(":checked")){
				document.getElementById("HDPeriksahdT_heparin_lmwh").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_heparin_lmwh").readOnly = true;
				document.getElementById("HDPeriksahdT_heparin_lmwh").value = 0;
			}
		}else if (param=="tanpaheparin_nama"){
			if ($("#HDPeriksahdT_is_tanpaheparin_nama").is(":checked")){
				document.getElementById("HDPeriksahdT_tanpaheparin_nama").readOnly = false;
				document.getElementById("HDPeriksahdT_tanpaheparin_jml").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_tanpaheparin_nama").readOnly = true;
				document.getElementById("HDPeriksahdT_tanpaheparin_jml").readOnly = true;
				document.getElementById("HDPeriksahdT_tanpaheparin_nama").value = '';
				document.getElementById("HDPeriksahdT_tanpaheparin_jml").value = 0;
			}
		}
	}
	
	function checkProfiling(param){
		if(param=="is_ultrafiltrasi"){
			if ($("#HDPeriksahdT_is_ultrafiltrasi").is(":checked")){
				document.getElementById("HDPeriksahdT_ultrafiltrasi_mode").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_ultrafiltrasi_mode").readOnly = true;
				document.getElementById("HDPeriksahdT_ultrafiltrasi_mode").value = '';
			}
		}else if(param=="is_iso_uf_ml"){
			if ($("#HDPeriksahdT_is_iso_uf_ml").is(":checked")){
				document.getElementById("HDPeriksahdT_iso_uf_ml").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_iso_uf_ml").readOnly = true;
				document.getElementById("HDPeriksahdT_iso_uf_ml").value = 0;
			}
		}else if(param=="is_lama_uso_uf"){
			if ($("#HDPeriksahdT_is_lama_uso_uf").is(":checked")){
				document.getElementById("HDPeriksahdT_lama_uso_uf").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_lama_uso_uf").readOnly = true;
				document.getElementById("HDPeriksahdT_lama_uso_uf").value = 0;
			}
		}else if(param=="is_natrium"){
			if ($("#HDPeriksahdT_is_natrium").is(":checked")){
				document.getElementById("HDPeriksahdT_natrium_mode").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_natrium_mode").readOnly = true;
				document.getElementById("HDPeriksahdT_natrium_mode").value = '';
			}
		}else if(param=="is_bicarbonat"){
			if ($("#HDPeriksahdT_is_bicarbonat").is(":checked")){
				document.getElementById("HDPeriksahdT_bicarbonat_mode").readOnly = false;
			}else{
				document.getElementById("HDPeriksahdT_bicarbonat_mode").readOnly = true;
				document.getElementById("HDPeriksahdT_bicarbonat_mode").value = '';
			}
		}
	}
	
	function hitungAdekuasi(){
		var pre_bun = unformatNumber($('#HDPeriksahdT_pre_dialisis_bun').val());
		var post_bun = unformatNumber($('#HDPeriksahdT_post_dialisis_bun').val());
		var UF = unformatNumber($('#HDPeriksahdT_uf_goal').val());
		var W = unformatNumber($('#HDPeriksahdT_bb_post_hd_kg').val());
		
		if(!pre_bun || !post_bun || !UF || !W){
			myAlert('Inputan masih ada yang kosong !');
			return false;
		}
		
		URR = (1-(post_bun/pre_bun))*100;
		
		LN = Math.log(post_bun/pre_bun - 0.03);
		KTV = -LN+(4-3.5*(post_bun/pre_bun))*(UF/W);
		
		$('#HDPeriksahdT_adekuasi_urr').val(URR);
		$('#HDPeriksahdT_adekuasi_kt_v').val(KTV);
		
	} 
    
    function labelsleed1(){
        var label = $('#HDPeriksahdT_teknik_hd').val(); 
        
        if(label != 'SLEED') {
//            $('#label-sleed').value('Non SLEED'); 
           $("#label-sleed > legend > .labelsleed").html('Non SLEED');     
        }else{
           $("#label-sleed > legend > .labelsleed").html('HD SLEED'); 
        }
        
    }
	
</script>
