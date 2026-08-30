<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    
<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultV3');
    echo $this->renderPartial('printAll/templateDpjpNew',['modPendaftaran'=>$modPendaftaran, 'dok'=>$dok, 'modAdmisi'=>$modAdmisi,  'print'=>1], true);
    
    echo '<div style="page-break-after: always;"></div>';
    
    echo $this->renderPartial('application.views.headerReport.headerDefaultV3');
    echo $this->renderPartial('printAll/templateKebutuhanPrivasiNew',['modPendaftaran'=>$modPendaftaran, 'dok'=>$dok, 'modAdmisi'=>$modAdmisi, 'surat'=>$surat,  'print'=>1], true);
    
    echo '<div style="page-break-after: always;"></div>';
    
    // echo $this->renderPartial('application.views.headerReport.headerDefaultV3',['identitaspasien'=>true, 'modPendaftaran'=>$modPendaftaran->pasien]);
    echo $this->renderPartial('printAll/templatePermintaanKerohanianNew',['modPendaftaran'=>$modPendaftaran, 'surat'=>$surat, 'print'=>1], true);

    echo '<div style="page-break-after: always;"></div>';
    
    // echo $this->renderPartial('application.views.headerReport.headerDefaultV3',['identitaspasien'=>true, 'modPendaftaran'=>$modPendaftaran->pasien]);
    echo $this->renderPartial('printAll/template',['modPendaftaran'=>$modPendaftaran, 'modSurat'=>$modSurat,  'print'=>1], true);
?>
  

