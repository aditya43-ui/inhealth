<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rjpasiennapza-t-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pasiennapza_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'detailnapza_id',array('class'=>'span1')); ?>

	<?php echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span2')); ?>

	<?php echo $form->textFieldRow($model,'pasien_id',array('class'=>'span2')); ?>

	<?php echo $form->textFieldRow($model,'tglperiksanapza',array('class'=>'span2')); ?>

	<?php echo $form->textFieldRow($model,'kunjunganke',array('class'=>'span2')); ?>

	<?php //echo $form->textFieldRow($model,'metodenapza',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textAreaRow($model,'keteranganmetode',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textAreaRow($model,'hasilpemeriksaannapza',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textAreaRow($model,'catatannapza',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'lamarehabilitasi',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'satuanlama',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'paramedis_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'dokter_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
						<?php 
           $content = $this->renderPartial('../tips/tips',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
	</div>

<?php $this->endWidget(); ?>
