<?php 
$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'nursestation-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "col-sm-6">
			<?php echo $form->textFieldRow($model,'nursestation_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'nursestation_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'nursestation_lokasi',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<br>
			<div class="control-group">
				<div class="controls">
					 <?php 
							$ruangan = array();
							if(count($modelnursekamar)>0){
								foreach($modelnursekamar as $value){
									$ruangan[] = $value->ruangan_id;
								}
							}
							$this->widget('application.extensions.emultiselect.EMultiSelect',
								array('sortable'=>true, 'searchable'=>true)
							);
							echo CHtml::dropDownList(
								'ruangan_id[]',
								$ruangan,
								CHtml::listData(RuanganM::model()->findAll('instalasi_id in ('.Params::INSTALASI_ID_RJ.', '.Params::INSTALASI_ID_RI.') AND ruangan_aktif IS TRUE order by instalasi_id, ruangan_nama'), 'ruangan_id', 'ruangan_nama'),
								array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
							);
					  ?>
				</div>
			</div>
		</div>
		<div class = "col-sm-6">
		<?php echo $form->textFieldRow($model,'nursestation_singkatan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
			<?php echo $form->textFieldRow($model,'nursestation_telp',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo CHtml::label('Nursestation PJ','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model,'nursestation_pj_id', array('readonly'=>true)) ?>
				<?php $this->widget('MyJuiAutoComplete', array(
					'name'=>'nama_pj', 
					'value'=>''.$model->nama_pj.'',
					 'source'=>'js: function(request, response) {
							$.ajax({
								url: "'.$this->createUrl('AutocompletePegawai').'",
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
						'focus'=> 'js:function( event, ui )
							{
							 $(this).val(ui.item.label);
							 return false;
							 }',
						'select'=>'js:function( event, ui ) {
							$(\'#SANursestationM_nursestation_pj_id\').val(ui.item.value);
							$(\'#nama_pj\').val(ui.item.label);
							 return false;
						 }',
					 ),
					 'htmlOptions'=>array(
						 'readonly'=>false,
						 'placeholder'=>'Nama Pegawai',
						 'size'=>13,
						 'onkeypress'=>"return $(this).focusNextInputField(event);",
					 ),
					 'tombolDialog'=>array('idDialog'=>'dialogpegawai'),
			 )); ?>
			</div><br><br>
			<?php echo $form->dropDownListRow($model, 'nursestation_filesuara', SARuanganM::getFileSuaraAntrian(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
			<?php echo $form->checkBoxRow($model,'nursestation_akitf', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		
		
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php 
			if(isset($_GET['id']) && !empty($_GET['id'])){
				echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('update',array('id'=>$_GET['id'])), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
			}else{
				echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
			}
		?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Nurse station',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<!-- ============================== Widget Dialog PJ =============================== -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogpegawai',
        'options'=>array(
            'title'=>'Pencarian Data Pegawai',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>400,
            'resizable'=>false,
        ),
    ));
    
    $modPegawai = new SAPegawaiM('searchDialog');
    $modPegawai->unsetAttributes();
    if (isset($_GET['SAPegawaiM'])) {
        $modPegawai->attributes = $_GET['SAPegawaiM'];
        $modPegawai->nama_pegawai = isset($_GET['SAPegawaiM']['nama_pegawai'])?$_GET['SAPegawaiM']['nama_pegawai']:null;
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'pegawai-grid',
        'dataProvider'=>$modPegawai->searchDialog(),
        'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectPegawai",
                                        "onClick" => "\$(\"#SANursestationM_nursestation_pj_id\").val($data->pegawai_id);
                                                              \$(\"#nama_pj\").val(\"$data->nama_pegawai\");
                                                              \$(\"#dialogpegawai\").dialog(\"close\")
                                                              submitruanganpegawai();"
                                ))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
					'filter'=>CHtml::activeTextField($modPegawai,'nomorindukpegawai'),
                ),
                array(
                    'header'=>'Nama Pegawai',
					'name'=>'nama_pegawai',
                    'type'=>'raw',
                    'value'=>'$data->NamaLengkap',
					//'filter'=>CHtml::activeTextField($model, 'pegawai_id', CHtml::listData(PegawaiM::getPegawaiItems(),'pegawai_id','nama_pegawai'),array('empty'=>'')),
					'filter'=>CHtml::activeTextField($modPegawai,'nama_pegawai'),
                ),  
			
			    array(
					'header'=>'Pendidikan',
					'name'=>'pendidikan_id',
					'type'=>'raw',
					'value'=>'isset($data->pendidikan->pendidikan_nama)? $data->pendidikan->pendidikan_nama : "" ',	 
					
				),  
			
			    array(
				    'header'=>'Jenis Kelamin',
				    'name'=>'jeniskelamin',
				    'type'=>'raw',
				    'value'=>'$data->jeniskelamin', 
					'filter'=>CHtml::activeTextField($modPegawai,'jeniskelamin'),
			    ), 
			
                array(
					'header'=>'Kelompok Pegawai',
					'name'=>'kelompokpegawai_id',
					'type'=>'raw',
					'value'=>'isset($data->kelompokpegawai->kelompokpegawai_nama)? $data->kelompokpegawai->kelompokpegawai_nama : ""',		
					
				),  
			
//			 array(
//					'header'=>'Jabatan',
//					'name'=>'jabatan_id',
//					'type'=>'raw',
//					'value'=>'$data->jabatan->jabatan_nama',			
//				), 
			  
                array(
                    'header'=>'Aktif',
                    'type'=>'raw',
                    'value'=>'(($data->pegawai_aktif)?"<span class=\'aktif_\'>Aktif</span>":"<span class=\'nonaktif_\'>Tidak Aktif</span>:")',
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>