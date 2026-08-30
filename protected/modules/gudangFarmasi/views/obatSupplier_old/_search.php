<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfsupplier-m-search',
        'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model,'supplier_kode',array('class'=>'span2','maxlength'=>10)); ?>
	<?php echo $form->textFieldRow($model,'supplier_nama',array('class'=>'span3','maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'obatalkes_nama',array('class'=>'span3','maxlength'=>100)); ?>
        <?php echo CHtml::label('Aktif','supplier_aktif', array('class'=>'control-label')) ?>
        &nbsp;
	<?php echo $form->checkBox($model,'supplier_aktif',array('checked'=>'supplier_aktif')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textAreaRow($model,'supplier_alamat',array('rows'=>4, 'cols'=>30, 'class'=>'span3')); ?>
    </div>
</div>
	<?php //echo $form->textFieldRow($model,'supplier_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'supplier_namalain',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_propinsi',array('class'=>'span2','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_kabupaten',array('class'=>'span2','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_telp',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_fax',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_kodepos',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_npwp',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_website',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_email',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'supplier_cp',array('class'=>'span5','maxlength'=>100)); ?>
        
        

	<div class="form-actions">
            <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
