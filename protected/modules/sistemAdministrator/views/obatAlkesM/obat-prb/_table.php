<?php

$model = new ARCustomModel;
if (isset($_GET['ARCustomModel'])){
    $model->attributes = $_GET['ARCustomModel'];
    $model->obatprb = $_GET['ARCustomModel']['obatprb'];
}

$itemsCssClass = 'table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';

$sort = true;
$data = $model->tabelObatPrb();
$template = "{summary}\n{items}\n{pager}";    

$this->widget($table, array(
    'id' => 'daftar-obat-prb-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => $itemsCssClass,
    'columns' => $model->getColumnObatPrb(true),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekData();}',
)); ?>
