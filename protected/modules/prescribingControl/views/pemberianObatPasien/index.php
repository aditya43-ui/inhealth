<?php
$this->breadcrumbs = array(
    'PCpemberianobatpasien Ts' => array('index'),
    'Create',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemberianobatpasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //        'focus'=>'#PCPendaftaranT_instalasi_id',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>
<div class="white-container">
    <legend class='rim2'>Pemberian <b>Obat Pasien</b></legend>
    <?php
    if (isset($_GET['sukses'])) {
        if ($_GET['sukses'] == 1) {
            Yii::app()->user->setFlash("success", "Tansaksi Pemberian Obat Pasien berhasil disimpan!");
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
    <fieldset class="box" id="form-datapemberianobat">
        <legend class="rim">Data Pemberian Obat</legend>
        <div class="row">
            <?php $this->renderPartial('_formDataPemberianObat', array('form' => $form, 'modPenjualan' => $modPenjualan, 'model' => $model)); ?>
        </div>
        <div class="block-tabel">
            <h6>Tabel <b>Obat</b></h6>
            <table class="items table table-striped table-condensed" id="table-detailpemesanan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Obat</th>
                        <th>Jumlah Pemakaian</th>
                        <th>Sisa Obat</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count((array)$modDetails) > 0) {
                        foreach ($modDetails as $i => $modDetail) {
                            echo $this->renderPartial('_rowDetailPemesanan', array('modDetail' => $modDetail));
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </fieldset>
    <div class='form-actions'>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array(
                'class' => 'btn btn-danger',
                'onKeypress' => 'return formSubmit(this,event)',
                'onsubmit' => '#',
                'id' => 'btn_simpan',
            )
        ); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')', 'disabled' => true));
        ?>

    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial('_jsFunctions'); ?>