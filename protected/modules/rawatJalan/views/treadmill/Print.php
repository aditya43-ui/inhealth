<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

if ($caraPrint != 'GRAFIK')
$this->renderPartial('PrintHasil', array('format'=>$format,
                'judul_print'=>$judul_print,
                'modTreadmill'=>$modTreadmill,
                'modTreadmillDetail'=>$modTreadmillDetail,
				'modPasien'=>$modPasien,
				'modPendaftaran'=>$modPendaftaran,
                'caraPrint'=>$caraPrint)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('PrintDiagram', array('format'=>$format,
                'judul_print'=>$judul_print,
                'modTreadmill'=>$modTreadmill,
                'modTreadmillDetail'=>$modTreadmillDetail,
				'modPasien'=>$modPasien,
				'modPendaftaran'=>$modPendaftaran,
                'caraPrint'=>$caraPrint), true); 

?>