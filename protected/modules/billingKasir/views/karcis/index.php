<style>
    .checked td {
        background-color: yellow !important;
    }
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tindakanpelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    //        'focus'=>'#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modTindakan); ?>

<?php echo $this->renderPartial("_formKarcis", array('form' => $form, 'format' => $format, 'modTindakan' => $modTindakan, 'modKarcisVs' => $modKarcisVs, 'dataTindakanKarcis' => $dataTindakanKarcis)) ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => FALSE));
    ?>
    <?php
    $content = $this->renderPartial('tips/tipsKarcis', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->renderPartial('_jsFunctions', array('modPendaftaran' => $modPendaftaran)); ?>
<?php $this->endWidget(); ?>