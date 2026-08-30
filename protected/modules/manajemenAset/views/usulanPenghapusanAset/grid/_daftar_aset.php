<?php

$modInv = new InvperalatanT('searchDialog');
$modInv->default = 'kosong';
if (isset($_GET['InvperalatanT'])) {
    $modInv->attributes = $_GET['InvperalatanT'];    
    $modInv->default = isset($_GET['InvperalatanT']['default'])?$_GET['InvperalatanT']['default']:null;    
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'aset-grid',
    'dataProvider' => $modInv->searchDialogInvPeralatan(),
    'filter' => $modInv,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modInv, 'lokasi_id'),
            'value' => function($data) {
                $dt = $data->attributes;                
                $dt['tanggal_perolehan'] = !empty($data->tanggal_perolehan)?MyFormatter::formatDateTimeForUser($data->tanggal_perolehan,'long'):'';
                $dt['barang_dan_kode'] = $data->invperalatan_kode.' - '.$data->invperalatan_namabrg;
                $res = json_encode($dt);
                
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:;", array("class" => "btn-small",
                            "id" => "selectObat",
                            "onClick" => "
                                setAset(" . $res . ",'')
                            return false;"));
            },
        ),
        [
            'header' => 'Kode',
            'name' => 'invperalatan_kode',
        ],
        [
            'header' => 'Nama Aset',
            'name' => 'invperalatan_namabrg',
        ],       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));