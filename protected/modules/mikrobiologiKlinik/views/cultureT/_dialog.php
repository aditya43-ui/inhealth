
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTindakanSpesimen',
    'options' => array(
        'title' => 'Pencarian Pemeriksaan Lab',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 670,
        'resizable' => false,
    ),
));


$modTarif = new TariftindakanlaboratoriumV('search');
$modTarif->unsetAttributes();

if (isset($_GET['TariftindakanlaboratoriumV'])) {
    $modTarif->attributes = $_GET['TariftindakanlaboratoriumV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kegiatanprogram-m-grid',
    'dataProvider' => $modTarif->searchTindakanMikrobiologi(),
    'filter' => $modTarif,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data){
                $cek = PemeriksaanlabM::model()->findByPk($data->pemeriksaanlab_id);
                $daftartindakan = !empty($cek) ? $cek->daftartindakan_id : 0;
                echo CHtml::Link("<i class='icon-form-check'></i>","#",
                    array(
                        "class"=>"btn-small", 
                        "id" => "selectSample",
                        "onClick" => " 
                            $('#CultureT_daftartindakan_id').val(".$daftartindakan.");
                            $('#pemeriksaanlab_nama').val('".$data->pemeriksaanlab_nama."');
                            CekTindakan();
                            $('#dialogTindakanSpesimen').dialog('close');return false;"
                    )
                );
            }
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_nama'
        ),
        array(
            'header' => 'Nama Pemeriksaan',
            'name' => 'pemeriksaanlab_nama'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpdsBl',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPpdsBl = new PpdsM('search');
$modPpdsBl->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpdsBl->attributes = $_GET['PpdsM'];
    $modPpdsBl->ppds_nim = $_GET['PpdsM']['ppds_nim'];
    $modPpdsBl->ppds_nama = $_GET['PpdsM']['ppds_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdsbl-m-grid',
    'dataProvider' => $modPpdsBl->searchPPDSPelayanan(),
    'filter' => $modPpdsBl,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setPpdsDialogBl(\"".$data->ppds_id."\"); return false; "));
            },
        ),
        'ppds_nim',
        'ppds_nama'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog buat cari data Petugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogVerifikatorBl',
    'options' => array(
        'title' => 'Pencarian Verifikator',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawaiBl = new PegawairuanganV('search');
$modPegawaiBl->unsetAttributes();
$modPegawaiBl->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiBl->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiBl->attributes = $_GET['PegawairuanganV'];
    $modPegawaiBl->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPegawaiBl->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogverifikatorBl-m-grid',
    'dataProvider' => $modPegawaiBl->search(),
    'filter' => $modPegawaiBl,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setDpjtmDialogBl(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawaiBl, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Petugas dialog =============================
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpdsCh',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPpdsCh = new PpdsM('search');
$modPpdsCh->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpdsCh->attributes = $_GET['PpdsM'];
    $modPpdsCh->ppds_nim = $_GET['PpdsM']['ppds_nim'];
    $modPpdsCh->ppds_nama = $_GET['PpdsM']['ppds_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdsch-m-grid',
    'dataProvider' => $modPpdsCh->searchPPDSPelayanan(),
    'filter' => $modPpdsCh,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setPpdsDialogCh(\"".$data->ppds_id."\"); return false; "));
            },
        ),
        'ppds_nim',
        'ppds_nama'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog buat cari data Petugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogVerifikatorCh',
    'options' => array(
        'title' => 'Pencarian Verifikator',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawaiCh = new PegawairuanganV('search');
$modPegawaiCh->unsetAttributes();
$modPegawaiCh->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiCh->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiCh->attributes = $_GET['PegawairuanganV'];
    $modPegawaiCh->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPegawaiCh->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogverifikatorch-m-grid',
    'dataProvider' => $modPegawaiCh->search(),
    'filter' => $modPegawaiCh,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setDpjtmDialogCh(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawaiCh, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Petugas dialog =============================
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpdsMc',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPpdsMc = new PpdsM('search');
$modPpdsMc->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpdsMc->attributes = $_GET['PpdsM'];
    $modPpdsMc->ppds_nim = $_GET['PpdsM']['ppds_nim'];
    $modPpdsMc->ppds_nama = $_GET['PpdsM']['ppds_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdsmc-m-grid',
    'dataProvider' => $modPpdsMc->searchPPDSPelayanan(),
    'filter' => $modPpdsMc,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setPpdsDialogMc(\"".$data->ppds_id."\"); return false; "));
            },
        ),
        'ppds_nim',
        'ppds_nama'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog buat cari data Petugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogVerifikatorMc',
    'options' => array(
        'title' => 'Pencarian Verifikator',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawaiMC = new PegawairuanganV('search');
$modPegawaiMC->unsetAttributes();
$modPegawaiMC->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiMC->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMC->attributes = $_GET['PegawairuanganV'];
    $modPegawaiMC->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPegawaiMC->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogverifikatormc-m-grid',
    'dataProvider' => $modPegawaiMC->search(),
    'filter' => $modPegawaiMC,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setDpjtmDialogMc(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawaiMC, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Petugas dialog =============================
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpdsRs',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPpdsRs = new PpdsM('search');
$modPpdsRs->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpdsRs->attributes = $_GET['PpdsM'];
    $modPpdsRs->ppds_nim = $_GET['PpdsM']['ppds_nim'];
    $modPpdsRs->ppds_nama = $_GET['PpdsM']['ppds_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdsrs-m-grid',
    'dataProvider' => $modPpdsRs->searchPPDSPelayanan(),
    'filter' => $modPpdsRs,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setPpdsDialogRs(\"".$data->ppds_id."\"); return false; "));
            },
        ),
        'ppds_nim',
        'ppds_nama'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog buat cari data Petugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogVerifikatorRs',
    'options' => array(
        'title' => 'Pencarian Verifikator',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawaiRs = new PegawairuanganV('search');
$modPegawaiRs->unsetAttributes();
$modPegawaiRs->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiRs->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiRs->attributes = $_GET['PegawairuanganV'];
    $modPegawaiRs->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPegawaiRs->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogverifikatorrs-m-grid',
    'dataProvider' => $modPegawaiRs->search(),
    'filter' => $modPegawaiRs,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setDpjtmDialogRs(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawaiRs, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Petugas dialog =============================
?>
<?php
//========= Dialog buat cari data Analis Blood =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAnalisBl',
    'options' => array(
        'title' => 'Pencarian Analis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modAnalisBl = new MKPegawairuanganV('search');
$modAnalisBl->unsetAttributes();
$modAnalisBl->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['MKPegawairuanganV'])) {
    $modAnalisBl->attributes = $_GET['MKPegawairuanganV'];
    $modAnalisBl->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'Analispelaksanabl-m-grid',
    'dataProvider' => $modAnalisBl->searchAnalisCulture(),
    'filter' => $modAnalisBl,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setAnalisBl(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modAnalisBl, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Analis dialog =============================
?>
<?php
//========= Dialog buat cari data Analis Blood =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAnalisMc',
    'options' => array(
        'title' => 'Pencarian Analis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modAnalisMc = new MKPegawairuanganV('search');
$modAnalisMc->unsetAttributes();
$modAnalisMc->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['MKPegawairuanganV'])) {
    $modAnalisMc->attributes = $_GET['MKPegawairuanganV'];
    $modAnalisMc->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'Analispelaksanamc-m-grid',
    'dataProvider' => $modAnalisMc->searchAnalisCulture(),
    'filter' => $modAnalisMc,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setAnalisMc(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modAnalisMc, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Analis dialog =============================
?>
<?php
//========= Dialog buat cari data Analis Blood =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAnalisCh',
    'options' => array(
        'title' => 'Pencarian Analis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modAnalisCh = new MKPegawairuanganV('search');
$modAnalisCh->unsetAttributes();
$modAnalisCh->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['MKPegawairuanganV'])) {
    $modAnalisCh->attributes = $_GET['MKPegawairuanganV'];
    $modAnalisCh->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'Analispelaksanach-m-grid',
    'dataProvider' => $modAnalisCh->searchAnalisCulture(),
    'filter' => $modAnalisCh,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setAnalisCh(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modAnalisCh, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Analis dialog =============================
?>

<?php
//========= Dialog buat cari data Analis Blood =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAnalisRs',
    'options' => array(
        'title' => 'Pencarian Analis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modAnalisRs = new MKPegawairuanganV('search');
$modAnalisRs->unsetAttributes();
$modAnalisRs->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['MKPegawairuanganV'])) {
    $modAnalisRs->attributes = $_GET['MKPegawairuanganV'];
    $modAnalisRs->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'Analispelaksanars-m-grid',
    'dataProvider' => $modAnalisRs->searchAnalisCulture(),
    'filter' => $modAnalisRs,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value'=>function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                        "onclick" => " setAnalisRs(\"".$data->pegawai_id."\"); return false; "));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modAnalisRs, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Analis dialog =============================
?>



