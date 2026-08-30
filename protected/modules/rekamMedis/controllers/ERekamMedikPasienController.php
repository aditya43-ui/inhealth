<?php

class ERekamMedikPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'rekamMedis.views.eRekamMedikPasien.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rekam Medik Elektronik Pasien";
    $modPasien = new PasienM();
    $modPendaftaran = new PendaftaranT();

    $this->render($this->path_view . 'index', array(
      'modPasien'=>$modPasien,
      'modPendaftaran'=>$modPendaftaran
    ));
  }

  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';
    $pages =  null;
    $modKunjungan = array();
    if(!empty($id)){
      $criteria = new CDbCriteria(array(
        'condition' => 't.pasien_id = ' . $id,
        'order' => 'tgl_pendaftaran DESC'
      ));
  
      $pages = new CPagination(PendaftaranT::model()->count($criteria));
      $pages->pageSize = Params::JUMLAH_PERHALAMAN;
      $pages->applyLimit($criteria);
  
      $modKunjungan = PendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'diagnosa')->findAll($criteria);
  
    }
    

    $this->render($this->path_view .'_riwayatPasien', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan
    ));
  }

  public function actionDetailPersalinan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modPasienIbu = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (!empty($modPasienIbu->pasien_ibu_id)) {
      $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->find('pasien_id = ' . $modPasienIbu->pasien_ibu_id . 'and persalinan_id is not null');
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
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view .'periksaDataPasien._persalinan',
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

  public function actionDetailPemeriksaanLab($id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPasien = PasienM::model()->findByPk($id);
    $modHasilPemeriksaan = new HasilpemeriksaanlabT();

    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $this->render(
      $this->path_view .'periksaDataPasien._pemeriksaanLab',
      array(
        'modPasien' => $modPasien,
        'format' => $format,
        'modHasilPemeriksaan' => $modHasilPemeriksaan,
        'judulLaporan' => $judulLaporan,
        'pasien_id' => $id,
      )
    );
  }

  public function actionDetailGinekologi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modGinekologi = PemeriksaanginekologiT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $ginekologi_id = PemeriksaanginekologiT::model()->findByAttributes(array('pendaftaran_id' => $id));
    if (!empty($ginekologi_id)) {
      $modRiwayatKelahiran = RiwayatkehamilanT::model()->findAllByAttributes(array('pemeriksaanginekologi_id' => $ginekologi_id->pemeriksaanginekologi_id));
    } else {
      $modRiwayatKelahiran = array();
    }

    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view .'periksaDataPasien._ginekologi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modGinekologi' => $modGinekologi,
        'modRiwayatKelahiran' => $modRiwayatKelahiran,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailKelahiran($id)
  {
    $this->layout = '//layouts/iframe';
    $modKelahiran = array();
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    $modPasienIbu = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (!empty($modPasienIbu->pasien_ibu_id)) {
      $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->find('pasien_id = ' . $modPasienIbu->pasien_ibu_id . 'and persalinan_id is not null');
    }

    $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    foreach ($modPersalinan as $persalinan) {
      $modKelahiran[$persalinan->persalinan_id] = KelahiranbayiT::model()->findAllByAttributes(array('persalinan_id' => $persalinan->persalinan_id));
    }
    $format = new MyFormatter;
    $modKelahiranSearch = new KelahiranbayiT('search');
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view .'periksaDataPasien._kelahiran',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPersalinan' => $modPersalinan,
        'modKelahiran' => $modKelahiran,
        'modKelahiranSearch' => $modKelahiranSearch,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailKonsul($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modRiwayatKonsulSearch = new RKKonsulpoliT('search');
    $format = new MyFormatter;
    $this->render($this->path_view .'periksaDataPasien._detailkonsulpoli',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modRiwayatKonsulSearch' => $modRiwayatKonsulSearch
      )
    );
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

    $this->render($this->path_view .'periksaDataPasien._riwayatRehab', array(
      'penunjang' => $penunjang,
    ));
  }
  
  public function actionDetailMCU($id)
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran = PendaftaranT::model()->findByPk($id);

    $this->render($this->path_view .'periksaDataPasien._riwayatMCU', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._umum', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._jantung', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._kandungan', array(
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
      $this->render($this->path_view .'periksaDataPasien.mcu._lainlain', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._treadmill', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._hearing', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._koroner', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._spirometri', array(
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
      $this->render($this->path_view .'periksaDataPasien.mcu._kesimpulan', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._lab', array(
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

      $this->render($this->path_view .'periksaDataPasien.mcu._rad', array(
        'detailHasil' => $detailHasil,
        'masukpenunjang' => $modPasienMasukPenunjang,
        'pemeriksa' => $pemeriksa,
        'detailHasil' => $detailHasil
      ));
    }
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

    $this->render($this->path_view .'periksaDataPasien._operasi2', array(
      'penunjang' => $penunjang,
    ));
  }

  public function actionDetailTindakan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    // var_dump($id);exit();

    $modTindakan = RKTindakanpelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modTindakanSearch = new RKTindakanpelayananT('search');
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view .'periksaDataPasien._tindakan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTindakan' => $modTindakan,
        'modTindakanSearch' => $modTindakanSearch,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailTerapi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

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

    $this->render(
      $this->path_view .'periksaDataPasien._terapi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'checkers' => $checkers
      )
    );
  }

  public function actionDetailPemakaianBahan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modBahan = RKObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modPemakaianBahan = new RKObatalkespasienT;
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view .'periksaDataPasien._pemakaianBahan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modBahan' => $modBahan,
        'modPemakaianBahan' => $modPemakaianBahan,
        'modPasien' => $modPasien
      )
    );
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

    $this->render($this->path_view .'periksaDataPasien._printPartograf', array(
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

  public function actionPrintDetailPartografBelakang($id)
  {
    $this->layout = '//layouts/printWindows';

    $persalinan = PersalinanT::model()->findByAttributes(array('pendaftaran_id' => $id));
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

    $this->render($this->path_view .'periksaDataPasien._printPartografBelakang', array(
      'persalinan' => $persalinan,
      'pendaftaran' => $pendaftaran,
      'pasien' => $pasien,
      'admisi' => $admisi,
      'kala' => $kala,
      'periksaFisik' => $periksaFisik,
      'kelahiran' => $kelahiran,
    ));
  }

  public function actionDetailHasilLab($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $modKunjungan = PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $criteria = new CDbCriteria();
    $criteria->join = "
							JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
							JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
							JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = DetailhasilpemeriksaanlabT::model()->findAll($criteria);
    $this->render($this->path_view .'periksaDataPasien.detailHasilLab', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan,
    ));
  }

  public function actionDetailHasilRad($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '')
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));
    $detailHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

    $this->render($this->path_view .'periksaDataPasien.detailHasilRad', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'caraPrint' => $caraPrint,
    ));
  }

  public function actionDetailHasilRehab($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
    $modPasienMasukPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $detailHasil = HasilpemeriksaanrmT::model()->findAll('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
    $this->render(
      $this->path_view .'periksaDataPasien.detailHasilRehab',
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
    $this->render($this->path_view .'periksaDataPasien.detailHasilGizi', array(
      'model' => $model,
    ));
  }

  public function actionDetailKonsulHasil($id)
  {
    $this->layout = '//layouts/iframe';

    $idKonsulAntarPoli = $id;
    $modKonsulPoli = RKKonsulpoliT::model()->findByPk($idKonsulAntarPoli);
    $modMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modKonsulPoli->pendaftaran_id,
      'ruangan_id' => $modKonsulPoli->ruangan_id,
    ));
    if (!empty($modKonsulPoli->pegawaikonsul_id)) {
      $modKonsulPoli->nama_pegawai = PegawaiM::model()->findByPk($modKonsulPoli->pegawaikonsul_id)->nama_pegawai;
    }

    $this->render($this->path_view .'periksaDataPasien.konsultasiInternal._viewKonsulPoliHasil', array('modKonsul' => $modKonsulPoli, 'modMorbiditas' => $modMorbiditas, 'no_ok' => 1));
  }
}
