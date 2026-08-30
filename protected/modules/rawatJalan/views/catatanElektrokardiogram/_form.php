<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'catatanedukasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
    ));
?>

<?php echo $form->errorSummary($model); ?>


<?php echo $this->renderPartial($this->path_view."_riwayat", array(
    'riwayat'=>$riwayat,'pendaftaran'=>$pendaftaran,
), true); ?>
<br>
<?php echo $this->renderPartial($this->path_view."_dataEkg", array(
      'form' => $form, 'model'=>$model,'pendaftaran'=>$pendaftaran,
), true); ?>

<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id' => 'btn-simpan', 'class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => isset($_GET['sukses']) ? true : false )); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
            $this->createUrl('create'),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
        ?>
        <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan CatatanedukasiT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>