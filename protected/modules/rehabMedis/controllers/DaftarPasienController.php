<?php

class DaftarPasienController extends MyAuthController
{
  public $successSave = false;
  public $successSaveJadwal = true;
  public $successSaveHasil = true;

  public $path_view = "rehabMedis.views.daftarPasien.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
    $modPasienMasukPenunjang = new RMMasukPenunjangV;
    $format = new MyFormatter();
    $modPasienMasukPenunjang->tgl_awal = date("d M Y");
    $modPasienMasukPenunjang->tgl_akhir = date('d M Y');
    $modPasienMasukPenunjang->tgl_awall = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_akhirl = date('Y-m-d');
    $modPasienMasukPenunjang->ceklis = false;
    if (isset($_REQUEST['RMMasukPenunjangV'])) {
      $modPasienMasukPenunjang->attributes = $_REQUEST['RMMasukPenunjangV'];
      $modPasienMasukPenunjang->ceklis = $_REQUEST['RMMasukPenunjangV']['ceklis'];
      $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_awal']);
      $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_akhir']);
      $modPasienMasukPenunjang->tgl_awall = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_awall']);
      $modPasienMasukPenunjang->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_akhirl']);
      $modPasienMasukPenunjang->ceklis = $_REQUEST['RMMasukPenunjangV']['ceklis'];
    }
    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarpasien-v-grid') {
        $this->renderPartial('_tablePasien',['modPasienMasukPenunjang' => $modPasienMasukPenunjang]);
        Yii::app()->end();
      }
    }
    $this->render('index', array(
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang
    ));
  }

  public function actionBuatJadwal($id)
  {
    $this->pageTitle = Yii::app()->name . " - Buat Jadwal";
    $modHasilPemeriksaan = $this->loadAllByPasienMasukPenunjang($id);
    $modPasienPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $id)); //data pasien penunjang
    $modTindakanPelayanan = new RMTindakanpelayananT;
    $modTindakanKomponen = new RMTindakanKomponenT;
    $modJadwalKunjungan = new JadwalrehabmedisT;
    //		$modJadwalKunjungan = new JadwalkunjunganrmT;
    $modNewHasil = new HasilpemeriksaanrmT;
    // $listJadwalKunjungan = JadwalrehabmedisT::model()->findAllByAttributes(array('pendaftaran_id' => $modPasienPenunjang->pendaftaran_id));
    $listJadwalKunjungan = JadwalrehabmedisT::model()->findAllByAttributes(array('pendaftaran_id' => $modPasienPenunjang->pendaftaran_id));

    //		$listJadwalKunjungan = JadwalkunjunganrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$id));

    if (isset($_POST['JadwalKunjungan'])) {
      $transaction = Yii::app()->db->beginTransaction();
      //			try
      //			{
        // var_dump($_POST); 
      $modJadwalKunjungan = $this->saveJadwalKunjungan($_POST['JadwalKunjungan'], $modPasienPenunjang);
      // var_dump($this->successSave , $this->successSaveJadwal , $this->successSaveHasil); die;
      if ($this->successSave && $this->successSaveJadwal && $this->successSaveHasil) {
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('buatJadwal', 'id'=>$id));
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ");
      }
      //			}
      //			catch(Exception $exc){
      //				$transaction->rollback();
      //				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
      //			}
    }

    $this->render('buatJadwal', array(
      'modPasienPenunjang' => $modPasienPenunjang,
      'modTindakanPelayanan' => $modTindakanPelayanan,
      'modTindakanKomponen' => $modTindakanKomponen,
      'modJadwalKunjungan' => $modJadwalKunjungan,
      'modNewHasil' => $modNewHasil,
      'listJadwalKunjungan' => $listJadwalKunjungan,
      'id' => $id
    ));
  }

  public function actionPrintJadwal()
  {
    $id = $_REQUEST['id'];
    $judulLaporan = 'Jadwal Kunjungan Rehab Medis';
    $modHasilPemeriksaan = $this->loadAllByPasienMasukPenunjang($id);
    $modPasienPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $id)); //data pasien penunjang
    $modTindakanPelayanan = new RMTindakanpelayananT;
    $modTindakanKomponen = new RMTindakanKomponenT;
    $modJadwalKunjungan = new JadwalrehabmedisT;
    //		$modJadwalKunjungan = new JadwalkunjunganrmT;
    $modNewHasil = new HasilpemeriksaanrmT;
    //		$listJadwalKunjungan = JadwalkunjunganrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$id));

    $listJadwalKunjungan = JadwalrehabmedisT::model()->findAllByAttributes(array('pendaftaran_id' => $modPasienPenunjang->pendaftaran_id));

    $this->layout = '//layouts/printWindows';
    $this->render('printJadwal', array(
      'modPasienPenunjang' => $modPasienPenunjang,
      'modTindakanPelayanan' => $modTindakanPelayanan,
      'modTindakanKomponen' => $modTindakanKomponen,
      'modJadwalKunjungan' => $modJadwalKunjungan,
      'modNewHasil' => $modNewHasil,
      'listJadwalKunjungan' => $listJadwalKunjungan,
      'id' => $id,
      'judulLaporan' => $judulLaporan,
    ));
  }


  /**
   * Fungsi untuk menyimpan ke tabel jadwalkunjungan_t
   * @param type $attrJadwal
   * @param type $modPasienPenunjang 
   */
  protected function saveJadwalKunjungan($attrJadwal, $modPasienPenunjang)
  {
    //            echo '<pre>';
    //            print_R($attrJadwal);
    //            exit();
    $format = new MyFormatter();
    $arrSave = array();
    $validJadwal = true;
    $arrTindakan = array(); // array untuk menampung tindakan yg nantinnya digunakan pada proses saveHasilpemeriksaan
    $arrIdHasilPemeriksaan = array(); // array untuk menampung hasilpemeriksaan_id yg nantinnya digunakan pada proses saveHasilpemeriksaan
    for ($f = 0; $f < $_POST['lamaterapi']; $f++) {
      //			$modJadwalKunjungan = new JadwalkunjunganrmT;
      $modJadwalKunjungan = new JadwalrehabmedisT;
      $modJadwalKunjungan->pegawai_id = (!empty($attrJadwal['pegawai_id'][$f])) ? $attrJadwal['pegawai_id'][$f] : Yii::app()->user->getState('pegawai_id');
      $modJadwalKunjungan->pasien_id = $modPasienPenunjang->pasien_id;
      //			$modJadwalKunjungan->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id ;
      $modJadwalKunjungan->pendaftaran_id = $modPasienPenunjang->pendaftaran_id;
      $modJadwalKunjungan->nojadwal = MyGenerator::noUrutJadwalRencanaRM();
      $modJadwalKunjungan->nourutjadwal = $f + 1;
      //			$modJadwalKunjungan->tgljadwalrm = $attrJadwal['tgljadwalrm'][$f] ;

      $HDke = JadwalrehabmedisT::model()->findByAttributes(array('pasien_id' => $modJadwalKunjungan->pasien_id), array('order' => 'jadwalrehabmedis_id DESC', 'limit' => 1));
      if (!empty($HDke)) {
        $modJadwalKunjungan->jadwalrehabmedis_ke = $modJadwalKunjungan->jadwalhemodialisa_ke + 1;
      } else {
        $modJadwalKunjungan->jadwalrehabmedis_ke = 1;
      }
      $modJadwalKunjungan->jadwalrehabmedis_tgl_ke = $format->formatDateTimeForDb($attrJadwal['tgljadwalrm'][$f]);
      
      $modJadwalKunjungan->slotbed_id = $attrJadwal['slotbed_id'][$f];

      $sloter = explode("_", $modJadwalKunjungan->slotbed_id);
      $modJadwalKunjungan->slotbed_id = $sloter[0];
      $modJadwalKunjungan->jadwalrehabmedis_tgl_ke .= " ".$sloter[1].":00";

      $modJadwalKunjungan->jadwalrehabmedis_hari = $this->getNamaHari($modJadwalKunjungan->jadwalrehabmedis_tgl_ke);
      $modJadwalKunjungan->jadwalrehabmedis_status = 0;
      $modJadwalKunjungan->membuat_id = Yii::app()->user->id;

      //                        $modJadwalKunjungan->jadwalrehabmedis_tgl_ke = $attrJadwal['tgljadwalrm'][$f] ;
      //			$modJadwalKunjungan->harijadwalrm = $this->getNamaHari($attrJadwal['tgljadwalrm'][$f]) ;
      $modJadwalKunjungan->lamaterapikunjungan = $_POST['lamaterapi'];
      $modJadwalKunjungan->paramedis1_id = (!empty($attrJadwal['paramedis1_id'][$f])) ? $attrJadwal['paramedis1_id'][$f] : null;
      $modJadwalKunjungan->paramedis2_id = (!empty($attrJadwal['paramedis2_id'][$f])) ? $attrJadwal['paramedis2_id'][$f] : null;

      $modJadwalKunjungan->create_loginpemakai_id = Yii::app()->user->id;
      $modJadwalKunjungan->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modJadwalKunjungan->create_time = date('Y-m-d H:i:s');
      $modJadwalKunjungan->create_iphost = getHostByName(getHostName());
      $modJadwalKunjungan->ruangan_id = Params::RUANGAN_ID_REHABMEDIS;
      $modJadwalKunjungan->mengetahui_id = Yii::app()->user->id;
      


      // $modJadwalKunjungan->shift_id = $attrJadwal['shift_id'][$f];

      // var_dump($modJadwalKunjungan->attributes);
      // die;

      $modJadwalKunjungan->validate();
      $arrIdHasilPemeriksaan[$f] = array(
        'hasilpemeriksaanrm_id' => isset($attrJadwal['hasilpemeriksaanrm_id'][$f]) ? $attrJadwal['hasilpemeriksaanrm_id'][$f] : null
      );

      if ($modJadwalKunjungan->validate()) {
        $validJadwal = true;
        $arrSave[$f] = $modJadwalKunjungan; // menyimpan objek JadwalrehabmedisT ke dalam sebuah array dan siap untuk disave *kaya masak ya :p

      } else {
        $validJadwal = false;
      }
    } //ENDING FOR
    if ($validJadwal) //kondisi apabila semua Jadwal tindakan valid dan siap untuk di save
    {
      $arrIdHasil = array(); //membuang nilai array yg empty . . 

      foreach ($arrIdHasilPemeriksaan as $z => $idHasil) {
        if ($idHasil['hasilpemeriksaanrm_id'] == '') {
          unset($idHasil[$z]);
        } else {
          $arrIdHasil[$z] = array(
            'hasilpemeriksaanrm_id' => $idHasil['hasilpemeriksaanrm_id']
          );
        }
      }

      foreach ($arrSave as $x => $simpan) {
        $simpan->save();
        $this->successSave = true;
        //                                echo $idHasil['hasilpemeriksaanrm_id'];
        if ($x < 1) // kondisi dimana proses save pada baris pertama, yang asumsinya bahwa jadwal pertama sudah pasti mempunyai hasilpemeriksaanrm_t maka akan diupdate
        {
          if (isset($idHasil['hasilpemeriksaanrm_id'])) {
            $this->updateHasilPemeriksaan($simpan, $arrIdHasil);
          }
        } else {
          if (isset($attrJadwal['tindakanrm_id'][$f])) {
            $this->saveHasilPemeriksaan($modPasienPenunjang, $attrJadwal, $simpan, $x);
          }
        }
        //                                exit();
      } //ENDING FOREACH
    } else {
      $this->successSave = false;
    }
    return $modJadwalKunjungan;
  }

  protected function saveHasilPemeriksaan($attrPenunjang, $attrTindakan, $modJadwal, $index)
  {
    $arrSave = array();
    $validTindakan = true;
    $arrTindakan = array(); // array untuk menampung tindakan yg nantinnya digunakan pada proses saveTindakanPelayanan
    for ($i = 0; $i < count((array)$attrTindakan['tindakanrm_id'][$index]); $i++) {

      $modHasil = new HasilpemeriksaanrmT;
      //			$modHasil->jadwalkunjunganrm_id = $modJadwal->jadwalkunjunganrm_id;
      $modHasil->jadwalrehabmedis_id = $modJadwal->jadwalrehabmedis_id;

      $modHasil->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
      $modHasil->pendaftaran_id = $attrPenunjang->pendaftaran_id;
      $modHasil->pasien_id = $attrPenunjang->pasien_id;
      $modHasil->ruangan_id = $attrPenunjang->ruangan_id;
      $modHasil->pegawai_id = $attrPenunjang->pegawai_id;
      $modHasil->tglpemeriksaanrm = date('Y-m-d H:i:s');
      $modHasil->kunjunganke = $modJadwal->nourutjadwal; //di default untuk kunjungan pertama

      $modHasil->tindakanrm_id = $attrTindakan['tindakanrm_id'][$index][$i];
      $modHasil->jenistindakanrm_id = RMTindakanrmM::model()->findByPk($modHasil->tindakanrm_id)->jenistindakanrm_id;

      $modHasil->create_time = date('Y-m-d H:i:s');
      $modHasil->create_loginpemakai_id = Yii::app()->user->id;
      $modHasil->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modHasil->nohasilrm = MyGenerator::noHasilPemeriksaanRM();

      if ($modHasil->validate()) {
        $arrSave[$i] = $modHasil; // menyimpan objek BSRencanaOperasiT ke dalam sebuah array dan siap untuk disave

      } else {
        $validTindakan = false;
      }
    } //ENDING FOR 

    if ($validTindakan) //kondisi apabila semua rencana operasi valid dan siap untuk di save
    {
      foreach ($arrSave as $f => $simpan) {
        $simpan->save();
        //                        $this->saveTindakanPelayanT($attrPendaftaran,$attrPenunjang,$simpan,$attrTindakanPelayanan,$f);
      }
      $this->successSave = true;
    } else {
      $this->successSave = false;
    }
    return $modHasil;
  }

  /**
   * Fungsi untuk mengupdate hasilpemeriksaanrm_t pada saat kunjungan pertama yg asumsinya dia sudah punya hasil pemeriksaan
   * @param type $attrHasil 
   */
  protected function updateHasilPemeriksaan($modJadwal, $attrHasil)
  {
    $arrSave = array();
    $validHasil = true;
    $modHasil = array();

    for ($i = 0; $i < count((array)$attrHasil); $i++) {
      $modHasil = $this->loadHasilPemeriksaan($attrHasil[$i]['hasilpemeriksaanrm_id']);
      //			$modHasil->jadwalkunjunganrm_id = $modJadwal->jadwalkunjunganrm_id;

      $modHasil->jadwalrehabmedis_id = $modJadwal->jadwalrehabmedis_id;
      $modHasil->pegawai_id = (!empty($modJadwal->pegawai_id)) ? $modJadwal->pegawai_id : null;
      $modHasil->paramedis1_id = (!empty($modJadwal->paramedis1_id)) ? $modJadwal->paramedis1_id : null;
      $modHasil->paramedis2_id = (!empty($modJadwal->paramedis2_id)) ? $modJadwal->paramedis2_id : null;
      if ($modHasil->validate()) {
        //                            $modHasil->save();
        $arrSave[$i] = $modHasil; // menyimpan objek 
      } else {
        $validHasil = false;
      }
    } //ENDING FOR

    if ($validHasil) //kondisi apabila semua hasil valid dan siap untuk di save
    {
      foreach ($arrSave as $f => $simpan) {
        $simpan->save();
        $this->successSave = true;
      }
    } else {
      $this->successSave = false;
    }
    //                        echo $this->successSave;
    return $modHasil;
  }

  function actionDeleteRecord() {
    $hasilpemeriksaanrm_id = $_POST['hasilpemeriksaanrm_id'];
    if(HasilpemeriksaanrmT::model()->deleteByPk($hasilpemeriksaanrm_id)) {
      $data['sukses'] = 1;
    } else {
      $data['sukses'] = 0;
    }

    echo json_encode($data);
  }

  public function actionHasilPemeriksaan($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '', $hasilpemeriksaanrm_id = null, $update = null)
  {
    $modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    
    $modHasilPemeriksaanrm = new HasilpemeriksaanrmT();
    $modHasilPemeriksaanrm->tglpemeriksaanrm = date('Y-m-d H:i:s');
    $modHasilPemeriksaanrm->tindakanrm_id = Yii::app()->user->getState('ruangan_id');

    if(!empty($hasilpemeriksaanrm_id)) {
      $modHasilPemeriksaanrm = HasilpemeriksaanrmT::model()->findByPk($hasilpemeriksaanrm_id);
      if(empty($modHasilPemeriksaanrm)) {
        $modHasilPemeriksaanrm = new HasilpemeriksaanrmT();
        $modHasilPemeriksaanrm->tglpemeriksaanrm = date('Y-m-d H:i:s');
        $modHasilPemeriksaanrm->tindakanrm_id = Yii::app()->user->getState('ruangan_id');
      }
    }


    if (isset($_POST['HasilpemeriksaanrmT'])) {
      // echo '<pre>';var_dump($_POST, $_FILES);die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if(empty($update)) {
          if(count($_POST['HasilpemeriksaanrmT']) > 0) {
            foreach ($_POST['HasilpemeriksaanrmT'] as $i => $postData) {
              $modHasilPemeriksaanrm = new HasilpemeriksaanrmT();
              $file = $_FILES['HasilpemeriksaanrmT'];
              $id_pendaftaran = $_POST['RMMasukPenunjangV']['pendaftaran_id'];
              $id_pasien = $_POST['RMMasukPenunjangV']['pasien_id'];
              $id_pasienmasukpenunjang = $_POST['RMMasukPenunjangV']['pasienmasukpenunjang_id'];
              $modHasilPemeriksaanrm->hasilpemeriksaanrm = $postData['hasilpemeriksaanrm'];
              $modHasilPemeriksaanrm->keteranganhasilrm = $postData['keteranganhasilrm'];
              $modHasilPemeriksaanrm->tindakanterapi_rehab = $postData['tindakanterapi_rehab'];
              $modHasilPemeriksaanrm->tglpemeriksaanrm = MyFormatter::formatDateTimeForDb($postData['tglpemeriksaanrm']);
              $modHasilPemeriksaanrm->ruangan_id = Yii::app()->user->getState('ruangan_id');
              $modHasilPemeriksaanrm->pendaftaran_id = $pendaftaran_id;
              $modHasilPemeriksaanrm->pasien_id = $pasien_id;
              $modHasilPemeriksaanrm->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
              $modHasilPemeriksaanrm->kunjunganke = 1;
              $modHasilPemeriksaanrm->nohasilrm = 0;
              $modHasilPemeriksaanrm->tindakanrm_id = Yii::app()->user->getState('ruangan_id');
              $modHasilPemeriksaanrm->jenistindakanrm_id = 19;
              $modHasilPemeriksaanrm->create_time = date('Y-m-d H:i:s');
              $modHasilPemeriksaanrm->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $modHasilPemeriksaanrm->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $modHasilPemeriksaanrm->pegawai_id = Yii::app()->user->getState('pegawai_id');
      
              if(isset($file['tmp_name'][$i]['dokfilerm_filepath'])) {
                $temp_file = $file['tmp_name'][$i]['dokfilerm_filepath'];
              } else {
                $temp_file = null;
              }
              if(!empty($temp_file)) {
                $modHasilPemeriksaanrm->dokfilerm_filepath = $file['name'][$i]['dokfilerm_filepath'];
                $modHasilPemeriksaanrm->dokfilerm_nama = $postData['dokfilerm_nama'];
              }
              $target_file = Params::pathFileHasilPemeriksaanTindakanDirectory() . $modHasilPemeriksaanrm->dokfilerm_filepath;
              if ($modHasilPemeriksaanrm->save()) {
                if(!empty($temp_file)) {
                  // upload file
                  if(move_uploaded_file($temp_file, $target_file)){
                    $this->successSaveHasil = TRUE;
                  }
                } else {
                  $this->successSaveHasil = TRUE;
                }
              } else {
                $this->successSaveHasil = FALSE;
              }
            }
          }
        } else {
          // untuk update
          $postData = $_POST['HasilpemeriksaanrmT'];
          $file = $_FILES['HasilpemeriksaanrmT'];
          $id_pendaftaran = $_POST['RMMasukPenunjangV']['pendaftaran_id'];
          $id_pasien = $_POST['RMMasukPenunjangV']['pasien_id'];
          $id_pasienmasukpenunjang = $_POST['RMMasukPenunjangV']['pasienmasukpenunjang_id'];
          $modHasilPemeriksaanrm->hasilpemeriksaanrm = $postData['hasilpemeriksaanrm'];
          $modHasilPemeriksaanrm->keteranganhasilrm = $postData['keteranganhasilrm'];
          $modHasilPemeriksaanrm->tglpemeriksaanrm = MyFormatter::formatDateTimeForDb($postData['tglpemeriksaanrm']);
          $modHasilPemeriksaanrm->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $modHasilPemeriksaanrm->pendaftaran_id = $pendaftaran_id;
          $modHasilPemeriksaanrm->pasien_id = $pasien_id;
          $modHasilPemeriksaanrm->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
          $modHasilPemeriksaanrm->kunjunganke = 1;
          $modHasilPemeriksaanrm->nohasilrm = 0;
          $modHasilPemeriksaanrm->tindakanrm_id = Yii::app()->user->getState('ruangan_id');
          $modHasilPemeriksaanrm->jenistindakanrm_id = 19;
          $modHasilPemeriksaanrm->create_time = date('Y-m-d H:i:s');
          $modHasilPemeriksaanrm->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modHasilPemeriksaanrm->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modHasilPemeriksaanrm->pegawai_id = Yii::app()->user->getState('pegawai_id');
  
          if(isset($file['tmp_name']['dokfilerm_filepath'])) {
            $temp_file = $file['tmp_name']['dokfilerm_filepath'];
          } else {
            $temp_file = null;
          }
          if(!empty($temp_file)) {
            $modHasilPemeriksaanrm->dokfilerm_filepath = $file['name']['dokfilerm_filepath'];
            $modHasilPemeriksaanrm->dokfilerm_nama = $postData['dokfilerm_nama'];
          }
          $target_file = Params::pathFileHasilPemeriksaanTindakanDirectory() . $modHasilPemeriksaanrm->dokfilerm_filepath;
          if ($modHasilPemeriksaanrm->save()) {
            if(!empty($temp_file)) {
              // upload file
              if(move_uploaded_file($temp_file, $target_file)){
                $this->successSaveHasil = TRUE;
              }
            } else {
              $this->successSaveHasil = TRUE;
            }
          } else {
            $this->successSaveHasil = FALSE;
          }
        }
        
        if ($this->successSaveHasil) {
          $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
            'pasienmasukpenunjang_id' => $id_pasienmasukpenunjang,
          ));

          PasienmasukpenunjangT::model()->updateByPk($id_pasienmasukpenunjang, array(
            'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA
          ));

          if ($penunjang->ruanganasal_id == $penunjang->ruangan_id) {

            $judul = 'Pasien sudah periksa Rehabilitasi Medis';
            $isi = $penunjang->no_pendaftaran . " - " . $penunjang->no_rekam_medik . ' ' . $penunjang->nama_pasien;

            $arr = array(
              'pendaftaran_id' => $penunjang->pendaftaran_id,
              'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
            );

            $isi .= CHtml::link('<br/><u>Klik ini untuk melakukan pembayaran.</u>', Yii::app()->createUrl('/billingKasir/PembayaranTagihanPasienPenunjang/index', $arr));

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
            ));

            PendaftaranT::model()->updateByPk($penunjang->pendaftaran_id, array(
              'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA
            ));
          }


          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array(
            'hasilPemeriksaan',
            'pendaftaran_id' => $id_pendaftaran,
            'pasien_id' => $id_pasien,
            'pasienmasukpenunjang_id' => $id_pasienmasukpenunjang,
            'sukses' => 1,
          ));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          echo '<pre>';var_dump($modHasilPemeriksaanrm->getErrors());die;
        }
      } catch (Exception $exc) {
        echo '<pre>';var_dump($exc);die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    // load riwayat
    $modRiwayat = new HasilpemeriksaanrmT();
    $modRiwayat->pendaftaran_id = $pendaftaran_id;

    if(Yii::app()->request->isAjaxRequest) {
      $this->renderPartial('_tableRiwayatHasilRehab', ['modRiwayat' => $modRiwayat]);
      Yii::app()->end();
    }


    $this->render($this->path_view . 'hasilPemeriksaanNew', array(/*'modJadwalKunjungan'=>$modJadwalKunjungan,*/
      'modPasienPenunjang' => $modPasienMasukPenunjang,
      'modHasilPemeriksaanrm' => $modHasilPemeriksaanrm,
      'caraPrint' => $caraPrint,
      'modRiwayat' => $modRiwayat
    ));
  }

  public function actionHasilPeriksaPrint($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '')
  {
    $this->layout = '//layouts/printWindows';
    $judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
    $modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $detailHasil = HasilpemeriksaanrmT::model()->findAll('pendaftaran_id = ' . $pendaftaran_id);
    $this->render($this->path_view . 'hasilPrint', array(
      'judulLaporan' => $judulLaporan,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'detailHasil' => $detailHasil,
    ));
  }

  /**
   * Fungsi untuk mengembalikan object $model dengan method findAllByAttributes yang nanti digunakan untuk mendeskripsikan operasi_id
   * @param type $id
   * @return type 
   */
  protected function loadAllByPasienMasukPenunjang($id)
  {
    $model = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $id));
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Fungsi untuk mengembalikan object $model dengan method findByAttributes yang nanti digunakan untuk mendeskripsikan hasilpemeriksanrm_t
   * @param type $id
   * @return type 
   */
  protected function loadHasilPemeriksaan($id)
  {
    $model = HasilpemeriksaanrmT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionLoadFormJadwalKunjunganAwal()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
      $kunjungan = PasienmasukpenunjangV::model()->findByAttributes(array(
        'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
      ));
      $lamaTerapi = isset($_POST['lamaTerapi']) ? $_POST['lamaTerapi'] : null;
      $tindakan = array();
      $idHasil = array();
      $modHasilPemeriksaan = array();

      //            $sql = "select * from hasilpemeriksaanrm_t where pasienmasukpenunjang_id = $pasienmasukpenunjang_id";
      //            //echo count((array)$sql);
      //            $modHasil = Yii::app()->db->createCommand($sql)->queryAll();
      $modHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      foreach ($modHasil as $i => $hasilPeriksa) {
        $tindakan[$i] = $hasilPeriksa['tindakanrm_id'];
        $idHasil[$i] = $hasilPeriksa['hasilpemeriksaanrm_id'];
        //                echo $hasilPeriksa['hasilpemeriksaanrm_id'].'<br/>';
        //                echo $hasilPeriksa['tindakanrm_id'].'<br/>';
      }
      if (count((array)$modHasil) > 0) {
        //            exit;
        echo CJSON::encode(array(
          'status' => 'create_form',
          'pesan' => '',
          'form' => $this->renderPartial('_formLoadJadwalKunjunganAwal', array(
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
            'lamaTerapi' => $lamaTerapi,
            'tindakan' => $tindakan,
            'idHasil' => $idHasil,
            'kunjungan' => $kunjungan,
          ), true)
        ));
        exit;
      } else {
        echo CJSON::encode(array(
          'status' => 'create_form',
          'pesan' => 'Tindakan Rehabilitasi Medis belum dipilih!',
          'form' => '',
        ));
        exit;
      }
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

      $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
      $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
      $pasienMasukPenunjang =  PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

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

      if (isset($pasienMasukPenunjang)) {
        if ($pasienMasukPenunjang->panggilantrian == true) {
          if ($keterangan == "batal") {
            $pasienMasukPenunjang->panggilantrian = false;
            if ($pasienMasukPenunjang->update()) {
              // SMS GATEWAY
              $modPasien = $pasienMasukPenunjang->pasien;
              $sms = new Sms();
              $smspasien = 1;
              foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $pasienMasukPenunjang->getAttributes();
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
              $data['nama_pasien'] = $modPasien->nama_pasien;
              $data['pesan'] = "Pemanggilan no. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dibatalkan !";
            }
          } else {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " sudah dipanggil sebelumnya !";
          }
        } else {
          $pasienMasukPenunjang->panggilantrian = true;
          if ($pasienMasukPenunjang->update()) {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
            // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
            //              AKAN DIGANTI MENGGUNAKAN NODE JS
            // self::postTelnet($data_telnet);
          }
        }
      }

      $attributes = $pasienMasukPenunjang->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $pasienMasukPenunjang->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionGetAntrianTerakhir()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $data['pesan'] = "";
      $criteria = new CDbCriteria;
      $criteria->addCondition('panggilantrian != TRUE');
      $criteria->addCondition('date(tglmasukpenunjang) = current_date');
      $criteria->order = 'no_urutperiksa ASC';
      $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));

      $model = RMMasukPenunjangV::model()->find($criteria);
      if (!empty($model)) {
        $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
        $data['ruangan_singkatan'] = $model->ruangan_singkatan;
        $data['no_urutperiksa'] = $model->no_urutperiksa;
        $data['ruangan_id'] = $model->ruangan_id;
      } else {
        $data['pesan'] = "Tidak ada antrian!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionBatalPenunjang($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = '';
      $update_tindakan = false;
      $delete_tindakan = false;
      $delete_penunjang = false;

      $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

      $username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
      $password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $status_tindakan = false;
      $status_obat = false;
      $status_batal = true;
      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
        $pesan = 'Gagal Login';
      } else {
        // cek password
        if (!$user->cekPassword3($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
          $pesan = 'Gagal Login';
        } else {
          $data['error'] = '';
          $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id, 'action' => $task)); //dari MyAuthController
          if ($cek) {
            $data['status'] = 'success';
            $data['userid'] = $user->loginpemakai_id;
            $data['username'] = $user->nama_pemakai;

            $transaction = Yii::app()->db->beginTransaction();
            try {
              $criteria = new CDbCriteria();
              $criteria->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
              $criteria->addCondition('tindakansudahbayar_id is not null');
              $modTindakanPelayanan = TindakanpelayananT::model()->find($criteria);

              $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
              $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

              if ($modPendaftaran->ruangan_id == $modPasienMasukPenunjang->ruangan_id) {
                $criteriaTindakan = new CDbCriteria();
                $criteriaTindakan->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

                $modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);

                $criteriaObat = new CDbCriteria();
                $criteriaObat->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                $criteriaObat->addCondition('oasudahbayar_id is not null');
                $modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);

                if (!empty($modTindakanPelayanan)) {
                  $status_tindakan = true;
                }

                if (!empty($modObatalkesPasien)) {
                  $status_obat = true;
                }

                if ($status_tindakan == true || $status_obat == true) {
                  $status_batal = false;
                  $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
                } else {
                  $status_batal = true;
                }

                if ($status_batal == true) {
                  /*
									* cek data pendaftaran pasien masuk penunjang
									*/
                  $criteria = new CDbCriteria();
                  if (!empty($pasienmasukpenunjang_id)) {
                    $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
                  }

                  $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

                  $pesan = '';
                  $status = false;
                  $model = new PasienbatalperiksaR();
                  $model->pendaftaran_id = $pendaftaran_id;
                  $model->pasien_id = $modPendaftaran->pasien_id;
                  $model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
                  $model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Pemeriksaan Rehab Medis";
                  $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai_id = Yii::app()->user->id;

                  if ($model->save()) {
                    $status = true;
                    $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                  } else {
                    $status = false;
                    $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
                  }

                  $attributes = array(
                    'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id
                  );
                  $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

                  if (!empty($pasienMasukPenunjang)) {
                    if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
                      $attributes = array(
                        'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
                      );
                      $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
                      if ($Perminataan_penunjang) {
                        $status = true;
                      } else {
                        $status = false;
                      }
                    }

                    $attributes = array(
                      'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
                      'update_time' => date('Y-m-d H:i:s'),
                      'update_loginpemakai_id' => Yii::app()->user->id
                    );
                    $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
                    if (!$penunjang) {
                      $status = false;
                    }
                    /*
										* cek data tindakan_pelayanan
										*/
                    $attributes = array(
                      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
                      'tindakansudahbayar_id' => null
                    );

                    $criteria2 = new CDbCriteria();
                    $criteria2->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
                    $criteria2->addCondition('tindakansudahbayar_id is null');
                    $tindakan = TindakanpelayananT::model()->findAll($criteria2);

                    if (count((array)$tindakan) > 0) {
                      foreach ($tindakan as $val => $key) {
                        $attributes = array(
                          'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                        );
                        $hapus_komponen = TindakankomponenT::model()->deleteAllByAttributes($attributes);
                      }

                      $attributes = array(
                        'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
                      );

                      $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
                      if (!$hapus_tindakan) {
                        $status = false;
                        $pesan = "exist";
                      }
                    } else {
                      $status = true;
                    }

                    $criteriaObat2 = new CDbCriteria();
                    $criteriaObat2->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                    $criteriaObat2->addCondition('oasudahbayar_id is null');
                    $modObatalkesPasien2 = ObatalkespasienT::model()->findAll($criteriaObat2);

                    if (count((array)$modObatalkesPasien2) > 0) {
                      foreach ($modObatalkesPasien2 as $val => $obat) {
                        $attributes = array(
                          'obatalkespasien_id' => $obat->obatalkespasien_id
                        );
                        $hapusobatalkes = ObatalkeskomponenT::model()->deleteAllByAttributes($attributes);
                      }

                      $hapus_obat = ObatalkespasienT::model()->deleteAllByAttributes($attributes);
                      if (!$hapus_obat) {
                        $status = false;
                        $pesan = "exist";
                      }
                    } else {
                      $status = true;
                    }

                    $penunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienMasukPenunjang->pasienmasukpenunjang_id);
                    if (!$penunjang) {
                      $status = false;
                    } else {
                    }
                  }
                }
              } else {
                if (!empty($modTindakanPelayanan)) {
                  $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
                } else {
                  $update_tindakanpelayanan = TindakanpelayananT::model()->updateAll(array(
                    'detailhasilpemeriksaanlab_id' => null,
                    'hasilpemeriksaanrm_id' => null,
                    'hasilpemeriksaanrad_id' => null,
                    'hasilpemeriksaanpa_id' => null
                  ), 'pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);

                  if ($update_tindakanpelayanan) {
                    $update_tindakan = true;
                    $status = true;
                  } else {
                    $update_tindakan = false;
                    $status = false;
                  }

                  $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                  if ($delete_tindakanpelayanan) {
                    $delete_tindakan = true;
                    $status = true;
                  } else {
                    $delete_tindakan = false;
                    $status = false;
                  }

                  $delete_pasienmasukpenunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienmasukpenunjang_id);
                  if ($delete_pasienmasukpenunjang) {
                    $delete_penunjang = true;
                    $status = true;
                  } else {
                    $delete_penunjang = false;
                    $status = false;
                  }
                }
              }

              if ($status = true) {
                $pesan = 'Pasien Penunjang berhasil di batalkan';
                $transaction->commit();
              } else {
                $transaction->rollback();
              }
            } catch (Exception $ex) {
              $status = false;
              $pesan = "exist";
              $transaction->rollback();
            }
          } else {
            $data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
          }
        }
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function getPath() {
      return "data/images/hasilPemeriksaanTindakan/";
  }

  public function actionLihatHasil($id, $caraPrint = '')
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
    $modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $detailHasil = HasilpemeriksaanrmT::model()->findAll('pendaftaran_id = ' . $id);
    $this->render(
      'lihatHasil',
      array(
        'masukpenunjang' => $modPasienMasukPenunjang,
        'judulLaporan' => $judulLaporan,
        'detailHasil' => $detailHasil,
        'caraPrint' => $caraPrint,
        'modPendaftaran' => $modPendaftaran
      )
    );
  }

  public function actionRincianTagihanPenunjang($pendaftaran_id, $pasienmasukpenunjang_id, $instalasi_id = null, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienmasukpenunjang_id)) {
      $criteria->addCondition("t.pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("t.pasienadmisi_id = " . $pasienadmisi_id);
    }
    if (!empty($instalasi_id)) {
      $criteria->addCondition("t.instalasi_id = " . $instalasi_id);
    }
    $modInfo = RMPasienMasukPenunjangV::model()->find($criteria);

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('t.pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pasienmasukpenunjang_id)) {
      $criteriaTindakan->addCondition("tp.pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteriaTindakan->addCondition('t.pasienadmisi_id = ' . $pasienadmisi_id);
    }
    if (!empty($instalasi_id)) {
      $criteriaTindakan->addCondition("t.instalasi_id = " . $instalasi_id);
    }


    $criteriaTindakan->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id";
    $criteriaTindakan->addCondition('tp.pasienmasukpenunjang_id is not null');
    $criteriaTindakan->group = 't.pendaftaran_id, t.pasien_id, t.instalasi_id, t.ruangan_id, t.kelaspelayanan_id, tp.pasienmasukpenunjang_id, t.tgl_tindakan, t.instalasi_nama, t.ruangan_nama, t.kelaspelayanan_nama';
    $criteriaTindakan->select = $criteriaTindakan->group . ', sum(t.tarif_tindakan) as tarif_tindakan, sum(t.tarif_medis) as tarif_medis, sum(t.tarif_bhp) as tarif_bhp, sum(t.tarif_paramedis) as tarif_paramedis, sum(t.tarifcyto_tindakan) as tarifcyto_tindakan';
    $criteriaTindakan->addCondition('t.is_alkes = false');
    $criteriaTindakan->order = 't.instalasi_id, t.ruangan_id, t.tgl_tindakan';
    $modRincianTindakan = RinciantagihanpasienV::model()->findAll($criteriaTindakan);

    $this->render('printRincianTagihanPenunjang', array(
      'format'       => $format,
      'modInfo'       => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
    ));
  }

  public function actionReloadListBed() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $tgl = MyFormatter::formatDateTimeForDB($_POST['tgl']);
    $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
    $instalasi_id = $_POST['instalasi_id'];

    $str = '<option value="">-- Pilih --</option>';
    $list = SlotbedM::getSlotBed($tgl, $kelaspelayanan_id, $instalasi_id);

    foreach ($list as $value => $label) {
      $str .= '<option value="'.$value.'">'.$label.'</option>';
    }

    echo $str;
  }

  public function actionReloadSlotBed() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $tgl = MyFormatter::formatDateTimeForDB($_POST['tgl']);
    $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
    $instalasi_id = $_POST['instalasi_id'];
    $bed = $_POST['bed'];

    echo SlotbedM::getSlotBedJadwal($tgl, $kelaspelayanan_id, $instalasi_id, $bed);

  }

  public function actionKunjunganRehab($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    $modRiwayatKunjungan = PasienmasukpenunjangT::model()->findAllByAttributes(['pendaftaran_id' => $modPenunjang->pendaftaran_id], ['order' => 'tglkunjunganrehab asc']);
    
    $modRiwayatKunjunganRehab = KunjunganrehabR::model()->findAllByAttributes(['pasien_id' => $modPenunjang->pasien_id], 'is_terakhirkunjungan is not true');
    
    if (isset($_POST['pasienmasukpenunjang_id'])) {
      // echo '<pre>'; var_dump($_POST); die;
      
      $transaction = Yii::app()->db->beginTransaction();
      
      try {
        
        $ok = false;
        
        if(!empty($_POST['pasienmasukpenunjang_id'])) {
            $modKunjunganRehab = new KunjunganrehabR();
            $modKunjunganRehab->kunjunganrehabke = $_POST['PasienmasukpenunjangT']['kunjunganrehabke'];
            $modKunjunganRehab->tgl_kunjunganrehab = MyFormatter::formatDateTimeForDb($_POST['tglkunjunganrehab']);
            $modKunjunganRehab->pendaftaran_id = $modPenunjang->pendaftaran_id;
            $modKunjunganRehab->pasien_id = $modPenunjang->pasien_id;
            $modKunjunganRehab->pasienmasukpenunjang_id = $modPenunjang->pasienmasukpenunjang_id;

            if($_POST['PasienmasukpenunjangT']['is_terakhirkunjungan'] == '1') {
              $modKunjunganRehab->is_terakhirkunjungan = true;
              KunjunganrehabR::model()->updateAll(['is_terakhirkunjungan' => true], 'pasien_id =' . $modPenunjang->pasien_id);
            }

            $modPenunjang->tglkunjunganrehab = MyFormatter::formatDateTimeForDb($_POST['tglkunjunganrehab']);
            $modPenunjang->kunjunganrehabke = $_POST['PasienmasukpenunjangT']['kunjunganrehabke'];

            if($modPenunjang->save() && $modKunjunganRehab->save()) {
              $ok = true;
            }
        }


        // $ok &= PendaftaranT::model()->updateByPk($kirim->pendaftaran_id, array('ruangan_id' => Yii::app()->user->getState('ruangan_id'),
        //  'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->getState('pegawai_id')));

        //  var_dump($ok); die;
       
        if ($ok) {

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Kunjungan rehab medis dibuat !");
          $this->redirect(array('KunjunganRehab', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'sukses' => 1));
        } else {
          $transaction->rollback();

          Yii::app()->user->setFlash('error', "Jadwal gagal dibuat[1] !<br>");
        }
      } catch (Exception $exc) {
        var_dump($exc); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Jadwal gagal dibuat[2] !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('kunjunganRehabMedis', array(
      'modPenunjang' => $modPenunjang,
      'modRiwayatKunjungan' => $modRiwayatKunjungan,
      'modRiwayatKunjunganRehab' => $modRiwayatKunjunganRehab
    ));
  }
}
