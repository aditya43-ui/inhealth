<?php
/**
 * perbaikan format Laporan
 * BMB-295
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$itemsCssClass='table table-bordered table-striped table-condensed';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchLaporan();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
      
        $itemsCssClass='table border';
} else{
  $data = $model->searchLaporan();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
	'itemsCssClass'=>$itemsCssClass,
	'template'=>$template,
	'columns'=>array(
		array(
		    'header'=>'No.',
		    'value' => $row,
		),
		array(
			'header'=>'Tanggal Pemusnahan',
                        
			'type'=>'raw',
			'value'=>'date("d/m/Y", strtotime($data->tglpemusnahan))',
		    ),
		array(
                        'header'=>'No. Pemusnahan',
			
			'type'=>'raw',
			'value'=>'$data->nopemusnahan',
		),
		array(
			'header'=>'Instalasi',
                        
			'type'=>'raw',
			'value'=>'$data->instalasi_nama',
		),
		array(
			'header'=>'Ruangan',
                        
			'type'=>'raw',
			'value'=>'$data->ruangan_nama',
		),
		array(
			'header'=>'Kode Obat Alkes',
                        
			'type'=>'raw',
			'value'=>'$data->obatalkes_kode',
		),
		array(
			'header'=>'Nama Obat Alkes',
                        
			'type'=>'raw',
			'value'=>'$data->obatalkes_nama',
		),
		array(
                        'header'=>'jumlah',
			
			'type'=>'raw',
			'value'=>'$data->jmlbarang',
		),
		array(
			'header'=>'Pegawai Mengetahui',
                        
			'type'=>'raw',
			'value'=>'$data->PegawaimengetahuiLengkap',
		),
		array(
                        'header'=>'Pegawai Menyetujui',	
                        
			'type'=>'raw',
			'value'=>'$data->PegawaimenyetujuiLengkap',
		),
		array(
                        'header'=>'Keterangan',
			
			'type'=>'raw',
			'value'=>'$data->keterangan',
		),
	),
)); ?>