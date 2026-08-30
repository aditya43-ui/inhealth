<?php

class ReturpenerimaanTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  //public $layout='//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'gudangUmum.views.returpenerimaanT.';
  public $successSave = false;
  public $pesan = "";

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Retur Penerimaan Barang";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new GUReturpenerimaanT;
    $modTerima = new TerimapersediaanT;
    $modDetails = array();
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->peg_retur_id = $modLogin->pegawai_id;
    $model->tglreturterima = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->noreturterima = MyGenerator::noReturTerima();
    if (!empty($model->peg_retur_id)) $model->peg_retur_nama = $modLogin->pegawai->nama_pegawai;
    if (isset($id)) {

      // Uncomment the following line if AJAX validation is needed

      $modDetails = array();

      $modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = ' . $id . ' and returpenerimaan_id is null');
      $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = ' . $id . ' and retpendetail_id is null');
      if ((!empty($modTerima)) && (count((array)$modDetailTerima) > 0)) {

        $model->terimapersediaan_id = $modTerima->terimapersediaan_id;
        foreach ($modDetailTerima as $i => $row) {
          $modDetails[$i] = new RetpendetailT();
          $modDetails[$i]->terimapersdetail_id = $row->terimapersdetail_id;
          $modDetails[$i]->jmlretur = $row->jmlterima;
          $modDetails[$i]->hargasatuan = $row->hargasatuan;
          $modDetails[$i]->satuanbeli = $row->satuanbeli;
          $modDetails[$i]->kondisibarang = $row->kondisibarang;
          $modDetails[$i]->jmlterima = $row->jmlterima;
          $modDetails[$i]->persendiscount = (!empty($row->persendiscount) ? $row->persendiscount : 0);
          $modDetails[$i]->persenppn = (!empty($row->persenppn) ? $row->persenppn : 0);
          $modDetails[$i]->persenpph = (!empty($row->persenpph) ? $row->persenpph : 0);
        }
      }
    }

    if (isset($_POST['GUReturpenerimaanT'])) {
      // var_dump($_POST); die;
      $model->attributes = $_POST['GUReturpenerimaanT'];
      $model->totalretur = str_replace(".", "", $model->totalretur);
      // var_dump($model->attributes, $model->validate(), $model->errors); die;
      if (count((array)$_POST['RetpendetailT']) > 0) {
        $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = ' . $model->terimapersediaan_id . ' and retpendetail_id is null');
        $modDetails = $this->validasiTabular($model, $_POST['RetpendetailT'], $modDetailTerima);
        if ($model->validate()) {
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $success = true;
            if ($model->save()) {
              TerimapersediaanT::model()->updateByPk($model->terimapersediaan_id, array('returpenerimaan_id' => $model->returpenerimaan_id));
              $modDetails = $this->validasiTabular($model, $_POST['RetpendetailT'], $modDetailTerima);
              foreach ($modDetails as $i => $data) {
                $data->hargasatuan = str_replace(".", "", $data->hargasatuan);
                // var_dump($data->attributes, $data->validate(), $data->errors); die;
                if ($data->jmlretur > 0) {
                  if ($data->save()) {
                    InventarisasiruanganT::kurangiStokBerdasarkanInventaris($data->jmlretur, $data->terimapersdetail->inventaris->inventarisasi_id);
                    TerimapersdetailT::model()->updateByPk($data->terimapersdetail_id, array('retpendetail_id' => $data->retpendetail_id));
                  } else {
                    $success = false;
                  }
                }
              }
            } else {
              $success = false;
            }

            if ($success == true) {
              if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                //                                            $modelTerimapers = TerimapersediaanT::model()->findByPk($model->terimapersediaan_id);
                $checkDatadetail = 0;
                $modDetailTerima = RetpendetailT::model()->findAllByAttributes(array('returpenerimaan_id' => $model->returpenerimaan_id));

                if (count((array)$modDetailTerima) > 0) {
                  foreach ($modDetailTerima as $dtFakturDetail) {
                    $modTerimDtl = TerimapersdetailT::model()->findByPk($dtFakturDetail->terimapersdetail_id);
                    $modBarangM = BarangM::model()->findByPk($modTerimDtl->barang_id);

                    if (isset($modBarangM)) {
                      if (!empty($modBarangM->jenisbarang_id)) {
                        $modJenisbarangRek = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $modBarangM->jenisbarang_id, 'isreturpenerimaan' => true));

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
                  foreach ($modDetailTerima as $dtFakturDetail) {
                    $modTerimDtl = TerimapersdetailT::model()->findByPk($dtFakturDetail->terimapersdetail_id);
                    $modBarangM = BarangM::model()->findByPk($modTerimDtl->barang_id);
                    if (isset($modBarangM)) {
                      if (!empty($modBarangM->jenisbarang_id)) {
                        $modJenisbarangRek = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $modBarangM->jenisbarang_id, 'isreturpenerimaan' => true));

                        if (count((array)$modJenisbarangRek) > 0) {
                          $modJurnalRekening = $this->saveJurnalRekeningFaktur($model, $dtFakturDetail);
                          foreach ($modJenisbarangRek as $dtjnsbarangrek) {
                            $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $dtjnsbarangrek);
                          }
                          if ($dtFakturDetail->jmlppn > 0) {
                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_RETPENDETAILT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_JMLPPN . "'");
                            if (isset($rekeningcolumn)) {
                              $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn, true);
                            }
                          }

                          if ($dtFakturDetail->jmlpph > 0) {
                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_RETPENDETAILT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_JMLPPH . "'");
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

              $transaction->commit();
              Yii::app()->user->setFlash('success', ' Data nomor retur ' . $model->noreturterima . ' berhasil disimpan.');
              $url = Yii::app()->createUrl('gudangUmum/TerimapersediaanT/informasi');
              $this->redirect($url);
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
          } catch (Exception $ex) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
          }
        }
      } else {
        $model->validate();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
      }
    }

    $this->render('index', array(
      'model' => $model, 'modDetails' => $modDetails, 'modTerima' => $modTerima, 'id' => $id,
    ));
  }

  protected function validasiTabular($model, $datas, $modDetailTerima)
  {
    $valid = true;
    foreach ($datas as $i => $data) {
      $modDetails[$i] = new RetpendetailT();
      $modDetails[$i]->attributes = $data;
      $modDetails[$i]->returpenerimaan_id = $model->returpenerimaan_id;
      $modDetails[$i]->jmlterima = $modDetailTerima[$i]->jmlterima;
      $valid = $modDetails[$i]->validate() && $valid;
    }

    return $modDetails;
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GUReturpenerimaanT'])) {
      $model->attributes = $_POST['GUReturpenerimaanT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->returpenerimaan_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  //	public function actionIndex()
  //	{
  //		$dataProvider=new CActiveDataProvider('GUReturpenerimaanT');
  //		$this->render('index',array(
  //			'dataProvider'=>$dataProvider,
  //		));
  //	}

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new GUReturpenerimaanT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GUReturpenerimaanT']))
      $model->attributes = $_GET['GUReturpenerimaanT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GUReturpenerimaanT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gureturpenerimaan-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new GUReturpenerimaanT;
    $model->attributes = $_REQUEST['GUReturpenerimaanT'];
    $judulLaporan = 'Data GUReturpenerimaanT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  public function actionLoadPenerimaanID()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $modDetails = array();

      $modDetails = array();
      $res = array();

      $modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = ' . $id . ' and returpenerimaan_id is null');
      $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = ' . $id . ' and retpendetail_id is null');
      if ((!empty($modTerima)) && (count((array)$modDetailTerima) > 0)) {

        //$model->terimapersediaan_id = $modTerima->terimapersediaan_id;
        foreach ($modDetailTerima as $i => $row) {
          $modDetails[$i] = new RetpendetailT();
          $modDetails[$i]->terimapersdetail_id = $row->terimapersdetail_id;
          $modDetails[$i]->jmlretur = $row->jmlterima;
          $modDetails[$i]->hargasatuan = $row->hargasatuan;
          $modDetails[$i]->satuanbeli = $row->satuanbeli;
          $modDetails[$i]->kondisibarang = $row->kondisibarang;
          $modDetails[$i]->jmlterima = $row->jmlterima;
        }
      }

      $modTerima->sumberdana_id = $modTerima->sumberdana->sumberdana_nama;

      $res['data'] = $modTerima->attributes;
      $res['tab'] = $this->renderPartial('_rowBarang', array('modDetails' => $modDetails), true);

      echo CJSON::encode($res);

      Yii::app()->end();
    }
  }

  public function actionLoadPenerimaan($term)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nopenerimaan = $_GET['term'];

      $criteria = new CDbCriteria();
      $criteria->compare('lower(nopenerimaan)', strtolower($nopenerimaan), true);
      $criteria->addCondition('returpenerimaan_id is null');
      $criteria->order = 'tglterima desc';


      $dat = TerimapersediaanT::model()->findAll($criteria);

      foreach ($dat as $i => $item) {
        $returnVal[$i]['label'] = $item->nopenerimaan . " - " . MyFormatter::formatDateTimeForUser($item->tglterima);
        $returnVal[$i]['value'] = $item->terimapersediaan_id;
      }

      echo CJSON::encode($returnVal);

      Yii::app()->end();
    }
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Retur Penerimaan Barang";
    $model = new GUInforeturterimabarangV('searchInformasi');
    $format = new MyFormatter();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    if (isset($_GET['GUInforeturterimabarangV'])) {
      $model->attributes = $_GET['GUInforeturterimabarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInforeturterimabarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInforeturterimabarangV']['tgl_akhir']);
    }

    $this->render('informasi', array(
      'model' => $model,
    ));
  }

  public function actionDetailInformasi($id)
  {
    $this->layout = '//layouts/iframe';
    $modRetur = GUReturpenerimaanT::model()->findByPk($id);
    $modDetailRetur = RetpendetailT::model()->findAllByAttributes(array('returpenerimaan_id' => $modRetur->returpenerimaan_id));
    $this->render($this->path_view . 'detailInformasi', array(
      'modRetur' => $modRetur,
      'modDetailRetur' => $modDetailRetur,
    ));
  }


  public function actionPrintInformasi($caraPrint)
  {
    $model = new GUInforeturterimabarangV('searchInformasi');
    $format = new MyFormatter();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    if (isset($_GET['GUInforeturterimabarangV'])) {
      $model->attributes = $_GET['GUInforeturterimabarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInforeturterimabarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInforeturterimabarangV']['tgl_akhir']);
    }

    $this->printFunction($model, $caraPrint, "Informasi Retur Penerimaan Barang", $this->path_view . "printInformasi");
  }


  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //            //$mpdf->useOddEven = 2;
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    } else if ($caraPrint == "CSV") {
      CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
    }
  }

  protected function saveJurnalRekeningFaktur($model, $dtDetail)
  {
    $modTerimaPers = TerimapersediaanT::model()->findByPk($model->terimapersediaan_id);
    $modTerimDtl = TerimapersdetailT::model()->findByPk($dtDetail->terimapersdetail_id);
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_HUTANG;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglreturterima);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->noreturterima;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglreturterima);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Retur Penerimaan Barang ' . $modTerimDtl->barang->barang_nama . " - " . (!empty($modTerimaPers->supplier_id) ? $modTerimaPers->supplier->supplier_nama : "") . " - " . $model->noreturterima;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($model->tglreturterima);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->create_ruangan;
    $modJurnalRekening->returpenerimaan_id = $model->returpenerimaan_id;

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
    $modJurnalPosting = null;
    $modTerimDtl = TerimapersdetailT::model()->findByPk($postRekenings->terimapersdetail_id);

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
    $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

    $totalHasilQty = ($postRekenings->hargasatuan * $postRekenings->jmlretur);
    $diskonHarga = $postRekenings->jmldiscount;
    $totalNetto = ($totalHasilQty - $diskonHarga);
    $ppnHarga = $postRekenings->jmlppn;
    $pphHarga = $postRekenings->jmlpph;
    $totalAll = $totalNetto + $ppnHarga + $pphHarga;

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
        $modelJurnalDetail->nourut = 2;
        $modelJurnalDetail->saldokredit = $totalNetto;
      }
      $modelJurnalDetail->saldodebit = 0;
    } else if ($modelRek->debitkredit == 'D') {
      if (empty($isPPN) && empty($ispph)) {
        $modelJurnalDetail->nourut = 1;
        $modelJurnalDetail->saldodebit = $totalAll;
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
}
