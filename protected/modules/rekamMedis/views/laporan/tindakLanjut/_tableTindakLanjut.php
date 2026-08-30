
<?php 
$itemCssClass='table table-striped table-condensed';
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass='table border';
} else{
    
  $data = $model->searchTable();
  $template = "{summary}\n{items}\n{pager}";
}
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
//            'instalasi_nama',
//            'carakeluar',
            array(
                'header'=>'Tindak Lanjut',
                'type'=>'raw',
                'value'=>'(empty($data->pasienpulang_id))?"PULANG":$data->carakeluar',
            ),
            'no_pendaftaran',
            'no_rekam_medik',            
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
            'umur',
            'jeniskelamin',
            array(
                'header' => 'Instalasi <br> / Ruangan',
                'type' => 'raw',
                'value' => '$data->instalasi_nama." <br> / ".$data->ruangan_nama'
            ),
            'diagnosa_nama',
//            array(
//                   'header'=>'CaraBayar/Penjamin',
//                   'type'=>'raw',
//                   'value'=>'$data->CaraBayarPenjamin',
//                   'htmlOptions'=>array('style'=>'text-align: center')
//            ),  
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>