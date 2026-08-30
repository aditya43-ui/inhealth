<?php

class ProduksiObatController extends MyAuthController
{
  public $msgProduksiDetail = "";
  public $msgProduksi = "";
  public $msgObat = "";
  public $msgStok = "";
  public $msgKosong = "";
  //public $modProduksiDetails="";
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';

  public $modProduksiDetails = true;
  public $stokobatalkestersimpan = true;
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
  public function actionCreate($id = null)
  {
    $model = new FAProduksiobatT;
    $modProduksiDetail = new FAProduksiobatdetT;
    $modObatalkesM = new FAObatalkesM; //agar nama2 elemennya sama dengan yg di master obat gudang untuk javascript
    $dataDetails = array(); //untuk mengembalikan detail jika gagal simpan
    $modProduksiDetails = array();
    $model->tglproduksiobt = date('d M Y H:i:s');
    $model->noproduksiobt = '-- Otomatis --';

    if (!empty($id)) {
      $model = FAProduksiobatT::model()->findByPk($id);
    }

    if (isset($_POST['FAProduksiobatT']) && isset($_POST['FAProduksiobatdetT']) && isset($_POST['FAObatalkesM'])) {
      $model->attributes = $_POST['FAProduksiobatT'];
      $model->tglproduksiobt = date('Y-m-d H:i:s');
      $model->noproduksiobt = MyGenerator::noProduksiObat();
      $model->create_time = $model->tglproduksiobt;
      $model->update_time = $model->tglproduksiobt;
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->update_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modObatalkesM->attributes = $_POST['FAObatalkesM'];

      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($model->save()) {


          //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
          $detailGroups = array();
          foreach ($_POST['FAProduksiobatdetT'] as $i => $postDetail) {
            $modProduksiDetails[$i] = new FAProduksiobatdetT;
            $modProduksiDetails[$i]->attributes = $postDetail;
            $modProduksiDetails[$i] = $this->simpanProduksiDetail2($model, $postDetail);
            $this->simpanStokObatAlkesOut2($modProduksiDetails[$i]);
            /* $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                            $modProduksiDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                            $modProduksiDetails[$i]->tglterima = $modStok->tglterima;
                            $obatalkes_id = $postDetail['obatalkes_id'];
                           if(isset($detailGroups[$obatalkes_id])){
                                $detailGroups[$obatalkes_id]['qtyproduksi'] += $postDetail['qtyproduksi'];
                            }else{
                                $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                                $detailGroups[$obatalkes_id]['qtyproduksi'] = $postDetail['qtyproduksi'];
                            } */
          }
          //END GROUP
          /*
                        foreach($detailGroups AS $i => $detail){
                            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qtyproduksi'], Yii::app()->user->getState('ruangan_id'));
                            if(count((array)$modStokOAs) > 0){
                                foreach($modStokOAs AS $i => $stok){
                                    $modDetails[$i] = $this->simpanProduksiDetail($model, $modProduksiDetails[$i], $stok);
                                    $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                                    $suksesDetail=true;
                                }
                            }else{
                                $this->stokobatalkestersimpan &= false;
                                $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                            }
                        }
                         * 
                         */
          //var_dump($this->modProduksiDetails && $this->stokobatalkestersimpan); die;
          if ($this->modProduksiDetails && $this->stokobatalkestersimpan) {
            $modObatalkesM->attributes = $_POST['FAObatalkesM'];
            (empty($modObatalkesM->ppn_persen) ? $modObatalkesM->ppn_persen = 0 : "");
            (empty($modObatalkesM->hargajual) ? $modObatalkesM->hargajual = 0 : "");
            (empty($modObatalkesM->hargamaksimum) ? $modObatalkesM->hargamaksimum = 0 : "");
            (empty($modObatalkesM->hargaminimum) ? $modObatalkesM->hargaminimum = 0 : "");
            (empty($modObatalkesM->hargaaverage) ? $modObatalkesM->hargaaverage = 0 : "");
            (empty($modObatalkesM->discountinue) ? $modObatalkesM->discountinue = 0 : "");
            $modObatalkesM->tglkadaluarsa = MyFormatter::formatDateTimeForDb($_POST['FAObatalkesM']['tglkadaluarsa']);

            // var_dump($modObatalkesM->attributes); die;

            if ($modObatalkesM->save()) {
              $obat = $this->simpanStokObatAlkesIn2($modObatalkesM);
              //die;
              if ($obat->save()) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $sukses = 1; // 1 = Sukses Create
                $this->redirect(array('create', 'id' => $model->produksiobat_id, 'sukses' => $sukses));
                $this->refresh();
              } else {
                $this->msgStok .= "<br>Stok gagal disimpan !";
              }
            } else {
              $this->msgObat .= "<br>Master Obat " . $modObatalkesM->obatalkes_kode . "-" . $modObatalkesM->obatalkes_nama . " gagal disimpan !";
            }
          }
        } else {
          $this->msgProduksi .= "Produksi Obat " . $model->noproduksiobt . " gagal disimpan !<br>";
        }
        //jika gagal simpan
        $dataDetails = $_POST['FAProduksiobatdetT'];
        $model->isNewRecord = true;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! <br>" . $this->msgProduksiDetail . $this->msgStok . $this->msgObat . $this->msgProduksi);
      } catch (Exception $exc) {
        $model->isNewRecord = true;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('create', array(
      'model' => $model,
      'modProduksiDetail' => $modProduksiDetail,
      'dataDetails' => $dataDetails,
      'modObatalkesM' => $modObatalkesM,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    // if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['FAProduksiobatT'])) {
      $model->attributes = $_POST['FAProduksiobatT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->produksiobat_id));
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
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('FAProduksiobatT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new FAProduksiobatT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['FAProduksiobatT']))
      $model->attributes = $_GET['FAProduksiobatT'];

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
    $model = FAProduksiobatT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'faproduksiobat-t-form') {
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
    $model = new FAProduksiobatT;
    $model->attributes = $_REQUEST['FAProduksiobatT'];
    $judulLaporan = 'Data FAProduksiobatT';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * untuk menyimpan dan validasi detail produksi
   * @param type $model
   * @param type $postDetails
   * @return boolean
   */
  protected function simpanProduksiDetail2($model, $postDetail)
  {
    $modProduksiDetails = new FAProduksiobatdetT;
    $modProduksiDetails->attributes = $postDetail;
    $modProduksiDetails->produksiobat_id = $model->produksiobat_id;
    $modProduksiDetails->qtyproduksi = ceil($modProduksiDetails->qtyproduksi);
    /*
                $modProduksiDetails->qtyproduksi = $postDetail->qtyproduksi;
                $modProduksiDetails->satuankecil_id = $stok->satuankecil_id;
                $modProduksiDetails->obatalkes_id = $stok->obatalkes_id;
                $modProduksiDetails->produksiobat_id = $model->obatalkes_id;
                $modProduksiDetails->hpp = $postDetail->hpp;
                $modProduksiDetails->harganetto = $stok->harganetto;
                $modProduksiDetails->hargasatuan = $postDetail->hargasatuan;
                $modProduksiDetails->keterangan = $model->keternganprdobat;
                $modProduksiDetails->produksiobat_id = $model->produksiobat_id;
                $modProduksiDetails->obatalkesproduksi_id = null;
                 * 
                 */
    if ($modProduksiDetails->save()) {
      $this->modProduksiDetails &= true;
    } else {
      $this->modProduksiDetails &= false;
    }
    return $modProduksiDetails;
  }

  /**
   * untuk menyimpan dan validasi detail produksi
   * @param type $model
   * @param type $postDetails
   * @return boolean
   */
  protected function simpanProduksiDetail($model, $postDetail, $stok)
  {
    $modProduksiDetails = new FAProduksiobatdetT;
    $modProduksiDetails->qtyproduksi = $postDetail->qtyproduksi;
    $modProduksiDetails->satuankecil_id = $stok->satuankecil_id;
    $modProduksiDetails->obatalkes_id = $stok->obatalkes_id;
    $modProduksiDetails->produksiobat_id = $model->obatalkes_id;
    $modProduksiDetails->hpp = $postDetail->hpp;
    $modProduksiDetails->harganetto = $stok->harganetto;
    $modProduksiDetails->hargasatuan = $postDetail->hargasatuan;
    $modProduksiDetails->keterangan = $model->keternganprdobat;
    $modProduksiDetails->produksiobat_id = $model->produksiobat_id;
    $modProduksiDetails->obatalkesproduksi_id = null;
    if ($modProduksiDetails->save()) {
      $this->modProduksiDetails &= true;
    } else {
      $this->modProduksiDetails &= false;
    }
    return $modProduksiDetails;
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  //        $stok['stokobatalkes_id'], $modDetails[$i]
  protected function simpanStokObatAlkesOut2($modDetails)
  {
    $format = new MyFormatter;
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modDetails->obatalkes_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modDetails->attributes; //duplicate
    $modStokOaNew->attributes = $oa->attributes;
    //$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modDetails->qtyproduksi;
    //        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;

    $modStokOaNew->create_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
    $modStokOaNew->validate();
    // var_dump($modStokOaNew->getErrors()); die;
    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
      //$modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  //        $stok['stokobatalkes_id'], $modDetails[$i]
  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modDetails)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modDetails->qtyproduksi;
    //        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  protected function simpanStokObatAlkesIn2($modObatalkesM)
  {
    $format = new MyFormatter;
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modObatalkesM->attributes; //duplicate
    //$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->obatalkes_id = $modObatalkesM->obatalkes_id;
    $modStokOaNew->qtystok_in = $_POST['FAObatalkesM']['stoksekarang'];
    $modStokOaNew->qtystok_out = 0;
    $modStokOaNew->satuankecil_id = $_POST['FAObatalkesM']['satuankecil_id'];
    $modStokOaNew->tglterima = date("Y-m-d H:i:s");
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
    $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
    $modStokOaNew->stokoa_aktif = true;

    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  protected function simpanStokObatAlkesIn($stokobatalkesasal_id, $modObatalkesM)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->obatalkes_id = $modObatalkesM->obatalkes_id;
    $modStokOaNew->qtystok_in = $_POST['FAObatalkesM']['stoksekarang'];
    $modStokOaNew->qtystok_out = 0;
    $modStokOaNew->satuankecil_id = $_POST['FAObatalkesM']['satuankecil_id'];
    $modStokOaNew->tglterima = date("Y-m-d H:i:s");
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
    $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
    $modStokOaNew->stokoa_aktif = true;
    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }


  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionSetFormProduksiDetail()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_REQUEST['obatalkes_id'];
      $jumlah = $_REQUEST['jumlah'];
      $removeButton = true;
      $row = 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modProduksiDetail = new FAProduksiobatdetT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);
      //if(count((array)$modStokOAs) > 0){
      //    $totalharganetto = 0;
      //    $totalhargajual = 0;
      //    foreach($modStokOAs AS $i => $stok){

      $modProduksiDetail->stokobatalkes_id = null; //$stok->stokobatalkes_id;
      $modProduksiDetail->qtyproduksi = $jumlah; //$stok->qtystok_terpakai;
      $modProduksiDetail->harganetto = $oa->harganetto; //$stok->HPP;
      $modProduksiDetail->hargasatuan = $oa->hargajual; //$stok->HargaJualSatuan;
      $modProduksiDetail->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
      $modProduksiDetail->qtystok = $oa->stokObatRuangan; //0; //$stok->qtystok_in - $stok->qtystok_out;
      $modProduksiDetail->obatalkes_nama = $oa->obatalkes_nama; //$modProduksiDetail->obatalkes->obatalkes_nama;
      $modProduksiDetail->obatalkes_kode = $oa->obatalkes_kode; //$modProduksiDetail->obatalkes->obatalkes_kode;
      $modProduksiDetail->hpp = $oa->hpp; //$modProduksiDetail->obatalkes->hpp;
      $modProduksiDetail->satuankecil_id = $oa->satuankecil_id; //$modProduksiDetail->obatalkes->satuankecil_id;
      $modProduksiDetail->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
      $modProduksiDetail->kekuatan = $oa->kekuatan; //$modProduksiDetail->obatalkes->kekuatan;
      $modProduksiDetail->kemasanbesar = $oa->kemasanbesar; //$modProduksiDetail->obatalkes->kemasanbesar;
      $totalharganetto = $modProduksiDetail->harganetto;
      $totalhargajual = $modProduksiDetail->hargasatuan;
      //                    $form .= $this->renderPartial('_rowDetailProduksi', array('modProduksiDetail'=>$modProduksiDetail,'removeButton'=>$removeButton), true);

      //    }
      //}else{
      //    $pesan = "Stok kosong!";
      //}
      //            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
      echo CJSON::encode(array(
        'detailBahan' => $modProduksiDetail->attributes,
        'qtystok' => isset($modProduksiDetail->qtystok) ? $modProduksiDetail->qtystok : "",
        'obatalkes_nama' => isset($modProduksiDetail->obatalkes->obatalkes_nama) ? $modProduksiDetail->obatalkes->obatalkes_nama : "",
        'obatalkes_kode' => isset($modProduksiDetail->obatalkes->obatalkes_kode) ? $modProduksiDetail->obatalkes->obatalkes_kode : "",
        'satuankecil_id' => isset($modProduksiDetail->satuankecil_id) ? $modProduksiDetail->satuankecil_id : "",
        'satuankecil_nama' => isset($modProduksiDetail->satuankecil_nama) ? $modProduksiDetail->satuankecil_nama : "",
        'kekuatan' => isset($modProduksiDetail->kekuatan) ? $modProduksiDetail->kekuatan : "",
        'kemasanbesar' => isset($modProduksiDetail->kemasanbesar) ? $modProduksiDetail->kemasanbesar : "",
        'obatalkes_kode' => isset($modProduksiDetail->obatalkes_kode) ? $modProduksiDetail->obatalkes_kode : "",
        'hargasatuan' => isset($modProduksiDetail->hargasatuan) ? $modProduksiDetail->hargasatuan : "",
        'harganetto' => isset($modProduksiDetail->harganetto) ? $modProduksiDetail->harganetto : "",
        'hpp' => isset($modProduksiDetail->hpp) ? $modProduksiDetail->hpp : "",
        'stokobatalkes_id' => isset($modProduksiDetail->stokobatalkes_id) ? $modProduksiDetail->stokobatalkes_id : "",
        'pesan' => $pesan
      ));
      Yii::app()->end();
    }
  }

  public function actionAutoCompleteObat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = explode(';', $_GET['term']);
      $obatalkes_nama = isset($term[0]) ? $term[0] : '';
      $hargajual = isset($term[1]) ? $term[1] : '';
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
      if ($hargajual != '') {
        $criteria->addCondition('hargajual =' . $hargajual, 'or');
      }
      $criteria->addCondition('obatalkes_farmasi = TRUE');
      $criteria->addCondition('obatalkes_aktif = true');
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = ObatalkesM::model()->findAll($criteria);
      $persenjual = $this->persenJualRuangan();
      $format = new MyFormatter();
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();

          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
          $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qtyStok;
          $returnVal[$i]['value'] = $model->obatalkes_nama;
          $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
          $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
          $returnVal[$i]['qtyStok'] = $qtyStok;
          $returnVal[$i]['hargajual'] = floor(($persenjual + 100) / 100 * $model->hargajual);
          $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
          $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
          $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
          $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
        }

        echo CJSON::encode($returnVal);
      }
    }
    Yii::app()->end();
  }

  protected function persenJualRuangan()
  {
    switch (Yii::app()->user->getState('instalasi_id')) {
      case Params::INSTALASI_ID_RI:
        $persen = Yii::app()->user->getState('ri_persjual');
        break;
      case Params::INSTALASI_ID_RJ:
        $persen = Yii::app()->user->getState('rj_persjual');
        break;
      case Params::INSTALASI_ID_RD:
        $persen = Yii::app()->user->getState('rd_persjual');
        break;
      default:
        $persen = 0;
        break;
    }

    return $persen;
  }

  public function actionAutoCompleteJenisObat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'jenisobatalkes_nama';
      $criteria->limit = 5;
      $models = JenisobatalkesM::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->jenisobatalkes_nama;
          $returnVal[$i]['value'] = $model->jenisobatalkes_id;
        }

        echo CJSON::encode($returnVal);
      }
    }
    Yii::app()->end();
  }
}
