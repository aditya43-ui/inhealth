<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rencana-t-search',
		'type'=>'horizontal',
		'focus'=>'#'.CHtml::activeId($model,'norenpengembalian'),
)); ?> 
<fieldset class="box">
	<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
	<table style="width: 100%; border: none;">
		<tr>
			<td>
				<div class="control-group">
						<?php echo CHtml::label('Tgl. Rencana','tgl_awal', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php   
									$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
									$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_awal',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
									)); 
									$model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
								?>
							</div>
					</div>
				<div class="control-group">
						<?php echo CHtml::label('Sampai Dengan','tgl_akhir', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php   
									$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
									$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_akhir',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
									)); 
									$model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
								?>
							</div>
				</div>
			</td>
			<td>
				<?php echo $form->textFieldRow($model,'norenpengembalian',array('placeholder'=>'No. Rencana','class'=>'numberOnly')); ?>

				<?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->getRuanganByInstalasi(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
						array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
						'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>

			</td>
		</tr>
	</table>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); ?><?php
		   $content = $this->renderPartial('../tips/informasi_gudangfarmasi',array(),true);
		   $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>
</div>