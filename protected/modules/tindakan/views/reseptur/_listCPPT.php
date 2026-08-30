<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarriwayat-v-grid',
    'dataProvider' => $modCPPT->searchCPPT(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => [
        [
            'header' => 'No',
            'value' => '$row+1',
        ],  [
            'header' => 'Tanggal CPPT',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tanggal_cppt);
            }
        ],
        [
            'header' => 'Planning',
            'type' =>'raw',
            'value' => function ($data) {
                return $data->soap_planning;
            }
        ],
        [
            'header' => 'Instruksi',
            'type' =>'raw',
            'value' => function ($data) {
                return $data->instruksi;
            }
        ],
    ],
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

