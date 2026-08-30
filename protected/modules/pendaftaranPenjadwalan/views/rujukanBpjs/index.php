<?php
$this->breadcrumbs = array(
    'Pencarian Rujukan BPJS',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="white-container">
    <legend class="rim2">Pencarian <b>Rujukan BPJS</b></legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pencarian-rujukan-bpjs-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event);',
            'onsubmit' => 'return requiredCheck(this);'
        ),
        'focus' => '#',
    ));
    ?>

    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data Pemesanan Kamar berhasil dibuat !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php
    $this->widget('bootstrap.widgets.BootTabbable', array(
        'type' => 'tabs',
        'placement' => 'above', // 'above', 'right', 'below' or 'left'
        'tabs' => array(
            array('label' => 'Rujukan FKTP', 'content' => $this->renderPartial('_formFKTP', array('form' => $form), true)),
            array('label' => 'Rujukan FKTL', 'content' => $this->renderPartial('_formFKTL', array('form' => $form), true)),
        ),
        //				'htmlOptions'=>array('onclick'=>'setTab(this);')
    ));
    ?>

    <fieldset class="box" id="data-peserta">
        <legend class="rim">Data Peserta</legend>
        <?php $this->renderPartial($this->path_view_peserta . '_formDataPeserta', array('form' => $form)); ?>
    </fieldset>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true, 'onclick' => 'printRujukanBpjs(\'PRINT\')')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', 'Lihat Riwayat', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary btn-riwayat', 'type' => 'button', 'disabled' => true, 'onclick' => 'lihatRiwayat(\'PRINT\')')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>
<?php
// Dialog untuk Melihat 10 riwayat terakhir peserta BPJS =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPesertaBpjs',
    'options' => array(
        'title' => '10 Riwayat Terakhir Peserta',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));
?>
<?php $this->renderPartial($this->path_view_peserta . '_riwayatPeserta', array()); ?>

</iframe>
<?php $this->endWidget(); ?>