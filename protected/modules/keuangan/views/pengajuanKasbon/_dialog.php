
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Nama Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 600,
        'resizable' => true,
    ),
));

$modPegawaiRuangan = new PegawaiV();
$modPegawaiRuangan->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiRuangan->pegawaisemua_id = array(4, 256, 246, 18, 69);
if (isset($_GET['PegawaiV'])) {
    $modPegawaiRuangan->attributes = $_GET['PegawaiV'];
    $modPegawaiRuangan->namaunitkerja = !empty($_GET['PegawaiV']['namaunitkerja']) ? $_GET['PegawaiV']['namaunitkerja'] : null;
    $modPegawaiRuangan->pegawaisemua_id = (!empty($_GET['PegawaiV']['pegawaisemua_id']) ? $_GET['PegawaiV']['pegawaisemua_id'] : null);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-mengetahui-grid',
    'dataProvider' => $modPegawaiRuangan->searchAllPegawai(),
    'filter' => $modPegawaiRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small",
                            "id" => "selectPegawaiDiajukan",
                            "onClick" => "
                        $(\"#PengajuankasbonT_pegawai_mengetahui_id\").val(" . $data->pegawai_id . ");
                        $(\"#PengajuankasbonT_pegawai_mengetahui_nama\").val('" . $data->namaLengkap . "');
                        $(\"#dialogPegawaiMengetahui\").dialog(\"close\");    
                    return false;
                "));
            },
            // 'filter' => CHtml::activeHiddenField($modPegawaiRuangan, 'pegawaisemua_id')
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => function($data) {
                if (!empty($data)) {
                    return (isset($data->gelardepan) ? $data->gelardepan : "") . ' ' . trim($data->nama_pegawai) . (isset($data->gelarbelakang_id) ? ', ' . $data->gelarbelakang->gelarbelakang_nama : "");
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'namaunitkerja',
            'value' => '$data->namaunitkerja',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php $this->endWidget(); ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pegawai Menyetujui I',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 600,
        'resizable' => true,
    ),
));

$modPegawaiMenyetujui = new PegawaiV();
$modPegawaiMenyetujui->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiMenyetujui->pegawaisemua_id = array(4, 256, 246, 18, 69);
if (isset($_GET['PegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['PegawaiV'];
    $modPegawaiMenyetujui->namaunitkerja = !empty($_GET['PegawaiV']['namaunitkerja']) ? $_GET['PegawaiV']['namaunitkerja'] : null;
    $modPegawaiMenyetujui->pegawaisemua_id = (!empty($_GET['PegawaiV']['pegawaisemua_id']) ? $_GET['PegawaiV']['pegawaisemua_id'] : null);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-menyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchAllPegawai(),
    'filter' => $modPegawaiMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small",
                            "id" => "selectPegawaiDiajukan",
                            "onClick" => "
                        $(\"#PengajuankasbonT_pegawai_menyetujui1_id\").val(" . $data->pegawai_id . ");
                        $(\"#PengajuankasbonT_pegawai_menyetujui1_nama\").val('" . $data->namaLengkap . "');
                        $(\"#dialogPegawaiMenyetujui\").dialog(\"close\");    
                    return false;
                "));
            },
            // 'filter' => Chtml::activeHiddenField($modPegawaiMenyetujui, 'pegawaisemua_id')
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => function($data) {
                if (!empty($data)) {
                    return (isset($data->gelardepan) ? $data->gelardepan : "") . ' ' . trim($data->nama_pegawai) . (isset($data->gelarbelakang_id) ? ', ' . $data->gelarbelakang->gelarbelakang_nama : "");
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'namaunitkerja',
            'value' => '$data->namaunitkerja',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php $this->endWidget(); ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawaiMenyetujui2',
    'options' => array(
        'title' => 'Pegawai Menyetujui II',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 600,
        'resizable' => true,
    ),
));

$modPegawaiMenyetujui2 = new PegawaiV();
$modPegawaiMenyetujui2->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiMenyetujui2->pegawaisemua_id = array(4, 256, 246, 18, 69);
if (isset($_GET['PegawaiV'])) {
    $modPegawaiMenyetujui2->attributes = $_GET['PegawaiV'];
    $modPegawaiMenyetujui2->namaunitkerja = !empty($_GET['PegawaiV']['namaunitkerja']) ? $_GET['PegawaiV']['namaunitkerja'] : null;
    $modPegawaiMenyetujui2->pegawaisemua_id = (!empty($_GET['PegawaiV']['pegawaisemua_id']) ? $_GET['PegawaiV']['pegawaisemua_id'] : null);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-menyetujui2-grid',
    'dataProvider' => $modPegawaiMenyetujui2->searchAllPegawai(),
    'filter' => $modPegawaiMenyetujui2,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small",
                            "id" => "selectPegawaiDiajukan",
                            "onClick" => "
                        $(\"#PengajuankasbonT_pegawai_menyetujui2_id\").val(" . $data->pegawai_id . ");
                        $(\"#PengajuankasbonT_pegawai_menyetujui2_nama\").val('" . $data->namaLengkap . "');
                        $(\"#dialogPegawaiMenyetujui2\").dialog(\"close\");    
                    return false;
                "));
            },
            // 'filter' => Chtml::activeHiddenField($modPegawaiMenyetujui2, 'pegawaisemua_id')
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => function($data) {
                if (!empty($data)) {
                    return (isset($data->gelardepan) ? $data->gelardepan : "") . ' ' . trim($data->nama_pegawai) . (isset($data->gelarbelakang_id) ? ', ' . $data->gelarbelakang->gelarbelakang_nama : "");
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'namaunitkerja',
            'value' => '$data->namaunitkerja',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php $this->endWidget(); ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawaiPengajuan',
    'options' => array(
        'title' => 'Nama Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 600,
        'resizable' => true,
    ),
));

$modPegawaiPengajuan = new PegawaiM();
// $modPegawaiRuangan->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawaiM'])) {
    $modPegawaiPengajuan->attributes = $_GET['PegawaiM'];
    $modPegawaiPengajuan->namaunitkerja = !empty($_GET['PegawaiM']['namaunitkerja']) ? $_GET['PegawaiM']['namaunitkerja'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-pengajuan-grid',
    'dataProvider' => $modPegawaiPengajuan->searchPegawaiDialog(),
    'filter' => $modPegawaiPengajuan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) use (&$model) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small",
                            "id" => "selectPegawaiPengajuan",
                            "onClick" => "
                            $(\"#" . CHtml::activeId($model, 'pegawai_mengajukan_id') . "\").val(\"$data->pegawai_id\");
                            $(\"#" . CHtml::activeId($model, 'pegawai_mengajukan_nama') . "\").val(\"$data->namaLengkap\");
                        $(\"#dialogPegawaiPengajuan\").dialog(\"close\");    
                    return false;
                "));
            }
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => function($data) {
                if (!empty($data)) {
                    return (isset($data->gelardepan) ? $data->gelardepan : "") . ' ' . trim($data->nama_pegawai) . (isset($data->gelarbelakang_id) ? ', ' . $data->gelarbelakang->gelarbelakang_nama : "");
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'unitkerja_id',
            'value' => '!empty($data->unitkerja)?$data->unitkerja->namaunitkerja:"-"',
            'filter' => Chtml::activeDropDownList($modPegawaiPengajuan, 'unitkerja_id', Chtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --'))
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php $this->endWidget(); ?>