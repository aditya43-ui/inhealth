<?php
/**
 * digunakan untuk menyimpan fung - fungsi javascript unyuk tabulasi menu asesmen awal kebidanan
 * 
 * @package application.modules.rawatInap
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class PasienMorbilitasDiagnosaController extends MyAuthController
{
	/**
   * @return array action filters
   */
	public $successSave; 
	public $successUpdateMasukKamar= false; 
	public $successPasienPulang= false; 
	public $successUpdatePendaftaran= false; 
	public $successUpdatePasienAdmisi= false; 
	public $successRujukanKeluar= true; 
	public $successPaseinM= true; 
	public $successSaveTindakanKomponen = true;
	public $successSaveTindakan;
        public $simpan_rencanakontrol;
        
  /**
   * action yang digunakan untuk mengakses menu informasi daftar pasien
   */
  public function actionIndex()
  {
           
//        $this->pageTitle = Yii::app()->name." - Pasien Rawat Inap";
        $format = new MyFormatter();
        $model = new ROCPasienmorbiditasT;
        $model->tgl_awal  = date('Y-m-d');
        //$model->tgl_awal  = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->ceklis = false;

        if(isset ($_REQUEST['ROCPasienmorbiditasT'])){
            $model->attributes = $_REQUEST['ROCPasienmorbiditasT'];
            $model->no_rekam_medik = $_REQUEST['ROCPasienmorbiditasT']['no_rekam_medik'];
            $model->tgl_awal = isset($_REQUEST['ROCPasienmorbiditasT']['tgl_awal'])?$format->formatDateTimeForDb($_REQUEST['ROCPasienmorbiditasT']['tgl_awal']):'';
            $model->tgl_akhir = isset($_REQUEST['ROCPasienmorbiditasT']['tgl_akhir'])?$format->formatDateTimeForDb($_REQUEST['ROCPasienmorbiditasT']['tgl_akhir']):'';
       }
       
        $this->render('index',array('model'=>$model,'format'=>$format));
  }

  public function actionPasienKemenkes() {
    if (Yii::app()->request->isAjaxRequest) {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $type = $_POST['type'];
        
        $modMorbilitas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $briging = new BridgingKemenkes();
        $queryHeaderParam = array('nomr: ' . $model->pasien->no_rekam_medik);
        $dataBridging = $briging->search_diagnosis("", $queryHeaderParam);
        $decodeJson  = json_decode($dataBridging);
        
        $checkPasien = true;
        $pesan = "";
        $sukses = 0;
        $pesanType = 0;
        
//        if(isset($decodeJson->diagnosis)){
//            if(isset($decodeJson->diagnosis[0]->status) && $decodeJson->diagnosis[0]->status != '201' && $type != 'tambah'){
//                if($type == 'ubah'){
//                    $checkPasien = true;
//                }else{
//                    $checkPasien = false;
//                }
//            }
//        }
        
        
        if(!is_array($decodeJson->diagnosis)){
                if(isset($decodeJson->diagnosis->status) && $decodeJson->diagnosis->status != '201' && $type != 'tambah'){
                   if($type == 'ubah'){
                        $checkPasien = true;
                    }else{
                        $checkPasien = false;
                    }
                }
            }
            else{
                 if(!isset($decodeJson->diagnosis[0]->nomr)){
                     if(isset($decodeJson->diagnosis[0]->status) && $decodeJson->diagnosis[0]->status != '201' && $type != 'tambah'){
                        if($type == 'ubah'){
                            $checkPasien = true;
                        }else{
                            $checkPasien = false;
                        }
                    }
                }
            }
        
        
        if($checkPasien){
            if($type=='tambah'){
                 $queryInsert = '{
                "nomr": "'.$model->pasien->no_rekam_medik.'",
                "icd": "Z08" ,
                "level": "1"
                }';
                $dataBridgingKemenkes = $briging->create_diagnosis($queryInsert);
            }
            if($type=='ubah'){
                 $queryInsert = '{
                "nomr": "'.$model->pasien->no_rekam_medik.'",
                "icd_awal" :"U17",
                "level_awal":"1",
                "icd":"Z08",
                "level":"2"
                
                }';
                $dataBridgingKemenkes = $briging->update_diagnosis($queryInsert);
            }
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
            
            if(isset($decodeJsonKemenkes)){
                $checksimpan = false;
                
                if(is_array($decodeJsonKemenkes->diagnosis)){
                    if($decodeJsonKemenkes->diagnosis[0]->status == '200'){
                        $checksimpan = true;
                        $pesan = $decodeJsonKemenkes->diagnosis[0]->message;
                    }
                }else{
                    if(isset($decodeJsonKemenkes->diagnosis)){
                        if($decodeJsonKemenkes->diagnosis->status == '200'){
                            $checksimpan = true;
                            $pesan = $decodeJsonKemenkes->pasien->message;
                        }
                    }
                }
                
                if($checksimpan){
                    $sukses = 1;
//                        $pesan = $decodeJsonKemenkes->diagnosis[0]->message;
                        $pesanType = 0;
                       
                        if($type=='tambah'){
                            PasienmorbiditasT::model()->updateByPk($modMorbilitas->pasienmorbiditas_id, array('tglpengiriminkemenkes'=>date('Y-m-d H:i:s'),'pegawaipengirimkemenkes'=>Yii::app()->user->getState('pegawai_id'),'statuspengiriman'=>'Sudah Terkirim'));
                        }else if($type=='ubah'){
                            PasienmorbiditasT::model()->updateByPk($modMorbilitas->pasienmorbiditas_id, array('tglubahpengirimankemenkes'=>date('Y-m-d H:i:s'),'pegawaiubahpengirimankemenkes'=>Yii::app()->user->getState('pegawai_id')));
                        }
                }
                
//                if(isset($decodeJsonKemenkes->diagnosis)){
//                    if($decodeJsonKemenkes->diagnosis[0]->status == '200'){
//                        $sukses = 1;
//                        $pesan = $decodeJsonKemenkes->diagnosis[0]->message;
//                        $pesanType = 0;
//                       
//                        if($type=='tambah'){
//                            PasienmorbiditasT::model()->updateByPk($modMorbilitas->pasienmorbiditas_id, array('tglpengiriminkemenkes'=>date('Y-m-d H:i:s'),'pegawaipengirimkemenkes'=>Yii::app()->user->getState('pegawai_id'),'statuspengiriman'=>'Sudah Terkirim'));
//                        }else if($type=='ubah'){
//                            PasienmorbiditasT::model()->updateByPk($modMorbilitas->pasienmorbiditas_id, array('tglubahpengirimankemenkes'=>date('Y-m-d H:i:s'),'pegawaiubahpengirimankemenkes'=>Yii::app()->user->getState('pegawai_id')));
//                        }
//                    }
//                }
            }else{
                if(isset($dataBridgingKemenkes)){
                    $pesan = "<div class='flash-error'>".$dataBridgingKemenkes."</div>";
                    $pesanType = 1;
                }
            }
        }

        if(!$sukses){
           $pesan = "Data gagal disimpan"; 
           $pesanType = 0;
        }    
        echo CJSON::encode(array(
                'sukses'=>$sukses, 
                'pesan'=>$pesan,
            'pesanType'=>$pesanType,
                ));
        exit;   
    }
}
  
 public function actionDeletePasienKemenkes() {
    if (Yii::app()->request->isAjaxRequest) {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $modMorbilitas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $briging = new BridgingKemenkes();
        $queryHeaderParam = array('nomr: ' . $model->pasien->no_rekam_medik);
        $dataBridging = $briging->search_diagnosis("", $queryHeaderParam);
        $decodeJson  = json_decode($dataBridging);
         $myJSON = json_encode($dataBridging);
        $checkPasien = true;
        $pesan = "";
        $sukses = 0;
           $pesanType = 0;
          $logpenghapusan = "";
          
            if(!is_array($decodeJson->diagnosis)){
                if(isset($decodeJson->diagnosis->status) && $decodeJson->diagnosis->status != '201'){
                    $checkPasien = false;
                    $pesan = $decodeJson->diagnosis->message;
                }else{
                    
                     $checkPasien = false;
                    $pesan = $decodeJson->diagnosis;
                }
            }else{
                 if(isset($decodeJson->diagnosis[0]->nomr)){
                    $checkPasien = true;
                    if(count($decodeJson->diagnosis)>0){
                        $ss = array();
                        foreach ($decodeJson->diagnosis as $dataDig){
                            $ss[]=serialize($dataDig);
                        }
                    }
                    $logpenghapusan = $myJSON;
                }
            }
        if($checkPasien){
             $queryHeaderParam = array('nomr: ' . $model->pasien->no_rekam_medik,
                 "icd:Z08",
                 "level: 1"
                 );
            $dataBridgingKemenkes = $briging->delete_diagnosis("", $queryHeaderParam);
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
            if(isset($decodeJsonKemenkes)){
                if(isset($decodeJsonKemenkes->diagnosis[0])){
                    if($decodeJsonKemenkes->diagnosis[0]->status == '200'){
                        $sukses = 1;
                        $pesan = $decodeJsonKemenkes->diagnosis[0]->message;
                         PasienmorbiditasT::model()->updateByPk($modMorbilitas->pasienmorbiditas_id, array('tglpenghapusankemenkes'=>date('Y-m-d H:i:s'),'pegawaipenghapusankemenkes'=>Yii::app()->user->getState('pegawai_id'),'logpenghapusandatakemenkes'=>$logpenghapusan));
                    }
                }
            }else{
                if(isset($dataBridgingKemenkes)){
                    $pesan = "<div class='flash-error'>".print_r($dataBridgingKemenkes)."</div>";
                    $pesanType = 1;
                }
            }
        }

        if(!$sukses){
            if(empty($pesan)){
                $pesan = "Data gagal disimpan"; 
            }
        }
        
        echo CJSON::encode(array(
                'sukses'=>$sukses, 
                'pesan'=>$pesan,
                'pesanType'=>$pesanType
                ));
        exit;   
    }
}
 
}
