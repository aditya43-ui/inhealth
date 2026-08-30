<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/literallycanvas/css/literallycanvas.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/react/build/react-with-addons.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/literallycanvas/js/literallycanvas-core.min.js'); ?>
<style>

    .judul_form {
        font-size: 20pt;
        text-align: center;
        margin-bottom: 50px;
    }

</style>

<div class="judul_form">DAFTAR SURAT ELIGIBILITAS PASIEN BPJS</div>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'daftar-mandiri-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'form_pendaftaran'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);','onKeyPress' => 'return disableKeyPress(event);', 
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUtama', array(
    'form'=>$form,
), true); ?>
<?php echo $this->renderPartial('_formBPJS', array(
    'form'=>$form,
    'modSep'=>$modSep,
    'modAsuransiPasien'=>$modAsuransiPasien,
    'model'=>$model,
    'modPasien'=>$modPasien,
    'modRujukanBpjs'=>$modRujukanBpjs,
), true); ?>

<?php $this->endWidget(); ?>