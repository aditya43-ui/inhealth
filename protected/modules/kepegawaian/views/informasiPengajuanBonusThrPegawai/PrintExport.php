<?php 
if($caraPrint=='EXPORT')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }       

    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasiPrint();
        $template = "{items}";
        if ($caraPrint == "EXPORT")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else {
        $data = $model->searchInformasiPrint();
        $template = "{summary}\n{items}\n{pager}";
    }
?><h>Bulan</h> <?php echo $periode;
if ($jenis == 'THR'){
    $total = '$data->totalthr';
}else{
    $total = '$data->nilaibonus';
}
$this->widget($table,array(
	'id'=>'pengajuanbonusthr-m-grid',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
	    'itemsCssClass'=>'table table-striped table-condensed',
	    'columns'=>array(
            array(
                'header' => 'No.',
                'type'=>'raw',
                'value'=>'$row+1',
                'footer'=> '&nbsp;',
                'footerHtmlOptions'=>array(
                    'style'=>'text-align: right'
                )
            ),
            array(
                'header'=>'NIK',
                'type'=>'raw',
                'value'=>'$data->nik',
                'footer'=> '&nbsp;'
            ),
            array(
                    'header'=>'Nama Pegawai',
                    'type'=>'raw',
                    'value'=>'$data->nama_pegawai',
                    'footer'=> 'Grand Total',
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right'
                    )
            ),
            array(
                'header'=>$jenis,
                'type'=>'raw',
                'value'=>$total,
                'footer'=> $model->getTotal(),
                'footerHtmlOptions'=>array(
                    'style'=>'text-align: right',
                )
            ),
             
        ),
    )); 
?>