<?php $linkHalaman = CustomFunction::getUrlByMenuID(3014); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Sterilisasi' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Penyimpanan Sterilisasi',
);
if (!empty($_GET['sukses'])) {
    Yii::app()->user->setFlash("success", "Data Penyimpanan Sterilisasi " . $modPenyimpananSterilisasi->penyimpanansteril_no . " berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-file-download"></i> Transaksi <b>Penyimpanan Sterilisasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#sterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('sterilisasi-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php if (!isset($_GET['sterilisasi_id'])) { ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view . '_pencarian', array('modSterilisasi' => $modSterilisasi, 'modSterilisasiDetail' => $modSterilisasiDetail, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
                </div>
            </div>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penyimpanansteril-t-form',
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
                <table id="tabel-sterilisasi" class="items table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Pilih
                                <?php echo CHtml::checkBox('check_semua', true, array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) ?>
                            </th>
                            <th>Lokasi Penyimpanan</th>
                            <th>Sub Rak</th>
                            <th>No. Sterilisasi</th>
                            <th>Instalasi</th>
                            <th>Ruangan</th>
                            <th>Nama Peralatan dan Linen</th>
                            <th>Waktu Kedaluwarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['sterilisasi_id'])) {
                            foreach ($modSterilisasi as $i => $penerimaan) {
                                $modPenyimpananSterilisasidetail = new STPenyimpanansterildetT;
                                $peralatan = PeralatansterilisasiM::model()->findByPk($penerimaan->peralatansterilisasi_id);
                                $modPenyimpananSterilisasidetail->sterilisasi_id = isset($penerimaan->sterilisasi_id) ? $penerimaan->sterilisasi_id : '';
                                $modPenyimpananSterilisasidetail->instalasi_nama = isset($penerimaan->instalasi_nama) ? $penerimaan->instalasi_nama : '';
                                $modPenyimpananSterilisasidetail->ruangan_nama = isset($penerimaan->ruangan_nama) ? $penerimaan->ruangan_nama : '';
                                $modPenyimpananSterilisasidetail->peralatansterilisasi_id = isset($penerimaan->peralatansterilisasi_id) ? $penerimaan->peralatansterilisasi_id : '';
                                $modPenyimpananSterilisasidetail->peralatansterilisasi_nama = isset($penerimaan->peralatansterilisasi_id) ? $peralatan->peralatansterilisasi_nama : '';
                                $modPenyimpananSterilisasidetail->sterilisasi_no = isset($penerimaan->sterilisasi->sterilisasi_no) ? $penerimaan->sterilisasi->sterilisasi_no : '';
                                $modPenyimpananSterilisasidetail->penyimpanansterildet_jml = isset($penerimaan->sterilisasidetail_jml) ? $penerimaan->sterilisasidetail_jml : '';
                                $modPenyimpananSterilisasidetail->penyimpanansterildet_ket = isset($penerimaan->sterilisasidetail_ket) ? $penerimaan->sterilisasidetail_ket : '';
                                $modPenyimpananSterilisasidetail->waktukadaluarsa = isset($penerimaan->waktukadaluarsa) ? $penerimaan->waktukadaluarsa : '';
                                $modPenyimpananSterilisasidetail->checklist = 1;
                                $modPenyimpananSterilisasidetail->sterilisasidetail_id = $penerimaan->sterilisasidetail_id;
                                $modPenyimpananSterilisasidetail->barang_id = isset($penerimaan->barang_id) ? $penerimaan->barang_id : '';
                                echo $this->renderPartial($this->path_view . '_rowPenerimaanSterilisasiSingle', array('penerimaan' => $modPenyimpananSterilisasidetail), true);
                            }
                        } else {
                            if (count((array)$modPenyimpananSterilisasiDetail) > 0) {
                                foreach ($modPenyimpananSterilisasiDetail as $i => $penerimaan) {
                                    $penerimaan->peralatansterilisasi_nama = $penerimaan->peralatansterilisasi_nama;
                                    $penerimaan->ruangan_nama = $penerimaan->ruangan_nama;
                                    $penerimaan->sterilisasi_no = $penerimaan->sterilisasi_no;
                                    $penerimaan->waktukadaluarsa = $penerimaan->waktukadaluarsa;
                                    echo $this->renderPartial($this->path_view . '_rowPenerimaanSterilisasi', array('penerimaan' => $penerimaan));
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penyimpanan Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_form', array('rel' => 'tooltip', 'title' => 'Klik untuk memilih semua penerimaan', 'form' => $form, 'modPenyimpananSterilisasi' => $modPenyimpananSterilisasi, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['penyimpanansteril_id'])) {
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
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE));
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
            $content = $this->renderPartial($this->path_view . 'tips/tipsPenyimpananSteril', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modSterilisasi' => $modSterilisasi, 'modPenyimpananSterilisasi' => $modPenyimpananSterilisasi, 'modPenyimpananSterilisasiDetail' => $modPenyimpananSterilisasiDetail)); ?>
    </div>
</div>