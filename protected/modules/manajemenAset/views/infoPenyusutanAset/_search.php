<!--<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>-->
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'mapenyusutanaset-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'no_penyusutan'),
)); ?>
<div class="row-fluid">
	<div class="span6">
            <div class="control-group">		
                <?php echo CHtml::label('Tanggal Penyusutan Aset','tgl_penyusutan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
	</div>
	<div class="span6">	
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'no_penyusutan',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'no_penyusutan',array('placeholder'=>'Ketik No. Penyusutan Aset', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'barang_nama',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'barang_nama',array('placeholder'=>'Ketik Nama Barang', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
						$this->createUrl($this->id.'/index'), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php  
		$content = $this->renderPartial('/tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>  
</div>
<?php $this->endWidget(); ?>