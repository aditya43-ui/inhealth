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
class PasienRawatInapController extends MyAuthController
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
           
        $this->pageTitle = Yii::app()->name." - Pasien Rawat Inap";
        $format = new MyFormatter();
        $model = new ROCInfopasienmasukkamarV;
        $model->tgl_awal  = date('Y-m-d', time() - (3600 * 24 * 60));
        //$model->tgl_awal  = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
		$model->tgl_awall = date('Y-m-d');
		$model->tgl_akhirl = date('Y-m-d');
        $model->ceklis = false;

        if(isset ($_REQUEST['ROCInfopasienmasukkamarV'])){
            $model->attributes = $_REQUEST['ROCInfopasienmasukkamarV'];
            $model->ceklis = $_REQUEST['ROCInfopasienmasukkamarV']['ceklis'];
            $model->tgl_awal = isset($_REQUEST['ROCInfopasienmasukkamarV']['tgl_awal'])?$format->formatDateTimeForDb($_REQUEST['ROCInfopasienmasukkamarV']['tgl_awal']):'';
            $model->tgl_akhir = isset($_REQUEST['ROCInfopasienmasukkamarV']['tgl_akhir'])?$format->formatDateTimeForDb($_REQUEST['ROCInfopasienmasukkamarV']['tgl_akhir']):'';
			$model->tgl_awall  = $format->formatDateTimeForDb($_REQUEST['ROCInfopasienmasukkamarV']['tgl_awall']);
            $model->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['ROCInfopasienmasukkamarV']['tgl_akhirl']);
            $model->prefix_pendaftaran = isset($_REQUEST['ROCInfopasienmasukkamarV']['prefix_pendaftaran'])?$_REQUEST['ROCInfopasienmasukkamarV']['prefix_pendaftaran']:'';
       }
       
        $this->render('index',array('model'=>$model,'format'=>$format));
  }

  public function actionPasienKemenkes() {
    if (Yii::app()->request->isAjaxRequest) {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $type = $_POST['type'];
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $briging = new BridgingKemenkes();
        $queryHeaderParam = array('nomr: ' . $model->pasien->no_rekam_medik);
        $dataBridging = $briging->search_pasien("",$queryHeaderParam);
        $decodeJson  = json_decode($dataBridging);
        
        $checkPasien = true;
        $pesan = "";
        $sukses = 0;
        $pesanType = 0;  
        
        if(!is_array($decodeJson->pasien)){
                if(isset($decodeJson->pasien->status) && $decodeJson->pasien->status != '201' && $type != 'tambah'){
                   if($type == 'ubah'){
                        $checkPasien = true;
                    }else{
                        $checkPasien = false;
                    }
                }
            }
            else{
                 if(!isset($decodeJson->pasien[0]->nomr)){
                     if(isset($decodeJson->pasien[0]->status) && $decodeJson->pasien[0]->status != '201' && $type != 'tambah'){
                        if($type == 'ubah'){
                            $checkPasien = true;
                        }else{
                            $checkPasien = false;
                        }
                    }
//                    $checkPasien = true;
//                    if(count($decodeJson->pasien)>0){
//                        $ss = array();
//                        foreach ($decodeJson->pasien as $dataDig){
//                            $ss[]=serialize($dataDig);
//                        }
//                    }
//                    $logpenghapusan = $myJSON;
                }
            }  
        
//        if(isset($decodeJson->pasien)){
//            if(isset($decodeJson->pasien[0]->status) && $decodeJson->pasien[0]->status != '201' && $type != 'tambah'){
//                if($type == 'ubah'){
//                    $checkPasien = true;
//                }else{
//                    $checkPasien = false;
//                }
//            }
//        }
//        if(isset($decodeJson->pasien->status) && $decodeJson->pasien->status != '201' && $type != 'tambah'){
//            if($type == 'ubah'){
//                $checkPasien = true;
//            }else{
//                $checkPasien = false;
//            }
//            
//        }
            $statusPulang = '1';
            if(isset($model->pasienpulang)){
                if(isset($model->pasienpulang->carakeluar)){
                    if($model->pasienpulang->carakeluar->statuskeluar_kemenkes >= 0){
                        $statusPulang = $model->pasienpulang->carakeluar->statuskeluar_kemenkes;
                    }
                }
            }
            
            
        if($checkPasien){
//            "kecamatan":"'.(isset($model->pasien->kecamatan)?(!empty($model->pasien->kecamatan->kodekecamatan_kemenkes)?$model->pasien->kecamatan->kodekecamatan_kemenkes:""):"").'",
            $queryInsert = '{"noc":"'.$model->pasien->no_identitas_pasien.'",
                "nomr": "'.$model->pasien->no_rekam_medik.'",
                "initial": "'.$model->pasien->nama_bin.'" ,
                "nama_lengkap": "'.$model->pasien->nama_pasien.'",
                "tglmasuk":"'.MyFormatter::formatDateTimeForDb($model->tgl_pendaftaran).'",
                "gender":"'.(($model->pasien->jeniskelamin== Params::JENIS_KELAMIN_LAKI_LAKI)?1:2).'",
                "birthdate":"'.MyFormatter::formatDateTimeForDb($model->pasien->tanggal_lahir).'",
                "kewarganegaraan":"'.(($model->pasien->warga_negara =='WNI')?1:36).'",
                "sumber_penularan":"3",
                "kecamatan":"'.(isset($model->pasien->kecamatan)? (!empty($model->pasien->kecamatan->kodekecamatan_kemenkes)?$model->pasien->kecamatan->kodekecamatan_kemenkes:"") :"").'",
                "tglkeluar":"'.(isset($model->pasienpulang)? MyFormatter::formatDateTimeForDb($model->pasienpulang->tglpasienpulang):"000-00-00").'",
                "status_keluar":"'.$statusPulang.'",
                "tgl_lapor":"'.date('Y-m-d H:i:s').'",
                "status_rawat":"'.(isset($model->jeniskasuspenyakit)? (!empty($model->jeniskasuspenyakit->statusrawat_kemenkes)?$model->jeniskasuspenyakit->statusrawat_kemenkes:"4"):"4").'",
                "status_isolasi":"4",
                "email":"'.(!empty($model->pasien->alamatemail)?$model->pasien->alamatemail:"-").'",
                "notelp":"'.(!empty($model->pasien->alamatemail)?$model->pasien->no_telepon_pasien:"-").'",
                "sebab_kematian":"'.(isset($model->pasienpulang)?$model->pasienpulang->keterangankeluar:"-").'"
                }';
            
            if($type=='tambah'){
                $dataBridgingKemenkes = $briging->create_pasien($queryInsert);
            }
            if($type=='ubah'){
                $dataBridgingKemenkes = $briging->update_pasien($queryInsert);
            }
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
             
            if(isset($decodeJsonKemenkes)){
                $checksimpan = false;
                
                if(is_array($decodeJsonKemenkes->pasien)){
                    if($decodeJsonKemenkes->pasien[0]->status == '200'){
                        $checksimpan = true;
                        $pesan = $decodeJsonKemenkes->pasien[0]->message;
                    }
                }else{
                    if(isset($decodeJsonKemenkes->pasien)){
                        if($decodeJsonKemenkes->pasien->status == '200'){
                            $checksimpan = true;
                            $pesan = $decodeJsonKemenkes->pasien->message;
                        }
                    }
                }
                
                if($checksimpan){
                    $sukses = 1;
//                    $pesan = $decodeJsonKemenkes->pasien[0]->message;
                    $pesanType = 0;
                    if($type=='tambah'){
                        PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('tglpengiriminkemenkes'=>date('Y-m-d H:i:s'),'pegawaipengirimkemenkes'=>Yii::app()->user->getState('pegawai_id'),'statuspengiriman'=>'Sudah Terkirim'));
                    }else if($type=='ubah'){
                        PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('tglubahpengirimankemenkes'=>date('Y-m-d H:i:s'),'pegawaiubahpengirimankemenkes'=>Yii::app()->user->getState('pegawai_id')));
                    }
                }
                
                
//                if(isset($decodeJsonKemenkes->pasien)){
//                    if($decodeJsonKemenkes->pasien[0]->status == '200'){
//                       
//                    }
//                }
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
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $briging = new BridgingKemenkes();
        
        $queryHeaderParam = array('nomr: ' . $model->pasien->no_rekam_medik);
        $dataBridging = $briging->search_pasien("", $queryHeaderParam);
        $decodeJson  = json_decode($dataBridging);
         $myJSON = json_encode($dataBridging);
         
//        $query = "nomr/".$model->pasien->no_rekam_medik;
//        $dataBridging = $briging->search_pasien($query);
//        $decodeJson  = json_decode($dataBridging);
        
        $checkPasien = true;
        $pesan = "";
        $sukses = 0;
               $pesanType = 0;
          $logpenghapusan = "";
          
            if(!is_array($decodeJson->pasien)){
                if(isset($decodeJson->pasien->status) && $decodeJson->pasien->status != '201'){
                    $checkPasien = false;
                    $pesan = $decodeJson->pasien->message;
                }else{
                    
                     $checkPasien = false;
                    $pesan = $decodeJson->pasien;
                }
            }else{
                 if(isset($decodeJson->pasien[0]->nomr)){
                    $checkPasien = true;
                    if(count($decodeJson->pasien)>0){
                        $ss = array();
                        foreach ($decodeJson->pasien as $dataDig){
                            $ss[]=serialize($dataDig);
                        }
                    }
                    $logpenghapusan = $myJSON;
                }
            }   
//        if(count($decodeJson->pasien)>0){
//            $checkPasien = true;
//        }else{
//            if(isset($decodeJson->pasien->status) && $decodeJson->pasien->status != '201'){
//                $checkPasien = false;
//            }
//        }
      
        if($checkPasien){
            $queryHeaderParam = array('nomr: ' . $model->pasien->no_rekam_medik);
//            $query = "/nomr/".$model->pasien->no_rekam_medik;
//            $queryInsert = '{
//                "nomr":"'.$model->pasien->no_rekam_medik.'",
//                }';
//            $query = '{
//                        "request":
//                         {
//                                "norm":"' . $model->pasien->no_rekam_medik . '"
//                        }
//                    }';
            $dataBridgingKemenkes = $briging->delete_pasien("",$queryHeaderParam);
            $decodeJsonKemenkes  = json_decode($dataBridgingKemenkes);
//                 echo '<pre>';
//            print_r($decodeJsonKemenkes);
//exit();   
            if(isset($decodeJsonKemenkes)){
                if(isset($decodeJsonKemenkes->pasien)){
                    if($decodeJsonKemenkes->pasien[0]->status == '200'){
                        $sukses = 1;
                        $pesan = $decodeJsonKemenkes->pasien[0]->message;
                        PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('tglpenghapusankemenkes'=>date('Y-m-d H:i:s'),'pegawaipenghapusankemenkes'=>Yii::app()->user->getState('pegawai_id'),'logpenghapusandatakemenkes'=>$logpenghapusan));
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
