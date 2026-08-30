<?php
//untuk actionDetailHasilLab
Yii::import('application.modules.laboratorium.models.LBPasienMasukPenunjangV');
//untuk actionDetailHasilRab
Yii::import('application.modules.radiologi.models.ROPasienMasukPenunjangV');
class RiwayatPasienController extends MyAuthController
{
  public $path_view = "rawatInap.views.riwayatPasien."; //agar bisa di extend
  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria(array(
      //'condition' => 't.pasien_id = '.$id.' and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
      'condition' => 't.pasien_id = ' . $id,
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(RIPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);

    $modKunjungan = RIPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'diagnosa')->findAll($criteria);


    $this->render($this->path_view . '_riwayatPasien', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
    ));
  }

  public function actionDetailPemakaianBahan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RIPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modBahan = RIObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modPemakaianBahan = new RIObatalkespasienT;
    $modPasien = RIPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view . '_pemakaianBahan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modBahan' => $modBahan,
        'modPemakaianBahan' => $modPemakaianBahan,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailTerapi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RIPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTerapi = ResepturT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modDetailTerapi = new RIResepturDetailT();
    $modPasien = RIPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view . '_terapi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTerapi' => $modTerapi,
        'modDetailTerapi' => $modDetailTerapi,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailTindakan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = RIPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTindakan = RITindakanPelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modTindakanSearch = new RITindakanPelayananT('search');
    $modPasien = RIPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      $this->path_view . '_tindakan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTindakan' => $modTindakan,
        'modTindakanSearch' => $modTindakanSearch,
        'modPasien' => $modPasien
      )
    );
  }
  /**
   * actionDetailHasilLab = mnampilkan hasil lab sesuai dengan yang dilab
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   */
  public function actionDetailHasilLab($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
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
          'pasienmasukpenunjang_id' => $masukpenunjangRad->pasienmasukpenunjang_id
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
    $query = "
            SELECT * FROM detailhasilpemeriksaanlab_t 
            JOIN pemeriksaanlab_m ON detailhasilpemeriksaanlab_t.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id 
            JOIN pemeriksaanlabdet_m ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id 
            JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
            JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
            WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = '" . $modHasilPeriksa->hasilpemeriksaanlab_id . "'
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
      $this->path_view . 'detailHasilLab',
      array(
        'modHasilPeriksa' => $modHasilPeriksa,
        'masukpenunjang' => $masukpenunjang,
        'pemeriksa' => $pemeriksa,
        'data' => $data,
        'data_rad' => $data_rad
      )
    );
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

    $this->render($this->path_view . 'detailHasilRad', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'caraPrint' => $caraPrint,
    ));
  }
}
