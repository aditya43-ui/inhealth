<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));
if ($caraPrint != 'GRAFIK'){
//$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
//$dataProv = $model->searchTable();
//$template = "{summary}\n{items}\n{pager}";
//$sort = true;
//if (isset($caraPrint)){
//    $sort = false;
//  $dataProv = $model->searchPrint();  
//  $template = "{items}";
//  if ($caraPrint == "EXCEL")
//      $table = 'ext.bootstrap.widgets.BootExcelGridView';
//}
?>
<?php 
$this->renderPartial('setoranHarian/_table', array('model'=>$model, 'caraPrint'=>$caraPrint));
//$this->widget($table,array(
//    'id'=>'tableLaporan',
//    'dataProvider'=>$dataProv,
//    'enableSorting'=>$sort,
//    'template'=>$template,
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//                array(
//                    'header' => 'No.',
//                    'value' => '$row+1',
//                    'htmlOptions'=>array('style'=>'font-size:10px;'),
//                ),
//               array(
//                    'header' => 'Poliklinik',
//                    'name' => 'ruangan_nama',
//                    'htmlOptions'=>array('style'=>'font-size:10px;'),
//                ),
//               array( 
//                    'header' => 'Tanggal Closing Kasir',
//                    'name' => 'tglclosingkasir',
//                    'value' => '$data->tglclosingkasir',
//                    'htmlOptions' => array('style'=>'font-size:10px;'), 
//                ),
//               array( 
//                    'header' => 'Jumlah Pasien',
//                    'name' => 'jmlpasien',
//                    'value' => '$data->jmlpasien',
//                    'htmlOptions' => array('style'=>'font-size:10px;'), 
//                ),
//               array(
//                    'header' => 'Bahan Alat',
//                    'type' => 'raw',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'value'=>'number_format($data->tarif_bhp,0,"",".")',
//                    'htmlOptions'=>array('style'=>'font-size:10px;'),
//                ),
//               array(
//                    'header' => 'Jasa Rumah Sakit',
//                    'type' => 'raw',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'value'=>'number_format($data->tarif_rsakomodasi,0,"",".")',
//                    'htmlOptions'=>array('style'=>'font-size:10px;'),
//                ),
//               array(
//                    'header' => 'Jasa Medis',
//                    'type' => 'raw',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'value'=>'number_format($data->tarif_medis,0,"",".")',
//                    'htmlOptions'=>array('style'=>'font-size:10px;'),
//                ),
//               array(
//                    'header' => 'Total',
//                    'type' => 'raw',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'value' => 'number_format($data->tarif_satuan,0,"",".")',
//                    'htmlOptions'=>array('style'=>'font-size:10px;'),
//                ),
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//));
}
else if ($caraPrint == 'GRAFIK'){
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}

?>
<br>
<br>
<table class="table-condensed" style="width:100%">
    <tr>
        <td align="left">
            <p style="text-align: left;">
                &nbsp;&nbsp;&nbsp;Kasir Penerima<br>
             <br>
             <br>
             <br>
             <br>
             <br>
             &nbsp;&nbsp;&nbsp;---------------------------------------------<br>
            </p>
        </td>
        <td align="right">
            <p style="text-align: right;">
             Kasir 24 Jam&nbsp;&nbsp;&nbsp;&nbsp;<br>
             <br>
             <br>
             <br>
             <br>
             <br>
             ---------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;<br>
            </p>
        </td>
    </tr>
</table>

<!--<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
                <label style='float:left;'>Petugas : <?php // echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">
            
                <label style='float:right;'>Tanggal Print : <?php // echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>
            
        </td>
    </tr>
</table>-->