<style>
	  
    @page {
        margin-top: 12mm;
    }
    
    @media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;            
			padding-bottom:1cm;  
			padding-left:0.5cm;			
            height:auto;
        }
    }
</style>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

$gedung = GedungM::model()->findByPk($model->gedung_id);
$lokasi = LokasiasetM::model()->findByPk($model->lokasi_id);
$ruangan = RuanganM::model()->findByPk($model->ruangan_id);


$ged_text = 'Gedung :'.(!empty($gedung)?$gedung->gedung_nama:'Semua');
$lok_text = '<br>Lokasi Aset :'.(!empty($lokasi)?$lokasi->lokasiaset_namalokasi:'Semua');
$ru_text = '<br>Ruangan :'.(!empty($ruangan)?$ruangan->ruangan_nama:'Semua');

$period = $ged_text.$ru_text.$lok_text;
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'periode'=>$period, 'colspan'=>10));  


if ($caraPrint != 'GRAFIK')
$this->renderPartial($this->path_view.'asetJenisPeralatan.grid._table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

?>