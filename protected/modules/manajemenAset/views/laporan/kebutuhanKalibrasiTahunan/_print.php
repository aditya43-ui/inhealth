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
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  
$mpdf = isset($mpdf)?$mpdf:null;
$gedung = GedungM::model()->findByPk($model->gedung_id);
$lokasi = LokasiasetM::model()->findByPk($model->lokasi_id);
$ruangan = RuanganM::model()->findByPk($model->ruangan_id);

$ged_text = 'Gedung :'.(!empty($gedung)?$gedung->gedung_nama:'Semua');
$lok_text = '<br>Lokasi Aset :'.(!empty($lokasi)?$lokasi->lokasiaset_namalokasi:'Semua');
$ru_text = '<br>Ruangan :'.(!empty($ruangan)?$ruangan->ruangan_nama:'Semua');

$period = $ged_text.$ru_text.$lok_text;



if ($caraPrint != 'GRAFIK-NOT-AUTO'){
    if (!empty($mpdf)){
        $mpdf->WriteHTML($this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'periode'=>$period, 'colspan'=>10),true));
        $this->renderPartial($this->path_view.'kebutuhanKalibrasiTahunan._tablePdf', array('model'=>$model, 'caraPrint'=>$caraPrint, 'mpdf'=>$mpdf)); 
    }else{
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'periode'=>$period, 'colspan'=>10));  
        $this->renderPartial($this->path_view.'kebutuhanKalibrasiTahunan._table', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
    }
}

if ($caraPrint == 'GRAFIK-NOT-AUTO'){
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'periode'=>$period, 'colspan'=>10));  
    echo $this->renderPartial($this->path_view.'kebutuhanKalibrasiTahunan._grafik', array('model'=>$model, 'caraPrint'=>$caraPrint), true); 
    echo $this->renderPartial($this->path_view.'kebutuhanKalibrasiTahunan._jsFunction', array('model'=>$model), true); 
}

?>
<script>
    $(document).ready(function(){        
        var cek_data = <?= json_encode(!empty($model->loadGrafik())?$model->loadGrafik():[]) ?>;
        console.log(cek_data);
        genGrafik($("#satugrafik-batang"),'<?= $model->tipe ?>',cek_data,'','',true);  
        
    });
</script>