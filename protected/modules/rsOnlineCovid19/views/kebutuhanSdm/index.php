<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Kebutuhan SDM</b></div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'kebutuhansdmkemenkes-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onsubmit' => 'return requiredCheck(this);'
            ),
            'focus' => '#',
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial($this->path_view . '_form', array('form' => $form)); ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'printData(\'PRINT\')')); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>