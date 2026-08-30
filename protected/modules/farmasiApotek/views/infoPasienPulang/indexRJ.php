<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Pasien Sudah Pulang - Rawat Jalan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Pasien Sudah <b>Pulang - Rawat Jalan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Search Patient'), 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'caripasien-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        Yii::app()->clientScript->registerScript('cariPasien', "
                    $('#caripasien-form').submit(function(){
                        $.fn.yiiGridView.update('pencarianpasien-grid', {
                            data: $(this).serialize()
                        });
                        return false;
                    });
                    ");
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked' => false, // whether this is a stacked menu
            'items' => array(
                array('label' => 'Pasien Rawat Jalan', 'url' => '', 'linkOptions' => array(), 'active' => true),
                array('label' => 'Pasien Rawat Darurat', 'url' => $this->createUrl('/farmasiApotek/infoPasienPulang/indexRD', array())),
                array('label' => 'Pasien Rawat Inap', 'url' => $this->createUrl('/farmasiApotek/infoPasienPulang/indexRI', array())),
            ),
        ));
        ?>
        <?php echo $this->renderPartial('_formCariRJ', array('model' => $modRJ, 'form' => $form, 'format' => $format,), true); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenjualanResep',
    'options' => array(
        'title' => 'Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1004,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePenjualanResep" width="100%" height="550">
</iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>
<!--/div-->