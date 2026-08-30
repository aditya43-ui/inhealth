<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Tambah Surat Rujukan Keluar</b></div>
    </div>
    <div class="panel-body">

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'rujukan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
            'focus' => '#',
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Rujukan berhasil disimpan !");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

        <?php echo $form->errorSummary($model); ?>

        <!--<div class="row-fluid">-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Pembuat Rujukan Keluar</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php echo $this->renderPartial('_formKunjungan', array('form' => $form, 'model' => $model, 'modInfoKunjungan' => $modInfoKunjungan,)); ?>
                </div>
            </div>
        </div>
        <br>
        <?php echo CHtml::textField('ppk_terdaftar', '', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'disabled' => true, 'style' => 'display:none')); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Rujukan</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php
                    echo $this->renderPartial('_formRujukan', array('form' => $form, 'model' => $model));
                    ?>
                </div>
            </div>
        </div>

        <!--</div>-->
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                $sukses = (isset($_GET['sukses']) ? $_GET['sukses'] : null);
                $disabledSave = (isset($_GET['id']) ? true : (($sukses == 1) ? true : false));
                ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'cekInput(1);return false;')); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl('index'),
                    array(
                        'class' => 'btn btn-danger',
                        'onclick' => 'return refreshForm(this);'
                    )
                ); ?>
                <?php
                if (Yii::app()->user->getState('isbridging')) {
                    if (isset($model->sep_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rujukan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRujukan();return false", 'disabled' => FALSE));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rujukan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. Rujukan!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    }
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print Rujukan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
                ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Rujukan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php $this->widget('UserTips', array('content' => '')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPoli',
    'options' => array(
        'title' => 'Referensi Poli BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('pendaftaranPenjadwalan.views.suratRujukan._pencarianPoliRujukan');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosaBpjs',
    'options' => array(
        'title' => 'Referensi Diagnosa BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('pendaftaranPenjadwalan.views.sepAsuransi._pencarianDiagnosa');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPpk',
    'options' => array(
        'title' => 'Referensi PPK Rujukan/Faskes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('pendaftaranPenjadwalan.views.suratRujukan._pencarianPpk');
$this->endWidget();
?>
<?php
echo $this->renderPartial('_jsFunctions', array('model' => $model));
?>

<script>
    $(document).ready(function() {
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>