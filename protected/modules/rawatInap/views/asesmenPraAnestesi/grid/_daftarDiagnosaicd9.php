<?php
$modDiag = new Pasienicd9cmT('searchPasienIcd9');
$modDiag->pendaftaran_id = $model->pendaftaran_id; 

// $this->widget('ext.bootstrap.widgets.BootGridView',array(
// 	'id'=>'daftar-diagnosa-icd9-grid',
// 	'dataProvider'=>$modDiag->searchPasienIcd9(),
// 	'filter'=>$modDiag,
//         'template'=>"{summary}\n{items}\n{pager}",
//         'itemsCssClass'=>'table table-striped table-bordered table-condensed',
// 	'columns'=>array(
//         array(
//             'header' => 'No.',
//             'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
//         ),
//         array(
//             'header' => 'Tgl. Tindakan (ICD IX)',
//             'value' => 'MyFormatter::formatDateTimeForUser($data->pasienmorbiditas->tglmorbiditas)'
//         ),
                
// 	),
//         'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
// ));


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayat-icd9-grid',
    'dataProvider' => $model->searchPasienIcd9(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    	'columns'=>array(
        array(
            'header' => 'Tgl. Tindakan (ICD IX)',
            'value' => 'MyFormatter::formatDateTimeForUser($data->pasienmorbiditas->tglmorbiditas)'
        ),
        array(
            'header' => 'Kelompok Tindakan (ICD IX)',
            'value' => '$data->pasienmorbiditas->kelompokdiagnosa->kelompokdiagnosa_nama'
        ),
        array(
            'header' => 'Nama Dokter',
            'value' => '$data->pasienmorbiditas->pegawai->namaLengkap'
        ),
        array(
            'header' => 'Kode Tindakan',
            'value' => '$data->pasienmorbiditas->diagnosatindakan->diagnosaicdix_kode'
        ),
        array(
            'header' => 'Uraian Tindakan',
            'value' => '$data->pasienmorbiditas->diagnosatindakan->diagnosaicdix_nama'
        ),
        array(
            'header' => 'Nama Lain',
            'value' => '$data->pasienmorbiditas->diagnosatindakan->diagnosaicdix_namalainnya'
        ),
        array(
            'header' => 'Keterangan',
            'value' => '$data->keterangan'
        ),
                
	),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
));