<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenistransfusi-m-search',
	'type'=>'horizontal',
)); ?>
<br>
    <?php echo $form->textFieldRow($model,'jenistransfusi_nama',array('class'=>'span3','maxlength'=>50)); ?>

    <?php echo $form->textFieldRow($model,'jenistransfusi_namalain',array('class'=>'span3','maxlength'=>50)); ?>

    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
    </div>

<?php $this->endWidget(); ?>
