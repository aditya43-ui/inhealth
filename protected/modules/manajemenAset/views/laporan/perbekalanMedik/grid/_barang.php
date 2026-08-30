

<?php
//========= Dialog buat cari data Lokasi Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modBarang = new BarangM('search');
$modBarang->barang_aktif = true;
if (isset($_GET['BarangM'])) {
    $modBarang->attributes = $_GET['BarangM'];
    $modBarang->barang_aktif = true;    
}
$modBarang->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modBarang->searchDialog(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                "#",
                array(
                    "class"=>"btn-small", 
                    "id" => "selectBidang",
                    "onClick" => "
                    $(\".barang_id\").val(\'$data->barang_id\');
                    $(\".nama_aset\").val(\'$data->barang_nama\');                            
                    $(\'#dialogBarang\').dialog(\'close\');return false;"))'
        ),
        array(
            'header'=>'Nama Aset',
            'name'=>'barang_nama',            
        ),              
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>