<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'penerimaan-t-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($modPenerimaan,'nopenerimaan'),
)); ?>

<div class="row">
	<div class="col-sm-4">
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Penerimaan Kas','tglPenerimaanKas', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
					$modPenerimaan->tgl_awal = isset($modPenerimaan->tgl_awal) ? MyFormatter::formatDateTimeForUser($modPenerimaan->tgl_awal) : date('d M Y');
					$this->widget('MyDateTimePicker',array(
						'model'=>$modPenerimaan,
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
			<?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
					$modPenerimaan->tgl_akhir = isset($modPenerimaan->tgl_akhir) ? MyFormatter::formatDateTimeForUser($modPenerimaan->tgl_akhir) : date('d M Y');
					$this->widget('MyDateTimePicker',array(
									'model'=>$modPenerimaan,
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
	<div class="col-sm-4">
		<?php echo $form->textFieldRow($modPenerimaan,'nopenerimaan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>            
	</div>
	<div class="col-sm-4">
		<div class="control-group">
                <?php echo CHtml::label('Jenis Pengeluaran','jenisPengeluaran', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                          echo  $form->dropDownList($modPenerimaan,'jenispenerimaan_id',CHtml::listData(JenispenerimaanM::model()->findAll(),
								'jenispenerimaan_id','jenispenerimaan_nama'),array('class'=>'span2','style'=>"width:140px;",'empty'=>'-- Pilih --'));
                    ?>
                </div>
            </div>
	</div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            $this->createUrl($this->id.'/index'), 
            array('class' => 'btn btn-default',
                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php  
		$content = $this->renderPartial('../tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
