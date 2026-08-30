<?php
$this->breadcrumbs = array(
    'PCevaluasipemberianobat Ts' => array('index'),
    'Create',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'evaluasipemberianobat-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //        'focus'=>'#PCPendaftaranT_instalasi_id',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>
<div class="white-container">
    <legend class="rim2">Evaluasi Pemberian <b>Obat Pasien</b></legend>
    <?php
    if (isset($_GET['sukses'])) {
        if ($_GET['sukses'] == 1) {
            Yii::app()->user->setFlash("success", "Tansaksi Evaluasi Pemberian Obat Pasien berhasil disimpan!");
        }
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <fieldset class="box" id="form-infopasien">
        <legend class="rim">Data Pasien
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setInfoPasienReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
        </legend>
        <div class="row">
            <?php $this->renderPartial('_formInfoPasien', array('modInfoRI' => $modInfoRI)); ?>
        </div>
    </fieldset>
    <fieldset id="form-infoobat">
        <?php $this->renderPartial('hasilEvaluasi'); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial('_jsFunctions'); ?>