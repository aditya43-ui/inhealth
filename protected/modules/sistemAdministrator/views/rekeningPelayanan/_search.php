<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'saruangan-m-search',
    'type'=>'horizontal',
)); ?>
<div class="row">
    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model,'instalasi_nama',array('class'=>'span3','maxlength'=>50)); ?>

    <?php //echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span3','maxlength'=>50)); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Uraian Tindakan",'daftartindakan_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'daftartindakan_nama',array('class'=>'span3','maxlength'=>50)); ?>
            </div>
        </div>
    </div>
	<?php //echo $form->textFieldRow($model,'ruangan_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<?php // echo $form->textFieldRow($model,'ruangan_lokasi',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->checkBoxRow($model,'ruangan_aktif',array('checked'=>'ruangan_aktif')); ?>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
