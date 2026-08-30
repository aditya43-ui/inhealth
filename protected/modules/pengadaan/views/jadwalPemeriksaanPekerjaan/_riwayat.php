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
                'header' => 'Tanggal Penjadwalan',                        
                'type' => 'raw',
                'value' => function($data){
                        return MyFormatter::formatDateTimeForUser($data['pengadaanjadwalpemeriksaan_tanggal']);
                }
            ),            
            array(
                'header' => 'Nomor SPK',
                'name' => 'nama_pegawai',
                'value' => function($data){
                    return $data["nosuratperjanjiankerja"];
                }
            ),
            array(
                'header' => 'Tanggal Pemeriksaan Dijadwalkan',                        
                'type' => 'raw',
                'value' => function($data){
                        return MyFormatter::formatDateTimeForUser($data['tanggal_pemeriksaan']);
                }
            ),
            array(
                'header' => 'Pemeriksa',                        
                'type' => 'raw',
                'value' => function($data){
                        echo "<ul>";
                        foreach ($data['det_pemeriksa'] as $det){
                            echo "<li>".$det['namaLengkap']."</li>";
                        }
                        echo "</ul>";
                }
            ),
            array(
                'header' => 'Status',                        
                'type' => 'raw',
                'value' => function($data){
                        return $data['pengadaanjadwalpemeriksaan_status'];
                }
            ),                    
        ),
        'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});                
    }',
));
?>