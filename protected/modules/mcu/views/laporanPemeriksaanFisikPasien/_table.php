<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
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
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'pemeriksaanfisikpasien-v-grid',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1',
            ), 
            array(
                'header' => 'No. Rekam Medik',
                'value' => function($data){
                    if(!empty($data->no_rekam_medik)){
                        return $data->no_rekam_medik;
                    }
                },  
            ),
            array(
                'header' => 'Nama Pasien',
                'value' => function($data){
                    if(!empty($data->nama_pasien)){
                        return $data->nama_pasien;
                    }
                },  
            ),  
            array(
                'header' => 'Umur',
                'value' => function($data){
                    if(!empty($data->umur)){
                        echo CustomFunction::getUmurTahun($data->tanggal_lahir, $data->tgl_pendaftaran).' Thn';
                    }
                },  
            ),  
            array(
                'header' => 'Jenis Kelamin',
                'value' => function($data){
                    if(!empty($data->jeniskelamin)){
                        return $data->jeniskelamin;
                    }
                },  
            ),  
            array(
                'header' => 'Tekanan Darah',
                'value' => function($data){
                    if(!empty($data->tekanandarah_sistolik) || !empty($data->tekanandarah_diastolik)){
                        return $data->tekanandarah_sistolik.' / '.$data->tekanandarah_diastolik;
                    }
                },  
            ),  
            array(
                'header' => 'Nadi',
                'name'=>'nadi', 
                'value' => function($data){
                    if(!empty($data->nadi)){
                        return $data->nadi;
                    }
                },  
            ),  
            array(
                'header' => 'Berat Badan',
                'name'=>'beratbadan', 
                'value' => function($data){
                    if(!empty($data->beratbadan)){
                        return $data->beratbadan.' kg';
                    }
                },  
            ), 
            array(
                'header' => 'Tinggi Badan',
                'name'=>'tinggibadan', 
                'value' => function($data){
                    if(!empty($data->tinggibadan)){
                        return $data->tinggibadan.' cm';
                    }
                },  
            ), 
            array(
                'header' => 'Keperluan',
                'name'=>'diagnosis', 
                'value' => function($data){
                    if(!empty($data->diagnosis)){
                        return $data->diagnosis;
                    }
                },  
            ),  
            array(
                'header' => 'Hasil Keterangan',
                'name'=>'status_fisik', 
                'value' => function($data){
                    if(!empty($data->status_fisik)){
                        return $data->status_fisik;
                    }
                },  
            ),  
            array(
                'header'=>'Lampiran',
                'type'=>'raw',
                'value' => '$this->grid->getOwner()->renderPartial("_listLampiran",array("suratketerangan_id"=>$data->suratketerangan_id),true)', 
                
            ),
		
	),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
    )); ?>