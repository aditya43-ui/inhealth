<?php

/**
 * controller utama pemeriksaa fisik
 * 
 * @package application.modules.perawatanIntensif
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 * 
 */
class PemeriksaanFisikTPIController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $simpanpemeriksaanfisik = false;
  public $simpanpemeriksaangambar = true;
  public $path_view = 'perawatanIntensif.views.pemeriksaanFisikTPI.';

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex()
  {
    $this->layout = '//layouts/iframe';
    //            $result = $this->xmlParser();
    $pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
    $pasienadmisi_id = (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null);
    $tglperiksafisik = (isset($_GET['tglperiksafisik']) ? $_GET['tglperiksafisik'] : null);
    $modBagianTubuh = new PIBagiantubuhM();
    $modGambarTubuh = new PIGambartubuhM();
    $modPemeriksaanGambar = array(); //PIPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (isset($pendaftaran_id)) { // jika di klik ubah di tabel Riwayat Fisik
      $pendaftaran_id = $pendaftaran_id;
      $pasienadmisi_id = $pasienadmisi_id;
      $cekPemeriksaanFisik = PIPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'tglperiksafisik' => $tglperiksafisik));
      $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
      $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modPpds = PpdsM::model()->findByPk($modPendaftaran->ppds_id);
      $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
      $tabelPemeriksaan = PIPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id), array('order' => 'create_time DESC'));
    } else {
      $cekPemeriksaanFisik = PIPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => null));
      $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
      $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modPpds = PpdsM::model()->findByPk($modPendaftaran->ppds_id);
      $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
      $tabelPemeriksaan = PIPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id), array('order' => 'create_time DESC'));
    }




    $format = new MyFormatter();
    $modPIMetodeGSCM = PIMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_singkatan,metodegcs_nilai DESC');



    if (!empty($cekPemeriksaanFisik)) {  //Jika Pasien Sudah Melakukan Pemeriksaan Fisik  Sebelumnya
      $modPemeriksaanFisik = $cekPemeriksaanFisik;
      $modPemeriksaanGambar = PIPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id));

      if (empty($modPemeriksaanFisik->paramedis_nama)) {
        $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if (!empty($pegawai)) {
          $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;
        }
      }
      if ($modPemeriksaanFisik->gcs_jenis) {
        $modPemeriksaanFisik->gcs_jenis = 1;
      } else {
        $modPemeriksaanFisik->gcs_jenis = 0;
      }

      if ($modPemeriksaanFisik->leher_anemia) {
        $modPemeriksaanFisik->is_pilih = 'isanemia';
      } elseif ($modPemeriksaanFisik->leher_leterus) {
        $modPemeriksaanFisik->is_pilih = 'isleterus';
      } elseif ($modPemeriksaanFisik->leher_cyanosis) {
        $modPemeriksaanFisik->is_pilih = 'iscyanosis';
      } elseif ($modPemeriksaanFisik->leher_dyspneu) {
        $modPemeriksaanFisik->is_pilih = 'isdyspneu';
      }

      //var_dump($modPemeriksaanFisik->leher_reflekpupil);die;                                        
      $modPemeriksaanFisik->leher_reflekpupil = Params::gantiBoolean($modPemeriksaanFisik->leher_reflekpupil);
      $modPemeriksaanFisik->leher_jvp = Params::gantiBoolean($modPemeriksaanFisik->leher_jvp);
      $modPemeriksaanFisik->leher_kelgetahbening_teraba = Params::gantiBoolean($modPemeriksaanFisik->leher_kelgetahbening_teraba);
      $modPemeriksaanFisik->leher_kelenjartiroid_teraba = Params::gantiBoolean($modPemeriksaanFisik->leher_kelenjartiroid_teraba);

      $modIntegumen = IntegumenT::model()->findByAttributes(array(
        'pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id,
      ));
      if (empty($modIntegumen)) {
        $modIntegumen = new IntegumenT();
      } else {

        $arr_warna = array("Normal", "Pucat", "Kemerahan");
        $res_warna = array(
          'val' => '',
          'lain2' => '',
        );

        $arr_int = array("Normal", "Luka", "Kemerahan", "Bula", "Ptekie", "Memar");
        $res_int = array(
          'val' => '',
          'lain2' => '',
        );

        if (in_array($modIntegumen->integritas, $arr_int)) {
          $res_int['val'] = $modIntegumen->integritas;
        } else {
          $res_int['val'] = "Lain2";
          $res_int['lain2'] = $modIntegumen->integritas;
        }
        if (in_array($modIntegumen->warna, $arr_warna)) {
          $res_warna['val'] = $modIntegumen->warna;
        } else {
          $res_warna['val'] = "Lain2";
          $res_warna['lain2'] = $modIntegumen->warna;
        }


        $modIntegumen->integritas = $res_int;
        $modIntegumen->warna = $res_warna;
        //var_dump($modIntegumen->attributes); die;

        if (!empty($modPemeriksaanFisik->reflekbayi)) {
          $modPemeriksaanFisik->reflekbayi = CJSON::decode($modPemeriksaanFisik->reflekbayi);
        }
      }
    } else {  //Jika Pasien Belum Pernah melakukan Pemeriksaan Fisik
      $modPemeriksaanFisik = new PIPemeriksaanFisikT;
      $modPemeriksaanFisik->pegawai_id = $modPendaftaran->pegawai_id;
      $modPemeriksaanFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPemeriksaanFisik->ppds_id = $modPendaftaran->ppds_id;
      $modPemeriksaanFisik->pasien_id = $modPasien->pasien_id;
      $modPemeriksaanFisik->tglperiksafisik = date('Y-m-d H:i:s');
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      if (!empty($pegawai))
        $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;

      $modIntegumen = new IntegumenT();
    }
    //            $modPemeriksaanFisik->td_diastolic = $result[2];
    //            $modPemeriksaanFisik->td_systolic = $result[1];
    //            $modPemeriksaanFisik->detaknadi = $result[3];
    //            
    //            $modPemeriksaanFisik->tekanandarah = $this->panjangText($modPemeriksaanFisik->td_diastolic, $modPemeriksaanFisik->td_systolic);;
    //            echo $modPemeriksaanFisik->tekanandarah;exit();
    // input baru 

    $modMasukKamar = PIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modAdmisi->pasienadmisi_id));
    if (!empty($modMasukKamar)) {
      $modPemeriksaanFisik->pegawai_id = $modMasukKamar->pegawai_id;
    } else {
      $modPemeriksaanFisik->pegawai_id = $modPendaftaran->pegawai_id;
    }


    if (isset($_POST['PIPemeriksaanFisikT']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id'])) {
      //                        echo nl2br(print_r($_POST['PIPemeriksaanFisikT'],1));
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPemeriksaanFisik->attributes = $_POST['PIPemeriksaanFisikT'];
        //    var_dump($_POST['PIPemeriksaanFisikT']);die();
        if (isset($_POST['PIPemeriksaanFisikT']['gcs_id'])) {
          if ($_POST['PIPemeriksaanFisikT']['gcs_id'] < 1) {
            $_POST['PIPemeriksaanFisikT']['gcs_id'] = null;
          }
        }
        //                                $modPemeriksaanFisik->keadaanumum = isset($_POST['PIPemeriksaanFisikT']['keadaanumum'])? $_POST['PIPemeriksaanFisikT']['keadaanumum'] : "-";
        $modPemeriksaanFisik->keadaanumum = isset($_POST['PIPemeriksaanFisikT']['keadaanumum']) ? $_POST['PIPemeriksaanFisikT']['keadaanumum'] : '';
        $modPemeriksaanFisik->tglperiksafisik = $format->formatDateTimeForDb($_POST['PIPemeriksaanFisikT']['tglperiksafisik']);
        //                                $modPemeriksaanFisik->indexmassatubuh=isset($_POST['imtValue'])?$_POST['imtValue']:null;
        $modPemeriksaanFisik->pasienadmisi_id = $_GET['pasienadmisi_id'];
        $modPemeriksaanFisik->leher_mata =  isset($_POST['PIPemeriksaanFisikT']['leher_mata']) ? $_POST['PIPemeriksaanFisikT']['leher_mata'] : "";
        $modPemeriksaanFisik->leher_telinga =  isset($_POST['PIPemeriksaanFisikT']['leher_telinga']) ? $_POST['PIPemeriksaanFisikT']['leher_telinga'] : "";
        $modPemeriksaanFisik->ppds_id = isset($_POST['PIPemeriksaanFisikT']['ppsd_id']) ? $_POST['PIPemeriksaanFisikT']['ppsd_id'] : "";

        $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
        //                                $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPemeriksaanFisik->create_ruangan = $modAdmisi->ruangan_id;
        $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->id;

        $modPemeriksaanFisik->gcs_jenis = $_POST['PIPemeriksaanFisikT']['gcs_jenis'];
        $modPemeriksaanFisik->jn_paten = $_POST['PIPemeriksaanFisikT']['jn_paten'];
        $modPemeriksaanFisik->jn_obstruktifpartial = $_POST['PIPemeriksaanFisikT']['jn_obstruktifpartial'];
        $modPemeriksaanFisik->jn_obstruktifnormal = $_POST['PIPemeriksaanFisikT']['jn_obstruktifnormal'];
        $modPemeriksaanFisik->jn_stridor = $_POST['PIPemeriksaanFisikT']['jn_stridor'];
        $modPemeriksaanFisik->jn_gargling = $_POST['PIPemeriksaanFisikT']['jn_gargling'];
        $modPemeriksaanFisik->pgp_normal = $_POST['PIPemeriksaanFisikT']['pgp_normal'];
        $modPemeriksaanFisik->pgp_kussmaul = $_POST['PIPemeriksaanFisikT']['pgp_kussmaul'];
        $modPemeriksaanFisik->pgp_takipnea = $_POST['PIPemeriksaanFisikT']['pgp_takipnea'];
        $modPemeriksaanFisik->pgp_retraktif = $_POST['PIPemeriksaanFisikT']['pgp_retraktif'];
        $modPemeriksaanFisik->pgp_dangkal = $_POST['PIPemeriksaanFisikT']['pgp_dangkal'];
        $modPemeriksaanFisik->pgd_simetri = $_POST['PIPemeriksaanFisikT']['pgd_simetri'];
        $modPemeriksaanFisik->pgd_asimetri = $_POST['PIPemeriksaanFisikT']['pgd_asimetri'];
        $modPemeriksaanFisik->sirkulasi_nadicarotis = $_POST['PIPemeriksaanFisikT']['sirkulasi_nadicarotis'];
        $modPemeriksaanFisik->sirkulasi_nadiradialis = $_POST['PIPemeriksaanFisikT']['sirkulasi_nadiradialis'];
        $modPemeriksaanFisik->cfr_kecil_2 = $_POST['PIPemeriksaanFisikT']['cfr_kecil_2'];
        $modPemeriksaanFisik->cfr_besar_2 = $_POST['PIPemeriksaanFisikT']['cfr_besar_2'];
        $modPemeriksaanFisik->kulit_normal = $_POST['PIPemeriksaanFisikT']['kulit_normal'];
        $modPemeriksaanFisik->kulit_jaundice = $_POST['PIPemeriksaanFisikT']['kulit_jaundice'];
        $modPemeriksaanFisik->kulit_cyanosis = $_POST['PIPemeriksaanFisikT']['kulit_cyanosis'];
        $modPemeriksaanFisik->kulit_pucat = $_POST['PIPemeriksaanFisikT']['kulit_pucat'];
        $modPemeriksaanFisik->kulit_berkeringat = $_POST['PIPemeriksaanFisikT']['kulit_berkeringat'];
        $modPemeriksaanFisik->akral = $_POST['PIPemeriksaanFisikT']['akral'];

        /* $modPemeriksaanFisik->batasmakanan_sebutkan = (isset($_POST['PIPemeriksaanFisikT']['batasmakanan_sebutkan'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['batasmakanan_sebutkan']) : '';
                  $modPemeriksaanFisik->gigipalsu_bagian = (isset($_POST['PIPemeriksaanFisikT']['gigipalsu_bagian'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['gigipalsu_bagian']) : '';
                  $modPemeriksaanFisik->lokasiluka = (isset($_POST['PIPemeriksaanFisikT']['lokasiluka'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['lokasiluka']) : '';
                  $modPemeriksaanFisik->pendengaran_sebutkan = (isset($_POST['PIPemeriksaanFisikT']['pendengaran_sebutkan'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['pendengaran_sebutkan']) : '';
                  $modPemeriksaanFisik->penglihatan_sebutkan = (isset($_POST['PIPemeriksaanFisikT']['penglihatan_sebutkan'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['penglihatan_sebutkan']) : '';
                  $modPemeriksaanFisik->defekasi_sebutkan = (isset($_POST['PIPemeriksaanFisikT']['defekasi_sebutkan'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['defekasi_sebutkan']) : '';
                  $modPemeriksaanFisik->miksi_sebutkan = (isset($_POST['PIPemeriksaanFisikT']['miksi_sebutkan'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['miksi_sebutkan']) : '';
                  $modPemeriksaanFisik->hambatanpembelajaran_ya = (isset($_POST['PIPemeriksaanFisikT']['hambatanpembelajaran_ya'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['hambatanpembelajaran_ya']) : '';
                  $modPemeriksaanFisik->kebutuhanpembelajaran = (isset($_POST['PIPemeriksaanFisikT']['kebutuhanpembelajaran'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['kebutuhanpembelajaran']) : '';
                  $modPemeriksaanFisik->hpht = (isset($_POST['PIPemeriksaanFisikT']['hpht'])) ? implode(', ', $_POST['PIPemeriksaanFisikT']['hpht']) : '';

                  //inputan nyeri
                  $modPemeriksaanFisik->keluhan_nyeri=$_POST['PIPemeriksaanFisikT']['keluhan_nyeri'];
                  $modPemeriksaanFisik->skala_wongbaker_nrs=$_POST['PIPemeriksaanFisikT']['skala_wongbaker_nrs'];
                  $modPemeriksaanFisik->rasanyeri_berpindah=$_POST['PIPemeriksaanFisikT']['rasanyeri_berpindah'];
                  $modPemeriksaanFisik->lama_nyeri=$_POST['PIPemeriksaanFisikT']['lama_nyeri'];
                  $modPemeriksaanFisik->seringmengalami_nyeri=$_POST['PIPemeriksaanFisikT']['seringmengalami_nyeri'];
                  $modPemeriksaanFisik->penyebabberkurang_nyeri=$_POST['PIPemeriksaanFisikT']['penyebabberkurang_nyeri'];
                  $modPemeriksaanFisik->rasanyeri_tajam=$_POST['PIPemeriksaanFisikT']['rasanyeri_tajam'];
                  $modPemeriksaanFisik->rasanyeri_tumpul=$_POST['PIPemeriksaanFisikT']['rasanyeri_tumpul'];
                  $modPemeriksaanFisik->rasanyeri_ditarik=$_POST['PIPemeriksaanFisikT']['rasanyeri_ditarik'];
                  $modPemeriksaanFisik->rasanyeri_ditusuk=$_POST['PIPemeriksaanFisikT']['rasanyeri_ditusuk'];
                  $modPemeriksaanFisik->rasanyeri_dibakar=$_POST['PIPemeriksaanFisikT']['rasanyeri_dibakar'];
                  $modPemeriksaanFisik->rasanyeri_dipukul=$_POST['PIPemeriksaanFisikT']['rasanyeri_dipukul'];
                  $modPemeriksaanFisik->rasanyeri_berdenyut=$_POST['PIPemeriksaanFisikT']['rasanyeri_berdenyut'];
                  $modPemeriksaanFisik->rasanyeri_ditikam=$_POST['PIPemeriksaanFisikT']['rasanyeri_ditikam'];
                  $modPemeriksaanFisik->rasanyeri_kram=$_POST['PIPemeriksaanFisikT']['rasanyeri_kram'];

                  //inputan resiko jatuh
                  $modPemeriksaanFisik->riwayatjatuh_penilaian=$_POST['PIPemeriksaanFisikT']['riwayatjatuh_penilaian'];
                  $modPemeriksaanFisik->riwayatjatuh_skor=$_POST['PIPemeriksaanFisikT']['riwayatjatuh_skor'];
                  $modPemeriksaanFisik->diagnosismedis_penilaian=$_POST['PIPemeriksaanFisikT']['diagnosismedis_penilaian'];
                  $modPemeriksaanFisik->diagnosismedis_skor=$_POST['PIPemeriksaanFisikT']['diagnosismedis_skor'];
                  $modPemeriksaanFisik->alatbantujalan_penilaian=$_POST['PIPemeriksaanFisikT']['alatbantujalan_penilaian'];
                  $modPemeriksaanFisik->alatbantujalan_skor=$_POST['PIPemeriksaanFisikT']['alatbantujalan_skor'];
                  $modPemeriksaanFisik->memakaiterapiheparin_penilaian=$_POST['PIPemeriksaanFisikT']['memakaiterapiheparin_penilaian'];
                  $modPemeriksaanFisik->memakaiterapiheparin_skor=$_POST['PIPemeriksaanFisikT']['memakaiterapiheparin_skor'];
                  $modPemeriksaanFisik->caraberjalan_penilaian=$_POST['PIPemeriksaanFisikT']['caraberjalan_penilaian'];
                  $modPemeriksaanFisik->caraberjalan_skor=$_POST['PIPemeriksaanFisikT']['caraberjalan_skor'];
                  $modPemeriksaanFisik->statusmental_penilaian=$_POST['PIPemeriksaanFisikT']['statusmental_penilaian'];
                  $modPemeriksaanFisik->statusmental_skor=$_POST['PIPemeriksaanFisikT']['statusmental_skor'];
                  $modPemeriksaanFisik->resikojatuh_skor=$_POST['PIPemeriksaanFisikT']['resikojatuh_skor'];
                  $modPemeriksaanFisik->resikojatuh_keterangan=$_POST['PIPemeriksaanFisikT']['resikojatuh_keterangan']; */
        if (!empty($modPemeriksaanFisik->tl_homecare_tgl)) {
          $modPemeriksaanFisik->tl_homecare_tgl = MyFormatter::formatDateTimeForDb($modPemeriksaanFisik->tl_homecare_tgl);
        } else {
          $modPemeriksaanFisik->tl_homecare_tgl = null;
        }

        if ($modPemeriksaanFisik->is_pilih == 'isanemia') {
          $modPemeriksaanFisik->leher_anemia = true;
          $modPemeriksaanFisik->leher_leterus = false;
          $modPemeriksaanFisik->leher_cyanosis = false;
          $modPemeriksaanFisik->leher_dyspneu = false;
        } elseif ($modPemeriksaanFisik->is_pilih == 'isleterus') {
          $modPemeriksaanFisik->leher_anemia = false;
          $modPemeriksaanFisik->leher_leterus = true;
          $modPemeriksaanFisik->leher_cyanosis = false;
          $modPemeriksaanFisik->leher_dyspneu = false;
        } elseif ($modPemeriksaanFisik->is_pilih == 'iscyanosis') {
          $modPemeriksaanFisik->leher_anemia = false;
          $modPemeriksaanFisik->leher_leterus = false;
          $modPemeriksaanFisik->leher_cyanosis = true;
          $modPemeriksaanFisik->leher_dyspneu = false;
        } elseif ($modPemeriksaanFisik->is_pilih == 'isdyspneu') {
          $modPemeriksaanFisik->leher_anemia = false;
          $modPemeriksaanFisik->leher_leterus = false;
          $modPemeriksaanFisik->leher_cyanosis = false;
          $modPemeriksaanFisik->leher_dyspneu = true;
        }

        $modPemeriksaanFisik->mews_suhu = str_replace(",", ".", $modPemeriksaanFisik->mews_suhu);
        $modPemeriksaanFisik->ews_suhu = str_replace(",", ".", $modPemeriksaanFisik->ews_suhu);
        $modPemeriksaanFisik->suhutubuh = str_replace(",", ".", $modPemeriksaanFisik->suhutubuh);

        if (!empty($modPemeriksaanFisik->mews_totalkriteria)) {
          $modPemeriksaanFisik->mews_totalkriteria = implode(".", $modPemeriksaanFisik->mews_totalkriteria);
        }
        if (!empty($modPemeriksaanFisik->reflekbayi)) {
          $modPemeriksaanFisik->reflekbayi = CJSON::encode($modPemeriksaanFisik->reflekbayi);
        }

//        var_dump($modPemeriksaanFisik->attributes); die;
        
        if ($modPemeriksaanFisik->validate()) {
          if ($modPemeriksaanFisik->save()) {
            // $updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
            $this->simpanpemeriksaanfisik = true;
            $this->simpanDiagnosaKerja($modPemeriksaanFisik, $_POST['PIPemeriksaanFisikT']);


            if (isset($_POST['IntegumenT'])) {
              $this->simpanIntegumen($modPemeriksaanFisik, $_POST['IntegumenT']);
            }
          }
        }
        if (isset($_POST['PIPemeriksaangambarT'])) {
          if (count((array)$_POST['PIPemeriksaangambarT']) > 0) {
            foreach ($_POST['PIPemeriksaangambarT'] as $i => $postperiksagbr) {
              $this->simpanpemeriksaangambar &= $this->simpanPemeriksaanGambar($postperiksagbr, $modPemeriksaanFisik, $modGambarTubuh);
            }
          }
        }

//                        var_dump($this->simpanpemeriksaanfisik, $this->simpanpemeriksaangambar); die;

        if ($this->simpanpemeriksaanfisik && $this->simpanpemeriksaangambar) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Pemeriksaan Fisik berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemeriksaan Fisik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
//                        var_dump($exc->getMessage(), $exc->getTraceAsString());
//                        die;
        Yii::app()->user->setFlash('error', "Data Pemeriksaan Fisik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id));
      }
    }
    // end input baru
    // update data
    //        if (isset($_POST['PIPemeriksaanFisikT']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id']) && isset($_GET['tglperiksafisik'])) {
    //            $modPemeriksaanFisik->attributes = $_POST['PIPemeriksaanFisikT'];
    //            $modPemeriksaanFisik->keadaanumum = isset($_POST['PIPemeriksaanFisikT']['keadaanumum']) ? implode(', ', $_POST['PIPemeriksaanFisikT']['keadaanumum']) : '';
    //            $modPemeriksaanFisik->tglperiksafisik = $format->formatDateTimeForDb($_POST['PIPemeriksaanFisikT']['tglperiksafisik']);
    //            $modPemeriksaanFisik->indexmassatubuh = isset($_POST['imtValue']) ? $_POST['imtValue'] : null;
    //            $modPemeriksaanFisik->pasienadmisi_id = $_GET['pasienadmisi_id'];
    //            $modPemeriksaanFisik->update_time = date('Y-m-d H:i:s');
    ////                        $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            $modPemeriksaanFisik->create_ruangan = $modAdmisi->ruangan_id;
    //            $modPemeriksaanFisik->update_loginpemakai_id = Yii::app()->user->id;
    //
    //
    //            if ($modPemeriksaanFisik->save()) {
    //                Yii::app()->user->setFlash('success', "Update Data Pemeriksaan Fisik Berhasil");
    //                $this->refresh();
    //            }
    //        }
    //end update data
    $modPemeriksaanFisik->tglperiksafisik = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPemeriksaanFisik->tglperiksafisik, 'yyyy-MM-dd hh:mm:ss')
    );
    $this->render('indexPI', array(
      'modPasien' => $modPasien,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPendaftaran' => $modPendaftaran,
      'modPIMetodeGSCM' => $modPIMetodeGSCM,
      'modAdmisi' => $modAdmisi,
      'modPpds'=>$modPpds,
      'format' => $format,
      'tabelPemeriksaan' => $tabelPemeriksaan,
      'modGambarTubuh' => $modGambarTubuh,
      'modBagianTubuh' => $modBagianTubuh,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modIntegumen' => $modIntegumen,
    ));
  }

  public function actionHapusRiwayatPemeriksaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPemeriksaanFisik = (isset($_POST['pemeriksaanfisik_id']) ? $_POST['pemeriksaanfisik_id'] : null);
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        DiagnosakerjaT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
        AsesmennyeriflaccsT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
        PemeriksaangambarT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
        PemeriksaankalaT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
        PengkajianaskepT::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
        RiwayatthtR::model()->deleteAllByAttributes(array('pemeriksaanfisik_id' => $idPemeriksaanFisik));
        $deletePemeriksaanFisik = PIPemeriksaanFisikT::model()->deleteByPk($idPemeriksaanFisik);
        if ($deletePemeriksaanFisik) {
          $data['pesan'] = "Riwayat Pemeriksaan Fisik Berhasil Dihapus!";
          $data['sukses'] = 1;
          $transaction->commit();
        } else {
          $data['pesan'] = "Gagal Menghapus Pemeriksaan Fisik";
          $data['sukses'] = 0;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Hapus Data Gagal :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

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

   
  public function actionPrintPemeriksaanFisik($pendaftaran_id, $pemeriksaanfisik_id = null) {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (!empty($pemeriksaanfisik_id)) {
        $modPemeriksaanFisik = PIPemeriksaanFisikT::model()->findByAttributes(array('pemeriksaanfisik_id' => $pemeriksaanfisik_id));
        $modPemeriksaanGambar = PIPemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $pemeriksaanfisik_id));
    } else {
        $modPemeriksaanFisik = PIPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPemeriksaanGambar = PIPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    }
    $modGambarTubuh = new PIGambartubuhM();
    $modBagianTubuh = new PIBagiantubuhM();
    if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
        $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
    }


    // Asesmen Nyeri (Fisioterapi)
    $modFlaCcs = new AsesmennyeriflaccsT;
    $dataFlaCcs = array();
    $getFlaCcs = null;
    $cekFlaCcs = array();

    $criFla = new CDbCriteria();
    $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
    $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
    $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
    $modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);


    foreach ($modNyeriFlaCcs as $dtF) {

        $datas = AsesmennyeriflaccsT::model()->findByAttributes(array(
            'pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id,
            'skalanyeriflaccs_id' => $dtF->skalanyeriflaccs_id,
        ));

        $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
        $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
            'id' => $dtF->skalanyeriflaccs_id,
            'keterangan' => $dtF->skalanyeriflaccs_desc,
            'value' => empty($datas) ? false : true,
        );
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

    // var_dump($modPemeriksaanFisik);die;
    $judul_print = 'PEMERIKSAAN FISIK';
    $this->render('printV3', array(
      'format' => $format,
      'hasil' => $hasil,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modGambarTubuh' => $modGambarTubuh,
      'modBagianTubuh' => $modBagianTubuh
    ));
}
  // public function actionPrintPemeriksaanFisik1($pendaftaran_id, $pemeriksaanfisik_id)
  // {
  //   $this->layout = '//layouts/printWindows';
  //   $format = new MyFormatter;
  //   $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
  //   $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
  //   $modPemeriksaanFisik = PIPemeriksaanFisikT::model()->findByPk($pemeriksaanfisik_id);
  //   $modPemeriksaanGambar = PIPemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $pemeriksaanfisik_id));
  //   $modGambarTubuh = new PIGambartubuhM();
  //   $modBagianTubuh = new PIBagiantubuhM();
  //   $jumlah = 0;
  //   $hasil = null;
  //   $gcs_eye = $modPemeriksaanFisik->gcs_eye;
  //   $gcs_motorik = $modPemeriksaanFisik->gcs_motorik;
  //   $gcs_verbal = $modPemeriksaanFisik->gcs_verbal;

  //   $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
  //   $namaGCS = GcsM::model()->find('' . $jumlah . '>=gcs_nilaimin AND ' . $jumlah . '<=gcs_nilaimax AND gcs_aktif=TRUE');
  //   if (!empty($namaGCS)) { //Jika Nilai GCSnya ada
  //     $hasil = $namaGCS->gcs_nama;
  //   } else {
  //     $hasil = 'Nilai GCS Tidak Ditemukan';
  //   }

  //   $judul_print = 'PEMERIKSAAN FISIK';
  //   $this->render('printV3', array(
  //     'format' => $format,
  //     'hasil' => $hasil,
  //     'modPendaftaran' => $modPendaftaran,
  //     'judul_print' => $judul_print,
  //     'modPasien' => $modPasien,
  //     'modPemeriksaanFisik' => $modPemeriksaanFisik,
  //     'modPemeriksaanGambar' => $modPemeriksaanGambar,
  //     'modGambarTubuh' => $modGambarTubuh,
  //     'modBagianTubuh' => $modBagianTubuh
  //   ));
  // }

  public function actionAjaxDetailFisik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idFisik = $_POST['idFisik'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPemeriksaanFisik = PIPemeriksaanFisikT::model()->findByPk($idFisik);
      $jumlah = 0;
      $hasil = null;
      $gcs_eye = $modPemeriksaanFisik->gcs_eye;
      $gcs_motorik = $modPemeriksaanFisik->gcs_motorik;
      $gcs_verbal = $modPemeriksaanFisik->gcs_verbal;
      $modPemeriksaanGambar = PIPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pemeriksaanfisik_id' => $idFisik));
      $modGambarTubuh = PIGambartubuhM::model()->findByAttributes(array(
        'ispemeriksaanfisik' => true,
        'gambartubuh_aktif' => true,
      ));
      $modBagianTubuh = new PIBagiantubuhM();
      $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
      $namaGCS = GcsM::model()->find('' . $jumlah . '>=gcs_nilaimin AND ' . $jumlah . '<=gcs_nilaimax AND gcs_aktif=TRUE');
      if (!empty($namaGCS)) { //Jika Nilai GCSnya ada
        $hasil = $namaGCS->gcs_nama;
      } else {
        $hasil = 'Nilai GCS Tidak Ditemukan';
      }
      $data['result'] = $this->renderPartial('_viewDetailFisik', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik,
        'modPendaftaran' => $modPendaftaran,
        'hasil' => $hasil,
        'modPemeriksaanGambar' => $modPemeriksaanGambar,
        'modGambarTubuh' => $modGambarTubuh,
        'modBagianTubuh' => $modBagianTubuh,
      ), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionMasterKeadaanUmum()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']), true);
      $criteria->limit = 5;
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

  public function simpanPemeriksaanGambar($postperiksagbr, $modPemeriksaanFisik, $modGambarTubuh)
  {
    $format = new MyFormatter;

    // var_dump($postperiksagbr); die;

    $modPemeriksaanGambar = new PIPemeriksaangambarT;
    $modPemeriksaanGambar->attributes = $postperiksagbr;
    $modPemeriksaanGambar->pemeriksaanfisik_id = $modPemeriksaanFisik->pemeriksaanfisik_id;
    $modPemeriksaanGambar->gambartubuh_id = $modGambarTubuh->DataGambarAnatomi->gambartubuh_id;
    $modPemeriksaanGambar->pendaftaran_id = $modPemeriksaanFisik->pendaftaran_id;
    $modPemeriksaanGambar->pasien_id = $modPemeriksaanFisik->pasien_id;
    $modPemeriksaanGambar->tglpemeriksaan = date('Y-m-d H:i:s');
    $modPemeriksaanGambar->create_time = date('Y-m-d H:i:s');
    $modPemeriksaanGambar->create_loginpemakai_id = Yii::app()->user->id;
    $modPemeriksaanGambar->create_ruangan = Yii::app()->user->getState('pegawai_id');

    // var_dump($modPemeriksaanGambar->attributes); die;

    if ($modPemeriksaanGambar->validate()) {
      $modPemeriksaanGambar->save();
      return true;
    } else {
      return false;
    }
  }

  public function actionTambahBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $form = '';
      if (!empty($_POST['bagiantubuh_id'])) {
        $modPemeriksaanGbr = new PIPemeriksaangambarT();
        $modPemeriksaanGbr->bagiantubuh_id = $_POST['bagiantubuh_id'];
        $modPemeriksaanGbr->namabagtubuh = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
        $modPemeriksaanGbr->keterangan_periksa_gbr = $_POST['keterangan'];
        $modPemeriksaanGbr->kordinat_tubuh_x = $_POST['pic_x'];
        $modPemeriksaanGbr->kordinat_tubuh_y = $_POST['pic_y'];
        $modPemeriksaanGbr->gambartubuh_id = $_POST['gambartubuh_id'];

        $modPemeriksaanGbr->look = isset($_POST['look']) ? $_POST['look'] : null;
        $modPemeriksaanGbr->feel = isset($_POST['feel']) ? $_POST['feel'] : null;
        $modPemeriksaanGbr->move = isset($_POST['move']) ? $_POST['move'] : null;
        $modPemeriksaanGbr->sensory = isset($_POST['sensory']) ? $_POST['sensory'] : null;
        $modPemeriksaanGbr->motorik = isset($_POST['motorik']) ? $_POST['motorik'] : null;


        $form = $this->renderPartial($this->path_view . '_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
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
      $loadPemeriskaanGamabr = PIPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
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

  public function actionMasterHambatanPembelajaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $lookup_type = 'hambatanpembelajaran';
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']), true);
      $criteria->compare('LOWER(lookup_type)', $lookup_type, true);
      $criteria->limit = 5;
      $lookups = LookupM::model()->findAll($criteria);
      $data = array();
      foreach ($lookups as $i => $lookup) {
        $data[$i] = array(
          'key' => $lookup->lookup_name,
          'value' => $lookup->lookup_name
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionMasterKebutuhanPembelajaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $lookup_type = 'kebutuhanpembelajaran';
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']), true);
      $criteria->compare('LOWER(lookup_type)', $lookup_type, true);
      $criteria->limit = 5;
      $lookups = LookupM::model()->findAll($criteria);
      $data = array();
      foreach ($lookups as $i => $lookup) {
        $data[$i] = array(
          'key' => $lookup->lookup_name,
          'value' => $lookup->lookup_name
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionGetMetodeGCS()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $gcs_eye = $_POST['gcs_eye'];
      $gcs_motorik = $_POST['gcs_motorik'];
      $gcs_verbal = $_POST['gcs_verbal'];

      $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;

      //         $namaGCS=GcsM::model()->find(''.$jumlah.'>=gcs_nilaimin AND '.$jumlah.'<=gcs_nilaimax AND gcs_aktif=TRUE');
      //         if(count((array)$namaGCS)>0){//Jika Nilai GCSnya ada
      //         $data['idGCS']=$namaGCS->gcs_id;
      //         $data['namaGCS']=$namaGCS->gcs_nama;
      //         }else{
      //             $data['pesan']='Nilai GCS Tidak Ditemukan';
      //         }
      $data = $jumlah; //LNG 815
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetBagianTubuhId()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $data = array();
      $kordinat_x = $_POST['kordinat_x'];
      $kordinat_y = $_POST['kordinat_y'];
      $gambartubuh_id = $_POST['gambartubuh_id'];
      //				$loadPemeriskaanGamabr = RJPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
      $cr = new CDbCriteria();
      $cr->addCondition("" . $kordinat_x . " between kordinat_x and kordinat_x2");
      $cr->addCondition("" . $kordinat_y . " between kordinat_y and kordinat_y2");
      $cr->compare('gambartubuh_id', $gambartubuh_id);
      $cr->order = ('bagiantubuh_urutan asc');

      $result = BagiantubuhM::model()->find($cr);
      if ($result) {
        $data['kakitangan'] = '';
        $tangan = stristr($result['namabagtubuh'], 'tangan');
        $lengan = stristr($result['namabagtubuh'], 'lengan');
        $paha = stristr($result['namabagtubuh'], 'paha');
        $lutut = stristr($result['namabagtubuh'], 'lutut');
        $betis = stristr($result['namabagtubuh'], 'betis');
        $kaki = stristr($result['namabagtubuh'], 'kaki');
        if (!empty($tangan) or !empty($lengan) or !empty($paha) or !empty($lutut) or !empty($betis) or !empty($kaki)) {
          $data['kakitangan'] = 'ok';
        }
        $data['pesan'] = '';
        $data['namabagtubuh'] = $result['namabagtubuh'];
        $data['bagiantubuh_id'] = $result['bagiantubuh_id'];
        echo json_encode($data);
      } else {
        $pesan = "Bagian tubuh belum disetting!";
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Menyimpan data Diagnosa kerja (jika ada).
   * 
   * @param RIPemeriksaanfisikT $model data pemeriksaan fisik
   * @param mixed $post data post submit.
   */
  public function simpanDiagnosaKerja($model, $post)
  {
    DiagnosakerjaT::model()->deleteAllByAttributes(array(
      'pemeriksaanfisik_id' => $model->pemeriksaanfisik_id,
    ));

    if (isset($post['periksa_penunjang_detail'])) {
      foreach ($post['periksa_penunjang_detail'] as $item) {
        $mod = new DiagnosakerjaT();
        $mod->pemeriksaanfisik_id = $model->pemeriksaanfisik_id;
        $mod->diagnosakerja_isi = $item;
        $this->simpanpemeriksaanfisik = $this->simpanpemeriksaanfisik && $mod->save();
        //var_dump($mod->save(), $mod->attributes);
      }
    }

    //var_dump($this->simpanpemeriksaanfisik, $model->attributes, $post);
    // die;
  }

  public function simpanIntegumen($model, $post)
  {

    $mod = IntegumenT::model()->findByAttributes(array(
      'pemeriksaanfisik_id' => $model->pemeriksaanfisik_id,
    ));
    if (empty($mod)) {
      $mod = new IntegumenT();
    }

    $mod->attributes = $post;
    $mod->pemeriksaanfisik_id = $model->pemeriksaanfisik_id;

    if (!empty($mod->warna['val'])) {
      if ($mod->warna['val'] == 'Lain2') {
        $mod->warna = $mod->warna['lain2'];
      } else {
        $mod->warna = $mod->warna['val'];
      }
    } else {
      $mod->warna = "";
    }
    if (!empty($mod->integritas['val'])) {
      if ($mod->integritas['val'] == 'Lain2') {
        $mod->integritas = $mod->integritas['lain2'];
      } else {
        $mod->integritas = $mod->integritas['val'];
      }
    } else {
      $mod->integritas = "";
    }

    $mod->save();
  }
}
