<?php
Yii::import('pendaftaranPenjadwalan.models.PPDiagnosaM');
$modDiagnosa = new PPDiagnosaM('searchDialog');
$modDiagnosa->unsetAttributes();
if (isset($_GET['PPDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'PPdiagnosa-m-grid',
        'dataProvider' => $modDiagnosa->searchDialog(),
        'filter' => $modDiagnosa,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                    "id" => "selectPasien",
                    "onClick" => "
                                    addRowDiagnosa('" . $data->diagnosa_id . "', '" . $data->diagnosa_kode . "', '" . $data->diagnosa_nama . "', '" . $data->diagnosa_namalainnya . "');
                                   
                                "
                        )
                    )
                            .CHtml::hiddenField('pilih_dialog_x', $data->diagnosa_id, array('id'=>'pilih_dialog_'.$data->diagnosa_id));
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
            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); updateSorotX();}',
    )
);