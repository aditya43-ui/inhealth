<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'id' => 'form-tarif-tindakan',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#BKPendaftaranT_instalasi_id',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);return false;'
            ),
        )
    );

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Entry Tarif Tindakan </b>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?php 
                $this->renderPartial('_dataKunjugan', [
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien
                ]);
            ?>
        </div>
        <div class="col-sm-6">
            <?php 
                $this->renderPartial('_formEntryTable', [
                    'form' => $form,
                    'modTindakanPelayanan' => $modTindakanPelayanan
                ]);
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', [

]) ?>
<?php $this->renderPartial('_dialogPrintUlang', [

]) ?>