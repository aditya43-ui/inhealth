<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'logindialog',
    'options' => array(
        'title' => 'Login Penyedia',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => false,
    ),
));
?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'loginform')); ?>
<div class="control-group ">
    <?php echo CHtml::label('Nama Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo CHtml::hiddenField('persiapanpengadaan_id', '', array()); ?> 
    </div>
</div>

<div class="control-group ">
    <?php echo CHtml::label('Kata Kunci', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'submitLogin("'.$id.'");return false;', 'onkeypress' => 'submitLogin("'.$id.'");return false;'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-ban-circle icon-white"></i>')), '#', array('class' => 'btn btn-danger', 'onclick' => "$('#logindialog').dialog('close');return false", 'disabled' => false)); ?>
</div> 
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>