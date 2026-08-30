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
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'replaceUrl' => true, 
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                 'header'=>'No.',
                 'value' => $row,
            ),
            array(
               'name'=>'No. Rekam Medis',
               'type'=>'raw',
               'value'=>'$data->no_rekam_medik',
            ),  
            array(
               'name'=>'Umur',
               'type'=>'raw',
               'value'=>'$data->umur',
            ),  
            array(
               'name'=>'Jenis Kelamin',
               'type'=>'raw',
               'value'=>'$data->jeniskelamin',
            ), 
            array(
               'name'=>'Tanggal Insiden',
               'type'=>'raw',
               'value'=>'$data->tanggal_insiden',
            ),   
            array(
               'name'=>'Jam Insiden',
               'type'=>'raw',
               'value'=>'$data->waktu_insiden',
            ),   
            array(
               'name'=>'Diagnosa',
               'type'=>'raw',
               'value'=>'$data->diagnosa_nama',
            ),  
            array(
               'name'=>'Tipe IKP',
               'type'=>'raw',
               'value' => '$this->grid->getOwner()->renderPartial("_listTipe",array("insidenrs_id"=>$data->insidenrs_id),true)', 
            ),  
            array(
               'name'=>'Subtipe IKP',
               'type'=>'raw',
               'value' => '$this->grid->getOwner()->renderPartial("_listSubtipe",array("insidenrs_id"=>$data->insidenrs_id),true)', 
            ),  
            array(
               'name'=>'Kronologis Insiden',
               'type'=>'raw',
               'value'=>'$data->insidenrs_kronologis',
            ),  
            array(
               'name'=>'Pelapor',
               'type'=>'raw',
               'value'=>'$data->insidenrs_pelapor',
            ),  
            array(
               'name'=>'Lokasi',
               'type'=>'raw',
               'value'=>function ($data){
                    $cekLokasi = RuanganM::model()->findByPk($data->lokasikejadian_id);
                    if(!empty($cekLokasi)){
                        echo $cekLokasi->ruangan_nama;
                    }else{
                        echo '-';
                    }
               }
            ),  
            array(
               'name'=>'Dampak',
               'type'=>'raw',
               'value'=>'$data->konsekuensi_deskripsi',
            ),  
            array(
               'name'=>'Jenis Insiden',
               'type'=>'raw',
               'value'=>'$data->insidenrs_jenis',
            ), 
            array(
               'name'=>'Grading',
               'type'=>'raw',
               'value'=>'$data->regradingrisiko',
            ), 
            array(
               'name'=>'SMF',
               'type'=>'raw',
               'value'=>function ($data){
                    $cekSMF = PegawaiM::model()->findByPk($data->mengetahui_id);
                    if(!empty($cekSMF)){
                        echo $cekSMF->namaLengkap;
                    }else{
                        echo '-';
                    }
               }
            ), 
            array(
               'name'=>'Tindakan Setelah Kejadian',
               'type'=>'raw',
               'value'=>'$data->tindakan_setelah',
            ), 
            array(
               'name'=>'Tindak Lanjut',
               'type'=>'raw',
               'value'=>'$data->tindakan',
            ), 
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>