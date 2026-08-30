<?php
$this->breadcrumbs = array(
    'Informasi Jadwal Dokter',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Informasi <b>Jadwal Dokter</b>
        </div>
    </div>
    <div class="panel-body">
        <div class='block-tabel' style="margin-top: 17px;">
            <?php $this->renderPartial('_search', ['bulanPilih' => $bulanPilih]) ?>
        </div>
        <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'carijadwal-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'method' => 'POST',
                'action' => $this->createUrl('index'),
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            ));
        ?>
        <div class='block-tabel' id="table-jadwal-poliklinik" style="margin-top: 17px;">
            <?php echo $kalenderJadwal; ?>
        </div>
        <div class="form-action">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'class' => 'btn btn-danger', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    'id' => 'btn_simpan',
                )
            ); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>