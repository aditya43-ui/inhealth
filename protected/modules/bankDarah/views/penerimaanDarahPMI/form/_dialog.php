<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_permintaan',
    'options' => array(
        'title' => 'Permintaan Darah PMI',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));


$modPermintaan = new BDPermintaandarahpmiT('search');
$modPermintaan->unsetAttributes();
if (isset($_GET['BDPermintaandarahpmiT'])) {
    $modPermintaan->attributes = $_GET['BDPermintaandarahpmiT'];
    $modPermintaan->nama_pegawai = $_GET['BDPermintaandarahpmiT']['nama_pegawai'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'permintaandarahpmi-grid',
    'dataProvider' => $modPermintaan->searchDialogUntukPenerimaan(),
    'filter' => $modPermintaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".permintaandarahpmi_id\").val(".$data->permintaandarahpmi_id.");
                    $(\".no_permintaan\").val(\"".$data->no_permintaan."\");
                    $(\"#dialog_permintaan\").dialog(\"close\");
                    setPermintaan(".$data->permintaandarahpmi_id.");
                    return false;"));
            },
        ),
        'no_permintaan',
        array(
            'name'=>'tgl_permintaan',
            'type'=>'raw',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_permintaan)',
            'filter'=>false,
        ),
        array(
            'name'=>'nama_pegawai',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->petugas_id)) {
                    return "-";
                }
                
                $peg = PegawaiM::model()->findByPk($data->petugas_id);
                
                return $peg->nama_pegawai;
            }
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>



<?php
//========= Dialog untuk Petugas Penerima  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_penerima',
    'options' => array(
        'title' => 'Petugas Penerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));
    
    
$modPenerima = new BDPegawairuanganV('search');
$modPenerima->unsetAttributes();
$modPenerima->ruangan_id = Params::RUANGAN_TRANSFUSI_DARAH;
if (isset($_GET['BDPegawairuanganV'])) {
    $modPenerima->attributes = $_GET['BDPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penerima-grid',
    'dataProvider' => $modPenerima->search(),
    'filter' => $modPenerima,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".petugas_penerima_id\").val(".$data->pegawai_id.");
                    $(\".petugas_penerima_nama\").val(\"".$data->nama_pegawai."\");
                    $(\"#dialog_penerima\").dialog(\"close\");
                    $(\"#petugas_penerima_nama\").blur();
                    return false;"))',
        ),
        'nomorindukpegawai',
        'nama_pegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>

    <?php
//========= Dialog untuk Petugas Mengetahui  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_mengetahui',
    'options' => array(
        'title' => 'Petugas Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));
    
    
$modMengetahui = new BDPegawairuanganV('search');
$modMengetahui->unsetAttributes();
$modMengetahui->ruangan_id = Params::RUANGAN_TRANSFUSI_DARAH;
if (isset($_GET['BDPegawairuanganV'])) {
    $modMengetahui->attributes = $_GET['BDPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'mengetahui-grid',
    'dataProvider' => $modMengetahui->search(),
    'filter' => $modMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".petugas_mengetahui_id\").val(".$data->pegawai_id.");
                    $(\".petugas_mengetahui_nama\").val(\"".$data->nama_pegawai."\");
                    $(\"#dialog_mengetahui\").dialog(\"close\");
                    return false;"))',
        ),
        'nomorindukpegawai',
        'nama_pegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>
