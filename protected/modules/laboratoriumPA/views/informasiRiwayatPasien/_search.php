<?php 
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
    ));     
?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class='control-group'>
			<?php echo CHtml::label('No. Rekam medik','noRekamMedik', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>8)); ?>
			</div>
		</div> 		
	</div>
	<div class="col-sm-6">		
		<div class='control-group'>
			<?php echo CHtml::label('Nama Pasien','namaPasien', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			</div>
		</div> 
	</div>
</div>
	<!-- <div class="control-group ">
                <?php echo $form->labelEx($model,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_rm_awal',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                        ?>
                </div>
            </div> -->
	<!-- <div class="control-group ">
                <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 
                        $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_rm_akhir',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>    
                </div>
            </div> -->
	<?php //echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3', 'maxlength'=>20)); ?>
    <?php //echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); ?>
<div class="form-actions">
	<?php 
		echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
		array('class'=>'btn btn-primary', 'type'=>'submit')); 
	?>
	<?php 
		echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
		$this->createUrl($this->id.'/index'), 
		array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
		'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
	?>   
	<?php 
		$content = $this->renderPartial('laboratorium.views.tips.informasiRiwayatPasien',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
