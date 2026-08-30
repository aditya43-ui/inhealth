<?php

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekValidasi()'),
    'focus' => '#',
));
?>
<?php echo $this->renderPartial($this->path_view."statusSosial/_ekonomiSosial", array('model'=>$model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'form'=>$form),true);?>
<?php echo $this->renderPartial($this->path_view."statusSosial/_jsFunction", array('model'=>$model),true);?>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
    ?>
    <?php
    $tips = array(
        '0' => 'waktutime',
        '1' => 'autocomplete-search',
        '2' => 'simpan'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>