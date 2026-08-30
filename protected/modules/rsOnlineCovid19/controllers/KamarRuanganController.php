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
class KamarRuanganController extends MyAuthController
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
        $model = new ROCKamarruanganM;
        $model->ceklis = false;

        if(isset ($_REQUEST['ROCKamarruanganM'])){
            $model->attributes = $_REQUEST['ROCKamarruanganM'];
       }
       
        $this->render('index',array('model'=>$model,'format'=>$format));
  }

  public function actionPasienKemenkes() {
    if (Yii::app()->request->isAjaxRequest) {
        $kamarruangan_id = $_POST['kamarruangan_id'];
        $type = $_POST['type'];
        
        $model = KamarruanganM::model()->findByPk($kamarruangan_id);
        $briging = new BridgingKemenkes();
//        $query = "Id_tt/15";
//        $dataBridging = $briging->search_fasyankes($query);
//        $decodeJson  = json_decode($dataBridging);
        
        $checkPasien = true;
        $pesan = "";
        $sukses = 0;
        $pesanType = 0;
        
//        echo '<pre>';
//        print_r($decodeJson);
//        exit();
        
//        if(isset($decodeJson->diagnosis->status) && $decodeJson->diagnosis->status != '201' && $type != 'tambah'){
//            if($type == 'ubah'){
//                $checkPasien = true;
//            }else{
//                $checkPasien = false;
//            }
//        }
        
        if($checkPasien){
           
            $queryInsert = '{
                "id_tt": "22",
                "jumlah_ruang": "3" ,
                "jumlah": "6",
                "terpakai": "2"
                }';
            if($type=='tambah'){
                $dataBridgingKemenkes = $briging->create_fasyankes($queryInsert);
            }
            if($type=='ubah'){
                $dataBridgingKemenkes = $briging->update_fasyankes($queryInsert);
            }
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
//             echo '<pre>';
//             print_r($decodeJsonKemenkes);
//             exit();
            if(isset($decodeJsonKemenkes)){
                if(isset($decodeJsonKemenkes->fasyankes)){
                    if($decodeJsonKemenkes->fasyankes[0]->status == '200'){
                        $sukses = 1;
                        $pesan = $decodeJsonKemenkes->fasyankes[0]->message;
                        $pesanType = 0;
                       if($type=='tambah'){
                            KamarruanganM::model()->updateByPk($model->kamarruangan_id, array('tglpengiriminkemenkes'=>date('Y-m-d H:i:s'),'pegawaipengirimkemenkes'=>Yii::app()->user->getState('pegawai_id'),'statuspengiriman'=>'Sudah Terkirim'));
                        }else if($type=='ubah'){
                            KamarruanganM::model()->updateByPk($model->kamarruangan_id, array('tglubahpengirimankemenkes'=>date('Y-m-d H:i:s'),'pegawaiubahpengirimankemenkes'=>Yii::app()->user->getState('pegawai_id')));
                        }
                    }
                }
            }else{
                if(isset($dataBridgingKemenkes)){
                    $pesan = "<div class='flash-error'>".$dataBridgingKemenkes."</div>";
                    $pesanType = 1;
                }
            }
        }

        if(!$sukses){
            if(empty($pesan)){
                $pesan = "Data gagal disimpan"; 
            }
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
       $kamarruangan_id = $_POST['kamarruangan_id'];
        $model = KamarruanganM::model()->findByPk($kamarruangan_id);
        
        $briging = new BridgingKemenkes();
//        $query = "nomr/".$model->pasien->no_rekam_medik;
        $dataBridging = $briging->search_fasyankes("");
        $decodeJson  = json_decode($dataBridging);
//        
        $checkPasien = true;
        $pesan = "";
        $sukses = 0;
        $pesanType = 0;
        $logpenghapusan = "";
        
        if(!is_array($decodeJson->fasyankes)){
                if(isset($decodeJson->fasyankes->status) && $decodeJson->fasyankes->status != '201'){
                    $checkPasien = false;
                    $pesan = $decodeJson->fasyankes->message;
                }else{
                    
                     $checkPasien = false;
                    $pesan = $decodeJson->fasyankes;
                }
            }else{
                 if(isset($decodeJson->fasyankes[0]->id_kebutuhan)){
                    $checkPasien = true;
                    if(count($decodeJson->fasyankes)>0){
//                        $ss = array();
                        foreach ($decodeJson->fasyankes as $dataDig){
                            if($dataDig->id_kebutuhan =='22'){
                                $ss[]=json_encode($dataDig);
                            }
                        }
                    }
                    
                    $logpenghapusan = implode(", ", $ss);
                }
            }
//            echo $logpenghapusan;
//        exit();
                 
//        if(count($decodeJson->diagnosis)>0){
//            $checkPasien = true;
//        }else{
//            if(isset($decodeJson->diagnosis->status) && $decodeJson->diagnosis->status != '201'){
//                $checkPasien = false;
//            }
//        }
      
        if($checkPasien){
            $queryInsert = '{
                "id_tt":"22"
                }';
//            $queryInsert = "/Id_tt/22";
//           $queryInsert = '{
//                "nomr": "'.$model->pasien->no_rekam_medik.'",
//                "icd":"Z08",
//                "level":"2"
//                }';
            $dataBridgingKemenkes = $briging->delete_fasyankes($queryInsert);
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
//                 echo '<pre>';
//            print_r($decodeJsonKemenkes);
//exit();   
            if(isset($decodeJsonKemenkes)){
                if(isset($decodeJsonKemenkes->fasyankes)){
                    if($decodeJsonKemenkes->fasyankes[0]->status == '200'){
                        $sukses = 1;
                        $pesan = $decodeJsonKemenkes->fasyankes[0]->message;
                        KamarruanganM::model()->updateByPk($model->kamarruangan_id, array('tglpenghapusankemenkes'=>date('Y-m-d H:i:s'),'pegawaipenghapusankemenkes'=>Yii::app()->user->getState('pegawai_id'),'logpenghapusandatakemenkes'=>$logpenghapusan));
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
            'pesanType'=>$pesanType,
                ));
        exit;   
    }
}
 
}
