<?php
//untuk actionDetailHasilLab
Yii::import('application.modules.laboratorium.models.LBPasienMasukPenunjangV');
//untuk actionDetailHasilRab
Yii::import('application.modules.radiologi.models.ROPasienMasukPenunjangV');
Yii::import('application.modules.rawatDarurat.models.RDPasienPulangT');
class DaftarPasienController extends MyAuthController
{
  public $path_view = 'rawatJalan.views.daftarPasien.';
  public $path_view_rj = 'rawatJalan.views.';
  public $pathView = 'pendaftaranPenjadwalan.views.sinkronisasiSEP.';
  public $pathViewBK = 'billingKasir.views.daftarPasien.';

  public $defaultAction = 'index';
  public $pasientersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $rujukantersimpan = false;
  public $rujukrisukses = false;
  public $successSaveMasukKamar = false;
  public $admisitersimpartopan = false;
  public $masukkamartersimpan = false;
  public $pasienpulangtersimpan = false;
  public $asuransipasientersimpan = false;

  public $ppdsTersimpan = true;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
    $model = new RJInfokunjunganrjV('searchDaftarPasien');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->tgl_awall = date('Y-m-d');
    $model->tgl_akhirl = date('Y-m-d');
    $model->ceklis = false;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    // if (Yii::app()->user->getState('unitkerja_id') == Params::UNITKERJA_ID_DOKTER) {
    //   //$model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    // }

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $model->ceklis = $_REQUEST['RJInfokunjunganrjV']['ceklis'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
      $model->tgl_awall  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awall']);
      $model->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhirl']);
      $model->nama_pasien = $_REQUEST['RJInfokunjunganrjV']['nama_pasien'];
      $model->no_rekam_medik = $_REQUEST['RJInfokunjunganrjV']['no_rekam_medik'];


      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarpasien-v-grid') {
          $this->renderPartial('_tablePasien', array('model' => $model));
          die;
          Yii::app()->end();
        }
      }
    }

    // var_dump(Yii::app()->user->getState('kelompokpegawai_id')); die;
    if (
      Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK
      && Yii::app()->user->getState('loginpemakai_id') != Params::LOGINPEMAKAI_ID_ADMIN
    ) {
      $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('_tablePasien', array('model' => $model));
    } else {
      $this->render('index', array('model' => $model));
    }
  }


  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    //            $modRincian->pendaftaran_id = $id;
    $this->render('rawatJalan.views.rinciantagihanpasienV.rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
  }

  public function actionInfoPasien($id)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    $modRincian = RJInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $id));
    if ($modPendaftaran->alihstatus) {
      $data['judulLaporan'] = 'Pasien Sedang di Rawat Inap';
    } elseif (!empty($modPendaftaran->pembayaranpelayanan_id) && $modPendaftaran->alihstatus == FALSE) {
      $data['judulLaporan'] = 'Pasien Sudah Melakukan Pembayaran';
    } else {
      $data['judulLaporan'] = 'Pasien Sudah Melakukan Pembatalan Pemeriksaan';
    }

    $this->render('infoPasien', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
    // $this->redirect(array('/rawatJalan/anamnesa','pendaftaran_id'=>$id));
  }

  /**
   * actionDetailHasilLab = mnampilkan hasil lab sesuai dengan yang dilab
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   */
  public function actionDetailHasilLab_old($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';

    $cek_penunjang = LBPasienMasukPenunjangV::model()->findAllByAttributes(
      array('pendaftaran_id' => $pendaftaran_id)
    );

    $data_rad = array();
    if (count((array)$cek_penunjang) > 1) {
      $masukpenunjangRad = LBPasienMasukPenunjangV::model()->findByAttributes(
        array(
          'pendaftaran_id' => $pendaftaran_id,
          'ruangan_id' => Params::RUANGAN_ID_RAD
        )
      );

      $modHasilPeriksaRad = HasilpemeriksaanradV::model()->findAllByAttributes(
        array(
          'pasienmasukpenunjang_id' => (isset($masukpenunjangRad->pasienmasukpenunjang_id) ? $masukpenunjangRad->pasienmasukpenunjang_id : null)
        ),
        array(
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

    $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
      array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
    );

    $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

    $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
      array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
      )
    );
    $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';
    $query = "
               SELECT * FROM detailhasilpemeriksaanlab_t 
               JOIN pemeriksaanlab_m ON detailhasilpemeriksaanlab_t.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id 
               JOIN pemeriksaanlabdet_m ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id 
               JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
               JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
			   JOIN kelkumurhasillab_m ON kelkumurhasillab_m.kelkumurhasillab_id = nilairujukan_m.kelkumurhasillab_id
               WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = '" . $modHasilPeriksa->hasilpemeriksaanlab_id . "'
                   AND LOWER(nilairujukan_m.nilairujukan_jeniskelamin) = '" . strtolower(trim($masukpenunjang->jeniskelamin)) . "'
                AND LOWER(kelkumurhasillab_m.kelkumurhasillabnama) = '" . $kelompokUmur . "'
               ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut
           ";
    $detailHasil = Yii::app()->db->createCommand($query)->queryAll();

    $data = array();
    $kelompokDet = null;
    $idx = 0;
    $temp = '';

    foreach ($detailHasil as $i => $detail) {
      $id_jenisPeriksa = $detail['jenispemeriksaanlab_id'];
      $jenisPeriksa = $detail['jenispemeriksaanlab_nama'];
      $kelompokDet = $detail['kelompokdet'];
      if ($id_jenisPeriksa == '72') {
        $query = "
                       SELECT jenispemeriksaanlab_m.* FROM pemeriksaanlabdet_m
                       JOIN pemeriksaanlab_m ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                       JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                       WHERE nilairujukan_id = " . $detail['nilairujukan_id'] . " AND pemeriksaanlab_m.jenispemeriksaanlab_id <> " . $id_jenisPeriksa . "
                   ";
        $rec = Yii::app()->db->createCommand($query)->queryRow();
        $id_jenisPeriksa = $rec['jenispemeriksaanlab_id'];
        $jenisPeriksa = $rec['jenispemeriksaanlab_nama'];
      }

      if ($temp != $kelompokDet) {
        $idx = 0;
      }

      $data[$id_jenisPeriksa]['tittle'] = $jenisPeriksa;
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['id'] = $id_jenisPeriksa;
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['nama'] = $jenisPeriksa;
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['kelompok'] = $kelompokDet;
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail['pemeriksaanlab_nama'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail['namapemeriksaandet'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail['nilairujukan_id'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail['nilairujukan_nama'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail['nilairujukan_metode'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail['hasilpemeriksaan'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail['nilairujukan'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail['hasilpemeriksaan_satuan'];
      $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail['nilairujukan_keterangan'];
      $temp = $kelompokDet;
      $idx++;
    }

    $this->render(
      'rawatInap.views.riwayatPasien.detailHasilLab',
      array(
        'modHasilPeriksa' => $modHasilPeriksa,
        'masukpenunjang' => $masukpenunjang,
        'pemeriksa' => $pemeriksa,
        'data' => $data,
        'data_rad' => $data_rad
      )
    );
  }

  public function actionDetailHasilRehab($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
    $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $detailHasil = HasilpemeriksaanrmT::model()->findAll('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
    $this->render(
      'rawatJalan.views._periksaDataPasien.detailHasilRehab',
      array(
        'masukpenunjang' => $modPasienMasukPenunjang,
        'judulLaporan' => $judulLaporan,
        'detailHasil' => $detailHasil,
      )
    );
  }

  public function actionDetailHasilGizi($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $model = AsesmengiziT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ), array(
      'order' => 'tgl_konsultasi desc',
    ));
    $this->render('rawatJalan.views._periksaDataPasien.detailHasilGizi', array(
      'model' => $model,
    ));
  }

  public function actionDetailHasilLab($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $modKunjungan = RJPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaan = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $criteria = new CDbCriteria();
    $criteria->join = "
							JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
							JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
							JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = RJDetailhasilpemeriksaanlabT::model()->findAll($criteria);

    // $data = array();
    $data2 = array();

    $sys = TrxSysRes::model()->findByAttributes(array(
      'ono' => $modHasilPemeriksaan->hasilpemeriksaanlab_id
    ));
    $sysdata = TrxSysResDt::model()->findAllByAttributes(array(
      'ono' => $modHasilPemeriksaan->hasilpemeriksaanlab_id
    ), array(
      'order' => 'disp_seq asc'
    ));

    if (!empty($sys)) {
      $modHasilPemeriksaan->catatanlabklinik = $sys->comment;
      $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
      $modHasilPemeriksaan->save(false);
    }

    $id_jenis_base = 1;
    $arr_jenis = array();
    $cnt = 1;
    foreach ($sysdata as $dt) {
      if (empty($arr_jenis[$dt->test_group])) {
        $arr_jenis[$dt->test_group] = $id_jenis_base++;
      }

      $id_jenis = $arr_jenis[$dt->test_group];
      $dtperiksa = $dt->order_testid;
      $kelompokdet = $dt->test_nm;
      $nilairujukan_id = $dt->disp_seq;

      if ($dt->data_typ == "ST" && !empty($dt->result_value)) {
        $dt->test_nm .= " : " . $dt->result_value;
      }

      $dt->result_value .= $dt->result_ft;

      $data2["$id_jenis"]["jenispemeriksaanlab_nama"] = $dt->test_group;
      $data2["$id_jenis"]["jenispemeriksaanlab_id"] = $id_jenis;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->order_testnm;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->order_testid;

      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->test_cd;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->disp_seq;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $kelompokdet;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->test_nm;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->result_value;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = "";
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = "";
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->ref_range;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['status'] = $dt->flag;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['tipe'] = $dt->data_typ;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['metode'] = $dt->test_comment;
      $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['satuan'] = $dt->unit;

      // var_dump($dt->attributes);

    }



    $this->render('rawatInap.views.riwayatPasien.detailHasilLab', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan,
      'data' => $data2,
    ));
  }

  /**
   * actionDetailHasilRad = menampilkan hasil radiologi sesuai dengan rad
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   * @param type $caraPrint
   */
  public function actionDetailHasilRad($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '')
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));
    $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

    $this->render('rawatInap.views.riwayatPasien.detailHasilRad', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'caraPrint' => $caraPrint,
    ));
  }


  public function actionHasilPemeriksaanPenunjang($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modRiwayatKonsulSearch = new RJKonsulPoliT('search');

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array('pendaftaran_id' => $id),
      'ruangan_id IN(' . Params::RUANGAN_ID_LAB_KLINIK . ') AND create_ruangan = ' . Yii::app()->user->getState('ruangan_id')
    );

    $api = new MyAPI;
    $custom = new CustomFunction;

    $isSecure = false;



    $url = 'viewerlab.rssa.my.id/api.php?get=1';

    $url = 'https://' . $url;

    $no_rm = $modPasien->no_rekam_medik;
    // $no_rm = '00194420';

    $urlhasil = $custom::absoluteUrl($url, '') . '&nomr=' . $no_rm;
    $hasil = $api->apiRequest($urlhasil);

    // var_dump($urlhasil, $hasil); die;

    if (!empty(trim($hasil))) {
      $hasil = json_decode($hasil, true);
    } else {
      $hasil = null;
    }

    $format = new MyFormatter;
    $this->render(
      '/_periksaDataPasien/_hasilPemeriksaanPenunjang',
      array(
        'modPendaftaran' => $modPendaftaran,
        'no_register' => $no_rm,
        'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
        'hasil' => $hasil
      )
    );
  }

  public function actionDetailKonsul($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modRiwayatKonsulSearch = new RJKonsulPoliT('search');
    $format = new MyFormatter;
    $this->render(
      '/_periksaDataPasien/_detailkonsulpoli',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modRiwayatKonsulSearch' => $modRiwayatKonsulSearch
      )
    );
  }

  public function actionDetailKonsulHasil($id)
  {
    $this->layout = '//layouts/iframe';

    $idKonsulAntarPoli = $id;
    $modKonsulPoli = RJKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
    $modKonsulPoli->uraian_konsul = strip_tags($modKonsulPoli->uraian_konsul);
    $modKonsulPoli->uraian_konsul = html_entity_decode($modKonsulPoli->uraian_konsul);
    $modKonsulPoli->uraian_konsuljawaban = strip_tags($modKonsulPoli->uraian_konsuljawaban);
    $modKonsulPoli->uraian_konsuljawaban = html_entity_decode($modKonsulPoli->uraian_konsuljawaban);


    $modMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modKonsulPoli->pendaftaran_id,
      'ruangan_id' => $modKonsulPoli->ruangan_id,
    ));
    if (!empty($modKonsulPoli->pegawaikonsul_id)) {
      $modKonsulPoli->nama_pegawai = PegawaiM::model()->findByPk($modKonsulPoli->pegawaikonsul_id)->nama_pegawai;
    }

    $this->render($this->path_view . 'konsultasiInternal._viewKonsulPoliHasil', array('modKonsul' => $modKonsulPoli, 'modMorbiditas' => $modMorbiditas, 'no_ok' => 1));
  }


  public function actionDetailTindakanHasil($id)
  {
    $this->layout = '//layouts/iframe';

    $idKonsulAntarPoli = $id;
    $modKonsulPoli = RJRuangTindakan::model()->findByPk($idKonsulAntarPoli);
    $modMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modKonsulPoli->pendaftaran_id,
      'ruangan_id' => $modKonsulPoli->ruangan_id,
    ));
    if (!empty($modKonsulPoli->pegawaiordertindakan_id)) {
      $modKonsulPoli->nama_pegawai = PegawaiM::model()->findByPk($modKonsulPoli->pegawaiordertindakan_id)->nama_pegawai;
    }

    $this->render($this->path_view . 'tindakanInternal._viewTindakanPoliHasil', array('modKonsul' => $modKonsulPoli, 'modMorbiditas' => $modMorbiditas, 'no_ok' => 1));
  }


  public function actionDetailTindakan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    // var_dump($id);exit();

    $modTindakan = RJTindakanPelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modTindakanSearch = new RJTindakanPelayananT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_tindakan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTindakan' => $modTindakan,
        'modTindakanSearch' => $modTindakanSearch,
        'modPasien' => $modPasien
      )
    );
  }

  /**
   * actionDetailPersalinan = menampilkan detail riwayat persalinan pasien
   * RSN-289
   */
  public function actionDetailPersalinan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPasienIbu = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (!empty($modPasienIbu->pasien_ibu_id)) {
      $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->find('pasien_id = ' . $modPasienIbu->pasien_ibu_id . 'and persalinan_id is not null');
    }
    $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modPemeriksaan = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $id, 'create_ruangan' => Params::RUANGAN_ID_VK), array(
      'order' => 'pemeriksaanfisik_id asc',
    ));

    $systolic = null;
    $diastolic = null;
    foreach ($modPemeriksaan as $cari) {
      $systolic = isset($cari->kala4_systolic) ? $cari->kala4_systolic : null;
      $diastolic = isset($cari->kala4_diastolic) ? $cari->kala4_diastolic : null;
    }

    $criteria2 = new CDbCriteria();
    $criteria2->select = 'max(systolic_min) as sys_max';
    $modSys = SysdiaM::model()->find($criteria2);
    $criteria3 = new CDbCriteria();
    $criteria3->select = 'max(diastolic_min) as dias_max';
    $modDia = SysdiaM::model()->find($criteria3);

    $criteria = new CDbCriteria();
    $tekanandarah_text = '';
    if (($systolic == null) && ($diastolic == null)) {
      $tekanandarah_text = null;
    } else {
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

      if (!empty($modSysDia)) {
        $tekanandarah_text = $modSysDia->sysdia_nama;
      }
    }



    $format = new MyFormatter;
    $modPersalinanSearch = new PersalinanT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      'rawatJalan.views._periksaDataPasien._persalinan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPersalinan' => $modPersalinan,
        'modPemeriksaan' => $modPemeriksaan,
        'tekananDarahText' => $tekanandarah_text,
        'modPersalinanSearch' => $modPersalinanSearch,
        'modPasien' => $modPasien
      )
    );
  }

  /*awal detail riwayat pemeriksaan ginekologi        
         */
  public function actionDetailGinekologi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modGinekologi = PemeriksaanginekologiT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $ginekologi_id = PemeriksaanginekologiT::model()->findByAttributes(array('pendaftaran_id' => $id));
    if (!empty($ginekologi_id)) {
      $modRiwayatKelahiran = RiwayatkehamilanT::model()->findAllByAttributes(array('pemeriksaanginekologi_id' => $ginekologi_id->pemeriksaanginekologi_id));
    } else {
      $modRiwayatKelahiran = array();
    }

    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_ginekologi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modGinekologi' => $modGinekologi,
        'modRiwayatKelahiran' => $modRiwayatKelahiran,
        'modPasien' => $modPasien
      )
    );
  }

  /*akhir detail riwayat pemeriksaan ginekologi*/


  /**
   * actionDetailKelahiran = menampilkan detail riwayat kelahiran bayi pasien
   * RSN-289
   */
  public function actionDetailKelahiran($id)
  {
    $this->layout = '//layouts/iframe';
    $modKelahiran = array();
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    $modPasienIbu = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (!empty($modPasienIbu->pasien_ibu_id)) {
      $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->find('pasien_id = ' . $modPasienIbu->pasien_ibu_id . 'and persalinan_id is not null');
    }

    $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    foreach ($modPersalinan as $persalinan) {
      $modKelahiran[$persalinan->persalinan_id] = KelahiranbayiT::model()->findAllByAttributes(array('persalinan_id' => $persalinan->persalinan_id));
    }
    $format = new MyFormatter;
    $modKelahiranSearch = new KelahiranbayiT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      'rawatJalan.views._periksaDataPasien._kelahiran',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPersalinan' => $modPersalinan,
        'modKelahiran' => $modKelahiran,
        'modKelahiranSearch' => $modKelahiranSearch,
        'modPasien' => $modPasien
      )
    );
  }

  /**
   * actionDetailAnamnesa = menampilkan detail hasil pemeriksaan pada tab_Anamnesa untuk riwayat pasien
   * RND-4100 
   */
  public function actionDetailAnamnesa($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modAnamnesa = RJAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modAnamnesaSearch = new RJAnamnesaT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_anamnesa',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modAnamnesa' => $modAnamnesa,
        'modAnamnesaSearch' => $modAnamnesaSearch,
        'modPasien' => $modPasien
      )
    );
  }

  /**
   * actionDetailPeriksaFisik = menampilkan detail hasil pemeriksaan pada tab_Periksa Fisik untuk riwayat pasien
   * RND-4100 
   */
  public function actionDetailPeriksaFisik($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modPemeriksaanFisikSearch = new RJPemeriksaanFisikT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $id));

    $modAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')), array('order' => 'create_time DESC'));

    $this->render(
      '/_periksaDataPasien/_periksafisik',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPemeriksaanFisik' => $modPemeriksaanFisik,
        'modPemeriksaanFisikSearch' => $modPemeriksaanFisikSearch,
        'modPasien' => $modPasien,
        'modPemeriksaanGambar' => $modPemeriksaanGambar,
        'modAnamnesa' => $modAnamnesa
      )
    );
  }
  /**
   * actionDetailPeriksaFisik = menampilkan detail hasil pemeriksaan pada tab_pengkajian Nyeri untuk riwayat pasien
   * RND-4100 
   */
  public function actionDetailPengkajianNyeri($id)
  {
    $this->layout = '//layouts/iframe';

    $daftar = PendaftaranT::model()->findByPk($id);

    $model = null;
    if (!empty($id)) {
      $model = PengkajiannyeriT::model()->findByPk($id);
    }
    if (empty($model)) {
      $model = new PengkajiannyeriT;
      $model->pendaftaran_id = $daftar->pendaftaran_id;
    }

    // var_dump($model);die;    
    $this->render(
      '/_periksaDataPasien/_periksapengkajiannyari',
      array(
        'model' => $model
      )
    );
  }

  public function actionDetailTerapi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    $penjualan = PenjualanresepT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array('order' => 'tglpenjualan DESC'));

    $prereseptur = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array('order' => 'tglreseptur DESC'));

    $reseptur = array();

    foreach ($prereseptur as $item) {
      $item->tglreseptur = MyFormatter::formatDateTimeForDb($item->tglreseptur);
      foreach ($penjualan as $item2) {
        if ($item->reseptur_id == $item2->reseptur_id || $item->penjualanresep_id == $item2->penjualanresep_id) {
          continue;
        }
      }
      array_push($reseptur, $item);
    }



    $checkers = array();

    foreach ($reseptur as $item) {
      $checkers[$item->tglreseptur] = array(
        'tipe' => 1,
        'noresep' => $item->noresep,
        'id' => $item->reseptur_id,
        'keterangan' => '',
        'user_apoteker' => "-",
      );
    }



    foreach ($penjualan as $item) {

      $login = LoginpemakaiK::model()->findByPk($item->create_loginpemakai_id);

      $checkers[$item->tglresep] = array(
        'tipe' => 2,
        'noresep' => $item->noresep,
        'id' => $item->penjualanresep_id,
        'keterangan' => $item->keterangan,
        'user_apoteker' => (empty($login->pegawai) ? $login->nama_pemakai : $login->pegawai->nama_pegawai),
      );
    }

    //echo "<pre>";
    //var_dump($checkers);
    //echo "</pre>";
    //die;

    //ksort($checkers);

    //var_dump(count((array)$checkers));die;

    $this->render(
      '/_periksaDataPasien/_terapi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'checkers' => $checkers
      )
    );

    /*
            //$modTerapi = RJPenjualanresepT::model()->with('reseptur')->findAllByAttributes(array('pendaftaran_id'=>$id));
            //$modTerapi = ResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
            //$modDetailTerapi = new RJResepturDetailT('searchDetailTerapi');
            $modDetailTerapi = new RJObatalkesPasienT;
            $format = new MyFormatter;
            $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_terapi', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTerapi'=>$modTerapi,
                        'modDetailTerapi'=>$modDetailTerapi,
                        'modPasien'=>$modPasien));
             * 
             */
  }

  public function actionDetailPemakaianBahan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modBahan = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modPemakaianBahan = new RJObatalkesPasienT;
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_pemakaianBahan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modBahan' => $modBahan,
        'modPemakaianBahan' => $modPemakaianBahan,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailPemeriksaanLab($id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPasien = PasienM::model()->findByPk($id);
    $modHasilPemeriksaan = new HasilpemeriksaanlabT();


    //            $criteria = new CDbCriteria();
    //            $criteria->addCondition(' t.pasien_id = '.$id);
    //            $criteria->select = 't.pasien_id, p.pemeriksaanlab_id, p.pemeriksaanlab_nama';
    //            $criteria->group = $criteria->select;
    //            $criteria->join = " JOIN detailhasilpemeriksaanlab_t AS d ON t.hasilpemeriksaanlab_id = d.hasilpemeriksaanlab_id "
    //                    . " JOIN pemeriksaanlab_m AS p ON d.pemeriksaanlab_id = p.pemeriksaanlab_id";
    //            $hasilPemeriksanLab = HasilpemeriksaanlabT::model()->findAll($criteria);
    //            
    //            $criteria2 = new CDbCriteria();
    //            $criteria2->select = 'DATE(tglhasilpemeriksaanlab) AS tglhasilpemeriksaanlab';
    //            $criteria2->group = 'DATE(tglhasilpemeriksaanlab)';
    //            $criteria2->addCondition('pasien_id='.$id);
    //            $tglPeriksa = HasilpemeriksaanlabT::model()->findAll($criteria2);


    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $this->render(
      '/_periksaDataPasien/_pemeriksaanLab',
      array(
        'modPasien' => $modPasien,
        'format' => $format,
        'modHasilPemeriksaan' => $modHasilPemeriksaan,
        'judulLaporan' => $judulLaporan,
        'pasien_id' => $id,
      )
    );
  }

  public function actionGetRiwayatPasienLama($id)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria(array(
      'condition' => 't.pasien_id = ' . $id,
      //.'
      //      and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(RJPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);

    $modKunjungan = RJPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'ppds', 'diagnosa')->findAll($criteria);
    // $modPpds =PasienPpdsT::model()->findByAttributes(array('pendaftaran_id'=> $id));

    $this->render('/_periksaDataPasien/_riwayatPasienLama', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
      //'modPpds' => $modPpds,

    ));
  }


  public function actionGetRiwayatPasienLama2($id)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria(array(
      'condition' => 't.pasien_id = ' . $id,
      //.'
      //      and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(RJPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);

    $modKunjungan = RJPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'ppds', 'diagnosa')->findAll($criteria);
    // $modPpds =PasienPpdsT::model()->findByAttributes(array('pendaftaran_id'=> $id));

    $this->render('/_periksaDataPasien/_riwayatPasienLama2', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
      //'modPpds' => $modPpds,

    ));
  }

  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria(array(
      'condition' => 't.pasien_id = ' . $id,
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(RJPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);
    $modKunjungan = RJPendaftaranT::model()->with('carabayar', 'instalasi', 'penjamin', 'ruangan', 'jeniskasuspenyakit', 'kelaspelayanan')->findAll($criteria);

    $this->render('/_periksaDataPasien/_riwayatPasien', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
    ));
  }

  public function actionGetSosialPasien($id)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);

    $modPasien = RJPasienM::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id));
    $modPenanggung = PenanggungjawabM::model()->findByAttributes(array('penanggungjawab_id' => $modPendaftaran->penanggungjawab_id));
    $modPegawai = RJPegawaiM::model()->findByAttributes(array('pegawai_id' => $modPendaftaran->pegawai_id));
    $modRuangan = RJRuanganM::model()->findByAttributes(array('ruangan_id' => $modPendaftaran->ruangan_id));


    $this->render('/pemeriksaanPasien/_dataSosialPasien', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modPenanggung' => $modPenanggung,
      'modRuangan' => $modRuangan

    ));
  }



  public function actionGetPengantarPasien($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PendaftaranT::model()->findByPk($pendaftaran_id);
    // $criteria =  new CDbCriteria();
    // $criteria->addCondition('pendaftaran_id ='.$pendaftaran_id);
    // $criteria->join = 'penanggungjawab_m on t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id';

    // $model = PendaftaranT::model()->find($criteria);
    $modPenanggungJawab = PenanggungjawabM::model()->findByPk($model->penanggungjawab_id);

    $this->render('/_periksaDataPasien/_penanggungJawab', array(
      // 'pages' => $pages,
      // 'modKunjungan' => $modKunjungan,
      'modPenanggungJawab' => $modPenanggungJawab
    ));
  }

  public function actionPrint($id = null)
  {
    //$this->layout='//layouts/iframe';

    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modHasilLab = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modDetailHasilLab = RJDetailhasilpemeriksaanlabT::model()->with('pemeriksaanlab')->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilLab->hasilpemeriksaanlab_id));
    $modDetailHasil = new RJDetailhasilpemeriksaanlabT();
    $format = new MyFormatter;
    $modHasilLab->tglhasilpemeriksaanlab = $format->formatDateTimeId($modHasilLab->tglhasilpemeriksaanlab);

    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);

    $judulLaporan = 'Data Hasil Pemeriksaan Lab';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }
  }

  public function actionPrint2($id = null)
  {
    //$this->layout='//layouts/iframe';

    //  $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;


    $judulLaporan = 'Data Rincian';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('rawatJalan.views._periksaDataPasien/detailRincian', array(
        'modPendaftaran' => $modPendaftaran,
        'modRincian' => $modRincian,

        // 'modPasien'=>$modPasien, 
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('rawatJalan.views._periksaDataPasien/detailRincian', array(
        'modPendaftaran' => $modPendaftaran,
        'modRincian' => $modRincian,
        //  'modPasien'=>$modPasien,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('rawatJalan.views._periksaDataPasien/detailRincian', array(
        'modPendaftaran' => $modPendaftaran,  'modRincian' => $modRincian,

        // 'modPasien'=>$modPasien,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }
  }

  public function actionGetRiwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = $_GET['pasien_id'];
      $page = $_GET['page'];
      if (empty($page)) {
        $page = 1;
      }
      //$modPendaftaran=RJPendaftaranT::model()->findByPk($pendaftaran_id);

      $modPasien = RJPasienM::model()->findByPk($pasien_id);
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('/_periksaDataPasien/_riwayatPasien', array('modPasien' => $modPasien, 'page' => $page), true)
      ));
      exit;
    }
  }

  public function actionGetRiwayatAllPemeriksaan($id)
  {

    Yii::import("rawatJalan.models.*");
    Yii::import("rekamMedis.models.*");

    $this->layout = '//layouts/iframe';
    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                 //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->useOddEven = 2;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNewRiwayatAll', array('judulLaporan' => "", 'periode' => "", 'is_pdf' => true), true));
    $mpdf->setHTMLFooter('<span></span>');

    // anamnesa

    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modAnamnesa = RJAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modAnamnesaSearch = new RJAnamnesaT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);

    $path_rj = "rawatJalan.views.";

    $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 35, 5);
    $mpdf->WriteHTML(

      $this->renderPartial(
        $this->pathViewBK . 'riwayat/_anamnesa',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modAnamnesa' => $modAnamnesa,
          'modAnamnesaSearch' => $modAnamnesaSearch,
          'modPasien' => $modPasien
        ),
        true
      )


    );





    // periksa Fisik
    $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $id), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modPemeriksaanFisikSearch = new RJPemeriksaanFisikT('search');
    $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
    if (!empty($modPemeriksaanFisik)) {
      $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    } else {
      $modPemeriksaanGambar = array();
      $modPemeriksaanFisik = new RJPemeriksaanFisikT;
    }
    // $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 5, 5);
    $mpdf->WriteHTML(

      $this->renderPartial(
        $this->pathViewBK . 'riwayat/_periksafisik',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modPemeriksaanFisik' => $modPemeriksaanFisik,
          'modPemeriksaanFisikSearch' => $modPemeriksaanFisikSearch,
          'modPasien' => $modPasien,
          'modPemeriksaanGambar' => $modPemeriksaanGambar
        ),
        true
      )

    );

    $morbid = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'kelompokdiagnosa_id' => 2
    )) ?? new PasienmorbiditasT;

    $morbidTambahan = PasienmorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'kelompokdiagnosa_id' => 3
    ));

    // var_dump(!empty($morbid), count($morbidTambahan)); die;

    $mpdf->WriteHTML(

      $this->renderPartial(
        $this->pathViewBK . 'riwayat/_diagnosa',
        array(
          'modPendaftaran' => $modPendaftaran,
          'morbid' => $morbid,
          'morbidTambahan' => $morbidTambahan,
        ),
        true
      )

    );



    // detail periksa penunjang
    $modMasukPenunjang = PasienmasukpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $jumlah = count((array)$modMasukPenunjang);




    foreach ($modMasukPenunjang as $row) {
      $nama = "";
      $login = LoginpemakaiK::model()->findByPk($row->create_loginpemakai_id);
      if (!empty($login->pegawai)) {
        $nama = $login->pegawai->namaLengkap;
      } else {
        $nama = $login->nama_pemakai;
      }
      $ada = true;
      $subresult = '<li>';

      $nama = trim($nama);

      $modHasilLab = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));
      $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));
      $modHasilRehab = HasilpemeriksaanrmT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));
      $modAsesmenGizi = AsesmengiziT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id), array(
        'order' => 'asesmengizi_id desc'
      ));

      if ($modHasilLab) { //cek jika sudah ada hasil lab

        $modKunjungan = $row; //PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modHasilPemeriksaan = $modHasilLab; //HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaansLab($modHasilPemeriksaan);
        // $data = array();

        $data2 = array();

        $sys = TrxSysRes::model()->findByAttributes(array(
          'ono' => $modHasilPemeriksaan->hasilpemeriksaanlab_id
        ));
        $sysdata = TrxSysResDt::model()->findAllByAttributes(array(
          'ono' => $modHasilPemeriksaan->hasilpemeriksaanlab_id
        ), array(
          'order' => 'disp_seq asc'
        ));

        if (!empty($sys)) {
          $modHasilPemeriksaan->catatanlabklinik = $sys->comment;
          $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
          $modHasilPemeriksaan->save(false);
        }

        $id_jenis_base = 1;
        $arr_jenis = array();
        $cnt = 1;

        //vaR_dump(count($sysdata)); die;

        foreach ($sysdata as $dt) {
          if (empty($arr_jenis[$dt->test_group])) {
            $arr_jenis[$dt->test_group] = $id_jenis_base++;
          }

          $id_jenis = $arr_jenis[$dt->test_group];
          $dtperiksa = $dt->order_testid;
          $kelompokdet = $dt->test_nm;
          $nilairujukan_id = $dt->disp_seq;

          if ($dt->data_typ == "ST" && !empty($dt->result_value)) {
            $dt->test_nm .= " : " . $dt->result_value;
          }

          $dt->result_value .= $dt->result_ft;

          $data2["$id_jenis"]["jenispemeriksaanlab_nama"] = $dt->test_group;
          $data2["$id_jenis"]["jenispemeriksaanlab_id"] = $id_jenis;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->order_testnm;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->order_testid;

          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->test_cd;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->disp_seq;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $kelompokdet;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->test_nm;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->result_value;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = "";
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = "";
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->ref_range;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['status'] = $dt->flag;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['tipe'] = $dt->data_typ;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['metode'] = $dt->test_comment;
          $data2["$id_jenis"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['satuan'] = $dt->unit;

          // var_dump($dt->attributes);
        }

        // var_dump($data2); die;

        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 35, 5);
        $mpdf->WriteHTML(
          $this->renderPartial($this->pathViewBK . 'riwayat/detailHasilLab', array(
            'format' => $format,
            'modKunjungan' => $modKunjungan,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
            'judulLaporan' => "",
            'data' => $data2,
          ), true)
        );
      } else if ($modHasilRad) { //jika radiologi

        $modPasienMasukPenunjang = $row;
        $modKunjungan = $row;
        $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));
        $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));

        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 35, 5);
        $mpdf->WriteHTML(
          $this->renderPartial($this->pathViewBK . 'riwayat/detailHasilRad', array(
            'detailHasil' => $detailHasil,
            'masukpenunjang' => $modPasienMasukPenunjang,
            'modKunjungan' => $modKunjungan,
            'pemeriksa' => $pemeriksa,
            'caraPrint' => null,
          ), true)
        );
      } else if ($modHasilRehab) {
      } else if ($modAsesmenGizi) {
        //if (!empty($modAsesmenGizi->ahligizi_id)) {
        //    $peg = PegawaiM::model()->findByPk($modAsesmenGizi->ahligizi_id);
        //    $nama = $peg->namaLengkap;
        //} 

        //$subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$row->ruangan_nama.'<br>('.$nama.')',Yii::app()->controller->createUrl("daftarPasien/detailHasilGizi",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Koonsultasi '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."<br>";
      } else {
      }
    }

    // resume
    $modResume = RKResumemedisR::model()->findByAttributes(array('pendaftaran_id' => $id), array('order' => 'resumemedis_id DESC'));

    if (!empty($modResume)) {
      $modKunjungan = RKInfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $modResume->pendaftaran_id));
      $modDiagnosaAwal = RKDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modResume->diagnosaawal_id));


      $dataDiagnosa['diagnosautama'] = '';
      //load diagnosa akhir
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $modResume->pendaftaran_id);
      $criteria->addInCondition(
        'kelompokdiagnosa_id',
        array(
          Params::KELOMPOKDIAGNOSA_UTAMA,
          Params::KELOMPOKDIAGNOSA_TAMBAH
        )
      );
      $modPasienMorbiditass = RKPasienMorbiditasT::model()->findAll($criteria);
      foreach ($modPasienMorbiditass as $key => $modPasienMorbiditas) {
        if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA) {
          $dataDiagnosa['diagnosautama'] .= "Diagnosa utama : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
        }
        if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH) {
          if ($key == 0) {
            $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
          } elseif ($key == 1) {
            $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
          } elseif ($key == 2) {
            $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
          }
        }
      }

      $judul_print = 'RESUME ( Ringkasan Pasien Keluar )';


      $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 35, 5);
      $mpdf->WriteHTML(
        $this->renderPartial(
          $this->pathViewBK . 'riwayat/_detailResume',
          array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modKunjungan' => $modKunjungan,
            'modResume' => $modResume,
            'modDiagnosaAwal' => $modDiagnosaAwal,
            'dataDiagnosa' => $dataDiagnosa,
          ),
          true
        )
      );
    }


    $mpdf->Output();
  }


  //         public function actionBatalRawatInap()
  //        {
  //             if(Yii::app()->request->isAjaxRequest) {
  //                $idOtoritas = $_POST['idOtoritas'];
  //                $namaOtoritas = $_POST['namaOtoritas'];
  //                $idPasienPulang=$_POST['idPasienPulang'];
  //                $alasanPembatalan=$_POST['Alasan'];
  //                $pendaftaran_id = $_POST['pendaftaran_id'];
  //                
  //                
  //                $modPasienBatalPulang = new PasienbatalpulangT;    
  //                $modPasienBatalPulang->namauser_otorisasi=$namaOtoritas;
  //                $modPasienBatalPulang->iduser_otorisasi=$idOtoritas;
  //                $modPasienBatalPulang->pasienpulang_id=$idPasienPulang;
  //                $modPasienBatalPulang->tglpembatalan=date('Y-m-d H:i:s');
  //                $modPasienBatalPulang->alasanpembatalan=$alasanPembatalan;
  //                 $transaction = Yii::app()->db->beginTransaction();
  //                 try{
  //                    if($modPasienBatalPulang->save()){
  //                        $pulang =  PasienpulangT::model()->updateByPk($idPasienPulang,array('pasienbatalpulang_id'=>$modPasienBatalPulang->pasienbatalpulang_id));
  //                        $pendaftaran =  PendaftaranT::model()->updateByPk($pendaftaran_id,array('pasienpulang_id'=>null,'pasienadmisi_id'=>null));   
  //                        if ($pulang && $pendaftaran){
  //                            $data['status'] = 'success';
  //                            $transaction->commit();
  ////                          
  //                        }
  //                        else{
  //                            throw new Exception("Update Data Gagal");
  //                        }
  //                    }
  //                    else{
  //                        Throw new Exception("Pasien Batal Rawat Inap Gagal Disimpan");
  //                    }
  //                 }catch(Exception $ex){
  //                     $transaction->rollback();
  //                     $data['status'] = $ex;
  //                 }
  //
  //                echo json_encode($data);
  //                Yii::app()->end();
  //                }
  //        }


  public function actionBatalRawatInap($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modPasienBatalPulang = new PasienbatalpulangT;
    $tersimpan = 'tidak';

    if (!empty($_POST['PasienbatalpulangT'])) {
      $pasienPulangId = $_POST['pasienpulang_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $format = new MyFormatter();
      $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
      $modPasienBatalPulang->create_time = date('Y-m-d H:i:s');
      $modPasienBatalPulang->update_time = date('Y-m-d H:i:s');
      $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);
      $modPasienBatalPulang->namauser_otorisasi = Yii::app()->user->name;
      $modPasienBatalPulang->iduser_otorisasi = Yii::app()->user->id;
      $modPasienBatalPulang->create_loginpemakai_id = Yii::app()->user->id;
      $modPasienBatalPulang->update_loginpemakai_id = Yii::app()->user->id;
      $modPasienBatalPulang->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $modPasienBatalPulang->pasienpulang_id = $pasienPulangId;
      if ($modPasienBatalPulang->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modPasienBatalPulang->save()) {
            $pulang =  PasienpulangT::model()->updateByPk($pasienPulangId, array('pasienbatalpulang_id' => $modPasienBatalPulang->pasienbatalpulang_id));
            $pendaftaran =  PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => null, 'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
            if ($pulang && $pendaftaran) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';
              //                          
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpanx");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render('formBatalRawatInap', array('modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modPasienBatalPulang' => $modPasienBatalPulang, 'tersimpan' => $tersimpan));
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
  public function actionUbahStatusPeriksaRJ($id)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $model = PendaftaranT::model()->findByPk($id);
    $model->tglselesaiperiksa = date('Y-m-d H:i:s');
    if (isset($_POST['PendaftaranT'])) {
      $update = PendaftaranT::model()->updateByPk($id, array('statusperiksa' => $_POST['PendaftaranT']['statusperiksa'], 'tglselesaiperiksa' => $format->formatDateTimeForDb($_POST['PendaftaranT']['tglselesaiperiksa'])));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->refresh();
        //                        echo CHtml::script("window.parent.$('#dialogUbahStatus').dialog('close');window.parent.$('#dialogUbahStatus').attr('src',,'');window.parent.$.fn.yiiGridView.update('{$_GET['id']}');");
        //                        $this->redirect(array('index',array('id'=>$id)));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $this->render('_ubahStatusPeriksa', array(
      'model' => $model,
    ));
  }

  // -- Detail Hasil Diagnosa -- //

  public function actionDetailHasilDiagnosa($id)
  {

    $this->layout = '//layouts/iframe';

    $modPasienMasukPenunjang = RJPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $detailHasil = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $id));

    $this->render('/_periksaDataPasien/detailHasilDiagnosa', array(
      'detailHasil' => $detailHasil,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }
  // -- End Detail Hasil Diagnosa -- //

  // -- Detail Hasil Anamnesa -- //

  public function actionDetailHasilAnamnesa($id)
  {

    $this->layout = '//layouts/iframe';

    $modPasienMasukPenunjang = RJPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $detailHasil = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $id));

    $this->render('/_periksaDataPasien/detailHasilAnamnesa', array(
      'detailHasil' => $detailHasil,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }
  // -- End Detail Hasil Anamnesas -- //

  // -- Detail Hasil Anamnesa -- //

  public function actionDetailHasilOperasi($id)
  {

    $this->layout = '//layouts/iframe';

    $modPasienMasukPenunjang = RJPasienMasukPenunjangT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $detailHasil = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $id));

    $this->render('/_periksaDataPasien/detailHasilAnamnesa', array(
      'detailHasil' => $detailHasil,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }
  // -- End Detail Hasil Anamnesas -- //

  public function actionRencanaKontrolPasienRJ($pendaftaran_id, $noSEP = null)
  {

    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $model = new PendaftaranT;
    $modSurat = new SuratketeranganR;
    $modSurat->tglsurat =  $format->formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->tglrenkontrol = $format->formatDateTimeForUser(date('Y-m-d H:i:s', strtotime('+30 days')));
    $modSurat->nomorsurat = MyGenerator::noSuratKontrol(2, Yii::app()->user->getState('ruangan_id'));
    $tersimpan = 'Tidak';

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modMorbidas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'kelompokdiagnosa_id asc'));
    $modSurats = SuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modDiagnosa = empty($modMorbidas) ? new DiagnosaM : DiagnosaM::model()->findByPk($modMorbidas->diagnosa_id);
    $modObatAlkes = ObatalkespasienT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

    if ($modDiagnosa->isNewRecord) {
      if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('isbridging') == true && !empty($noSEP)) {
        $bpjs = new BpjsVklaim;
        $resDiag = CJSON::decode($bpjs->search_sep($noSEP));
        if (!empty($resDiag['response']['diagnosa'])) {
          $modSurat->diagnosa_kontrol = $resDiag['response']['diagnosa'];
        }
      }
    } else {
      $modSurat->diagnosa_kontrol = $modDiagnosa->diagnosa_nama;
    }


    if (isset($modObatAlkes) && !empty($modObatAlkes)) {
      $modAlkes = ObatalkesM::model()->findByPk($modObatAlkes->obatalkes_id);
    } else {
      $modAlkes = new ObatalkesM;
    }
    if (isset($pendaftaran_id)) {
      $cekSurat = SuratketeranganR::model()->findByAttributes(array(
        'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
        'jenissurat_id' => 2
      ), array(
        'order' => 'suratketerangan_id desc',
      ));
      $model = $modPendaftaran;
      if (!empty($cekSurat)) {
        $modSurat = $cekSurat;
        $modSurat->tglsurat = MyFormatter::formatDateTimeForUser($modSurat->tglsurat);
        // $model->tglrenkontrol = $modSurat->tglkontrol;

        // var_dump($model->attributes); die;
      }
    }

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
    $smspasien = 1;

    $vclaim_msg = "";
    $modKonsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
    $modPendaftaran->ruangan_id = empty($modKonsulPoli) ? $modPendaftaran->ruangan_id : $modKonsulPoli->ruangan_id;

    if (isset($_POST['PendaftaranT'])) {
      $renKontrol = $format->formatDateTimeForDb($_POST['PendaftaranT']['tglrenkontrol']);
      $pasien_id = $_POST['PendaftaranT']['pendaftaran_id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modSurat->attributes = $_POST['SuratketeranganR'];
        $modSurat->tglsurat = MyFormatter::formatDateTimeForDB($_POST['SuratketeranganR']['tglsurat']);
        $modSurat->jenissurat_id = 2;
        $modSurat->kontrolri_terapipulang = $_POST['SuratketeranganR']['kontrolri_terapipulang'];
        $modSurat->konrol_rencanatindaklanjut = $_POST['SuratketeranganR']['konrol_rencanatindaklanjut'];
        $modSurat->kontrol_alasan = $_POST['SuratketeranganR']['kontrol_alasan'];
        $judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => 2));
        $modSurat->judulsurat = $judul->jenissurat_nama;
        $modSurat->nourutsurat = 1;
        $modSurat->pendaftaran_id = $_POST['PendaftaranT']['pendaftaran_id'];

        $Pasien = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modSurat->pendaftaran_id));
        $modSurat->pasien_id = $Pasien->pasien_id;
        $modSurat->ruangan_id = Yii::app()->user->getState('ruangan_id');
        // $modSurat->jmlprint_surat = 1;
        // $modSurat->mengetahui_surat = $_POST['RKSuratketeranganR']['mengetahui_surat'];
        $modSurat->profilrs_id = Params::getDefaultProfilRS();
        $modSurat->nomorsurat = $_POST['SuratketeranganR']['nomorsurat'];
        // $modSurat->judulsurat = "SURAT KETERANGAN ISTIRAHAT";
        // $modSurat->lamaistirahat = $_POST['RKSuratketeranganR']['lamaistirahat'];
        // $modSurat->tglistirahat = $format->formatDateTimeForDb($_POST['RKSuratketeranganR']['tglistirahat']);
        // $modSurat->istirahat_tgl_sd = $format->formatDateTimeForDb($model->istirahat_tgl_sd);

        $modSurat->create_time = date('Y-m-d');
        $modSurat->update_time = date('Y-m-d');
        $modSurat->create_loginpemakai_id = Yii::app()->user->id;
        $modSurat->update_loginpemakai_id = Yii::app()->user->id;
        $modSurat->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modSurat->tglkontrol = MyFormatter::formatDateTimeForDB($_POST['PendaftaranT']['tglrenkontrol']);
        $modSurat->tglkontrol = date('Y-m-d', strtotime($modSurat->tglkontrol));
        // var_dump($modSurat->attributes); die;

        if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('isbridging') == true) {
          // var_dump($_POST);

          $kode_dokter = "";
          if (isset($_POST['PendaftaranT']['doktertujuankontrol_id'])) {
            $dok = PegawaiM::model()->findByPk($_POST['PendaftaranT']['doktertujuankontrol_id']);
            if (!empty($dok)) {
              $kode_dokter = $dok->kodedokter_bpjs;
            }
          }
          $poli = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
          $kontrol_poli = $poli->kode_bpjs;

          if ($kontrol_poli == "HDL") {
            $kontrol_poli = "INT";
          }

          $kontrol_tgl_rencana = date('Y-m-d', strtotime($renKontrol));
          $user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
          $kontrol_user_res = empty($user) ? "" : trim($user->nama_pegawai);
          $kontrol_no_sep = isset($_POST['SepT']['nosep']) ? $_POST['SepT']['nosep'] : null;

          $bpjs = new Bpjs_Vklaim;


          if (!empty($kontrol_no_sep)) {
            $res_sep = CJSON::decode($bpjs->search_sep($kontrol_no_sep));
            if (!empty($res_sep['response'])) {
              $modSurat->tglsep = $res_sep['response']['tglSep'];
            }
          }

          if (!empty($_POST['PendaftaranT']['doktertujuankontrol_id'])) {
            $modSurat->doktertujuankontrol_id = $_POST['PendaftaranT']['doktertujuankontrol_id'];
            $peg = PegawaiM::model()->findByPk($modSurat->doktertujuankontrol_id);
            $modSurat->namadokterkontrol = $peg->namaLengkap;
            $modSurat->kodedokterkontrol = $peg->kodedokter_bpjs;
            $modSurat->spesialissubspesialis_id = $peg->spesialissubspesialis_id;
            // var_dump($peg->attributes); die;
          }

          $modSurat->nosep = $kontrol_no_sep;
          $modSurat->polikontrol = $kontrol_poli;
          $modSurat->ruanganpolitujuan_id = $poli->ruangan_id;


          // var_dump($modSurat->attributes); die;

          $modSep = SepT::model()->findByAttributes(array('nosep' => $noSEP));
          if (!empty($modSep)) {
            $kode_dokter = !empty($modSep->kode_dpjp) ? $modSep->kode_dpjp : $modSep->dpjpygmelayani_kode;
            $modPegawai = PegawaiM::model()->findByAttributes(array('kodedokter_bpjs' => $kode_dokter));
            $jadwalDokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $modPegawai->pegawai_id));
            // $data_sep = CJSON::decode($bpjs->search_rujukan_no_rujukan($modSep->norujukan));
            // $poli_sep = $data_sep['response']['rujukan']['poliRujukan']['kode'];
            if (empty($modSep->politujuan) || $modSep->politujuan == '') {
              $modSep->politujuan = $jadwalDokter->ruangan->kode_bpjs;
            }
            $kontrol_poli = $modSep->politujuan;
          }
          if (!empty($modSurat->nomorsurat_bpjs)) {
            $res_kontrol = $bpjs->update_rencana_kontrol($modSurat->nomorsurat_bpjs, $kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
          } else {
            $res_kontrol = $bpjs->create_rencana_kontrol($kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
          }

          $vclaim_msg = "";

          if (!$res_kontrol) {
            $vclaim_msg = "Note : Ada kesalahan ketika membuat rencana kontrol";
          }
          $res_json = CJSON::decode($res_kontrol);

          if ($res_json['metaData']['code'] != 200) {
            $vclaim_msg = "Note : " . $res_json['metaData']['message'];
            $modSurat->respon_bpjs = CJSON::encode($res_json);
            if (!empty($modSurat->nomorsurat_bpjs)) {
              $this->logBpjs($Pasien, $res_json, $bpjs->server_new['update_rencana_kontrol']);
            } else {
              $this->logBpjs($Pasien, $res_json, $bpjs->server_new['create_rencana_kontrol']);
            }
          } else {
            if (!empty($modSurat->nomorsurat_bpjs)) {
              $this->logBpjs($Pasien, $res_json, $bpjs->server_new['update_rencana_kontrol']);
            } else {
              $this->logBpjs($Pasien, $res_json, $bpjs->server_new['create_rencana_kontrol']);
            }
            $modSurat->nomorsurat_bpjs = $res_json['response']['noSuratKontrol'];
            if (empty($modSurat->respon_bpjs)) {
              $modSurat->respon_bpjs = CJSON::encode($res_json['response']);
            }
          }

          // var_dump($res_json);
          // die;
          // var_dump($kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res, $kontrol_no_sep);
        }



        $modSurat->save();
        $modSurat->tglsurat = MyFormatter::formatDateTimeForUser($modSurat->tglsurat);

        // $this->simpanSepBPJS($modPendaftaran);

        $update = PendaftaranT::model()->updateByPk($pasien_id, array(
          'tglrenkontrol' => $renKontrol,
          'ruangankontrol_id' => $Pasien->ruangan_id,
          'doktertujuankontrol_id' => isset($_POST['PendaftaranT']['doktertujuankontrol_id']) ? $_POST['PendaftaranT']['doktertujuankontrol_id'] : null,
        ));
        $model->tglrenkontrol = $renKontrol;
        $model->ruangankontrol_id = $Pasien->ruangan_id;
        $model->doktertujuankontrol_id = isset($_POST['PendaftaranT']['doktertujuankontrol_id']) ? $_POST['PendaftaranT']['doktertujuankontrol_id'] : null;

        if ($update) {
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $modRuangan = $modPendaftaran->ruangan;
          $modInstalasi = $modPendaftaran->instalasi;

          $konsys = KonfigsystemK::model()->find();

          if ($konsys->issmsgateway) {
            $sms = new Sms();
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
              $attributes = $modPegawai->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modInstalasi->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPendaftaran->tglrenkontrol), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
            // END SMS GATEWAY
          }

          /** AWAL - Notifikasi Rencana Kontrol */
          $judul = 'Pasien Rencana Kontrol';
          $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . '<br/> telah membuat rencana kontrol untuk tanggal ' . MyFormatter::formatDateTimeForUser($renKontrol);

          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => Params::INSTALASI_ID_RJ, 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Params::MODUL_ID_RJ),
            array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
          ));
          if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
            $this->kirimWhatsApp($model, $modPasien);
          }

          /** AKHIR - Notifikasi Rencana Kontrol */
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan " . $vclaim_msg);
          $tersimpan = 'Ya';
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . $vclaim_msg);
          if (!empty($modSurat->nomorsurat_bpjs)) {
            $this->logBpjs($Pasien, $res_json, $bpjs->server_new['update_rencana_kontrol']);
          } else {
            $this->logBpjs($Pasien, $res_json, $bpjs->server_new['create_rencana_kontrol']);
          }
        }

        //                        RND-6398
        //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
        //                        $params['create_time'] = date( 'Y-m-d H:i:s');
        //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
        //                        $params['instalasi_id'] = Yii::app()->user->getState('instalasi_id');
        //                        $params['modul_id'] = Yii::app()->session['modul_id'];
        //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien;
        //                        $params['create_ruangan'] = $modPendaftaran->ruangan_id;
        //                        $params['judulnotifikasi'] = ($modPendaftaran->tglrenkontrol != null ? 'Rencana Kontrol Pasien' : 'Rencana Kontrol Pasien' );
        //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
      } catch (Exception $exc) {
        $transaction->rollback();
        var_dump($exc->getMessage());
        die;
        Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
      }
    }

    if (empty($model->tglrenkontrol)) {
      $model->tglrenkontrol = $format->formatDateTimeForUser(date('Y-m-d H:i:s', strtotime('+30 days')));
    }
    $model->tglrenkontrol = MyFormatter::formatDateTimeForUser($model->tglrenkontrol);


    $this->render('rawatJalan.views.daftarPasien.formRencanaKontrol', array(
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'model' => $model,
      'tersimpan' => $tersimpan,
      'modSurat' => $modSurat,
      'modSurats' => $modSurats,
      'modDiagnosa' => $modDiagnosa,
      'modAlkes' => $modAlkes,
      'smspasien' => $smspasien,
      'noSEP' => $noSEP,
    ));
  }

  //save log bpjs
  function logBpjs($model, $reqSep, $api = null)
  {
    $log = new BpjslogR;
    $log->tgl_log = date('Y-m-d H:i:s');
    $log->code = $reqSep['metaData']['code'];
    $log->loginpemakai_id = Yii::app()->user->id;
    if (isset($reqSep['metaData']['message'])) {
      $log->pesan = $reqSep['metaData']['message'];
    }
    if (!empty($reqSep['request_vars'])) {
      $log->json_request_respose = $reqSep['request_vars'];
    }
    $log->pendaftaran_id = $model->pendaftaran_id;
    $request = Yii::app()->request;
    $ipAddress = $request->getUserHostAddress();
    $log->ip_address = $ipAddress;
    $log->api = $api;
    $log->save();
  }

  public function kirimWhatsApp($model, $modPasien)
  {
    $str = "
  
Selamat Datang di ((nama_rs))

((nama_pasien))  terdaftar sebagai pasien pada tanggal ((tgl_pendaftaran)) dan akan melakukan pemeriksaan di ((ruangan_nama)) dengan No. Antrian ((no_antrian))
        
Harap cermati dan patuhi apa yang sudah disetujui dan ditandatangani di persetujuan umum. 
Jika memerlukan bantuan bisa kontak ke bagian Informasi Rumah Sakit. 

        
Terimakasih
((nama_rs)) - ((lokasi))       
";

    $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);
    $str = str_replace("((nama_pasien))", $modPasien->namadepan . $modPasien->nama_pasien, $str);
    $str = str_replace("((tgl_pendaftaran))", MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran), $str);
    $str = str_replace("((ruangan_nama))", $model->ruangan->ruangan_nama, $str);
    $str = str_replace("((no_antrian))", $model->no_urutantri, $str);
    $str = str_replace("((lokasi))", Yii::app()->user->getState('kabupaten_nama'), $str);


    // var_dump($str); die;

    $wa = new WhatsApp();
    $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
    //            $res = $wa->kirimIndividu("085606615990", $str);

    //            var_dump($res, $str, $model->attributes, $modPasienAdmisi->attributes, $modPasien->attributes);
    //            die;
  }

  public function actionPasienRujukRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
      $modInstalasi = InstalasiM::model()->findByPk($modRuangan->instalasi_id);
      $pasien_id = $modPendaftaran->pasien_id;
      $modPasien = PasienM::model()->findByPk($pasien_id);
      $modPasienPulang = new PasienpulangT;
      $modPasienPulang->pendaftaran_id = $pendaftaran_id;
      $modPasienPulang->pasien_id = $pasien_id;
      $modPasienPulang->tglpasienpulang = date('Y-m-d H:i:s');
      $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
      $modPasienPulang->kondisikeluar_id = Params::KONDISIKELUAR_ID_RAWATINAP;
      $modPasienPulang->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
      $modPasienPulang->lamarawat = 0;
      $modPasienPulang->satuanlamarawat = 'lamarawat';

      $judul = 'Pasien Rujuk ke Rawat Inap';

      $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien
        . ' - ' . $modInstalasi->instalasi_nama . ' - ' . $modRuangan->ruangan_nama;



      $ok = CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
      ));

      if ($modPasienPulang->save()) {
        PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => $modPasienPulang->pasienpulang_id, 'statusperiksa' => Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO));
        $data['pesan'] = 'Berhasil';
      } else {
        $data['pesan'] = 'Gagal';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAlergiObat()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $datatable = '';
    $pendaftaran_id = $_GET['pendaftaran_id'];
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    if (!empty($modAnamnesa)) {
      $modAnamnesa->riwayatalergiobat = preg_replace('/\s+/', '', $modAnamnesa->riwayatalergiobat);
      $datatable = explode(',', trim($modAnamnesa->riwayatalergiobat));
    }
    $this->render('_alergiObat', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
      'datatable' => $datatable
    ));
  }
  /**
   * tindak lanjut pasien ke Instalasi Rawat Inap
   * di extend ke rawat darurat (TindakLanjutRIDariRDController) (jika ada perubahan cek keduanya)
   * @param type $instalasi_id
   * @param type $pendaftaran_id
   * @param type $pasienadmisi_id
   */
  public function actionTindakLanjutRI($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRujukan = new RJRujukanT;
    $modRujukanBpjs = new RJRujukanbpjsT;
    $modPasienAdmisi = new RJPasienAdmisiT;
    $modAsuransiPasien = new RJAsuransipasienM;
    $modAsuransiPasienBpjs = new RJAsuransipasienbpjsM;
    $modSep = new RJSepT;
    $status = 0;

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
    $smspasien = 1;

    if (in_array($instalasi_id, array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_HEMODIALISA))) {
      $modPasienPulang = new PasienpulangT;
      $modPasienPulang->tglpasienpulang = date('d M Y H:i:s');
      $modPasienPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPasienPulang->pasien_id = $modPasien->pasien_id;

      $date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
      $date2 = date('Y-m-d H:i:s');
      $diff = abs(strtotime($date2) - strtotime($date1));
      $hours   = floor(($diff) / 3600);

      $modPasienPulang->lamarawat = $hours;
    } else {
      $modPasienPulang = array();
    }
    if (isset($_POST['RJPendaftaranT'])) {

      // var_dump($_POST); 

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $ok = true;
        if (isset($_POST['PasienpulangT'])) {
          $modPasienPulang->attributes = $_POST['PasienpulangT'];
          $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
          $modPasienPulang->kondisikeluar_id = Params::KONDISIKELUAR_ID_RAWATINAP;
          $modPasienPulang->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
          $modPasienPulang->lamarawat = 0;
          $modPasienPulang->satuanlamarawat = 'lamarawat';

          if ($modPasienPulang->validate() || $modPasienPulang->validate()) {
            $ok = $ok && $modPasienPulang->save();
          } else $ok = false;
        }

        PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => $modPasienPulang->pasienpulang_id, 'statusperiksa' => Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO));


        $modInstalasi = InstalasiM::model()->findByPk($modPendaftaran->instalasi_id);
        $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);

        $judul = 'Pasien Rujuk ke Rawat Inap';

        $link = $this->createUrl('/pendaftaranPenjadwalan/PendaftaranRawatInapDariRJRD/index', array(
          'pendaftarantindaklanjut_id' => $modPendaftaran->pendaftaran_id,
        ));

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien
          . ' - ' . $modInstalasi->instalasi_nama . ' - ' . $modRuangan->ruangan_nama;


        $ok = $ok && CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN, 'link_proses' => $link),
        ));

        // var_dump($ok, $modPasienPulang->attributes); die;



        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
          $status = 1;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan');
        }

       
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . '_tindakLanjutRI', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modPasienPulang' => $modPasienPulang,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modSep' => $modSep,
      'status' => $status,
      'smspasien' => $smspasien
    ));
  }

  protected function savePasienPulang($modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '')
  {
    $modelPulangNew = new RDPasienPulangT;
    $modelPulangNew->attributes = $attrPasienPulang;
    $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
    $modelPulangNew->ruanganakhir_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_time = date('Y-m-d H:i:s');
    $modelPulangNew->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;

    if ($modelPulangNew->save()) {
      $this->pasienpulangtersimpan = true;
    }

    return $modelPulangNew;
  }

  public function pulangRujukRI()
  {
    $pendaftaran_id = (isset($_POST['RJPendaftaranT']['pendaftaran_id']) ? $_POST['RJPendaftaranT']['pendaftaran_id'] : (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null));
    $pasien_id =  PendaftaranT::model()->findByPk($pendaftaran_id)->pasien_id;
    $modPasienPulang = new PasienpulangT;
    $modPasienPulang->pendaftaran_id = $pendaftaran_id;
    $modPasienPulang->pasien_id = $pasien_id;
    $modPasienPulang->tglpasienpulang = date('Y-m-d H:i:s');
    $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
    $modPasienPulang->kondisikeluar_id = Params::KONDISIKELUAR_ID_RAWATINAP;
    $modPasienPulang->ruanganakhir_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPasienPulang->lamarawat = 0;
    $modPasienPulang->satuanlamarawat = 'lamarawat';
    if ($modPasienPulang->save()) {
      PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => $modPasienPulang->pasienpulang_id, 'statusperiksa' => Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO, 'alihstatus' => TRUE));
      $this->rujukrisukses = true;
    }

    return $modPasienPulang;
  }

  /**
   * proses simpan / ubah data pasien
   * @param type $modPasien
   * @param type $post
   * @return type
   */
  public function simpanPasien($modPasien, $post)
  {
    $format = new MyFormatter();

    if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
      $load = new $modPasien;
      $modPasien = $load->findByPk($post['pasien_id']);
    }
    $modPasien->attributes = $post;
    $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    if (isset($post['tempPhoto'])) {
      $modPasien->photopasien = $post['tempPhoto'];
    }
    if (empty($modPasien->pasien_id)) {
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = FALSE;
      $modPasien->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
    }

    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }

    return $modPasien;
  }

  /**
   * simpan MasukkamarT
   * ubah : KamarruanganM.kamarruangan_status, KamarruanganM.keterangan_kamar
   * INI COPY DARI MODUL PP - PendaftaranRawatInapController
   * @param type $model
   * @param type $modPasien
   * @param type $modPasienAdmisi
   */
  public function simpanMasukKamar($model, $modPasien, $modPasienAdmisi)
  {
    $modMasukKamar = new MasukkamarT;
    $modMasukKamar->carabayar_id = $model->carabayar_id;
    $modMasukKamar->kamarruangan_id = (!empty($modPasienAdmisi->kamarruangan_id)) ? $modPasienAdmisi->kamarruangan_id : null;
    $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
    $modMasukKamar->ruangan_id = $modPasienAdmisi->ruangan_id;
    $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
    $modMasukKamar->pegawai_id = $model->pegawai_id;
    $modMasukKamar->penjamin_id = $model->penjamin_id;
    $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
    $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
    $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
    $modMasukKamar->jammasukkamar = date('H:i:s');
    $modMasukKamar->tglkeluarkamar = null;
    $modMasukKamar->jamkeluarkamar = null;
    $modMasukKamar->lamadirawat_kamar = null;
    $modMasukKamar->create_time = date("Y-m-d H:i:s");
    $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
    $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modMasukKamar->save()) {
      if (!empty($modMasukKamar->kamarruangan_id)) {
        KamarruanganM::model()->updateByPk($modMasukKamar->kamarruangan_id, array('kamarruangan_status' => false, 'keterangan_kamar' => 'IN USE'));
      }
      $this->masukkamartersimpan = true;
    } else {
      $this->masukkamartersimpan = false;
    }
  }

  /**
   * proses simpan data rujukan
   * @param type $modRujukan
   * @param type $post
   * @return type
   */
  public function simpanRujukanBpjs($modRujukanBpjs, $post)
  {
    $format = new MyFormatter();
    $modRujukanBpjs->attributes = $post;
    $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);

    if ($modRujukanBpjs->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukanBpjs;
  }
  /**
   * simpan asuransi pasien
   * @param type $modAsuransiPasien
   * @param type $postPendaftaran
   * @param type $postPasien
   * @param type $postAsuransiPasien
   * @return type
   */
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
  {
    $format = new MyFormatter();
    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
  }

  public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep)
  {
    $reqSep = null;
    $modSep = new RJSepT;
    $bpjs = new Bpjs();

    $modSep->tglsep = date('Y-m-d H:i:s');
    $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
    $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
    $modSep->norujukan = $modRujukanBpjs->no_rujukan;
    $modSep->ppkrujukan = $postSep['ppkrujukan'];
    $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->jnspelayanan = ($model->instalasi_id == Params::INSTALASI_ID_RI) ? Params::JENISPELAYANAN_RI : Params::JENISPELAYANAN_RJ;
    $modSep->catatansep = $postSep['catatansep'];
    $data_diagnosa = explode(', ', $modRujukanBpjs->diagnosa_rujukan);
    $modSep->diagnosaawal = isset($data_diagnosa[0]) ? $data_diagnosa[0] : '';
    $modSep->politujuan = $model->ruangan_id;
    $modSep->klsrawat = $modAsuransiPasienBpjs->kelastanggunganasuransi_id;
    $modSep->tglpulang = date('Y-m-d H:i:s');
    $modSep->create_time = date('Y-m-d H:i:s');
    $modSep->create_loginpemakai_id = Yii::app()->user->id;
    $modSep->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id), true);

    if ($reqSep['metadata']['code'] == 200) {
      $modSep->nosep = $reqSep['response'];
      if ($modSep->save()) {
        $this->septersimpan = true;
      }
    }

    return $modSep;
  }

  /**
   * simpan PPPasienAdmisiT
   * @param modPasienAdmisi $modPasienAdmisi
   * @param type $model
   * @param type $modPasien
   * @param type $post
   * @return \modPasienAdmisi
   */
  public function simpanPasienAdmisi($model, $modPasien, $modPasienAdmisi, $post)
  {
    $format = new MyFormatter();
    $modPasienAdmisi = new $modPasienAdmisi;
    $modPasienAdmisi->attributes = $post;
    if ($model->instalasi_id == Params::INSTALASI_ID_RJ) {
      $caramasuk_id = Params::CARAMASUK_ID_RJ;
    } else if ($model->instalasi_id == Params::INSTALASI_ID_RD) {
      $caramasuk_id = Params::CARAMASUK_ID_RD;
    } else {
      $caramasuk_id = Params::CARAMASUK_ID_LANGSUNG_RI;
    }
    $modPasienAdmisi->caramasuk_id = $caramasuk_id;
    $modPasienAdmisi->pendaftaran_id = $model->pendaftaran_id;
    $modPasienAdmisi->tglpendaftaran = $model->tgl_pendaftaran;
    $modPasienAdmisi->tgladmisi = date('Y-m-d H:i:s');
    $modPasienAdmisi->pasien_id = $model->pasien_id;
    $modPasienAdmisi->shift_id = Yii::app()->user->getState('shift_id');
    $modPasienAdmisi->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienAdmisi->ruangan_id);
    $modPasienAdmisi->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPasienAdmisi->tglpulang = null;
    $modPasienAdmisi->rencanapulang = null;
    $modPasienAdmisi->create_time = date("Y-m-d H:i:s");
    $modPasienAdmisi->create_loginpemakai_id = Yii::app()->user->id;

    if ($modPasienAdmisi->save()) {
      //jika ada booking kamar (BELUM INTEGRASI)
      //                BookingkamarT::model()->updateByPk($modPasienAdmisi->bookingkamar_id,array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,'pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id));
      if (PendaftaranT::model()->updateByPk($modPasienAdmisi->pendaftaran_id, array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id, 'statusperiksa' => Params::STATUSPERIKSA_SEDANG_DIRAWATINAP))) {
        $this->admisitersimpan = true;
      } else {
        $this->admisitersimpan = false;
      }
    } else {
      $this->admisitersimpan = false;
    }
    return $modPasienAdmisi;
  }

  /**
   * set dropdown dokter
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new RJPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set antrian ruangan
   */
  public function actionSetAntrianRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $data = array();
      $data['maxantrianruangan'] = null;
      $data['no_urutantri'] = '001';
      if (!empty($ruangan_id)) {
        $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition("ruangan_id = " . $ruangan_id);
        }
        $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
        if (count((array)$modJadwalBukaPoli) > 0) {
          foreach ($modJadwalBukaPoli as $key => $antrian) {
            $data['maxantrianruangan'] = $antrian->maxantiranpoli;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown jenis kasus penyakit
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new RJPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   *penggunaannya
   * 1. digunakan di pendaftaran rawat inap
   * @param type $encode
   * @param type $namaModel
   * @param type $attr 
   */
  public function actionSetDropdownKamarKosong($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
        $ruangan_id = $_POST[$namaModel]['ruangan_id'];

      $bookingkamar_id = (isset($_POST['bookingkamar_id']) ? $_POST['bookingkamar_id'] : null);
      if (empty($bookingkamar_id) && isset($_POST[$namaModel]['bookingkamar_id']))
        $bookingkamar_id = $_POST[$namaModel]['bookingkamar_id'];

      $kamarKosong = array();
      if (!empty($ruangan_id)) {
        if (!empty($bookingkamar_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true, 'kamarruangan_aktif' => TRUE));

          $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
        } else {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true, 'kamarruangan_aktif' => TRUE));
        }
        $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kamarKosong)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          foreach ($kamarKosong as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }


  public function simpanPPDS($pendaftaran_id, $urutan_ppds, $ppds_id, $pasienadmisi_id, $post)
  {
    foreach ($post as $i => $ppds) {
      if (empty($ppds['pasien_ppds_id'])) {
        $model = new PasienPpdsT();
        $model->attributes = $ppds;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->urutan_ppds = $urutan_ppds;
        $model->ppds_id = $urutan_ppds;
        $model->pasienadmisi_id = $pasienadmisi_id;

        if (!$model->save()) {
          $this->ppdsTersimpan &= false;
        }
      }
    }
  }


  public function actionCreate($pendaftaran_id = null, $pasienadmisi_id = null, $ppds_id = null, $urutan_ppds = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;
    $model = new PasienPpdsT;

    if (isset($_POST['PpdsM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;

      $i = 1;
      foreach ($_POST['PpdsM'] as $idx => $item) {
        $modDetail = new PasienPpdsT;
        $modDetail->ppds_id = $item['ppds_id'];
        $modDetail->urutan_ppds = $i;
        $modDetail->pendaftaran_id = $pendaftaran_id;
        $modDetail->pasienadmisi_id = $pasienadmisi_id;

        $ok = $ok && $modDetail->save();
        $i++;
      }

      if ($ok && !empty(Yii::app()->user->getState('pegawai_id'))) {
        $transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Sukses!</strong> Data berhasil disimpan!');
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Perhatian!</strong> Nama PPDS Tidak Sesuai login Anda!');
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'model2' => $model2,
      'modPpds' => $modPpds,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan' => $modRuangan,
      'modDetail' => $modDetail
    ));
  }

  public function actionAutoPPDS()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'ppds_nama';
      $criteria->limit = 10;
      $models = PpdsM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->ppds_nama;
        $returnVal[$i]['value'] = $model->ppds_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPPDSRJ($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    //$pendaftaran_id = $_GET['pendaftaran_id'];

    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;

    $model2->ppds_nama;

    $this->render('_formPPDSRJ', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan' => $modRuangan,
      'model2' => $model2,
      'modPpds' => $modPpds,
      'modDetail' => $modDetail
      //   'datatable' => $datatable
    ));
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /*
         * Mencari kelas pelayanan berdasarkan kamarruangan_id di tabel kamarruanganM
         * and open the template in the editor.
         */
  public function actionSetDropdownKelasPelayanan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kamarruangan_id = $_POST["$namaModel"]['kamarruangan_id'];
      $kelasPelayanan = null;
      if ($kamarruangan_id) {
        $kelasPelayanan = KamarruanganM::model()->with('kelaspelayanan')->findAll('kamarruangan_id=' . $kamarruangan_id . '');
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
      if (empty($kelasPelayanan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($kelasPelayanan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set antrian dokter
   */
  public function actionSetAntrianDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $data = array();
      $data['maxantriandokter'] = 0;
      if (!empty($ruangan_id) && !empty($pegawai_id)) {
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition("ruangan_id = " . $ruangan_id);
        }
        if (!empty($pegawai_id)) {
          $criteria->addCondition("pegawai_id = " . $pegawai_id);
        }
        $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
        if (count((array)$modJadwalDokter) > 0) {
          foreach ($modJadwalDokter as $key => $antrian) {
            $data['maxantriandokter'] = $antrian->maximumantrian;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * action ketika tombol panggil di klik
   */
  // public function actionPanggil()
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $format = new MyFormatter();
  //     $data = array();
  //     $data['pesan'] = "";
  //     $pendaftaran_id = ($_POST['pendaftaran_id']);
  //     $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
  //     $modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);

  //     $nama_modul = Yii::app()->controller->module->id;
  //     $nama_controller = Yii::app()->controller->id;
  //     $nama_action = Yii::app()->controller->action->id;
  //     $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
  //     $criteria = new CDbCriteria;
  //     $criteria->compare('modul_id', $modul_id);
  //     $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
  //     $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
  //     if (isset($_POST['tujuansms'])) {
  //       $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
  //     }
  //     $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
  //     $data['smspasien'] = 1;
  //     $data['nama_pasien'] = '';

  //     if (isset($modPendaftaran)) {
  //       if ($modPendaftaran->panggilantrian == true) {
  //         if ($keterangan == "batal") {
  //           $modPendaftaran->panggilantrian = false;
  //           if ($modPendaftaran->update()) {

  //             $data['pesan'] = "Pemanggilan no. antrian " . $modPendaftaran->no_urutantri . " dibatalkan !";
  //           }
  //         } else {

  //           $data['pesan'] = "No. antrian " . $modPendaftaran->no_urutantri . " dipanggil !";
  //         }
  //         $data['smspasien'] = 1;
  //       } else {
  //         $modPendaftaran->panggilantrian = true;
  //         if ($modPendaftaran->update()) {
  //           // SMS GATEWAY
  //           $modPasien = $modPendaftaran->pasien;
  //           $sms = new Sms();
  //           $smspasien = 1;
  //           foreach ($modSmsgateway as $i => $smsgateway) {
  //             $isiPesan = $smsgateway->templatesms;

  //             $attributes = $modPasien->getAttributes();
  //             foreach ($attributes as $attributes => $value) {
  //               $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
  //             }
  //             $attributes = $modPendaftaran->getAttributes();
  //             foreach ($attributes as $attributes => $value) {
  //               $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
  //             }

  //             if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
  //               if (!empty($modPasien->no_mobile_pasien)) {
  //                 $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
  //               } else {
  //                 $smspasien = 0;
  //               }
  //             }
  //           }
  //           // END SMS GATEWAY
  //           $data['smspasien'] = $smspasien;
  //           $data['nama_pasien'] = $modPendaftaran->pasien->nama_pasien;
  //           $data['pesan'] = "No. antrian " . $modPendaftaran->no_urutantri . " dipanggil !";
  //           $data_telnet = $modPendaftaran->ruangan->ruangan_nama . ", " . $modPendaftaran->ruangan->ruangan_singkatan . "-" . $modPendaftaran->no_urutantri;
  //           // CustomFunction::postTelnet($data_telnet);

  //           if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ){
  //             $penSelesaiPeriksa = PendaftaranT::model()->findByPk($pendaftaran_id);
  //             $findWaktu = WaktutunggupelayananT::model()->findByAttributes(array('pendaftaran_id'=>$penSelesaiPeriksa->pendaftaran_id, 'task_id'=>'4'));

  //             $kodebooking = $penSelesaiPeriksa->no_pendaftaran;

  //             if(!empty($penSelesaiPeriksa->buatjanjipoli_id)){
  //               $buatjanjipoli = BuatjanjipoliT::model()->findByPk($penSelesaiPeriksa->buatjanjipoli_id);

  //               if(!empty($buatjanjipoli)){
  //                 $kodebooking = $buatjanjipoli->no_buatjanji;
  //               }
  //             }

  //             if(empty($findWaktu)){
  //               $waktutunggupelayanan = new WaktutunggupelayananT();
  //               $waktutunggupelayanan->pendaftaran_id = $penSelesaiPeriksa->pendaftaran_id;
  //               $waktutunggupelayanan->pasien_id = $penSelesaiPeriksa->pasien_id;
  //               $waktutunggupelayanan->task_id = 4;
  //               $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type'=>'taskid','lookup_value'=>$waktutunggupelayanan->task_id));
  //               $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu)?$lookup_waktutunggu->lookup_name:null);
  //               $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
  //               $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));

  //               $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
  //               $waktutunggupelayanan->kode_booking = $kodebooking;
  //               $waktutunggupelayanan->statuskirim = 0;
  //               $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
  //               $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
  //               $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
  //               $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

  //               if($waktutunggupelayanan->save()){
  //                 if(Yii::app()->user->getState('antreanonlinewsbpjs')){
  //                   $body_waktutgp = array("kodebooking"=>$waktutunggupelayanan->kode_booking, "taskid"=>$waktutunggupelayanan->task_id, "waktu"=>$waktutunggupelayanan->waktutunggu_mil);
  //                   $antrianonlinebpjs = new AntrianOnlineBpjs();
  //                   $response_antrianol = CJSON::decode($antrianonlinebpjs->update_waktu($body_waktutgp));
  //                   $dateNowUpdt = date('c', strtotime(date('Y-m-d H:i:s')));

  //                   if(!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200'){
  //                     WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('statuskirim'=>true,'update_loginpemakai_id'=>Yii::app()->user->id,'update_time'=>date('Y-m-d H:i:s', strtotime($dateNowUpdt))));
  //                   }else{
  //                     if(!empty($response_antrianol['metaData']['code'])){
  //                       WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list'=>$response_antrianol['metaData']['message']));
  //                     }
  //                   }
  //                 }
  //               }
  //             }
  //           }
  //         }
  //       }
  //     }
  //     // CustomFunction::postSerialPanggilanRuangan($modPendaftaran->ruangan->ruangan_singkatan . $modPendaftaran->no_urutantri, $modPendaftaran->ruangan_id);
  //     $attributes = $modPendaftaran->attributeNames();
  //     foreach ($attributes as $i => $attribute) {
  //       $data["$attribute"] = $modPendaftaran->$attribute;
  //     }
  //     $data['ruangan_singkatan'] = $modPendaftaran->ruangan->ruangan_singkatan;
  //     $data['ruangan_id'] = $modPendaftaran->ruangan->ruangan_id;


  //     echo CJSON::encode($data);
  //     Yii::app()->end();
  //   } else
  //     throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  // }

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
      $model = CheckjadwalR::model()->findAllByAttributes(['pegawai_id' => $modPendaftaran->pegawai_id]);
      foreach ($model as $i) {
        $data_telnet = ">" . $modPendaftaran->no_urutantri;
        // if(Yii::app()->user->getState('is_telnetaktif')){
        $address = $i->check_ipsegment;
        $port   = $i->check_port;
        $len    = strlen($data_telnet);
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) or FALSE;
        if ($socket) {
          if (socket_connect($socket, $address, $port)) {
            socket_sendto($socket, $data_telnet, $len, 0, $address, $port);
            socket_close($socket);
          }
        }
      }
      // var_dump($modPendaftaran);die;
      // $modCheck[]=$model;
      // var_dump($model['check_status']);die;
      // $model->check_status = !empty($model->check_status) ? $model->check_status : false;
      // $model['check_status'] = !empty($model->check_status) ? $model->check_status : false;
      // var_dump($model['check_status']);die;
      // if (empty($model)) {
      //   // $data['status'] = !empty($model->check_status) ? $model->check_status : false;

      //   $data['pesan'] = "Dokter belum melakukan check in !";

      //   echo CJSON::encode(['data' => $data, 'list' => $model]);
      // } else {

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
              $data['pesan'] = "Pemanggilan no. antrian " . $modPendaftaran->ruangan->ruangan_singkatan . '-' . $modPendaftaran->no_urutantri . " dibatalkan !";
            }
          } else {
            $modPendaftaran->jml_panggil = (!empty($modPendaftaran->jml_panggil)) ? ($modPendaftaran->jml_panggil + 1) : 1;
            $modPendaftaran->panggilantrian = true;
            $modPendaftaran->waktupanggilpasien = date('Y-m-d H:i:s');
            $modPendaftaran->update();
            $data['pesan'] = "No. antrian " . $modPendaftaran->ruangan->ruangan_singkatan . '-' . $modPendaftaran->no_urutantri . " dipanggil !";
          }
          $data['smspasien'] = 1;
        } else {
          $modPendaftaran->panggilantrian = true;
          $modPendaftaran->jml_panggil = (!empty($modPendaftaran->jml_panggil)) ? ($modPendaftaran->jml_panggil + 1) : 1;
          $modPendaftaran->waktupanggilpasien = date('Y-m-d H:i:s');
          $modPendaftaran->update();

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
            $data['pesan'] = "No. antrian " . $modPendaftaran->ruangan->ruangan_singkatan . '-' .  $modPendaftaran->no_urutantri . " dipanggil !";
            $data_telnet = $modPendaftaran->ruangan->ruangan_nama . ", " . $modPendaftaran->ruangan->ruangan_singkatan . "-" . $modPendaftaran->no_urutantri;
            // $this->postTelnet(var_dump($data_telnet));die;
            // CustomFunction::postTelnet($data_telnet);

            if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) {
              $penSelesaiPeriksa = PendaftaranT::model()->findByPk($pendaftaran_id);
              $findWaktu = WaktutunggupelayananT::model()->findByAttributes(array('pendaftaran_id' => $penSelesaiPeriksa->pendaftaran_id, 'task_id' => '4'));

              $kodebooking = $penSelesaiPeriksa->no_pendaftaran;

              if (!empty($penSelesaiPeriksa->buatjanjipoli_id)) {
                $buatjanjipoli = BuatjanjipoliT::model()->findByPk($penSelesaiPeriksa->buatjanjipoli_id);

                if (!empty($buatjanjipoli)) {
                  $kodebooking = $buatjanjipoli->no_buatjanji;
                }
              }

              if (empty($findWaktu)) {
                $waktutunggupelayanan = new WaktutunggupelayananT();
                $waktutunggupelayanan->pendaftaran_id = $penSelesaiPeriksa->pendaftaran_id;
                $waktutunggupelayanan->pasien_id = $penSelesaiPeriksa->pasien_id;
                $waktutunggupelayanan->task_id = 4;
                $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
                $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
                $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
                $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));

                $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
                $waktutunggupelayanan->kode_booking = $kodebooking; //$penSelesaiPeriksa->no_pendaftaran;
                $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
                $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
                $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

                $antrianonlinebpjs = new AntrianOnlineBpjs();
                $body = array(
                  "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
                );
                $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

                if (
                  !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
                ) {
                  $waktutunggupelayanan->statuskirim = 1;
                  $waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
                  $waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
                } else {
                  $waktutunggupelayanan->statuskirim = 0;
                  $waktutunggupelayanan->response_list = $response['metaData']['message'];
                }
                $waktutunggupelayanan->save();
              }
            }
          }
        }
      }
      // CustomFunction::postSerialPanggilanRuangan($modPendaftaran->ruangan->ruangan_singkatan . $modPendaftaran->no_urutantri, $modPendaftaran->ruangan_id);
      $attributes = $modPendaftaran->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $modPendaftaran->$attribute;
      }
      $data['ruangan_singkatan'] = $modPendaftaran->ruangan->ruangan_singkatan;
      $data['ruangan_id'] = $modPendaftaran->ruangan->ruangan_id;

      echo CJSON::encode(['data' => $data, 'list' => $model]);
      // }

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
      $criteria->addCondition('date(tgl_pendaftaran) BETWEEN \'' . date('d M Y') . '\' AND \'' . date('d M Y') . '\'');
      $criteria->order = 'no_urutantri ASC';

      $model = RJInfokunjunganrjV::model()->find($criteria);
      if (!empty($model)) {
        $data['pendaftaran_id'] = $model->pendaftaran_id;
        $data['ruangan_singkatan'] = $model->ruangan_singkatan;
        $data['no_urutantri'] = $model->no_urutantri;
        $data['ruangan_id'] = $model->ruangan_id;
      } else {
        $data['pesan'] = "Tidak ada antrian!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * batal periksa pasien 
   */
  public function actionBatalPeriksa()
  {
    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $smspasien = 1;
    $smsdokter = 1;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPegawai = $modPendaftaran->pegawai;
      $modPasien = $modPendaftaran->pasien;

      try {
        /*
					* cek data pendaftaran pasien masuk penunjang
					*/
        $criteria = new CDbCriteria();
        if (!empty($pendaftaran_id)) {
          $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        }

        $tindakan = TindakanpelayananT::model()->findByAttributes(array(
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'tindakansudahbayar_id is not null'
        ));
        $oa = ObatalkespasienT::model()->findByAttributes(array(
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'oasudahbayar_id is not null'
        ));

        $ada = false;

        if (!empty($tindakan) || !empty($oa)) {
          $ada = true;
          $pesan = "Pasien sudah melakukan pembayaran. "
            . "Mohon pembayaran sebelumnya dibatalkan terlebih dahulu sebelum melakukan pembatalan pemeriksaan.";
          $status = false;
          goto onco; // loncat ke label 'onco'
        }

        $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

        $pesan = '';
        $status = false;
        $model = new PasienbatalperiksaR();
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->tglbatal = date('Y-m-d');
        $model->keterangan_batal = $keterangan_batal;
        $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
          $status = true;
          $pesan = "Pemeriksaan pasien berhasil dibatalkan!";

          if (!empty($modPendaftaran) && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ && (empty($modPendaftaran->pasienadmisi_id))) {
            $kodebooking = $modPendaftaran->no_pendaftaran;

            if (!empty($modPendaftaran->buatjanjipoli_id)) {
              $buatjanjipoli = BuatjanjipoliT::model()->findByPk($modPendaftaran->buatjanjipoli_id);

              if (!empty($buatjanjipoli)) {
                $kodebooking = $buatjanjipoli->no_buatjanji;
              }
            }

            $waktutunggupelayanan = new WaktutunggupelayananT();
            $waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
            $waktutunggupelayanan->task_id = 99;
            $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
            $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
            $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
            $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
            $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->kode_booking = $kodebooking;
            $waktutunggupelayanan->statuskirim = 0;
            $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
            $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

            if ($waktutunggupelayanan->save()) {
              $body_waktutgp = array("kodebooking" => $waktutunggupelayanan->kode_booking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil);
              $antrianonlinebpjs = new AntrianOnlineBpjs();
              $response_antrianol = CJSON::decode($antrianonlinebpjs->update_waktu($body_waktutgp));
              $dateNowUpdt = date('c', strtotime(date('Y-m-d H:i:s')));

              if (!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200') {
                // $body_batal = array("kodebooking"=>$waktutunggupelayanan->kode_booking, "keterangan"=>$keterangan_batal);
                // $respbatal_antrianol = CJSON::decode($antrianonlinebpjs->batal_antrian($body_batal));

                // if(!empty($respbatal_antrianol['metaData']['code']) && $respbatal_antrianol['metaData']['code'] == '200'){
                WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('statuskirim' => true, 'update_loginpemakai_id' => Yii::app()->user->id, 'update_time' => date('Y-m-d H:i:s', strtotime($dateNowUpdt))));
                // }else{
                //   if(!empty($respbatal_antrianol['metaData']['code'])){
                //     WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list'=>$respbatal_antrianol['metaData']['message']));
                //   }
                // }
              } else {
                if (!empty($response_antrianol['metaData']['code'])) {
                  WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list' => $response_antrianol['metaData']['message']));
                }
              }
            }
          }
        } else {
          $status = false;
          $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
        }

        $attributes = array(
          'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
          'update_time' => date('Y-m-d H:i:s'),
          'update_loginpemakai_id' => Yii::app()->user->id,
          'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA
        );
        $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

        // hapus sep BPJS
        /*
        if (!empty($modPendaftaran->sep_id)) {
            $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
            
            if (!empty($sep)) {
                $bpjs = new BpjsVklaim;
                
                $reqSep = json_decode($bpjs->delete_transaksi_sep($sep->nosep, Yii::app()->user->getState('nama_pegawai')));
                
                // var_dump($sep->nosep, Yii::app()->user->getState('nama_pegawai'), $reqSep); die;
            }
        }
        */

        onco:

        if ($status == true) {
          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $sms = new Sms();
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglbatal), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
              if (!empty($modPegawai->nomobile_pegawai)) {
                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
              } else {
                $smsdokter = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
          $this->hapusSepBatal($modPendaftaran);
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "exist";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
        'smspasien' => $smspasien,
        'smsdokter' => $smsdokter,
        'nama_pasien' => $modPasien->nama_pasien,
        'nama_pegawai' => $modPegawai->nama_pegawai,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * batal periksa pasien 
   */
  public function actionBatalPeriksa1()
  {
    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $smspasien = 1;
    $smsdokter = 1;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPegawai = $modPendaftaran->pegawai;
      $modPasien = $modPendaftaran->pasien;

      try {
        /*
					* cek data pendaftaran pasien masuk penunjang
					*/
        $criteria = new CDbCriteria();
        if (!empty($pendaftaran_id)) {
          $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        }

        $tindakan = TindakanpelayananT::model()->findByAttributes(array(
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'tindakansudahbayar_id is not null'
        ));
        $oa = ObatalkespasienT::model()->findByAttributes(array(
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'oasudahbayar_id is not null'
        ));

        $ada = false;

        if (!empty($tindakan) || !empty($oa)) {
          $ada = true;
          $pesan = "Pasien sudah melakukan pembayaran. "
            . "Mohon pembayaran sebelumnya dibatalkan terlebih dahulu sebelum melakukan pembatalan pemeriksaan.";
          $status = false;
          goto onco; // loncat ke label 'onco'
        }

        $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

        $pesan = '';
        $status = false;
        $model = new PasienbatalperiksaR();
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->tglbatal = date('Y-m-d');
        $model->keterangan_batal = !empty($keterangan_batal) ? $keterangan_batal : "-";
        $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
          $status = true;
          $pesan = "Pemeriksaan pasien berhasil dibatalkan!";

          if (!empty($modPendaftaran) && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ && (empty($modPendaftaran->pasienadmisi_id))) {
            $kodebooking = $modPendaftaran->no_pendaftaran;

            if (!empty($modPendaftaran->buatjanjipoli_id)) {
              $buatjanjipoli = BuatjanjipoliT::model()->findByPk($modPendaftaran->buatjanjipoli_id);

              if (!empty($buatjanjipoli)) {
                $kodebooking = $buatjanjipoli->no_buatjanji;
              }
            }

            $waktutunggupelayanan = new WaktutunggupelayananT();
            $waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
            $waktutunggupelayanan->task_id = 99;
            $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
            $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
            $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
            $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
            $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->kode_booking = $kodebooking;
            $waktutunggupelayanan->statuskirim = 0;
            $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
            $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

            if ($waktutunggupelayanan->save()) {
              $body_waktutgp = array("kodebooking" => $waktutunggupelayanan->kode_booking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil);
              $antrianonlinebpjs = new AntrianOnlineBpjs();
              $response_antrianol = CJSON::decode($antrianonlinebpjs->update_waktu($body_waktutgp));
              $dateNowUpdt = date('c', strtotime(date('Y-m-d H:i:s')));

              if (!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200') {
                // $body_batal = array("kodebooking"=>$waktutunggupelayanan->kode_booking, "keterangan"=>$keterangan_batal);
                // $respbatal_antrianol = CJSON::decode($antrianonlinebpjs->batal_antrian($body_batal));

                // if(!empty($respbatal_antrianol['metaData']['code']) && $respbatal_antrianol['metaData']['code'] == '200'){
                WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('statuskirim' => true, 'update_loginpemakai_id' => Yii::app()->user->id, 'update_time' => date('Y-m-d H:i:s', strtotime($dateNowUpdt))));
                // }else{
                //   if(!empty($respbatal_antrianol['metaData']['code'])){
                //     WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list'=>$respbatal_antrianol['metaData']['message']));
                //   }
                // }
              } else {
                if (!empty($response_antrianol['metaData']['code'])) {
                  WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list' => $response_antrianol['metaData']['message']));
                }
              }
            }
          }
        } else {
          $status = false;
          $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
        }

        $attributes = array(
          'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
          'update_time' => date('Y-m-d H:i:s'),
          'update_loginpemakai_id' => Yii::app()->user->id,
          'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA
        );
        $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

        // hapus sep BPJS
        /*
        if (!empty($modPendaftaran->sep_id)) {
            $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
            
            if (!empty($sep)) {
                $bpjs = new BpjsVklaim;
                
                $reqSep = json_decode($bpjs->delete_transaksi_sep($sep->nosep, Yii::app()->user->getState('nama_pegawai')));
                
                // var_dump($sep->nosep, Yii::app()->user->getState('nama_pegawai'), $reqSep); die;
            }
        }
        */

        onco:

        if ($status == true) {
          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $sms = new Sms();
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglbatal), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
              if (!empty($modPegawai->nomobile_pegawai)) {
                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
              } else {
                $smsdokter = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
          $this->hapusSepBatal($modPendaftaran);
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "exist";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
        'smspasien' => $smspasien,
        'smsdokter' => $smsdokter,
        'nama_pasien' => $modPasien->nama_pasien,
        'nama_pegawai' => $modPegawai->nama_pegawai,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function hapusSepBatal($modPendaftaran)
  {
    $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
    if (empty($sep)) {
      return false;
    }

    $no_sep = $sep->nosep;
    if (empty($no_sep)) {
      return false;
    }

    $bpjs = new Bpjs_Vklaim;
    $bpjs->delete_transaksi_sep($no_sep, Yii::app()->user->getState('nama_pemakai'));

    PendaftaranT::model()->updateAll(array('sep_id' => null), 'sep_id = ' . $sep->sep_id);
    PasiendirujukkeluarT::model()->deleteAllByAttributes(array('sep_id' => $sep->sep_id));

    $sep->delete();
  }

  /**
   * untuk Ubah Dokter
   */
  public function actionUbahDokterPeriksa()
  {
    $model = new RJPendaftaranT;
    $modUbahDokter = new RJUbahdokterR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['RJPendaftaranT'])) {
      if ($_POST['RJPendaftaranT']['pegawai_id'] != "") {
        $model->attributes = $_POST['RJPendaftaranT'];
        $modUbahDokter->attributes = $_POST['RJUbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['RJPendaftaranT']['pendaftaran_id'];
        $modUbahDokter->dokterbaru_id = $_POST['RJPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pegawai_id' => $_POST['RJPendaftaranT']['pegawai_id']);
          $save = $model::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $modUbahDokter->save();
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
        'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu), true)
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
        $idPegawai = $_POST['idPegawai'];

        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array(
          'order' => 'nama_pegawai',
          'condition' => 'pegawai_id <> ' . $idPegawai,
        ));
        $data = CHtml::listData($data, 'pegawai_id', 'namaLengkap');

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
   * untuk Ubah Poliklinik
   */
  public function actionUbahPoliklinik($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (isset($_POST['RJPendaftaranT'])) {
      $modPendaftaran->attributes = $_POST['RJPendaftaranT'];
      $format = new MyFormatter();
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $attributes = array(
          'ruangan_id' => $modPendaftaran->ruangan_id,
          'no_urutantri' => MyGenerator::noAntrian($modPendaftaran->ruangan_id),
        );

        $save = $modPendaftaran::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'], $attributes);

        if ($save) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('ubahPoliklinik', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render('_formUbahPoliklinik', array('modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran));
  }

  public function actionDetailScanRM2($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $file = DokfilermR::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

    if (strpos($file->dokfilerm_filepath, '.png,.pdf') !== false) {
      $this->redirect(Params::urlFileRMPasienDirectory() . $file->namafolder . '/' . $file->dokfilerm_filepath);
    } else {
      $this->render($this->path_view . "detail", array(
        'modPendaftaran' => $modPendaftaran,
        'file' => $file,

      ));
    }
  }


  public function actionRiwayatDokfilerm($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $crit = new CDbCriteria();
    $crit->addCondition('pasien_id =' . $modPasien->pasien_id);
    $modDokfilerm = DokfilermR::model()->findAll($crit);
    $modDokfilerms = [];
    foreach ($modDokfilerm as $dok) {
      // if (in_array(Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
      $modDokfilerms[] = $dok;
      // }
    }


    $kertas = Params::DEFAULT_KERTAS_UKURAN;
    $mpdf = new MyPDF60;

    $a = 0;
    foreach ($modDokfilerms as $key => $val) {
      $file = Params::pathFileRMPasienDirectory() . $modPasien->no_rekam_medik . '/' . $val->dokfilerm_filepath;
      $urlfile = Params::urlFileRMPasienDirectory() . $modPasien->no_rekam_medik . '/' . $val->dokfilerm_filepath;
      if (file_exists($file)) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if ($ext == 'pdf') {
          $pagecount = $mpdf->SetSourceFile($file);
          for ($i = 1; $i <= $pagecount; $i++) {
            if ($a > 0) {
              $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 15, 15, 15, 15, 15, 15);
            }
            $tplId = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($tplId);
            $a++;
          }
        } elseif ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
          if ($a > 0) {
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 15, 15, 15, 15, 15, 15);
          }
          $mpdf->writeHtml("<img src='" . $urlfile . "' width='100%'>");
          $a++;
        }
      }
    }

    if (!file_exists(Params::pathFileRMPasienDirectory() . $modPasien->no_rekam_medik . '/gabungan/')) {
      mkdir(Params::pathFileRMPasienDirectory() . $modPasien->no_rekam_medik . '/gabungan/', 0775, true);
    }

    $pdffile = Params::pathFileRMPasienDirectory() . $modPasien->no_rekam_medik . '/gabungan/filegabungan.pdf';
    $mpdf->Output($pdffile, 'F');

    $urlfile = Params::urlFileRMPasienDirectory() . $modPasien->no_rekam_medik . '/gabungan/filegabungan.pdf';

    // echo '<pre>';var_dump($urlfile);die;
    $this->render('_listDokfilerm', array('pdffile' => $urlfile));
  }

  public function actionDetailScanRM($dokfilerm_id)
  {
    $this->layout = '//layouts/iframe';

    $file = DokfilermR::model()->findByPk($dokfilerm_id);

    $this->render("detail", array(
      'file' => $file,
    ));
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

    $this->render($this->path_view . '_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'modAdmisi' => $modAdmisi,
      'status' => $status
    ));
  }

  /**
   * penghapusan dokumen RM
   */
  /**
   * ubah status dokumen
   */
  public function actionHapusDokumenPengiriman()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $statusdok = $_POST['status'];
      $delete = false;
      $status = '';
      $div = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      $pengiriman = PengirimanrmT::model()->findAllByAttributes(array(
        'ruanganpengirim_id' => Yii::app()->user->getState('ruangan_id'),
        'pendaftaran_id' => $pendaftaran_id,
      ), array(
        'order' => 'nourut_keluar desc',
        'limit' => 2,
      ));

      //var_dump($pengiriman[0]->pengirimanrm_id); die;

      if (!empty($pengirimanrm_id)) {
        $model->pengirimanrm_id = $pengirimanrm_id;
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengiriman[0]->pengirimanrm_id); //($pengirimanrm_id);  
        // var_dump($modPenerimaanRm->attributes);
        // var_dump($model->attributes); die;
        if ($model->save()) {
          $modPenerimaanRm->delete();
          $delete = true;
        } else {
          $delete = false;
        }
      }

      if ($delete == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil dihapus </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal dihapus </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }
  /**
   * ambil status penerimaan dokumen
   */
  public function actionGetStatusPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $ruanganpenerimaan_id = $_POST['ruanganpenerimaan_id'];
      $statusdok = $_POST['status'];
      $penerimaan = false;
      $div = '';
      $ruangan = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        if ($modPenerimaanRm->ruanganpenerimaan_id == $ruanganpenerimaan_id) {
          $penerimaan = true;
        }
      }

      if ($penerimaan == true) {
        $div = "<div class='flash-success'>Dokumen Sudah Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
      } else {
        $div = "<div class='flash-error'>Dokumen Belum Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
      }

      echo CJSON::encode(array(
        'div' => $div,
      ));
      exit;
    }
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

  public function actionAutocompletePetugas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->NamaLengkap;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionSetSedangPeriksa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $p = PendaftaranT::model()->findByPk($pendaftaran_id);
      $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
      //$update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
      $this->updateStatusKonsul($pendaftaran_id);
      echo CJSON::encode($update);
    }
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
      $update = true;
      if (in_array($status, array(Params::STATUSPERIKSA_ANTRIAN))) {
        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
        $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
        // if (empty($model->pasienadmisi_id)) $update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
        $this->updateStatusKonsul($pendaftaran_id, Params::STATUSPERIKSA_SEDANG_PERIKSA);
      } else if (in_array($status, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA))) {
        // var_dump($status); die;
        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
        $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_PULANG);
        // if (empty($model->pasienadmisi_id)) $update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));

        $this->updateStatusKonsul($pendaftaran_id, Params::STATUSPERIKSA_SUDAH_PULANG);
      } else if($status == Params::STATUSPERIKSA_SUDAH_PULANG) {

        $p = PendaftaranT::model()->findByPk($pendaftaran_id);

        if(date('Y-m-d', strtotime($p->tgl_pendaftaran)) == date('Y-m-d')) {
          $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
          $this->updateStatusKonsul($pendaftaran_id, Params::STATUSPERIKSA_SEDANG_PERIKSA);
        }

      } else if ($status == "SEDANG PERIKSA") {
        $update = true;

        $anamnesa = AnamnesaT::model()->find("pendaftaran_id = $pendaftaran_id");
        $fisik = PemeriksaanfisikT::model()->find("pendaftaran_id = $pendaftaran_id");
        $diagnosa_awal = PasienmorbiditasT::model()->find("pendaftaran_id = $model->pendaftaran_id");

        // echo '<pre>'; var_dump($anamnesa, $fisik, $diagnosa_awal); die;
        
        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
        $kosong = empty($anamnesa) && empty($fisik) && empty($diagnosa_awal);

        if ($p->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {

          if($kosong) {
            $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_ANTRIAN);
          } else {
            $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
            PendaftaranT::model()->broadcastNotifSudahPeriksa($pendaftaran_id);
          }
          
        }


        if (empty($p->pasienadmisi_id)) $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s')));
        $this->updateStatusKonsul($pendaftaran_id, Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
        $pselesai = PendaftaranT::model()->findByPk($pendaftaran_id);

        $findwaktu = WaktutunggupelayananT::model()->findByAttributes(array('pendaftaran_id' => $pselesai->pendaftaran_id, 'task_id' => '5'));
        if (!empty($pselesai) && $pselesai->instalasi_id == Params::INSTALASI_ID_RJ && (empty($pselesai->pasienadmisi_id)) && empty($findwaktu)) {
          $kodebooking = $pselesai->no_pendaftaran;

          if (!empty($pselesai->buatjanjipoli_id)) {
            $buatjanjipoli = BuatjanjipoliT::model()->findByPk($pselesai->buatjanjipoli_id);

            if (!empty($buatjanjipoli)) {
              $kodebooking = $buatjanjipoli->no_buatjanji;
            }
          }

          $waktutunggupelayanan = new WaktutunggupelayananT();
          $waktutunggupelayanan->pendaftaran_id = $pselesai->pendaftaran_id;
          $waktutunggupelayanan->pasien_id = $pselesai->pasien_id;
          $waktutunggupelayanan->task_id = 5;
          $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
          $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
          $dateNow = date('c', strtotime((!empty($pselesai->tglselesaiperiksa) ? MyFormatter::formatDateTimeForDb($pselesai->tglselesaiperiksa) : date('Y-m-d H:i:s'))));
          $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
          $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
          $waktutunggupelayanan->kode_booking = $kodebooking; //$pselesai->no_pendaftaran;
          $waktutunggupelayanan->statuskirim = 0;
          $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
          $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
          $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
          $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

          if ($waktutunggupelayanan->save()) {
            if (Yii::app()->user->getState('antreanonlinewsbpjs')) {
              $body_waktutgp = array("kodebooking" => $waktutunggupelayanan->kode_booking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil);
              $antrianonlinebpjs = new AntrianOnlineBpjs();
              $response_antrianol = CJSON::decode($antrianonlinebpjs->update_waktu($body_waktutgp));
              $dateNowUpdt = date('c', strtotime(date('Y-m-d H:i:s')));

              if (!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200') {
                WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('statuskirim' => true, 'update_loginpemakai_id' => Yii::app()->user->id, 'update_time' => date('Y-m-d H:i:s', strtotime($dateNowUpdt))));
              } else {
                if (!empty($response_antrianol['metaData']['code'])) {

                  WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list' => $response_antrianol['metaData']['message']));
                }
              }
            }
          }
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
  /*
     * end Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */

  function updateStatusKonsul($pendaftaran_id, $status)
  {
    $p = PendaftaranT::model()->findByPk($pendaftaran_id);
    $konsul = KonsulpoliT::model()->findAllByAttributes(array(
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
      'pendaftaran_id' => $pendaftaran_id,
    ));
    foreach ($konsul as $item) {
      KonsulpoliT::model()->updateByPk($item->konsulpoli_id, array(
        'statusperiksa' => $status,
      ));
    }
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * @param type $term data dari Text Input
   */
  public function actionGetDokterPenerima($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $prov = PegawaiV::model()->searchDokterUmum();
    $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
    $prov->sort->defaultOrder = 'nama_pegawai';
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }


  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Ambil data dokter Umum dari autocomplete.
   * 
   * @param type $term data dari Text Input
   */
  public function actionGetDokterDPJP($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $prov = PegawaiV::model()->searchDokterDPJP();
    $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
    $prov->sort->defaultOrder = 'nama_pegawai';
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  function actionPrintDetailPartograf($id)
  {
    $this->layout = '//layouts/printWindows_delay';

    $persalinan = PersalinanT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $pendaftaran = PendaftaranT::model()->findByPk($id);
    $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);


    $mod = PemeriksaanpartografT::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'pemeriksaanpartograf_id',
    ));

    $det = PemeriksaanpartografdetT::model()->findAllByAttributes(array(
      'pemeriksaanpartograf_id' => $mod->pemeriksaanpartograf_id,
    ), array(
      'order' => 'pemeriksaan_ke ASC',
    ));

    $partograf = array();
    $partograf['obat'] = array();
    $partograf['tekanan']['nadi'] = array();
    $partograf['tekanan']['sys'] = array();
    $partograf['tekanan']['dias'] = array();
    $partograf['tekanan']['arrow'] = array();
    $partograf['pembukaan']['serviks'] = array();
    $partograf['pembukaan']['turunkepala'] = array();
    $partograf['denyutjantung'] = array();
    $partograf['waktu'] = array();
    $partograf['denyut'] = array();
    $partograf['airketuban'] = array();
    $partograf['penyusupan'] = array();
    $partograf['oksilosin'] = array();
    $partograf['tetesmenit'] = array();
    $partograf['suhu'] = array();
    $partograf['urinaseton'] = array();
    $partograf['urinprotein'] = array();
    $partograf['urinvolume'] = array();
    $partograf['kontraksi']['jml'] = array();
    $partograf['kontraksi']['mnt'] = array();
    $a = 0;

    $time = "00:00:00";
    $time_ref = array();
    for ($i = 0; $i < 32; $i++) {
      $res_time = date("H:i", strtotime($time));
      $time_ref[$res_time] = $i;
      $time = date("H:i:s", strtotime($time . " + 30 minute"));

      $partograf['tekanan']['nadi'][$i] = null;
      $partograf['tekanan']['sys'][$i] = null;
      $partograf['tekanan']['dias'][$i] = null;
      $partograf['tekanan']['arrow'][$i] = null;
      $partograf['pembukaan']['serviks'][$i] = null;
      $partograf['pembukaan']['turunkepala'][$i] = null;
      $partograf['denyutjantung'][$i] = null;
      $partograf['denyut'][$i] = null;
      $partograf['airketuban'][$i] = null;
      $partograf['penyusupan'][$i] = null;
      $partograf['oksilosin'][$i] = null;
      $partograf['tetesmenit'][$i] = null;
      $partograf['suhu'][$i] = null;
      $partograf['urinaseton'][$i] = null;
      $partograf['urinprotein'][$i] = null;
      $partograf['urinvolume'][$i] = null;
      $partograf['kontraksi']['jml'][$i] = null;
      $partograf['kontraksi']['mnt'][$i] = null;
    }



    $nadi_sub = array();
    foreach ($partograf['tekanan']['nadi'] as $i => $val) {
      $nadi_sub[$i] = $val;
    }

    $offset = 0;
    foreach ($det as $key => $item) {
      $times = strtotime($item->waktucatat);
      $times = round($times / (1800)) * 1800;
      $times = date("H:i", $times);

      $nadi_sub[$time_ref[$times]] = $item->p3_pembukaanserviks;
    }
    foreach ($nadi_sub as $item) {
      if (!empty($item)) {
        $offset = ($item - 4) * 2;
        break;
      }
    }

    foreach ($det as $key => $detParto) {

      $times = strtotime($detParto->waktucatat);
      $times = round($times / (1800)) * 1800;
      $times = date("H:i", $times);

      $obat = PemeriksaanpartografobatT::model()->findAll(" pemeriksaanpartografdet_id = '" . $detParto->pemeriksaanpartografdet_id . "' ");

      $point = $time_ref[$times] + $offset;

      foreach ($obat as $idx => $obat) {
        if ($key % 2 == 0) {
          $partograf['obat'][$key]['det'][$detParto->pemeriksaanpartografdet_id . $idx] = $obat->obatalkes->obatalkes_nama . " (" . $obat->obatalkes_jumlah . " " . $obat->obatalkes->satuankecil->satuankecil_nama . ")";
        } else {
          $partograf['obat'][$key - 1]['det'][$detParto->pemeriksaanpartografdet_id . $idx] = $obat->obatalkes->obatalkes_nama . " (" . $obat->obatalkes_jumlah . " " . $obat->obatalkes->satuankecil->satuankecil_nama . ")";
        }
      }

      $partograf['tekanan']['nadi'][$point] = $detParto->p6_nadi;
      $partograf['tekanan']['sys'][$point] = $detParto->p6_systolic;
      $partograf['tekanan']['dias'][$point] = $detParto->p6_diastolic;
      $partograf['tekanan']['arrow'][$point] = $detParto->p6_penyulit;

      $partograf['pembukaan']['serviks'][$point] = $detParto->p3_pembukaanserviks;
      $partograf['pembukaan']['turunkepala'][$point] = $detParto->p3_turunnyakepala;

      $partograf['denyutjantung'][$point] = $detParto->p1_djj_menit;
      if ($a % 2 == 0) {
        $partograf['waktu'][$key] = date("H:i", strtotime($detParto->p3_waktu));
      }
      $partograf['denyutjantung'][$point] = $detParto->p1_djj_menit;
      $partograf['denyut'][$point]['jumlah'] = $detParto->p1_djj_menit;
      $partograf['airketuban'][$point] = $detParto->p2_airketuban;
      $partograf['penyusupan'][$point] = $detParto->p2_penyusupan;
      $partograf['oksilosin'][$point] = $detParto->p5_oksitosin_unit;
      $partograf['tetesmenit'][$point] = $detParto->p5_tetes_menit;
      $partograf['suhu'][$point] = $detParto->p7_suhu;
      $partograf['urinaseton'][$point] = $detParto->p8_urin_aseton;
      $partograf['urinprotein'][$point] = $detParto->p8_urin_protein;
      $partograf['urinvolume'][$point] = $detParto->p8_urin_volume;
      $partograf['kontraksi']['jml'][$point] = $detParto->p4_kontraksi_jml;
      $partograf['kontraksi']['mnt'][$point] = $detParto->p4_kontraksi_lama_detik;
      $a++;
    }

    $this->render($this->path_view_rj . '_periksaDataPasien/_printPartograf', array(
      'persalinan' => $persalinan,
      'pendaftaran' => $pendaftaran,
      'pasien' => $pasien,
      'mod' => $mod,
      'det' => $det,
      'partograf' => $partograf,
      'admisi' => $admisi,
      'offset' => $offset,
    ));
  }



  public function actionRiwayatPelayanan($pendaftaran_id)
  {

    $this->layout = '//layouts/iframe';
    $sukses = 'tidak';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPengirim = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

    //var_dump($modFisik); die;

    $this->render('_riwayatPelayanan', array('modPengirim' => $modPengirim, 'modFisik' => $modFisik, 'modPendaftaran' => $modPendaftaran));
  }

  public function actionPrintDetailPartografBelakang($id)
  {
    $this->layout = '//layouts/printWindows';

    $persalinan = PersalinanT::model()->findByAttributes(array('pendaftaran_id' => $id));
    if (empty($persalinan)) {
      echo "Data Persalinan Tidak ada";
      Yii::app()->end();
    }
    $pendaftaran = PendaftaranT::model()->findByPk($id);
    $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

    $kala = PemeriksaankalaT::model()->findByAttributes(array(
      'persalinan_id' => $persalinan->persalinan_id,
    ));
    $periksaFisik = PemeriksaanfisikT::model()->findByPk($kala->pemeriksaanfisik_id);
    $kelahiran = KelahiranbayiT::model()->findByAttributes(array(
      'persalinan_id' => $persalinan->persalinan_id,
    ));
    if (empty($kelahiran)) {
      $kelahiran = new KelahiranbayiT;
    }

    $this->render($this->path_view_rj . '_periksaDataPasien/_printPartografBelakang', array(
      'persalinan' => $persalinan,
      'pendaftaran' => $pendaftaran,
      'pasien' => $pasien,
      'admisi' => $admisi,
      'kala' => $kala,
      'periksaFisik' => $periksaFisik,
      'kelahiran' => $kelahiran,
    ));
  }


  /**
   * Jawab konsul poli pasien
   * @param integer $konsulpoli_id
   */
  public function actionKonsultasiInternal($konsulpoli_id)
  {
    $this->layout = '//layouts/iframe';
    $model = RJKonsulPoliT::model()->findByPk($konsulpoli_id);
    $model->uraian_konsul = strip_tags($model->uraian_konsul);

    if (empty($model)) {
      echo "Pasien belum melakukan konsultasi poliklinik";
      Yii::app()->end();
    }

    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit', 'kelaspelayanan')->findByPk($model->pendaftaran_id);
    $modPasien = $modPendaftaran->pasien;
    $pasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modUraian = new RJPasienMorbiditasT();
    $modMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ));

    $model->tgljawabpoli = !empty($model->tgljawabpoli) ? $model->tgljawabpoli : date('d M Y H:i:s');
    if (!empty($model->pegawaikonsul_id)) {
      $model->nama_pegawai = PegawaiM::model()->findByPk($model->pegawaikonsul_id)->nama_pegawai;
    }

    $model->uraian_konsul = strip_tags($model->uraian_konsul);
    $model->uraian_konsul = html_entity_decode($model->uraian_konsul);
    $model->uraian_konsuljawaban = strip_tags($model->uraian_konsuljawaban);
    $model->uraian_konsuljawaban = html_entity_decode($model->uraian_konsuljawaban);


    // echo '<pre>'; var_dump($modKonsulPoli->uraiankonsul, $modKonsulPoli->uraiankonsuljawaban); die;


    if (isset($_POST['RJKonsulPoliT'])) {
      $sukses = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['RJKonsulPoliT'];
        $model->uraian_konsul = isset($_POST['RJKonsulPoliT']['uraian_konsul']) ? $_POST['RJKonsulPoliT']['uraian_konsul'] : '';
        $model->uraian_konsuljawaban = isset($_POST['RJKonsulPoliT']['uraian_konsuljawaban']) ? $_POST['RJKonsulPoliT']['uraian_konsuljawaban'] : '';

        if ($model->save()) {

          if (isset($_POST['RJPasienMorbiditasT'])) {
            foreach ($_POST['RJPasienMorbiditasT'] as $key => $val) {
              if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "") {
                $insert = new RJPasienMorbiditasT();
                $insert->attributes = $val;
                $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
                $insert->kelompokumur_id = $modPasien->kelompokumur_id;
                $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
                $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $insert->kasusdiagnosa = $val['kasusdiagnosa'];
                $insert->pasien_id = $modPendaftaran->pasien_id;
                $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $insert->pegawai_id = $val['pegawai_id'];
                $insert->$golUmur = 1;
                if ($insert->save()) {
                  $sukses &= true;
                } else {
                  $sukses &= false;
                }
              }
            }
          }
        } else {
          $sukses &= false;
        }

        if ($sukses) {
          $transaction->commit();

          $ruangan_id = "";
          $daftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);

          if (!empty($daftar->pasienadmisi_id)) {
            $admisiMod = PasienadmisiT::model()->findBypk($daftar->pasienadmisi_id);
            $ruangan_id = (isset($admisiMod) ? $admisiMod->ruangan_id : "");
          } else {
            $ruangan_id = (isset($daftar) ? $daftar->ruangan_id : "");
          }

          if (!empty($ruangan_id)) {
            $ruanganMod = RuanganM::model()->findByPk($ruangan_id);
            $ruangKonsul = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

            if (isset($ruanganMod)) {
              $judul = 'Pasien Konsultasi Internal';
              $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' Telah melakukan konsultasi Internal di ' . $ruangKonsul->ruangan_nama . ' pada ' . $model->tgljawabpoli;
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $ruanganMod->instalasi_id, 'ruangan_id' => $ruanganMod->ruangan_id, 'modul_id' => $ruanganMod->modul_id),
              ));
            }
          }

          Yii::app()->user->setFlash('success', "Data berhasil update");
          $this->redirect(array('KonsultasiInternal', 'konsulpoli_id' => $konsulpoli_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('danger', "Data tidak berhasil update");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('konsultasiInternal/index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
      'pasienMorbiditas' => $pasienMorbiditas,
      'modUraian' => $modUraian,
      'modMorbiditas' => $modMorbiditas,
    ));
  }





  public function actionTindakanInternal($ruangtindakan_id)
  {
    $this->layout = '//layouts/iframe';
    $model = RJRuangTindakan::model()->findByPk($ruangtindakan_id);

    if (empty($model)) {
      echo "Pasien belum melakukan konsultasi tindakan";
      Yii::app()->end();
    }

    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit', 'kelaspelayanan')->findByPk($model->pendaftaran_id);
    $modPasien = $modPendaftaran->pasien;
    $pasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modUraian = new RJPasienMorbiditasT();
    $modMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ));

    $model->tgljawabordertindakan = !empty($model->tgljawabordertindakan) ? $model->tgljawabordertindakan : date('d M Y H:i:s');
    if (!empty($model->pegawaikonsul_id)) {
      $model->nama_pegawai = PegawaiM::model()->findByPk($model->pegawaikonsul_id)->nama_pegawai;
    }

    if (isset($_POST['RJRuangTindakan'])) {
      $sukses = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['RJRuangTindakan'];

        if ($model->save()) {
          if (isset($_POST['RJPasienMorbiditasT'])) {
            foreach ($_POST['RJPasienMorbiditasT'] as $key => $val) {
              if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "") {
                $insert = new RJPasienMorbiditasT();
                $insert->attributes = $val;
                $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
                $insert->kelompokumur_id = $modPasien->kelompokumur_id;
                $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
                $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $insert->kasusdiagnosa = $val['kasusdiagnosa'];
                $insert->pasien_id = $modPendaftaran->pasien_id;
                $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $insert->pegawai_id = $val['pegawai_id'];
                $insert->ppds_id = $val['ppds_id'];

                $insert->$golUmur = 1;
                if ($insert->save()) {
                  $sukses &= true;
                } else {
                  $sukses &= false;
                }
              }
            }
          }
        } else {
          $sukses &= false;
        }

        if ($sukses) {
          $transaction->commit();

          $ruangan_id = "";
          $daftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);

          if (!empty($daftar->pasienadmisi_id)) {
            $admisiMod = PasienadmisiT::model()->findBypk($daftar->pasienadmisi_id);
            $ruangan_id = (isset($admisiMod) ? $admisiMod->ruangan_id : "");
          } else {
            $ruangan_id = (isset($daftar) ? $daftar->ruangan_id : "");
          }

          if (!empty($ruangan_id)) {
            $ruanganMod = RuanganM::model()->findByPk($ruangan_id);
            $ruangKonsul = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

            if (isset($ruanganMod)) {
              $judul = 'Pasien Tindakan Internal';
              $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' Telah melakukan Tindakan Internal di ' . $ruangKonsul->ruangan_nama . ' pada ' . $model->tgljawabpoli;
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $ruanganMod->instalasi_id, 'ruangan_id' => $ruanganMod->ruangan_id, 'modul_id' => $ruanganMod->modul_id),
              ));
            }
          }

          Yii::app()->user->setFlash('success', "Data berhasil update");
          $this->redirect(array('TindakanInternal', 'ruangtindakan_id' => $ruangtindakan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('danger', "Data tidak berhasil update");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('tindakanInternal/index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
      'pasienMorbiditas' => $pasienMorbiditas,
      'modUraian' => $modUraian,
      'modMorbiditas' => $modMorbiditas,
    ));
  }



  /**
   * Untuk cek golongan umur
   * @param type $idGolonganUmur
   */
  private function cekGolonganUmur($idGolonganUmur)
  {
    switch ($idGolonganUmur) {
      case 1:
        return 'umur_5_14thn';
      case 2:
        return 'umur_15_24thn';
      case 3:
        return 'umur_25_44thn';
      case 4:
        return 'umur_45_64thn';
      case 5:
        return 'umur_65';
      case 9:
        return 'umur_65';
      case 10:
        return 'umur_65';
      case 6:
        return 'umur_0_28hr';
      case 7:
        return 'umur_28hr_1thn';
      case 8:
        return 'umur_1_4thn';
      default:
          break;
    }
  }

  public function actionVerifikasiTindakLanjut()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }


    $ok = 1;
    $msg = "";
    $id = $_POST['id'];

    $is_confirm = 0;
    $is_notif = 0;

    $reseptur = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'condition' => 'penjualanresep_id is null',
      'order' => 'tglreseptur asc',
    ));

    // ============= Pemeriksaan belum diapprove di lab/rad ===========
    $kirim = PasienkirimkeunitlainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
      'instalasi_id' => array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_REHAB),
    ), array(
      'condition' => 'tglrencanapemeriksaan is null',
    ));

    if (count($kirim) > 0 || count($reseptur) > 0) {
      $ok = 0;
      $is_notif = 1;

      $grup_kirim = array(
        Params::INSTALASI_ID_LAB => array(
          'nama'=>'Pemeriksaan Laboratorium',
          'detail'=>array(),
        ),
        Params::INSTALASI_ID_RAD => array(
          'nama'=>'Pemeriksaan Radiologi',
          'detail'=>array(),
        ),
        Params::INSTALASI_ID_IBS => array(
          'nama'=>'Tindakan Bedah',
          'detail'=>array(),
        ),
        Params::INSTALASI_ID_REHAB => array(
          'nama'=>'Tindakan Fisioterapi',
          'detail'=>array(),
        ),
      );

      foreach ($kirim as $item) {
        $grup_kirim[$item->instalasi_id]['detail'][] = $item;
      }

      $msg = $this->renderPartial($this->path_view."_notifPenunjang", array(
        'grup_kirim'=>$grup_kirim, 'reseptur'=>$reseptur
      ), true);

      goto outs;
    }


    // ============= Pemeriksaan belum di di-set tgl rencana



    /*
    // ============= Pemeriksaan belum muncul di modul lab/rad ========
    $penunjang = PasienmasukpenunjangT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
      'ruangan_id' => array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD),
    ));


    $is_lab = false;
    $is_rad = false;

    foreach ($penunjang as $item) {
      if ($item->ruangan_id == Params::RUANGAN_ID_RAD) {
        $criRad = new CDbCriteria();
        $criRad->addCondition(" pendaftaran_id = '" . $item->pendaftaran_id . "' AND pasienmasukpenunjang_id = '" . $item->pasienmasukpenunjang_id . "' ");
        $criRad->addCondition(" (statusperiksahasil = '" . Params::STATUSPERIKSAHASIL_BELUM . "') OR (statusperiksahasil IS NULL)  ");
        $rad = HasilpemeriksaanradT::model()->findAll($criRad);

        if (count((array)$rad) > 0) {
          $ok = 0;
          $is_rad = true;
        }
      } else if ($item->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
        $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
          'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id
        ));

        if (!empty($hasil) || $hasil->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM) {
          $ok = 0;
          $is_lab = true;
        }
      }
    }

    if ($is_lab || $is_rad) {
      $ruangan = array();
      if ($is_lab) {
        $ruangan[] = "Laboratorium";
      }
      if ($is_rad) {
        $ruangan[] = "Radiologi";
      }

      $ok = 0;
      $msg = "Belum ada hasil pemeriksaan pada " . (implode(" dan ", $ruangan)) . ". Anda yakin untuk melanjutkan ?";
      $is_confirm = 1;

      goto outs;
    }
    */




    /*
    if (count((array)$reseptur) > 0) {
      $is_belum = false;
      foreach ($reseptur as $item) {
        $pen = PenjualanresepT::model()->findByAttributes(array(
          'reseptur_id' => $item->reseptur_id
        ));
        if (empty($pen)) {
          $is_belum = true;
          break;
        }
      }

      if ($is_belum) {
        $ok = 0;
        $msg = "Pasien memiliki reseptur yang belum diverifikasi. Silahkan lakukan penjualan terlebih dahulu.";
        
        goto outs;
      }
    }
    // */

    /*
    $tindakanBelumBayar = TindakanpelayananT::model()->findByAttributes(array(
      'pendaftaran_id'=>$id,
    ), array(
      'condition'=>'tindakansudahbayar_id is null and qty_tindakan <> 0 and tarif_satuan > 0'
    ));

    $obatBelumBayar = ObatalkespasienT::model()->findByAttributes(array(
      'pendaftaran_id'=>$id,
    ), array(
      'condition'=>'oasudahbayar_id is null and qty_oa <> 0 and hargasatuan_oa > 0'
    ));

    if (!empty($tindakanBelumBayar) || !empty($obatBelumBayar)) {
      $ok = 0;
      $msg = "Pasien Belum Melakukan Pembayaran Rawat Jalan. Silahkan Melakukan Pembayaran Terlebih Dahulu";
    }
    // */






    outs:
    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'is_confirm' => $is_confirm, 'is_notif'=>$is_notif));
  }


  public function actionVerifikasiAntrian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pendaftaran_id = ($_POST['pendaftaran_id']);
      $modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);

      $modPendaftaran->waktuverifikasipasien = date('Y-m-d H:i:s');
      if (!empty($modPendaftaran->waktupanggilpasien)) {
        if ($modPendaftaran->update()) {
          if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) {
            $penSelesaiPeriksa = PendaftaranT::model()->findByPk($pendaftaran_id);
            $findWaktu = WaktutunggupelayananT::model()->findByAttributes(array('pendaftaran_id' => $penSelesaiPeriksa->pendaftaran_id, 'task_id' => '4'));

            $kodebooking = $penSelesaiPeriksa->no_pendaftaran;

            if (!empty($penSelesaiPeriksa->buatjanjipoli_id)) {
              $buatjanjipoli = BuatjanjipoliT::model()->findByPk($penSelesaiPeriksa->buatjanjipoli_id);

              if (!empty($buatjanjipoli)) {
                $kodebooking = $buatjanjipoli->no_buatjanji;
              }
            }

            if (empty($findWaktu)) {
              $waktutunggupelayanan = new WaktutunggupelayananT();
              $waktutunggupelayanan->pendaftaran_id = $penSelesaiPeriksa->pendaftaran_id;
              $waktutunggupelayanan->pasien_id = $penSelesaiPeriksa->pasien_id;
              $waktutunggupelayanan->task_id = 4;
              $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
              $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
              $waktutunggupelayanan->tanggal = date('Y-m-d H:i:s');
              $waktutunggupelayanan->kode_booking = $kodebooking;
              $waktutunggupelayanan->statuskirim = 0;
              $waktutunggupelayanan->create_time = date('Y-m-d H:i:s');
              $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
              $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
              $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s');

              $antrianonlinebpjs = new AntrianOnlineBpjs();
              $body = array(
                "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
              );
              $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

              if (
                !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
              ) {
                $waktutunggupelayanan->statuskirim = 1;
                $waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
                $waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
              } else {
                $waktutunggupelayanan->statuskirim = 0;
                $waktutunggupelayanan->response_list = $response['metaData']['message'];
              }
              $waktutunggupelayanan->save();
            }
          }

          $data['pesan'] = "";
        } else {
          $data['pesan'] = "Verifikasi gagal dilakukan";
        }
      } else {
        $data['pesan'] = "Antrian belum dilakukan pemanggilan";
      }

      echo CJSON::encode($data);
      Yii::app()->end();
    } else {
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
  }


  public function actionVerifikasiAnamnesa()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];
    $ok = 1;

    $peg_id = Yii::app()->user->getState('pegawai_id');

    if (!empty($peg_id)) {
      AnamnesaT::model()->updateByPk($id, array(
        'dokterverifikasi_id' => $peg_id,
      ));
    } else {
      $ok = 0;
    }

    echo CJSON::encode(array('ok' => $ok));
  }

  public function actionDetailOperasi($id)
  {
    $this->layout = '//layouts/iframe';
    $rencana = RencanaoperasiT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'tglrencanaoperasi asc',
    ));

    if (count((array)$rencana) == 0) {
      echo "Data tidak ditemukan";
      Yii::app()->end();
    }

    $penunjang = array();
    foreach ($rencana as $item) {
      $idp = $item->pasienmasukpenunjang_id;
      if (empty($penunjang[$idp])) {
        $penunjang_data = PasienmasukpenunjangV::model()->findByAttributes(array(
          'pasienmasukpenunjang_id' => $idp
        ));
        $penunjang[$idp] = array(
          'data' => $penunjang_data,
          'rencana' => array(),
        );
      }

      $penunjang[$idp]['rencana'][] = $item;
    }

    $this->render('rawatJalan.views._periksaDataPasien._operasi2', array(
      'penunjang' => $penunjang,
    ));
  }

  public function actionDetailGizi($id)
  {
    $this->layout = '//layouts/iframe';
  }

  public function actionDetailMCU($id)
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran = PendaftaranT::model()->findByPk($id);

    $this->render('rawatJalan.views._periksaDataPasien._riwayatMCU', array(
      'pendaftaran' => $pendaftaran,
    ));
  }

  public function actionDetailMCUDetail($id, $submenu)
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran = PendaftaranT::model()->findByPk($id);
    $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);

    if ($submenu == 'periksaUmum') {

      $umums = McuPemeriksaanumumT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tgl_pemeriksaan asc',
      ));

      if (count((array)$umums) == 0) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }

      $this->render('rawatJalan.views._periksaDataPasien.mcu._umum', array(
        'modPendaftaran' => $pendaftaran,
        'modPasien' => $pasien,
        'umums' => $umums,
      ));
    } else if ($submenu == 'jantung') {

      $format = new MyFormatter();
      $modPemeriksaanjantung = McuPemeriksaanjantungT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tgl_pemeriksaan desc',
      ));


      if (empty($modPemeriksaanjantung)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }

      $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modPemeriksaanjantung->dokterpemeriksa_id));

      $this->render('rawatJalan.views._periksaDataPasien.mcu._jantung', array(
        'model' => $modPemeriksaanjantung,
        'format' => $format,
        'modPegawai' => $modPegawai,
        'modPasien' => $pasien

      ));
    } else if ($submenu == 'kandungan') {

      $model = McuPemeriksaankandunganT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tgl_pemeriksaan desc',
      ));

      if (empty($model)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }

      $this->render('rawatJalan.views._periksaDataPasien.mcu._kandungan', array(
        'modPendaftaran' => $pendaftaran,
        'modPasien' => $pasien,
        'model' => $model,
      ));
    } else if ($submenu == 'lainLain') {

      $format = new MyFormatter();
      $modMcuPemeriksaanlainlain = McuPemeriksaanlainlainT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tgl_pemeriksaan desc',
      ));

      if (empty($modMcuPemeriksaanlainlain)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }


      $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modMcuPemeriksaanlainlain->dokterpemeriksa_id));
      $this->render('rawatJalan.views._periksaDataPasien.mcu._lainlain', array(
        'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
        'format' => $format,
        'modPegawai' => $modPegawai

      ));
    } else if ($submenu == 'treadmill') {

      $format = new MyFormatter;
      $modTreadmill = TreadmillT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tgltreadmill desc',
      ));

      if (empty($modTreadmill)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }


      $modTreadmillDetail = TreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $modTreadmill->treadmill_id));

      $judul_print = 'TREADMILL EXCERCISE TEST (' . $modTreadmill->pasien->jeniskelamin . ')';

      $this->render('rawatJalan.views._periksaDataPasien.mcu._treadmill', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modTreadmill' => $modTreadmill,
        'modTreadmillDetail' => $modTreadmillDetail,
        'modPasien' => $pasien,
        'modPendaftaran' => $pendaftaran,
        'caraPrint' => ''
      ));
    } else if ($submenu == 'hearingTest') {

      $format = new MyFormatter;
      $modHearingTest = HearingtestT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tglhearingtest desc',
      ));

      if (empty($modHearingTest)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }

      $judul_print = 'FORMULIR PEMERIKSAAN AUDIOMETRI';
      $caraPrint = null;

      $this->render('rawatJalan.views._periksaDataPasien.mcu._hearing', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modHearingTest' => $modHearingTest,
        'modPasien' => $pasien,
        'modPendaftaran' => $pendaftaran,
        'caraPrint' => $caraPrint
      ));
    } else if ($submenu == 'koroner') {

      $format = new MyFormatter;
      $modJantungKoroner = JantungkoronerT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tglhitungresiko desc',
      ));

      if (empty($modJantungKoroner)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }

      $judul_print = 'ANALISA RESIKO KORONER';
      $caraPrint = null;

      $this->render('rawatJalan.views._periksaDataPasien.mcu._koroner', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modJantungKoroner' => $modJantungKoroner,
        'modPasien' => $pasien,
        'modPendaftaran' => $pendaftaran,
        'caraPrint' => $caraPrint
      ));
    } else if ($submenu == 'spirometri') {

      $modPemeriksaanFisik = McuPemeriksaanumumT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'mcu_pemeriksaanumum_id desc',
      ));

      if (empty($modPemeriksaanFisik)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }

      $model = SpirometriT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ));

      if (!empty($model->pengetahui_id)) {
        $peg = PegawaiM::model()->findByPk($model->pengetahui_id);

        $model->mengetahui_nama = $peg->namaLengkap;
      }

      foreach ($model->metadata->tableSchema->columns as $columnName => $column) {
        if ($column->dbType == "double precision" && !empty($model->$columnName)) {
          $model->$columnName = number_format($model->$columnName, 2, ',', '');
        }
      }

      $model->spirometri_tgl = MyFormatter::formatDateTimeForUser($model->spirometri_tgl);

      $this->render('rawatJalan.views._periksaDataPasien.mcu._spirometri', array(
        'model' => $model,
        'modPendaftaran' => $pendaftaran,
        'modPemeriksaanFisik' => $modPemeriksaanFisik,
      ));
    } else if ($submenu == 'kesimpulan') {

      $format = new MyFormatter;
      $ModKesimpulanMCU = KesimpulanmcuT::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
      ), array(
        'order' => 'tgl_kesimpulanmcu desc',
      ));


      if (empty($ModKesimpulanMCU)) {
        echo "Data tidak ditemukan";
        Yii::app()->end();
      }

      $modPemeriksaanFisik = AsesmenAwalMedisT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id));
      $modPeriksaKacamata = PeriksakacamataT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
      $modHearingTest = HearingtestT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
      $modHasilPemeriksaanRad = HasilpemeriksaanradT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'create_time ASC'));
      $modTreadMill = TreadmillT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
      $modJantungKoroner = JantungkoronerT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'create_time DESC'));
      $modPasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'create_time ASC'));
      $modHasilPemeriksaanLab = HasilpemeriksaanlabT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id), array('order' => 'create_time ASC'));

      if (count((array)$modHasilPemeriksaanLab) > 0) {
        //$modHasilPemeriksaanLabDetail = MCDetailHasilPemeriksaanLabT::model()->findAllByAttributes(array('pemeriksaanlab_id'=>$modHasilPemeriksaanLab->pemeriksaanlab_id));
        $modHasilPemeriksaanLabDetail = null;
      } else {
        $modHasilPemeriksaanLabDetail = null;
      }

      $modKunjungan = PasienmasukpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id));
      $idLab = array();
      $idRad = array();
      if (!empty($modKunjungan)) {
        foreach ($modKunjungan as $d) {
          if ($d->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
            $idLab[] = $d->pasienmasukpenunjang_id;
          }

          if ($d->ruangan_id == Params::RUANGAN_ID_RAD) {
            $idRad[] = $d->pasienmasukpenunjang_id;
          }
        }
      }


      $criLab = new CDbCriteria();
      $criLab->addInCondition(" pasienmasukpenunjang_id ", $idLab);
      $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findAll($criLab);
      $modDetailHasilPemeriksaans = array();
      if (!empty($modHasilPemeriksaan)) {
        $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaansMCU($modHasilPemeriksaan);
      }
      $data = array();
      if (count((array)$modDetailHasilPemeriksaans) > 0) {
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
      }


      $judul_print = 'Medical Check Up';
      $this->render('rawatJalan.views._periksaDataPasien.mcu._kesimpulan', array(
        'format' => $format,
        'ModKesimpulanMCU' => $ModKesimpulanMCU,
        'modPendaftaran' => $pendaftaran,
        'modPasien' => $pasien,
        'judul_print' => $judul_print,
        'modPemeriksaanFisik' => $modPemeriksaanFisik,
        'modPeriksaKacamata' => $modPeriksaKacamata,
        'modHearingTest' => $modHearingTest,
        'modHasilPemeriksaanRad' => $modHasilPemeriksaanRad,
        'modTreadMill' => $modTreadMill,
        'modJantungKoroner' => $modJantungKoroner,
        'modPasienMorbiditas' => $modPasienMorbiditas,
        'modHasilPemeriksaanLabDetail' => $modHasilPemeriksaanLabDetail,
        'data' => $data
      ));
    } else if ($submenu == 'laboratorium') {
      $format = new MyFormatter();
      $judulLaporan = "Hasil Pemeriksaan Laboratorium";
      //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
      $modKunjungan = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK));

      if (empty($modKunjungan)) {
        echo "Pemeriksaan Laboratorium tidak ditemukan";
        Yii::app()->end();
      }

      $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modKunjungan->pasienmasukpenunjang_id));
      //var_dump($modHasilPemeriksaan->pasien_id);die;
      $modDetailHasilPemeriksaans = $this->loadHasilPemeriksaansLABMCU($modHasilPemeriksaan);

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

      $this->render('rawatJalan.views._periksaDataPasien.mcu._lab', array(
        'format' => $format,
        'modKunjungan' => $modKunjungan,
        'modHasilPemeriksaan' => $modHasilPemeriksaan,
        'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
        'judulLaporan' => $judulLaporan,
        'caraPrint' => null,
        'data' => $data
      ));
    } else if ($submenu == 'radiologi') {
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

      $this->render('rawatJalan.views._periksaDataPasien.mcu._rad', array(
        'detailHasil' => $detailHasil,
        'masukpenunjang' => $modPasienMasukPenunjang,
        'pemeriksa' => $pemeriksa,
        'detailHasil' => $detailHasil
      ));
    }
  }

  /**
   * load LBDetailHasilPemeriksaanLabT
   * @param type $modHasilPemeriksaan
   */
  public function loadHasilPemeriksaansLABMCU($modHasilPemeriksaan)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "
                            JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
                            JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                            JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = DetailhasilpemeriksaanlabT::model()->findAll($criteria);
    return $modDetailHasilPemeriksaans;
  }

  /**
   * digunakan untuk mengenerate data detail hasil pemeriksaan lab
   * @param type $modHasilPemeriksaan
   * @return type
   */
  public function loadDetailHasilPemeriksaansMCU($modHasilPemeriksaan)
  {

    $idhasil = array();
    foreach ($modHasilPemeriksaan as $d) {
      $idhasil[] = $d->hasilpemeriksaanlab_id;
    }

    $criteria = new CDbCriteria();
    $criteria->join = "                        
                        LEFT JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
			LEFT JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id  
                        LEFT JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        LEFT JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addInCondition('t.hasilpemeriksaanlab_id', $idhasil);
    $criteria->order = "jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    //$criteria->order = "pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = DetailhasilpemeriksaanlabT::model()->findAll($criteria);

    return $modDetailHasilPemeriksaans;
  }

  /**
   * digunakan untuk mengenerate data detail hasil pemeriksaan lab
   * @param type $modHasilPemeriksaan
   * @return type
   */
  public function loadDetailHasilPemeriksaansLab($modHasilPemeriksaan)
  {

    $idhasil = $modHasilPemeriksaan->hasilpemeriksaanlab_id;

    $criteria = new CDbCriteria();
    $criteria->join = "                        
                        LEFT JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
			LEFT JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id  
                        LEFT JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        LEFT JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->compare('t.hasilpemeriksaanlab_id', $idhasil);
    $criteria->order = "jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    //$criteria->order = "pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = DetailhasilpemeriksaanlabT::model()->findAll($criteria);

    return $modDetailHasilPemeriksaans;
  }

  public function actionDetailRehab($id)
  {
    $this->layout = '//layouts/iframe';
    $hasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'order' => 'tglpemeriksaanrm asc',
    ));

    if (count((array)$hasil) == 0) {
      echo "Data tidak ditemukan";
      Yii::app()->end();
    }

    $penunjang = array();
    foreach ($hasil as $item) {
      $idp = $item->pasienmasukpenunjang_id;
      if (empty($penunjang[$idp])) {
        $penunjang_data = PasienmasukpenunjangV::model()->findByAttributes(array(
          'pasienmasukpenunjang_id' => $idp
        ));
        $penunjang[$idp] = array(
          'data' => $penunjang_data,
          'hasil' => array(),
        );
      }

      $penunjang[$idp]['hasil'][] = $item;
    }

    $this->render('rawatJalan.views._periksaDataPasien._riwayatRehab', array(
      'penunjang' => $penunjang,
    ));
  }

  public function actionDetailKeperawatanJiwa($id)
  {
    $this->layout = '//layouts/iframe';

    $model = PengkajiankeperawatanjiwaT::model()->findByAttributes(array(
      'pendaftaran_id' => $id
    ));

    if (empty($model)) {
      echo "Pengkajian Keperawatan Jiwa Pasien tidak ditemukan.";
      Yii::app()->end();
    }

    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $model->tgl_pengkajian = MyFormatter::formatDateTimeForUser($model->tgl_pengkajian);

    if (!$model->prediosposisi_anggotakeluraga_gangguan) {
      $model->prediosposisi_anggotakeluraga_gangguan = 0;
    }
    if (!$model->prediosposisi_gangunajiwa_masalalu) {
      $model->prediosposisi_gangunajiwa_masalalu = 0;
    }

    foreach ($model->jsonColumn as $attr) {
      $model->$attr = CJSON::decode($model->$attr);
    }

    $this->path_view = "rawatJalan.views.keperawatanJiwa.";

    $this->render($this->path_view . 'print', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien
    ));
  }

  public function actionVclaimCekRuangan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    // $nosep = $_POST['nosep'];
    if (isset($_POST['nosep'])) {
      $nosep = $_POST['nosep'];
    } else {
      $sep_id = $_POST['sep_id'];
      $sep = SepT::model()->findByPk($sep_id);
      $nosep = $sep->nosep;
    }

    $ruangan_id = $_POST['ruangan_id'];
    $tanggal = MyFormatter::formatDateTimeForDB($_POST['tgl']);
    $dokter = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
    $html = '<option value="">-- Pilih --</option>';

    $ruangan = RuanganM::model()->findByPk($ruangan_id);
    $tanggal2 = date('Y-m-d', strtotime($tanggal));


    $no_kartu = empty($nosep) ? "0000000000000000000" : $nosep;
    $ruangan = $ruangan->kode_bpjs;
    $is_hemo = false;

    if ($ruangan == "HDL") {
      $is_hemo = true;
      $ruangan = "INT";
    }

    if (empty($no_kartu) || empty($ruangan)) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'No. SEP atau Ruangan tidak ditemukan',
        'html' => $html,
        'judul' => "Pengecekan Ruangan",
      ));
      Yii::app()->end();
    }


    $bpjs = new Bpjs_Vklaim;
    $res = $bpjs->search_spesialtik_kontrol(2, $no_kartu, $tanggal2);

    $res_json = CJSON::decode($res);

    if (!$res || !isset($res_json['response'])) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Terjadi kesalahan dalam pengecekan Ruangan VClaim',
        'html' => $html,
        'judul' => "Pengecekan Ruangan.",
      ));
      Yii::app()->end();
    }




    $res_json = CJSON::decode($res);
    
    if ($res_json['metaData']['code'] != 200) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => $res_json['metaData']['message'],
        'html' => $html,
        'judul' => "Pengecekan Ruangan..",
      ));
      Yii::app()->end();
    }



    $is_ada = false;
    $modSep = SepT::model()->findByAttributes(array('nosep' => $nosep));
    $modPegawai = PegawaiM::model()->findByAttributes(array('kodedokter_bpjs' => $modSep->kode_dpjp));
    $jadwalDokter = JadwaldokterM::model()->findByAttributes(array('pegawai_id' => $modPegawai->pegawai_id));
    
    // $data_sep = CJSON::decode($bpjs->search_rujukan_no_rujukan($modSep->norujukan));
    // $poli_sep = $data_sep['response']['rujukan']['poliRujukan']['kode'];
    if (empty($modSep->politujuan) || $modSep->politujuan == '') {
      if (!empty($jadwalDokter)) {
        $modSep->politujuan = $jadwalDokter->ruangan->kode_bpjs;
      }
    }
    foreach ($res_json['response']['list'] as $item) {
      if ($modSep->politujuan == $item['kodePoli']) {
        $is_ada = true;

        if ($item['jmlRencanaKontroldanRujukan'] == $item['kapasitas']) {
          echo CJSON::encode(array(
            'ok' => 0,
            'msg' => "Kapasitas Jumlah Pasien Rencana Kontrol Poliklinik  Pasien BPJS sudah penuh, silahkan pilih tanggal lain",
            'html' => $html,
            'judul' => "Pengecekan Ruangan...",
          ));
          Yii::app()->end();
        }

        break;
      }else if ($ruangan == $item['kodePoli']  ){
        $is_ada = true;
        $modSep->politujuan = $ruangan;

        if ($item['jmlRencanaKontroldanRujukan'] == $item['kapasitas']) {
          echo CJSON::encode(array(
            'ok' => 0,
            'msg' => "Kapasitas Jumlah Pasien Rencana Kontrol Poliklinik  Pasien BPJS sudah penuh, silahkan pilih tanggal lain",
            'html' => $html,
            'judul' => "Pengecekan Ruangan...",
          ));
          Yii::app()->end();
        }

        break;
      }
    }

    // var_dump($ruangan, $res_json); die;

    if (!$is_ada) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => "Ruangan kontrol tidak ditemukan.",
        'html' => $html,
        'judul' => "Pengecekan Ruangan....",
      ));
      Yii::app()->end();
    }

    if ($is_hemo) {
      $config = KonfigsystemK::model()->find();
      if ($config->tipe_bridging == 1) {
        $query = "1/tglPelayanan/" . $tanggal2 . "/Spesialis/" . $ruangan;
      } else {
        $query = "1/" . $tanggal2 . "/" . $ruangan;
      }

      $res = $bpjs->search_dpjp($query, 1, 10);
      // var_dump(CJSON::decode($res)); die;
    } else {
      $res = $bpjs->search_jadwal_dokter_kontrol(2, $modSep->politujuan, $tanggal2);
    }

    if (!$res) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Terjadi kesalahan dalam pengecekan Jadwal Dokter VClaim',
        'html' => $html,
      ));
      Yii::app()->end();
    }



    $res_json = CJSON::decode($res);
   
    if ($res_json['metaData']['code'] != 200) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => $res_json['metaData']['message'],
        'html' => $html,
        'judul' => "Pengecekan Dokter",
      ));
      Yii::app()->end();
    }

    $is_ada = false;


    $peg_list = array();
    foreach ($res_json['response']['list'] as $item) {

      if ($is_hemo) {

        $peg = PegawaiM::model()->findByAttributes(array(
          'kodedokter_bpjs' => $item['kode'],
        ));

        if (empty($peg)) {
          continue;
        }

        if (in_array($peg->pegawai_id, $peg_list)) {
          continue;
        }
      } else {
        if ($item['kapasitas'] == 0) {
          continue;
        }

        $peg = PegawaiM::model()->findByAttributes(array(
          'kodedokter_bpjs' => $item['kodeDokter'],
        ));

        if (empty($peg)) {
          continue;
        }

        if (in_array($peg->pegawai_id, $peg_list)) {
          continue;
        }
      }


      $peg_list[] = $peg->pegawai_id;

      $html .= '<option value="' . $peg->pegawai_id . '"' . ($peg->pegawai_id == $dokter ? "selected" : null) . '>' . $peg->namaLengkap . '</option>';

      //var_dump($item);
    }

    echo CJSON::encode(array(
      'ok' => 1,
      'html' => $html,
      'judul' => '',
    ));
  }

  public function actionPrintRencanaKontrol($id = null)
  {
    //$this->layout='//layouts/iframe';

    $modPendaftaran = RJPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
    $model = SuratketeranganR::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
    //$judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => $_GET['pendaftaran_id']));
    $judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => $model->jenissurat_id));
    $judul2 = ' Data SK Rencana Kontrol pasien';
    // $modPasien = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
    $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id' => $modPendaftaran->ruangankontrol_id));
    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $_GET['pendaftaran_id'], 'kelompokdiagnosa_id' => 2,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id')
    ));
    if (isset($modMorbiditas)) {
      $modDiagnosa = DiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modMorbiditas->diagnosa_id));
    } else {
      $modDiagnosa = array();
    }

    $modTambahan = PasienmorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $_GET['pendaftaran_id'], 'kelompokdiagnosa_id' => 3,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id')
    ));




    // foreach($modDiagnosaTambahan as $diagnosa){
    //     echo print_r($diagnosa->diagnosa_nama).exit();
    // }
    //echo print_r($modDiagnosaTambahan).exit();


    $judulLaporan = '';
    $caraPrint = $_REQUEST['caraPrint'];
    $file = "rawatJalan.views.daftarPasien.PrintRencanaKonsul";

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        $file,
        array(
          'modPendaftaran' => $modPendaftaran,
          'judul' => $judul,
          'judul2' => $judul2,
          'caraPrint' => $caraPrint,
          'model' => $model,
          'modPasien' => $modPasien,
          'modRuangan' => $modRuangan,
          'judulLaporan' => $judulLaporan,
          'modDiagnosa' => $modDiagnosa,
          'modTambahan' => $modTambahan,
          'modPegawai' => $modPegawai
        )
      );
    }
  }

  public function actionPrintRencanaKontrolBpjs($id = null)
  {
    //$this->layout='//layouts/iframe';

    $modPendaftaran = RJPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
    $model = SuratketeranganR::model()->findByAttributes(array(
      'pendaftaran_id' => $_GET['pendaftaran_id'],
      'jenissurat_id' => 2,
    ), array(
      'order' => 'suratketerangan_id desc',
    ));
    if (empty($model)) {
      echo 'Surat Keterangan Rencana Kontrol Belum Ada';
      exit;
    }
    $judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => $model->jenissurat_id));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id' => $modPendaftaran->ruangankontrol_id));
    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $_GET['pendaftaran_id'], 'kelompokdiagnosa_id' => 2,
      'ruangan_id' => $modPendaftaran->ruangan_id
    ));
    // var_dump($modMorbiditas);
    if (isset($modMorbiditas)) {
      $modDiagnosa = DiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modMorbiditas->diagnosa_id));
    } else {
      $modDiagnosa = null;
    }

    $modTambahan = PasienmorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $_GET['pendaftaran_id'], 'kelompokdiagnosa_id' => 3,
      'ruangan_id' => $modPendaftaran->ruangan_id
    ));




    // foreach($modDiagnosaTambahan as $diagnosa){
    //     echo print_r($diagnosa->diagnosa_nama).exit();
    // }
    //echo print_r($modDiagnosaTambahan).exit();


    $judulLaporan = '';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('rawatJalan.views.daftarPasien.PrintRencanaKonsulSRK', array(
        'modPendaftaran' => $modPendaftaran,
        'judul' => $judul,
        'caraPrint' => $caraPrint,
        'model' => $model,
        'modPasien' => $modPasien,
        'modRuangan' => $modRuangan,
        'judulLaporan' => $judulLaporan,
        'modDiagnosa' => $modDiagnosa,
        'modTambahan' => $modTambahan
      ));
    }
  }

  public function actionPrintKePenunjang($id)
  {
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);

    $kepenunjang = $modPendaftaran->riwayatKePenunjang();

    $judulLaporan = 'Data Hasil Pemeriksaan Lab';
    $caraPrint = 'PDF';


    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->useOddEven = 2;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);

    if (!empty($kepenunjang)) {
      $i = 0;
      //pemeriksaan lab
      if (!empty($kepenunjang['laboratorium'])) {
        foreach ($kepenunjang['laboratorium'] as $k => $v) {
          if ($i > 0) {
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
          }
          $mpdf->WriteHTML($this->renderPartial('rawatJalan.views._periksaDataPasien/prinout._hasilLab', array(
            'format' => $format,
            'modKunjungan' => $v['kunjungan'],
            'modHasilPemeriksaan' => $v['hasil'],
            'modDetailHasilPemeriksaans' => $v['detail'],
            'judulLaporan' => 'Hasil Pemeriksaan Laboratorium',
          ), true));
          $i++;
        }
      }

      //pemeriksaan radiologi
      if (!empty($kepenunjang['radiologi'])) {

        foreach ($kepenunjang['radiologi'] as $k => $v) {
          if ($i > 0) {
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
          }
          $mpdf->WriteHTML($this->renderPartial('rawatJalan.views._periksaDataPasien/prinout._hasilRad', array(
            'format' => $format,
            'masukpenunjang' => $v['kunjungan'],
            'detailHasil' => $v['hasil'],
            'pemeriksa' => $v['pemeriksa'],
            'caraPrint' => 'PDF',
          ), true));
          $i++;
        }
      }

      //pemeriksaan rehab medis
      if (!empty($kepenunjang['rehabmedis'])) {

        foreach ($kepenunjang['rehabmedis'] as $k => $v) {
          if ($i > 0) {
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
          }
          $mpdf->WriteHTML($this->renderPartial('rawatJalan.views._periksaDataPasien.prinout._hasilRehab', array(
            'format' => $format,
            'masukpenunjang' => $v['kunjungan'],
            'detailHasil' => $v['hasil'],
            'judulLaporan' => 'HASIL PEMERIKSAAN REHAB MEDIS',
          ), true));
          $i++;
        }
      }

      //pemeriksaan asesmen gizi
      if (!empty($kepenunjang['asesmengizi'])) {

        foreach ($kepenunjang['asesmengizi'] as $k => $v) {
          foreach ($v['hasil'] as $g) {
            if ($i > 0) {
              $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            }
            $mpdf->WriteHTML($this->renderPartial('rawatJalan.views._periksaDataPasien.prinout._hasilGizi', array(
              'model' => $g,
            ), true));
            $i++;
          }
        }
      }
    }
    $mpdf->Output();
  }

  public function actionDetailKIE($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modKie = KiepasienT::model()->findByAttributes(array('pendaftaran_id' => $id));
    // echo CJSON::encode($modPendaftaran);

    // $modRiwayatKonsulSearch = new RJKonsulPoliT('search');
    $format = new MyFormatter;
    $this->render(
      '/_periksaDataPasien/_detailkie',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modKie' => $modKie
        // 'modRiwayatKonsulSearch'=>$modRiwayatKonsulSearch
      )
    );
  }

  public function actionPrintDetailKieDokter($pendaftaran_id, $kiepasien_id)
  {
    $modKie = KiepasienT::model()->findByPk($kiepasien_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modDetails = KiepasiendetT::model()->findAllByAttributes(array('kiepasien_id' => $kiepasien_id));
    $modListKie = ListkieM::model()->findAll('listkie_aktif =  true');
    // var_dump($modPenjualanObat);die;

    $modPenjualanObat = RJPenjualanresepT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    // $modObatAlkes = RJObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualanObat->penjualanresep_id)); 


    $judulLaporan = 'KIE';
    // $caraPrint=$_REQUEST['caraPrint'];
    // if($caraPrint=='PRINT') {
    $this->layout = '//layouts/printWindows';
    $this->render('/_periksaDataPasien/_printDetailKieDokter', array('modKie' => $modKie, 'modListKie' => $modListKie, 'modPendaftaran' => $modPendaftaran, 'modDetails' => $modDetails, 'judulLaporan' => $judulLaporan, 'modPenjualanObat' => $modPenjualanObat));
    // }
    // else if($caraPrint=='EXCEL') {
    //     $this->layout='//layouts/printExcel';
    //     $this->render($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    // }
    // else if($_REQUEST['caraPrint']=='PDF') {
    //     $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
    //     $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    //     $mpdf = new MyPDF('',$ukuranKertasPDF); 
    //     $mpdf->useOddEven = 2;  
    //     $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    //     $mpdf->WriteHTML($stylesheet,1);  
    //     $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
    //     $mpdf->WriteHTML($this->renderPartial($this->path_view.'printRiwayat',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKonsul'=>$modRiwayatKonsul,'modKonsul'=>$modKonsul,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
    //     $mpdf->Output();
    // }                       
  }

  public function actionInformasiRiwayatPasien($id)
  {
    $modelRiwayat = new RJCpptpasienT();
    // $pendaftaran_id = $_GET['pendaftaran_id'];
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
    $ruangan_id = Yii::app()->user->getState("ruangan_id");

    if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_GIZI) {
      $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => $ruangan_id));
    } else if (Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) {
      if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_VK) {
        $modPendaftaran = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => $ruangan_id));
      }
    }
    if (isset($_GET['RJCpptpasienT'])) {
      $modelRiwayat->attributes = $_GET['RJCpptpasienT'];
    }
    $this->render('rawatJalan.views.daftarPasien._riwayatCPPT', array(
      'modelRiwayat' => $modelRiwayat,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  public function actionUpdatePasienPRMRJ()
  {
    if (Yii::app()->request->isPostRequest) {
      $pendaftaranId = $_POST['pendaftaran_id'];

      $updatependaftaran = PendaftaranT::model()->updateByPk($pendaftaranId, array('isprmrj' => true, 'petugaskesehatan_prmrj' => Yii::app()->user->getState('pegawai_id')));

      $message = "";
      $sukses = 0;

      if ($updatependaftaran) {
        $message = "Data Berhasil Ditambahkan!";
        $sukses = 1;
      } else {
        $message = "Data gagal Ditambahkan!";
        $sukses = 0;
      }

      echo CJSON::encode(array(
        'sukses' => $sukses,
        'msg' => $message,
      ));
      exit;
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  public function actionPrintSep($sep_id, $pendaftaran_id, $preview = '')
  {
    $this->layout = '//layouts/iframe';

    if (empty($preview) || $preview != 1) {
      $this->layout = $this->layout = '//layouts/printWindows';
    }

    $format = new MyFormatter;
    $modRujukanBpjs = new RujukanT;
    $modSep = SepT::model()->findByPk($sep_id);
    if (isset($modSep->print_ke) && !empty($modSep->print_ke)) {
      $modSep->print_ke++;
      SepT::model()->updateByPk($modSep->sep_id, array('print_ke' => $modSep->print_ke));
      // $modSep->update(array('print_ke'));
    } else {
      $modSep->print_ke = 1;
      SepT::model()->updateByPk($modSep->sep_id, array('print_ke' => $modSep->print_ke));
      // $modSep->update(array('print_ke'));
    }
    $bpjs = new Bpjs();
    $modAsuransiPasienBpjs = AsuransipasienM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
    $modJenisPeserta = JenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
    if (isset($modSep->norujukan)) {
      $modRujukanBpjs = RujukanT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
    $bpjs = new BpjsVklaim;
    $dataSep = CJSON::decode($bpjs->search_sep($modSep->nosep));
    if ($dataSep['metaData']['code'] == 200) {
      $dataSep_new = $dataSep['response'];
    }
    // echo "<pre>";
    // var_dump($dataSep);die;
    $judul_print = 'SURAT ELIGIBILITAS PESERTA';
    $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printSep_baru3', array(
      'format' => $format,
      'modSep' => $modSep,
      'judul_print' => $judul_print,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modJenisPeserta' => $modJenisPeserta,
      'modRujukan' => $modRujukan,
      'data_sep' => $dataSep_new
    ));
  }

  public function actionRiwayatPelayananPasien()
  {
    $no_kartu = $_GET['noka'];
    $kode_dokter = $_GET['kodedokter'];

    $urlData = array();
    $riwayatPelayannan = new RiwayatPasien();

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Authorization");

    $dataApi = CJSON::decode($riwayatPelayannan->search_riwayat($no_kartu, $kode_dokter));

    // echo "<pre>";
    // var_dump($dataApi);die;

    if ($dataApi['metaData']['code'] == 200) {
      $urlData['url'] = $dataApi['response']['url'];
      $urlData['pesan'] = "";
    } else {
      $urlData['pesan'] = $dataApi['metaData']['message'];
    }

    echo CJSON::encode($urlData);
    // echo "<pre>";
    // var_dump($dataApi);
    // die;
  }
  
  public function actionUbahDPJP($pendaftaran_id = null)
    {

        $this->layout = '//layouts/iframe';

        $modUbahDokter = new RJUbahdokterR;
        
        $modRiwayatUbahDokter = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'create_time desc']);

        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

        if(!empty($modPendaftaran)) {
            $modUbahDokter->dokterlama_id = $modPendaftaran->pegawai_id;
            $modUbahDokter->dokterlama_nama = $modPendaftaran->pegawai->nama_pegawai;
            $modPendaftaran->nama_pasien = $modPendaftaran->pasien->nama_pasien;
            $modPendaftaran->alamat_pasien = $modPendaftaran->pasien->alamat_pasien;
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            $modPendaftaran->no_rekam_medik = $modPendaftaran->pasien->no_rekam_medik;
            
        }
        
        if(empty($modPendaftaran)) {
            $modPendaftaran = new RJPendaftaranT();
        }

        if (isset($_POST['RJPendaftaranT'])) {

            $transaction = Yii::app()->db->beginTransaction();

            if ($_POST['RJUbahdokterR']['dokterbaru_id'] != "") {
                $modUbahDokter->attributes = $_POST['RJUbahdokterR'];
                $modUbahDokter->pendaftaran_id = $_POST['RJPendaftaranT']['pendaftaran_id'];
                $modUbahDokter->tglubahdokter = MyFormatter::formatDateTimeForDb($_POST['tglubahdokter']);
                $modUbahDokter->create_time = date('Y-m-d H:i:s');
                $modUbahDokter->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
                // echo '<pre>';var_dump($modUbahDokter);die;
                try {

                    $attributes = array('pegawai_id' => $_POST['RJUbahdokterR']['dokterbaru_id']);
        
                    $save = RJPendaftaranT::model()->updateByPk($_POST['RJPendaftaranT']['pendaftaran_id'], $attributes);
                    // echo '<pre>';var_dump($save, $modUbahDokter->validate());die;
                    if ($save) {
                        if($modUbahDokter->save()) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan !');
                            $this->redirect(array('UbahDPJP', 'pendaftaran_id'=>$pendaftaran_id, 'sukses' => 1));

                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan !');

                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {2}!');


                    }
                    
                } catch (Exception $exc) {
                    echo '<pre>';var_dump($exc);die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {3}!');

                }
            }
            
        }

   
        $this->render($this->path_view . 'dpjp/_formUbahDPJP', array(
            'modPendaftaran' => $modPendaftaran, 
            'modUbahDokter' => $modUbahDokter, 
            'modDokter' => $modUbahDokter, 
            'modRiwayatUbahDokter' => $modRiwayatUbahDokter,
        ));
        
    }

  function actionCekPemeriksaanUntukAksesUbahDPJP() {
    $pendaftaran_id = $_POST['pendaftaran_id'];

    // cek anamnesa
    $modAnamnesa = AnamnesaT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);

    // cek pemeriksaan fisik
    $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
    
    // cek diagnosa
    $modMorbi = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);

    if(!empty($modAnamnesa) || !empty($modPemeriksaanFisik) || !empty($modMorbi)) {
      $data['akses'] = 0;
    } else {
      $data['akses'] = 1;
    }

    echo json_encode($data);
  }
}
