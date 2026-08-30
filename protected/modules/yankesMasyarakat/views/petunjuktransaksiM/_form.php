<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB    ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<link rel="stylesheet" href="assets/js/wysihtml5/bootstrap-wysihtml5.css">

<?php
$check = false;
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/wysihtml5/bootstrap-wysihtml5_custom2.js', CClientScript::POS_END);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'petunjuktransaksi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event);', 
        'onsubmit' => 'return requiredCheck(this);'),
    ));
?>
<style>
    .control-label{
        width: 200px;
    }
</style>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <?php echo $form->textFieldRow($model, 'petunjuktransaksi_type', array('readonly' => !empty($model->petunjuktransaksi_id) ? true : false, 'class' => 'span3 tipe', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <table class="table table-bordered table-condensed" id="tablePetunjuk">
        <thead>
            <th style="text-align: center"> Nama </th>
            <th style="text-align: center"> Deskripsi </th>
            <th style="text-align: center"> Gambar </th>
            <th style="text-align: center; width: 5%"> Urutan </th>
            <th style="text-align: center"> Aktif </th>
            <th style="text-align: center;  width: 10%"> Aksi</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Petunjuk Penggunaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php 
//$modDetail = new PetunjuktransaksiM();
$this->renderPartial('_jsFunction', array('model' => $model, 'modDetail' => $modDetail, 'form' => $form)); ?>
