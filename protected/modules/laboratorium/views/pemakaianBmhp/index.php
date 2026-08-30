<!--div class="white-container"-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<?php
$this->breadcrumbs = array(
    'Pemakaian BMHP' => array('index'),
);

$arrMenu = array();
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();				
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('pemakaianbahp-form', {
                            data: $(this).serialize()
                    });
                    return false;
            });
        ");

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemakaianbahp-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#no_pendaftaran',
)); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-mortar-pestle"></i> Pemakaian <b>BMHP</b>
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
                        <fieldset class="box" id="form-datakunjungan">
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
												<table class="table table-responsive table-bordered table-condensed table-striped">
													<thead>
														<th>No.</th>
														<th>Tgl. Pelayanan</th>
														<th>Obat / Alat Kesehatan</th>
														<th>Satuan Kecil</th>
														<th>Harga</th>
														<th>Jumlah</th>
														<th>Sub Total</th>
														<th>Hapus</th>
													</thead>
													<tbody>
														<tr><td colspan=8>Data tidak ditemukan</td></tr>
													</tbody>
												</table>',
                            'active' => true,
                        ),
                    ),
                )); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-tablets"></i> Obat dan Alkes
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <fieldset class="box" id="form-tambahobatalkes">
                            <div class="row">
                                <?php $this->renderPartial($this->path_view . '_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
                            </div>
                            <div class="block-tabel panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <i class="entypo-credit-card"></i> Tabel <b>BMHP</b>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Obat / Alat Kesehatan</th>
                                                <th>Satuan Kecil</th>
                                                <th>Harga</th>
                                                <th>Stok</th>
                                                <th>Jumlah</th>
                                                <th>Sub Total</th>
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
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array(
                            'class' => 'btn btn-danger',
                            'type' => 'submit',
                            'title' => 'Simpan',
                            'onclick' => 'formSubmit(this,event);',
                            'onkeypress' => 'formSubmit(this,event);'
                        )
                    );
                    if (!isset($_GET['frame'])) {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'class' => 'btn btn-default',
                                'title' => 'Ulang',
                                //                                  'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                            )
                        );
                    }
                    if ($modKunjungan->isNewRecord) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $modKunjungan->pasienmasukpenunjang_id . ");return false"));
                    }

                    $content = $this->renderPartial($this->path_view . 'tips/tipsPemakaianBmhp', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>
<!--/div-->