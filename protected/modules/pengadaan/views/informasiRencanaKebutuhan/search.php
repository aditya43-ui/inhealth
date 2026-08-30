<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rencana-t-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'noperencnaan'),
)); ?> 
	<div class="row-fluid">
		<div class="col-sm-6">
			<div class="control-group">		
				<?php echo CHtml::label("Tanggal Rencana",'tglRencanaKebutuhan', array('class' => 'control-label')) ?>
				<div class="controls">
					<div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
						<i class="entypo-calendar"></i>
						<span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
						<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
						<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
					</div>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'noperencnaan',array('placeholder'=>'Ketik No. Rencana','class'=>'numberOnly span3')); ?>
		</div>
		<div class="col-sm-6">
                     <div class = "control-group">
				<?php echo CHtml::label('Sumber Dana', 'sumberdana_id', array('class'=>'control-label')) ?>
				<div class = "controls">
					<?php echo $form->dropDownList($model, 'sumberdana_id', Chtml::ListData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE"),'sumberdana_id','sumberdana_nama'),array('empty'=>'-- Pilih --','class'=>'span3'))?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'statusrencana', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'statusrencana',LookupM::getItems('statusrencana'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
				</div>
			</div>
		</div>
	</div>      
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); echo "&nbsp;"; ?><?php
			$content = $this->renderPartial('pengadaan.views/tips/informasi_pengadaan',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
    </div>
	<?php $this->endWidget(); ?>
</div>