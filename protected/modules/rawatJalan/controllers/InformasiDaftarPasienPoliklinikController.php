<?php
class InformasiDaftarPasienPoliklinikController extends MyAuthController
{
  public $defaultAction = 'index';
  public $tindakanpelayanantersimpan = true;

  public function actionIndex()
  {
    $model = new RJInfokunjunganrjpoliklinikV('searchDaftarPasienPoliklinik');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['RJInfokunjunganrjpoliklinikV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjpoliklinikV'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjpoliklinikV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjpoliklinikV']['tgl_akhir']);
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('_tablePasien', array('model' => $model));
    } else {
      $this->render('index', array('model' => $model));
    }
  }

  /**
   * Mengatur dropdown kasus penyakit
   */
  public function actionSetDropdownKasusPenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

      $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE');
      $jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');

      $jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id', '', $jeniskasuspenyakit, array("onchange" => "saveKasusPenyakit(this,$pendaftaran_id)", "style" => "width:140px;", "options" => array($jeniskasuspenyakit_id => array("selected" => true))));

      $dataList['kasusPenyakit'] = $jeniskasuspenyakitOptions;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }
  /**
   * Mengatur dropdown kasus penyakit
   */
  public function actionSaveKasusPenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
      $pesan = 'gagal';

      $update = RJPendaftaranT::model()->updateByPk($pendaftaran_id, array('jeniskasuspenyakit_id' => $jeniskasuspenyakit_id));
      if ($update) {
        $pesan = 'berhasil';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }


  /**
   * untuk Ubah Dokter
   */
  public function actionUbahDokterPeriksa()
  {
    $model = new RJPendaftaranT;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['RJPendaftaranT'])) {
      if ($_POST['RJPendaftaranT']['pegawai_id'] != "") {
        $model->attributes = $_POST['RJPendaftaranT'];
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pegawai_id' => $_POST['RJPendaftaranT']['pegawai_id']);
          $save = $model::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'menu' => $menu), true)
      ));
      exit;
    }
  }

  public function actionGetDataPendaftaranRJ()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $model = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
        $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
        $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'nama_pegawai');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pendaftaran_id = ($_POST['pendaftaran_id']);
      $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
      $modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);

      $nama_modul = Yii::app()->controller->module->id;
      $nama_controller = Yii::app()->controller->id;
      $nama_action = Yii::app()->controller->action->id;
      $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
      $criteria = new CDbCriteria;
      $criteria->compare('modul_id', $modul_id);
      $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
      $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
      if (isset($_POST['tujuansms'])) {
        $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
      }
      $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
      $data['smspasien'] = 1;
      $data['nama_pasien'] = '';

      if (isset($modPendaftaran)) {
        if ($modPendaftaran->panggilantrian == true) {
          if ($keterangan == "batal") {
            $modPendaftaran->panggilantrian = false;
            if ($modPendaftaran->update()) {

              $data['pesan'] = "Pemanggilan no. antrian " . $modPendaftaran->no_urutantri . " dibatalkan !";
            }
          } else {

            $data['pesan'] = "No. antrian " . $modPendaftaran->no_urutantri . " sudah dipanggil sebelumnya !";
          }
          $data['smspasien'] = 1;
        } else {
          $modPendaftaran->panggilantrian = true;
          if ($modPendaftaran->update()) {
            // SMS GATEWAY
            $modPasien = $modPendaftaran->pasien;
            $sms = new Sms();
            $smspasien = 1;
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPendaftaran->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
            // END SMS GATEWAY
            $data['smspasien'] = $smspasien;
            $data['nama_pasien'] = $modPendaftaran->pasien->nama_pasien;
            $data['pesan'] = "No. antrian " . $modPendaftaran->no_urutantri . " dipanggil !";
            // $data_telnet = $modPendaftaran->ruangan->ruangan_nama.", ".$modPendaftaran->ruangan->ruangan_singkatan."-".$modPendaftaran->no_urutantri;
            //              AKAN DIGANTI MENGGUNAKAN NODE JS
            // self::postTelnet($data_telnet);
          }
        }
      }
      $attributes = $modPendaftaran->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $modPendaftaran->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /*
     * Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
  public function actionUbahStatusPeriksaPasien()
  {
    $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $model = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modBatalPeriksa = new PasienbatalperiksaR;
    $model->tglselesaiperiksa = date('Y-m-d H:i:s');
    if (isset($_POST['status'])) {
      if ($status == "ANTRIAN") {
        $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
      } else {
        if ($status == "SEDANG PERIKSA") {
          $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
        } else if ($status == "SEDANG DIRAWAT INAP") {
          $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
        }
      }
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
          ));
          exit;
        }
      } else {

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
          ));
          exit;
        }
      }
    }
  }
  //penambahan status dokumen untuk informasi daftar pasien poliklinik
  public function actionRiwayatDokfilerm($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $crit = new CDbCriteria();
    $crit->addCondition('pasien_id ='. $modPasien->pasien_id);
    $modDokfilerm = DokfilermR::model()->findAll($crit);
    $modDokfilerms =[];
    foreach ($modDokfilerm as $dok) {
        if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
            $modDokfilerms[]=$dok; 
        }
    }
    
    if (empty($modDokfilerms)){
        echo 'Tidak memiliki file rekam medis';
        exit;
    }
    
    $kertas = Params::DEFAULT_KERTAS_UKURAN;
    $mpdf = new MyPDF60;
   
    $a = 0;
    foreach($modDokfilerms as $key => $val){
        $file = Params::pathFileRMPasienDirectory().$modPasien->no_rekam_medik.'/'.$val->dokfilerm_filepath;                        
        $urlfile = Params::urlFileRMPasienDirectory().$modPasien->no_rekam_medik.'/'.$val->dokfilerm_filepath;                        
        if (file_exists($file)){
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext == 'pdf'){                                    
                $pagecount = $mpdf->SetSourceFile($file);                
                for($i=1;$i<=$pagecount;$i++){
                    if ($a > 0){
                        $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 15, 15, 15, 15, 15, 15);
                    }
                    $tplId = $mpdf->ImportPage($i);
                    $mpdf->UseTemplate($tplId);    
                    $a++;
                }                
            }elseif ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'){ 
                if ($a > 0){
                    $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 15, 15, 15, 15, 15, 15);
                }
                $mpdf->writeHtml("<img src='".$urlfile."' width='100%'>");
            }         
        }    
    }
    
    if (!file_exists(Params::pathFileRMPasienDirectory().$modPasien->no_rekam_medik.'/gabungan/')){
        mkdir(Params::pathFileRMPasienDirectory().$modPasien->no_rekam_medik.'/gabungan/',0775,true);
    }
    
    $pdffile = Params::pathFileRMPasienDirectory().$modPasien->no_rekam_medik.'/gabungan/filegabungan.pdf';
    $mpdf->Output($pdffile, 'F');
    
    $urlfile = Params::urlFileRMPasienDirectory().$modPasien->no_rekam_medik.'/gabungan/filegabungan.pdf';
    
    $this->render('_listDokfilerm', array('pdffile' => $urlfile));
  }

  public function actionDetailScanRM($dokfilerm_id) {
    $this->layout = '//layouts/iframe';
    
    $file = DokfilermR::model()->findByPk($dokfilerm_id);
           
    $this->render("detail", array(
      'file'=>$file,
    ));
  }

  /**
   * Pengiriman Dokumen RM
   */

  public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = null;
    $status = false;
    if (!empty($pengirimanrm_id)) {
      $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
    } else {
      $modPengirimanRm = new PengirimanrmT();
    }



    $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = $pegawai_id;

    if (!empty($modPendaftaran->pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RI;
      $modUbahStatus->ruangan_id = $modAdmisi->ruangan_id;
    }

    if (isset($_POST['PengirimanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modUbahStatus->attributes = $_POST['PengirimanrmT'];

        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

        if ($modUbahStatus->save()) {
          $ruangan = RuanganM::model()->findByPk($modUbahStatus->ruanganpenerima_id);


          $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
          $modPendaftaran->pengirimanrm_id = $modUbahStatus->pengirimanrm_id;


          // var_dump($modPendaftaran->attributes); die;

          $modPendaftaran->save();

          $judul = 'Pengiriman Berkas Rekam Medis';

          $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
          ));

          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'modAdmisi' => $modAdmisi,
      'status' => $status
    ));
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

   /**
   * ubah status dokumen
   */
  public function actionStatusDokumenTerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $statusdok = $_POST['status'];
      $update = false;
      $status = '';
      $div = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
        $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
        $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
        if ($modPenerimaanRm->save()) {
          $model->statusdokrm = 'SUDAH DITERIMA';
          $model->save();

          $judul = 'Penerimaan Berkas Rekam Medis';

          $isi = $modPenerimaanRm->pasien->no_rekam_medik . ' - ' . $modPenerimaanRm->pasien->nama_pasien;


          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $modPenerimaanRm->ruanganpengirim->instalasi->instalasi_id, 'ruangan_id' => $modPenerimaanRm->ruanganpengirim->ruangan_id, 'modul_id' => !empty($modPenerimaanRm->ruanganpengirim->modul_id) ? $modPenerimaanRm->ruanganpengirim->modul_id : null),
          ));


          $update = true;
        } else {
          $update = false;
        }
      }

      if ($update == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }

    public function actionTambahJadwal(){
        // $this->layout = '//layouts/iframe';
        $form = '';
        $format = new MyFormatter();
        $dokter = !empty($_POST['checkJadwal']['pegawai']) ? $_POST['checkJadwal']['pegawai'] : null;
        $poliklinik = !empty($_POST['checkJadwal']['ruangan']) ? $_POST['checkJadwal']['ruangan'] : "-";
        // var_dump($poliklinik);die;

        if (!empty($checkjadwal_id)) {
            $model = CheckjadwalR::model()->findByPk($checkjadwal_id);
        } else {
            $model = new CheckjadwalR;                    
        }
        if (isset($_POST['CheckjadwalR'])) {
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['CheckjadwalR'];
                $model->pendaftaran_id = isset($_POST['CheckjadwalR']['pendaftaran_id']) ? $_POST['CheckjadwalR']['pendaftaran_id'] : null;
                // $model->pasien_id = isset($_POST['CheckjadwalR']['pasien_id']) ? $_POST['CheckjadwalR']['pasien_id'] : null;
                $model->pegawai_id = $dokter;
                $model->check_poliklinik = $poliklinik;
                $model->create_time = date('Y-m-d');
                $model->update_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->check_status = 1;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                // echo "<pre>";
                // var_dump($model);die;

                if ($model->validate()) {
                    if ($model->save()) {
                        // echo "OK"; die;
                        $trans->commit();
                        $model->isNewRecord = FALSE;
                        // if (!empty($_GET['pendaftaran_id'])) {
                        //     $model->suratketerangan_id = $model->suratketerangan_id;
                        // }
                        
                        Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
                        // $this->redirect('tambahjadwal');
                        $this->redirect(array('TambahJadwal'));
                    }else{
                        Yii::app()->user->setFlash('error', " Jadwal dokter gagal disimpan ");
                        $trans->rollback();
                    }
                }
            } catch (Exception $exc) { 
                var_dump($exc->getMessage());die;               
                Yii::app()->user->setFlash('error', "Jadwal dokter gagal disimpan" . MyExceptionMessage::getMessage($exc, true));
                $trans->rollback();
            }
        }
        $this->render('_formCheckJadwal', array('model' => $model, 'form'=>$form));
    }

    public function actionAjaxListPoli() {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST['id'];
            // var_dump($instalasi);die;
            $criteria = new CDbCriteria;
            if (!empty($instalasi)) {
                $criteria->addCondition("instalasi_id = " . $instalasi);
            }
            $criteria->addCondition('ruangan_id = 522');
            $criteria->order = 'ruangan_nama';

            $polis = RuanganM::model()->findAll($criteria);

            $str = '<option value="">-- Pilih --</option>';

            foreach ($polis as $ruangan) {
                $str .= '<option value="' . $ruangan->ruangan_id . '">' . $ruangan->ruangan_nama . '</option>';
            }

            echo CJSON::encode(array('list' => $str));

//                echo CHtml::checkBoxList($name, $select, $data);
            //echo CHtml::checkBox('pilih_semua_poli',true,array('onclick'=>'pilihSemua(this);'))."<label class='checkbox'>Pilih Semua</label><br/>";
            //echo CHtml::checkBoxList('jadwalDokter[poliklinik]', CHtml::listData($polis, 'ruangan_id', 'ruangan_id'), CHtml::listData($polis, 'ruangan_id', 'ruangan_nama'), array('template'=>'<label class="checkbox">{input} {label}</label>','separator'=>''));
        }
    }

    public function actionAjaxListDokterRuangan () {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $criteria = new CDbCriteria;
            if (!empty($ruangan_id)) {
                $criteria->addCondition("ruangan_id = " . $ruangan_id);
            }
            $criteria->addCondition('pegawai_aktif = TRUE');
            $criteria->order = 'nama_pegawai';

            $dokters = DokterV::model()->findAll($criteria);

            $str = '<option value="">-- Pilih --</option>';

            foreach ($dokters as $dokter) {
                $str .= '<option value="' . $dokter->pegawai_id . '">' . $dokter->namaLengkap . '</option>';
            }

            echo CJSON::encode(array('list' => $str));

//                echo CHtml::checkBoxList($name, $select, $data);
            //echo CHtml::checkBox('pilih_semua_poli',true,array('onclick'=>'pilihSemua(this);'))."<label class='checkbox'>Pilih Semua</label><br/>";
            //echo CHtml::checkBoxList('jadwalDokter[poliklinik]', CHtml::listData($polis, 'ruangan_id', 'ruangan_id'), CHtml::listData($polis, 'ruangan_id', 'ruangan_nama'), array('template'=>'<label class="checkbox">{input} {label}</label>','separator'=>''));
        }
    }

    public function actionAjaxListRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST['poliklinik_id'];
            $instalasi_nama = $_POST['poliklinik_nama'];
            // var_dump($instalasi_nama);die;
            $criteria = new CDbCriteria;
            if (!empty($instalasi)) {
                $criteria->addCondition("ruangan_id = " . $instalasi);
            }
            // $criteria->addCondition('poliklinik_nama != null');
            $criteria->order = 'poliklinik_nama';

            $polis = PapanantrianserialruanganM::model()->findAll($criteria);
            
            // foreach ($check as $check){
            //   $dok = DokterV::model()->findAllByAttributes(array('pegawai_id' => $check->pegawai_id));
            //   // var_dump($dok);die;
            // }
            
            
            // var_dump($polis);die;

            $str = '<option value="">-- Pilih --</option>';
            $arrayCheck = [];
            foreach ($polis as $ruangan) {
              $check = CheckjadwalR::model()->findByAttributes(array('check_ipsegment' => $ruangan->ip_address));
              $arrayCheck[] = $check;
              // echo CJSON::encode($check);die;
              // var_dump($check);die;
              // $dok = DokterV::model()->findByAttributes(array('pegawai_id' => $check->pegawai_id));
              // var_dump($dok);die;
              // foreach ($check as $check){
                  
                  // var_dump($dok->pegawai_id);die;
              // }
                
              // var_dump($check);die;
              if(!empty($check->check_ipsegment) && $check->check_status == true){
                $str .= '<option value="' . $ruangan->poliklinik_nama . '">' . $ruangan->poliklinik_nama ." --- " . $check->pegawai->namaLengkap.'</option>';
              }else{
                $str .= '<option value="' . $ruangan->poliklinik_nama . '">' . $ruangan->poliklinik_nama . '</option>';
              }
              // echo $check['check_ipsegment'];
            }
            
            echo CJSON::encode(array('list' => $str, 'data' => $arrayCheck));

//                echo CHtml::checkBoxList($name, $select, $data);
            //echo CHtml::checkBox('pilih_semua_poli',true,array('onclick'=>'pilihSemua(this);'))."<label class='checkbox'>Pilih Semua</label><br/>";
            //echo CHtml::checkBoxList('jadwalDokter[poliklinik]', CHtml::listData($polis, 'ruangan_id', 'ruangan_id'), CHtml::listData($polis, 'ruangan_id', 'ruangan_nama'), array('template'=>'<label class="checkbox">{input} {label}</label>','separator'=>''));
        }
    }

    public function actionAjaxListIp() {
      if (Yii::app()->request->isAjaxRequest) {
          $instalasi = $_POST['poliklinik_id'];
          // var_dump($instalasi);die;
          $criteria = new CDbCriteria;
          if (!empty($instalasi)) {
            $criteria->compare('LOWER(poliklinik_nama)', strtolower($instalasi));
          }
          // $criteria->addCondition('poliklinik_nama != null');
          $criteria->order = 'ip_address asc';

          $polis = PapanantrianserialruanganM::model()->findAll($criteria);

          // $str = '<option value="">-- Pilih --</option>';

          // foreach ($polis as $ruangan) {
          //     $str .= '<option value="' . $ruangan->poliklinik_nama . '">' . $ruangan->ip_address . $ruangan->ip_port.'</option>';
          // }

          echo CJSON::encode(array('list' => $polis));
      }
  }

  public function actionBatalRujukKeluar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $data = array(
      'ok' => 1,
      'msg' => '',
    );

    $this->tindakanpelayanantersimpan = true;
    $trans = Yii::app()->db->beginTransaction();


    try {
      $model = CheckjadwalR::model()->findByPk($_POST['id']);


      CheckjadwalR::model()->deleteByPk($model->checkjadwal_id);

      if ($this->tindakanpelayanantersimpan) {
        $trans->commit();
      } else {
        $trans->rollback();
        $data['ok'] = 0;
        $data['msg'] = "";
      }
    } catch (CException $e) {
      $trans->rollback();
      $data['ok'] = 0;
      $data['msg'] = $e->message;
    }


    echo CJSON::encode($data);
  }


  public function actionPrintIdentitas()
  {

    $model = PasienM::model()->findByPk($_GET['pasien_id']);
    $judulLaporan = 'Data Booking Kamar';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', [80, 140]);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 2, 2, 15, 15);
      $mpdf->setHTMLFooter('<span></span>');
      $mpdf->WriteHTML($this->renderPartial('_printIdentitas', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
   
  /*
     * end Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
}
