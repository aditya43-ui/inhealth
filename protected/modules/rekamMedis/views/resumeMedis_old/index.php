<?php
$this->breadcrumbs = array(
    'Transaksi Resume Medis',
);
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Resume Medis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemakaianbahp-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title" id="judul-form-datakunjungan">
                    <i class="glyphicon glyphicon-user"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Resume Medis
                </div>
            </div>
            <div class="panel-body" id="form-dataresume">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formResumeMedis', array('modKunjungan' => $modKunjungan, 'modResume' => $modResume)); ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'enabled' => 'true')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->module->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                    )
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Resume Medis Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => 'true'));
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->module->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                    )
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();return false", 'enabled' => 'true'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Resume Medis Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printResume();return false", 'enabled' => 'true'));
            }
            $content = $this->renderPartial($this->path_view . 'tips/tipsPemakaianBahan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modResume' => $modResume, 'dataDiagnosa' => $dataDiagnosa)); ?>
</div>