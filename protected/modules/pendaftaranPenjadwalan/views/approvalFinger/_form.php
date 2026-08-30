<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'assep-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    'focus' => '#',
)); ?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Approval berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<!--<div class="row-fluid">-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo CHtml::checkBox('collapsed', false, array('class' => 'collapsedPanel','onclick' => 'collapsedPanel(this, "panel-data-kunjungan")')); ?>
            Data Pencarian Pasien
        </div>
    </div>
    <div class="panel-body" id="panel-data-kunjungan">
        <div class="row-fluid">
            <?php echo $this->renderPartial('_formRekamMedik_new', array('form' => $form, 'model' => $model, 'modInfoKunjungan' => $modInfoKunjungan,)); ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pengajuan Approval</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid" id="panel-data-pengajuan-approval">
            <?php echo $this->renderPartial('_formApproval2', array('form' => $form, 'model' => $model)); ?>
        </div>
    </div>
</div>

<!--</div>-->
<div class="row-fluid">
    <div class="form-actions">
        <?php
        $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
        //$disabledSave = isset($_GET['id']) ? false : (($sukses == 1) ? false : false);
        if (isset($_GET['sukses'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true, 'onclick' => 'cekInput(this,13);return false;'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'onKeypress' => 'return', 'disabled' => false, 'onclick' => 'cekInput(this,13);return false;'));
        }
        ?>
        <?php //echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false, 'onclick' => 'cekInput(this,13);return false;')); 
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array(
                'class' => 'btn btn-danger',
                'onclick' => 'if(!confirm("' . Yii::t('mds', 'Anda yakin akan mengulang?') . '")) return false;'
            )
        ); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Approval', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
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
echo $this->renderPartial('_pencarianPoli');
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
echo $this->renderPartial('_pencarianDiagnosa');
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
echo $this->renderPartial('_pencarianPpk');
$this->endWidget();
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