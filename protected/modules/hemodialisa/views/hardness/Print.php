
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

$selisih = CustomFunction::hitungHari($model->tgl_akhir, $model->tgl_awal);
$get = [];
for($i=0;$i<=$selisih;$i++){
    $tgl = date('Y-m-d', strtotime($model->tgl_awal.' +'.$i.' days'));
    $tahun = date('Y', strtotime($model->tgl_awal.' +'.$i.' days'));
    $bulan = date('m', strtotime($model->tgl_awal.' +'.$i.' days'));
    if (isset($get[$bulan.$tahun]['awal'])){
        if ($get[$bulan.$tahun]['awal'] > $tgl){
            $get[$bulan.$tahun]['awal'] = $tgl;
        }
    }else{
        $get[$bulan.$tahun]['awal'] = $tgl;
    }
    
    if (isset($get[$bulan.$tahun]['akhir'])){
        if ($get[$bulan.$tahun]['akhir'] < $tgl){
            $get[$bulan.$tahun]['akhir'] = $tgl;
        }
    }else{
        $get[$bulan.$tahun]['akhir'] = $tgl;
    }
}

$i = 1;
foreach($get as $det){
    $model->tgl_awal = $det['awal'];
    $model->tgl_akhir = $det['akhir'];
    
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiHemo',array('judulLaporan'=>$judulLaporan, 'colspan'=>10,'periode'=>'','form_no'=>'Form. WTP-IHD 02'));      

    echo $this->renderPartial($this->path_view.'_tablePrint',['model'=>$model,'caraPrint'=>$caraPrint], true);

    if (count($get) != $i){
?>

    <div style="page-break-before: always;"></div>
<?php
    }
    $i++;
}
?>