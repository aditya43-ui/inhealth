<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'etilogi-m-search',
	'type'=>'horizontal',
)); ?>
	<?php // echo $form->textFieldRow($model,'etilogi_id',array('class'=>'span3 numbers-only')); ?>

	<?php // echo $form->textFieldRow($model,'etilogi_kode',array('class'=>'span3','maxlength'=>10)); ?>

	<?php // echo $form->textFieldRow($model,'etilogi_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php // echo $form->textFieldRow($model,'etilogi_namalain',array('class'=>'span3','maxlength'=>100)); ?>

<br>
<table width="100%">
    <tr>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'etilogi_kode',array('class'=>'span3','maxlength'=>200)); ?>
        
            <?php echo $form->textFieldRow($model,'etilogi_nama',array('class'=>'span3')); ?>

        </div>
    
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'etilogi_namalain',array('class'=>'span3','maxlength'=>50)); ?>
            
        <div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'etilogi_aktif',array('checked'=>true)); ?> <label>Etiologi Aktif</label>
            </div>
        </div>
        </div>
        </td>
    </tr>
</table>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
