<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sep-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert'); ?>

<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                        ?></p>
<?php echo $form->errorSummary(array($modSep)); ?>

<div class="row-fluid">
    <div class="span12">
        <div class="control-group ">
            <?php $modSep->tglpulang = (!empty($modSep->tglpulang) ? date("d/m/Y H:i:s", strtotime($modSep->tglpulang)) : null); ?>
            <?php echo $form->labelEx($modSep, 'tglpulang', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modSep,
                    'attribute' => 'tglpulang',
                    'mode' => 'datetime',
                    'options' => array(),
                    'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'placeholder' => '00:00:0000 00:00:00'),
                ));
                ?>
                <?php echo $form->error($modSep, 'tglpulang'); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>

    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-danger', 'onclick' => "window.parent.$('#dialogUbahTanggalPulang').dialog('close');")
    ); ?>
</div>
<?php $this->endWidget(); ?>