<?php

$model = new ARCustomModel;
if (isset($_GET['ARCustomModel'])){
    $model->attributes = $_GET['ARCustomModel'];
    $model->nama = isset($_GET['ARCustomModel']['nama'])?$_GET['ARCustomModel']['nama']:null;
    $model->kode = isset($_GET['ARCustomModel']['kode'])?$_GET['ARCustomModel']['kode']:null;
}

$itemsCssClass = 'table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';

$sort = true;
$data = $model->tabelDiagnosaPrb();
$template = "{summary}\n{items}\n{pager}";    

$this->widget($table, array(
    'id' => 'daftar-diagnosa-prb-grid',
    'dataProvider' => $data,
    'filter' => $model,
    'template' => $template,
    'itemsCssClass' => $itemsCssClass,
    'columns' => $model->getColumnDiagnosaPrb(true),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekData("diagnosa");}',
)); ?>
