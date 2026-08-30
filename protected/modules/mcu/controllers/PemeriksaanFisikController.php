<?php

Yii::import('rawatJalan.models.*');

class PemeriksaanFisikController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  protected $path_view = 'rawatJalan.views.pemeriksaanFisik.';
  protected $path_view_mcu = 'mcu.views.pemeriksaanFisik.';
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $simpanpemeriksaanfisik = false;
  public $simpanpemeriksaantht = true;

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($pendaftaran_id)
  {
    //            $result = $this->xmlParser();		
    $format = new MyFormatter();
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    //$modRJMetodeGSCM = RJMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_singkatan,metodegcs_nilai DESC');
    $modRJMetodeGSCM = RJMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_id');
    $modBagianTubuh = new RJBagiantubuhM();
    $modGambarTubuh = new RJGambartubuhM();
    $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $cekPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $modRiwayatTht = new MCRiwayatthtR();
    $modRiwayatTht->bentuk_telinga = 'Tidak';
    $modRiwayatTht->liang_telinga = 'Tidak';
    $modRiwayatTht->membran_timpani = 'Tidak';
    $modRiwayatTht->serumen = 'Tidak';
    $modRiwayatTht->bentuk_hidung = 'Tidak';
    $modRiwayatTht->septum_nasi = 'Tidak';
    $modRiwayatTht->konka_nasal = 'Tidak';
    $modRiwayatTht->pharynx = 'Tidak';
    $modRiwayatTht->tonsil = 'Tidak';
    $modRiwayatTht->oral_hygine = 'Tidak';
    $modRiwayatTht->gusi = 'Tidak';
    $modRiwayatTht->gigi = 'Tidak';
    $modRiwayatTht->bentuk_leher = 'Tidak';
    $modRiwayatTht->kelenjar_thyroid = 'Tidak';
    $modRiwayatTht->paru_inspeksi = 'Tidak';
    $modRiwayatTht->paru_palpasi = 'Tidak';
    $modRiwayatTht->paru_perkusi = 'Tidak';
    $modRiwayatTht->jantung_inspeksi = 'Tidak';
    $modRiwayatTht->jantung_palpasi = 'Tidak';
    $modRiwayatTht->jantung_perkusi = 'Tidak';
    $modRiwayatTht->bentuk_abdomen = 'Tidak';
    $modRiwayatTht->inspeksi_abdomen = 'Tidak';
    $modRiwayatTht->hati = 'Tidak';
    $modRiwayatTht->limpa = 'Tidak';
    $modRiwayatTht->anus = 'Tidak';
    $modRiwayatTht->extremitas = 'Tidak';
    $modRiwayatTht->kelainan_kulit = 'Tidak';
    $modRiwayatTht->sensibilitas_kulit = 'Tidak';

    if (!empty($cekPemeriksaanFisik)) {  //Jika Pasien Sudah Melakukan Pemeriksaan Fisik  Sebelumnya
      $modPemeriksaanFisik = $cekPemeriksaanFisik;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;
      $modPemeriksaanFisik->update_time = date('Y-m-d H:i:s');
      $modPemeriksaanFisik->update_loginpemakai_id = Yii::app()->user->id;

      $modRiwayatThts = MCRiwayatthtR::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id));
      $attrRiwayatTht = array(
        'bentuk_telinga', 'liang_telinga', 'membran_timpani', 'serumen', 'keterangan_telinga',
        'bentuk_hidung', 'septum_nasi', 'konka_nasal', 'keterangan_hidung',
        'pharynx', 'tonsil', 'ukuran', 'keterangan_tenggorokan',
        'oral_hygine', 'gusi', 'gigi', 'keterangan_mulut',
        'bentuk_leher', 'kelenjar_thyroid', 'keterangan_leher',
        'paru_inspeksi', 'paru_palpasi', 'paru_perkusi', 'paru_auskultasi', 'keterangan_paru',
        'jantung_inspeksi', 'jantung_palpasi', 'jantung_perkusi', 'jantung_auskultasi', 'keterangan_jantung',
        'bentuk_abdomen', 'inspeksi_abdomen', 'hati', 'limpa', 'keterangan_abdomen',
        'anus', 'keterangan_rectal',
        'extremitas', 'keterangan_extremitas',
        'neurologis', 'keterangan_neurologis',
        'warna_kulit', 'kelainan_kulit', 'sensibilitas_kulit', 'keterangan_kulit',
        'kriteria_td'
      );
      foreach ($modRiwayatThts as $i => $val) {
        $modRiwayatTht[$attrRiwayatTht[$i]] = $val->status_bagiantht;
      }
    } else {  //Jika Pasien Belum Pernah melakukan Pemeriksaan Fisik
      $modPemeriksaanFisik = new RJPemeriksaanFisikT;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;
      $modPemeriksaanFisik->pegawai_id = $modPendaftaran->pegawai_id;
      $modPemeriksaanFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPemeriksaanFisik->pasien_id = $modPasien->pasien_id;
      $modPemeriksaanFisik->tglperiksafisik = date('Y-m-d H:i:s');
      $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
      $modPemeriksaanFisik->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->id;
    }
    if (isset($_POST['RJPemeriksaanFisikT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPemeriksaanFisik->attributes = $_POST['RJPemeriksaanFisikT'];
        $modPemeriksaanFisik->keadaanumum = isset($_POST['RJPemeriksaanFisikT']['keadaanumum']) ? ((count((array)$_POST['RJPemeriksaanFisikT']['keadaanumum']) > 0) ? implode(', ', $_POST['RJPemeriksaanFisikT']['keadaanumum']) : '') : '';
        $modPemeriksaanFisik->tglperiksafisik = $format->formatDateTimeForDb($_POST['RJPemeriksaanFisikT']['tglperiksafisik']);
        $modPemeriksaanFisik->denyutjantung = isset($_POST['RJPemeriksaanFisikT']['denyutjantung']) ? $_POST['RJPemeriksaanFisikT']['denyutjantung'] : "";
        $modPemeriksaanFisik->kriteria_td = isset($_POST['RJPemeriksaanFisikT']['kriteria_td']) ? $_POST['RJPemeriksaanFisikT']['kriteria_td'] : "";
        $modPemeriksaanFisik->lingkarperut_cm = isset($_POST['RJPemeriksaanFisikT']['lingkarperut_cm']) ? $_POST['RJPemeriksaanFisikT']['lingkarperut_cm'] : "";
        $modPemeriksaanFisik->bentukbadan = isset($_POST['RJPemeriksaanFisikT']['bentukbadan']) ? $_POST['RJPemeriksaanFisikT']['bentukbadan'] : "";
        $modPemeriksaanFisik->mata_persepsiwarna = isset($_POST['RJPemeriksaanFisikT']['mata_persepsiwarna']) ? $_POST['RJPemeriksaanFisikT']['mata_persepsiwarna'] : "";
        $modPemeriksaanFisik->mata_visus_od = isset($_POST['RJPemeriksaanFisikT']['mata_visus_od']) ? $_POST['RJPemeriksaanFisikT']['mata_visus_od'] : "";
        $modPemeriksaanFisik->mata_visus_os = isset($_POST['RJPemeriksaanFisikT']['mata_visus_os']) ? $_POST['RJPemeriksaanFisikT']['mata_visus_os'] : "";
        $modPemeriksaanFisik->mata_penglihatanjauh = isset($_POST['RJPemeriksaanFisikT']['mata_penglihatanjauh']) ? $_POST['RJPemeriksaanFisikT']['mata_penglihatanjauh'] : "";
        $modPemeriksaanFisik->mata_kelainan = isset($_POST['RJPemeriksaanFisikT']['mata_kelainan']) ? $_POST['RJPemeriksaanFisikT']['mata_kelainan'] : "";

        if ($modPemeriksaanFisik->validate()) {
          if ($modPemeriksaanFisik->save()) {
            $updateStatusPeriksa = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            /* ================================================ */
            /* Proses update status periksa KonsulPoli EHS-179  */
            /* ================================================ */
            $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
            if (!empty($konsulPoli)) {
              $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            }
            /* ================================================ */
            $this->simpanpemeriksaanfisik = true;
          }
        }
        $this->savepemeriksaantht($modPemeriksaanFisik, $_POST['MCRiwayatthtR']);
        if ($this->simpanpemeriksaanfisik && $this->simpanpemeriksaantht) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Pemeriksaan Fisik berhasil disimpan");
          $this->redirect($_POST['url']);
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
          $this->redirect($_POST['url']);
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pemeriksaan Fisik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $modPemeriksaanFisik->tglperiksafisik = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPemeriksaanFisik->tglperiksafisik, 'yyyy-MM-dd hh:mm:ss')
    );

    $this->render($this->path_view_mcu . 'index', array(
      'modPasien' => $modPasien,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPendaftaran' => $modPendaftaran,
      'modRJMetodeGSCM' => $modRJMetodeGSCM,
      'modBagianTubuh' => $modBagianTubuh,
      'modGambarTubuh' => $modGambarTubuh,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modRiwayatTht' => $modRiwayatTht
    ));
  }

  //-- Rawat Jalan --//
  //function ajax get Text Tekanan Body Mass Index untuk form Pemeriksaan Fisik
  public function actionGetBMIText()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bmi = (isset($_POST['bmi']) ? $_POST['bmi'] : null);
      $criteria2 = new CDbCriteria();
      $criteria2->select = 'max(bmi_minimum) as max_bmi';
      $modBMI = BodymassindexM::model()->find($criteria2);
      $criteria = new CDbCriteria();
      //$criteria->addCondition($bmi.' >= bmi_minimum');

      if ($bmi > $modBMI->max_bmi) {
        $criteria->condition = 'bmi_minimum <= ' . $bmi . ' and bmi_maksimum = 0';
        //$criteria->condition('0 <= bmi_maksimum');
      } else {
        $criteria->addCondition($bmi . ' >= bmi_minimum');
        $criteria->addCondition($bmi . ' <= bmi_maksimum');
      }
      //echo $bmi;exit();
      //$criteria->order='bmi_minimum ASC';
      $data = array();
      $bmi = BodymassindexM::model()->find($criteria);
      $data['text'] = (isset($bmi->bmi_defenisi) ? $bmi->bmi_defenisi : "");
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  public function savepemeriksaantht($modPemeriksaanFisik, $posts)
  {
    $namapemeriksaan = array(
      'Bentuk Telinga', 'Liang Telinga', 'Membran Timpani', 'Serumen', 'Keterangan Telinga',
      'Bentuk Hidung', 'Septum Nasi', 'Konka Nasal', 'Keterangan Hidung',
      'Pharynx', 'Tonsil', 'Ukuran', 'Keterangan Tenggorokan',
      'Oral Hygine', 'Gusi', 'Gigi', 'Keterangan Mulut',
      'Bentuk Leher', 'Kelenjar Thyroid', 'Keterangan Leher',
      'Inspeksi Paru', 'Palpasi Paru', 'Perkusi Paru', 'Auskultasi Paru', 'Keterangan Paru',
      'Inspeksi Jantung', 'Palpasi Jantung', 'Perkusi Jantung', 'Auskultasi Jantung', 'Keterangan Jantung',
      'Bentuk Abdomen', 'Inspeksi / Palpasi / Perkusi', 'Hati', 'Limpa', 'Keterangan Abdomen',
      'Anus / Rektum / Periana', 'Keterangan Rectal',
      'Ekstremitas', 'Keterangan Extremitas',
      'Neurologis (reflex)', 'Keterangan Neurologis',
      'Warna Kulit', 'Kelainan Kulit', 'Sensibilitas Kulit', 'Keterangan Kulit',
    );
    $index = 0;

    if ($posts['rectal_tidakdilakukan'] == 1) {
      unset($posts['rectal_tidakdilakukan']);
    } else {
      unset($posts['anus']);
      unset($posts['rectal_tidakdilakukan']);
      unset($namapemeriksaan[35]); // Anus
      unset($namapemeriksaan[36]); // Ket Rectal
      $namapemeriksaan = array_values($namapemeriksaan); // re-index array
    }
    foreach ($posts as $i => $post) {
      $index = $index;
      $modRiwayatTht = new MCRiwayatthtR();
      $modRiwayatTht->pemeriksaanfisik_id = $modPemeriksaanFisik->pemeriksaanfisik_id;
      $modRiwayatTht->bagian_tht = $namapemeriksaan[$index];
      $modRiwayatTht->status_bagiantht = !empty($posts[$i]) ? $posts[$i] : " - ";
      if ($index <= 4) {
        $modRiwayatTht->jenis_tht = 'Telinga';
      } else if ((4 < $index) && ($index <= 8)) {
        $modRiwayatTht->jenis_tht = 'Hidung';
      } else if ((8 < $index) && ($index <= 12)) {
        $modRiwayatTht->jenis_tht = 'Tenggorokan';
      } else if ((12 < $index) && ($index <= 16)) {
        $modRiwayatTht->jenis_tht = 'Mulut';
      } else if ((16 < $index) && ($index <= 19)) {
        $modRiwayatTht->jenis_tht = 'Leher';
      } else if ((19 < $index) && ($index <= 24)) {
        $modRiwayatTht->jenis_tht = 'Paru';
      } else if ((24 < $index) && ($index <= 29)) {
        $modRiwayatTht->jenis_tht = 'Jantung';
      } else if ((29 < $index) && ($index <= 34)) {
        $modRiwayatTht->jenis_tht = 'Abdomen';
      } else if ((34 < $index) && ($index <= 36)) {
        $modRiwayatTht->jenis_tht = 'Rectal';
      } else if ((36 < $index) && ($index <= 38)) {
        $modRiwayatTht->jenis_tht = 'Extremitas';
      } else if ((38 < $index) && ($index <= 40)) {
        $modRiwayatTht->jenis_tht = 'Neurologis';
      } else {
        $modRiwayatTht->jenis_tht = 'Kulit';
      }
      if ($modRiwayatTht->validate()) {
        $modRiwayatTht->save();
        $this->simpanpemeriksaantht &= true;
      }
      $index++;
    }
  }

  //-- Rawat Jalan --//
  //function ajax get Text Tekanan Darah untuk form Pemeriksaan Fisik
  public function actionGetTextTekananDarah()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $systolic = $_POST['systolic'];
      $diastolic = $_POST['diastolic'];
      $criteria2 = new CDbCriteria();
      $criteria2->select = 'max(systolic_min) as sys_max';
      $modSys = SysdiaM::model()->find($criteria2);
      $criteria3 = new CDbCriteria();
      $criteria3->select = 'max(diastolic_min) as dias_max';
      $modDia = SysdiaM::model()->find($criteria3);

      $criteria = new CDbCriteria();

      if ($systolic > $modSys->sys_max) {
        $criteria->condition = 'systolic_min <= ' . $systolic . ' and systolic_max = 0';
      } else {
        $criteria->addCondition($systolic . ' >= systolic_min');
        $criteria->addCondition($systolic . ' <= systolic_max');
      }

      if ($diastolic > $modDia->dias_max) {
        $criteria->condition = 'diastolic_min <= ' . $diastolic . ' and diastolic_max = 0';
      } else {
        $criteria->addCondition($diastolic . ' >= diastolic_min');
        $criteria->addCondition($diastolic . ' <= diastolic_max');
      }

      $modSysDia = SysdiaM::model()->find($criteria);
      $data['text'] = $modSysDia->sysdia_nama;
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  //        protected function xmlParser(){            
  //            $file = dirname('c:/').'/data/xml/ostar.xml';
  //            echo $file;
  //                    ////'http://www.php.net/feed.atom';
  //            $data = simplexml_load_file($file);
  ////            print_r($data);
  //            //echo count((array)$data);
  //            
  //            $result = array($data->BPMRecord[0]['Date_Time'], $data->BPMRecord[0]['H'], $data->BPMRecord[0]['L'], $data->BPMRecord[0]['P']);
  //            return $result;
  //        }
  //        
  //        protected function panjangText($a,$b){
  //            $tambah = '';
  //            if (strlen($a) < 3){
  //                for($i = strlen($a); $i < 3; $i++){
  //                    $tambah = $tambah.'0';
  //                }
  //                $a = $tambah.$a;
  //            }
  //            $tambah = '';
  //            if (strlen($b) < 3){
  //                for($i = strlen($b); $i < 3; $i++){
  //                    $tambah = $tambah.'0';
  //                }
  //                $b = $tambah.$b;
  //            }
  //            
  //            return $b.' / '.$a;
  //        }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintPemeriksaanFisik($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modGambarTubuh = new RJGambartubuhM();
    $modBagianTubuh = new RJBagiantubuhM();
    $modRiwayatThts = MCRiwayatthtR::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id));
    $attrRiwayatTht = array(
      'bentuk_telinga', 'liang_telinga', 'membran_timpani', 'serumen', 'keterangan_telinga',
      'bentuk_hidung', 'septum_nasi', 'konka_nasal', 'keterangan_hidung',
      'pharynx', 'tonsil', 'ukuran', 'keterangan_tenggorokan',
      'oral_hygine', 'gusi', 'gigi', 'keterangan_mulut',
      'bentuk_leher', 'kelenjar_thyroid', 'keterangan_leher',
      'paru_inspeksi', 'paru_palpasi', 'paru_perkusi', 'paru_auskultasi', 'keterangan_paru',
      'jantung_inspeksi', 'jantung_palpasi', 'jantung_perkusi', 'jantung_auskultasi', 'keterangan_jantung',
      'bentuk_abdomen', 'inspeksi_abdomen', 'hati', 'limpa', 'keterangan_abdomen',
      'anus', 'keterangan_rectal',
      'extremitas', 'keterangan_extremitas',
      'neurologis', 'keterangan_neurologis',
      'warna_kulit', 'kelainan_kulit', 'sensibilitas_kulit', 'keterangan_kulit',
      'kriteria_td'
    );
    foreach ($modRiwayatThts as $i => $val) {
      $modRiwayatTht[$attrRiwayatTht[$i]] = $val->status_bagiantht;
    }
    $jumlah = 0;
    $hasil = null;
    $gcs_eye = $modPemeriksaanFisik->gcs_eye;
    $gcs_motorik = $modPemeriksaanFisik->gcs_motorik;
    $gcs_verbal = $modPemeriksaanFisik->gcs_verbal;

    $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
    $namaGCS = GcsM::model()->find('' . $jumlah . '>=gcs_nilaimin AND ' . $jumlah . '<=gcs_nilaimax AND gcs_aktif=TRUE');
    if (!empty($namaGCS)) { //Jika Nilai GCSnya ada
      $hasil = $namaGCS->gcs_nama;
    } else {
      $hasil = 'Nilai GCS Tidak Ditemukan';
    }

    $judul_print = 'PEMERIKSAAN FISIK';
    $this->render($this->path_view_mcu . 'print', array(
      'format' => $format,
      'hasil' => $hasil,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modGambarTubuh' => $modGambarTubuh,
      'modBagianTubuh' => $modBagianTubuh,
      'modRiwayatTht' => $modRiwayatTht
    ));
  }

  // RND-5044 action pindahan dari Controller/ActionAjaxController
  public function actionGetMetodeGCS()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $gcs_eye = $_POST['gcs_eye'];
      $gcs_motorik = $_POST['gcs_motorik'];
      $gcs_verbal = $_POST['gcs_verbal'];

      $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;

      $namaGCS = GcsM::model()->find('' . $jumlah . '>=gcs_nilaimin AND ' . $jumlah . '<=gcs_nilaimax AND gcs_aktif=TRUE');
      if (!empty($namaGCS)) { //Jika Nilai GCSnya ada
        $data['idGCS'] = $namaGCS->gcs_id;
        $data['namaGCS'] = $namaGCS->gcs_nama;
      } else {
        $data['pesan'] = 'Nilai GCS Tidak Ditemukan';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetfromDevice()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $file = dirname('c:/OstarP2/x') . '/OstarXML.xml';
      } else {
        $file = Yii::app()->getBaseUrl('webroot') . '/data/xml/ostar.xml';
      }

      $data2 = simplexml_load_file($file);
      $a = $data2->BPMRecord[0]['H'];
      $b = $data2->BPMRecord[0]['L'];
      $c = $data2->BPMRecord[0]['P'];

      $tambah = '';
      if (strlen($a) < 3) {
        for ($i = strlen($a); $i < 3; $i++) {
          $tambah = $tambah . '0';
        }
        $a = $tambah . $a;
      }
      $tambah = '';
      if (strlen($b) < 3) {
        for ($i = strlen($b); $i < 3; $i++) {
          $tambah = $tambah . '0';
        }
        $b = $tambah . $b;
      }

      $data['sys'] = "$a";
      $data['dias'] = "$b";
      $data['detaknadi'] = "$c";
      $data['tekanandarah'] = $a . ' / ' . $b;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionMasterKeadaanUmum()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']), true);
      $keluhans = KeadaanumumM::model()->findAll($criteria);
      $data = array();
      foreach ($keluhans as $i => $keluhan) {
        $data[$i] = array(
          'key' => $keluhan->keadaanumum_nama,
          'value' => $keluhan->keadaanumum_nama
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  // RND-5044 action pindahan dari Controller/ActionAutoCompleteController
  public function actionAutocompleteParamedisRJ()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = ParamedisV::model()->findAll($criteria);
      foreach ($models as $item) {
        $arr[] = $item->nama_pegawai; //array(
        //'no_rekam_medik' => $item->no_rekam_medik,
        //'value' => $item->city,
        //'label' => $item->city . ' (' . $item->province . ')',
        //);
      }

      echo CJSON::encode($arr);
    }
    Yii::app()->end();
  }

  public function actionTambahBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $form = '';
      if (!empty($_POST['bagiantubuh_id'])) {
        $modPemeriksaanGbr = new RJPemeriksaangambarT();
        $modPemeriksaanGbr->bagiantubuh_id = $_POST['bagiantubuh_id'];
        $modPemeriksaanGbr->namabagtubuh = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
        $modPemeriksaanGbr->keterangan_periksa_gbr = $_POST['keterangan'];
        $modPemeriksaanGbr->kordinat_tubuh_x = $_POST['pic_x'];
        $modPemeriksaanGbr->kordinat_tubuh_y = $_POST['pic_y'];
        $form = $this->renderPartial($this->path_view_mcu . '_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
        $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
        $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
        echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
      } else {
        $pesan = 'Bagian tubuh tidak boleh kosong!';
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }

  public function actionHapusBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $loadPemeriskaanGamabr = RJPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
      if ($loadPemeriskaanGamabr->delete()) {
        $pesan = '';
        echo CJSON::encode(array('pesan' => $pesan));
      } else {
        $pesan = "Bagian Tubuh gagal dihapus!";
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }
}
