<?php

//========= Dialog buat cari data Jenis Jaringan Sumber =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogFreezerStemCell',
    'options' => array(
        'title' => 'Daftar Freezer Stem Cell',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 480,
        'resizable' => false,
    ),
));

$modFreezer = new BJFreezerstemcellM('search');
$modFreezer->freezerstemcell_aktif = true;
if (isset($_GET['BJFreezerstemcellM'])) {
    $modFreezer->attributes = $_GET['BJFreezerstemcellM'];
    $modFreezer->freezerstemcell_aktif = true;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modFreezer->search(),
    'filter' => $modFreezer,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
            "javascript:;",
            array(
                    "class"=>"btn-small",
                    "id" => "selectJaringan",
                    "onClick" => "
                    $(\"#' . CHtml::activeId($model, 'freezerstemcell_nama') . '\").val(\'$data->freezerstemcell_nama\');
                    $(\"#' . CHtml::activeId($model, 'freezerstemcell_id') . '\").val(\'$data->freezerstemcell_id\');
                    $(\'#dialogFreezerStemCell\').dialog(\'close\');return false;"))'
        ),
        'freezerstemcell_nama',       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>