

<?php

$modGedung = new GedungM('search');
$modGedung->gedung_aktif = true;
if (isset($_GET['GedungM'])) {
    $modGedung->attributes = $_GET['GedungM'];
    $modGedung->gedung_aktif = true;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gedung-m-grid',
    'dataProvider' => $modGedung->search(),
    'filter' => $modGedung,
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
                    $(\".gedung_nama\").val(\'$data->gedung_nama\');
                    $(\".gedung_id\").val(\'$data->gedung_id\');                            
                    $(\'#dialogGedung\').dialog(\'close\');return false;"))'
        ),
        array(
            'header'=>'Nama Gedung',
            'name'=>'gedung_nama',
        ),       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));


?>