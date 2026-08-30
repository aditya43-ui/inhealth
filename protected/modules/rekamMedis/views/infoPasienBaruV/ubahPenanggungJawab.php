<?php
$this->breadcrumbs = array(
    'Informasi Pasien Baru' => Yii::app()->request->getUrlReferrer(),
    'Ubah Penanggung Jawab',
);
?>
<?php
$arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update Person in Charge of Patients'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
$this->menu = $arrMenu;
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ubahpenanggungjawabpasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#PenanggungjawabM_pengantar',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Penanggung Jawab</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_formUbahPenanggungJawab', array('model' => $model, 'form' => $form)); ?>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/infoPasienBaruV/admin'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>