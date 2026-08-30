<?php

$modDiagnosa = new DiagnosaM('searchDialog');
$modDiagnosa->default = 'kosong';
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
    $modDiagnosa->default = isset($_GET['DiagnosaM']['default'])?$_GET['DiagnosaM']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftar-diagnosa-x-grid',
    'dataProvider' => $modDiagnosa->searchDialog(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
    
                $res['diagnosa_id'] = $data->diagnosa_id;
                $res['diagnosa_nama'] = $data->diagnosa_nama;
                $res['diagnosa_kode'] = $data->diagnosa_kode;
                $res['diagnosa_namalainnya'] = $data->diagnosa_namalainnya;
                
                $res = json_encode($res);
    
                return CHtml::Link('<i class="icon-form-check"></i>', "javascript:;", array("class" => "btn-small",
                    "id" => "selectPasien",
                    'attr-id' => $data->diagnosa_id,
                    "onclick" => "setDiagnosa(this,". $res .");$('#dialogDiagnosaX').dialog('close');return false;"
                ));
            },
        ),
        array(
            'name' => 'diagnosa_nourut',
            'value' => '$data->diagnosa_nourut',
            'filter' => false,
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        array(
            'header' => 'Kelompok Diagnosis',
            'value' => 'CHtml::dropDownList("kelompokdiagnosa", "", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id","kelompokdiagnosa_nama"), array("class"=>"span2"))',
            'filter' => false,
            'type' => 'raw',
        ),
        array(
            'header' => 'Kasus Diagnosis',
            'value' => 'CHtml::dropDownList("kasusdiagnosa", "", CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type"=>"kasusdiagnosa")), "lookup_value","lookup_name"), array("class"=>"span2 kasusdiagnosa"))',
            'filter' => false,
            'type' => 'raw',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)
);
?>