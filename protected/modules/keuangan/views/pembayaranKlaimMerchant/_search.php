<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'GET',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'
            ),
        )
    );
?>
<fieldset>
	<div class="row">
		<div class='col-sm-6'>
			<div class="control-group">
				<?php echo CHtml::label('Tgl. Bukti Bayar', 'tblbuktibayar',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php   
						$modTandabukti->tgl_awal = (!empty($modTandabukti->tgl_awal) ? MyFormatter::formatDateTimeForUser($modTandabukti->tgl_awal) : MyFormatter::formatDateTimeForUser(date('Y-m-d')));
						$this->widget('MyDateTimePicker',array(
							'name' => 'Filter[tgl_awal]',
							'model'=>$modTandabukti,
							'attribute'=>'tgl_awal',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
							),
							'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px; z-index:50;',
							),
						)); 
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Sampai Dengan', 'sampai dengan',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php   
						$modTandabukti->tgl_akhir = (!empty($modTandabukti->tgl_akhir) ? MyFormatter::formatDateTimeForUser($modTandabukti->tgl_akhir) : MyFormatter::formatDateTimeForUser(date('Y-m-d')));
						$this->widget('MyDateTimePicker',array(
							'name' => 'Filter[tgl_akhir]',
							'model'=>$modTandabukti,
							'attribute'=>'tgl_akhir',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
							),
							'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
							),
						)); 
					?>
				</div>
			</div>		
			<div class="control-group">
				<?php echo CHtml::label('Jenis Penjamin	 <span class="required">*</span>', 'cara bayar',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php 
						echo CHtml::activeDropDownList($modTandabukti,'carabayar_id', CHtml::listData($modTandabukti->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,
							array('style'=>'width:120px;','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
							'ajax' => array('type'=>'POST',
								'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'KUTandabuktibayarT')), 
								'update'=>'#KUTandabuktibayarT_penjamin_id'  //selector to update
							),
						)); 
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo CHtml::label('Penjamin <span class="required">*</span>', 'penjamin',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php 
						echo CHtml::activeDropDownList($modTandabukti,'penjamin_id', CHtml::listData($modTandabukti->getPenjaminItems($modPendaftaran->carabayar_id), 
						'penjamin_id', 'penjamin_nama') ,array('style'=>'width:120px;','empty'=>'-- Pilih --',
						'onkeypress'=>"return $(this).focusNextInputField(event)",)); 
					?>
				</div>
			</div>		
			<div class="control-group">
				<?php echo CHtml::label('Nama Bank Kartu', 'bankkartu',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
						echo CHtml::activeTextField($modTandabukti, 'bankkartu',array('class'=>'span3','placeholder'=>'Nama Bank'));
					?>
				</div>
			</div>
		</div>
	</div>
</fieldset> 
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onClick'=>'ajaxGetList();')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
</div>    
<?php $this->endWidget();?>