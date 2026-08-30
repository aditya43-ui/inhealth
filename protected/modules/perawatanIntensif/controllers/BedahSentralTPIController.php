<?php
//Yii::import('rawatJalan.controllers.BedahSentralController');
//Yii::import('rawatJalan.models.*');
//class BedahSentralTPIController extends BedahSentralController
//{
//        
//}
class BedahSentralTPIController extends MyAuthController
{
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = array();
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKegiatanOperasi = PIKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif' => true), array('order' => 'kegiatanoperasi_nama'));
    $modOperasi = PIOperasiM::model()->findAllByAttributes(array('operasi_aktif' => true), array('order' => 'operasi_nama'));
    $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = isset($modAdmisi->pegawai_id) ? $modAdmisi->pegawai_id : $modPendaftaran->pegawai_id;

    //untuk pencarian 
    $kegiatanOperasiSearch = new PIKegiatanOperasiM;
    $operasiSearch = new PIOperasiM;

    if (isset($_GET['idPasienKirimKeUnitLain'])) {
      $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modAdmisi->penjamin_id);
    if (isset($_POST['PIPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi);
        if (isset($_POST['permintaanPenunjang'])) {
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }
        
        $modKirimAnestesi = $this->savePasienKirimKeUnitLainAnestesi($modPendaftaran, $modKirimKeUnitLain->pasienkirimkeunitlain_id);

        $this->savePermintaanPenunjangAnestesi($modKirimAnestesi);

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

    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'instalasi_id' => Params::INSTALASI_ID_IBS
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $modBayarUangMuka = PIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
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
      'kegiatanOperasiSearch' => $kegiatanOperasiSearch,
      'operasiSearch' => $operasiSearch,
    ));
  }

  protected function savePasienKirimKeUnitLain($modAdmisi)
  {
    $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->attributes = $_POST['PIPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
    $modKirimKeUnitLain->pegawai_id = $modAdmisi->pegawai_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
    $modKirimKeUnitLain->ppds_id = isset($_POST['PIPasienKirimKeUnitLainT']['ppds_id']) ? $_POST['PIPasienKirimKeUnitLainT']['ppds_id'] : false;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_IBS;
    // $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_BEDAH;
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    //            $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->create_ruangan = $modAdmisi->ruangan_id;
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
      $modPermintaan = new PIPermintaanPenunjangT;
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

  public function actionBatalRujukan($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = '';

      $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
        'ruangan_id' => Params::RUANGAN_ID_BEDAH
      ));

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('t.pasienkirimkeunitlain_id = ' . $pasienkirimkeunitlain_id);
        $criteria->addCondition('tindakanpelayanan_t.tindakansudahbayar_id is not null');
        $criteria->join = 'JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
        $modPermintaanPenunjang = PermintaankepenunjangT::model()->findAll($criteria);

        if (count((array)$modPermintaanPenunjang) > 0) {
          $pesan = "Pemeriksaan Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
        } else {
          $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
          if (count((array)$modPermintaanKePenunjang) > 0) {
            foreach ($modPermintaanKePenunjang as $i => $detail) {
              $update_tindakanpelayanan = TindakanpelayananT::model()->updateByPk($detail->tindakanpelayanan_id, array(
                'detailhasilpemeriksaanlab_id' => null,
                'hasilpemeriksaanrm_id' => null,
                'hasilpemeriksaanrad_id' => null,
                'hasilpemeriksaanpa_id' => null
              ));

              if ($update_tindakanpelayanan) {
                $update_tindakan = true;
                $status = true;
              } else {
                $update_tindakan = false;
                $status = false;
              }

              $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteByPk($detail->tindakanpelayanan_id);
              if ($delete_tindakanpelayanan) {
                $delete_tindakan = true;
                $status = true;
              } else {
                $delete_tindakan = false;
                $status = false;
              }
            }
            if ($status = true) {
              $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
              if ($delete_permintaankepenunjang) {
                $delete_penunjang = true;
                PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                $status = true;
              } else {
                $delete_penunjang = false;
                $status = false;
              }
            }
          } else {
            $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            if ($delete_permintaankepenunjang) {
              $delete_penunjang = true;
              PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
              $status = true;
            } else {
              $delete_penunjang = false;
              $status = false;
            }
          }

          if ($status = true) {
            $pesan = 'Pasien Penunjang berhasil di batalkan';
            $transaction->commit();
          } else {
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "exist";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
        'result' => $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true)
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //        public function actionAjaxBatalKirim()
  //        {
  //            if(Yii::app()->request->isAjaxRequest) {
  //            $idPasienKirimKeUnitLain = $_POST['idPasienKirimKeUnitLain'];
  //            $pendaftaran_id = $_POST['pendaftaran_id'];
  //            
  //            PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
  //            PasienkirimkeunitlainT::model()->deleteByPk($idPasienKirimKeUnitLain);
  //            $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
  //                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_BEDAH));
  //            
  //            $data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);
  //
  //            echo json_encode($data);
  //             Yii::app()->end();
  //            }
  //        }

  public function actionSetChecklistOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postKegiatanOperasi = $post['PIKegiatanOperasiM'];
      $postOperasi = $post['PIOperasiM'];

      $criteria = new CdbCriteria();
      if (!empty($postKegiatanOperasi['kegiatanoperasi_nama'])) {
        $criteria->compare('LOWER(t.kegiatanoperasi_nama)', strtolower($postKegiatanOperasi['kegiatanoperasi_nama']), true);
      }

      $criteria->addCondition('t.kegiatanoperasi_aktif is TRUE');
      $modKegiatanOperasi = PIKegiatanOperasiM::model()->findAll($criteria);

      $criteria2 = new CdbCriteria();
      if (!empty($postOperasi['operasi_nama'])) {
        $criteria2->compare('LOWER(operasi_nama)', strtolower($postOperasi['operasi_nama']), true);
      }
      $criteria2->addCondition('operasi_aktif is TRUE');
      $modOperasi = PIOperasiM::model()->findAll($criteria2);

      $content = $this->renderPartial('_formOperasi', array('modKegiatanOperasi' => $modKegiatanOperasi, 'modOperasi' => $modOperasi), true);

      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(
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
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), 'pasienmasukpenunjang_id IS NULL');
    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
  
  /**
     * fungsi simpan ke tabel pasienkirimkeunitlain_t
     * @param type $modPendaftaran
     * @param type $parentbedah_id
     * @return \PIPasienKirimKeUnitLainT
     */
    protected function savePasienKirimKeUnitLainAnestesi($modPendaftaran, $parentbedah_id) {
        $format = new MyFormatter();
        $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
        $modKirimKeUnitLain->attributes = $_POST['PIPasienKirimKeUnitLainT'];
        $modKirimKeUnitLain->no_permintaan = MyGenerator::generateNomorPermintaan(Yii::app()->user->getState('ruangan_id'));
        $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
        $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        //$modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
        $modKirimKeUnitLain->pegawai_id = $_POST['PIPasienKirimKeUnitLainT']['pegawai_id'];
        $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_ANESTESI;
        $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_ANASTESI;
        $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['PIPasienKirimKeUnitLainT']['tgl_kirimpasien']);
//        $modKirimKeUnitLain->ops_tgl = !empty($modKirimKeUnitLain->ops_tgl) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tgl) : null;
//        $modKirimKeUnitLain->ops_tglmrs = !empty($modKirimKeUnitLain->ops_tglmrs) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tglmrs) : null;
        $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
        $modKirimKeUnitLain->update_loginpemakai_id = $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
        $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
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
     * @param type $modKirimKeUnitLain
     */
    protected function savePermintaanPenunjangAnestesi($modKirimKeUnitLain) {
        $r = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
        $init = !empty($r->ruangan_singkatan) ? $r->ruangan_singkatan : 'AR';

        $modPermintaan = new PIPermintaanPenunjangT;
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
