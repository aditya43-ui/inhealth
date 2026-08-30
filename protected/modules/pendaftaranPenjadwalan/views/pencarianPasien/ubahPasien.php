<?php
$this->breadcrumbs = array(
    'Informasi Pencarian Pasien' => Yii::app()->request->getUrlReferrer(),
    'Ubah Pasien',
);
$arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update Patient Data'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
$this->menu = $arrMenu;
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ubahpasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#PPPasienM_jenisidentitas',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', "onsubmit" => "return requiredCheck(this);"),
));
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body" style="padding-top: 0;">
        <?php echo $this->renderPartial($this->path_view . '_formUbahPasien', array('format' => $format, 'model' => $model, 'form' => $form, 'modPendaftaran' => $modPendaftaran, 'modPegawai' => $modPegawai)); ?>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/pencarianPasien/cariPasien'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>

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
</div>

<?php $this->endWidget(); ?>