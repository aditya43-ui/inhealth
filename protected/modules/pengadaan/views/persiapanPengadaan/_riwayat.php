<?php
    $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView',array(
        'id'=>'riwayat-intensivis-grid',
        'dataProvider'=>$model->searchRiwayat(),        
        'template'=>"{items}",
        'itemsCssClass'=>'table table-bordered table-stripped table-condesed',
        'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),            
            array(
                'header' => 'Tanggal',                        
                'type' => 'raw',
                'value' => function($data){
                        return MyFormatter::formatDateTimeForUser($data->tanggal_update);
                }
            ),            
            array(
                'header' => 'Nama Pengguna',
                'name' => 'nama_pegawai',
                'value' => '$data->nama_pegawai." (".(!empty($data->jabatan_pengadaan)?$data->jabatan_pengadaan:"").")"'
            ),            
            'riwayatpengadaan_catatan',
            'status_berkas',
            array(
                'header' => 'Lampiran',
                'type' => 'raw',
                'value' => function($data){
                    return CHtml::link('<u>'.$data->riwayatpengadaan_lampiran.'</u>',$this->createUrl('Unduh',array('riwayatpengadaan_id'=>$data->riwayatpengadaan_id)),array('class'=>'','title'=>'Klik untuk download','rel'=>'tooltip'));
                },
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});                
    }',
));
?>