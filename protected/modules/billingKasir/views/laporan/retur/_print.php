<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));
if ($caraPrint != 'GRAFIK'){
//$this->renderPartial('penerimaanKasir/_table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$dataProv = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $row = '$row+1';
    $sort = false;
  $dataProv = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$dataProv,
    'enableSorting'=>$sort,
    'template'=>$template,
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
            array(
            'header' => 'No.',
            'value' => $row,
        ),
        array(
            'header'=>'Tanggal Retur',
            'name'=>'tglreturpelayanan',
            'type'=>'raw',
            'value'=>'date("d/m/Y H:i:s",strtotime($data->tglreturpelayanan))',
        ),
        array(
            'header'=>'No. Retur Pembayaran',
            'name'=>'noreturbayar',
            'type'=>'raw',
            'value'=>'$data->noreturbayar',
        ),
         array(
            'header'=>'No. RM',
            'name'=>'no_rekam_medik',
            'type'=>'raw',
            'value'=>'$data->no_rekam_medik',
        ),
        'no_pendaftaran',
        'nama_pasien',
       
        array(
            'header'=>'Ruangan Pelayanan',
            'name'=>'ruanganakhir_nama',
            'type'=>'raw',
            'value'=>'$data->ruanganakhir_nama',
        ),
        array(
            'header'=>'Nominal Retur',
            'name'=>'totalbiayaretur',
            'type'=>'raw',
            'value'=>'number_format($data->totalbiayaretur,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right')
        ),
        array(
            'header'=>'Keterangan Retur',
            'name'=>'keteranganretur',
            'type'=>'raw',
            'value'=>'$data->keteranganretur',
        ),
        array(
            'header'=>'User Pelaksana Retur',
            'name'=>'user_nm_otorisasi',
            'type'=>'raw',
            'value'=>'$data->user_nm_otorisasi',
        ),  
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
}
else if ($caraPrint == 'GRAFIK'){
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}

?>

<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
                <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">
            
<!--<label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>-->
            
        </td>
    </tr>
</table>