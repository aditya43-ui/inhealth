<?php

$mod = new DenyutjantungjaninT();
$mod->unsetAttributes();
$mod->partografpasien_id = $partograf->partografpasien_id;

$prov = $mod->search();
$prov->sort->defaultOrder = 'tgl_pemeriksaan, jam_pemeriksaan';

$col = array(
    'pemeriksaanke',
    array(
        'name' => 'tgl_pemeriksaan',
        'type' => 'raw',
        'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan)',
    ),
    'jam_pemeriksaan',
    array(
        'name' => 'denyutjantung_janin',
        'htmlOptions' => array(
            'style' => 'text-align: center',
        ),
    ),
    array(
        'name' => 'petugaspemeriksa_id',
        'type' => 'raw',
        'value' => function($data) {
            return empty($data->petugaspemeriksa) ? "-" : $data->petugaspemeriksa->namaLengkap;
        }
    ),
);
    
if (empty($is_detail) || $is_detail != 1) {
    array_push($col, array(
        'header' => 'Ubah',
        'type' => 'raw',
        'value' => function($data) use ($partograf) {
            return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id' => $partograf->pendaftaran_id, 'denyutjantungjanin_id' => $data->denyutjantungjanin_id)));
        },
        'htmlOptions' => array(
            'style' => 'text-align: center; width: 80px;',
        ),
    ),
    array(
        'header' => 'Hapus',
        'type' => 'raw',
        'value' => function($data) {
            return CHtml::link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
                    'onclick' => 'hapusDenyut(' . $data->denyutjantungjanin_id . '); return false;',
            ));
        },
        'htmlOptions' => array(
            'style' => 'text-align: center; width: 80px;',
        ),
    ));
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'denyut-grid',
    'dataProvider' => $prov,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => $col,
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
