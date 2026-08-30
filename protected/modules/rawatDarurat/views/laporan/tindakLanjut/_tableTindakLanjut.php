<?php 
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$sort = true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=> $itemCssClass,
	'columns'=>array(
//            'instalasi_nama',
//            'carakeluar',
            array(
                'header'=>'Tindak Lanjut',
                'type'=>'raw',
                'value'=>'(empty($data->pasienpulang_id))?"PULANG":$data->carakeluar',
            ),
            array(
                'header' => 'Tanggal Pendaftaran/ <br> No. Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
            ),            
            'no_rekam_medik',
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
        //    'nama_pasien',
            
            'umur',
            //'jeniskelamin',
             array(
                'header'=>'Nama Diagnosa',
                'type'=>'raw',
                //'value'=>'(!empty($data->diagnosa_nama))?$data->diagnosa_nama:""',
              'value' => '$this->grid->getOwner()->renderPartial("tindakLanjut/_listDiagnosa",array("pendaftaran_id"=>$data->pendaftaran_id),true)'
            ),
            // 'diagnosa_nama',
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