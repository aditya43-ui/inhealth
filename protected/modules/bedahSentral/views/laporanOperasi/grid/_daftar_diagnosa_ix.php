<?php

$modDiagnosa = new DiagnosaicdixM('searchDialog');
$modDiagnosa->default = 'kosong';
if (isset($_GET['DiagnosaicdixM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaicdixM'];
    $modDiagnosa->default = isset($_GET['DiagnosaicdixM']['default'])?$_GET['DiagnosaicdixM']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftar-diagnosa-ix-grid',
    'dataProvider' => $modDiagnosa->searchDialog(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
    
                $res['diagnosaicdix_id'] = $data->diagnosaicdix_id;
                $res['diagnosaicdix_nama'] = $data->diagnosaicdix_nama;
                $res['diagnosaicdix_kode'] = $data->diagnosaicdix_kode;
                $res['diagnosaicdix_namalainnya'] = $data->diagnosaicdix_namalainnya;
                
                $res = json_encode($res);
    
                return CHtml::Link('<i class="icon-form-check"></i>', "javascript:;", array("class" => "btn-small",
                    "id" => "selectPasien",
                    'attr-id' => $data->diagnosaicdix_id,
                    "onclick" => "setDiagnosaIx(this,". $res .");$('#dialogDiagnosaIX').dialog('close');return false;"
                ));
            },
        ),
        array(
            'name' => 'diagnosaicdix_nourut',
            'value' => '$data->diagnosaicdix_nourut',
            'filter' => false,
        ),
        'diagnosaicdix_kode',
        'diagnosaicdix_nama',
        'diagnosaicdix_namalainnya',
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