<fieldset class="box" id="fieldsetPasien">
    <legend class="rim">Data Pasien</legend>
    <div class="row">
        <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>   
                        <?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'No. Identitas',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
                        <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                    <div class="controls inline">

                        <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1',)); ?>   
                        <?php echo $form->textField($modPasien,'nama_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)", 
                                    'class'=>'span3 all-caps','placeholder'=>'Nama Pasien', )); ?>       
                        <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
                    </div>
                </div>

                        <?php echo $form->textFieldRow($modPasien,'nama_bin', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'placeholder'=>'Alias')); ?>
                        <?php echo $form->textFieldRow($modPasien,'tempat_lahir', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'placeholder'=>'Tempat Lahir')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
								'model'=>$modPasien,
								'attribute'=>'tanggal_lahir',
								'mode'=>'date',
								'options'=> array(
									//'dateFormat'=>Params::DATE_FORMAT,
									'maxDate' => 'd',
									//
									'onkeyup'=>"js:function(){getUmur(this);}",
									'onSelect'=>'js:function(){getUmur(this);}',
									'yearRange'=> "-60:+0",
								),
								'htmlOptions'=>array('class'=>'dtPicker4 datemask', 
									'onkeyup'=>"return $(this).focusNextInputField(event)",
								),
                             )); 
                        ?>
                        <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model,'umur', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('CMaskedTextField', array(
                                'model' => $model,
                                'attribute' => 'umur',
                                'mask' => '99 Thn 99 Bln 99 Hr',
                                'htmlOptions' => array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                'onblur'=>'getTglLahir(this)','placeholder'=>'Umur Pasien')
                            ));
                        ?>
                        <?php echo $form->error($model, 'umur'); ?>
                    </div>
                </div>

                        <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), 
                                    array('onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setNamaGelar()")); ?>
                        <?php echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),
                                    array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setNamaGelar()", )); ?>

                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
                                    array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>   
                        <div class="radio inline">
                            <div class="form-inline">
                            <?php echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), 
                                    array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
                            </div>
                       </div>
                        <?php echo $form->error($modPasien, 'golongandarah'); ?>
                        <?php echo $form->error($modPasien, 'rhesus'); ?>
                    </div>
                </div>
                        <?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('class'=>'span4 all-caps','onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'placeholder'=>'Alamat Pasien')); ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline')) ?>

                <div class="controls">
                    <?php echo $form->textField($modPasien,'rt', array('onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'class'=>'span1 numbersOnly','maxlength'=>3,'placeholder'=>'RT')); ?>   / 
                    <?php echo $form->textField($modPasien,'rw', array('onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'class'=>'span1 numbersOnly','maxlength'=>3,'placeholder'=>'RW')); ?>            
                    <?php echo $form->error($modPasien, 'rt'); ?>
                    <?php echo $form->error($modPasien, 'rw'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPasien,'no_telepon_pasien',array('class'=>'span4 numbersOnly','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'no_mobile_pasien <span style="color:red;"> * </span>', array('class'=>'control-label required')); ?>

                    <div class="controls">
                            <?php echo $form->textField($modPasien,'no_mobile_pasien',array('class'=>'span4 numbersOnly required','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
            </div>
            <div class="control-group">
				<?php echo $form->labelEx($modPasien,'propinsi_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPasien,'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
								array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
										'ajax'=>array('type'=>'POST',
													'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPasien))),
													'update'=>"#".CHtml::activeId($modPasien, 'kabupaten_id'),
										),
										'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
					<?php echo $form->error($modPasien, 'propinsi_id'); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($modPasien,'kabupaten_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPasien,'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
								array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
										'ajax'=>array('type'=>'POST',
													'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPasien))),
													'update'=>"#".CHtml::activeId($modPasien, 'kecamatan_id'),
										),
										'onchange'=>"setClearDropdownKelurahan();",));?>
					<?php echo $form->error($modPasien, 'kabupaten_id'); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($modPasien,'kecamatan_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPasien,'kecamatan_id', CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
								array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
										'ajax'=>array('type'=>'POST',
													'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($modPasien))),
													'update'=>"#".CHtml::activeId($modPasien, 'kelurahan_id'),
										),
										'onchange'=>"",));?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($modPasien,'kelurahan_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPasien,'kelurahan_id',CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
													  array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
					<?php echo $form->error($modPasien, 'kelurahan_id'); ?>
				</div>
			</div>
            <?php echo $form->dropDownListRow($modPasien,'agama', LookupM::getItems('agama'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modPasien,'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modPasien,'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modPasien,'warga_negara', LookupM::getItems('warganegara'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            
        </div>
    </div>
</fieldset>
<?php 
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modDataPasien = new PPPasienM('searchWithDaerah');
$modDataPasien->unsetAttributes();
if(isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
	$modDataPasien->propinsiNama = isset($_GET['PPPasienM']['propinsiNama'])?$_GET['PPPasienM']['propinsiNama']:'';
	$modDataPasien->kabupatenNama = isset($_GET['PPPasienM']['kabupatenNama'])?$_GET['PPPasienM']['kabupatenNama']:'';
	$modDataPasien->kecamatanNama = isset($_GET['PPPasienM']['kecamatanNama'])?$_GET['PPPasienM']['kecamatanNama']:'';
	$modDataPasien->kelurahanNama = isset($_GET['PPPasienM']['kelurahanNama'])?$_GET['PPPasienM']['kelurahanNama']:'';
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pasien-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modDataPasien->searchWithDaerah(),
	'filter'=>$modDataPasien,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectPasien",
				"onClick" => "
					$(\"#dialogPasien\").dialog(\"close\");
					$(\"#noRekamMedik\").val(\"$data->no_rekam_medik\");
					$(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");

					setJenisKelaminPasien(\"$data->jeniskelamin\");
					setRhesusPasien(\"$data->rhesus\");
					loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->pasien_id);
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
					$(\"dataPesan\").html(\'\');
					getRuanganberdasarkanRM(\"$data->no_rekam_medik\");
					$(\"#'.CHtml::activeId($model,'pasien_id').'\").val(\"$data->pasien_id\");
					$(\"#'.CHtml::activeId($modPasien,'no_rekam_medik').'\").val(\"$data->no_rekam_medik\");
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
			'value'=>'(isset($data->propinsi_id) ? $data->propinsi->propinsi_nama : "")',
		),
		array(
			'name'=>'kabupatenNama',
			'value'=>'(isset($data->kabupaten_id) ? $data->kabupaten->kabupaten_nama : "")',
		),
		array(
			'name'=>'kecamatanNama',
			'value'=>'(isset($data->kecamatan_id) ? $data->kecamatan->kecamatan_nama : "")',
		),
		array(
			'name'=>'kelurahanNama',
			'value'=>'(isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : "")',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end pasien dialog =============================
?>

<?php 
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddPropinsi',
    'options'=>array(
        'title'=>'Menambah data Provinsi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>350,
        'resizable'=>false,
    ),
));

echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end propinsi dialog =============================

// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKabupaten',
    'options'=>array(
        'title'=>'Menambah data Kabupaten',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKabupaten"></div>';
$this->endWidget();
//========= end kabupaten dialog =============================

// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKecamatan',
    'options'=>array(
        'title'=>'Menambah data Kecamatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKecamatan"></div>';
$this->endWidget();
//========= end kecamatan dialog =============================

// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKelurahan',
    'options'=>array(
        'title'=>'Menambah data Kelurahan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKelurahan"></div>';

$this->endWidget();
//========= end kelurahan dialog =============================
?>
<script type="text/javascript">
var enableInputPasien = '<?php isset($model->isPasienLama) ? 1 : 0; ?>';
if(enableInputPasien) {
    $('#fieldsetPasien input').attr('disabled','true');
    $('#fieldsetPasien select').attr('disabled','true');
    $('#fieldsetDetailPasien input').attr('disabled','true');
    $('#fieldsetDetailPasien select').attr('disabled','true');
    $('#PPPasienM_no_rekam_medik').removeAttr('disabled');
    $('#controlNoRekamMedik button').removeAttr('disabled');
    $('#fieldsetPasien button').attr('disabled','true');
}
else{
    $('#fieldsetPasien input').removeAttr('disabled');
    $('#fieldsetPasien select').removeAttr('disabled');
    $('#fieldsetDetailPasien input').removeAttr('disabled');
    $('#fieldsetDetailPasien select').removeAttr('disabled');
    $('#PPPasienM_no_rekam_medik').attr('disabled','true');
    $('#controlNoRekamMedik button').attr('disabled','true');
    $('#fieldsetPasien button').removeAttr('disabled');
}	
</script>