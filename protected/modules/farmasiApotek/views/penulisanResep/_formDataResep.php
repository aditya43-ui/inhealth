<?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?> 

<div class="col-sm-6">
	<div class="control-group">
		<?php $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
		<?php echo $form->labelEx($modReseptur,'tglreseptur', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php   
					$this->widget('MyDateTimePicker',array(
									'model'=>$modReseptur,
									'attribute'=>'tglreseptur',
									'mode'=>'datetime',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
										'maxDate' => 'd',
										'yearRange'=> "-60:+0",
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
									),
			)); ?>
			<?php echo $form->error($modReseptur, 'tglreseptur'); ?>
		</div>
	</div>
	<?php echo $form->dropDownListRow($modReseptur,'pegawai_id',CHtml::listData($modReseptur->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
	<!--<div class="control-group">-->
		<?php // echo $form->labelEx($modReseptur,'noresep', array('class'=>'control-label')) ?>
		<!--<div class="controls">-->
			<?php if(!isset($_GET['reseptur_id'])){ ?>
				<?php // echo $form->textField($modReseptur,'noresep_belakang', array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:100px;'));?>
			<?php }else{ ?>
				<?php // echo $form->textField($modReseptur,'noresep', array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:100px;'));?>
			<?php } ?>
		<!--</div>-->
	<!--</div>-->
	
                
</div>
 <div class="col-sm-6">
                
				<?php // echo $form->dropDownListRow($modReseptur,'ruangan_id',CHtml::listData($modReseptur->ApotekRawatJalan, 'ruangan_id', 'ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'setOaByRuangTujuan(this)'));?>
</div>