<?php

$this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
    'id' => 'riwayat-intensivis-grid',
    'dataProvider' => $model->searchRiwayat2(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-stripped table-condesed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header' => 'Tanggal',
            'type' => 'raw',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->tanggal_update);
            }
        ),
        array(
            'header' => 'Nama Pengguna',
            'type' => 'raw',
            'value' => function($data) {
                echo $data->nama_pegawai;
                echo !empty($data->jabatan_pengadaan) ? ' (' . $data->jabatan_pengadaan . ')' : '';
            }
        ),
        'riwayatpengadaan_catatan',
        array(
            'header' => 'Status',
            'type' => 'raw',
            'value' => function($data) {
                return $data->status_berkas;
            }
        ),
        array(
            'header' => 'Lampiran',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<u>' . $data->riwayatpengadaan_lampiran . '</u>', $this->createUrl('UnduhLampiran', array('riwayatpengadaan_id' => $data->riwayatpengadaan_id)), array('class' => '', 'title' => 'Klik untuk download lampiran', 'rel' => 'tooltip'));
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});                
    }',
));
?>