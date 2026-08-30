<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modCariDokter = new PPDokterV('searchDialog');

$modCariDokter->unsetAttributes();
if (isset($_GET['PPDokterV'])) {
    $modCariDokter->attributes = $_GET['PPDokterV'];
    isset($_GET['PPDokterV']['ruangan_id']) ? $modCariDokter->ruangan_id = $_GET['PPDokterV']['ruangan_id'] : '';
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-v-grid',
    'dataProvider' => $modCariDokter->searchDialog(),
    'filter' => $modCariDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectDokter",
                            "onClick" => "
                                $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val($data->pegawai_id);
                                $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");                                            
                                setAntrianDokter();
                                $(\"#dialogDokter\").dialog(\"close\");
                            "))',
        ),
        'gelardepan',
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->nama_pegawai',
            'filter' => CHtml::activeHiddenField($modCariDokter, 'ruangan_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariDokter, 'nama_pegawai', array()),
        ),
        'gelarbelakang_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>