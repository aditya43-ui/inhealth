<?php

$model = new ARCustomModel;
if (isset($_GET['ARCustomModel'])){
    $model->attributes = $_GET['ARCustomModel'];
    $model->nama = isset($_GET['ARCustomModel']['nama'])?$_GET['ARCustomModel']['nama']:null;
    $model->kode = isset($_GET['ARCustomModel']['kode'])?$_GET['ARCustomModel']['kode']:null;
    $model->tglsep = isset($_GET['ARCustomModel']['tglsep'])?date("Y-m-d", strtotime($_GET['ARCustomModel']['tglsep'])):null;    
    $model->kodespesialis = isset($_GET['ARCustomModel']['kodespesialis'])?$_GET['ARCustomModel']['kodespesialis']:null;
    $model->jnspelayanan = isset($_GET['ARCustomModel']['jnspelayanan'])?$_GET['ARCustomModel']['jnspelayanan']:null;        
}
$model->isdokterrs = true;

$itemsCssClass = 'table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';

$sort = true;
$data = $model->tabelDokterDpjp();
$template = "{summary}\n{items}\n{pager}";    

$this->widget($table, array(
    'id' => 'daftar-dokter-dpjp-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => $itemsCssClass,
    'columns' => $model->getColumnDokterDpjp(true),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekData("dokter");}',
)); ?>
