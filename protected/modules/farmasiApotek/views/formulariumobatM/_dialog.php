<!--============================== Widget Dialog ObatAlkes ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatalkes',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modObatalkes = new ObatalkesM;
$modObatalkes->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modObatalkes->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatalkes->searchObatFarmasi(),
    'filter' => $modObatalkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "a",
                "onClick" => "
                    $(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
                    $(\"#obatalkes\").val(\"$data->obatalkes_nama\");
                    $(\"#dialogObatalkes\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'header' => 'Kode Obat',
            'name' => 'obatalkes_kode',
            'value' => '$data->obatalkes_kode',
        ),
        array(
            'header' => 'Nama Obat',
            'name' => 'obatalkes_nama',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisobatalkes_id',
            'value' => '(isset($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
            'filter' => CHtml::dropDownList('ObatalkesM[jenisobatalkes_id]', $modObatalkes->jenisobatalkes_id, CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kategori',
            'name' => 'obatalkes_kategori',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_kategori]', $modObatalkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Golongan',
            'name' => 'obatalkes_golongan',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_golongan]', $modObatalkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog ObatAlkes ====================================-->
<!--============================== Widget Dialog ObatAlkes ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatalkesUpdate',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modObatalkes = new ObatalkesM;
$modObatalkes->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modObatalkes->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-grid',
    'dataProvider' => $modObatalkes->searchObatFarmasi(),
    'filter' => $modObatalkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "a",
                "onClick" => "
                    $(\"#FAFormulariumobatM_obatalkes_id\").val(\"$data->obatalkes_id\");
                    $(\"#FAFormulariumobatM_obatalkes\").val(\"$data->obatalkes_nama\");
                    $(\"#dialogObatalkesUpdate\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'header' => 'Kode Obat',
            'name' => 'obatalkes_kode',
            'value' => '$data->obatalkes_kode',
        ),
        array(
            'header' => 'Nama Obat',
            'name' => 'obatalkes_nama',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisobatalkes_id',
            'value' => '(isset($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
            'filter' => CHtml::dropDownList('ObatalkesM[jenisobatalkes_id]', $modObatalkes->jenisobatalkes_id, CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kategori',
            'name' => 'obatalkes_kategori',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_kategori]', $modObatalkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Golongan',
            'name' => 'obatalkes_golongan',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_golongan]', $modObatalkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog ObatAlkes ====================================-->