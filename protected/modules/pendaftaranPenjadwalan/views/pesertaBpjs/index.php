<?php
$this->breadcrumbs = array(
    'Pencarian Peserta BPJS',
);

$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> <b>Pencarian Peserta BPJS</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pencarian-peserta-bpjs-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formPencarian', array('form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data peserta
                </div>
            </div>
            <div class="panel-body" id="data-peserta">
                <?php $this->renderPartial($this->path_view . '_formDataPeserta', array('form' => $form)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true, 'onclick' => 'printPesertaBpjs(\'PRINT\')')); ?>
            <?php // echo CHtml::htmlButton(Yii::t('mds','Lihat Riwayat',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary btn-riwayat','type'=>'button','disabled'=>true,'onclick'=>'lihatRiwayat(\'PRINT\')')); 
            ?>
            <?php
            $content = $this->renderPartial('../tips/bpjs', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
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
<?php $this->renderPartial($this->path_view . '_riwayatPeserta', array()); ?>

</iframe>
<?php $this->endWidget(); ?>