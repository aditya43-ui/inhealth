<div class="search-form">
<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'pencarian-form',
		'type' => 'horizontal',
	));
?>
<div class="row">
    <div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Berkas Masuk', '', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php   
					$model->tgl_awal = (!empty($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : null);
					$this->widget('MyDateTimePicker',array(
						'model'=>$model,
						'attribute'=>'tgl_awal',
						'mode'=>'date',
						'options'=> array(
							'showOn' => false,
							'maxDate' => 'd',
							'dateFormat'=>Params::DATE_FORMAT,
							'yearRange'=> "-150:+0",
						),
						'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
						),
					));
					$model->tgl_awal = (!empty($model->tgl_awal) ? MyFormatter::formatDateTimeForDb($model->tgl_awal) : null);
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sampai dengan', '', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php   
					$model->tgl_akhir = (!empty($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : null);
					$this->widget('MyDateTimePicker',array(
						'model'=>$model,
						'attribute'=>'tgl_akhir',
						'mode'=>'date',
						'options'=> array(
							'showOn' => false,
							'maxDate' => 'd',
							'yearRange'=> "-150:+0",
							'dateFormat'=>Params::DATE_FORMAT,
						),
						'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
						),
					)); 
					$model->tgl_akhir = (!empty($model->tgl_akhir) ? MyFormatter::formatDateTimeForDb($model->tgl_akhir)  : null);
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::activeLabel($model, 'nosurat_rs',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($model,'nosurat_rs',array('class'=>'span3')); ?>
			</div>
		</div>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            $this->createUrl($this->id.'/index'), 
            array('class' => 'btn btn-default',
                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php  
		$content = $this->renderPartial('tips/tipsPencarian',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
</div>

