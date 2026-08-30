<?php
/**
 * digunakan untuk mengelola menu observasi donor darah
 * RSST-1498
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Elham Budianto <elhambudianto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class ObservasiDonorDarahController extends MyAuthController
{	    
    public $layout = '//layouts/column2';
    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.observasiDonorDarah.';
    public $path_view_nyeri = 'bankDarah.views.observasiDonorDarah.skalanyeri.';
    public $init = '';        

    /**
     * dignakan untuk masuk ke menu observasi donor darah
     * @param type $daftardonasi_id
     * @param type $observasipendonor_id
     */
    public function actionIndex($daftardonasi_id=null,$observasipendonor_id=null)
    {
        $model = new BDObservasipendonorT;
        $modGambar = new BDGambarnyeriT;
        $modNyeri = new BDPeriksanyeripendonorT;
        $modDaftarDonasi = new BDDaftardonasiT;
        $modSeleksi = new BDSeleksipendonorT;
        $modPendonor = new BDPendonorM;
        $cekKantong = new KantongdarahT;
        if (!empty($daftardonasi_id)){
            $modDaftarDonasi = BDDaftardonasiT::model()->findByPk($daftardonasi_id);
            if(!empty($modDaftarDonasi->ruangrekrutmen->ruangan_nama)) {
                $modDaftarDonasi->ruangrekrutmen_nama = $modDaftarDonasi->ruangrekrutmen->ruangan_nama;
            } else {
                $modDaftarDonasi->ruangrekrutmen_nama = $modDaftarDonasi->lokasi_rekruitmen;
            }
                    
            $modPendonor = BDPendonorM::model()->findByPk($modDaftarDonasi->pendonor_id);
            $modPendonor->no_formulir = $modDaftarDonasi->no_formulir;
            $modPendonor->tgllahir = !empty($modPendonor->tgllahir)?MyFormatter::formatDateTimeForUser($modPendonor->tgllahir):null;
            $modPendonor->umur = CustomFunction::getUmur($modPendonor->tgllahir);
            $modSeleksi = BDSeleksipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));   
            
            $cekKantong = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id'=>$daftardonasi_id));
            if (!empty($cekKantong)) {
                $cekKantong->jeniskantong_nama = $cekKantong->jeniskantongdarah->nama_jenis;
            }
            
            /**
             * Pencarian riwayat donor sebelumnya
             */
            $modObs = ObservasipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftardonasi_id));
            if (!empty($modObs)) {
                $sql = 
                    "select * FROM (
                        select 
                        ROW_NUMBER() OVER (ORDER BY observasipendonor_id) AS nomor_urut, 
                        daftardonasi_id,
                        pendonor_id,
                        date(waktu_observasi) as waktu_observasi,
                        observasipendonor_id
                        from observasipendonor_t where pendonor_id = '".$modPendonor->pendonor_id."'
                        order by observasipendonor_id ASC
                    ) AS sub
                    GROUP BY nomor_urut,  daftardonasi_id, pendonor_id, waktu_observasi, observasipendonor_id
                    HAVING max(observasipendonor_id) <= '".$modObs->observasipendonor_id."'
                    order by observasipendonor_id ASC";
                $modObservasi = Yii::app()->db->createCommand($sql)->queryAll();
            
                if ($modObservasi > 1) {
                    foreach($modObservasi as $mod){
                        $hasil = $mod['nomor_urut']-1;   
                    }
                    $sql = 
                            " select * FROM (
                                select 
                                    ROW_NUMBER() OVER (ORDER BY observasipendonor_id) AS nomor_urut, 
                                    daftardonasi_id,
                                    pendonor_id,
                                    date(waktu_observasi) as waktu_observasi,
                                    observasipendonor_id
                                from observasipendonor_t where pendonor_id = '".$modPendonor->pendonor_id."'
                                order by observasipendonor_id ASC
                            ) AS sub
                            group by nomor_urut,  daftardonasi_id, pendonor_id, waktu_observasi, observasipendonor_id
                            having max(nomor_urut) = '".$hasil."'
                            order by observasipendonor_id ASC";
                    $result = Yii::app()->db->createCommand($sql)->queryAll();
                    foreach ($result as $item){
                        $modPendonor->waktu_observasi = date('d M Y', strtotime($item['waktu_observasi']));
                    }
                } else {
                    $modPendonor->waktu_observasi = '-';
                }
            } else {
                $modPendonor->waktu_observasi = '-';
            }
            
            if (empty($modSeleksi)){
                $modSeleksi = new BDSeleksipendonorT;
            }else{
                if(!empty($modSeleksi->dokter_id)){
                    $modSeleksi->dokter_nama = $modSeleksi->dokter->namaLengkap;
                }
                if(!empty($modSeleksi->petugas_id)){
                    $modSeleksi->petugas_nama = $modSeleksi->petugas->namaLengkap;
                }
            }
        }
        $this->render($this->path_view.'index',array(
            'model' => $model,
            'modGambar'=>$modGambar,
            'modNyeri'=>$modNyeri,
            'modPendonor'=>$modPendonor,
            'modSeleksi'=>$modSeleksi,
            'modDaftarDonasi'=>$modDaftarDonasi,
            'cekKantong'=>$cekKantong
        ));
    }
    
    /**
     * fungsi simpan observasi donor darah
     * @param type $daftardonasi_id
     * @param type $observasipendonor_id
     */
    public function actionPenyadapan($daftardonasi_id,$observasipendonor_id=null)
    {
        $this->layout = '//layouts/iframe';
        
        $model = new BDObservasipendonorT;
        $model->kelancarandarah = Params::ALIRAN_DARAH_LANCAR;
        $model->tglmulaiobservasi = date('d M Y');
        $model->jamawal = date('H:i:s');
        $model->jamakhir = date('H:i:s', strtotime("+5 minutes"));
        $model->waktu_observasi = date('d M Y H:i:s');
        $model->durasi_penyadapan = '00:05:00';
        $model->ada_keluhan = 'Tidak Ada';
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
        $model->nama_pegawai = $cekPegawai->nama_pegawai;
        
        $getCeklis = array();
        $cekObservasi = BDObservasipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));
        if (!empty($cekObservasi)){
            $model = $cekObservasi;
            $model->petugas_nama = $model->petugas->namaLengkap;            
            $model->jamawal = date('H:i:s',strtotime($model->tglmulaiobservasi));
            $model->jamakhir = date('H:i:s',strtotime($model->sd_observasi));
            $model->tglmulaiobservasi = MyFormatter::formatDatetimeforUser(date('d M Y',strtotime($model->tglmulaiobservasi)));
            $model->waktu_observasi = date('d M Y H:i:s',strtotime($model->waktu_observasi));
            $model->alasanbatal_penyadapan = $model->alasanbatal_penyadapan;
            if($model->keluhan_pendonor == null){
                $model->ada_keluhan = 'Tidak Ada';
            }else{
                $model->ada_keluhan = 'Ada';
            }
            $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
            $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
            $model->nama_pegawai = $cekPegawai->nama_pegawai;
        }
        
        $modDaftarDonasi = BDDaftardonasiT::model()->findByPk($daftardonasi_id);    
        
        $modSeleksi = BDSeleksipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));

        if (isset($_POST['BDObservasipendonorT'])){
            
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{                                
                $model->attributes = $_POST['BDObservasipendonorT'];    
                $model->seleksidonor_id = $modSeleksi->seleksidonor_id;
                $model->daftardonasi_id = $modDaftarDonasi->daftardonasi_id;
                $model->pendonor_id = $modDaftarDonasi->pendonor_id;
                $model->waktu_observasi = MyFormatter::formatDateTimeForDb($model->waktu_observasi);
                $tgl = $model->tglmulaiobservasi;
                $model->tglmulaiobservasi = MyFormatter::formatDateTimeForDb($tgl).' '.$_POST['BDObservasipendonorT']['jamawal'];
                $model->sd_observasi = MyFormatter::formatDateTimeForDb($tgl).' '.$_POST['BDObservasipendonorT']['jamakhir'];
                $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
                
                if (!empty($model->keluhan_pendonor)){
                    $model->keluhan_pendonor = implode(",",$model->keluhan_pendonor);     
                }
                
                if (!empty($model->observasipendonor_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                    
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }
                                                                                              
                
                $ok = $ok && $model->save();     
                
                $donasi = 0;
                $sql = "select * FROM (
                            select 
                            ROW_NUMBER() OVER (ORDER BY daftardonasi_id) AS nomor_urut, 
                            daftardonasi_id,
                            pendonor_id,
                            donasi_ke
                            from daftardonasi_t 
                            where pendonor_id = '".$model->pendonor_id."' AND donasi_ke >= 1 AND daftardonasi_id != '".$model->daftardonasi_id."'
                            order by daftardonasi_id ASC
                        ) AS sub
                        GROUP BY nomor_urut,  daftardonasi_id, pendonor_id, donasi_ke
                        order by daftardonasi_id ASC";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                if (!empty($result)) {
                    foreach ($result as $res){
                        $donasi = $res['donasi_ke'];
                    }
                } else {
                    $donasi = 0;
                }
                                
                $up = DaftardonasiT::model()->findByPk($model->daftardonasi_id);
                $up->donasi_ke = $donasi + 1;
                $up->status = Params::STATUS_PENDONOR_OBSERVASI;
                $pendonor = PendonorM::model()->findByPk($up->pendonor_id);
                $pendonor->donor_itd_ke = $pendonor->donor_itd_ke + 1; 

                $ok = $ok && $up->save() && $pendonor->save();
                
                $cekKantong = BDKantongdarahT::model()->findAllByAttributes(array('pendonor_id'=>$model->pendonor_id,'daftarpendonor_id'=>$model->daftardonasi_id));
                if (!empty($cekKantong)){
                    foreach($cekKantong as $kan){
                        $kan->observasipendonor_id = $model->observasipendonor_id;
                        $ok = $ok && $kan->save();
                    }
                }

                
                
                if($ok){                        
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('penyadapan','daftardonasi_id'=>$daftardonasi_id,'observasipendonor_id'=>$model->observasipendonor_id,'sukses'=>1));       
                }else{                        
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {  var_dump($exc->getMessage());              
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
        $this->render($this->path_view.'observasi/index',array(
            'model' => $model,            
            'modDaftarDonasi'=>$modDaftarDonasi,
            'getCeklis'=>$getCeklis
        ));
    }
    
    /**
     * Digunakan untuk menampilkan detail observasi
     * @author  Andyka Putra <andykaputra@.com>
     * @param type $daftardonasi_id
     * @param type $observasipendonor_id
     * RSST-1534
     */
    public function actionDetailobservasi($daftardonasi_id,$observasipendonor_id)
    {
        $format = new MyFormatter();
        $this->layout = '//layouts/iframe';
        $model = BDObservasipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));
        
        $modDaftarDonasi = BDDaftardonasiT::model()->findByPk($daftardonasi_id);
        
        $modPendonor = BDPendonorM::model()->findByPk($modDaftarDonasi->pendonor_id);
        $modPendonor->no_formulir = $modDaftarDonasi->no_formulir;
        $modPendonor->tgllahir = !empty($modPendonor->tgllahir)?MyFormatter::formatDateTimeForUser($modPendonor->tgllahir):null;
        $modPendonor->umur = CustomFunction::getUmur($modPendonor->tgllahir);
        
        $modSeleksi = BDSeleksipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));        
               
        if (empty($modSeleksi)){
            $modSeleksi = new BDSeleksipendonorT;
        }
       
        $this->render($this->path_view.'_detail',array(
            'format'=>$format,
            'model' => $model,
            'modPendonor'=>$modPendonor,
            'modSeleksi'=>$modSeleksi,
            'modDaftarDonasi'=>$modDaftarDonasi,
            'daftardonasi_id'=>$daftardonasi_id,
            'observasipendonor_id'=>$observasipendonor_id,
        ));
    }
    
    /**
     * Digunakan untuk menampilkan detail observasi
     * @param type $daftardonasi_id
     * @param type $observasipendonor_id
     */
    public function actionDetailtabobservasi($daftardonasi_id,$observasipendonor_id)
    {
        $format = new MyFormatter();
        $this->layout = '//layouts/iframe';
        $model = BDObservasipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));
        
        $modDaftarDonasi = BDDaftardonasiT::model()->findByPk($daftardonasi_id);
        
        $modPendonor = BDPendonorM::model()->findByPk($modDaftarDonasi->pendonor_id);
        $modPendonor->no_formulir = $modDaftarDonasi->no_formulir;
        $modPendonor->tgllahir = !empty($modPendonor->tgllahir)?MyFormatter::formatDateTimeForUser($modPendonor->tgllahir):null;
        $modPendonor->umur = CustomFunction::getUmur($modPendonor->tgllahir);
        
        $modSeleksi = BDSeleksipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));        
               
        if (empty($modSeleksi)){
            $modSeleksi = new BDSeleksipendonorT;
        }
       
        $this->render($this->path_view.'detailobservasi',array(
            'format'=>$format,
            'model' => $model,
            'modPendonor'=>$modPendonor,
            'modSeleksi'=>$modSeleksi,
            'modDaftarDonasi'=>$modDaftarDonasi
        ));
    }
    
    /**
     * Digunakan untuk menampilkan detail nyeri
     * @param type $daftardonasi_id
     */
    public function actionDetailtabnyeri($daftardonasi_id)
    {
        $format = new MyFormatter();
        $this->layout = '//layouts/iframe';
        $modDaftarDonor = BDDaftardonasiT::model()->findByPk($daftardonasi_id);
        $model = BDPeriksanyeripendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));
        $model->tglperiksanyeri = MyFormatter::formatDateTimeforUser(date('Y-m-d',strtotime($model->tglperiksanyeri)));
        if (!empty($model)){
            $modPeriksaGambar = BDGambarnyeriT::model()->findAllByAttributes(array('periksanyeripendonor_id'=>$model->periksanyeripendonor_id));
        }else{
            $modPeriksaGambar = BDGambarnyeriT::model()->findAll(" periksanyeripendonor_id is null ");
        }
                    
        $modGambarTubuh = new BDGambartubuhM();

        $modBagianTubuh = new BDBagiantubuhM();
        $this->render($this->path_view_nyeri.'index',array(
            'format'=>$format,
            'model' => $model,
            'modGambarTubuh' => $modGambarTubuh,
            'modPeriksaGambar' => $modPeriksaGambar,                
            'modBagianTubuh' => $modBagianTubuh,
            'modDaftarDonor'=>$modDaftarDonor
        ));
    }
    
    /**
     * Digunakan untuk mengecek data skala nyeri dan observasi sebelum submit
     */
    public function actionGetData() {
          if (Yii::app()->request->isAjaxRequest) {
              $id = isset($_POST['id']) ? $_POST['id'] : null;              
              $tabulasi = isset($_POST['tabulasi']) ? $_POST['tabulasi'] : null;
              
              if(isset($id)) {
                  $modObservasipendonor = ObservasipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$id));
                  $modPeriksanyeripendonor = PeriksanyeripendonorT::model()->findByAttributes(array('daftardonasi_id'=>$id));
                  $kantongdarah = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id'=>$id));
                    if (empty($kantongdarah) && $tabulasi == 'observasiNyeri'){
                        $data['sukses'] = 1;
                        $data['pesan'] = 'data ada';
                    }elseif(empty($modPeriksanyeripendonor)){
                         if ($tabulasi != 'observasiNyeri'){
                            $data['sukses'] = 0;
                            $data['pesan'] = 'Anda Belum melakukan transaksi Skala Nyeri!';
                         }
                    }elseif(isset($modObservasipendonor) && isset($modPeriksanyeripendonor) && $modObservasipendonor->is_batalpenyadapan == false) {
                        $data['sukses'] = 1;
                        $data['pesan'] = 'data ada';
                    }else if(isset($modObservasipendonor) && isset($modPeriksanyeripendonor) && $modObservasipendonor->is_batalpenyadapan == true){
                        if ($tabulasi != 'observasiDonorDarah' || $tabulasi != 'observasiPendonor'){
                          $data['sukses'] = 1;
                          $data['pesan'] = 'Penyadapan Darah Gagal';
                        }
                    }else if(empty($modObservasipendonor) && empty($modPeriksanyeripendonor)){
                        if ($tabulasi != 'observasiDonorDarah' && $tabulasi != 'observasiPendonor'){
                          $data['sukses'] = 0;
                          $data['pesan'] = 'Anda Belum melakukan transaksi Skala Nyeri dan Observasi Donor Darah!';
                        }
                    }else if(empty($modObservasipendonor)){
                        if ($tabulasi != 'observasiDonorDarah' && $tabulasi != 'observasiNyeri'){
                          $data['sukses'] = 0;
                          $data['pesan'] = 'Anda Belum melakukan transaksi Observasi Donor Darah!';
                        }
                    }

                  $data['observasipendonor_id'] = !empty($modObservasipendonor->observasipendonor_id)?$modObservasipendonor->observasipendonor_id:null;
              }
               echo CJSON::encode($data);
               Yii::app()->end();
          }
    }
    
   /**
     * fungsi simpan observasi donor darah, seteah penyadapan
     * @param type $daftardonasi_id
     * @param type $observasipendonor_id
     */
    public function actionPendonor($daftardonasi_id,$observasipendonor_id=null)
    {
        $this->layout = '//layouts/iframe';
              
        $getCeklis = array();
        $model = BDObservasipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));                
        $model->tanggalobservasi_setelahpenyadapan = !empty($model->tanggalobservasi_setelahpenyadapan)?$model->tanggalobservasi_setelahpenyadapan:date('d M Y H:i:s');        
        $model->kelancarandarah_setelahpenyadapan = !empty($model->kelancarandarah_setelahpenyadapan)?$model->kelancarandarah_setelahpenyadapan:Params::ALIRAN_DARAH_LANCAR;         
        $model->suhu_setelahpenyadapan = !empty($model->suhu_setelahpenyadapan)?number_format($model->suhu_setelahpenyadapan,2,",",""):null;
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
        $model->nama_pegawai = $cekPegawai->nama_pegawai;
        
        if (empty($model->petugaspenyadapan_id)) {
            $cekSkalaNyeri = PeriksanyeripendonorT::model()->findByAttributes(array('daftardonasi_id' => $_GET['daftardonasi_id']));
            $model->petugaspenyadapan_id = !empty($cekSkalaNyeri->petugas_id) ? $cekSkalaNyeri->petugas_id : "";
            $model->petugaspenyadapan_nama = !empty($cekSkalaNyeri->petugas_id) ? $cekSkalaNyeri->petugaspenyadap->namaLengkap : "";
        } else {
            $model->petugaspenyadapan_id = !empty($model->petugaspenyadapan_id)?$model->petugaspenyadapan_id : "";
            $model->petugaspenyadapan_nama = !empty($model->petugaspenyadapan_id)?$model->petugaspenyadapan->namaLengkap:"";
        }
            
        
        
        $modPenggunaan = new PenggunaanCoolboxdetT;
        $modDaftarDonasi = BDDaftardonasiT::model()->findByPk($daftardonasi_id);    
        $cekObservasi = BDObservasipendonorT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));
        if (!empty($cekObservasi)){
            $cekKantongs = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id'=>$daftardonasi_id));
            $cekCoolbox = PenggunaanCoolboxdetT::model()->findByAttributes(array('daftardonasi_id'=>$daftardonasi_id));
            if(!empty($cekCoolbox) && $cekKantongs->nomorbarcode_sample == $cekCoolbox->nomorbarcod_sample){
                $modPenggunaan->penggunaan_coolbox_id = $cekCoolbox->penggunaan_coolbox_id;
            }
        }                
        $cekKantong = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id'=>$daftardonasi_id));    
        
        if (isset($_POST['BDObservasipendonorT'])){
            
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{                                
                $model->attributes = $_POST['BDObservasipendonorT'];   
                $model->tanggalobservasi_setelahpenyadapan = MyFormatter::formatDateTimeForDb($model->tanggalobservasi_setelahpenyadapan);
//                $model->volume = $_POST['BDObservasipendonorT']['volume'];   
//                $model->ada_sampelkonfirmasi = $_POST['BDObservasipendonorT']['ada_sampelkonfirmasi'];   
//                $model->ada_sampelimltd = $_POST['BDObservasipendonorT']['ada_sampelimltd'];   
//                $model->ada_kantongdarah = $_POST['BDObservasipendonorT']['ada_kantongdarah'];   
                $model->suhu_setelahpenyadapan = !empty($model->suhu_setelahpenyadapan)?MyFormatter::formatNumberForDb($model->suhu_setelahpenyadapan):null;
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->pegawai_id = Yii::app()->user->getState('pegawai_id');                    
                    
                if (!empty($model->keluhan_setelahpenyadapan)){
                    $model->keluhan_setelahpenyadapan = implode(",",$model->keluhan_setelahpenyadapan);     
                }
                                
                $ok = $ok && $model->save();                                                                               
                
                if(!empty($cekCoolbox) && $cekKantongs->nomorbarcode_sample == $cekCoolbox->nomorbarcod_sample){
                    PenggunaanCoolboxdetT::model()->deleteAllByAttributes(array('nomorbarcod_sample'=>$cekCoolbox->nomorbarcod_sample));
                    if (isset($_POST['PenggunaanCoolboxdetT'])){
                        $cekKantongnya = KantongdarahT::model()->findAllByAttributes(array('daftarpendonor_id'=>$daftardonasi_id));
                        if(!empty($cekKantongnya)){
                            foreach ($cekKantongnya as $value){
                                $modPenggunaan = new PenggunaanCoolboxdetT;
                                $modPenggunaan->daftardonasi_id = $modDaftarDonasi->daftardonasi_id;
                                $modPenggunaan->kantongdarah_id = $value->kantongdarah_id;
                                $modPenggunaan->penggunaan_coolbox_id = $_POST['PenggunaanCoolboxdetT']['penggunaan_coolbox_id'];
                                $modPenggunaan->nomorbarcod_sample = $value->nomorbarcode_sample;
                                $modPenggunaan->save();
                            }
                        }
                    }
                }else{
                    if (isset($_POST['PenggunaanCoolboxdetT'])){
                        $cekKantongnya = KantongdarahT::model()->findAllByAttributes(array('daftarpendonor_id'=>$daftardonasi_id));
                        if(!empty($cekKantongnya)){
                            foreach ($cekKantongnya as $value){
                                $modPenggunaan = new PenggunaanCoolboxdetT;
                                $modPenggunaan->daftardonasi_id = $modDaftarDonasi->daftardonasi_id;
                                $modPenggunaan->kantongdarah_id = $value->kantongdarah_id;
                                $modPenggunaan->penggunaan_coolbox_id = $_POST['PenggunaanCoolboxdetT']['penggunaan_coolbox_id'];
                                $modPenggunaan->nomorbarcod_sample = $value->nomorbarcode_sample;
                                $modPenggunaan->save();
                            }
                        }
                    }
                }
                
                if($ok){                        
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('pendonor','daftardonasi_id'=>$daftardonasi_id,'observasipendonor_id'=>$model->observasipendonor_id,'sukses'=>1));       
                }else{                        
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }                
            } catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
 

        $this->render($this->path_view.'pendonor/index',array(
            'model' => $model,            
            'modDaftarDonasi'=>$modDaftarDonasi,
            'getCeklis'=>$getCeklis,
            'modPenggunaan'=>$modPenggunaan,
            'cekKantong'=>$cekKantong,
            ));
    }
   
    /**
     * Print Label Penyadapan
     * @author Andyka Putra <andykaputra@.com>
     * @param integer $observasipendonor_id
     */
    public function actionPrintLabel($observasipendonor_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $id = isset($observasipendonor_id) ? $observasipendonor_id : '';
        if (isset($id)) {
            $modObservasi = ObservasipendonorT::model()->findByPk($id);
        }
        $judul_print = 'Label';
        $this->render($this->path_view.'observasi._printLabel', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modObservasi'=>$modObservasi

        ));
    }   
}