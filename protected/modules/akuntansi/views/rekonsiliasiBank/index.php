<?php $linkHalaman = CustomFunction::getUrlByMenuID(1903); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Transaksi Rekonsiliasi Bank',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Rekonsiliasi Bank</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Rekonsiliasi Bank berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'akrekonsiliasibank-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);',
            ),
            'focus' => '#',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="" id="form-rekonsiliasi">
                    <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'model' => $model, 'modRekonDetail' => $modRekonDetail)); ?>
                </fieldset>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Rekonsiliasi Bank
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formJenisRekon', array('form' => $form, 'model' => $model, 'modRekonDetail' => $modRekonDetail)); ?>
                <div class="panel panel-success" id="tabel-rekonsiliasi">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Rekonsiliasi Bank</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="frmGridRekonsiliasi">
                        <table class="table table-bordered table-condensed table-striped" id="tabel-detailrekonsiliasi">
                            <thead>
                                <tr>
                                    <th rowspan="2">Uraian Jurnal</th>
                                    <th rowspan="2">Kode Rekening</th>
                                    <th rowspan="2">Nama Rekening</th>
                                    <th colspan="2" style="text-align:center;">Saldo</th>
                                    <th rowspan="2">Keterangan</th>
                                    <th rowspan="2">Batal</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;">Debit</th>
                                    <th style="text-align:center;">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count((array)$modRekonDetail) > 0) {
                                    foreach ($modRekonDetail as $i => $modDetail) {
                                        $modDetail->uraiantransaksi = isset($modDetail->jenisrekonsiliasibank_id) ? $modDetail->jenisrekonsiliasibank->jenisrekonsiliasibank_nama : "";
                                        $modDetail->nama_rekening = $modDetail->getNamaRekening();
                                        $modDetail->kode_rekening = $modDetail->getKodeRekening();
                                        $status = '';
                                        if ($modDetail->saldodebit != '') {
                                            $status = 'debit';
                                        } else {
                                            $status = 'kredit';
                                        }
                                        echo $this->renderPartial($this->path_view . '_rowDetailRekening', array('modRekonDetail' => $modDetail, 'status' => $status));
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['rekonsiliasibank_id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'verifikasi();', 'onkeypress' => 'verifikasi();', 'disabled' => $disableSave,)); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')); ?>
            <?php $content = $this->renderPartial('tips/tipsTransaksiRekonsiliasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<!--/div-->
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modRekonDetail' => $modRekonDetail, 'modJurnal' => $modJurnal, 'modJurnalDetail' => $modJurnalDetail)); ?>