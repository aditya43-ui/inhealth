<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzdiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#DietM_tipediet_id',
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'tipediet_id',
            CHtml::listData($model->TipeDietItems, 'tipediet_id', 'tipediet_nama'),
            array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'jenisdiet_id',
            CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
            array(
                'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'empty' => '-- Pilih --',
            )
        ); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'zatgizi_id', CHtml::listData($model->ZatgiziItems, 'zatgizi_id', 'zatgizi_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'diet_kandungan', array('placeholder' => 'Kandungan Gizi', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
    </div>
</div>



<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/dietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('dietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

</div>
<!--form-->