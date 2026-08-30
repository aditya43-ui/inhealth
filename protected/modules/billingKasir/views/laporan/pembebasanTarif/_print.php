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
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$dataProv = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
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
                    'header'=>'Nama Dokter',
                    // 'name'=>'nobuktibayar',
                    'type'=>'raw',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
// //                'nobuktibayar',
                array(
                    'header'=>'Tanggal <br> Pembebasan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeFOrUser($data->tglpembebasan)',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Tanggal <br> Pelayanan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeFOrUser($data->tgl_tindakan)',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'No. RM <br> No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik ."<br>".$data->no_pendaftaran',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan.$data->nama_pasien',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Ruangan Peluayanan',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Jumlah Tarif',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_satuan)',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
                ),
                array(
                    'header'=>'Uraian Tindakan',
                    'type'=>'raw',
                    'value'=>'$data->daftartindakan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),   
                ),
                array(
                    'header'=>'Kompora Tarif',
                    'type'=>'raw',
                    'value'=>'0',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
                ),
                array(
                    'header'=>'Jumlah Pembebasan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatNumberForPrint($data->jmlpembebasan)',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
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