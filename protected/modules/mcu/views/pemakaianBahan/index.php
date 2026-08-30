<!--div class="white-container"-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<?php

$this->breadcrumbs = array(
    'Pemakaian Bahan',
);

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

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemakaian <b>Bahan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <fieldset id="form-datakunjungan">
                    <div class="row">
                        <?php $this->renderPartial($this->path_view_bmhp . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'riwayat-obatalkespasien-t',
                    'content' => array(
                        'content-riwayat-obatalkespasien-t' => array(
                            'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                            'isi' => '
											<table class="table table-bordered table-condensed table-striped">
												<thead>
													<th>No.</th>
													<th>Tgl. Pelayanan</th>
													<th>Obat / Alat Kesehatan</th>
													<!--th>Satuan Kecil</th-->
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
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='fas fa-tablets'></i> Obat dan Alkes
                </div>
            </div>
            <div class="panel-body table-responsive ">
                <fieldset id="form-tambahobatalkes">
                    <div class="row">
                        <?php $this->renderPartial($this->path_view . '_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
                    </div>
                    <div class="block-tabel panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Obat dan Alat Kesehatan</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="items table-bordered table table-striped table-condensed" id="table-obatalkespasien">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Obat / Alat Kesehatan</th>
                                        <!--th>Satuan Kecil</th-->
                                        <!--th>Stok</th-->
                                        <th>Jumlah</th>
                                        <th>Status</th>
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
                </fieldset>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if ($modKunjungan->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-primary disabled', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
                );
            }
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        //                                  'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
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
    </div>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view_bmhp . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>