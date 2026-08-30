<?php
$this->breadcrumbs = array(
    'Informasi Pasien Lama' => Yii::app()->request->getUrlReferrer(),
    'Ubah Pasien',
);
?>
<?php
$arrMenu = array();
//    array_push($arrMenu,array('label'=>Yii::t('mds','Update Patient Data'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
$this->menu = $arrMenu;
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ubahpasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#RKInfoPasienBaruV_jenisidentitas',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
$this->widget('bootstrap.widgets.BootAlert');

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Data Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <!-- <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body"> -->
        <?php echo $this->renderPartial('_formUbahPasien', array('model' => $model, 'form' => $form, 'modPegawai' => $modPegawai)); ?>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/infoPasienLamaV/admin'),
                array(
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
    </div>
    <!-- </div>
    </div> -->
</div>

<?php $this->endWidget(); ?>