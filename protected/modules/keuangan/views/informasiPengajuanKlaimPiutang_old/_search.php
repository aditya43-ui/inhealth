<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kupengklaimpiu-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nokaskeluar'),
)); ?>
<div class="row">
<div class="col-sm-6">
	<div class="control-group">
		<?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
		<?php echo CHtml::label('Tgl. Pengajuan','tglPengajuan', array('class'=>'control-label inline')) ?>
		<div class="controls">
			<?php   
				$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_awal',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
				)); 
			?>
		</div>
	</div>
	<div class="control-group">
		<?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
		<?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
		<div class="controls">
			<?php   
				$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_akhir',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'minDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
				)); 
			?>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<div class="control-group">
		<?php echo CHtml::label('Jenis Penjamin',' Jenis Penjamin', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
					'ajax' => array('type'=>'POST',
						'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'KUInformasipengajuanklaimpiutangV')), 
						'update'=>'#KUInformasipengajuanklaimpiutangV_penjamin_id'  //selector to update
					),
			 )); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('Penjamin',' Penjamin', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($model,'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
		</div>
	</div>
</div>
</div>			
            

	<div class="form-actions">
                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PenggajianpegT/Informasi'), array('class'=>'btn btn-danger')); ?>
							  	<?php
$content = $this->renderPartial('../tips/informasi_penggajianKaryawan',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
