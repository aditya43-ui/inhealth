<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rekperiod-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'perideawal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; 
                ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'perideawal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //                                                        'minDate' => 'd',
                        //                                                            'maxDate'=>$minDate,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'sampaidgn', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; 
                ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'sampaidgn',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //                                                        'minDate' => 'd',
                        //                                                            'maxDate'=>$minDate,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->TextFieldRow($model, 'deskripsi', array('class' => 'span3', 'placeholder' => 'Deskripsi', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div class='control-group'>
            <?php echo CHtml::label("", 'isclosing', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isclosing', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label for="AKRekperiodM_isclosing">Closing</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>