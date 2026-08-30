<?php $form_todolist=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'todolistupdate-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<div class="form-horizontal" style="padding:3px;">
        <div class="row-fluid box">
            <?php echo $form_todolist->hiddenField($modTodolist,'todolist_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="col-md-6">
                <?php echo $form_todolist->textField($modTodolist,'todolist_nama',array('class'=>'span3', 'placeholder'=>'Ketikkan todo list', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-md-6">
                    <?php   
                    $modTodolist->tgltodolist = (!empty($modTodolist->tgltodolist) ? date("d/m/Y",strtotime($modTodolist->tgltodolist)) : null);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$modTodolist,
                                            'attribute'=>'tgltodolist',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'showOn' => false,
                                                'minDate' => 'd',
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 form-control datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    ));
                    ?>
            </div>
            <div style="float:right;">
                <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),array('class'=>'btn btn-primary','onclick'=>'updateTodolist();')); ?>
            </div>
             <?php //echo $form_todolist->checkBoxRow($modTodolist,'todolist_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
    
<?php $this->endWidget(); ?>

