<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'konfigemail-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#' . CHtml::activeId($model, 'konfigemail_host'),
)); ?>



<?php echo $form->errorSummary($model); ?>
<?php

$this->widget('bootstrap.widgets.BootAlert');

?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'konfigemail_send_type', LookupM::getItems("email_sendtype"), array('onchange' => 'cekTipeKirim(this);')); ?>

        <?php echo $form->dropDownListRow($model, 'konfigemail_email_type', LookupM::getItems("email_type"), array('empty' => '-- Pilih --')); ?>
    </div>

    <div class="col-sm-6">
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'konfigemail_host', array('class' => 'span3', 'maxlength' => 100, 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_host'))); ?>

        <?php echo $form->textFieldRow($model, 'konfigemail_port', array('class' => 'span3 numbers-only', 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_port'))); ?>

        <?php echo $form->textFieldRow($model, 'konfigemail_username', array('class' => 'span3', 'maxlength' => 100, 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_username'))); ?>

        <?php echo $form->textFieldRow($model, 'konfigemail_password', array('class' => 'span3', 'maxlength' => 100, 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_password'))); ?>

        <?php echo $form->textFieldRow($model, 'konfigemail_oauth_id', array('class' => 'span3', 'maxlength' => 100, 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_username'))); ?>

        <?php echo $form->textFieldRow($model, 'konfigemail_oauth_pass', array('class' => 'span3', 'maxlength' => 100, 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_username'))); ?>

    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("", 'konfigemail_ishtml', array('class' => 'control-label', 'rel' => 'tooltip')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'konfigemail_ishtml', array('rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_ishtml'))); ?> <label>HTML</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'konfigemail_smtp_auth', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'konfigemail_smtp_auth', array('rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_smtp_auth'))); ?> <label>SMTP Auth</label>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'konfigemail_smtp_secure', array('tl' => 'TLS', 'ssl' => 'SSL'), array('-- Pilih --', 'class' => 'span3 required', 'maxlength' => 20, "data-toggle" => "tooltip", "data-placement" => "top", "title" => "", "data-original-title" => CustomFunction::getAttributeTooltip($model, 'konfigemail_smtp_secure'), 'data-html' => true)); // 
        ?>

        <?php echo $form->textFieldRow($model, 'konfigemail_oauth_email', array('class' => 'span3', 'maxlength' => 100, 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_username'))); ?>
        <?php echo $form->textFieldRow($model, 'konfigemail_oauth_type', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100, 'rel' => 'tooltip', 'title' => CustomFunction::getAttributeTooltip($model, 'konfigemail_username'))); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    //            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Sistem', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php echo $this->renderPartial('js/_jsFunctions', array('model' => $model), true); ?>