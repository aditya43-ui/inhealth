<?php
class FormulirTransferPasienController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.formulirTransferPasien.';
    
    public function actionIndex($pendaftaran_id)
    {
        if(!empty($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }

        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS){
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>Yii::app()->user->getState("ruangan_id")));
        }
        
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
       $checkTabulasi = false;
       
       $formLembar = FormtransferpasienT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'create_ruangan_id'=>Yii::app()->user->getState("ruangan_id")));
        
       if(isset($formLembar)){
           $checkTabulasi = true;
       }
       
        $this->render($this->path_view.'index',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'checkTabulasi'=>$checkTabulasi
        ));
    }
    
    public function actionAjaxCheckLembarTransfer()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = $_POST['pendaftaran'];
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);

           $checkTabulasi = false;
       
            $formLembar = FormtransferpasienT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'create_ruangan_id'=>Yii::app()->user->getState("ruangan_id")));

            if(isset($formLembar)){
                $checkTabulasi = true;
            }

            echo json_encode($checkTabulasi);
             Yii::app()->end();
        }
    }
    
    public function getUrlLembarTransfer(){
            return $this->module->id.'/LembarTransfer/index';
    }
    
    public function getUrlTransferKondisiPasien(){
            return $this->module->id.'/TransferKondisiPasien/index';
    }
    
    public function actionDetailFormulir($pendaftaran_id, $formtransferpasien_id)
    {
        if(!empty($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }
        
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS){
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>Yii::app()->user->getState("ruangan_id")));
        }
        
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
       $ruangan_id = Yii::app()->user->getState("ruangan_id");
       
       $model = RDFormtransferpasienT::model()->findByAttributes(array('formtransferpasien_id'=>$formtransferpasien_id));
       $modProsesTransfer = RDProsestransferpasienT::model()->findByAttributes(array('formtransferpasien_id'=>$formtransferpasien_id));
       
       $tindakanUtama = "";
        $tindakanTambahan = "";
        
        $modMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'ruangan_id'=>$ruangan_id));
       
        if(count($modMorbid) >0){
            $indexKel2=0;
            $indexKel3=0;
            foreach ($modMorbid as $datamorbid){
                if($datamorbid->kelompokdiagnosa_id == 2){
                    if($indexKel2 > 0){
                        $tindakanUtama .= ", ";
                    }
                    $tindakanUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }
                
                if($datamorbid->kelompokdiagnosa_id == 3){
                    if($indexKel3 > 0){
                        $tindakanTambahan .= ", ";
                    }
                    $tindakanTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $model->diagnosamasukrs = "<p>Diagnosa Utama: ".$tindakanUtama."</p>  <p>Diagnosa Tambahan: ".$tindakanTambahan."</p>";
        
        $modAnamnesis = AnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));
        
        if(isset($modAnamnesis)){
            $model->riwayatpenyakitterdahulu = $modAnamnesis->riwayatpenyakitterdahulu;
        }
        
        $modAsesmenAwalKep = AsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'create_ruangan_id'=>$ruangan_id));
        $riwayatalergiobat = "Tidak ada";
        $riwayatalergimakanan = "Tidak ada";
        $riwayatalergilainnya = "Tidak ada";
        if(isset($modAsesmenAwalKep)){
            $riwayatalergiobat = (!empty($modAsesmenAwalKep->riwayatalergiobat)?$modAsesmenAwalKep->riwayatalergiobat:"Tidak ada");
            $riwayatalergimakanan = (!empty($modAsesmenAwalKep->riwayatalergimakanan)?$modAsesmenAwalKep->riwayatalergimakanan:"Tidak ada");
            $riwayatalergilainnya = (!empty($modAsesmenAwalKep->riwayatalergilainnya)?$modAsesmenAwalKep->riwayatalergilainnya:"Tidak ada");
        }
        $model->riwayatalergi = "<p>Riwayat Alergi Obat : ".$riwayatalergiobat."</p> <p>Riwayat Alergi Makanan: ".$riwayatalergimakanan."</p> <p>Riwayat Alergi Lainnya: ".$riwayatalergilainnya."</p>";
        $modTindakans = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));
        $modRiwayatResepBHP = ObatalkespasienT::model()->findAllByAttributes(array('oa'=>'BM','pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));
        $modRiwayatResep = ResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruanganreseptur_id'=>$ruangan_id),array('order'=>'create_time DESC'));
        
        $this->render($this->path_view.'detailFormulir',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model,
            'modProsesTransfer'=>$modProsesTransfer,
            'modTindakans'=>$modTindakans,
            'modRiwayatResep'=>$modRiwayatResep,
            'modRiwayatResepBHP'=>$modRiwayatResepBHP
        ));
    }
    
    public function actionAjaxDetailResep()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $idReseptur = $_POST['idReseptur'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
            $modReseptur = ResepturT::model()->findByPk($idReseptur);
            $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$idReseptur));

            $data['result'] = $this->renderPartial($this->path_view.'_viewDetailResep', array('modDetailResep'=>$modDetailResep,'modPendaftaran'=>$modPendaftaran, 'modReseptur'=>$modReseptur), true);

            echo json_encode($data);
             Yii::app()->end();
        }
    }
    
    public function actionPrintReseptur($idReseptur = null)
    {
        $pendaftaran_id = $_GET['id'];
        $criteria=new CDbCriteria;
        if (empty($idReseptur)) {
            $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
        } else {
            $criteria->compare('reseptur_id', $idReseptur);
        }
        $maxtime = ResepturT::model()->find($criteria);
        $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$maxtime->reseptur_id));
        $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $judulLaporan='Reseptur';
        $caraPrint=$_REQUEST['caraPrint'];
        If(isset($_GET['idReseptur'])){
            $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_GET['idReseptur']));
            if($caraPrint=='PRINT') {
                    $this->layout='//layouts/printWindows';
                    $this->render($this->path_view.'_viewDetailResep',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modDetailResep'=>$modDetailResep, 'modReseptur'=>$maxtime));
            }
        }else{
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'_viewDetailResep',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,"modDetailResep"=>$modDetailResep, 'modReseptur'=>$maxtime));
            }
        }
    }
    
    public function actionPrint($formtransferpasien_id, $pendaftaran_id) 
    {
       $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS){
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>Yii::app()->user->getState("ruangan_id")));
        }
        
       $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
       $ruangan_id = Yii::app()->user->getState("ruangan_id");
       
       $model = RDFormtransferpasienT::model()->findByAttributes(array('formtransferpasien_id'=>$formtransferpasien_id));
       $modProsesTransfer = RDProsestransferpasienT::model()->findByAttributes(array('formtransferpasien_id'=>$formtransferpasien_id));
       
       $tindakanUtama = "";
        $tindakanTambahan = "";
        
        $modMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'ruangan_id'=>$ruangan_id));
       
        if(count($modMorbid) >0){
            $indexKel2=0;
            $indexKel3=0;
            foreach ($modMorbid as $datamorbid){
                if($datamorbid->kelompokdiagnosa_id == 2){
                    if($indexKel2 > 0){
                        $tindakanUtama .= ", ";
                    }
                    $tindakanUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }
                
                if($datamorbid->kelompokdiagnosa_id == 3){
                    if($indexKel3 > 0){
                        $tindakanTambahan .= ", ";
                    }
                    $tindakanTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $model->diagnosamasukrs = "<p>Diagnosa Utama: ".$tindakanUtama."</p>  <p>Diagnosa Tambahan: ".$tindakanTambahan."</p>";
        
        $modAnamnesis = AnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id, 'create_ruangan'=>$ruangan_id));
        
        if(isset($modAnamnesis)){
            $model->riwayatpenyakitterdahulu = $modAnamnesis->riwayatpenyakitterdahulu;
        }
        
        $modAsesmenAwalKep = AsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'create_ruangan_id'=>$ruangan_id));
        $riwayatalergiobat = "Tidak ada";
        $riwayatalergimakanan = "Tidak ada";
        $riwayatalergilainnya = "Tidak ada";
        if(isset($modAsesmenAwalKep)){
            $riwayatalergiobat = (!empty($modAsesmenAwalKep->riwayatalergiobat)?$modAsesmenAwalKep->riwayatalergiobat:"Tidak ada");
            $riwayatalergimakanan = (!empty($modAsesmenAwalKep->riwayatalergimakanan)?$modAsesmenAwalKep->riwayatalergimakanan:"Tidak ada");
            $riwayatalergilainnya = (!empty($modAsesmenAwalKep->riwayatalergilainnya)?$modAsesmenAwalKep->riwayatalergilainnya:"Tidak ada");
        }
        $model->riwayatalergi = "<p>Riwayat Alergi Obat : ".$riwayatalergiobat."</p> <p>Riwayat Alergi Makanan: ".$riwayatalergimakanan."</p> <p>Riwayat Alergi Lainnya: ".$riwayatalergilainnya."</p>";
        $modTindakans = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));
        $modRiwayatResepBHP = ObatalkespasienT::model()->findAllByAttributes(array('oa'=>'BM','pendaftaran_id'=>$model->pendaftaran_id,'ruangan_id'=>$ruangan_id));
        $modRiwayatResep = ResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'ruanganreseptur_id'=>$ruangan_id),array('order'=>'create_time DESC'));
        
        
            
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modProsesTransfer'=>$modProsesTransfer, 'modTindakans'=>$modTindakans, 'modRiwayatResep'=>$modRiwayatResep, 'modRiwayatResepBHP'=>$modRiwayatResepBHP,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait            
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;  

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet,1);  
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $judulLaporan = "SURAT PERSETUJUAN UMUM";
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modProsesTransfer'=>$modProsesTransfer, 'modTindakans'=>$modTindakans, 'modRiwayatResep'=>$modRiwayatResep, 'modRiwayatResepBHP'=>$modRiwayatResepBHP,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
        }  
    } 
    
}
