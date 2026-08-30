<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpperjalanandinas-r-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'perjalanandinas_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nourutperj',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tujuandinas',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textAreaRow($model,'tugasdinas',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'descdinas',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'alamattujuan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'propinsi_nama',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'kotakabupaten_nama',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'tglmulaidinas',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sampaidengan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'negaratujuan',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
				<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.perjalanandinasR.'/informasi'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
							  	<?php
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
	</div>

<?php $this->endWidget(); ?>
