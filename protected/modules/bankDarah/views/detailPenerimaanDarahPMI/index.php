<?php
$this->breadcrumbs = array(
    'Informasi Penerimaan Kantong Darah dari PMI' => Yii::app()->request->getUrlReferrer(),
    'Detail Penerimaan Darah dari UTD PMI',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data No. Penerimaan " . $modelPenerimaan->no_penerimaan . " berhasil Disimpan");
}

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Detail <b>Penerimaan Darah dari UTD PMI</b>
        </div>
    </div>
    <div class="panel-body">
        <?php

        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penerimaandarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onsubmit' => 'return requiredCheck(this);',
            ),
        )); ?>

        <?php echo $this->renderPartial($this->path_view . "form._penerimaan", array(
            'form' => $form,
            'modelPenerimaan' => $modelPenerimaan,
        ), true); ?>

        <?php echo $this->renderPartial($this->path_view . "form._detailPenerimaanDarah", array(
            'form' => $form,
            'modelDetail' => $modelDetail,
            'modKantong' => $modKantong,
        ), true); ?>

        <div class="form-actions">
            <?php

            $disabled = isset($_GET['sukses']) ? TRUE : FALSE;

            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'title' => 'Simpan',
                    'class' => 'btn btn-danger ' . ($disabled ? '' : 'submit'),
                    'disabled' => $disabled,
                    'type' => 'submit'
                )
            );
            if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = ' . $this->createUrl('index') . ';}); return false;'
                    )
                );
            }

            echo CHtml::link(
                Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                'javascript:void(0);',
                array(
                    'class' => 'btn btn-info',
                    'onclick' => "print();return false",
                    "disabled" => !$disabled,
                )
            );

            $content = $this->renderPartial($this->path_view . 'tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>

<?php echo $this->renderPartial($this->path_view . 'form/_jsFunctions', array(), true); ?>
<?php echo $this->renderPartial($this->path_view . 'form/_dialog', array(), true); ?>

<script>
    function print() {

        var permintaan_id = <?php echo empty($modelPenerimaan->penerimaandarahpmi_id) ? "null" : $modelPenerimaan->penerimaandarahpmi_id; ?>;
        if (permintaan_id != null) {
            window.open('<?php echo $this->createUrl('print'); ?>&id=' + permintaan_id, 'printwin', 'left=100,top=100,width=800,height=500');
        }
    }
</script>