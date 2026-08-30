<?php
class RuangTindakanController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $path_view = 'rawatJalan.views.ruanganTindakan.';

  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null, $idKonsulTindakan = null)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis' => true));

    $modKonsul = new RJRuangTindakan;
    $modelPendaftaran = new RJPendaftaranT;
    $modKonsul->pasien_id = $modPendaftaran->pasien_id;
    $modKonsul->pendaftaran_id = $pendaftaran_id;
    $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
    $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $modKonsul->asalpoliklinikorder_id = $ruangan_id;

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

    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    if (!empty($idKonsulTindakan)) {
      $modKonsulPoli = RJRuangTindakan::model()->findByPk($idKonsulTindakan);
    } else {
      $modKonsulPoli = new RJRuangTindakan();
    }

    if (isset($_POST['RJRuangTindakan'])) {

      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;

      if (isset($_POST['RJRuangTindakan']['ruangan_id']) && count($_POST['RJRuangTindakan']['ruangan_id']) > 0) {
        foreach($_POST['RJRuangTindakan']['ruangan_id'] as $ruangantujuan_id) {

          $modKonsul = new RJRuangTindakan;
          $modKonsul->attributes = $_POST['RJRuangTindakan'];
          $modelPendaftaran->pasienpulang_id = $modPendaftaran->pasienpulang_id;
          $modelPendaftaran->pasienbatalperiksa_id = $modPendaftaran->pasienbatalperiksa_id;
          if (empty($modelPendaftaran->penanggungjawab_id)) {
            $penanggungjawab = 1;
          } else {
            $penanggungjawab = $modPendaftaran->penanggungjawab_id;
          }
          $modKonsul->no_antrianordertindakan = MyGenerator::noAntrianPPKonsul2($ruangantujuan_id); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
          $modKonsul->pegawaiordertindakan_id = $modKonsul->pegawai_id;
          $modKonsul->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
          $modKonsul->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
          $modKonsul->create_time =  date('Y-m-d H:i:s');
          $modKonsul->create_loginpemakai_id = Yii::app()->user->id;
          $modKonsul->create_ruangan = $ruangantujuan_id;
          $modKonsul->ruangan_id = $ruangantujuan_id;
          $modKonsul->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $modKonsul->pasien_id = $modPendaftaran->pasien_id;
          $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
          $modKonsul->asalpoliklinikorder_id =  $modPendaftaran->pasienadmisi->ruangan_id ?? $modPendaftaran->ruangan_id;
          $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
          // $modKonsul->subjektif_jawaban = $_POST['RJRuangTindakan']['subjektif_jawaban'];
          // $modKonsul->objektif_jawaban = $_POST['RJRuangTindakan']['objektif_jawaban'];
          // $modKonsul->assesment_jawaban = $_POST['RJRuangTindakan']['assesment_jawaban'];
          // $modKonsul->planning_jawaban = $_POST['RJRuangTindakan']['planning_jawaban'];
        

          if ($_POST['RJRuangTindakan']['ruangan_id'] != Params::RUANGAN_ID_HEMODIALISA) {
            $modKonsul->jenisdialisat_id = null;
            $modKonsul->penarikan_cairan = null;
            $modKonsul->lama_hd = null;
            $modKonsul->jenistransfusi_id = null;
            $modKonsul->aksesvaskular_id = null;
          }
    
          // var_dump($modKonsul->attributes, $_POST); die;
    
          if ($modKonsul->validate()) {
            if ($modKonsul->save()) {
    
              $p = PendaftaranT::model()->findByPk($pendaftaran_id);
              $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
    
              /* ================================================ */
              /* Proses update status periksa KonsulPoli EHS-179  */
              /* ================================================ */
              $konsulPoli = RuangTindakanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
              if (!empty($konsulPoli)) {
                $updateStatusPeriksa = RuangTindakanT::model()->updateByPk($konsulPoli->ruangtindakan_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
              }
              /* ================================================ */
    
              PendaftaranT::model()->updateByPk(
                $pendaftaran_id,
                array(
                  'pembayaranpelayanan_id' => null
                )
              );
    
          $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id)->jenistarif_id;

          $criteria = new CDbCriteria();
          $criteria->addCondition('t.komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
          $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
          $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";
          $criteria->addCondition("kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
          $criteria->addCondition("jenistarif_id = " . $jenistarif);

              $modTarif = RJTariftindakanM::model()->find($criteria);
              if (!empty($modTarif)) {
                $modTindakanPelayanan =  new RJTindakanPelayananT;
                $modTindakanPelayanan->ruangtindakan_id = $modKonsul->ruangtindakan_id;
                $modTindakanPelayanan->pasien_id = $modPendaftaran->pasien_id;
                $modTindakanPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modTindakanPelayanan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modTindakanPelayanan->shift_id     = $modPendaftaran->shift_id;
                $modTindakanPelayanan->carabayar_id = $modPendaftaran->carabayar_id;
                $modTindakanPelayanan->penjamin_id = $modPendaftaran->penjamin_id;
                $modTindakanPelayanan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $modTindakanPelayanan->ruangan_id   = $modKonsul->ruangan_id;
                $modTindakanPelayanan->instalasi_id = $modTindakanPelayanan->ruangan->instalasi_id;
                $modTindakanPelayanan->cyto_tindakan = 0;
                $modTindakanPelayanan->tarifcyto_tindakan = 0;
                $modTindakanPelayanan->discount_tindakan = 0;
                $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
                $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
                $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
                $modTindakanPelayanan->iurbiaya_tindakan = 0;
                $modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
                $modTindakanPelayanan->create_ruangan = $modKonsul->ruangan_id;
                $modTindakanPelayanan->create_time =  date('Y-m-d H:i:s');
                $modTindakanPelayanan->satuantindakan = "Hari";
    
                $modTindakanPelayanan->daftartindakan_id = $modTarif->daftartindakan_id;
                $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
    
                $modTindakanPelayanan->tarif_satuan = (isset($modTarif->harga_tariftindakan) ? $modTarif->harga_tariftindakan : 0);
                $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;
    
                if ($modTindakanPelayanan->validate()) {
                  if ($modTindakanPelayanan->save()) {
                    $valid = true;
                    $modTindakanPelayanan->saveTindakanKomponen2();
                  }
                }
              }
              /* ================================================ */
    
              /** AWAL
               * Notifikasi Antar Poliklinik, notifikasi ditampilkan ke polik tujuan
               * 
               * 
               */
    
              $judul = 'Pasien Ruangan Tindakan';

              $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' telah ditujukan ke ruangan ' . $modKonsul->ruangtujuan->ruangan_nama . ' pada ' . $modKonsul->tglordertindakan . ' dari ' . $modKonsul->ruangasal->ruangan_nama;
    
              $ruangan = RuangTindakanT::model()->findByAttributes(array('ruangan_id'=>$modKonsul->ruangan_id));
              $ruangan2 = RuanganM::model()->findByPk($modKonsul->ruangan_id);
              
    
    
              $ok_notif = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $ruangan->instalasi_id ?? "", 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id ?? ""),
              ));


              $ok_notif2 = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $ruangan2->instalasi_id, 'ruangan_id' => $ruangan2->ruangan_id, 'modul_id' => $ruangan2->modul_id),
              ));
    
              /** AKHIR **/
    
    
              // SMS GATEWAY
              /*
              $modPegawai = $modPendaftaran->pegawai;
              $modRuangan = $modKonsul->politujuan;
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
                $attributes = $modKonsul->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modRuangan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKonsul->tglkonsulpoli), $isiPesan);
    
                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                  if (!empty($modPasien->no_mobile_pasien)) {
                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                  } else {
                    $smspasien = 0;
                  }
                }
              }
              */
    
            } else {
            //  var_dump($modKonsul->errors);
              $ok = false;
            }
          } else {
          //  var_dump($modKonsul->errors);
            $ok = false;
          }
          
        }
        
        
      }

    //  vaR_dump($ok); die;

      if ($ok) {
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id));
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $modRiwayatKonsul = RJRuangTindakan::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'asalpoliklinikorder_id' => $ruangan_id));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKonsul' => $modKonsul,
      'karcisTindakan' => $karcisTindakan,
      'modRiwayatKonsul' => $modRiwayatKonsul,
      'modelPendaftaran' => $modelPendaftaran,
      'modKonsulPoli' => $modKonsulPoli, //added  - data ini digunakan untuk membuat notifikasi yang dikirim untuk ruangan asal
      'modJenisTarif' => $modJenisTarif
    ));
  }


  public function actionAjaxDetailKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $konsulantarpoli_id = $_POST['idKonsulAntarTindakan'];
      $modKonsulPoli = RJRuangTindakan::model()->findByPk($konsulantarpoli_id);
      $modPendaftaran = RJPendaftaranT::model()->findByPk($modKonsulPoli->pendaftaran_id);
      $data['result'] = $this->renderPartial($this->path_view . '_viewRuangTindakan', array('modKonsul' => $modKonsulPoli, 'modPendaftaran' => $modPendaftaran), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Detail hasil jawaban konsul poli dengan fungsi ajax
   */

  // public function actionIndex($pengperawatanlinen_id = null, $linkHalaman = null)
  // {
  //   $this->pageTitle = Yii::app()->name . " - Pengajuan Perawatan";
  //   $format = new MyFormatter;
  //   if (isset($pengperawatanlinen_id)) {
  //     $model = LAPengperawatanlinenT::model()->findByPk($pengperawatanlinen_id);
  //     $model->pegawaimengajukan_nama = isset($model->mengajukan_id) ? $model->pegawaiMengajukan->nama_pegawai : '';
  //     $model->pegawaimengetahui_nama = isset($model->mengetahui_id) ? $model->pegawai->nama_pegawai : '';
  //   } else {
  //     $model = new LAPengperawatanlinenT;
  //     $model->pengperawatanlinen_no = MyGenerator::noPengPerawatanLinen();
  //     $model->pengperawatanlinen_id =  Yii::app()->user->getState('pegawai_id');
  //     $model->pegawaimengajukan_nama = PegawaiM::model()->findByPk($model->pengperawatanlinen_id )->nama_pegawai;
  //   }   


  public function actionAjaxDetailKonsulHasil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKonsulAntarTindakan = $_POST['idKonsulAntarTindakan'];
      $modKonsulPoli = RJRuangTindakan::model()->findByPk($idKonsulAntarTindakan);
      $modMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $modKonsulPoli->pendaftaran_id,
        'ruangan_id' => $modKonsulPoli->ruangan_id,
      ));
      if (!empty($modKonsulPoli->pegawaiordertindakan_id)) {
        $modKonsulPoli->nama_pegawai = PegawaiM::model()->findByPk($modKonsulPoli->pegawaiordertindakan_id)->nama_pegawai;
      }

      $data['result'] = $this->renderPartial($this->path_view . '_viewRuangTindakanHasil', array('modKonsul' => $modKonsulPoli, 'modMorbiditas' => $modMorbiditas), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAjaxBatalKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $konsulantarpoli_id = (isset($_POST['idKonsulAntarTindakan']) ? $_POST['idKonsulAntarTindakan'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);

      $tindakanpelayanan = RJTindakanPelayananT::model()->findByAttributes(array('konsulpoli' => $konsulantarpoli_id));
      if (!empty($tindakanpelayanan)) {
        TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayanan->tindakanpelayanan_id));
        RJTindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);
      }

      RJRuangTindakan::model()->deleteByPk($konsulantarpoli_id);
      $modRiwayatKonsul = RJRuangTindakan::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $data['result'] = $this->renderPartial($this->path_view . '_listRuangTindakan', array('modRiwayatKonsul' => $modRiwayatKonsul), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * ajax untuk menampilkan tarif tindakan konsultasi poliklinik
   */
  public function actionAjaxSetTarif()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $ruangan = RuanganM::model()->findByPk($ruangan_id);
      $ruangan_nama = $ruangan->ruangan_nama;
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id)->jenistarif_id;

      $criteria = new CDbCriteria();
      $criteria->addCondition('t.komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
      $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
      $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";



      if (!empty($kelaspelayanan_id)) {
        $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
      }
      if (!empty($jenistarif)) {
        $criteria->addCondition("jenistarif_id = " . $jenistarif);
      }
      // var_dump($criteria); die;
      $model = TariftindakanM::model()->findAll($criteria);

      $data['result'] = $this->renderPartial($this->path_view . '_listTarifRuangan', array('model' => $model, 'ruangan_nama' => $ruangan_nama), true);
      $data['dokter'] = $this->loadDokterRuangan($ruangan_id);


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  protected function loadDokterRuangan($ruangan_id)
  {
    $dokter = DokterV::model()->findAllByAttributes(array(
      'pegawai_aktif' => true,
      'ruangan_id' => $ruangan_id,
    ));
    $dat = CHtml::listData($dokter, 'pegawai_id', 'namaLengkap');
    $str = count((array)$dat) > 1 ? '<option value="">-- Pilih --</option>' : '';
    foreach ($dat as $val => $item) {
      $str .= '<option value="' . $val . '">' . $item . '</option>';
    }

    return $str;
  }

  public function actionPrint()
  {
    $modKonsul = new RJRuangTindakan;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $ruangtindakan_id = (isset($_GET['idKonsulTindakan']) ? $_GET['idKonsulTindakan'] : null);
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

    //            $modKonsulPoli = RJKonsulPoliT::model()->findByPk($idKonsulAntarTindakan);
    $modRiwayatKonsul = RJRuangTindakan::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangtindakan_id' => $ruangtindakan_id));

    $judulLaporan = 'Permintaan Ruangan Tindakan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $modKonsul = new RJRuangTindakan;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKonsul = RJRuangTindakan::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judulLaporan = 'Permintaan Ruangan Tindakan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
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
}
