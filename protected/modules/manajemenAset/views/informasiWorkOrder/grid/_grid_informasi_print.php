<?php

$data = $model->searchInformasi();
$data->pagination = false;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'corectivemaintenance-r-grid',
    'dataProvider' => $data,
    'enableSorting'=>false,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
        ),
        array(
            'header' => 'Tanggal',
            'value' => function($data) {
                echo MyFormatter::formatDateTimeForUser($data->workorder_tgl, 'long');
            },
        ),
        array(
            'header' => 'Nomor WO ',
            'value' => function($data) {
                echo $data->workorder_no;
            },
        ),
        array(
            'header' => 'Jenis Peralatan',
            'value' => function($data) {
                if ($data->invperalatan_namabrg !== NULL) {
                    echo $data->invperalatan_namabrg;
                } else {
                    echo '-';
                }
            },
        ),
        array(
            'header' => 'Kode Aset',
            'type' => 'raw',
            'value' => '$data->invperalatan_kode'
        ),
        array(
            'header' => 'Nomor Seri',
            'type' => 'raw',
            'value' => '$data->peralatan_noseri'
        ),
        [
            'header' => 'Ruangan Aset',
            'name' => 'ruangan_nama'
        ],
        array(
            'header' => 'Lokasi Aset',
            'type' => 'raw',
            'value' => function($data) {               
                return $data->lokasiaset_namalokasi;
            }
        ),
        array(
            'header' => 'Penanggung Jawab',
            'value' => function($data) {
                echo $data->pegawai_pjp_gelardepan . ' ' . $data->pegawai_pjp_nama . ' ' . $data->gelarbelakangpjp_nama;
            },
        ),
        array(
            'header' => 'Keterangan',
            'value' => function($data) {
                echo $data->ket_pemeliharaan;
            },
        ),
        array(
            'header' => 'Tanggal Selesai',
            'value' => function($data) {

                echo!empty($data->tglpemeliharaan_selesai) ? MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglpemeliharaan_selesai))) : null;
            },
        ),       
        array(
            'header' => 'Status',
            'value' => function($data) {
                return $data->status_pemeliharaan;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>