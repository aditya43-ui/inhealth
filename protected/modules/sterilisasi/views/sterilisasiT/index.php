<?php $linkHalaman = CustomFunction::getUrlByMenuID(3004); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pembersihan' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Sterilisasi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-check-double"></i> Transaksi <b>Sterilisasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <!--<div class="white-container">-->
        <div style='display:none;'>
            <?php
            //			UNTUK LOAD assets FCBKComplete
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'name' => 'nama',
                'debugMode' => true,
                'options' => array(
                    //'bricket'=>false,
                    'json_url' => $this->createUrl('MasterBahanSterilisasi'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                    'id' => 'STDekontaminasidetailT_0_bahansterilisasi_nama',
                ),
            ));
            ?>
        </div>
        <!--<legend class="rim2">Transaksi <b>Sterilisasi</b></legend>-->
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#penerimaansterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('penerimaansterilisasi-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash("success", "Data Sterilisasi berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php if (isset($_GET['pembersihan_id'])) { ?>
                        <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan Sterilisasi</b>
                    <?php } else { ?>
                        <i class="entypo-search"></i> Pencarian
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <?php
                if (isset($_GET['pembersihan_id'])) {
                    $this->renderPartial($this->path_view . '_pencarianDisable', array('modPenerimaanSterilisasi' => $modPenerimaanSterilisasi, 'modPenerimaanSterilisasiDetail' => $modPenerimaanSterilisasiDetail, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans, 'modPenerimaansterilisasiV' => $modPenerimaansterilisasiV));
                } else {
                    $this->renderPartial($this->path_view . '_pencarian', array('modPenerimaanSterilisasi' => $modPenerimaanSterilisasi, 'modPenerimaanSterilisasiDetail' => $modPenerimaanSterilisasiDetail, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans, 'modPenerimaansterilisasiV' => $modPenerimaansterilisasiV));
                }
                ?>
            </div>
        </div>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'sterilisasi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onSubmit' => 'return requiredCheck(this);'),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="tabel-penerimaansterilisasi" class="items table table-striped table-condensed" style="max-width: 1300px;">
                    <thead>
                        <tr>
                            <th>Pilih
                                <?php echo CHtml::checkBox('check_semua', true, array('rel' => 'tooltip', 'title' => 'Pilih semua penerimaan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) ?>
                            </th>
                            <th>Ruangan Asal</th>
                            <th>No. Penerimaan</th>
                            <th>Nama Peralatan dan Linen</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Jenis Sterilisasi</th>
                            <th>Alat Sterilisasi</th>
                            <th>Bahan yang Digunakan</th>
                            <th>Kemasan yang Digunakan</th>
                            <th>Waktu Kedaluwarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count((array)$modSterilisasiDetail) > 0) {
                            foreach ($modSterilisasiDetail as $i => $penerimaan) {
                                //$penerimaan->barang_nama = $penerimaan->barang->barang_nama;
                                $penerimaan->peralatansterilisasi_id = $penerimaan->peralatansterilisasi_id;
                                $penerimaan->ruangan_nama = isset($penerimaan->penerimaansterilisasi->ruangan->ruangan_nama) ? $penerimaan->penerimaansterilisasi->ruangan->ruangan_nama : "";
                                $penerimaan->penerimaansterilisasi_no = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_no;
                                $penerimaan->penerimaansterilisasi_tgl = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_tgl;
                                echo $this->renderPartial($this->path_view . '_rowPenerimaanSterilisasi', array('penerimaan' => $penerimaan));
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php // echo $this->renderPartial($this->path_view.'_rowPenerimaanSterilisasi',array('modPenerimaanSterilisasi'=>$modPenerimaanSterilisasi,'modPenerimaanSterilisasiDetail'=>$modPenerimaanSterilisasiDetail)); 
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'modSterilisasi' => $modSterilisasi, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['sterilisasi_id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    'javascript:void(0);',
                    array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'button', 'onKeypress' => 'validasiCek();', 'onclick' => 'validasiCek();', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsSterilisasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPenerimaanSterilisasi' => $modPenerimaanSterilisasi, 'modSterilisasi' => $modSterilisasi, 'modSterilisasiDetail' => $modSterilisasiDetail)); ?>
    </div>
</div>
<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'name' => 'testingkktest',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>