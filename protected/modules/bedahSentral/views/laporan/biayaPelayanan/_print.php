<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
                        <br>
                <?php  $itemCssClass='table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
	$row = '$row+1';
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
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
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                    'header' => 'No.',
					
                    'value' => $row
            ),
			array(
				'header' => 'Tanggal Pendaftaran/ <br>No. Pendaftaran',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeFOrUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
			),
            'no_rekam_medik',
//            'NamaNamaBIN',
            array (
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien',
            ),            
            'umur',           
            
//            'kelaspelayanan_nama',
//            'carabayarPenjamin',
            array(
                'header'=>'Jenis Penjamin /<br> Penjamin',
				 'type'=>'raw',
                'value'=>'$data->carabayarPenjamin',
            ),
			array(
              'header'=>'Jenis Kasus Penyakit',
              'type'=>'raw',
              'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
				'footer' => '<b>Total</b>',
				'footerHtmlOptions' => array('style' => 'text-align:right;','colspan' => 8)
            ),
		
            array(
                'header'=>'Iur Biaya (Rp)',
                'type'=>'raw',
				'name' => 'iurbiaya',
                'value'=>'number_format($data->iurbiaya,0,"",".")',
                'htmlOptions' => array('style'=>'text-align: right;'),
				'footer' => 'sum(iurbiaya)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header'=>'Biaya Pelayanan (Rp)',
                'type'=>'raw',
				'name' => 'total',
                'value'=>'number_format($data->total,0,"",".")',
                'htmlOptions' => array('style'=>'text-align: right;'),
				'footer' => 'sum(total)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
//            'iurbiaya',
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
     <br>
<?php $itemCssClass='table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
	$row = '$row+1';
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
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
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                    'header' => 'No.',
					
                    'value' => $row
            ),
			array(
				'header' => 'Tanggal Pendaftaran/ <br>No. Pendaftaran',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeFOrUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
			),
            'no_rekam_medik',
//            'NamaNamaBIN',
            array (
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien',
            ),            
            'umur',           
            
//            'kelaspelayanan_nama',
//            'carabayarPenjamin',
            array(
                'header'=>'Jenis Penjamin /<br> Penjamin',
				 'type'=>'raw',
                'value'=>'$data->carabayarPenjamin',
            ),
			array(
              'header'=>'Jenis Kasus Penyakit',
              'type'=>'raw',
              'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
				'footer' => '<b>Total</b>',
				'footerHtmlOptions' => array('style' => 'text-align:right;','colspan' => 8)
            ),
		
            array(
                'header'=>'Iur Biaya (Rp)',
                'type'=>'raw',
				'name' => 'iurbiaya',
                'value'=>'number_format($data->iurbiaya,0,"",".")',
                'htmlOptions' => array('style'=>'text-align: right;'),
				'footer' => 'sum(iurbiaya)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header'=>'Biaya Pelayanan (Rp)',
                'type'=>'raw',
				'name' => 'total',
                'value'=>'number_format($data->total,0,"",".")',
                'htmlOptions' => array('style'=>'text-align: right;'),
				'footer' => 'sum(total)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
//            'iurbiaya',
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>

<?php
}
if ($caraPrint == 'GRAFIK'){
 ?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?> </div>
                        <br>
                        <?php $itemCssClass='table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
	$row = '$row+1';
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
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
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                    'header' => 'No.',
					
                    'value' => $row
            ),
			array(
				'header' => 'Tanggal Pendaftaran/ <br>No. Pendaftaran',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeFOrUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
			),
            'no_rekam_medik',
//            'NamaNamaBIN',
            array (
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien',
            ),            
            'umur',           
            
//            'kelaspelayanan_nama',
//            'carabayarPenjamin',
            array(
                'header'=>'Jenis Penjamin /<br> Penjamin',
				 'type'=>'raw',
                'value'=>'$data->carabayarPenjamin',
            ),
			array(
              'header'=>'Jenis Kasus Penyakit',
              'type'=>'raw',
              'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
				'footer' => '<b>Total</b>',
				'footerHtmlOptions' => array('style' => 'text-align:right;','colspan' => 8)
            ),
		
            array(
                'header'=>'Iur Biaya (Rp)',
                'type'=>'raw',
				'name' => 'iurbiaya',
                'value'=>'number_format($data->iurbiaya,0,"",".")',
                'htmlOptions' => array('style'=>'text-align: right;'),
				'footer' => 'sum(iurbiaya)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header'=>'Biaya Pelayanan (Rp)',
                'type'=>'raw',
				'name' => 'total',
                'value'=>'number_format($data->total,0,"",".")',
                'htmlOptions' => array('style'=>'text-align: right;'),
				'footer' => 'sum(total)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
//            'iurbiaya',
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));?>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
  
<?php
}
?>