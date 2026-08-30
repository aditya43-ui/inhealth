<?php $linkHalaman = CustomFunction::getUrlByMenuID(129); ?>
<?php
$this->breadcrumbs = array(
    'Pemakaian Bahan',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pemakaian <b>Bahan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pemakaian Bahan berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemakaianbahp-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="" id="form-datakunjungan">
                    <div class="row">
                        <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'riwayat-obatalkespasien-t',
            'content' => array(
                'content-riwayat-obatalkespasien-t' => array(
                    'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                    'isi' => '
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Tgl. Pelayanan</th>
                                <th>Obat / Alat Kesehatan</th>
                                <th>Satuan Kecil</th>
                                <th>Jumlah</th>
                                <th>Hapus</th>
                            </thead>
                            <tbody>
                                <tr><td colspan=7>Data tidak ditemukan</td></tr>
                            </tbody>
                        </table>',
                    'active' => true,
                ),
            ),
        )); ?>
        <div id="form-tambahobatalkes" class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='fas fa-tablets'></i> Obat dan Alkes
                </div>
            </div>
            <div class="panel-body">
                <div class="row fieldset">
                    <?php $this->renderPartial($this->path_view . '_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Bahan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Obat / Alat Kesehatan</th>
                                    <th hidden>Satuan Kecil</th>
                                    <th hidden>Stok</th>
                                    <th>Jumlah</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count((array)$dataOas) > 0) {
                                    foreach ($dataOas as $i => $modObatAlkesPasien) {
                                        echo $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien));
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
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
            );
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->module->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                    )
                );
            }
            if ($modKunjungan->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $modKunjungan->pendaftaran_id . ");return false"));
            }
            $content = $this->renderPartial('laboratorium.views.pemakaianBahan.tips.tipsPemakaianBahan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>
    </div>
</div>