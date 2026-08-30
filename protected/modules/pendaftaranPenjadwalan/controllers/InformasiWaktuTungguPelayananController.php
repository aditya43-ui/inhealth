<?php

class InformasiWaktuTungguPelayananController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'pendaftaranPenjadwalan.views.informasiWaktuTungguPelayanan.';

  public function actionIndex()
  {
    $model = new WaktutunggupelayananT();
    $format = new MyFormatter;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    

    if (isset($_GET['WaktutunggupelayananT'])) {
      $model->attributes = $_GET['WaktutunggupelayananT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['WaktutunggupelayananT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['WaktutunggupelayananT']['tgl_akhir']);
      $model->no_pendaftaran = $_GET['WaktutunggupelayananT']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['WaktutunggupelayananT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['WaktutunggupelayananT']['nama_pasien'];
      $model->status = $_GET['WaktutunggupelayananT']['status'];
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionKirimKeBpjs()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];

      $respon = $this->antrianOnlineKirim($id);

      $data['status'] = $respon['status'];
      $data['pesan'] = $respon['pesan'];
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionRiwayat($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modWaktuTunggu = WaktutunggupelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
    $modTambahAntrian = BpjstambahantreanV::model()->findByAttributes(array('kodebooking'=>$modPendaftaran->no_pendaftaran));
    $kodebooking = $modWaktuTunggu->kode_booking;
    $nourut = 0;
    // $waktu_riwayat[$nourut]['urut'] = $nourut;
    // $waktu_riwayat[$nourut]['tanggal'] = $modTambahAntrian->tglakandilayani;
    // $waktu_riwayat[$nourut]['terkirim'] = (($modPendaftaran->statuskirim_wsbpjs == true)?"Ya":"Tidak");
    // $waktu_riwayat[$nourut]['response_list'] = $modPendaftaran->respons_wsbpjs;
    // $waktu_riwayat[$nourut]['task'] = "Tambah Antrian Online";
    // $waktu_riwayat[$nourut]['tgl_kirim'] = (($modPendaftaran->statuskirim_wsbpjs == true)? (!empty($modPendaftaran->update_time)?$modPendaftaran->update_time:$modPendaftaran->create_time):"");

    $nourut = ($nourut + 1);
    $modWaktuTungguList = WaktutunggupelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'task_id ASC'));

    if(!empty($modWaktuTungguList)){
      foreach($modWaktuTungguList as $dataWaktu){
        $waktu_riwayat[$nourut]['urut'] = $nourut;
        $waktu_riwayat[$nourut]['tanggal'] = $dataWaktu->waktutunggu_rs;
        $waktu_riwayat[$nourut]['terkirim'] = (($dataWaktu->statuskirim == true)?"Ya":"Tidak");
        $waktu_riwayat[$nourut]['response_list'] = $dataWaktu->response_list;
        $waktu_riwayat[$nourut]['task'] = $dataWaktu->task_name;
        $waktu_riwayat[$nourut]['task_id'] = $dataWaktu->task_id;
        $waktu_riwayat[$nourut]['tgl_kirim'] = (($dataWaktu->statuskirim == true)? (!empty($dataWaktu->update_time)?$dataWaktu->update_time:$dataWaktu->create_time):"");

        $nourut = ($nourut + 1);
      }
    }

    $this->render($this->path_view .'_riwayat', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'waktu_riwayat' => $waktu_riwayat,
      'kodebooking'=>$kodebooking
    ));
  }

  public function actionKirimAllKeBpjs()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = "Data Gagal Dikirim !!!";
      $sukses = 0;

   

    if (isset($_POST['WaktutunggupelayananT'])) {
      $model = new WaktutunggupelayananT();
      $format = new MyFormatter;
      $model->attributes = $_POST['WaktutunggupelayananT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_POST['WaktutunggupelayananT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_POST['WaktutunggupelayananT']['tgl_akhir']);
      $model->no_pendaftaran = $_POST['WaktutunggupelayananT']['no_pendaftaran'];
      $model->no_rekam_medik = $_POST['WaktutunggupelayananT']['no_rekam_medik'];
      $model->nama_pasien = $_POST['WaktutunggupelayananT']['nama_pasien'];
      $model->status = 2; //belum kirim bpjs

      $prov = $model->searchInfo();
      $prov->pagination = false;
      $modWaktu = $prov->data;

      $terkirim = true;
     
      if(!empty($modWaktu)){
        foreach($modWaktu as $dataWaktu){
          $respon = $this->antrianOnlineKirim($dataWaktu->pendaftaran_id);

          if($respon['status']==0){
            $terkirim = false;
          }
        }
      }

      if($terkirim == true){
        $sukses = 1;
        $pesan = "Data Berhasil Dikirim !!!";
      }else{
        $sukses = 0;
        $pesan = "Data Gagal Dikirim !!! Response Bisa Dilihat Pada Detail Riwayat";
      }
    }

      $data['status'] = $sukses;
      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function antrianOnlineKirim($pendaftaran_id){
    $resp_rollback = array();
    $pesan = "Data Gagal Dikirim !!!";
    $sukses = 0;

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modWaktuTunggu = WaktutunggupelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));

    $antrianonlinebpjs = new AntrianOnlineBpjs();
    $suksetambah = false;
    if($modPendaftaran->statuskirim_wsbpjs == null || $modPendaftaran->statuskirim_wsbpjs == false){
      $kodebooking = $modWaktuTunggu->kode_booking;
      $jenispasien = (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) ? "JKN" : "NON JKN");

      $nomorkartu = "";
      $nomorreferensi = "";
      $modSep = SepT::model()->findByPk($modPendaftaran->sep_id);
        if(!empty($modSep)){
            $nomorkartu = (!empty($modSep->nokartuasuransi)?$modSep->nokartuasuransi:"");
            $nomorreferensi = (!empty($modSep->norujukan)?$modSep->norujukan :"");
        }
        $nik = $modPendaftaran->pasien->no_identitas_pasien;
        $nohp = $modPendaftaran->pasien->no_mobile_pasien;

        $kodepoli = (!empty($modPendaftaran->ruangan)?$modPendaftaran->ruangan->kode_bpjs : "");
        $namapoli = (!empty($modPendaftaran->ruangan)?$modPendaftaran->ruangan->ruangan_nama : "");
        $pasienbaru = (($modPendaftaran->statuspasien == Params::STATUSPASIEN_BARU) ? 1: 0);
        $norm = $modPendaftaran->pasien->no_rekam_medik;
        $tanggalperiksa = date('Y-m-d',strtotime($modPendaftaran->tgl_pendaftaran));
        $kodedokter = (!empty($modPendaftaran->pegawai)?$modPendaftaran->pegawai->kodedokter_bpjs : "");
        $namadokter = (!empty($modPendaftaran->pegawai)?$modPendaftaran->pegawai->nama_pegawai : "");

        $jadwaldokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id'=>$modPendaftaran->pegawai_id,'jadwaldokter_tgl'=>$tanggalperiksa));

        $jampraktek = "";
        $sisakuotajkn = 50;
        $kuotajkn = 100;
        $sisakuotanonjkn = 0;
        $kuotanonjkn = 0;

        if(!empty($jadwaldokter)){
            $jam = $jadwaldokter->jadwaldokter_buka;
            $jamArray = explode(" ", $jam);
            $jamArray[1]= "-";
            $jamArray[0]= substr($jamArray[0],0,5);
            $jamArray[2]= substr($jamArray[2],0,5);
            $jamArray = implode('', $jamArray);
            $jampraktek = $jamArray;

            $sisakuotajkn = $jadwaldokter->maximumbpjsantrian;
            $kuotajkn = $jadwaldokter->maximumbpjsantrian;
            $sisakuotanonjkn = $jadwaldokter->maximumantrian;
            $kuotanonjkn = $jadwaldokter->maximumantrian;
        }
        $jeniskunjungan = 1;
        $nomorantrean = number_format($modPendaftaran->no_urutantri);
        $angkaantrean = number_format($modPendaftaran->no_urutantri);
        $estimasidilayani = $modPendaftaran->tglakandilayani;
        $stampwaktuantrian = strtotime($estimasidilayani);
        $estimasidilayani = $stampwaktuantrian*1000;
        
        $keterangan = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";

        if(Yii::app()->user->getState('antreanonlinewsbpjs')){
          $bodytambah = array("kodebooking"=>$kodebooking, "jenispasien"=>$jenispasien, "nomorkartu"=>$nomorkartu, "nik"=>$nik,"nohp"=>$nohp, "kodepoli"=>$kodepoli, "namapoli"=>$namapoli, "pasienbaru"=>$pasienbaru, "norm"=>$norm, "tanggalperiksa"=>$tanggalperiksa, "kodedokter"=>$kodedokter, "namadokter"=>$namadokter, "jampraktek"=>$jampraktek, "jeniskunjungan"=>$jeniskunjungan, "nomorreferensi"=>$nomorreferensi, "nomorantrean"=>$nomorantrean, "angkaantrean"=>$angkaantrean, "estimasidilayani"=>$estimasidilayani, "sisakuotajkn"=>$sisakuotajkn, "kuotajkn"=>$kuotajkn, "sisakuotanonjkn"=>$sisakuotanonjkn, "kuotanonjkn"=>$kuotanonjkn, "keterangan"=>$keterangan);
          $res_tambah = CJSON::decode($antrianonlinebpjs->tambah_antrian($bodytambah));
                    
          if(!empty($res_tambah['metaData']['code']) && $res_tambah['metaData']['code'] == '200'){
            $suksetambah = true;
            $tersimpanupdate = true;
            PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('respons_wsbpjs'=>null,'statuskirim_wsbpjs'=>true,'update_loginpemakai_id'=>Yii::app()->user->id,'update_time'=>date('Y-m-d H:i:s')));

            $modWaktuTungguList = WaktutunggupelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'task_id ASC'));
            if(!empty($modWaktuTungguList)){
              foreach($modWaktuTungguList as $dataWaktu){
                if(empty($dataWaktu->waktutunggu_mil)){
                  $dateNowData = date('c', strtotime(MyFormatter::formatDateTimeForDb($dataWaktu->waktutunggu_rs)));
                  $dataWaktu->waktutunggu_mil = (strtotime($dateNowData) * 1000);
                  WaktutunggupelayananT::model()->updateByPk($dataWaktu->waktutunggupelayanan_id, array('waktutunggu_mil'=> $dataWaktu->waktutunggu_mil));
                }

                $body_update = array("kodebooking"=>$dataWaktu->kode_booking, "taskid"=>$dataWaktu->task_id, "waktu"=>$dataWaktu->waktutunggu_mil);
                $res_update = CJSON::decode($antrianonlinebpjs->update_waktu($body_update));
                  
                if(!empty($res_update['metaData']['code']) && $res_update['metaData']['code'] == '200'){
                  WaktutunggupelayananT::model()->updateByPk($dataWaktu->waktutunggupelayanan_id, array('response_list'=>null,'statuskirim'=>true,'update_loginpemakai_id'=>Yii::app()->user->id,'update_time'=>date('Y-m-d H:i:s')));
                }else{
                  $tersimpanupdate = false;
                    if(!empty($res_update['metaData']['code'])){
                        WaktutunggupelayananT::model()->updateByPk($dataWaktu->waktutunggupelayanan_id, array('response_list'=>$res_update['metaData']['message']));
                    }
                }
              }
            }

            if($tersimpanupdate == false){
              $suksetambah = false;
            }
          }else{
            $suksetambah = false;
              if(!empty($res_tambah['metaData']['message'])){
                PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('respons_wsbpjs'=>$res_tambah['metaData']['message']));
              }
          }
        }
    }else{
      $suksetambah = true;
      $tersimpanupdate = true;
      $modWaktuTungguList = WaktutunggupelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'statuskirim'=>false), array('order'=>'task_id ASC'));
      if(!empty($modWaktuTungguList)){
        foreach($modWaktuTungguList as $dataWaktu){
          if(empty($dataWaktu->waktutunggu_mil)){
            $dateNowData = date('c', strtotime(MyFormatter::formatDateTimeForDb($dataWaktu->waktutunggu_rs)));
            $dataWaktu->waktutunggu_mil = (strtotime($dateNowData) * 1000);
            WaktutunggupelayananT::model()->updateByPk($dataWaktu->waktutunggupelayanan_id, array('waktutunggu_mil'=> $dataWaktu->waktutunggu_mil));
          }
          
          if(Yii::app()->user->getState('antreanonlinewsbpjs')){
            $body_update = array("kodebooking"=>$dataWaktu->kode_booking, "taskid"=>$dataWaktu->task_id, "waktu"=>$dataWaktu->waktutunggu_mil);
            $res_update = CJSON::decode($antrianonlinebpjs->update_waktu($body_update));
            
            if(!empty($res_update['metaData']['code']) && $res_update['metaData']['code'] == '200'){
              WaktutunggupelayananT::model()->updateByPk($dataWaktu->waktutunggupelayanan_id, array('response_list'=>null,'statuskirim'=>true,'update_loginpemakai_id'=>Yii::app()->user->id,'update_time'=>date('Y-m-d H:i:s')));
            }else{
              $tersimpanupdate = false;
                if(!empty($res_update['metaData']['code'])){
                    WaktutunggupelayananT::model()->updateByPk($dataWaktu->waktutunggupelayanan_id, array('response_list'=>$res_update['metaData']['message']));
                }
            }
          }
          
        }
      }
      if($tersimpanupdate == false){
        $suksetambah = false;
      }
    }

    if($suksetambah == true){
      $sukses = 1;
      $pesan = "Data Berhasil Dikirim !!!";
    }else{
      $sukses = 0;
      $pesan = "Data Gagal Dikirim !!! Response Bisa Dilihat Pada Detail Riwayat";
    }

    $resp_rollback['status'] = $sukses;
    $resp_rollback['pesan'] = $pesan;
    
    return $resp_rollback;
  }
}



