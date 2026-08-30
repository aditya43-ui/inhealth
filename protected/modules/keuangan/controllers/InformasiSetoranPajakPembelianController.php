<?php
class InformasiSetoranPajakPembelianController extends MyAuthController
{
  protected $successSave = true;
  protected $pesan = "succes";
  protected $path_view = "keuangan.views.informasiSetoranPajakPembelian.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Setoran Pajak Pembelian";
    $model = new KUInformasisetoranpajakpembelianV();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tglnyetor_awal = date('Y-m-d');
    $model->tglnyetor_akhir = date('Y-m-d');
    $model->ceklis = false;

    if (isset($_GET['KUInformasisetoranpajakpembelianV'])) {
      $model->attributes = $_GET['KUInformasisetoranpajakpembelianV'];
      $model->ceklis = $_GET['KUInformasisetoranpajakpembelianV']['ceklis'];
      $model->status_penyetoran = $_GET['KUInformasisetoranpajakpembelianV']['status_penyetoran'];
      $model->status_pembatalan = $_GET['KUInformasisetoranpajakpembelianV']['status_pembatalan'];
      $model->tgl_awal = $format->formatDateTimeForDB($_GET['KUInformasisetoranpajakpembelianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDB($_GET['KUInformasisetoranpajakpembelianV']['tgl_akhir']);
      $model->tglnyetor_awal = $format->formatDateTimeForDB($_GET['KUInformasisetoranpajakpembelianV']['tglnyetor_awal']);
      $model->tglnyetor_akhir = $format->formatDateTimeForDB($_GET['KUInformasisetoranpajakpembelianV']['tglnyetor_akhir']);
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function actionRincian($tandabuktikeluar_id)
  {

    if (isset($_GET['caraPrint']) && ($_GET['caraPrint'] == "PRINT")) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }

    $totalhutang = 0;
    $totalsisahutang = 0;
    $jmlpembayaran = 0;
    $tglsetoran = "";

    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
    $model = SetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));

    if (count((array)$model) > 0) {
      foreach ($model as $dataSetor) {
        $totalhutang += $dataSetor->totalhutang;
        $totalsisahutang += $dataSetor->totalsisahutang;
        $jmlpembayaran += $dataSetor->jmlpembayaran;
        $tglsetoran = MyFormatter::formatDateTimeForUser($dataSetor->tglsetoranpajak);
      }
    }

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    $this->render($this->path_view . '_rincian', array(
      'caraPrint' => $caraPrint,
      'modBuktiKeluar' => $modBuktiKeluar,
      'totalhutang' => $totalhutang,
      'totalsisahutang' => $totalsisahutang,
      'tglsetoran' => $tglsetoran,
      'jmlpembayaran' => $jmlpembayaran,
      'model' => $model,
    ));
  }


  public function actionBatalSetoranPajak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $tandabuktikeluar_id = isset($_POST['tandabuktikeluar_id']) ? $_POST['tandabuktikeluar_id'] : null;
      $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
      $pegawaibatal = isset($_POST['pegawaibatal']) ? $_POST['pegawaibatal'] : null;
      $pegawaibatal_id = isset($_POST['pegawaibatal_id']) ? $_POST['pegawaibatal_id'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

      $model = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);

      try {
        if (isset($model)) {
          $sukses = true;
          $moddetails = KUSetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $tandabuktikeluar_id));

          if (count((array)$moddetails) > 0) {
            foreach ($moddetails as $dataDet) {
              $modupdate = KUSetoranpajakT::model()->updateByPk($dataDet->setoranpajak_id, array('tglbatalsetor' => MyFormatter::formatDateTimeForDb($tglbatal), 'batalpegawai_id' => $pegawaibatal_id, 'alasanbatal' => $keterangan_batal));

              if (!$modupdate) {
                $sukses = false;
              }
            }
          }
          $deleteJurnal = true;

          $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $tandabuktikeluar_id));
          if (isset($modJurnalBefore)) {
            foreach ($modJurnalBefore as $jurnalBef) {
              $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));
              if (count((array)$jurnaldetail) > 0) {
                foreach ($jurnaldetail as $jurnaldetBefor) {
                  $jurnaldetBefor->delete();
                }
              }
              $deleteJurnal = $jurnalBef->delete();
            }
          }


          if ($sukses && $deleteJurnal) {
            $keterangan = "Data Berhasil Dibatalkan! ";
            $status = 'ok';
            $transaction->commit();
          } else {
            $keterangan = "Data Gagal Dibatalkan! ";
            $status = 'not';
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        $keterangan = "Data Gagal Dibatalkan! " . print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }



  //	public function actionPrint($caraPrint) {
  //        $modFaktur = new KUInformasifakturumumV('search');
  //        $modFaktur->unsetAttributes();
  //		$format = new MyFormatter();
  //		$periode = $format->formatDateTimeForUser($modFaktur->tgl_awal).' s/d '.$format->formatDateTimeForUser($modFaktur->tgl_akhir);
  //        if(empty($model->tgl_awal)){
  //            $periode = $format->formatDateTimeForUser($modFaktur->tgl_awal).' s/d '.$format->formatDateTimeForUser($modFaktur->tgl_akhir);
  //        }
  //
  //
  //        if(isset($_GET['KUInformasifakturumumV'])){
  //            $modFaktur->attributes=$_GET['KUInformasifakturumumV'];
  //            $modFaktur->tgl_awal = (isset($_GET['KUInformasifakturumumV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_awal']) : null);
  //            $modFaktur->tgl_akhir = (isset($_GET['KUInformasifakturumumV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_akhir']) : null);
  //        }
  //        $judulLaporan = 'Informasi Faktur Umum';
  //        $caraPrint = $_REQUEST['caraPrint'];
  //        if ($caraPrint == 'PRINT') {
  //          $this->layout = '//layouts/printWindows';
  //          $this->render('Print', array('modFaktur' => $modFaktur, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //        } else if ($caraPrint == 'EXCEL') {
  //          $this->layout = '//layouts/printExcel';
  //          $this->render('Print', array('modFaktur' => $modFaktur, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //        } else if ($_REQUEST['caraPrint'] == 'PDF') {
  //
  //          $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
  //          $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
  //          $mpdf = new MyPDF60('', $ukuranKertasPDF);
  //          $mpdf->mirrorMargins = 2;
  //          $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
  //          $mpdf->WriteHTML($stylesheet, 1);
  //		  ob_clean();
  //          $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
  //          $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
  //          $mpdf->Output();
  //        }
  //      }

  public function actionPrint()
  {
    $modFaktur = new KUInformasifakturumumV('search');
    $format = new MyFormatter();
    $modFaktur->tgl_awal = date('Y-m-d');
    $modFaktur->tgl_akhir = date('Y-m-d');
    $judulLaporan = 'Informasi Faktur Umum';
    //Data Grafik
    $data['title'] = 'Informasi Faktur Umum';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['KUInformasifakturumumV'])) {
      $modFaktur->attributes = $_GET['KUInformasifakturumumV'];
      $modFaktur->tgl_awal = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_awal']);
      $modFaktur->tgl_akhir = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_akhir']);

      if ($_GET['berdasarkanJatuhTempo'] > 0) {
        $modFaktur->tgl_awalJatuhTempo = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_awalJatuhTempo']);
        $modFaktur->tgl_akhirJatuhTempo = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_akhirJatuhTempo']);
      } else {
        $modFaktur->tgl_awalJatuhTempo = null;
        $modFaktur->tgl_akhirJatuhTempo = null;
      }
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'Print';

    $this->printFunction($modFaktur, $data, $caraPrint, $judulLaporan, $target);
  }

  protected function printFunction($modFaktur, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($modFaktur->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($modFaktur->tgl_akhir);
    if (empty($modFaktur->tgl_awal)) {
      $periode = $format->formatDateTimeForUser($modFaktur->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($modFaktur->tgl_akhir);
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('modFaktur' => $modFaktur, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('modFaktur' => $modFaktur, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // //$mpdf->useOddEven = 2;
      //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
      //$mpdf->SetHTMLFooter('{PAGENO}');
      ////$mpdf->useOddEven = 1;
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('modFaktur' => $modFaktur, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionMenyetujui($terimapersediaan_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modTerima = TerimapersediaanT::model()->findByPk($terimapersediaan_id);
    $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
    if ($approve) {
      $modAppr = ApprovalotorisasiM::model()->find();
      $pegawaid = "";

      if (isset($modAppr)) {
        if ($modTerima->sumberdana_id == Params::SUMBERDANA_ID_PT) {
          $pegawaid = $modAppr->managerkeuanganpt_id;
        } else {
          $pegawaid = $modAppr->managerkeuangan_id;
        }
      }
      $update = TerimapersediaanT::model()->updateByPk($terimapersediaan_id, array('tgl_menyetujuikeuangan' => date("Y-m-d"), 'pegawaimenyetujuikeuangan_id' => $pegawaid));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'terimapersediaan_id' => $terimapersediaan_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    //		if($tolak){
    //			$update = ADPermintaanpembelianT::model()->updateByPk($permintaanpembelian_id,array('statuspembelian'=>"DITOLAK"));
    //			if($update){
    //				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    //				$this->redirect(array('menyetujui','permintaanpembelian_id'=>$permintaanpembelian_id,'sukses'=>1,'ditolak'=>1));
    //			}else{
    //				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
    //			}
    //		}
    $judulLaporan = 'Faktur Pembelian Barang Non Medis';
    $deskripsi = '';
    $this->render('menyetujui', array(
      'format' => $format,
      'modTerima' => $modTerima,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetailTerima' => $modDetailTerima
    ));
  }

  public function actionPrintMenyetujui($terimapersediaan_id)
  {
    $format = new MyFormatter();
    $modTerima = TerimapersediaanT::model()->findByPk($terimapersediaan_id);
    $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));
    $judulLaporan = 'Faktur Pembelian Barang Non Medis';
    $deskripsi = '';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printMenyetujui', array('format' => $format, 'modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printMenyetujui', array('format' => $format, 'modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial('printMenyetujui', array('format' => $format, 'modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionUbahFaktur($terimapersediaan_id)
  {
    $format = new MyFormatter();

    $model = KUTerimapersediaanT::model()->findByPk($terimapersediaan_id);
    $modDetails = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $terimapersediaan_id));

    if (isset($_POST['KUTerimapersediaanT'])) {

      $model->attributes = $_POST['KUTerimapersediaanT'];
      $model->update_loginpemakai_id = Yii::app()->user->id;
      $model->update_time = date('Y-m-d H:i:s');
      $model->tglfaktur = $format->formatDateTimeForDB($model->tglfaktur);
      $model->tgljatuhtempo = $format->formatDateTimeForDB($model->tgljatuhtempo);

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = true;
          if ($model->save()) {
            if (isset($_POST['TerimapersdetailT'])) {
              if (count((array)$_POST['TerimapersdetailT']) > 0) {
                foreach ($_POST['TerimapersdetailT'] as $i => $data) {
                  $modelDet = TerimapersdetailT::model()->findByPk($data['terimapersdetail_id']);
                  $modelDet->attributes = $data;

                  if ($modelDet->save()) {
                    $this->updateHargaBarang($_POST['KUTerimapersediaanT'], $data);
                  } else {
                    $success = false;
                  }
                }
              }
            }
            if ($success == true) {
              if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                $checkDatadetail = 0;
                $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $model->terimapersediaan_id));

                if (count((array)$modDetailTerima) > 0) {
                  foreach ($modDetailTerima as $dtFakturDetail) {
                    $modBarangM = BarangM::model()->findByPk($dtFakturDetail->barang_id);

                    if (isset($modBarangM)) {
                      if (!empty($modBarangM->jenisbarang_id)) {
                        $modJenisbarangRek = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $modBarangM->jenisbarang_id, 'ispenerimaan' => true));

                        if (count((array)$modJenisbarangRek) > 0) {
                          $checkDatadetail++;
                        } else {
                          if ($checkDatadetail > 1) {
                            $checkDatadetail--;
                          }
                        }
                      }
                    }
                  }
                }

                if ($checkDatadetail > 0) {
                  $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('terimapersediaan_id' => $model->terimapersediaan_id));

                  if (isset($modJurnalBefore)) {
                    if (count((array)$modJurnalBefore) > 0) {
                      foreach ($modJurnalBefore as $jurnalBef) {
                        $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));

                        if (count((array)$jurnaldetail) > 0) {
                          foreach ($jurnaldetail as $jurnaldetBefor) {
                            $jurnaldetBefor->delete();
                          }
                        }
                        $jurnalBef->delete();
                      }
                    }
                  }

                  foreach ($modDetailTerima as $dtFakturDetail) {
                    $modBarangM = BarangM::model()->findByPk($dtFakturDetail->barang_id);
                    if (isset($modBarangM)) {
                      if (!empty($modBarangM->jenisbarang_id)) {
                        $modJenisbarangRek = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $modBarangM->jenisbarang_id, 'ispenerimaan' => true));

                        if (count((array)$modJenisbarangRek) > 0) {
                          $modJurnalRekening = $this->saveJurnalRekeningFaktur($model, $dtFakturDetail);
                          foreach ($modJenisbarangRek as $dtjnsbarangrek) {
                            $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $dtjnsbarangrek);
                          }
                          if ($dtFakturDetail->persenppn > 0) {
                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TERIMAPERSDETAILT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_BARANGID . "'");
                            if (isset($rekeningcolumn)) {
                              $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn, true);
                            }
                          }

                          if ($dtFakturDetail->persenpph > 0) {
                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TERIMAPERSEDIAANT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_PAJAKPPH . "'");
                            if (isset($rekeningcolumn)) {
                              $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn, null, true);
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }

            if ($success == true) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('ubahFaktur', 'terimapersediaan_id' => $model->terimapersediaan_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan<br/>" . $ex->getMessage() . "<br/>" . MyExceptionMessage::getMessage($ex, true));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan. ");
      }
    }
    $this->render('ubahFaktur', array(
      'model' => $model,
      'modDetails' => $modDetails,
      'format' => $format
    ));
  }

  public function updateHargaBarang($post, $detail)
  {

    $barang = BarangM::model()->findByPk($detail['barang_id']);
    $barang->barang_persendiskon = (!empty($detail['persendiscount']) ? $detail['persendiscount'] : 0);
    $barang->barang_ppn = (!empty($detail['jmlppn']) ? $detail['jmlppn'] : 0);
    $jmlDiskon = (($detail['hargasatuan'] * $detail['persendiscount']) / 100);
    $jmlPpn = ((($detail['hargasatuan'] - $jmlDiskon) * $detail['persenppn']) / 100);
    $jmlPph = ((($detail['hargasatuan'] - $jmlDiskon) * $detail['persenpph']) / 100);

    $updateHarganetto = false;

    if ($barang->barang_harganetto != $detail['hargasatuan']) {
      if ($detail['hppcheck'] > 0) {
        $updateHarganetto = true;
      }
    }
    if ($updateHarganetto) {
      $barang->barang_harganetto = $detail['hargasatuan'];
      $judul = 'Perubahan Harga Netto Barang';
      $isi = $barang->barang_nama;
      CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => Params::INSTALASI_ID_LOGISTIK, 'ruangan_id' => Params::RUANGAN_ID_LOGISTIK, 'modul_id' => Params::MODUL_ID_GUDANGUMUM),
      ));
    }

    $hpp = ($detail['hargasatuan'] - $jmlDiskon + $jmlPpn - $jmlPph);
    $barang->barang_hpp = $hpp;
    $barang->barang_hargajual = $hpp;
    $barang->barang_jmldlmkemasan = $detail['jmldalamkemasan'];
    $barang->save();
  }

  protected function saveJurnalRekeningFaktur($model, $dtDetail)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_HUTANG;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglfaktur);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nofaktur;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglfaktur);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Faktur Pembelian ' . (!empty($dtDetail->barang->jenisbarang_id) ? $dtDetail->barang->jenisbarangs->jenisbarang_nama : "") . " " . $dtDetail->barang->barang_nama . " - " . (!empty($model->supplier_id) ? $model->supplier->supplier_nama : "") . " - " . $model->nofaktur;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($model->tglfaktur);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->create_ruangan;
    $modJurnalRekening->terimapersediaan_id = $model->terimapersediaan_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetailFaktur($modJurnalRekening, $postRekenings, $modelRek, $isPPN = null, $ispph = null)
  {
    $valid = true;
    //        $modJurnalPosting = null;

    if (empty($modelRek)) {
      return true;
    }

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);



    //        if(Yii::app()->user->getState('ispostingotomatis'))
    //        {
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if($modJurnalPosting->validate()){
    //                $modJurnalPosting->save();
    //            }
    //        }

    $modelJurnalDetail = new JurnaldetailT();
    //        $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

    $totalHasilQty = ($postRekenings->hargasatuan * $postRekenings->jmlterima);
    $diskonHarga = ($totalHasilQty * ($postRekenings->persendiscount / 100));
    $totalNetto = ($totalHasilQty - $diskonHarga);
    $ppnHarga = (($totalHasilQty - $diskonHarga) * ($postRekenings->persenppn / 100));
    $pphHarga = (($totalHasilQty - $diskonHarga) * ($postRekenings->persenpph / 100));
    $totalAll = $totalNetto + $ppnHarga - $pphHarga;

    if ($modelRek->debitkredit == 'K') {
      if (!empty($isPPN)) {
        $modelJurnalDetail->nourut = 3;
        $modelJurnalDetail->saldokredit = $ppnHarga;
      }

      if (!empty($ispph)) {
        $modelJurnalDetail->nourut = 4;
        $modelJurnalDetail->saldokredit = $pphHarga;
      }

      if (empty($isPPN) && empty($ispph)) {
        $modelJurnalDetail->nourut = 5;
        $modelJurnalDetail->saldokredit = $totalAll;
      }

      $modelJurnalDetail->saldodebit = 0;
    } else if ($modelRek->debitkredit == 'D') {
      if (!empty($isPPN)) {
        $modelJurnalDetail->nourut = 2;
        $modelJurnalDetail->saldodebit = $ppnHarga;
      }

      if (!empty($ispph)) {
        $modelJurnalDetail->nourut = 3;
        $modelJurnalDetail->saldodebit = $pphHarga;
      }

      if (empty($isPPN) && empty($ispph)) {
        $modelJurnalDetail->nourut = 1;
        $modelJurnalDetail->saldodebit = $totalNetto;
      }

      $modelJurnalDetail->saldokredit = 0;
    }

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }

  public function actionBatalFaktur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $terimapersediaan_id = isset($_POST['terimapersediaan_id']) ? $_POST['terimapersediaan_id'] : null;
      $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
      $pegawaibatal = isset($_POST['pegawaibatal']) ? $_POST['pegawaibatal'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

      $model = TerimapersediaanT::model()->findByPk($terimapersediaan_id);

      try {
        if (isset($model)) {
          $sukses = true;

          $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('terimapersediaan_id' => $model->terimapersediaan_id));

          if (isset($modJurnalBefore)) {
            if (count((array)$modJurnalBefore) > 0) {
              foreach ($modJurnalBefore as $jurnalBef) {
                $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));

                if (count((array)$jurnaldetail) > 0) {
                  foreach ($jurnaldetail as $jurnaldetBefor) {
                    $jurnaldetBefor->delete();
                  }
                }
                $jurnalBef->delete();
              }
            }
          }

          $modupdate = TerimapersediaanT::model()->updateByPk($model->terimapersediaan_id, array('tglfaktur' => null, 'nofaktur' => null, 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->id));

          if (!$modupdate) {
            $sukses = false;
          }

          if ($sukses) {
            $keterangan = "Data Berhasil Dibatalkan! ";
            $status = 'ok';
            $transaction->commit();
          } else {
            $keterangan = "Data Gagal Dibatalkan! ";
            $status = 'not';
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        $keterangan = "Data Gagal Dibatalkan! " . print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }



      //            $nama_modul = Yii::app()->controller->module->id;
      //            $nama_controller = Yii::app()->controller->id;
      //            $nama_action = Yii::app()->controller->action->id;
      //            $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
      //            $criteria = new CDbCriteria;
      //            $criteria->compare('modul_id',$modul_id);
      //            $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
      //            $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
      //            if(isset($_POST['tujuansms'])){
      //                $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
      //            }
      //            $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
      //            $smspasien = 1;
      //            $nama_pasien = '';
      //
      //            try{
      //                $idPenunjang = $_POST['idPenunjang'];
      //                                    $keterangan_batal = isset($_POST['keterangan_batal'])?$_POST['keterangan_batal']:null;
      //                if($idPenunjang){
      //                    $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
      //                    $modPendaftaran = PendaftaranT::model()->findByPk($pasienMasukPenunjang->pendaftaran_id);
      //                    if($modPendaftaran->pembayaranpelayanan_id){ // sudah lunas semua
      //                        $status = 'not';
      //                        $pesan = 'exist';
      //                        $keterangan = "<div class='flash-success'>Pasien <b> ".$pasienMasukPenunjang->pendaftaran->pasien->nama_pasien."
      //                                            </b> sudah melakukan pembayaran pemeriksaan </div>";
      //                    }else{
      //                        $criteria = new CdbCriteria;
      //                        $criteria->addCondition('pasienmasukpenunjang_id = '.$pasienMasukPenunjang->pasienmasukpenunjang_id);
      //                        $criteria->addCondition('tindakansudahbayar_id > 0');
      //                        $tindakan = TindakanpelayananT::model()->findAll($criteria);
      //                        if(count((array)$tindakan) > 0){
      //                            $status = 'not';
      //                            $pesan = 'exist';
      //                            $keterangan = "<div class='flash-success'>Pasien <b> ".$pasienMasukPenunjang->pendaftaran->pasien->nama_pasien."
      //                                                </b> sudah melakukan pembayaran pemeriksaan </div>";
      //                        }else{
      //                                                            //$ok = $ok && TindakanpelayananT::model()->deleteAllByAttributes(array(
      //                              //  'pasienmasukpenunjang_id' => $idPenunjang,
      //                            //));
      //
      //
      //                            $model = new PasienbatalperiksaR();
      //                            $model->pendaftaran_id = $pasienMasukPenunjang->pendaftaran_id;
      //                            $model->pasien_id = $pasienMasukPenunjang->pasien_id;
      //                            $model->pasienmasukpenunjang_id = $pasienMasukPenunjang->pasienmasukpenunjang_id;
      //                            $model->pasienkirimkeunitlain_id = $pasienMasukPenunjang->pasienkirimkeunitlain_id;
      //                            $model->tglbatal = date('Y-m-d');
      //                            $model->keterangan_batal = $keterangan_batal;
      //                            $model->create_time = date('Y-m-d H:i:s');
      //                            $model->update_time = null;
      //                            $model->create_loginpemakai_id = Yii::app()->user->id;
      //                            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //                            if($model->save()){
      //                                $status = 'ok';
      //                                $pesan = 'exist';
      //                                $keterangan = "<div class='flash-success'>Pemeriksaan Berhasil dibatalkan ! </div>";
      //                            }
      //                        }
      //                    }
      //                }
      //
      //                /*
      //                 * kondisi_commit
      //                 */
      //                if($status == 'ok')
      //                {
      //                     // SMS GATEWAY
      //                    $sms = new Sms();
      //                    $modPasien = PasienM::model()->findByPk($model->pasien_id);
      //                    $nama_pasien = $modPasien->nama_pasien;
      //                    foreach ($modSmsgateway as $i => $smsgateway) {
      //                        $isiPesan = $smsgateway->templatesms;
      //
      //                        $attributes = $model->getAttributes();
      //                        foreach($attributes as $attributes => $value){
      //                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
      //                        }
      //                        $attributes = $modPasien->getAttributes();
      //                        foreach($attributes as $attributes => $value){
      //                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
      //                        }
      //
      //                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglbatal),$isiPesan);
      //
      //                        if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
      //                            if(!empty($modPasien->no_mobile_pasien)){
      //                                $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
      //                            }else{
      //                                $smspasien = 0;
      //                            }
      //                        }
      //
      //                    }
      //                    // END SMS GATEWAY
      //
      //                    $transaction->commit();
      //                }else{
      //                    $transaction->rollback();
      //                }
      //            }catch(Exception $ex){
      //                print_r($ex);
      //                $status = 'not';
      //                $transaction->rollback();
      //            }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionLoadJatuhTempo()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tglfaktur = (isset($_POST['tgl_faktur']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_faktur']) : date('Y-m-d H:i:s'));
      $supplier_id = $_POST['supplier_id'];

      $dateJatuhTempo = date('d M Y H:i:s');
      $termin = 0;

      $modSupplier = SupplierM::model()->findByPk($supplier_id);

      if (isset($modSupplier)) {
        $termin = $modSupplier->terminpembayaran;
      }
      if ($termin > 0) {
        $dateJatuhTempo = date('d M Y H:i:s', strtotime('+' . $termin . ' days', strtotime($tglfaktur)));
      }
      echo CJSON::encode(array('value' => $dateJatuhTempo));
      Yii::app()->end();
    }
  }
}
