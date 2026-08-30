<?php $linkHalaman = CustomFunction::getUrlByMenuID(3563); ?>
<?php
$this->breadcrumbs = array(
    'Kebutuhan APD',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kebutuhan APD</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'kebutuhanapdkemenkes-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onsubmit' => 'return requiredCheck(this);'
            ),
            'focus' => '#',
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div style="margin-bottom: 17px;">
            <?php $this->renderPartial($this->path_view . '_formPencarian', array('form' => $form)); ?>
        </div>
        <?php $this->renderPartial($this->path_view . '_form', array('form' => $form)); ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'printData(\'PRINT\')')
            ); ?>
            <?php
            $tips = array(
                '0' => 'cari',
                '1' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>