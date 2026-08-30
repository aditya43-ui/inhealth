<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengirimanrm-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary(array($modUbahStatus)); ?>
    
	<div class="row">
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo $form->labelEx($modUbahStatus,'tglpengirimanrm', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
						$this->widget('MyDateTimePicker',array(
							'model'=>$modUbahStatus,
							'attribute'=>'tglpengirimanrm',
							'mode'=>'datetime',
							'options'=> array(
							),
							'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','placeholder'=>'00:00:0000 00:00:00'),
						));
					?>
					<?php echo $form->error($modUbahStatus, 'tglpengirimanrm'); ?> 
				</div>
			</div>
			
			<div class="control-group">
				<?php echo CHtml::label('Instalasi Tujuan <span style ="color:red;">*</span>', 'instalasi_id', array('class'=>'control-label')); ?>
				 <div class="controls">
					 <?php
                        echo $form->dropDownList($modUbahStatus, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(" instalasi_aktif = TRUE ORDER BY instalasi_nama ASC "), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style'=>'width:200px;',
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modUbahStatus))),
                                'update' => '#' . CHtml::activeId($modUbahStatus, 'ruangan_id') . ''),));
                        ?>
				 </div>
			 </div>
			
			<div class="control-group">
				<?php echo CHtml::label('Ruangan Tujuan <span style ="color:red;">*</span>', 'ruangan_id', array('class'=>'control-label')); ?>
				 <div class="controls">
					 <?php echo $form->dropDownList($modUbahStatus, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$modUbahStatus->instalasi_id,'ruangan_aktif'=>true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 required', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>				 
					 <?php echo $form->error($modUbahStatus, 'ruangan_id'); ?>
				 </div>
			 </div>
			
			<div class="control-group">
                <?php echo CHtml::label('Petugas Pengirim', 'petugaspengirim_id', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php //echo CHtml::textField('petugaspengirim_id','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                    <?php echo $form->hiddenField($modUbahStatus,'petugaspengirim_id',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                    <?php //echo CHtml::activeHiddenField($modUbahStatus,'petugaspengirim','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                     <?php echo $form->textField($modUbahStatus,'petugaspengirim',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php 
                  /*  $this->widget('MyJuiAutoComplete', array(
                        'name'=>'petugaspengirim_nama',
                        'source'=>'js: function(request, response) {
                                       $.ajax({
                                           url: "'.$this->createUrl('AutocompletePetugas').'",
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
                                    $(this).val("");
                                    return false;
                                }',
                               'select'=>'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    $("#petugaspengirim_id").val(ui.item.pegawai_id);
                                    $("#petugaspengirim_nama").val(ui.item.nama_pegawai);
                                    $("#'.CHtml::activeId($modUbahStatus,'petugaspengirim_id').'").val(ui.item.pegawai_id);
                                    $("#'.CHtml::activeId($modUbahStatus,'petugaspengirim').'").val(ui.item.nama_pegawai);
                                    return false;
                                }',
                        ),
                        'htmlOptions'=>array(
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#petugaspengirim_id").val(""); '
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogPetugas'),
                    )); */
                    ?>
                </div>
            </div>
		</div>
		<div class="col-sm-6">
			
		</div>
	</div>
        
    <div class="form-actions">
         <?php 
			if ($status == false){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
					array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
					array('class' => 'btn btn-danger', 'type'=>'button','disabled'=>true)); 
			}
			?>

        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
				array('class' => 'btn btn-default','onclick'=>"window.parent.$('#dialogStatusDokumen').dialog('close');")); ?>
    </div>
<?php $this->endWidget(); ?>
<?php
    //========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPetugas',
        'options' => array(
            'title' => 'Daftar Petugas Pengirim',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));

    $modPegawai = new RDPegawaiM('search');
    $modPegawai->unsetAttributes();
    if (isset($_GET['RDPegawaiM']))
        $modPegawai->attributes = $_GET['RDPegawaiM'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'petugaspengirim-m-grid',
        'dataProvider' => $modPegawai->searchDialog(),
        'filter' => $modPegawai,
        'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($modUbahStatus, 'petugaspengirim') . '\').val(\'$data->NamaLengkap\');
						$(\'#' . Chtml::activeId($modUbahStatus, 'petugaspengirim_id') . '\').val(\'$data->pegawai_id\');
						$(\'#petugaspengirim_id\').val(\'$data->pegawai_id\');
						$(\'#petugaspengirim\').val(\'$data->NamaLengkap\');
						$(\'#petugaspengirim_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogPetugas\').dialog(\'close\');
						return false;"))',
            ),
            'nama_pegawai',
            'nomorindukpegawai',
            'alamat_pegawai',
            'agama',
            array(
                'name' => 'jeniskelamin',
                'filter' => LookupM::getItems('jeniskelamin'),
                'value' => '$data->jeniskelamin',
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>

	
<script>
	$(document).ready(function(){
		if (<?php echo $status ?> == true){
			setTimeout("window.parent.$('#dialogStatusDokumen').dialog('close');",500);			
		}
	});
</script>