<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'shift-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'shift_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'shift_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'shift_aktif',array('checked'=>true)); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'shift_id',array('class'=>'span5')); ?>

	

	
<!--<div class="control-group">
            <?php //echo $form->labelEx($model, 'shift_jamawal', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php 
//            $this->widget('MyDateTimePicker',array(
//                                    'model'=>$model,
//                                    'attribute'=>'shift_jamawal',
//                                    'mode'=>'datetime',
//                                    'options'=> array(
//                                        'dateFormat'=>Params::DATE_FORMAT,
//                                    ),
//                                    'htmlOptions'=>array('readonly'=>true,
//                                                          'onkeypress'=>"return $(this).focusNextInputField(event)",
//                                                          'class'=>'dtPicker3',
//                                     ),
//            )); 
            ?> 
            </div>
        </div>
        <div class="control-group">
            <?php //echo $form->labelEx($model, 'shift_jamakhir', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php 
//            $this->widget('MyDateTimePicker',array(
//                                    'model'=>$model,
//                                    'attribute'=>'shift_jamakhir',
//                                    'mode'=>'datetime',
//                                    'options'=> array(
//                                        'dateFormat'=>Params::DATE_FORMAT,
//                                    ),
//                                    'htmlOptions'=>array('readonly'=>true,
//                                                          'onkeypress'=>"return $(this).focusNextInputField(event)",
//                                                          'class'=>'dtPicker3',
//                                     ),
//            )); ?> 
            </div>
        </div>-->

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
