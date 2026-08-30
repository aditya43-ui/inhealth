<?php

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayat-permintaan-grid',
    'dataProvider' => $model->searchPermintaanKepenunjangOperasi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(                     
        'operasi_nama',
        'detailoperasi_nama'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
