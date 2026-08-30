

<?php
//========= Dialog buat cari data Lokasi Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRuangan',
    'options' => array(
        'title' => 'Daftar Ruangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modRuangan = new RuanganM('search');
$modRuangan->ruangan_aktif = true;
if (isset($_GET['RuanganM'])) {
    $modRuangan->attributes = $_GET['RuanganM'];
    $modRuangan->ruangan_aktif = true;
    $modRuangan->instalasi_nama = isset($_GET['RuanganM']['instalasi_nama'])?$_GET['RuanganM']['instalasi_nama']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruangan-m-grid',
    'dataProvider' => $modRuangan->searchDialog(),
    'filter' => $modRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'filter'=> CHtml::activeHiddenField($modRuangan, 'gedung_id'),
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                "#",
                array(
                    "class"=>"btn-small", 
                    "id" => "selectBidang",
                    "onClick" => "
                    $(\".ruangan_id\").val(\'$data->ruangan_id\');
                    $(\".ruangan_nama\").val(\'$data->ruangan_nama\');                            
                    $(\'#dialogRuangan\').dialog(\'close\');return false;"))'
        ),
        array(
            'header'=>'Nama Instalasi',
            'name'=>'instalasi_nama',            
        ),       
        array(
            'header'=>'Nama Ruangan',
            'name'=>'ruangan_nama',
        ),       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>