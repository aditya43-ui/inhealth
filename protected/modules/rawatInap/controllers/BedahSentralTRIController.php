<?php
//Yii::import('rawatJalan.controllers.BedahSentralController');
//Yii::import('rawatJalan.models.*');
//class BedahSentralTRIController extends BedahSentralController
//{
//        
//}
class BedahSentralTRIController extends MyAuthController
{
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = array();
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKegiatanOperasi = RIKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif' => true), array('order' => 'kegiatanoperasi_nama'));
    $modOperasi = RIOperasiM::model()->findAllByAttributes(array('operasi_aktif' => true), array('order' => 'operasi_nama'));
    $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modAdmisi->pegawai_id;

    if (isset($_GET['idPasienKirimKeUnitLain'])) {
      $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modAdmisi->penjamin_id);
    if (isset($_POST['RIPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        // if($_POST['RIPasienKirimKeUnitLainT']['is_cyto'] == 1){
        //   $_POST['RIPasienKirimKeUnitLainT']['is_cyto'] = true;
        // } else{
        //   $_POST['RIPasienKirimKeUnitLainT']['is_cyto'] = false;
        // }
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi);
        if (isset($_POST['permintaanPenunjang'])) {
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }
        
        $modKirimAnestesi = $this->savePasienKirimKeUnitLainAnestesi($modPendaftaran, $modKirimKeUnitLain->pasienkirimkeunitlain_id);

        $this->savePermintaanPenunjangAnestesi($modKirimAnestesi);
        
        $judul = 'Pasien Rawat Inap Rujuk ke Bedah Sentral';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
        $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

        // var_dump($mr->attributes); die;
        $link = $this->createUrl('/bedahSentral/RujukanPenunjang/Index', array(
          'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[no_pendaftaran]' => $modKirimKeUnitLain->pendaftaran->no_pendaftaran,
          'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
          'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
        ));


        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
          // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
        ));
        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'instalasi_id' => Params::INSTALASI_ID_IBS,
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $modBayarUangMuka = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $total = 0;
    foreach ($modBayarUangMuka as $key => $value) {
      $total += $modBayarUangMuka[$key]->jumlahuangmuka;
    }
    $modDeposit = (($modBayarUangMuka) ? $total : null);

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKegiatanOperasi' => $modKegiatanOperasi,
      'modOperasi' => $modOperasi,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modAdmisi' => $modAdmisi,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modJenisTarif' => $modJenisTarif,
      'modDeposit' => $modDeposit,
    ));
  }

  protected function savePasienKirimKeUnitLain($modAdmisi)
  {
    $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
    $modKirimKeUnitLain->pegawai_id = $modAdmisi->pegawai_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
    $modKirimKeUnitLain->ppds_id = isset($_POST['RIPasienKirimKeUnitLainT']['ppds_id']) ? $_POST['RIPasienKirimKeUnitLainT']['ppds_id'] : false;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_IBS;
    // $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_BEDAH;
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->is_cito = isset($_POST['RIPasienKirimKeUnitLainT']['is_cito']) ? $_POST['RIPasienKirimKeUnitLainT']['is_cito'] : false;
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();
      $this->statusSaveKirimkeUnitLain = true;
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan['inputoperasi'] as $i => $value) {
      $modPermintaan = new RIPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = '';     //$permintaan['idDaftarTindakan'][$i];
      $modPermintaan->pemeriksaanlab_id = '';
      $modPermintaan->operasi_id = $permintaan['inputoperasi'][$i];
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PB');
      $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
      $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
      if ($modPermintaan->validate()) {
        $modPermintaan->save();
        $this->statusSavePermintaanPenunjang = true;
      }
    }
  }
  /**
   * untuk ajax action load tindakan operasi
   */
  public function actionLoadFormPermintaanOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $operasi_id = isset($_POST['operasi_id']) ? $_POST['operasi_id'] : null;
      $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPasienAdmisi->penjamin_id)->jenistarif_id;
      $modOperasi = OperasiM::model()->with('kegiatanoperasi')->findByPk($operasi_id);

      // var_dump($modOperasi->attributes); die;

      $criteria = new CDbCriteria();
      $criteria->addCondition('daftartindakan_id =' . $modOperasi->daftartindakan_id);
      $criteria->addCondition('kelaspelayanan_id =' . $kelaspelayanan_id);
      $criteria->addCondition('jenistarif_id =' . $jenistarif);
      $criteria->addCondition('komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);

      $modTarif = TariftindakanM::model()->find($criteria);
      /**
       * dicomment RND-3284
       */
      //                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modOperasi->daftartindakan_id,
      //                                                                            'kelaspelayanan_id'=>$kelaspelayanan_id,
      //                                                                            'jenistarif_id'=>$jenistarif,
      //                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));


      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadPermintaanOperasi', array(
          'modOperasi' => $modOperasi,
          'kelaspelayanan_id' => $kelaspelayanan_id,
          'modTarif' => $modTarif
        ), true)
      ));
      exit;
    }
  }

  public function actionAjaxBatalKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $pasienkirimkeunitlain_id = $_POST['idPasienKirimKeUnitLain'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!";
      $data['sukses'] = 0;
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

            $data['pesan'] = "Pasien kirim ke bedah sentral berhasil dibatalkan!";
            $data['sukses'] = 1;
            $transaction->commit();
          } else {
            $transaction->rollback();
            $data['pesan'] = "Pasien kirim ke bedah sentral tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
            $data['sukses'] = 0;
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Pasien kirim ke bedah sentral gagal dibatalkan karena tindakan sudah dibayarkan!";
        $data['sukses'] = 0;
      }
      //$idPasienKirimKeUnitLain = $_POST['idPasienKirimKeUnitLain'];
      //$pendaftaran_id = $_POST['pendaftaran_id'];

      //PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
      //PasienkirimkeunitlainT::model()->deleteByPk($idPasienKirimKeUnitLain);
      $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
        'ruangan_id' => Params::RUANGAN_ID_BEDAH,
        'pasienmasukpenunjang_id' => null
      ));

      $data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modAdmisi' => $modAdmisi, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modAdmisi' => $modAdmisi, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('modPendaftaran' => $modPendaftaran, 'modAdmisi' => $modAdmisi, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), 'pasienmasukpenunjang_id IS NULL');
    $modKirim = RIPasienKirimKeUnitLainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), 'pasienmasukpenunjang_id IS NULL');
    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim), true));
      $mpdf->Output();
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
    $judul = 'Pasien Batal Rujuk Bedah Sentral';

    $isi = $modKirimKeunitlain['no_pendaftaran'] . ' ' . $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien;


    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modKirimKeunitlain['instalasi_id'], 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
  }

  /**
     * fungsi simpan ke tabel pasienkirimkeunitlain_t
     * @param type $modPendaftaran
     * @param type $parentbedah_id
     * @return \RIPasienKirimKeUnitLainT
     */
    protected function savePasienKirimKeUnitLainAnestesi($modPendaftaran, $parentbedah_id) {
        $format = new MyFormatter();
        $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
        $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
        $modKirimKeUnitLain->no_permintaan = MyGenerator::generateNomorPermintaan(Yii::app()->user->getState('ruangan_id'));
        $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
        $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        //$modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
        $modKirimKeUnitLain->pegawai_id = $_POST['RIPasienKirimKeUnitLainT']['pegawai_id'];
        $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_ANESTESI;
        $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_ANASTESI;
        $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RIPasienKirimKeUnitLainT']['tgl_kirimpasien']);
//        $modKirimKeUnitLain->ops_tgl = !empty($modKirimKeUnitLain->ops_tgl) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tgl) : null;
//        $modKirimKeUnitLain->ops_tglmrs = !empty($modKirimKeUnitLain->ops_tglmrs) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tglmrs) : null;
        $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
        $modKirimKeUnitLain->update_loginpemakai_id = $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
        $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
//        $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
        $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
        $modKirimKeUnitLain->pasienkirimkeunitlainparent_id = $parentbedah_id;
        if ($modKirimKeUnitLain->validate()) {
            $modKirimKeUnitLain->save();

            $this->statusSaveKirimkeUnitLain = true;
        }

        return $modKirimKeUnitLain;
    }
    
    /**
     * fungsi simpan ke tabel PermintaanPenunjang_t untuk anestesi
     * @param type $permintaan
     * @param type $modKirimKeUnitLain
     */
    protected function savePermintaanPenunjangAnestesi($modKirimKeUnitLain) {
        $r = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
        $init = !empty($r->ruangan_singkatan) ? $r->ruangan_singkatan : 'AR';

        $modPermintaan = new RIPermintaanPenunjangT;
        $modPermintaan->daftartindakan_id = null;
        $modPermintaan->pemeriksaanlab_id = null;
        $modPermintaan->operasi_id = null;
        $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
        $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($init);
        $modPermintaan->qtypermintaan = 1;
        $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
        if ($modPermintaan->validate()) {
            $modPermintaan->save();
            $this->statusSavePermintaanPenunjang = true;
        }
    }
}
