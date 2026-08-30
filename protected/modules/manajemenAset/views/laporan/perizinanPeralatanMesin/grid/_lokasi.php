

<?php
//========= Dialog buat cari data Lokasi Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLokasi',
    'options' => array(
        'title' => 'Daftar Lokasi Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modLokasi = new LokasiasetM('search');
$modLokasi->lokasiaset_aktif = true;
if (isset($_GET['LokasiasetM'])) {
    $modLokasi->attributes = $_GET['LokasiasetM'];
    $modLokasi->lokasiaset_aktif = true;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'lokasiaset-m-grid',
    'dataProvider' => $modLokasi->search(),
    'filter' => $modLokasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'filter'=> CHtml::activeHiddenField($modLokasi, 'ruangan_id'),
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                "#",
                array(
                    "class"=>"btn-small", 
                    "id" => "selectBidang",
                    "onClick" => "
                    $(\".lokasi_id\").val(\'$data->lokasi_id\');
                    $(\".lokasiaset_namalokasi\").val(\'$data->lokasiaset_namalokasi\');                            
                    $(\'#dialogLokasi\').dialog(\'close\');return false;"))'
        ),
        array(
            'header'=>'Kode Lokasi',
            'name'=>'lokasiaset_kode',            
        ),       
        array(
            'header'=>'Lokasi Aset',
            'name'=>'lokasiaset_namalokasi',
        ),       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>