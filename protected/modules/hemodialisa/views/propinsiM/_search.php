<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'sapropinsi-m-search',
                 'type'=>'horizontal',
)); ?>
<br>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'propinsi_nama',array('class'=>'span3', 'maxlength'=>25)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'propinsi_namalainnya',array('class'=>'span3','maxlength'=>25)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'propinsi_aktif',array('checked'=>true)); ?> <label>Propinsi Aktif</label>
                </div>
            </div>
            <?php // echo  $form->checkBoxRow($model,'propinsi_aktif',array('checked'=>true)); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'propinsi_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
