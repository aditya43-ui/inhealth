<?php $form_todolist = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'todolistupdate-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="form-horizontal" style="padding:3px;">
    <div class="row box">
        <?php echo $form_todolist->hiddenField($modTodolist, 'todolist_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div style="float:left;">
            <?php echo $form_todolist->textField($modTodolist, 'todolist_nama', array('class' => 'span3', 'placeholder' => 'To Do List', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="control-group " style="float:left;">
            <?php $modTodolist->tgltodolist = MyFormatter::formatDateTimeForUser($modTodolist->tgltodolist); ?>
            <?php echo $form_todolist->labelEx($modTodolist, 'tgltodolist', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modTodolist,
                    'attribute' => 'tgltodolist',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'minDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span16', 'class' => 'dtPicker2 reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form_todolist->error($modTodolist, 'tgltodolist'); ?>
            </div>
        </div>
        <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),array('class'=>'btn btn-primary','onclick'=>'updateTodolist();')); 
        ?>
        <?php //echo $form_todolist->checkBoxRow($modTodolist,'todolist_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>