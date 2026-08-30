<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bkpembayaranpelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modKunjungan); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modTandabukti); ?>
<?php echo $form->errorSummary($modPemakaianuangmuka); ?>

<?php
$this->breadcrumbs = array(
    'Pembayaran Resep Obat Pasien',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-money-bill"></i> Pembayaran Resep <b>Obat Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading" id="form-datakunjungan">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                    </span> <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Detail <b>Tagihan Obat dan Alkes</b>
                    <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setRincianObatalkes();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh rincian tagihan obat dan alkes')); ?>
                </div>
            </div>
            <div class="panel-body" id="">
                <div style="overflow-x: auto; max-width: 100%;" id="form-rincianobatalkes">
                    <?php $this->renderPartial($this->path_view . '_formRincianObatalkes', array('dataOas' => $dataOas)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success" hidden>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> <b>Total Rincian Pelayanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div id="form-rinciansemua">
                    <?php $this->renderPartial($this->path_view . '_formRincianTotal', array()); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran</b>
                </div>
            </div>
            <div class="panel-body" id="">
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan!");
                    $this->widget('bootstrap.widgets.BootAlert');
                }
                ?>
                <?php $this->renderPartial($this->path_view . '_formPembayaran', array('form' => $form, 'model' => $model, 'modTandabukti' => $modTandabukti, 'modPemakaianuangmuka' => $modPemakaianuangmuka)); ?>
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
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            }
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} INVOICE', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRincianOABelumBayar();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} INVOICE', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRincianSudahBayar();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBuktiKasMasuk();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKuitansi();return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPembayaranTagihanPasien', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model, 'modTandabukti' => $modTandabukti, 'modPemakaianuangmuka' => $modPemakaianuangmuka)); ?>
        <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model, 'modTandabukti' => $modTandabukti, 'modPemakaianuangmuka' => $modPemakaianuangmuka)); ?>
        <?php $this->endWidget(); ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-verifikasi',
            'options' => array(
                'title' => 'Verifikasi Pembayaran',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo '<div class="dialog-content"></div>';
        ?>

        <div class="col-sm-12 clear">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); simpanPembayaranPelFarmasi();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>