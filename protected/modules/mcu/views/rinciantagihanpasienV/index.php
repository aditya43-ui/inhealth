<?php

/**
 * - digunakan sebagai Informasi Rincian Tagihan Pasien
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<?php
$this->breadcrumbs = array(
    'Informasi Rincian Tagihan Pasien',
);
Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
		});
		$('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rjrinciantagihanpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
		});
    ");
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$module  = $this->module->name;
$controller = $this->id;
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rincian Tagihan Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'caripasien-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>
        <?php $this->renderPartial('mcu.views.rinciantagihanpasienV._search', array(
            'model' => $model, 'form' => $form
        ));
        ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'ajax' => array(
                    'type' => 'GET',
                    'url' => array("/" . $this->route),
                    'update' => '#rjrinciantagihanpasien-v-grid',
                    'beforeSend' => 'function(){
                                    $("#rjrinciantagihanpasien-v-grid").addClass("animation-loading");
                                }',
                    'complete' => 'function(){
                                    $("#rjrinciantagihanpasien-v-grid").removeClass("animation-loading");
                                }',
                ))
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.informasiRincianTagihanPasien', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Rincian Tagihan Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo $this->renderPartial('mcu.views.rinciantagihanpasienV._tableRinciantagihan', array('model' => $model)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
</div>
</div>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>