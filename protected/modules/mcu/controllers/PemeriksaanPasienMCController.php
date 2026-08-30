<?php
Yii::import('rawatJalan.controllers.PemeriksaanPasienController');
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.views.*');
/**
 * Digunakan untuk menampilkan informasi Pasien MCU
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.mcu
 * @subpackage controllers
 */
class PemeriksaanPasienMCController extends PemeriksaanPasienController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
  public $path_view_mcu = 'mcu.views.pemeriksaanPasienMC.';

  /**
   * Lists all models.
   */
  public function actionIndex($pendaftaran_id)
  {
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $this->render($this->path_view_mcu . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }


  public function actionDetailPemeriksaanUmum($id)
  {
    $this->layout = '//layouts/iframe';
    $modKunjungan = MCPendaftaranT::model()->findByPk($id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);
    $riwayat = McuPemeriksaanumumT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'mcu_pemeriksaanumum_id desc'
    ));

    $this->render('_pemeriksaanUmum', array(
      'modPendaftaran' => $modKunjungan,
      'modPasien' => $modPasien,
      'riwayat' => $riwayat
    ));
  }

  public function actionDetailJantung($id)
  {
    $this->layout = '//layouts/iframe';
    $modKunjungan = MCPendaftaranT::model()->findByPk($id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);
    $riwayat = McuPemeriksaanjantungT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'checkup_jantung_id desc'
    ));

    $this->render('_jantung', array(
      'modPendaftaran' => $modKunjungan,
      'modPasien' => $modPasien,
      'riwayat' => $riwayat
    ));
  }

  public function actionDetailKandungan($id)
  {
    $this->layout = '//layouts/iframe';
    $modKunjungan = MCPendaftaranT::model()->findByPk($id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);
    $riwayat = McuPemeriksaankandunganT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'checkup_kandungan_id desc'
    ));

    $this->render('_kandungan', array(
      'modPendaftaran' => $modKunjungan,
      'modPasien' => $modPasien,
      'riwayat' => $riwayat
    ));
  }

  public function actionDetailLain2($id)
  {
    $this->layout = '//layouts/iframe';
    $modKunjungan = MCPendaftaranT::model()->findByPk($id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);
    $riwayat = McuPemeriksaanlainlainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'checkup_lainlain_id desc'
    ));

    $this->render('_lainLain', array(
      'modPendaftaran' => $modKunjungan,
      'modPasien' => $modPasien,
      'riwayat' => $riwayat
    ));
  }

  /**
   * Menampilkan riwayat pasien di modul mcu
   * @param type $pendaftaran_id
   */
  public function actionGetRiwayatPasien($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modKunjungan = MCPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);

    $this->render('_riwayatPasien', array(
      'modKunjungan' => $modKunjungan,
      'modPasien' => $modPasien,
    ));
  }

  /**
   * actionDetailAnamnesa = menampilkan detail hasil pemeriksaan pada tab_Anamnesa untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailAnamnesa($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modAnamnesa = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modAnamnesaSearch = new AnamnesaT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_anamnesa', array(
      'modPendaftaran' => $modPendaftaran,
      'modAnamnesa' => $modAnamnesa,
      'modAnamnesaSearch' => $modAnamnesaSearch,
      'modPasien' => $modPasien
    ));
  }

  /**
   * actionDetailPeriksaFisik = menampilkan detail hasil pemeriksaan pada tab_Periksa Fisik untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailPeriksaFisik($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPemeriksaanFisik = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modPemeriksaanFisikSearch = new PemeriksaanfisikT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_periksafisik', array(
      'modPendaftaran' => $modPendaftaran,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPemeriksaanFisikSearch' => $modPemeriksaanFisikSearch,
      'modPasien' => $modPasien
    ));
  }

  /**
   * actionDetailTreadmill = menampilkan detail hasil pemeriksaan pada tab_Treadmill untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailTreadmill($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTreadmill = MCTreadmillT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $modDetail = MCTreadmillT::model()->searchInformasiDetailTreadmill($id);

    $format = new MyFormatter;
    $modTreadmillSearch = new MCTreadmillT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_treadmill', array(
      'modPendaftaran' => $modPendaftaran,
      'modDetail' => $modDetail,
      'modTreadmill' => $modTreadmill,
      'modTreadmillSearch' => $modTreadmillSearch,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien
    ));
  }

  /**
   * actionDetailHearingTest = menampilkan detail hasil pemeriksaan pada tab_Hearing Test untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailHearingTest($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modHearingtest = MCHearingtestT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modHearingtestSearch = new MCHearingtestT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_hearingtest', array(
      'modPendaftaran' => $modPendaftaran,
      'modHearingtest' => $modHearingtest,
      'modHearingtestSearch' => $modHearingtestSearch,
      'modPasien' => $modPasien
    ));
  }

  /**
   * actionDetailKacamata = menampilkan detail hasil pemeriksaan pada tab_Kacamata Test untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailKacamata($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPeriksakacamata = MCPeriksakacamataT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modPeriksakacamataSearch = new MCPeriksakacamataT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_periksakacamata', array(
      'modPendaftaran' => $modPendaftaran,
      'modPeriksakacamata' => $modPeriksakacamata,
      'modPeriksakacamataSearch' => $modPeriksakacamataSearch,
      'modPasien' => $modPasien
    ));
  }

  /**
   * actionDetailJantungKoroner = menampilkan detail hasil pemeriksaan pada tab_Jantung Koroner untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailJantungKoroner($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modJantungKoroner = MCJantungkoronerT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modJantungKoronerSearch = new MCJantungkoronerT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_jantungkoroner', array(
      'modPendaftaran' => $modPendaftaran,
      'modJantungKoroner' => $modJantungKoroner,
      'modJantungKoronerSearch' => $modJantungKoronerSearch,
      'modPasien' => $modPasien
    ));
  }

  /**
   * actionDetailKesimpulanSaran = menampilkan detail hasil pemeriksaan pada tab_Kesimpulan dan Saran untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailKesimpulanSaran($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modKesimpulanSaran = MCKesimpulanmcuT::model()->findByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modKesimpulanSaranSearch = new MCKesimpulanmcuT('search');
    $modSuratStudiLuar = MCSuratstudiluarmcuT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_kesimpulansaran', array(
      'modPendaftaran' => $modPendaftaran,
      'modKesimpulanSaran' => $modKesimpulanSaran,
      'modSuratStudiLuar' => $modSuratStudiLuar,
      'modKesimpulanSaranSearch' => $modKesimpulanSaranSearch,
      'modPasien' => $modPasien
    ));
  }

  /**
   * actionDetailHasilDiagnosa = menampilkan detail hasil pemeriksaan pada tab_diagnosis untuk riwayat pasien
   * LNG-551
   */
  public function actionDetailHasilDiagnosa($id)
  {

    $this->layout = '//layouts/iframe';

    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $detailHasil = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $id));

    $this->render('_detailhasildiagnosa', array(
      'detailHasil' => $detailHasil,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }

  /**
   * actionDetailHasilLab = mnampilkan hasil lab sesuai dengan yang dilab
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   */
  /*
	public function actionDetailHasilLab($id) {
		$this->layout = '//layouts/iframe';
		 $format = new MyFormatter();
		$modPendaftaran = MCPendaftaranT::model()->findByPk($id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

		$cek_penunjang = PasienmasukpenunjangV::model()->findAllByAttributes(
				array('pendaftaran_id' => $id)
		);

		$data_rad = array();
		if (count((array)$cek_penunjang) > 1) {
			$masukpenunjangRad = PasienmasukpenunjangV::model()->findByAttributes(
					array(
						'pendaftaran_id' => $id,
						'ruangan_id' => Params::RUANGAN_ID_RAD
					)
			);

			$modHasilPeriksaRad = HasilpemeriksaanradV::model()->findAllByAttributes(
					array(
				'pasienmasukpenunjang_id' => (isset($masukpenunjangRad->pasienmasukpenunjang_id) ? $masukpenunjangRad->pasienmasukpenunjang_id : null)
					), array(
				'order' => 'pemeriksaanrad_urutan'
					)
			);

			foreach ($modHasilPeriksaRad as $i => $val) {
				$data_rad[] = array(
					'pemeriksaan' => $val['pemeriksaanrad_nama'],
//                        'hasil'=>'Hasil Pemeriksaan ' . $val['pemeriksaanrad_nama'] . ' terlampir',
					'hasil' => 'Hasil terlampir'
				);
			}
		}

		$masukpenunjang = PasienmasukpenunjangV::model()->findByAttributes(
				array('pendaftaran_id' => $id)
		);

		$pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

		$modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
				array(
					'pasienmasukpenunjang_id' => $masukpenunjang->pasienmasukpenunjang_id
				)
		);


//	   $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';   
//	   $detailHasil = array();
		if (!empty($modHasilPeriksa)) {
			$modKunjungan = MCPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $masukpenunjang->pasienmasukpenunjang_id));
			$modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $masukpenunjang->pasienmasukpenunjang_id));
			$modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
		}
		$this->render('_detailhasillab', array(
			'format'=>$format,
			'masukpenunjang' => $masukpenunjang,
			'pemeriksa' => $pemeriksa,
			'modKunjungan'=>$modKunjungan,
            'modHasilPemeriksaan'=>$modHasilPemeriksaan,
            'modDetailHasilPemeriksaans'=>$modDetailHasilPemeriksaans,
			'modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien
		));

//	   $this->render('_detailhasillab',
//		   array(
//			  'modHasilPeriksa'=>$modHasilPeriksa,
//			  'masukpenunjang'=>$masukpenunjang,
//			  'pemeriksa'=>$pemeriksa,
//			  'data'=>$data,
//			  'data_rad'=>$data_rad,
//			   'modPendaftaran'=>$modPendaftaran,
//			   'modPasien'=>$modPasien
//		   )
//	   );
	}*/

  /**
   * Menampilkan detail hasil lab pada modul MCU dan rawat jalan
   * @param type $id
   * @param type $frame
   * @param type $caraPrint
   */
  public function actionDetailHasilLab($id, $frame = null, $caraPrint = null)
  {
    //var_dump($id);die;
    if ($frame == 1) {
      $this->layout = '//layouts/iframe';
    }
    //$modKunjungan = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$id));
    //pasienmasukpenunjang_id
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
    $modKunjungan = MCPasienMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK));

    if (empty($modKunjungan)) {
      echo "Pemeriksaan Laboratorium tidak ditemukan";
      Yii::app()->end();
    }

    $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modKunjungan->pasienmasukpenunjang_id));
    //var_dump($modHasilPemeriksaan->pasien_id);die;
    $modDetailHasilPemeriksaans = $this->loadHasilPemeriksaans($modHasilPemeriksaan);

    $data = array();


    foreach ($modDetailHasilPemeriksaans as $dt) {
      $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
      $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;


      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;

      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;

      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
    }

    $this->render('printHasilPemeriksaan', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
      'data' => $data
    ));
  }

  /**
   * load LBDetailHasilPemeriksaanLabT
   * @param type $modHasilPemeriksaan
   */
  public function loadHasilPemeriksaans($modHasilPemeriksaan)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "
                            JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
                            JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                            JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = MCDetailHasilPemeriksaanLabT::model()->findAll($criteria);
    return $modDetailHasilPemeriksaans;
  }

  /**
   * actionDetailHasilRad = menampilkan hasil radiologi sesuai dengan rad
   * @param type $id
   * @param type $idRad
   */
  public function actionDetailHasilRad($id, $idRad = null)
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_RAD));

    if (!empty($modPasienMasukPenunjang)) {
      $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));

      $pasien = HasilpemeriksaanradV::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));

      if (!empty($idRad)) {
        $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('hasilpemeriksaanrad_id' => $idRad));
      } else {
        $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
      }
    } else {

      echo "Pemeriksaan Radiologi tidak ditemukan";
      Yii::app()->end();
      /*
            $modPasienMasukPenunjang = new PasienmasukpenunjangV();
            $pemeriksa = new PegawaiM;
            $detailHasil = array();
             * 
             */
    }

    $this->render('_detailhasilrad', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'detailHasil' => $detailHasil
    ));
  }

  /**
   * actionDetailHasilRad = menampilkan hasil radiologi sesuai dengan rad
   * @param type $id
   * @param type $idRad
   */
  public function actionDetailHasilRehab($id)
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_FISIOTERAPI));

    if (!empty($modPasienMasukPenunjang)) {
      $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));

      $pasien = PasienM::model()->findByPk($modPasienMasukPenunjang->pasien_id);

      $detailHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
    } else {

      echo "Pemeriksaan Fisioterapi tidak ditemukan";
      Yii::app()->end();
      /*
            $modPasienMasukPenunjang = new PasienmasukpenunjangV();
            $pemeriksa = new PegawaiM;
            $detailHasil = array();
             * 
             */
    }

    $this->render('_detailhasilrehab', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'detailHasil' => $detailHasil
    ));
  }

  public function actionDetailTesSpirometri($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTesSpirometri = MCTesSpirometriT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));

    $format = new MyFormatter;
    $modTesSpirometriSearch = new MCTesSpirometriT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render('_tesSpirometri', array(
      'modPendaftaran' => $modPendaftaran,
      'modTesSpirometri' => $modTesSpirometri,
      'modTesSpirometriSearch' => $modTesSpirometriSearch,
      'modPasien' => $modPasien
    ));
  }

  public function actionDetailPrintHasil($id, $caraPrint = null)
  {
    //var_dump($id);die;
    // $caraPrint = $_REQUEST['caraPrint'];
        $this->layout = '//layouts/iframe';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/iframeNeon';
    }
    // if ($caraPrint == 'PRINT') {
    //   $this->layout = '//layouts/printWindows';
    // }else{
      
    //   if ($frame == 1) {
    //     $this->layout = '//layouts/iframe';
    //   }
    // }
    $format = new MyFormatter();
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
    $modPendaftaran2 = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    $modPasien2 = RJPasienM::model()->findByPk($modPendaftaran2->pasien_id);
    $modKunjungan = MCPendaftaranT::model()->findByPk($id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);

    // LAB
    $modKunjungan2 = MCPasienMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK));

    if (empty($modKunjungan2)) {
      echo "Pemeriksaan Laboratorium tidak ditemukan";
      Yii::app()->end();
    }
    $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modKunjungan2->pasienmasukpenunjang_id));
    //var_dump($modHasilPemeriksaan->pasien_id);die;
    $modDetailHasilPemeriksaans = $this->loadHasilPemeriksaans($modHasilPemeriksaan);

    $data = array();

    foreach ($modDetailHasilPemeriksaans as $dt) {
      $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
      $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;


      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;

      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;

      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
    }


    // RADIOLOGI
    // $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_RAD));

    // if (!empty($modPasienMasukPenunjang)) {
    //   $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));

    //   $pasien = HasilpemeriksaanradV::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));

    //   if (!empty($idRad)) {
    //     $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('hasilpemeriksaanrad_id' => $idRad));
    //   } else {
    //     $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
    //   }
    // } else {
    //   $modPasienMasukPenunjang = '';
    //   $pemeriksa = '';
    //   $detailHasil = '';
    // }


    // REHAB
    // $modPasienMasukPenunjang2 = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_FISIOTERAPI));

    // if (!empty($modPasienMasukPenunjang2)) {
    //   $pemeriksa2 = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang2->pegawai_id));

    //   $pasien2 = PasienM::model()->findByPk($modPasienMasukPenunjang2->pasien_id);

    //   $detailHasil2 = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang2->pasienmasukpenunjang_id));
    // } else {
    //   $modPasienMasukPenunjang2 = '';
    //   $pemeriksa2 = '';
    //   $detailHasil2 = '';
    // }


    // TREAD
    $modTreadmill = MCTreadmillT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $modDetail = MCTreadmillT::model()->searchInformasiDetailTreadmill($id);
    $modTreadmillSearch = new MCTreadmillT('search');


    // Hearing
    // $modHearingtest = MCHearingtestT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    // $modHearingtestSearch = new MCHearingtestT('search');


    // diagnosa
    $detailHasildiagnosa = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $id));


    //kesimpulan
    // $modKesimpulanSaran = MCKesimpulanmcuT::model()->findByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    // $modKesimpulanSaranSearch = new MCKesimpulanmcuT('search');
    // $modSuratStudiLuar = MCSuratstudiluarmcuT::model()->findByAttributes(array('pendaftaran_id' => $id));


    //jantung
    $modJantungKoroner = MCJantungkoronerT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $modJantungKoronerSearch = new MCJantungkoronerT('search');


    //spiro
    $modTesSpirometri = MCTesSpirometriT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $modTesSpirometriSearch = new MCTesSpirometriT('search');


    $riwayat1 = McuPemeriksaanumumT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'mcu_pemeriksaanumum_id desc'
    ));
    $riwayat2 = McuPemeriksaanjantungT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'checkup_jantung_id desc'
    ));
    // $riwayat3 = McuPemeriksaankandunganT::model()->findAllByAttributes(array(
    //   'pendaftaran_id' => $id,
    // ), array(
    //   'order' => 'checkup_kandungan_id desc'
    // ));
    // $riwayat4 = McuPemeriksaanlainlainT::model()->findAllByAttributes(array(
    //   'pendaftaran_id' => $id,
    // ), array(
    //   'order' => 'checkup_lainlain_id desc'
    // ));

    $this->render('_detailprinthasil', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPendaftaran2' => $modPendaftaran2,
      'modPasien2' => $modPasien2,
      'caraPrint' => $caraPrint,
      'modKunjungan' => $modKunjungan,
      'modKunjungan2' => $modKunjungan2,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'data' => $data,
      'detailHasildiagnosa' => $detailHasildiagnosa,
      // 'detailHasil' => $detailHasil,
      // 'masukpenunjang' => $modPasienMasukPenunjang,
      // 'pemeriksa' => $pemeriksa,
      // 'detailHasil2' => $detailHasil2,
      // 'masukpenunjang2' => $modPasienMasukPenunjang2,
      // 'pemeriksa2' => $pemeriksa2,
      'modDetail' => $modDetail,
      'modTreadmill' => $modTreadmill,
      'modTreadmillSearch' => $modTreadmillSearch,
      // 'modHearingtest' => $modHearingtest,
      // 'modHearingtestSearch' => $modHearingtestSearch,
      // 'modKesimpulanSaran' => $modKesimpulanSaran,
      // 'modSuratStudiLuar' => $modSuratStudiLuar,
      // 'modKesimpulanSaranSearch' => $modKesimpulanSaranSearch,
      'modJantungKoroner' => $modJantungKoroner,
      'modJantungKoronerSearch' => $modJantungKoronerSearch,
      'modTesSpirometri' => $modTesSpirometri,
      'modTesSpirometriSearch' => $modTesSpirometriSearch,
      'riwayat1' => $riwayat1,
      'riwayat2' => $riwayat2,
      // 'riwayat3' => $riwayat3,
      // 'riwayat4' => $riwayat4,
    ));
  }
  public function actionPrintHasilDetail($id, $frame = null, $caraPrint = null)
  {
    //var_dump($id);die;
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    }else{
      
      if ($frame == 1) {
        $this->layout = '//layouts/iframe';
      }
    }
    $format = new MyFormatter();
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
    $modPendaftaran2 = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    $modPasien2 = RJPasienM::model()->findByPk($modPendaftaran2->pasien_id);
    $modKunjungan = MCPendaftaranT::model()->findByPk($id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);

    // LAB
    $modKunjungan2 = MCPasienMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK));

    if (empty($modKunjungan2)) {
      echo "Pemeriksaan Laboratorium tidak ditemukan";
      Yii::app()->end();
    }
    $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modKunjungan2->pasienmasukpenunjang_id));
    //var_dump($modHasilPemeriksaan->pasien_id);die;
    $modDetailHasilPemeriksaans = $this->loadHasilPemeriksaans($modHasilPemeriksaan);

    $data = array();

    foreach ($modDetailHasilPemeriksaans as $dt) {
      $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
      $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;


      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;

      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;

      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
      $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
    }


    // RADIOLOGI
    // $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_RAD));

    // if (!empty($modPasienMasukPenunjang)) {
    //   $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));

    //   $pasien = HasilpemeriksaanradV::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));

    //   if (!empty($idRad)) {
    //     $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('hasilpemeriksaanrad_id' => $idRad));
    //   } else {
    //     $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
    //   }
    // } else {
    //   $modPasienMasukPenunjang = '';
    //   $pemeriksa = '';
    //   $detailHasil = '';
    // }


    // REHAB
    // $modPasienMasukPenunjang2 = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_FISIOTERAPI));

    // if (!empty($modPasienMasukPenunjang2)) {
    //   $pemeriksa2 = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang2->pegawai_id));

    //   $pasien2 = PasienM::model()->findByPk($modPasienMasukPenunjang2->pasien_id);

    //   $detailHasil2 = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang2->pasienmasukpenunjang_id));
    // } else {
    //   $modPasienMasukPenunjang2 = '';
    //   $pemeriksa2 = '';
    //   $detailHasil2 = '';
    // }


    // TREAD
    $modTreadmill = MCTreadmillT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $modDetail = MCTreadmillT::model()->searchInformasiDetailTreadmill($id);
    $modTreadmillSearch = new MCTreadmillT('search');


    // Hearing
    // $modHearingtest = MCHearingtestT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    // $modHearingtestSearch = new MCHearingtestT('search');


    // diagnosa
    $detailHasildiagnosa = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $id));


    //kesimpulan
    // $modKesimpulanSaran = MCKesimpulanmcuT::model()->findByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    // $modKesimpulanSaranSearch = new MCKesimpulanmcuT('search');
    // $modSuratStudiLuar = MCSuratstudiluarmcuT::model()->findByAttributes(array('pendaftaran_id' => $id));


    //jantung
    $modJantungKoroner = MCJantungkoronerT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $modJantungKoronerSearch = new MCJantungkoronerT('search');


    //spiro
    $modTesSpirometri = MCTesSpirometriT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $modTesSpirometriSearch = new MCTesSpirometriT('search');


    $riwayat1 = McuPemeriksaanumumT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'mcu_pemeriksaanumum_id desc'
    ));
    $riwayat2 = McuPemeriksaanjantungT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'checkup_jantung_id desc'
    ));
    // $riwayat3 = McuPemeriksaankandunganT::model()->findAllByAttributes(array(
    //   'pendaftaran_id' => $id,
    // ), array(
    //   'order' => 'checkup_kandungan_id desc'
    // ));
    // $riwayat4 = McuPemeriksaanlainlainT::model()->findAllByAttributes(array(
    //   'pendaftaran_id' => $id,
    // ), array(
    //   'order' => 'checkup_lainlain_id desc'
    // ));

    $this->render('_detailprinthasil', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPendaftaran2' => $modPendaftaran2,
      'modPasien2' => $modPasien2,
      'caraPrint' => $caraPrint,
      'modKunjungan' => $modKunjungan,
      'modKunjungan2' => $modKunjungan2,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'data' => $data,
      'detailHasildiagnosa' => $detailHasildiagnosa,
      // 'detailHasil' => $detailHasil,
      // 'masukpenunjang' => $modPasienMasukPenunjang,
      // 'pemeriksa' => $pemeriksa,
      // 'detailHasil2' => $detailHasil2,
      // 'masukpenunjang2' => $modPasienMasukPenunjang2,
      // 'pemeriksa2' => $pemeriksa2,
      'modDetail' => $modDetail,
      'modTreadmill' => $modTreadmill,
      'modTreadmillSearch' => $modTreadmillSearch,
      // 'modHearingtest' => $modHearingtest,
      // 'modHearingtestSearch' => $modHearingtestSearch,
      // 'modKesimpulanSaran' => $modKesimpulanSaran,
      // 'modSuratStudiLuar' => $modSuratStudiLuar,
      // 'modKesimpulanSaranSearch' => $modKesimpulanSaranSearch,
      'modJantungKoroner' => $modJantungKoroner,
      'modJantungKoronerSearch' => $modJantungKoronerSearch,
      'modTesSpirometri' => $modTesSpirometri,
      'modTesSpirometriSearch' => $modTesSpirometriSearch,
      'riwayat1' => $riwayat1,
      'riwayat2' => $riwayat2,
      // 'riwayat3' => $riwayat3,
      // 'riwayat4' => $riwayat4,
    ));
  }
}
