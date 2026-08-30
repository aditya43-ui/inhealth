<?php

$modDiagnosa = new RIDiagnosaM('searchDiagnosaAnamnesa');
$modDiagnosa->unsetAttributes();
$modDiagnosa->default = 'kosong';
if(isset($_GET['RIDiagnosaM'])){
    $modDiagnosa->attributes = $_GET['RIDiagnosaM'];
    $modDiagnosa->diagnosa_nama = (isset($_GET['RIDiagnosaM']['diagnosa_nama']) ? $_GET['RIDiagnosaM']['diagnosa_nama'] : "");
    $modDiagnosa->diagnosa_namalainnya = (isset($_GET['RIDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RIDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDiagnosa->diagnosa_kode = (isset($_GET['RIDiagnosaM']['diagnosa_kode']) ? $_GET['RIDiagnosaM']['diagnosa_kode'] : "");
    $modDiagnosa->default = (isset($_GET['RIDiagnosaM']['default']) ? $_GET['RIDiagnosaM']['default'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'list-diagnosa-m-grid',
    'dataProvider' => $modDiagnosa->searchDiagnosaAnamnesa(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data){
    
                $res['diagnosa_id'] = $data->diagnosa_id;
                $res['diagnosa_nama'] = $data->diagnosa_nama;
                $res = json_encode($res);
    
                return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small",
                    "id" => "selectDiagnosaPenyakit",
                    "onClick" => "setDiagnosa(".$res.")"
            ));
            },
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));