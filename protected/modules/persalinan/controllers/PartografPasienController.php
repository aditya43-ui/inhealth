<?php
class PartografPasienController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'persalinan.views.partografPasien.';
    
    public function actionIndex($pendaftaran_id)
    {
        $modPendaftaran = PSPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    
       
        $this->render($this->path_view.'index',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            
        ));
    }
    
    
    public function getUrlDataAwal(){
            return $this->module->id.'/DataAwal/index';
    }
    public function getUrlKemajuanPersalinan(){
            return $this->module->id.'/kemajuanPersalinan/index';
    }
    public function getUrlKesejahteraanJanin(){
            return $this->module->id.'/kesejahteraanJanin/index';
    }
    public function getUrlKesejahteraanIbu(){
            return $this->module->id.'/kesejahteraanIbu/create';
    }
    
    public function actionPrintPartograf($id) {
        
        $this->layout = "//layouts/printWindows_delay";
        
        $partograf = PartografpasienT::model()->findByPk($id);
        $pendaftaran = PendaftaranT::model()->findByPk($partograf->pendaftaran_id);
        
        if (empty($partograf)) {
            echo "Lakukan input Data Awal sebelum melihat printout ini.";
            Yii::app()->end();
        }
        
        // kemajuan persalinan
        $jalanlahir = new MonitoringjalanlahirT;
        $jalanlahir->unsetAttributes();
        $jalanlahir->partografpasien_id = $partograf->partografpasien_id;
        
        $kontraksi = new MonitoringkontraksiT;
        $kontraksi->unsetAttributes();
        $kontraksi->partografpasien_id = $partograf->partografpasien_id;
        
        // kesejahteraan janin
        $jantung = new DenyutjantungjaninT;
        $jantung->unsetAttributes();
        $jantung->partografpasien_id = $jantung->partografpasien_id;
        
        $ketuban = new KetubandanpenyusupanT();
        $ketuban->unsetAttributes();
        $ketuban->partografpasien_id = $partograf->partografpasien_id;
        
        // kesejahteraan ibu
        $modelIbu = new KesejahteraanibuT;
        $modelIbu->unsetAttributes();
        $modelIbu->partografpasien_id = $partograf->partografpasien_id;
        
        $this->render($this->path_view."print", array(
            'partograf'=>$partograf,
            'jalanlahir'=>$jalanlahir,
            'kontraksi'=>$kontraksi,
            'jantung'=>$jantung,
            'ketuban'=>$ketuban,
            'modelIbu'=>$modelIbu,
            'pendaftaran'=>$pendaftaran,
        ));
    }
    
}
