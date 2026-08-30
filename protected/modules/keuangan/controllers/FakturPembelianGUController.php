<?php

class FakturPembelianGUController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  protected $successSave = true;
  protected $pesan = "succes";

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
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Faktur Pembelian Barang Non Medis";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new KUTerimapersediaanT;
    $modDetails = new TerimapersdetailT;
    $modFakturPembelian = new FakturpembelianT;
    $permintaan = new PembelianbarangT;
    $modUangmuka = new UangmukabeliT();


    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->peg_penerima_id = $modLogin->pegawai_id;
    if (!empty($peg_penerima_id))
      $model->peg_penerima_nama = $modLogin->pegawai->nama_pegawai;
    $model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
    $model->instalasi_id = $model->ruangan->instalasi_id;
    $model->tglterima = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->tglsuratjalan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->tglfaktur = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->tgljatuhtempo = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->totalharga = 0;
    $model->discount = 0;
    $model->biayaadministrasi = 0;
    $model->pajakpph = 0;
    $model->pajakppn = 0;
    $model->supplier_id = isset($model->pembelianbarang->supplier_id) ? $model->pembelianbarang->supplier_id : null;

    //        if(isset($model->supplier_id)){ echo "isset";exit; }else{ echo'else';exit; }
    if (isset($_POST['KUTerimapersediaanT'])) {
      $format = new MyFormatter();
      $terimapersediaanId = (!empty($model->terimapersediaan_id) ? $model->terimapersediaan_id : $_POST['terimapersediaan_id']);
      $model = TerimapersediaanT::model()->findByPk($terimapersediaanId);
      $model->attributes = $_POST['KUTerimapersediaanT'];

      $model->update_loginpemakai_id = $modLogin->loginpemakai_id;
      $model->update_time = date('Y-m-d H:i:s');
      $model->tglfaktur = $format->formatDateTimeForDB($model->tglfaktur);
      $model->tgljatuhtempo = $format->formatDateTimeForDB($model->tgljatuhtempo);
      $model->terimapersediaan_id = $_POST['terimapersediaan_id'];
      //                        $model->persendiscount = isset($_POST['discountpersen'])?MyFormatter::formatNumberForDb($_POST['discountpersen']):0;
      //                        $model->persenppn = isset($_POST['ppnpersen'])?MyFormatter::formatNumberForDb($_POST['ppnpersen']):0;
      //                        $model->persenpph = isset($_POST['KUTerimapersediaanT']['persenpph_22'])?MyFormatter::formatNumberForDb($_POST['KUTerimapersediaanT']['persenpph_22']):0;
      // echo "Kick2"; die;
      // var_dump($model->validate()); die;

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = true;

          if ($model->save()) {
            $modPembelianbarang = PembelianbarangT::model()->findByAttributes(array('terimapersediaan_id' => $model->terimapersediaan_id));

            if (!empty($modPembelianbarang))
              $supplier_id = $modPembelianbarang->supplier_id;

            if (!isset($_POST['TerimapersdetailT'])) {
              throw new Exception("Data detail penerimaan tidak ditemukan.");
            }

            $modDetails = $_POST['TerimapersdetailT'];

            foreach ($modDetails as $i => $data) {
              $modelDet = TerimapersdetailT::model()->findByPk($data['terimapersdetail_id']);
              $modelDet->attributes = $data;

              if ($modelDet->save()) {
                $this->updateHargaBarang($_POST['KUTerimapersediaanT'], $data);
              } else {
                $success = false;
              }
              //						TerimapersdetailT::model()->updateByPk($data['terimapersdetail_id'], array(
              //							'hargabeli' => $data['hargabeli'],
              //							'hargasatuan' => $data['hargasatuan']
              //						));
              //                                $modInven = new InventarisasiruanganT;
              //                                $modInven->inventarisasi_id = $data['inventarisasi_id'];
              //                                $modInven->inventarisasi_hargabeli = $data['hargabeli'];
              //                                $modInven->inventarisasi_hargasatuan = $data['hargasatuan'];
              //
              //                                InventarisasiruanganT::model()->updateByPk($modInven->inventarisasi_id, array(
              //                                    'inventarisasi_hargabeli'=>$modInven->inventarisasi_hargabeli,
              //                                    'inventarisasi_hargasatuan'=>$modInven->inventarisasi_hargasatuan
              //                                ));
            }
          }

          //                                        $totaldiskon = ($model->totalharga * ($model->persendiscount / 100));
          //                                        $totalppn = (($model->totalharga - $totaldiskon) * ($model->persenppn / 100));
          //                                        $totalpph = (($model->totalharga - $totaldiskon) * ($model->persenpph / 100));
          //                                        $totalKeseluruh = $model->totalharga - $totaldiskon + $totalppn + $totalpph;
          //					TerimapersediaanT::model()->updateByPk($model->terimapersediaan_id, array(
          //						'tglfaktur' => $model->tglfaktur,
          //						'nofaktur' => $model->nofaktur,
          //						'tgljatuhtempo' => $model->tgljatuhtempo,
          //						'totalharga' => $model->totalharga,
          //						'discount' => $totaldiskon,
          //						'biayaadministrasi' => $model->biayaadministrasi,
          //						'pajakpph' => $totalpph,
          //						'pajakppn' => $totalppn,
          //						'totalkeseluruhan' => $totalKeseluruh,
          //						'update_loginpemakai_id' => $model->update_loginpemakai_id,
          //						'update_time' => $model->update_time,
          //                                                'persendiscount'=>$model->persendiscount,
          //                                                'persenppn'=>$model->persenppn,
          //                                                'persenpph'=>$model->persenpph,
          //					));
          //							  RND-9646
          //                            $modFakturPembelian->terimapersediaan_id = $model->terimapersediaan_id;
          //                            $modFakturPembelian->supplier_id    = $supplier_id;
          //                            $modFakturPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
          //                            $modFakturPembelian->nofaktur   = $model->nofaktur;
          //                            $modFakturPembelian->tglfaktur  = $model->tglfaktur;
          //                            $modFakturPembelian->tgljatuhtempo  = $model->tgljatuhtempo;
          //                            $modFakturPembelian->totharganetto  = $model->totalharga;
          //                            $modFakturPembelian->persendiscount = $model->discount;
          //                            $modFakturPembelian->jmldiscount    = ($model->discount/100) * $model->totalharga;
          //                            $modFakturPembelian->biayamaterai   = $model->biayaadministrasi;
          //                            $modFakturPembelian->totalpajakpph  = $model->pajakpph;
          //                            $modFakturPembelian->totalpajakppn  = $model->pajakppn;
          //                            $modFakturPembelian->totalhargabruto  = $modFakturPembelian->totharganetto - $modFakturPembelian->jmldiscount + $modFakturPembelian->biayamaterai + $modFakturPembelian->totalpajakpph + $modFakturPembelian->totalpajakppn;
          //                            $modFakturPembelian->create_time = date('Y-m-d H:i:s');
          //                            $modFakturPembelian->create_loginpemakai_id = Yii::app()->user->id;
          //                            $modFakturPembelian->create_ruangan = Yii::app()->user->getState('ruangan_id');
          //                            $modFakturPembelian->syaratbayar_id = 1;
          //							echo json_encode($modFakturPembelian->validate());exit;
          //
          //                            $modFakturPembelian->save();
          //                            $modJurnalRekening = $this->saveJurnalRekening($model, $_POST['KUTerimapersediaanT']);
          //                            $noUrut = 0;
          //                            foreach($_POST['RekeningsupplierV'] AS $i => $post){
          //                                $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, null);
          //                                $noUrut ++;
          //                            }

          if ($success == true) {
            if (Yii::app()->user->getState('isjurnalotomatis') == true) {
              $model = TerimapersediaanT::model()->findByPk($model->terimapersediaan_id);
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
                          $modPajak = PajakM::model()->findByPk($model->pajak_id);

                          if (isset($modPajak)) {
                            if (!empty($modPajak->rekening5_id)) {
                              $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $modPajak, null, true);
                            }
                          }


                          //                                                    $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '" . Params::REKENINGCOLUMN_TABLE_TERIMAPERSEDIAANT . "' AND column_name = '" . Params::REKENINGCOLUMN_COLUMN_PAJAKPPH . "'");
                          //                                                    if (isset($rekeningcolumn)) {
                          //                                                        $this->saveJurnalDetailFaktur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn, null, true);
                          //                                                    }
                        }
                      }
                    }
                  }
                }
              }

              $modJurnalFaktuAfter = JurnalrekeningT::model()->findAllByAttributes(array('terimapersediaan_id' => $model->terimapersediaan_id));

              if (count((array)$modJurnalFaktuAfter) > 0) {
                $rekening_id = null;

                foreach ($modJurnalFaktuAfter as $dataFakturAf) {
                  $criteriaJud = new CDbCriteria();
                  $criteriaJud->addCondition('jurnalrekening_id = ' . $dataFakturAf->jurnalrekening_id);
                  $criteriaJud->addCondition('saldokredit > 0');
                  $criteriaJud->order = "nourut DESC";
                  $criteriaJud->limit = 1;
                  $modFakturJurDetAfter = JurnaldetailT::model()->find($criteriaJud);

                  if (isset($modFakturJurDetAfter)) {
                    $rekening_id = $modFakturJurDetAfter->rekening5_id;
                  }
                }

                if (!empty($model->jlmuangmukabeli) && $model->jlmuangmukabeli > 0) {
                  $modJurnalRekening = $this->saveJurnalRekeningUangMuka($model);

                  $modRekening5 = Rekening5M::model()->findByPk($rekening_id);

                  if (isset($modRekening5)) {
                    $this->saveJurnalDetailUangMuka($modJurnalRekening, $modRekening5, $model->jlmuangmukabeli, 'D', 1);
                  }

                  $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_TERIMAPERSEDIAANT, 'column_name' => Params::REKENINGCOLUMN_COLUMN_JLMUANGMUKABELI));
                  if (isset($rekeningcolumn)) {
                    $this->saveJurnalDetailUangMuka($modJurnalRekening, $rekeningcolumn, $model->jlmuangmukabeli, 'K', 2);
                  }
                }
              }
            }
          }

          $this->notifFaktur($model);

          if ($success == true) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            if (isset($model->terimapersediaan_id)) {
              $this->redirect(array('index', 'id' => $model->terimapersediaan_id, 'sukses' => 1));
            } else {
              $this->refresh();
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan<br/>" . $ex->getMessage() . "<br/>" . MyExceptionMessage::getMessage($ex, true));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan. ");
      }
    }


    $this->render('index', array(
      'model' => $model, 'modDetails' => $modDetails, 'modFakturPembelian' => $modFakturPembelian, 'permintaan' => $permintaan, 'modUangmuka' => $modUangmuka
    ));
  }

  protected function notifFaktur($model)
  {
    //        print_r($model->attributes);
    //        die;

    $judul = "Faktur Pembelian Barang - " . $model->nofaktur;

    $isi = "Tgl. Faktur : " . MyFormatter::formatDateTimeForUser($model->tglfaktur) . "<br/>";
    $isi = "No. Penerimaan : " . $model->nopenerimaan . "<br/>";
    $isi .= "Total Bruto : " . MyFormatter::formatNumberForPrint($model->totalkeseluruhan) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    //$ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      //array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
    ));
  }

  public function updateHargaBarang($post, $detail)
  {

    $barang = BarangM::model()->findByPk($detail['barang_id']);
    //        $barang->barang_harganetto = $detail['hargasatuan'];
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


    //        $barang->barang_persendiskon = ;
    //        $barang->barang_ppn = ($post['pajakppn']/$post['totalharga']) * $barang->barang_harganetto;
    $barang->barang_jmldlmkemasan = $detail['jmldalamkemasan'];

    //        $barang_diskon = $barang->barang_harganetto * (100 - $barang->barang_persendiskon) / 100;
    //        $barang->barang_hpp = $barang_diskon + $barang->barang_ppn;

    $barang->save();

    // var_dump($barang->attributes, $post, $detail, $barang->save());
    // die;
  }

  public function actionDynamicSupplier()
  {

    $supplier_id = (isset($_POST['KUTerimapersediaanT']['supplier_id']) ? $_POST['KUTerimapersediaanT']['supplier_id'] : null);
    $data = SupplierrekM::model()->findAllByAttributes(array('supplier_id' => $supplier_id));
    echo $supplier_id;
    echo $data[0]->saldonormal;
    exit;
  }

  protected function validasiTabular($model, $data)
  {
    $valid = true;
    foreach ($data as $i => $row) {
      $modDetails[$i] = new TerimapersdetailT();
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->terimapersediaan_id = $model->terimapersediaan_id;
      // if (isset($beli)){
      //     $modDetails[$i]->jmlbeli = $beli[$i]->jmlbeli;
      // }
      echo "<pre>";
      print_r($modDetails[$i]->attributes);

      $valid = $modDetails[$i]->validate() && $valid;
    }
    exit();
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


    if (isset($_POST['GUTerimapersediaanT'])) {
      $model->attributes = $_POST['GUTerimapersediaanT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->terimapersediaan_id));
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
  //  public function actionIndex()
  //  {
  //      $dataProvider=new CActiveDataProvider('GUTerimapersediaanT');
  //      $this->render('index',array(
  //          'dataProvider'=>$dataProvider,
  //      ));
  //  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new TerimapersediaanT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['TerimapersediaanT']))
      $model->attributes = $_GET['TerimapersediaanT'];

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
    $model = GUTerimapersediaanT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'guterimapersediaan-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengubah status aktif
   * @param type $id
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionInformasi()
  {
    //
    $model = new GUTerimapersediaanT('search');
    //      $model->unsetAttributes();  // clear any default values
    $model->tglAwal = date('Y-m-d H:i:s');
    $model->tglAkhir = date('Y-m-d H:i:s');
    if (isset($_GET['GUTerimapersediaanT'])) {
      $model->attributes = $_GET['GUTerimapersediaanT'];
      $format = new MyFormatter();
      $model->tglAwal = $format->formatDateTimeForDB($model->tglAwal);
      $model->tglAkhir = $format->formatDateTimeForDB($model->tglAkhir);
    }

    $this->render('informasi', array(
      'model' => $model,
    ));
  }

  public function actionDetailTerimaPersediaan($id)
  {
    $this->layout = 'frameDialog';
    $modTerima = TerimapersediaanT::model()->findByPk($id);
    $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $modTerima->terimapersediaan_id));
    $this->render('detailInformasi', array(
      'modTerima' => $modTerima,
      'modDetailTerima' => $modDetailTerima,
    ));
  }

  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $judulLaporan = 'RINCIAN FAKTUR PEMBELIAN';
    $modTerima = TerimapersediaanT::model()->findByPk($id);
    $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $modTerima->terimapersediaan_id));
    $this->render('print', array(
      'judulLaporan' => $judulLaporan,
      'modTerima' => $modTerima,
      'modDetailTerima' => $modDetailTerima,
    ));
  }

  public function actionReturPenerimaan($id)
  {
    $this->layout = 'frameDialog';
    $model = new ReturpenerimaanT();
    $modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = ' . $id . ' and returpenerimaan_id is null');
    $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = ' . $id . ' and retpendetail_id is null');
    if (!empty($modTerima) && (count((array)$modDetailTerima) > 0)) {
      $model->tglreturterima = date('Y-m-d H:i:s');
      $model->terimapersediaan_id = $modTerima->terimapersediaan_id;
      $model->noreturterima = Generator::noReturTerima();
      $this->render('returPenerimaan', array(
        'model' => $model,
      ));
    } else {
      echo 'Barang telah dibatal mutasikan';
    }
    if (isset($_POST['BatalmutasibrgT'])) {
      $modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
        foreach ($modBatals as $i => $data) {
          if ($data->qty_batal > 0) {
            $modInventaris = InventarisasiruanganT::model()->findByAttributes(array('barang_id' => $data->barang_id), array('order' => 'tgltransaksi', 'limit' => 1));
            if ($data->save()) {
              InventarisasiruanganT::kembalikanStok($data->qty_batal, $data->barang_id);
              MutasibrgdetailT::model()->updateByPk($_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'], array('batalmutasibrg_id' => $data->batalmutasibrg_id));
              InventarisasiruanganT::model()->updateAll(array('batalmutasibrg_id' => $data->batalmutasibrg_id), 'mutasibrgdetail_id = ' . $_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'] . ' and barang_id = ' . $data->barang_id);
            } else {
              $success = false;
            }
          }
        }

        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }
  }

  protected function saveJurnalRekening($modRetur, $postPenUmum)
  {
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modRetur->tglfaktur;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modRetur->tglfaktur, 'JUB');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = $modRetur->tglfaktur;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = "Pembelian " . $modRetur->nofaktur;
    $modJurnalRekening->jenisjurnal_id = Params::JURNAL_PENGELUARAN_KAS;
    $periodeID = Yii::app()->session['periodeID'];
    $modJurnalRekening->rekperiod_id = $periodeID[0];
    $modJurnalRekening->create_time = $modRetur->tglfaktur;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }

    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $post, $noUrut = 0, $modJurnalPosting)
  {
    $modJurnalDetail = new JurnaldetailT();
    $modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
    $modJurnalDetail->saldodebit = $post['saldodebit'];
    $modJurnalDetail->saldokredit = $post['saldokredit'];
    $modJurnalDetail->nourut = $noUrut;
    $modJurnalDetail->rekening1_id = $post['struktur_id'];
    $modJurnalDetail->rekening2_id = $post['kelompok_id'];
    $modJurnalDetail->rekening3_id = $post['jenis_id'];
    $modJurnalDetail->rekening4_id = $post['obyek_id'];
    $modJurnalDetail->rekening5_id = $post['rincianobyek_id'];
    $modJurnalDetail->catatan = "";

    if ($modJurnalDetail->validate()) {
      $modJurnalDetail->save();
    }
    return $modJurnalDetail;
  }

  //Pencarian Penerimaan Persediaan barang
  public function actionGetPenerimaanPersediaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idTerimaPers = $_POST['idTerimaPers'];
      $modTerimaDetail = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id' => $idTerimaPers));
      $modTerima = TerimapersediaanT::model()->findByPk($idTerimaPers);

      $uangmuka = 0;
      $checkuangmuka = false;
      $nouangmuka = "";
      $tgluangmuka = "";

      if (!empty($modTerima->pembelianbarang_id)) {
        $modUangMuka = UangmukabeliT::model()->findByAttributes(array('pembelianbarang_id' => $modTerima->pembelianbarang_id));

        if (isset($modUangMuka)) {
          $uangmuka = (!empty($modUangMuka->jumlahuang) ? $modUangMuka->jumlahuang : 0);
          $checkuangmuka = true;
          $nouangmuka = $modUangMuka->nopembayaran;
          $tgluangmuka = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
        }
      }

      $modTerima->jlmuangmukabeli = $uangmuka;
      $modTerima->totalhutangusaha = ($modTerima->totalkeseluruhan - $uangmuka);
      $modTerima->pajak_nama = (isset($modTerima->pajak) ? $modTerima->pajak->pajak_nama : "");

      $tr = '';
      foreach ($modTerimaDetail as $key => $TerimaDetail) {
        $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($TerimaDetail->barang_id);
        $modDetail = new TerimapersdetailT();
        $modDetail->attributes = $TerimaDetail->attributes;
        $modDetail->jmlterima = $TerimaDetail->jmlterima;
        $modDetail->barang_id = $TerimaDetail->barang_id;
        $modDetail->hargabeli = $TerimaDetail->hargabeli;
        $modDetail->hargasatuan = $TerimaDetail->hargasatuan;
        $modDetail->jmldalamkemasan = $TerimaDetail->jmldalamkemasan;
        $modDetail->terimapersdetail_id = $TerimaDetail->terimapersdetail_id;
        $modDetail->satuanbeli = $TerimaDetail->satuanbeli;
        $modDetail->kondisibarang = "Baik";

        $tr .= $this->renderPartial('_detailPenerimaanPersediaanBarangBaru', array('modBarang' => $modBarang, 'key' => $key, 'modDetail' => $modDetail), true);
      }

      echo json_encode(array('persdiaan' => $modTerima->attributes, 'tab' => $tr, 'checkuangmuka' => $checkuangmuka, 'nouangmuka' => $nouangmuka, 'tgluangmuka' => $tgluangmuka, 'pajak_nama' => $modTerima->pajak_nama));
      Yii::app()->end();
    }
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
    //        $terima = TerimapersediaanT::model()->findByAttributes(array('terimapersediaan_id'=>$postRekenings->terimapersediaan_id));

    if (empty($modelRek)) {
      return true;
    }

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);



    //        if (Yii::app()->user->getState('ispostingotomatis')) {
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if ($modJurnalPosting->validate()) {
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

      //            if($postRekenings->persenppn > 0){
      //                $modelJurnalDetail->nourut = 4;
      //            }
      //            if($postRekenings->persenpph > 0){
      //                if(!empty($ispph)){
      //                   $modelJurnalDetail->nourut = 5;
      //                }
      //            }
      //            if(!empty($ispph)){
      //                 $modelJurnalDetail->saldokredit = $pphHarga;
      //            }else{
      //
      //            }

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

  protected function saveJurnalRekeningUangMuka($model)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglfaktur);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nofaktur;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglfaktur);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Pengurangan Hutang Usaha dari Uang Muka';

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

  public function saveJurnalDetailUangMuka($modJurnalRekening, $modelRek, $nilai, $saldonormal, $nourut)
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



    //        if (Yii::app()->user->getState('ispostingotomatis')) {
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if ($modJurnalPosting->validate()) {
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
    $modelJurnalDetail->nourut = $nourut;
    if ($saldonormal == 'K') {
      $modelJurnalDetail->saldokredit = $nilai;
      $modelJurnalDetail->saldodebit = 0;
    } else {
      $modelJurnalDetail->saldokredit = 0;
      $modelJurnalDetail->saldodebit = $nilai;
    }

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
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
