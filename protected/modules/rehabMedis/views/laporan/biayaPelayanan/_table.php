<?php
/**
 * view yang digunakan untuk menampilkan data ke dalam bentuk tabel
 *
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
$itemsCssClass="table table-striped table-bordered table-condensed";
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
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
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
                
            }
            
        </style>";
    $itemsCssClass='table border';
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTable();
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,        
        'itemsCssClass'=>$itemsCssClass,
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
                'header' => 'No. Rekam Medik',
                'value' => '$data->no_rekam_medik'
            ),
            array(
                'header' => 'No. Pendaftaran',
                'value' => '$data->no_pendaftaran'
            ),
            array(
                'header' => 'Umur',
                'value' => '$data->umur'
            ),            
            array(
                'header' => 'Jenis Kelamin',
                'value' => '$data->jeniskelamin'
            ),            
            array(
                'header'=>'Jenis Kasus Penyakit',
                'type'=>'raw',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
            array(
                'header'=>'Kelas Pelayanan',
                'type'=>'raw',
                'value'=>'$data->kelaspelayanan_nama',
            ),            
            'carabayarPenjamin',
            'iurbiaya',
            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>