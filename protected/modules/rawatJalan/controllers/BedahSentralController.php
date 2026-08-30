<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); //RND-6398
class BedahSentralController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  protected $tindakanpelayanantersimpan = true;
  protected $komponentindakantersimpan = true;
  protected $path_view = 'rawatJalan.views.bedahSentral.';

  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null)
  {
//      var_dump($this->path_view);die();
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKegiatanOperasi = RJKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif' => true), array('order' => 'kegiatanoperasi_nama'));
    $modOperasi = RJOperasiM::model()->findAllByAttributes(array('operasi_aktif' => true), array('order' => 'operasi_nama'));
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);
    $modPemeriksaanBedah = new RJTarifoperasiruanganV;
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

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {
      
      $transaction = Yii::app()->db->beginTransaction();
      
      try {
        // if($_POST['RJPasienKirimKeUnitLainT']['is_cyto'] == 1){

        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = true;
        // } else{
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = false;
          
        // }
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran);
        
        if (isset($_POST['permintaanPenunjang'])) {
          
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
          // var_dump("test1");die;
           $modKirimAnestesi = $this->savePasienKirimKeUnitLainAnestesi($modPendaftaran, $modKirimKeUnitLain->pasienkirimkeunitlain_id);

            $this->savePermintaanPenunjangAnestesi($modKirimAnestesi);
          
          PendaftaranT::model()->updateByPk(
            $pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );

          //                        RND-6398
          //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
          //                        $params['create_time'] = date( 'Y-m-d H:i:s');
          //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
          //                        $params['instalasi_id'] = Params::INSTALASI_ID_IBS;
          //                        $params['modul_id'] = 11;
          //                        $ruangan = RuanganM::model()->findByPk($ruangan_id);
          //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
          //                        $params['create_ruangan'] = Params::RUANGAN_ID_BEDAH;
          //                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
          //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);

        } else {
          $this->statusSavePermintaanPenunjang = true;
          
        }
        $judul = 'Pasien ' . Yii::app()->user->getState('instalasi_nama') . ' Rujuk ke Bedah Sentral';

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
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $ins_hemo = RuanganhemodialisaV::arrIns();
            if (in_array($modPendaftaran->instalasi_id, $ins_hemo)) {
                $cri = new CDbCriteria;
                $cri->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id ";
                $cri->addInCondition("r.instalasi_id", $ins_hemo);
                $cri->addCondition(" pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
                $modKonsulPoli = KonsulpoliT::model()->find($cri);
                if (!empty($modKonsulPoli)) {
                    $modKonsulPoli->update_time = date("Y-m-d h:i:s");
                    $modKonsulPoli->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                    $modKonsulPoli->save(); 
                } else {
                    $modPendaftaran->update_time = date("Y-m-d h:i:s");
                    $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                    $modPendaftaran->save(); 
                }
            }
            
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
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
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id, 'smspasien' => $smspasien,'sukses'=>1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {          
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'instalasi_id' => Params::INSTALASI_ID_IBS,
      ),
      'pasienmasukpenunjang_id IS NULL'
    );
    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKegiatanOperasi' => $modKegiatanOperasi,
      'modOperasi' => $modOperasi,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif,
      'modPemeriksaanBedah' => $modPemeriksaanBedah
    ));
  }

  protected function savePasienKirimKeUnitLain($modPendaftaran)
  {
    $format = new MyFormatter();
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modKirimKeUnitLain->ppds_id = isset($_POST['RJPasienKirimKeUnitLainT']['ppds_id']) ? $_POST['RJPasienKirimKeUnitLainT']['ppds_id'] : false;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_IBS;
    // $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_BEDAH;
    $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
    $modKirimKeUnitLain->is_cito = isset($_POST['RJPasienKirimKeUnitLainT']['is_cito']) ? $_POST['RJPasienKirimKeUnitLainT']['is_cito'] : false;
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();

      $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
      $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);

      /* ================================================ */
      /* Proses update status periksa KonsulPoli EHS-179  */
      /* ================================================ */
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
      if (!empty($konsulPoli)) {
        $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
      }
      /* ================================================ */
      PendaftaranT::model()->updateByPk(
        $modPendaftaran->pendaftaran_id,
        array(
          'pembayaranpelayanan_id' => null
        )
      );
      $this->statusSaveKirimkeUnitLain = true;
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan['inputoperasi'] as $i => $value) {
      $modPermintaan = new RJPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = isset($permintaan['idDaftarTindakan'][$i]) ? $permintaan['idDaftarTindakan'][$i] : null;
      // $modPermintaan->daftartindakan_id = '';
      $modPermintaan->pemeriksaanlab_id = '';
      $modPermintaan->operasi_id = $permintaan['inputoperasi'][$i];
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PB');
      $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
      $modPermintaan->tarif_pelayananan = $permintaan['inputtarifoperasi'][$i];
      $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
      if($modKirimKeUnitLain->is_cyto == true){
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->operasi->daftartindakan_id));
                                                                            // 'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = $modTarif->totaltarifakhir_cyto;
      }else{
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->operasi->daftartindakan_id));
                                                                            // 'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = !empty($modTarif->harga_tariftindakan)?$modTarif->harga_tariftindakan:0;
      }
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
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id)->jenistarif_id;
      $modOperasi = OperasiM::model()->with('kegiatanoperasi')->findByPk($operasi_id);
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
        'form' => $this->renderPartial($this->path_view . '_formLoadPermintaanOperasi', array(
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
      //$idPasienKirimKeUnitLain = $_POST['idPasienKirimKeUnitLain'];
      //$pendaftaran_id = $_POST['pendaftaran_id'];

      //PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
      //PasienkirimkeunitlainT::model()->deleteByPk($idPasienKirimKeUnitLain);
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

      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
        'ruangan_id' => Params::RUANGAN_ID_BEDAH,
        'pasienmasukpenunjang_id' => null
      ));

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

    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), 'pasienmasukpenunjang_id IS NULL');
    $modKirim = RJPasienKirimKeUnitLainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), 'pasienmasukpenunjang_id IS NULL');

    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim), true));
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
     * Simpan data tabel pasienkirimunitlain_t dengan instalasi_id = instalasi anestesi
     * @param type $modPendaftaran
     * @param type $parentbedah_id
     * @return \RJPasienKirimKeUnitLainT
     */
    protected function savePasienKirimKeUnitLainAnestesi($modPendaftaran, $parentbedah_id) {
        
        $ranas = RuangananestesiV::model()->find();
        
        $format = new MyFormatter();
        $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
        $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];        
        $modKirimKeUnitLain->no_permintaan = MyGenerator::generateNomorPermintaan(Yii::app()->user->getState('ruangan_id'));        
        $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
        $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;        
        $modKirimKeUnitLain->pegawai_id = $_POST['RJPasienKirimKeUnitLainT']['pegawai_id'];
        $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        // $modKirimKeUnitLain->instalasi_id = !empty($ranas)?$ranas->instalasi_id:Params::INSTALASI_ID_ANESTESI;
        $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_ANESTESI;
        $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_ANASTESI;
        $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);        
        
//        $modKirimKeUnitLain->ops_tgl = !empty($modKirimKeUnitLain->ops_tgl) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tgl) : null;
//        $modKirimKeUnitLain->ops_tglmrs = !empty($modKirimKeUnitLain->ops_tglmrs) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tglmrs) : null;
        $modKirimKeUnitLain->update_time = $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
        $modKirimKeUnitLain->update_loginpemakai_id = $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
        $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
        $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
        $modKirimKeUnitLain->pasienkirimkeunitlainparent_id = $parentbedah_id;
        $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;                           
        if ($modKirimKeUnitLain->save()){
            $this->statusSaveKirimkeUnitLain  = true;
        }else{
            $this->statusSaveKirimkeUnitLain  = false;
        }  
        return $modKirimKeUnitLain;
    }
    
    /**
     * fungsi simpan ke tabel PermintaanPenunjang_t untuk anestesi     
     * @param type $modKirimKeUnitLain
     */
    protected function savePermintaanPenunjangAnestesi($modKirimKeUnitLain) {
        $r = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
        $init = !empty($r->ruangan_singkatan) ? $r->ruangan_singkatan : 'AR';

        $modPermintaan = new RJPermintaanPenunjangT;
        $modPermintaan->daftartindakan_id = null;
        $modPermintaan->pemeriksaanlab_id = null;
        $modPermintaan->operasi_id = null;
        $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
        $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($init);
        $modPermintaan->qtypermintaan = 1;
        $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
        
        $this->statusSavePermintaanPenunjang &= $modPermintaan->save();                        
    }

     /**
   * set checklist pemeriksaan bedah
   */
  public function actionSetChecklistPemeriksaanBedah()
  {
    if (Yii::app()->request->isAjaxRequest) {
        $content = "";
        $modPendaftaran = RJPendaftaranT::model()->findByAttributes(['pendaftaran_id' => $_POST['pendaftaran_id']]);

        $critKategori = new CdbCriteria();
        $critKategori->select = 't.kegiatanoperasi_id, t.kegiatanoperasi_nama';
        $critKategori->group = 't.kegiatanoperasi_id, t.kegiatanoperasi_nama';
        $critKategori->join = ' JOIN operasi_m o ON o.kegiatanoperasi_id = t.kegiatanoperasi_id ';
        $critKategori->compare('LOWER(t.kegiatanoperasi_nama)', strtolower($_POST['keg_operasi']), true);
        $critKategori->compare('LOWER(o.operasi_nama)', strtolower($_POST['operasi']), true);
        $critKategori->addCondition(' t.kegiatanoperasi_aktif is true ');
        $modKegiatanOperasi = RJKegiatanOperasiM::model()->findAll($critKategori);

        $critOperasi = new CdbCriteria();
        $critOperasi->compare('LOWER(operasi_nama)', strtolower($_POST['operasi']), true);
        $critOperasi->addCondition(' operasi_aktif is true ');
        $critOperasi->order = "operasi_nama";
        $modOperasi = OperasiM::model()->findAll($critOperasi);

        $content = $this->renderPartial($this->path_view . '_formOperasi', array('modKegiatanOperasi' => $modKegiatanOperasi, 'modOperasi' => $modOperasi), true);

      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }
    
}
