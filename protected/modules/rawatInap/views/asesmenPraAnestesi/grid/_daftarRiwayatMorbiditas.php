<?php

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayat-morbiditas-grid',
    'dataProvider' => $model->searchMorbiditas(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(                     
        array(
            'header' => 'Tgl Diagnosa',            
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmorbiditas)'
        ),        
        'kelompokdiagnosa_nama',
        'klasifikasidiagnosa_nama',
        [
            'header'=>'Kode',
            'name'=>'diagnosa_kode'
        ],
        'diagnosa_nama',
        'diagnosa_namalain',
        'keterangan'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
