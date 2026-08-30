
<!--<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>-->
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'mapenyusutanaset-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'reevaluasiaset_no'),
)); ?>
<div class="row-fluid">
	<div class="span6">
            <div class="control-group">		
                <?php echo CHtml::label('Tanggal Re-evaluasi','reevaluasiaset_tgl', array('class'=>'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>

	</div>
	<div class="span6">	
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'reevaluasiaset_no',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'reevaluasiaset_no',array('placeholder'=>'Ketik No. Re-evaluasi Aset', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrow-ccw"></i>')), 
						$this->createUrl($this->id.'/index'), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php  
		$content = $this->renderPartial('/tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>  
</div>
<?php $this->endWidget(); ?>