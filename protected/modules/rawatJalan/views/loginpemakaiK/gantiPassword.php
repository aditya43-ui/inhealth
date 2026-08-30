<?php
$this->breadcrumbs = array(
    'Ganti Kata Kunci',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-key"></i> Ganti <b>Kata Kunci</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'loginpemakai-k-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#LoginpemakaiK_old_password',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $form->errorSummary($model);
                ?>
                <?php
                echo $form->textFieldRow($model, 'nama_pemakai', array('class' => 'span3', 'readonly' => true));
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'old_password', array('class' => 'control-label required')); ?>
                    <div class="controls">
                        <?php echo $form->passwordField($model, 'old_password', array('placeholder' => 'Kata Kunci Lama', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200)); ?><?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array('class' => 'btn btn-default', 'data-title' => Yii::t('mds', 'Tips'), 'data-content' => Yii::t('mds', 'fill this field in case to change the password'), 'rel' => 'popover')); ?>
                        <?php echo $form->error($model, 'old_password'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php
                echo $form->passwordFieldRow($model, 'new_password', array('placeholder' => 'Kata Kunci Baru', 'class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200));
                echo $form->passwordFieldRow($model, 'new_password_repeat', array('placeholder' => 'Ulangi Kata Kunci', 'class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50));
                echo CHtml::hiddenfield('prevUrl', $prevUrl);
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->request->getUrlReferrer(),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_old_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;
Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);
?>