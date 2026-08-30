<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); RND-6398
class LaboratoriumController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  protected $tindakanpelayanantersimpan = true;
  protected $komponentindakantersimpan = true;
  protected $path_view = 'rawatJalan.views.laboratorium.';

  /**
   * method untuk mengirimkan pasien ke unit lain
   * digunakan di :
   * 1. rawatJalan/laboratorium/index
   * @param int $pendaftaran_id pendaftaran_id
   */
  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null)
  {

    $params = array();
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

    if ($modPendaftaran->carabayar_id == 2) {
      $modPendaftaran->kelaspelayanan_id = 5;
    }
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    if(Yii::app()->user->getState('kelompokpegawai_id') === Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP) {
      $modKirimKeUnitLain->pegawai_id = Yii::app()->user->getState('pegawai_id');
    } else {
        $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
        if(isset($_GET['pasienadmisi_id'])) {
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->admisi->pegawai_id;
        }
    }
    //RSPMC-1260
    if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
      $modKirimKeUnitLain->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
    } else {
      $modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    }

    if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && $modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
    else $modKirimKeUnitLain->isbayarkekasirpenunjang = false;
    $modJenisPeriksaLab = RJJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif' => true), array('order' => 'jenispemeriksaanlab_urutan'));

    $critpl = new CDbCriteria;
    $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                        j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
    $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                      JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                      JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                      JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
    $critpl->group = $critpl->select;

    $critpl->addCondition('t.pemeriksaanlab_aktif = true');

    if (!empty($modPendaftaran->kelaspelayanan_id)) {
      $critpl->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
    }

    $modPeriksaLab = RJPemeriksaanLabM::model()->findAll($critpl);
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

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

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }
    $modPemeriksaanLab = new RJTarifpemeriksaanlabruanganV;

    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {
      // echo '<pre>';var_dump($_POST);die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        // if($_POST['RJPasienKirimKeUnitLainT']['is_cyto'] == 1){
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = true;
        // } else{
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = false;
        // }


        $cito = $_POST['RJPasienKirimKeUnitLainT']['is_cito'];


        if (isset($_POST['permintaanPenunjang'])) {
          // var_dump($_POST['permintaanPenunjang']);die;
          $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_KLINIK, $cito);
        }
        if (isset($_POST['permintaanPenunjangAnatomi'])) {

          //$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI);
          $modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI, $cito);
        }

        if (isset($_POST['permintaanPenunjang']) || isset($_POST['permintaanPenunjangAnatomi'])) {
          if (isset($_POST['permintaanPenunjang'])) {
            $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
          }

          if (isset($_POST['permintaanPenunjangAnatomi'])) {
            $this->savePermintaanPenunjang($_POST['permintaanPenunjangAnatomi'], $modKirimKeUnitLainAnatomi);
          }

          // update status sudah diperiksa hanya dilakukan update manual pada daftar pasien
          // $p = PendaftaranT::model()->findByPk($pendaftaran_id);
          // $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);

          /* ================================================ */
          /* Proses update status periksa KonsulPoli EHS-179  */
          /* ================================================ */
          $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
          $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
          if (!empty($konsulPoli)) {
            $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          }
          /* ================================================ */

          PendaftaranT::model()->updateByPk(
            $pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );
          //                        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
          //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
          //                        $params['create_time'] = date( 'Y-m-d H:i:s');
          //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
          //                        $params['instalasi_id'] = $ruangan->instalasi_id;
          //                        $params['modul_id'] = 8;
          //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
          //                        $params['create_ruangan'] = $ruangan->ruangan_id;
          //                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';
          //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
          //sudah di ganti menggunakan node js seperti di Farmasi Apotek - transaksi penjualan resep RS.
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        $judul = 'Pasien Rujuk ke Laboratorium';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;



        // var_dump($mr->attributes); die;

        if (!empty($modKirimKeUnitLain->pendaftaran_id)) {
          $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

          $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index', array(
            'LBPasienKirimKeUnitLainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[no_pendaftaran]' => substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran, 2),
            'LBPasienKirimKeUnitLainV[prefix_pendaftaran]' => substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran, 0, 2),
            'LBPasienKirimKeUnitLainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
            'LBPasienKirimKeUnitLainV[nama_pasien]' => $modPasien->nama_pasien,
            //  'LBPasienKirimKeUnitLainV[ppds_id]' => $modKirimKeUnitLain->ppds_id
          ));

          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
            // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          ));
        } else {
          $mr = RuanganM::model()->findByPk($modKirimKeUnitLainAnatomi->ruangan_id);

          $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index', array(
            'LBPasienKirimKeUnitLainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[no_pendaftaran]' => substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran, 2),
            'LBPasienKirimKeUnitLainV[prefix_pendaftaran]' => substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran, 0, 2),
            'LBPasienKirimKeUnitLainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
            'LBPasienKirimKeUnitLainV[nama_pasien]' => $modPasien->nama_pasien,
            // 'LBPasienKirimKeUnitLainV[ppds_id]' => $modKirimKeUnitLain->ppds_id
          ));

          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
            // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          ));
        }


        // var_dump($this->tindakanpelayanantersimpan);die;
        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->tindakanpelayanantersimpan) {
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
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
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modKirimKeUnitLain->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          if (!empty($modKirimKeUnitLain->pendaftaran_id)) {
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'pasienkirim_id' => $modKirimKeUnitLain->pasienkirimkeunitlain_id));
          } else {
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan! ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        var_dump($exc->getMessage());
        die;
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    // $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
    //   array('pendaftaran_id' => $pendaftaran_id),
    // 'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_KLINIK . ') AND create_ruangan = '.Yii::app()->user->getState('ruangan_id')
    // );

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll(
      'pendaftaran_id = ' . $pendaftaran_id . ' AND ruangan_id IN(' . Params::RUANGAN_ID_LAB_KLINIK . ')'
    );

    // $q_riwayat = "(pendaftaran_id = ".$pendaftaran_id." OR (pendaftaran_id IS NULL AND pasien_id = ".$modPendaftaran->pasien_id.") ) AND instalasi_id = ".Params::INSTALASI_ID_RAD." ORDER BY  pasienmasukpenunjang_id";    

    // var_dump($q_riwayat); die;
    // $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll($q_riwayat);

    if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_REKAMMEDIS || isset($_GET['lihat'])) {
      $this->render($this->path_view . 'indexRekamMedis', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modKirimKeUnitLain' => $modKirimKeUnitLain,
        'modJenisPeriksaLab' => $modJenisPeriksaLab,
        'modPeriksaLab' => $modPeriksaLab,
        'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
        'modJenisTarif' => $modJenisTarif,
        'modPemeriksaanLab' => $modPemeriksaanLab
      ));
    } else {
      $this->render($this->path_view . 'index', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modKirimKeUnitLain' => $modKirimKeUnitLain,
        'modJenisPeriksaLab' => $modJenisPeriksaLab,
        'modPeriksaLab' => $modPeriksaLab,
        'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
        'modJenisTarif' => $modJenisTarif,
        'modPemeriksaanLab' => $modPemeriksaanLab
      ));
    }
  }


  //--Ubah

  public function actionUpdate($pendaftaran_id, $pasienkirimkeunitlain_id)
  {

    $params = array();
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($pasienkirimkeunitlain_id);
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;

    // var_dump($modKirimKeUnitLain->kelaspelayanan_id); die;

    if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && $modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
    else $modKirimKeUnitLain->isbayarkekasirpenunjang = false;
    $modJenisPeriksaLab = RJJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif' => true), array('order' => 'jenispemeriksaanlab_urutan'));

    $critpl = new CDbCriteria;
    $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                        j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
    $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                      JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                      JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                      JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
    $critpl->group = $critpl->select;

    $critpl->addCondition('t.pemeriksaanlab_aktif = true');

    if (!empty($modPendaftaran->kelaspelayanan_id)) {
      $critpl->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
    }

    $modPeriksaLab = RJPemeriksaanLabM::model()->findAll($critpl);
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

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

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }
    $modPemeriksaanLab = new RJTarifpemeriksaanlabruanganV;

    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        // if($_POST['RJPasienKirimKeUnitLainT']['is_cyto'] == 1){
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = true;
        // } else{
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = false;
        // }

        $cito = in_array("ya", $_POST['permintaanPenunjang']['cito_true'] ?? array());

        if (isset($_POST['permintaanPenunjang'])) {
          $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_KLINIK, $cito, $modKirimKeUnitLain);
        }
        if (isset($_POST['permintaanPenunjangAnatomi'])) {

          //$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI);
          $modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI, $cito, $modKirimKeUnitLainAnatomi);
        }



        if (isset($_POST['permintaanPenunjang']) || isset($_POST['permintaanPenunjangAnatomi'])) {
          if (isset($_POST['permintaanPenunjang'])) {
            $hapuspermintaan = true;
            $hapuspermintaan &= PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
          }

          if (isset($_POST['permintaanPenunjangAnatomi'])) {
            $this->savePermintaanPenunjang($_POST['permintaanPenunjangAnatomi'], $modKirimKeUnitLainAnatomi);
          }

          // $p = PendaftaranT::model()->findByPk($pendaftaran_id);
          // $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);

          /* ================================================ */
          /* Proses update status periksa KonsulPoli EHS-179  */
          /* ================================================ */
          $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
          $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
          if (!empty($konsulPoli)) {
            $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          }
          /* ================================================ */

          PendaftaranT::model()->updateByPk(
            $pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );
          //                        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
          //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
          //                        $params['create_time'] = date( 'Y-m-d H:i:s');
          //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
          //                        $params['instalasi_id'] = $ruangan->instalasi_id;
          //                        $params['modul_id'] = 8;
          //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
          //                        $params['create_ruangan'] = $ruangan->ruangan_id;
          //                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';
          //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
          //sudah di ganti menggunakan node js seperti di Farmasi Apotek - transaksi penjualan resep RS.
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        $judul = 'Pasien Rujuk ke Laboratorium';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;



        // var_dump($mr->attributes); die;

        if (!empty($modKirimKeUnitLain->pendaftaran_id)) {
          $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

          $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index', array(
            'LBPasienKirimKeUnitLainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[no_pendaftaran]' => substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran, 2),
            'LBPasienKirimKeUnitLainV[prefix_pendaftaran]' => substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran, 0, 2),
            'LBPasienKirimKeUnitLainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
            'LBPasienKirimKeUnitLainV[nama_pasien]' => $modPasien->nama_pasien,
            //  'LBPasienKirimKeUnitLainV[ppds_id]' => $modKirimKeUnitLain->ppds_id
          ));

          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
            // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          ));
        } else {
          $mr = RuanganM::model()->findByPk($modKirimKeUnitLainAnatomi->ruangan_id);

          $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index', array(
            'LBPasienKirimKeUnitLainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
            'LBPasienKirimKeUnitLainV[no_pendaftaran]' => substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran, 2),
            'LBPasienKirimKeUnitLainV[prefix_pendaftaran]' => substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran, 0, 2),
            'LBPasienKirimKeUnitLainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
            'LBPasienKirimKeUnitLainV[nama_pasien]' => $modPasien->nama_pasien,
            // 'LBPasienKirimKeUnitLainV[ppds_id]' => $modKirimKeUnitLain->ppds_id
          ));

          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
            // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          ));
        }



        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->tindakanpelayanantersimpan) {
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
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
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modKirimKeUnitLain->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          if (!empty($modKirimKeUnitLain->pendaftaran_id)) {
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'pasienkirim_id' => $modKirimKeUnitLain->pasienkirimkeunitlain_id));
          } else {
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan! ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        var_dump($exc->getMessage());
        die;
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array('pendaftaran_id' => $pendaftaran_id),
      'pasienmasukpenunjang_id IS NULL AND ruangan_id IN(' . Params::RUANGAN_ID_LAB_KLINIK . ',' . Params::RUANGAN_ID_LAB_ANATOMI . ') AND create_ruangan = ' . Yii::app()->user->getState('ruangan_id')
    );

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modJenisPeriksaLab' => $modJenisPeriksaLab,
      'modPeriksaLab' => $modPeriksaLab,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif,
      'modPemeriksaanLab' => $modPemeriksaanLab
    ));
  }

  //--End Ubah

  /**
   * method untuk menyimpan data pasien ke unit lain RJPasienKirimkeUnitLainT
   * digunakan di :
   * 1. rawatJalan/laboratorium/index
   * @param object $modPendaftaran model PendaftaranT
   * @return \RJPasienKirimKeUnitLainT
   */
  protected function savePasienKirimKeUnitLain($modPendaftaran, $ruangan_lab, $is_cito, $modKirimKeUnitLain = null)
  {
    $ruangan = RuanganM::model()->findByPk($ruangan_lab);
    if (empty($modKirimKeUnitLain)) {
      $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    }
    $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
    // echo'<pre>';
    // var_dump( $modKirimKeUnitLain->attributes);die;
    $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modKirimKeUnitLain->instalasi_id = $ruangan->instalasi_id;
    $modKirimKeUnitLain->ruangan_id = $ruangan_lab;
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->create_time = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->update_time = date('Y-m-d H:i:s');
    // $modKirimKeUnitLain->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $modKirimKeUnitLain->ppds_id = isset($_POST['RJPasienKirimKeUnitLainT']['ppds_id']) ? $_POST['RJPasienKirimKeUnitLainT']['ppds_id'] : false;
    $modKirimKeUnitLain->is_cyto = $is_cito;
    $modKirimKeUnitLain->is_cito = $is_cito;
    $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if(isset($_POST['RJTarifpemeriksaanlabruanganV']['jenisform_id']) && $_POST['RJTarifpemeriksaanlabruanganV']['jenisform_id'] == 5) {
      $modKirimKeUnitLain->is_bga = true;
    } else {
      $modKirimKeUnitLain->is_bga = false;
    }
      // var_dump($modKirimKeUnitLain->getMessage());die;
    if ($modKirimKeUnitLain->validate()) {
      if ($modKirimKeUnitLain->save()) {
        $this->statusSaveKirimkeUnitLain = true;
      }
    }

    return $modKirimKeUnitLain;
  }

  /**
   * method untuk menyimpan dan validasi permintaan penunjang
   * digunakan di :
   * 1. rawatJalan/laboratorium/index
   * @param array $permintaan berupa post request berisi data permintaan penunjang
   * @param object $modKirimKeUnitLain model PasienkirimkeunitlainT
   */
  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    // echo '<pre>'; 

    foreach ($permintaan['inputpemeriksaanlab'] as $i => $value) {
      $modPermintaan = new RJPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = isset($permintaan['idDaftarTindakan'][$i]) ? $permintaan['idDaftarTindakan'][$i] : null;
      $modPermintaan->pemeriksaanlab_id = $permintaan['inputpemeriksaanlab'][$i];
      $modPermintaan->pemeriksaanrad_id = '';
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
      $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i] ?? 1;
      $modPermintaan->tarif_pelayananan = str_replace(",", "", $permintaan['inputtarifpemeriksaanlab'][$i]);
      $modPermintaan->is_cito = $modKirimKeUnitLain->is_cito;

      // var_dump($modPermintaan->is_cito);

      // if($modKirimKeUnitLain->is_cyto == true){
      //   $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
      //                                                                       'daftartindakan_id'=>$modPermintaan->pemeriksaanlab->daftartindakan_id,
      //                                                                       'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
      //   $modPermintaan->tarif_pelayananan = $modTarif->totaltarifakhir_cyto;
      // }else{
      //   $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
      //                                                                       'daftartindakan_id'=>$modPermintaan->pemeriksaanlab->daftartindakan_id,
      //                                                                       'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
      //   $modPermintaan->tarif_pelayananan = $modTarif->hargatariftindakan;
      // }
      // $modPermintaan->tarif_pelayananan = $modKirimKeUnitLain->is_cyto
      $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
      // insert paket pelayanan
      if (isset($permintaan['tindakanpelayanan_id'][$i])) {
        $modPermintaan->tindakanpelayanan_id = $permintaan['tindakanpelayanan_id'][$i];
      }
      if ($modPermintaan->validate()) {
        if ($modPermintaan->save()) {
          $this->statusSavePermintaanPenunjang = true;
          /*
						if($modKirimKeUnitLain->isbayarkekasirpenunjang){ 
							$modMasukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$modKirimKeUnitLain->pendaftaran->pasienadmisi_id),'pindahkamar_id IS NULL');
							$modTindakan = $this->simpanTindakanPelayanan($modMasukKamar,$modKirimKeUnitLain,$modPermintaan); //AGAR BISA DI BAYAR DI KASIR
							$modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
							$modPermintaan->update();
						}
                         * 
                         */
        }
      }
    }
    // die;
  }


  /**
   * proses simpan TindakanPelayananT dan TindakanKomponenT
   * khusus untuk permintaan penunjang
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan)
  {
    $modTindakan = new RJTindakanPelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
    $modTindakan->tarif_satuan = $modPermintaan->tarif_pelayananan;
    $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modKirimKeUnitLain->pegawai_id;
    $modTindakan->perawat_id = (!empty($modKirimKeUnitLain->perawat_id) ? $modKirimKeUnitLain->perawat_id : null);
    $modTindakan->tgl_tindakan = $modPermintaan->tglpermintaankepenunjang;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  public function actionAjaxBatalKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!";
      $data['sukses'] = 0;
      $kirimUnit = array();

      $status = 'ok';

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $criteria = new CDbCriteria();
        $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
        $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
        $criteria->addCondition("t.pasienkirimkeunitlain_id = " . $pasienkirimkeunitlain_id . " and tp.tindakansudahbayar_id is not null");
        $permintaan = PermintaankepenunjangT::model()->find($criteria);

        if ($permintaan->permintaankepenunjang_id > 0) {
          $data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
          $data['sukses'] = 0;
        } else {
          $ok = true;
          $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

          if (!empty($kirim)) {
            $kirimUnit = array(
              'instalasi_id' => $kirim->instalasi_id,
              'ruangan_id' => $kirim->ruangan_id,
              'pasien_id' => $kirim->pasien_id,
              'no_pendaftaran' => $kirim->pendaftaran->no_pendaftaran
            );
          }


          $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
            'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id
          ));
          foreach ($permintaan as $item) {
            if (!empty($item->tindakanpelayanan_id)) {
              $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
            }
          }
          $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
          $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
          $keterangan = "Pasien berhasil dibatalkan";

          if ($status == 'ok' && $ok) {

            $this->notifBatalRujuk($kirimUnit);

            $data['pesan'] = "Pasien kirim ke laboratorium berhasil dibatalkan!";
            $data['sukses'] = 1;
            $transaction->commit();
          } else {
            $transaction->rollback();
            $data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan!";
            $data['sukses'] = 0;
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!<br/>" . $exc->getMessage();
        $data['sukses'] = 0;
      }
      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
        array('pendaftaran_id' => $pendaftaran_id),
        'pasienmasukpenunjang_id IS NULL AND ruangan_id IN(' . Params::RUANGAN_ID_LAB_KLINIK . ',' . Params::RUANGAN_ID_LAB_ANATOMI . ')'
      );
      $data['result'] = $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      ),
      'pasienmasukpenunjang_id IS NULL'
    );
    $modKirim = RJPasienKirimKeUnitLainT::model()->findByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      )
    );

    $judulLaporan = 'Permintaan Pemeriksaan Laboratorium';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim' => $modKirim));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim' => $modKirim));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim' => $modKirim), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_LAB),
      'pasienmasukpenunjang_id IS NULL'
    );

    $judulLaporan = 'Permintaan Pemeriksaan Laboratorium';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   *
   * Ajax untuk load pemeriksaan lab ketika di cekllist
   *
   */
  public function actionLoadFormPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pemeriksaanlab_id = (isset($_POST['pemeriksaanlab_id']) ? $_POST['pemeriksaanlab_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Params::RUANGAN_ID_LAB_KLINIK);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      $criteria = new CDbCriteria();
      $criteria->addCondition('pemeriksaanlab_id = ' . $pemeriksaanlab_id);
      $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
      // $criteria->addCondition('penjamin_id = ' . $modPendaftaran->penjamin_id);
      // $criteria->addCondition('ruangan_id = ' . $ruangan_id);
      $modTarif = TarifpemeriksaanlabruanganV::model()->find($criteria);
      // $modTarif->harga_tariftindakan = 0;


      //Jalan
      $crit_rj = new CDbCriteria();
      $crit_rj->addCondition('pemeriksaanlab_id = ' . $pemeriksaanlab_id);
      $crit_rj->addCondition('kelaspelayanan_id = 6');
      $modTarif_rj = TarifpemeriksaanlabruanganV::model()->find($crit_rj);

      if (!empty($modTarif_rj)) {
        $modTarif = $modTarif_rj;
      }

      //Kelas 3
      $crit_k3 = new CDbCriteria();
      $crit_k3->addCondition('pemeriksaanlab_id = ' . $pemeriksaanlab_id);
      $crit_k3->addCondition('kelaspelayanan_id = 5');
      $modTarif_k3 = TarifpemeriksaanlabruanganV::model()->find($crit_k3);

      if (!empty($modTarif_k3)) {
        $modTarif = $modTarif_k3;
      }


      $id_tindakan = null;
      $paket = null;

      /*
                if (!empty($modTarif)) {
                    $crPaket = new CDbCriteria();
                    $crPaket->compare('t.daftartindakan_id', $modTarif->daftartindakan_id);
                    $crPaket->addCondition('t.tipepaket_id <> '.Params::TIPEPAKET_ID_NONPAKET);
                    $crPaket->join = 'left join permintaankepenunjang_t p on t.tindakanpelayanan_id = p.tindakanpelayanan_id';
                    $crPaket->addCondition('p.tindakanpelayanan_id is null');
                    $crPaket->order = 'p.tindakanpelayanan_id asc';

                    $tindakanPaket = TindakanpelayananT::model()->find($crPaket);

                    if (!empty($tindakanPaket)) {
                        $id_tindakan = null;// $tindakanPaket->tindakanpelayanan_id;
                        $paket = TipepaketM::model()->findByPk($tindakanPaket->tipepaket_id);
                    }
                }
                 *
                 */


      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial($this->path_view . '_formLoadPemeriksaanLab', array('modTarif' => $modTarif, 'id_tindakan' => $id_tindakan, 'paket' => $paket), true)
      ));
      exit;
    }
  }

  /**
   * - digunakan untuk mengenerate notif batal rujukan
   * @param type $modKirimKeunitlain
   */
  protected function notifBatalRujuk($modKirimKeunitlain)
  {

    $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain['ruangan_id']);
    $pasien_id = $modKirimKeunitlain['pasien_id'];
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Rujuk Laboratorium';

    $isi = $modKirimKeunitlain['no_pendaftaran'] . ' ' . $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien;


    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modKirimKeunitlain['instalasi_id'], 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
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
  /**
   * set checklist pemeriksaan lab
   */
  public function actionSetChecklistPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {


      $modPemeriksaanLab = new RJTarifpemeriksaanlabruanganV;

      $content = "";
      parse_str($_POST['data'], $post);



      $postPemeriksaan = $post['RJTarifpemeriksaanlabruanganV'];

      // tarif radiologi antar kelas sama
      $critpl = new CDbCriteria;
      $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                          j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id, t.subjenis_pemeriksaanlab_id';
      $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                        JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                        JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                        JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
      $critpl->group = $critpl->select;
      $critpl->order = ' t.pemeriksaanlab_id, t,pemeriksaanlab_urutan ';


      if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD) {
        $critpl->addCondition('k.kelaspelayanan_id = 6');
      } else {
        $critpl->addCondition('k.kelaspelayanan_id = ' . $post['RJPendaftaranT']['kelaspelayanan_id']);
      }



      $critpl->addCondition('t.pemeriksaanlab_aktif = true');
      $critpl->addCondition('j.jenispemeriksaanlab_kelompok = \'PATOLOGI KLINIK\'');

      $critpl->compare('LOWER(t.pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);
      
      $modPeriksaLabAll = RJPemeriksaanLabM::model()->findAll($critpl);
      $modPeriksaLab = array();

      $jenis = null;
      if (isset($postPemeriksaan['jenisform_id']) && !empty($postPemeriksaan['jenisform_id'])) {
        $jenis_detail = CHtml::listData(JenisformdetM::model()->findAllByAttributes(array(
          'jenisform_id' => $postPemeriksaan['jenisform_id']
        )), 'pemeriksaanlab_id', 'pemeriksaanlab_id');

        foreach ($modPeriksaLabAll as $item) {
          if (!in_array($item->pemeriksaanlab_id, $jenis_detail)) {
            continue;
          }
          $modPeriksaLab[] = $item;
        }
      } else {
        $modPeriksaLab = array();
      }

      $arr_jns = [];

      $jns_temp = 0;

      if (count($modPeriksaLab) > 0) {

        foreach ($modPeriksaLab as $per) {

          if ($jns_temp != $per->pemeriksaanlab_id) {

            array_push($arr_jns, $per->jenispemeriksaanlab_id);
          }
        }
      }

      $critJenis = new CdbCriteria();
      $critJenis->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($postPemeriksaan['jenispemeriksaanlab_nama']), true);
      $critJenis->addCondition('jenispemeriksaanlab_aktif = true');


      // echo '<pre>'; var_dump($arr_jns); die();

      // if(count($arr_jns) > 0) {
      $critJenis->addInCondition('jenispemeriksaanlab_id', $arr_jns);
      // }

      $critJenis->order = "jenispemeriksaanlab_urutan";
      $modJenisPeriksaLab = RJJenisPemeriksaanLabM::model()->findAll($critJenis);

      $modPendaftaran = new RJPendaftaranT();

      if (isset($_GET['pendaftaran_id'])) {
        $modPendaftaran = RJPendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
      }
      // echo '<pre>'; var_dump(count($modPemeriksaanlabs), $post, $criteria); die();


      $content = $this->renderPartial(
        $this->path_view . '_checklistPemeriksaanLab',
        array(
          'modJenisPeriksaLab' => $modJenisPeriksaLab, 'modPemeriksaanLab' => $modPemeriksaanLab,
          'modPeriksaLab' => $modPeriksaLab, 'modPendaftaran' => $modPendaftaran
        ),
        true
      );
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }



  public function actionSetChecklistFormLab()
  {
    if (Yii::app()->request->isAjaxRequest) {


      $modPemeriksaanLab = new RJTarifpemeriksaanlabruanganV;

      $content = "";
      parse_str($_POST['data'], $post);


      // echo '<pre>'; var_dump($_POST); die();

      // echo '<pre>'; var_dump(); die();
      $postPemeriksaan = $post['RJTarifpemeriksaanlabruanganV'];

      // tarif radiologi antar kelas sama
      $critpl = new CDbCriteria;
      $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                          r.jenisform_id,
                          r.jenisform_nama,
                          j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
      $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                        JOIN jenisform_m r ON r.jenisform_id = t.jenisform_id
                        JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                        JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                        JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
      $critpl->group = $critpl->select;
      $critpl->order = ' t.pemeriksaanlab_id, t,pemeriksaanlab_urutan ';


      if (!empty($post['RJPendaftaranT']['kelaspelayanan_id'])) {
        $critpl->addCondition('k.kelaspelayanan_id = ' . $post['RJPendaftaranT']['kelaspelayanan_id']);
      }

      $critpl->addCondition('t.pemeriksaanlab_aktif = true');

      $critpl->compare('LOWER(t.pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);


      $modPeriksaLab = RJPemeriksaanLabM::model()->findAll($critpl);

      $arr_jns = [];

      $jns_temp = 0;

      if (count($modPeriksaLab) > 0) {

        foreach ($modPeriksaLab as $per) {

          if ($jns_temp != $per->pemeriksaanlab_id) {

            array_push($arr_jns, $per->jenisform_id);
            array_push($arr_jns, $per->jenispemeriksaanlab_id);
          }
        }
      }

      $critJenis = new CdbCriteria();
      //   $critJenis->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,r.jenisform_id,r.jenisform_nama,
      //                     j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
      // $critJenis->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
      //                   JOIN jenisform_m r ON r.jenisform_id = t.jenisform_id
      //                   JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
      //                   JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
      //                   JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
      // $critJenis->group = $critpl->select;
      // $critJenis->order = ' t.pemeriksaanlab_id, t,pemeriksaanlab_urutan ';

      $critJenis->compare('LOWER(jenisform_nama)', strtolower($postPemeriksaan['jenisform_nama']), true);
      //$critJenis->compare('LOWER(jenisform_id)', strtolower($postPemeriksaan['jenisform_id']), true);
      //$critJenis->addCondition('jenispemeriksaanlab_aktif = true');


      // echo '<pre>'; var_dump($arr_jns); die();

      // if(count($arr_jns) > 0) {
      $critJenis->addInCondition('jenisform_id', $arr_jns);
      //$critJenis->addInCondition('.jenisform_id', $arr_jns);

      // }

      // $critJenis->order = "jenispemeriksaanlab_urutan";
      $modJenisPeriksaLab = RJJenisForm::model()->findAll($critJenis);

      $modPendaftaran = new RJPendaftaranT();

      if (isset($_GET['pendaftaran_id'])) {
        $modPendaftaran = RJPendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
      }
      // echo '<pre>'; var_dump(count($modPemeriksaanlabs), $post, $criteria); die();


      $content = $this->renderPartial(
        $this->path_view . '_checklistPemeriksaanLab',
        array(
          'modJenisPeriksaLab' => $modJenisPeriksaLab, 'modPemeriksaanLab' => $modPemeriksaanLab,
          'modPeriksaLab' => $modPeriksaLab, 'modPendaftaran' => $modPendaftaran
        ),
        true
      );
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }
  public function actionCekTindakan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['sukses'] = 0;
      $data['pesan'] = '';
      $pemeriksaan = [];
      $pemeriksaanlab_id = isset($_POST['pemeriksaanlab_id']) ? $_POST['pemeriksaanlab_id'] : null;
      $daftartindakan_id = [];
      $pendaftaran_id = $_POST['pendaftaran_id'];

      $crit = new CDbCriteria();
      $crit->select = "t.daftartindakan_id, t.pemeriksaanlab_id, p.pendaftaran_id, t.pasienkirimkeunitlain_id";
      $crit->join = "join pasienkirimkeunitlain_t p on p.pasienkirimkeunitlain_id = t.pasienkirimkeunitlain_id ";
      $crit->addCondition('date(t.tglpermintaankepenunjang) = current_date');
      $crit->addCondition('p.pendaftaran_id = ' . $pendaftaran_id);
      // $crit->addInCondition("pemeriksaanlab_id", $pemeriksaanlab_id);
      $modPermintaan = PermintaankepenunjangT::model()->findAll($crit);

      if (!empty($modPermintaan)) {
        $data['sukses'] += 1;
        foreach ($modPermintaan as $key => $det) {
          $pemeriksaan[$det['daftartindakan_id']] = !empty($det->pemeriksaanlab->pemeriksaanlab_nama) ? $det->pemeriksaanlab->pemeriksaanlab_nama : "-";
        }
      }

      $crit1 = new CDbCriteria();
      // $crit1->addInCondition("pemeriksaanlab_id", $pemeriksaanlab_id);
      $modPemeriksaanLab = PemeriksaanlabM::model()->findAll($crit1);
      if (!empty($modPemeriksaanLab)) {
        foreach ($modPemeriksaanLab as $key => $det) {
          $daftartindakan_id[$det['daftartindakan_id']] = $det['daftartindakan_id'];
        }
      }

      $crit2 = new CDbCriteria();
      $crit2->addCondition('date(tgl_tindakan) = current_date');
      $crit2->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $crit2->addInCondition("daftartindakan_id", $daftartindakan_id);
      $modTindakan = TindakanpelayananT::model()->findAll($crit2);

      if (!empty($modTindakan)) {
        $data['sukses'] += 1;
        foreach ($modTindakan as $key => $det) {
          $pemeriksaan[$det['daftartindakan_id']] = $det->daftartindakan->daftartindakan_nama;
        }
      }

      $data_periksa = "";
      if (!empty($pemeriksaan)) {
        foreach ($pemeriksaan as $key => $det) {
          $data_periksa .= "- " . $det . " <br>";
        }
      }

      $data['pemeriksaan'] = $data_periksa;

      if ($data['sukses'] >= 1) {
        $data['pesan'] .= 'Apakah Akan melakukan Permintaan ke Penunjang dengan Pemeriksaan yang Sama?';
        $data['pesan'] .= "<br>";
        $data['pesan'] .= $data['pemeriksaan'];
      }

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  function actionSetJenisPemeriksaanLab() {
    $jenisform_id = $_POST['jenisform_id'];

    $modJenisPemeriksaan = JenispemeriksaansesuaiformV::model()->findAllByAttributes(['jenisform_id' => $jenisform_id], ['order' => 'jenispemeriksaanlab_nama ASC']);
    $option = "<option value> -- Pilih -- </option>";

    if(!empty($modJenisPemeriksaan)) {
      foreach($modJenisPemeriksaan as $i => $data) {
        $option .= "<option value='" . $data->jenispemeriksaanlab_nama . "'> " . $data->jenispemeriksaanlab_nama . " </option>";
      }
    }

    echo json_encode(['option' => $option]);
  }
}
