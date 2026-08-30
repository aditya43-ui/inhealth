
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

$gedung = GedungM::model()->findByPk($model->gedung_id);
$lokasi = LokasiasetM::model()->findByPk($model->lokasi_id);
$ruangan = RuanganM::model()->findByPk($model->ruangan_id);

$ged_text = '<br>Gedung :'.(!empty($gedung)?$gedung->gedung_nama:'Semua');
$lok_text = '<br>Lokasi Aset :'.(!empty($lokasi)?$lokasi->lokasiaset_namalokasi:'Semua');
$ru_text = '<br>Ruangan :'.(!empty($ruangan)?$ruangan->ruangan_nama:'Semua');

$period = $ged_text.$ru_text.$lok_text;

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('period'=>$period,'judulLaporan'=>$judulLaporan.$period, 'colspan'=>10));      

echo $this->renderPartial('grid/_tabel',['model'=>$model,'caraPrint'=>$caraPrint], true);
?>