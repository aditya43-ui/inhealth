<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppruangan-m-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'ruangan_nama'),
)); ?>
<table eidth="100%">
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'ruangan_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'ruangan_nama',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'ruangan_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
        
	
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
