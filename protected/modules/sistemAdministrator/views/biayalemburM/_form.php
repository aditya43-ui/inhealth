<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'biayalembur-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#BiayalemburM_biayalembur_nilai',
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'biayalembur_nama', array('placeholder' => 'Nama', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'biayalembur_nilai', array('placeholder' => 'Biaya Normal (per Jam)', 'class' => 'span3 integer2')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'biayalembur_nilailibur', array('placeholder' => 'Biaya Libur (per Jam)', 'class' => 'span3 integer2')); ?>
        <?php if (!$model->isNewRecord) : ?>
            <div class="control-group">
                <label class='control-label'></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'biayalembur_aktif'); ?>
                    <label for="BiayalemburM_biayalembur_aktif">Aktif</label>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="actions clear">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Biaya Lembur', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('biayalemburM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>