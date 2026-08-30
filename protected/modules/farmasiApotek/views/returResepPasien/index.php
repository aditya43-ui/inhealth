<!--div class="white-container"-->
<style>
    .integer2,
    .float2,
    .qty {
        text-align: right;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Retur Resep Obat dan Alkes Pasien',
);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Retur Resep <b>Obat dan Alkes Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'returreseppasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
                    'focus' => '#cari_pendaftaran_id',
                )); ?>
                <?php echo $form->errorSummary($modKunjungan); ?>
                <?php echo $form->errorSummary($model); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                        </div>
                    </div>
                    <div class="panel-body" id="form-datakunjungan">
                        <div class="row">
                            <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Retur Resep</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formReturResep', array('form' => $form, 'model' => $model)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Detail <b>Tagihan Obat dan Alkes</b> <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setRincianObatalkes();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh rincian tagihan obat dan alkes')); ?>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php if (!isset($_GET['id'])) { ?>
                            <div class="block-tabel">
                                <div id="form-returresepdet">
                                    <?php $this->renderPartial('_formRincianObatalkes', array('model' => $model, 'dataOas' => $dataOas)); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php
                    if ($model->isNewRecord) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')
                        ); //formSubmit(this,event)
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                        );
                    }
                    ?>
                    <?php
                    if (!isset($_GET['frame'])) {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl('index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "$(this).attr("href")";}); return false;'
                            )
                        );
                    }
                    ?>
                    <?php
                    if ($model->isNewRecord) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRincian();return false", 'disabled' => FALSE));
                    }
                    ?>
                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips/tipsReturResepPasien', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>

                <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model)); ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-verifikasi',
    'options' => array(
        'title' => 'Verifikasi Pembayaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 360,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';
?>

<div class="col-sm-12 clear">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#returreseppasien-form").submit();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<!--/div-->