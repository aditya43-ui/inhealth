<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'updatePembersihan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )
);
?>
<p class="help-block">
    <?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Hasil Indikator
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('', 'sterilisasi_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pembersihan_id', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Selesai Pembersihan', 'selesaipembersihan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'selesaipembersihan',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                    )); ?>
                </div>
            </div>
            <?php echo $form->radioButtonListInlineRow($model, 'ind_visual', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>


            <?php echo $form->radioButtonListInlineRow($model, 'ind_kimia', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>


            <?php echo $form->radioButtonListInlineRow($model, 'ind_protein', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>

        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Keterangan', 'dekontaminasi_ket', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($model, 'ind_character', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan'));
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Selesai', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'button', 'onclick' => 'simpanSelesaiBersih();'));
    ?>
    <?php


    ?>


    <?php $this->endWidget(); ?>
    <?php

    echo CHtml::link(
        Yii::t('mds', '{icon} Cuci Ulang', array('{icon}' => '<i class="' . MyIcon::getIcons('ubah') . '"></i>')),
        Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/" . Yii::app()->controller->id . "/cuciUlang", array("pembersihan_id" => $pembersihan_id)),
        array('class' => 'btn btn-danger',)
    );
    ?>
</div>