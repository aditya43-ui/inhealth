<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => Yii::app()->request->getUrlReferrer(),
    'Buat Jadwal Rehab Medis',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Buat Jadwal <b>Rehab Medis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'buatjadwal-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#lamaterapi',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>

        <?php echo $form->errorSummary(array($modNewHasil, $modJadwalKunjungan, $modTindakanPelayanan, $modTindakanKomponen)); ?>

        <?php echo $this->renderPartial('_formDataPasien', array('form' => $form, 'modPasienPenunjang' => $modPasienPenunjang)) ?>

        <?php echo $this->renderPartial('_formJadwalKunjungan', array('form' => $form, 'modPasienPenunjang' => $modPasienPenunjang, 'id' => $id, 'listJadwalKunjungan' => $listJadwalKunjungan,)) ?>
        <div class='form-actions'>
            <?php if (empty($listJadwalKunjungan)) { ?>

                <?php echo CHtml::htmlButton(
                    $modJadwalKunjungan->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                ); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl('buatJadwal', array('id' => $modPasienPenunjang->pasienmasukpenunjang_id)),
                    array('title' => 'Ulang', 'class' => 'btn btn-default')
                ); ?>
                <?php
                $content = $this->renderPartial('./tips', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
            <?php } else { ?>
                <?php
                $content = $this->renderPartial('./tips', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                ?>
            <?php } ?>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function print(caraPrint) {
        window.open("<?php echo $this->createUrl('printJadwal'); ?>/" + "&id=<?php echo $id; ?>" + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }
</script>