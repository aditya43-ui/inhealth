<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan sebagai view utama untuk memilih transaksi mana yang akan dilanjutkan skala nyeri, observasi donor darah atau kantong darah
 * RSST-1498
 */
?>
<?php $linkHalaman = CustomFunction::getUrlByMenuID(3585); ?>
<style>
    .control-label {
        text-align: left !important;
        vertical-align: top !important;
    }

    #data-seleksi .span2,
    #tandavital .span2 {
        width: 99px !important;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Transaksi Retensi Berkas Rekam Medis',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Retensi Berkas Rekam Medis</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        Yii::app()->clientScript->registerScript('search', "
            $('#seach-berkas').submit(function(){
                $.fn.yiiGridView.update('retensidokrm-v-grid', {
                    data: $(this).serialize()
                });                
                return false;
            });
        ");
        $search = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'seach-berkas',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        echo $this->renderPartial($this->path_view . '_searchBerkas', array('model' => $modDok, 'form' => $search), true);
        $this->endWidget();
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'transaksi-inaktif-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        echo $this->renderPartial($this->path_view . '_tabelBerkasRM', array('modDok' => $modDok, 'modDet' => $modDet), true);
        echo $this->renderPartial($this->path_view . '_formRetensi', array('model' => $model), true);
        $this->endWidget();
        echo $this->renderPartial($this->path_view . '_jsFunction', array('model' => $model,), true);
        echo $this->renderPartial($this->path_view . '_dialog', array('model' => $model,), true);
        ?>
    </div>
</div>