<?php

class PaketpelayananMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.paketpelayananM.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new SAPaketpelayananM;
    $kelas = 0;
    $modPaket = array();

    if (isset($_POST['SAPaketpelayananM'])) {
      $model->attributes = $_POST['SAPaketpelayananM'];
      $modPaket = $this->validasiTabular($_POST['PaketpelayananM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = 0;
        $list = CHtml::listData(PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id' => $model->tipepaket_id)), 'paketpelayanan_id', 'paketpelayanan_id');
        foreach ($modPaket as $i => $row) {
          if ($row->save()) {
            unset($list[$row->paketpelayanan_id]);
            $success++;
          }
        }
        if (count((array)$list) > 0) {
          foreach ($list as $hasil) {
            PaketpelayananM::model()->deleteByPk($hasil);
          }
        }

        //                if (count((array)$modPaket)>0) {
        //                    $this->updateTarifPaket($model);
        //                }

        $modTipePaket = TipepaketM::model()->findByPk($model->tipepaket_id);
        //Update Tipe Paket                        
        $modTipePaket->tarifpaket = $model->tarifpaketpel;
        $modTipePaket->paketsubsidiasuransi = $model->subsidiasuransi;
        $modTipePaket->paketsubsidipemerintah = $model->subsidipemerintah;
        $modTipePaket->paketsubsidirs = $model->subsidirumahsakit;
        $modTipePaket->paketiurbiaya = $model->iurbiaya;
        $modTipePaket->save();
      

        if ((count((array)$modPaket) > 0) && ($success == count((array)$modPaket))) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data " . $model->namatindakan . " Berhasil Disimpan ");
          $this->redirect($this->createUrl('admin'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
        
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modPaket' => $modPaket, 'kelas' => $kelas
    ));
  }

  protected function validasiTabular($data)
  {
    $x = 0;
    foreach ($data as $i => $row) {
      if (!empty($row['paketpelayanan_id'])) {
        $paket[$x] = PaketpelayananM::model()->findByPk($row['paketpelayanan_id']);
      } else {
        $paket[$x] = new PaketpelayananM();
      }
      $paket[$x]->attributes = $row;
      $paket[$x]->namatindakan = $row['namatindakan'];
      $paket[$x]->carabayar_id = isset($row['carabayar_id'])  ?$row['carabayar_id'] : null;
      $paket[$x]->penjamin_id = isset($row['penjamin_id']) ? $row['penjamin_id'] : null;
      $paket[$x]->jenistarif_id = isset($row['jenistarif_id']) ? $row['jenistarif_id'] : null;
      $paket[$x]->subsidiasuransi = floor($row['subsidiasuransi']);
      $paket[$x]->subsidipemerintah = floor($row['subsidipemerintah']);
      $paket[$x]->subsidirumahsakit = floor($row['subsidirumahsakit']);
      $paket[$x]->tarifpaketpel = floor($row['tarifpaketpel']);
      $paket[$x]->iurbiaya = floor($row['iurbiaya']);
      $paket[$x]->qty_tindakan = floor($row['qty_tindakan']);
      $paket[$x]->validate();

      $x++;
    }
    return $paket;
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
    $model->ruangan_id = '';

    $modTipePaket = TipepaketM::model()->findByPk($model->tipepaket_id);
    //		$model->tarifpaketpel=$modTipePaket->tarifpaket;
    //		$model->subsidiasuransi = $modTipePaket->paketsubsidiasuransi;
    //		$model->subsidirumahsakit = $modTipePaket->paketsubsidirs;
    //		$model->subsidipemerintah = $modTipePaket->paketsubsidipemerintah;
    //		$model->iurbiaya = $modTipePaket->paketiurbiaya;
    //                $model->tarifpaketpel= MyFormatter::formatNumberForPrint($model->tarifpaketpel);
    //		$model->subsidiasuransi = MyFormatter::formatNumberForPrint($model->subsidiasuransi);
    //		$model->subsidirumahsakit = MyFormatter::formatNumberForPrint($model->subsidirumahsakit);
    //		$model->subsidipemerintah = MyFormatter::formatNumberForPrint($model->subsidipemerintah);
    //		$model->iurbiaya = MyFormatter::formatNumberForPrint($model->iurbiaya);

    $kelas = $modTipePaket->kelaspelayanan_id;
    $dataPaketPelayanan = PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id' => $model->tipepaket_id));
    // Uncomment the following line if AJAX validation is needed
    //echo $jumlahUlang;exit();

    // var_dump($_POST);die;
    if (isset($_POST['SAPaketpelayananM'])) {
      $model->attributes = $_POST['SAPaketpelayananM'];
      $modPaket = $this->validasiTabular($_POST['PaketpelayananM']);
      $dataPaketPelayanan = $modPaket;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = 0;
        //                        SAPaketpelayananM::model()->deleteAllByAttributes(array('tipepaket_id'=>$model->tipepaket_id));
        $list = CHtml::listData(PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id' => $model->tipepaket_id)), 'paketpelayanan_id', 'paketpelayanan_id');
        foreach ($modPaket as $i => $row) {
          if ($modPaket[$i]->save()) {
            unset($list[$row->paketpelayanan_id]);
            $success++;
          }
        }

        if (count((array)$list) > 0) {
          foreach ($list as $hasil) {
            PaketpelayananM::model()->deleteByPk($hasil);
          }
        }

        //                if (count((array)$modPaket)>0) {
        //                    $this->updateTarifPaket($model);
        //                }
        //Update Tipe Paket                        
        $modTipePaket->tarifpaket = $model->tarifpaketpel;
        $modTipePaket->paketsubsidiasuransi = $model->subsidiasuransi;
        $modTipePaket->paketsubsidipemerintah = $model->subsidipemerintah;
        $modTipePaket->paketsubsidirs = $model->subsidirumahsakit;
        $modTipePaket->paketiurbiaya = $model->iurbiaya;
        $modTipePaket->save();

        if ((count((array)$modPaket) > 0) && ($success == count((array)$modPaket))) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data " . $model->namatindakan . " Berhasil Disimpan ");
          $this->redirect($this->createUrl('admin'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modPaket' => $dataPaketPelayanan, 'kelas' => $kelas,
    ));
  }

  protected function updateTarifPaket($modPaket)
  {

    $paket = TipepaketM::model()->findByPk($modPaket->tipepaket_id);

    $total_tarif = 0;
    $total_subsidi = 0;
    $total_rs = 0;
    $total_iurbiaya = 0;

    //        foreach ($modPaket as $item) {
    //            $total_tarif += $item->tarifpaketpel;
    //            $total_subsidi += $item->subsidiasuransi;
    //            $total_rs += $item->subsidirumahsakit;
    //            $total_iurbiaya += $item->iurbiaya;
    //        }
    //        $paket->tarifpaket = $total_tarif;
    //        $paket->paketsubsidiasuransi = $total_subsidi;
    //        $paket->paketsubsidipemerintah = 0;
    //        $paket->paketsubsidirs = $total_rs;
    //        $paket->paketiurbiaya = $total_iurbiaya;

    $paket->tarifpaket = $modPaket->tarifpaketpel;
    $paket->paketsubsidiasuransi = $modPaket->subsidiasuransi;
    $paket->paketsubsidipemerintah = $modPaket->subsidipemerintah;
    $paket->paketsubsidirs = $modPaket->subsidirumahsakit;
    $paket->paketiurbiaya = $modPaket->iurbiaya;
    $paket->save();

    //        if(){
    //            echo 'asdasa';
    //            exit();
    //        }
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  // public function actionDelete($id)
  // {
  //   if (Yii::app()->request->isPostRequest) {
  //     SAPaketpelayananM::model()->deleteAllByAttributes(array('paketpelayanan_id' => $id));

  //     if (!isset($_GET['ajax']))
  //       $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  //   } else
  //     throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  // }



  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $tipepaket_id = $_POST['tipepaket_id'] ?? $_POST['tipepaket_id'];

      PaketpelayananM::model()->deleteByPk($tipepaket_id);
      TipepaketM::model()->deleteByPk($tipepaket_id);

      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

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
    $dataProvider = new CActiveDataProvider('SAPaketpelayananM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new SAPaketpelayananM('search');
    $modTipePaket = new SATipePaketM('search');

    if (isset($_GET['SATipePaketM'])) {
      $modTipePaket->attributes = $_GET['SATipePaketM'];
    }
    if (isset($_GET['SAPaketpelayananM'])) {
      $modTipePaket->paketpelayanan_id = $_GET['SAPaketpelayananM']['paketpelayanan_id'];
      $modTipePaket->tipepaket_id = $_GET['SAPaketpelayananM']['tipepaket_id'];
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
      'modTipePaket' => $modTipePaket,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $dataModel = SAPaketpelayananM::model()->findByAttributes(array('tipepaket_id' => $id), array('limit' => 1));

    if ($dataModel === null) {
      $model = new SAPaketpelayananM();
      $model->tipepaket_id = $id;
    } else {
      $model = SAPaketpelayananM::model()->findByPk($dataModel->paketpelayanan_id);
      if ($model === null) {
        $model = new SAPaketpelayananM();
        $model->tipepaket_id = $id;
      }
    }
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapaketpelayanan-m-form') {
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

  public function actionPrint()
  {
    $model = new SAPaketpelayananM;
    $modTipePaket = new SATipePaketM('search');
    if (isset($_GET['SATipePaketM'])) {
      $modTipePaket->attributes = $_GET['SATipePaketM'];
    }
    $judulLaporan = 'Data Paket Pelayanan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetPaketPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tr = '';
      if (isset($_POST['tipePaket'])) {
        $modPaketPelayanan = PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id' => $_POST['tipePaket']));
        if (count((array)$modPaketPelayanan) > 0) {
          $data['paket'] = 'Ada';
        } else {
          $data['paket'] = 'Tidak';
        }
      } else {
        $idTipePaket = $_POST['idTipePaket'];
        $idDaftarTindakan = $_POST['idDaftarTindakan'];
        $idTarifTindakan = $_POST['idTarifTindakan'];

        //$idRuangan = null; //isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null;
        $idRuangan = isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null;
        $modTipePaket = TipepaketM::model()->findByPk($idTipePaket);
        $modDaftarTindakan = DaftartindakanM::model()->findByPk($idDaftarTindakan);
        // $namaRuangan = RuanganM::model()->findByPk($idRuangan)->ruangan_nama;
        $modPaketPelayanan = new PaketpelayananM;
        $modTarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $idDaftarTindakan, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL));
        $TarifTindakan = TariftindakanM::model()->findByPk($idTarifTindakan);

        $totaltarif = 0;
        foreach ($modTarifTindakan as $row) {
          $totaltarif += $row->harga_tariftindakan;
        }
        $modPaketPelayanan->tipepaket_id = $idTipePaket;
        $modPaketPelayanan->daftartindakan_id = $idDaftarTindakan;
        $modPaketPelayanan->qty_tindakan = 1;

        $modPaketPelayanan->ruangan_id = $idRuangan;

        $tr .= "<tr>
							<td>" . CHtml::TextField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
          CHtml::activeHiddenField($modPaketPelayanan, '[' . $idDaftarTindakan . ']tipepaket_id') .
          CHtml::activeHiddenField($modPaketPelayanan, '[' . $idDaftarTindakan . ']daftartindakan_id') .
          //CHtml::activeHiddenField($modPaketPelayanan, 'ruangan_id[]', array('value'=>$idRuangan)).
          "</td>
							<td>" . $modTipePaket->tipepaket_nama . "</td>
							<td>" . $modDaftarTindakan->daftartindakan_nama . "</td>
							<td>" . CHtml::activeDropDownList($modPaketPelayanan, '[' . $idDaftarTindakan . ']ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 ruangan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $idDaftarTindakan . ']namatindakan[]', array('value' => $modDaftarTindakan->daftartindakan_nama, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::TextField('totaltarif[]', number_format($TarifTindakan->harga_tariftindakan, 0, ',', '.'), array('readonly' => true, 'class' => 'span2 integer2 totalTarif', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $row->daftartindakan_id . ']tarifpaketpel', array('parent' => 'SAPaketpelayananM_tarifpaketpel', 'class' => 'span2 tarifpaket integer2', 'onblur' => 'tarifPaket(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $row->daftartindakan_id . ']subsidiasuransi', array('parent' => 'SAPaketpelayananM_subsidiasuransi', 'class' => 'span2 subisidiAsuransi integer2', 'onblur' => 'tarifAsuransi(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td class='cols_hide'>" . CHtml::activeTextField($modPaketPelayanan, '[' . $row->daftartindakan_id . ']subsidipemerintah', array('parent' => 'SAPaketpelayananM_subsidipemerintah', 'class' => 'span1 subisidiPemerintah integer2', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $row->daftartindakan_id . ']subsidirumahsakit', array('parent' => 'SAPaketpelayananM_subsidirumahsakit', 'class' => 'span2 subisidiRS integer2', 'onblur' => 'tarifRs(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $row->daftartindakan_id . ']iurbiaya', array('readonly' => true, 'parent' => 'SAPaketpelayananM_iurbiaya', 'class' => 'span2 iurBiaya integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::activeTextField($modPaketPelayanan, '[' . $row->daftartindakan_id . ']qty_tindakan', array('parent' => 'SAPaketpelayananM_qty_tindakan', 'class' => 'span2 qtyTindakan integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>" . CHtml::link("<i class='icon-remove'></i>", '', array('href' => '', 'onclick' => 'remove2(this);return false;')) . "</td>
						</tr>
						";

        $data['tr'] = $tr;
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /*
     * load data tipe paket pada database
     */

  public function actionGetTipePaket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idTipePaket = $_POST['idTipePaket'];
      $modTipePaket = TipepaketM::model()->findByPk($idTipePaket);
      $data['asuransi'] = $modTipePaket->paketsubsidiasuransi;
      $data['pemerintah'] = $modTipePaket->paketsubsidipemerintah;
      $data['rs'] = $modTipePaket->paketsubsidirs;
      $data['iurbiaya'] = $modTipePaket->paketiurbiaya;
      $data['kelaspelayanan_id'] = $modTipePaket->kelaspelayanan_id;
      $data['tarifpaketpel'] = $modTipePaket->tarifpaket;
      $data['carabayar_id'] = $modTipePaket->carabayar_id;
      $data['carabayar_nama'] = (isset($modTipePaket->carabayar) ? $modTipePaket->carabayar->carabayar_nama : "");
      $data['penjamin_id'] = $modTipePaket->penjamin_id;
      $data['penjamin_nama'] = (isset($modTipePaket->penjamin) ? $modTipePaket->penjamin->penjamin_nama : "");
      $data['jenistarif_id'] = $modTipePaket->jenistarif_id;
      $data['jenistarif_nama'] = (isset($modTipePaket->jenistarif) ? $modTipePaket->jenistarif->jenistarif_nama : "");
      $modPaket = PaketpelayananM::model()->findAll('tipepaket_id = ' . $idTipePaket);

      $tr = '';
      if (count((array)$modPaket) > 0) {
        foreach ($modPaket as $i => $row) {
          $modTarifTindakan = TariftindakanM::model()->findByAttributes(array('daftartindakan_id' => $row->daftartindakan_id, 'komponentarif_id' => 6, 'kelaspelayanan_id' => $modTipePaket->kelaspelayanan_id, 'jenistarif_id' => $modTipePaket->jenistarif_id));

          $tarif = 0;
          if (!empty($modTarifTindakan)) {
            $tarif = $modTarifTindakan->harga_tariftindakan;
          }

          $row->tarifpaketpel = MyFormatter::formatNumberForPrint($row->tarifpaketpel);
          $row->subsidiasuransi = MyFormatter::formatNumberForPrint($row->subsidiasuransi);
          $row->subsidipemerintah = MyFormatter::formatNumberForPrint($row->subsidipemerintah);
          $row->subsidirumahsakit = MyFormatter::formatNumberForPrint($row->subsidirumahsakit);
          $row->iurbiaya = MyFormatter::formatNumberForPrint($row->iurbiaya);
          $row->carabayar_id = $modTipePaket->carabayar_id;
          $row->penjamin_id = $modTipePaket->penjamin_id;
          $row->jenistarif_id = $modTipePaket->jenistarif_id;


          $tr .= "<tr>
                            <td>" . CHtml::TextField('noUrut', ($i + 1), array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
            CHtml::activeHiddenField($row, '[' . $row->daftartindakan_id . ']tipepaket_id') .
            CHtml::activeHiddenField($row, '[' . $row->daftartindakan_id . ']daftartindakan_id') .
            CHtml::activeHiddenField($row, '[' . $row->daftartindakan_id . ']ruangan_id') .
            CHtml::activeHiddenField($row, '[' . $row->daftartindakan_id . ']carabayar_id') .
            CHtml::activeHiddenField($row, '[' . $row->daftartindakan_id . ']penjamin_id') .
            CHtml::activeHiddenField($row, '[' . $row->daftartindakan_id . ']jenistarif_id') .
            CHtml::activeHiddenField($row, '[' . $row->daftartindakan_id . ']paketpelayanan_id') . "</td>
                            <td>" . $row->tipepaket->tipepaket_nama . "</td>
                            <td>" . $row->daftartindakan->daftartindakan_nama . "</td>
                            <td>" . CHtml::activeDropDownList($row, '[' . $row->daftartindakan_id . ']ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 ruangan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>" . CHtml::activeTextField($row, '[' . $row->daftartindakan_id . ']namatindakan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>" . CHtml::TextField('totaltarif[]', $tarif, array('readonly' => true, 'class' => 'span2 totalTarif integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>" . CHtml::activeTextField($row, '[' . $row->daftartindakan_id . ']tarifpaketpel', array('parent' => 'SAPaketpelayananM_tarifpaketpel', 'class' => 'span2 tarifpaket integer2', 'onblur' => 'tarifPaket(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>" . CHtml::activeTextField($row, '[' . $row->daftartindakan_id . ']subsidiasuransi', array('parent' => 'SAPaketpelayananM_subsidiasuransi', 'class' => 'span2 subisidiAsuransi integer2', 'onblur' => 'tarifAsuransi(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td hidden>" . CHtml::activeTextField($row, '[' . $row->daftartindakan_id . ']subsidipemerintah', array('parent' => 'SAPaketpelayananM_subsidipemerintah', 'class' => 'span2 subisidiPemerintah integer2', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>" . CHtml::activeTextField($row, '[' . $row->daftartindakan_id . ']subsidirumahsakit', array('parent' => 'SAPaketpelayananM_subsidirumahsakit', 'class' => 'span2 subisidiRS integer2', 'onblur' => 'tarifRs(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>" . CHtml::activeTextField($row, '[' . $row->daftartindakan_id . ']iurbiaya', array('readonly' => true, 'parent' => 'SAPaketpelayananM_iurbiaya', 'class' => 'span2 iurBiaya integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>" . CHtml::activeTextField($row, '[' . $row->daftartindakan_id . ']qty_tindakan', array('readonly' => true, 'parent' => 'SAPaketpelayananM_qty_tindakan', 'class' => 'span2 qtyTindakan integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>

                            <td>" . CHtml::link("<i class='icon-remove'></i>", '', array('href' => '', 'onclick' => 'remove2(this);return false;')) . "</td>
                        </tr>";
        }
      }
      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
