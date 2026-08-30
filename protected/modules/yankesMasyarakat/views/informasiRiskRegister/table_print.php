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
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
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
                'header' => 'Sumber',
                'name' => 'sumber_riskregister',
                'value' => function($data){
                    $cekSumber = LookupM::model()->findByAttributes(array('lookup_type'=>'sumber_riskregister', 'lookup_aktif'=>true, 'lookup_value'=>$data->sumber_riskregister));
                    if(!empty($cekSumber)){
                        echo $cekSumber->lookup_name;
                    }else{
                        echo $data->sumber_riskregister;
                    }

                },
            ),
            array(
                'header' => 'Deskripsi Resiko',
                'name' => 'riskregister_deskripsiresiko',
                'value' => function($data){
                    echo $data->riskregister_deskripsiresiko;
                },
            ),
            array(
                'header' => 'Penyebab / Akar Masalah',
                'name' => 'riskregister_penyebab',
                'value' => function($data){
                    echo $data->riskregister_penyebab;
                },
            ),
            array(
                'header' => 'Tipe / Area Risiko',
                'name' => 'tiperesiko_id',
                'value' => function($data){
                    $cekTipe = TiperesikoM::model()->findByAttributes(array('tiperesiko_aktif'=>true, 'tiperesiko_id'=>$data->tiperesiko_id));
                    if(!empty($cekTipe)){
                        echo $cekTipe->tiperesiko_nama;
                    }else{
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'C',
                'name'=>'konsekuensi_skor',
                'type'=>'raw',
                'value'=>'$data->konsekuensi_skor',
            ),
            array(
                'header' => 'L',
                'name'=>'peluang_skor',
                'type'=>'raw',
                'value'=>'$data->peluang_skor',
            ),
            array(
                'header' => 'D',
                'name'=>'detectability_skor',
                'type'=>'raw',
                'value'=>'$data->detectability_skor',
            ),
            array(
                'header' => 'RPN',
                'name'=>'riskregister_rpn',
                'type'=>'raw',
                'value'=>'$data->riskregister_rpn',
            ),
            array(
                'header' => 'Target RPN',
                'name'=>'riskregister_targetrpn',
                'type'=>'raw',
                'value'=>'$data->riskregister_targetrpn',
            ),
            array(
                'header' => 'Evaluasi Risiko',
                'name'=>'evaluasi_risiko',
                'type'=>'raw',
                'value' => function($data){
                    $cekSumber = LookupM::model()->findByAttributes(array('lookup_type'=>'evaluasi_risiko', 'lookup_aktif'=>true, 'lookup_value'=>$data->evaluasi_risiko));
                    if(!empty($cekSumber)){
                        echo $cekSumber->lookup_name;
                    }else{
                        echo $data->evaluasi_risiko;
                    }

                },
            ),
            array(
                'header' => 'Respon Risiko dan Rencana',
                'name'=>'riskregister_riskresponse',
                'type'=>'raw',
                'value'=>'$data->riskregister_riskresponse',
            ),
            array(
                'header' => 'Tanggal Mulai',
                'name' => 'riskregister_tanggalmulai',
                'value' => function($data){
                    return MyFormatter::formatDateTimeForUser($data->riskregister_tanggalmulai);
                },
            ),
            array(
                'header' => 'Batas Waktu',
                'name' => 'riskregister_tanggaltinjauan',
                'value' => function($data){
                    return MyFormatter::formatDateTimeForUser($data->riskregister_tanggaltinjauan);
                },
            ),
            array(
                'header' => 'Penanggung Jawab Risiko',
                'name'=>'penanggungjawab',
                'type'=>'raw',
                'value'=>'$data->penanggungjawab',
            ),
            array(
                'header' => 'C',
                'name'=>'konsekuensi_skor_rpnsisa',
                'type'=>'raw',
                'value'=>'$data->konsekuensi_skor_rpnsisa',
            ),
            array(
                'header' => 'L',
                'name'=>'peluang_skor_rpnsisa',
                'type'=>'raw',
                'value'=>'$data->peluang_skor_rpnsisa',
            ),
            array(
                'header' => 'D',
                'name'=>'detectability_skor_rpnsisa',
                'type'=>'raw',
                'value'=>'$data->detectability_skor_rpnsisa',
            ),
            array(
                'header' => 'RPN Sisa',
                'name'=>'riskregister_rpnsisa',
                'type'=>'raw',
                'value'=>'$data->riskregister_rpnsisa',
            ),
            array(
                'header' => 'Laporan Singkat',
                'name'=>'laporansingkat',
                'type'=>'raw',
                'value'=>'$data->laporansingkat',
            ),
            array(
                'header' => 'Status',
                'name'=>'status_riskregister',
                'type'=>'raw',
                'value' => function($data){
                    $cekSumber = LookupM::model()->findByAttributes(array('lookup_type'=>'status_riskregister', 'lookup_aktif'=>true, 'lookup_value'=>$data->status_riskregister));
                    if(!empty($cekSumber)){
                        echo $cekSumber->lookup_name;
                    }else{
                        echo $data->status_riskregister;
                    }

                },
            ),
        ),
    )); 
?>