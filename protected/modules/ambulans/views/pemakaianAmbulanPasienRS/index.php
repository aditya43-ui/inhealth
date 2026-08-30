<style type="text/css">
    .tabelTarifAmbulan {
        overflow: auto;
        width: 100%;
    }

    table .span2x {
        float: none;
        margin-left: 0;
        width: 80px;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Jalan' => Yii::app()->request->getUrlReferrer(),
    'Pemakaian Ambulans Pasien Rumah Sakit',
);

if (isset($_GET['sukses'])) {
    // Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-ambulance"></i> Pemakaian Ambulans <b>Pasien Rumah Sakit</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $sukses = null;
        if (isset($_GET['sukses'])) {
            $sukses = $_GET['sukses'];
        }
        if ($sukses > 0)
            // Yii::app()->user->setFlash('success',"Transaksi Pemakaian Ambulans berhasil disimpan!");
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemakaianambulans-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''
            ),
            'focus' => '#' . CHtml::activeId($modPemakaian, 'norekammedis'),
        )); ?>
        <?php echo $form->errorSummary($modPemakaian); ?>

        <div class="panel panel-success" id="form-datakunjungan">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'format' => $format, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>
            </div>
        </div>

        <div class="panel panel-success" id="form-datapemakaian">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-ambulance"></i> Pemakaian Ambulans<span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formPemesananAmbulan', array('form' => $form, 'modPemakaian' => $modPemakaian, 'instalasi' => $instalasi, 'modInstalasi' => $modInstalasi, 'format' => $format, 'modObatAlkesPasien' => $modObatAlkesPasien, 'latitude' => $latitude, 'longitude' => $longitude)); ?>
            </div>
        </div>


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php
                    echo '<i class="fas fa-money-bill"></i> Tarif Ambulans Berdasarkan Kota Tujuan ' . CHtml::htmlButton('<i class="entypo-search"></i>', array(
                        'class' => 'btn btn-default', 'onclick' => "$('#dialogTarif').dialog('open');",
                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari Tarif Ambulans'
                    ))
                    ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="tblTarifAmbulans" class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th colspan="4" style='vertical-align:middle;text-align:center;'>Tujuan</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:left;'>Jumlah KM</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:left;'>Tarif / KM</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Biaya Tol</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Total Tarif</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:left;'>Batal</th>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count((array)$tarif['tarifAmbulans']); $i++) : ?>
                            <?php if (!empty($tarif['tarifAmbulans'][$i])) { ?>
                                <tr>
                                    <td><input type="text" value="<?php echo $tarif['propinsi'][$i]; ?>" name="tarif[propinsi][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['kabupaten'][$i]; ?>" name="tarif[kabupaten][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['kecamatan'][$i]; ?>" name="tarif[kecamatan][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['kelurahan'][$i]; ?>" name="tarif[kelurahan][]" class="span2" /></td>
                                    <td><input type="text" value="<?php echo $tarif['jmlKM'][$i]; ?>" name="tarif[jmlKM][]" class="span1 number" />
                                        <input type="hidden" value="<?php echo $tarif['daftartindakanId'][$i]; ?>" name="tarif[daftartindakanId][]" class="span1 number" />
                                    </td>
                                    <td><input type="text" value="<?php echo $tarif['tarifKM'][$i]; ?>" name="tarif[tarifKM][]" class="span1 integer" /></td>
                                    <td><input type="text" value="<?php echo $tarif['biayatol'][$i]; ?>" onblur="hitungTarif(this);" name="tarif[biayatol][]" class="span1 integer" /></td>
                                    <td><input type="text" value="<?php echo $tarif['tarifAmbulans'][$i]; ?>" name="tarif[tarifAmbulans][]" class="span2 integer" /></td>
                                    <td><i class="icon-form-silang" onclick="batalTarif(this);return false;"></i></td>
                                </tr>
                            <?php } ?>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-money-bill"></i> Tarif Ambulans Berdasarkan Peta

                </div>
            </div>
            <div class="panel-body tabelTarifAmbulan table-responsive">
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-riwayatpasien',
                    'content' => array(
                        'content-riwayatpasien' => array(
                            'header' => '<b>Rute Tarif Ambulans</b>',
                            'isi' => $this->renderPartial('_daftarTarifAPI', array('modPemakaian' => $modPemakaian, 'form' => $form), true),
                            'active' => false,
                        ),
                    ),
                    'htmlOptions' => array('style' => 'margin-top: 0 !important;'),
                )); ?>
                <table id="tblTarifAmbulansAPI" class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Tujuan</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Jarak</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Durasi</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Tarif BBM</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Jasa Paramedis</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Akomodasi Paramedis</th>
                            <th colspan="3" style='vertical-align:middle;text-align:center;'>Akomodasi Lain-Lain</th>
                            <th colspan="4" style='vertical-align:middle;text-align:center;'>Akomodasi Dokter</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:center;'>Total Tarif</th>
                            <th rowspan="2" style='vertical-align:middle;text-align:left;'>Batal</th>
                        </tr>
                        <tr>
                            <th style='vertical-align:middle;text-align:center;'>Tol</th>
                            <th style='vertical-align:middle;text-align:center;'>Hotel</th>
                            <th style='vertical-align:middle;text-align:center;'>Tiket</th>
                            <th style='vertical-align:middle;text-align:center;'>Uang Harian</th>
                            <th style='vertical-align:middle;text-align:center;'>Uang Makan</th>
                            <th style='vertical-align:middle;text-align:center;'>Hotel</th>
                            <th style='vertical-align:middle;text-align:center;'>Tiket</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" style="margin-top: 17px;">
            <?php
            if (isset($_GET['sukses'])) {
                echo '<div class="col-sm-12">';
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'riwayat-obatalkespasien-t',
                    'content' => array(
                        'content-riwayat-obatalkespasien-t' => array(
                            'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                            'isi' => '
                                        <table class="table table-condensed table-bordered">
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
                ));
                echo '</div>';
            } else {
            ?>
                <div class="col-sm-5">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="fas fa-tablets"></i> Pemakaian Obat dan Alat Kesehatan
                            </div>
                        </div>
                        <div class="panel-body" id="form-tambahobatalkes">
                            <?php $this->renderPartial('_formObatAlkesPasien', array('modKunjungan' => $modKunjungan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>BMHP</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Obat / Alat Kesehatan</th>
                                        <th>Satuan Kecil</th>
                                        <th>Stok</th>
                                        <th>Jumlah</th>
                                        <th>Batal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
        </div>

    <?php } ?>

    <div class="form-actions">
        <?php
        if ($modPemakaian->isNewRecord) {
            echo CHtml::htmlButton(
                $modPemakaian->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_submit', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            );
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'disabled' => true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
        }
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('Index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        ); ?>
        <?php
        if (!isset($_GET['pemakaian_id'])) {
            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaian BMHP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
            echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaian BMHP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemakaianOa(" . $_GET['pemakaian_id'] . ");return false"));
        }
        ?>
        <?php $content = $this->renderPartial('../tips/transaksi_pemakaian', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
    </div>

    <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPemakaian' => $modPemakaian, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>
    <?php $this->endWidget(); ?>
    </div>
</div>
<?php
//========= Dialog buat daftar paramedis 1  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogParamedis1',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarParamedis1');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis 1 =============================
//========= Dialog buat daftar paramedis 2  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogParamedis2',
    'options' => array(
        'title' => 'Daftar Pendamping 2',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarParamedis2', array('modPemakaian' => $modPemakaian));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis 2 =============================

//========= Dialog buat daftar supir  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupir',
    'options' => array(
        'title' => 'Daftar Supir',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarSupir');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar supir =============================

//========= Dialog buat daftar pelaksana  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPelaksana',
    'options' => array(
        'title' => 'Daftar Pendamping 1',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarPelaksana', array('modPemakaian' => $modPemakaian));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar pelaksana =============================
//
//========= Dialog buat daftar dokter pendamping  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokPendamping',
    'options' => array(
        'title' => 'Daftar Dokter Pendamping',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarDokPendamping', array('modPemakaian' => $modPemakaian));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar dokter pendamping =============================

//========= Dialog buat daftar ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKendaraan',
    'options' => array(
        'title' => 'Daftar Kendaraan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarKendaraan');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar ambulans =============================

//========= Dialog buat daftar tarif ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTarif',
    'options' => array(
        'title' => 'Daftar Tarif Ambulans',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
$this->renderPartial('_daftarTarifAmbulans');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tarif ambulans =============================
?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPasien = new AMInfopasienrirdambulansV('searchDialog');
$modPasien->unsetAttributes();
if (isset($_GET['AMInfopasienrirdambulansV'])) {
    $modPasien->attributes = $_GET['AMInfopasienrirdambulansV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modPasien->searchDialog(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPasien",
                "onClick" => "$(\"#AMPemakaianambulansT_norekammedis\").val(\"$data->no_rekam_medik\");
                  $(\"#AMPemakaianambulansT_pasien_id\").val(\"$data->pasien_id\");
                  $(\"#AMPemakaianambulansT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                  $(\"#AMPemakaianambulansT_namapasien\").val(\"$data->nama_pasien\");


                  $(\"#dialogPasien\").dialog(\"close\");    
            "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>