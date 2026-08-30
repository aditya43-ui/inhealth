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
class KebutuhanAlkesApdController extends MyAuthController
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
        $model = new ROCObatalkesM;

        if(isset ($_REQUEST['ROCObatalkesM'])){
            $model->attributes = $_REQUEST['ROCObatalkesM'];
       }
       
        $this->render('index',array('model'=>$model,'format'=>$format));
  }

  public function actionPasienKemenkes() {
    if (Yii::app()->request->isAjaxRequest) {
        $obatalkes_id = $_POST['obatalkes_id'];
        $type = $_POST['type'];
        
        $model = ObatalkesM::model()->findByPk($obatalkes_id);
        $briging = new BridgingKemenkes();
//        $query = "Id_tt/15";
//        $queryHeaderParam = array('nomr: ' . $model->pasien->no_rekam_medik);
        $dataBridging = $briging->search_apd("");
        $decodeJson  = json_decode($dataBridging);
//        echo '<pre>';
//        print_r($decodeJson);
//        exit();
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
                "id_kebutuhan": "13",
                "jumlah_eksisting": "154" ,
                "jumlah": "3",
                "jumlah_diterima": "1"
                }';
            if($type=='tambah'){
                $dataBridgingKemenkes = $briging->create_apd($queryInsert);
            }
            if($type=='ubah'){
                $dataBridgingKemenkes = $briging->update_apd($queryInsert);
            }
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
//             echo '<pre>';
//             print_R($decodeJsonKemenkes);
//             exit();
            if(isset($decodeJsonKemenkes)){
                if(isset($decodeJsonKemenkes->apd)){
                    if($decodeJsonKemenkes->apd[0]->status == '200'){
                        $sukses = 1;
                        $pesan = $decodeJsonKemenkes->apd[0]->message;
                        $pesanType = 0;
                        if($type=='tambah'){
                            ObatalkesM::model()->updateByPk($model->obatalkes_id, array('tglpengiriminkemenkes'=>date('Y-m-d H:i:s'),'pegawaipengirimkemenkes'=>Yii::app()->user->getState('pegawai_id'),'statuspengiriman'=>'Sudah Terkirim'));
                        }else if($type=='ubah'){
                            ObatalkesM::model()->updateByPk($model->obatalkes_id, array('tglubahpengirimankemenkes'=>date('Y-m-d H:i:s'),'pegawaiubahpengirimankemenkes'=>Yii::app()->user->getState('pegawai_id')));
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
       $obatalkes_id = $_POST['obatalkes_id'];
        
        $model = ObatalkesM::model()->findByPk($obatalkes_id);
        
        $briging = new BridgingKemenkes();
        $query = '{
                "id_kebutuhan":"13"
                }';
        $queryHeaderParam = array('id_kebutuhan: 13');
//        $query = "nomr/".$model->pasien->no_rekam_medik;
        $dataBridging = $briging->search_apd("",$queryHeaderParam);
        $decodeJson  = json_decode($dataBridging);
//         $myJSON = json_encode($dataBridging);
         
//        echo '<pre>';
//        print_r($decodeJson);
//        exit();
        $checkPasien = true;
        $pesan = "";
        $sukses = 0;
        $pesanType = 0;
        $logpenghapusan = "";
        
        if(!is_array($decodeJson->apd)){
                if(isset($decodeJson->apd->status) && $decodeJson->apd->status != '201'){
                    $checkPasien = false;
                    $pesan = $decodeJson->apd->message;
                }else{
                    
                     $checkPasien = false;
                    $pesan = $decodeJson->apd;
                }
            }else{
                 if(isset($decodeJson->apd[0]->id_kebutuhan)){
                    $checkPasien = true;
                    if(count($decodeJson->apd)>0){
//                        $ss = array();
                        foreach ($decodeJson->apd as $dataDig){
                            if($dataDig->id_kebutuhan =='13'){
                                $ss[]=json_encode($dataDig);
                            }
                            
                        }
//                        echo '<pre>';
//                        print_r($ss);
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
                "id_kebutuhan":"13"
                }';
            $dataBridgingKemenkes = $briging->delete_apd($queryInsert);
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
//                 echo '<pre>';
//            print_r($decodeJsonKemenkes);
//exit();   
            if(isset($decodeJsonKemenkes)){
                if(isset($decodeJsonKemenkes->apd)){
                    if($decodeJsonKemenkes->apd[0]->status == '200'){
                        $sukses = 1;
                        $pesan = $decodeJsonKemenkes->apd[0]->message;
                        ObatalkesM::model()->updateByPk($model->obatalkes_id, array('tglpenghapusankemenkes'=>date('Y-m-d H:i:s'),'pegawaipenghapusankemenkes'=>Yii::app()->user->getState('pegawai_id'),'logpenghapusandatakemenkes'=>$logpenghapusan));
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
