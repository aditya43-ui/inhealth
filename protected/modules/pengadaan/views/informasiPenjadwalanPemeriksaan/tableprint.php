<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
         if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
            
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
        
    } else{
        $data = $model->searchInformasi();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'penilaianiki-indikator-m-grid',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header'=>'No',
                'value'=>'$row+1',
            ), 
           array(
                                    'header' => 'Tanggal dan Nomor Penjadwalan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function($data){
                            
                                        echo MyFormatter::formatDateTimeForUser($data->pengadaanjadwalpemeriksaan_tanggal)."<br>".$data->pengadaanjadwalpemeriksaan_nomor; 
                                    }
                                ),
                                array(
                                    'header' => 'Nomor SPK',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => '$data->nosuratperjanjiankerja'
                                ),
                                array(
                                    'header' => 'Nama Pekerjaan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => '$data->namapekerjaan'
                                ),
                                array(
                                    'header' => 'Penyedia',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => '$data->supplier_nama'
                                ),
                                array(
                                    'header' => 'Waktu Pemeriksaan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_pemeriksaan)'
                                ),
                                array(
                                    'header' => 'Pemeriksa',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function($data){
                                        $modJadwalDet = PengadaanjadwalpemeriksaandetT::model()->findAllByAttributes(array('pengadaanjadwalpemeriksaan_id' => $data->pengadaanjadwalpemeriksaan_id));
                                        if (!empty($modJadwalDet)) {
                                            echo '<ul>';
                                                foreach($modJadwalDet as $value){
                                                    echo '<li>'.$value->pegpemeriksa->namaLengkap.'</li>';
                                                }
                                            echo '</ul>';
                                        }
                                                                             
                                    }
                                ),
                                array(
                                    'header' => 'Persetujuan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'type' => 'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value' => function($data){
                                        echo $data->pengadaanjadwalpemeriksaan_status;
                                    }
                                ),
                                array(
                                    'header' => 'Keterangan',
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function($data){
                                        if (!empty($data->alasan_tolak)) {
                                            return $data->alasan_tolak;
                                        }
                                    }
                                ),
            
        ),
    )); 
?>