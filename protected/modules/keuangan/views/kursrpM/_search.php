<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kursrp-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'matauang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList(
                    $model,
                    'matauang_id',
                    CHtml::listData($model->MataUangItems, 'matauang_id', 'matauang'),
                    array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)
                );
                ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'tglkursrp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; 
                ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkursrp',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //                                                        'minDate' => 'd',
                        //                                                                'maxDate'=>$minDate,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3',),
                ));
                ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->checkBoxRow($model, 'kursrp_aktif', array('checked' => 'checked')); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'nilai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilai', array('placeholder' => '00', 'class' => 'span2 integer2')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'rupiah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'rupiah', array('placeholder' => '00', 'class' => 'span2 integer2',)); ?>
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