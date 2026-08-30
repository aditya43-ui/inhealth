<?php
Yii::import('sistemAdministrator.controllers.RekeningPelayananController');
Yii::import('sistemAdministrator.models.*');
class RekeningPelayananAKController extends RekeningPelayananController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.rekeningPelayanan.';

  public function actionCreate()
  {
    $model = new AKPelayananRekM();
    $modTindakanRuangan = new AKPelayananRekM('search');
    $modTindakanRuangan->unsetAttributes();
    $modTindakanRuangan->ruangan_id = null; //default tidak muncul data
    /*
        if (Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN) {
            //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            //$model->ruangan_nama = Yii::app()->user->getState('ruangan_nama');
            $modTindakanRuangan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
         *
         */
    if (isset($_GET['AKPelayananRekM'])) {
      $modTindakanRuangan->attributes = $_GET['AKPelayananRekM'];
      $modTindakanRuangan->ruangan_id = $_GET['AKPelayananRekM']['ruangan_id'];
      $modTindakanRuangan->kdrekening5 = $_GET['AKPelayananRekM']['kdrekening5'];
      $modTindakanRuangan->nmrekening5 = $_GET['AKPelayananRekM']['nmrekening5'];
      $modTindakanRuangan->saldonormal = $_GET['AKPelayananRekM']['saldonormal'];
      //$modTindakanRuangan->kelompoktindakan_nama = $_GET['AKPelayananRekM']['kelompoktindakan_nama'];
      //$modTindakanRuangan->kategoritindakan_nama = $_GET['AKPelayananRekM']['kategoritindakan_nama'];
      //$modTindakanRuangan->daftartindakan_kode = $_GET['AKPelayananRekM']['daftartindakan_kode'];
      $modTindakanRuangan->daftartindakan_nama = $_GET['AKPelayananRekM']['daftartindakan_nama'];
    }

    if (Yii::app()->request->isPostRequest) { //submit by ajax
      $data['sukses'] = 0;
      $data['pesan'] = "";

      if (isset($_POST['AKPelayananRekM'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $loadTindakanRuangan = AKPelayananRekM::model()->findByAttributes(array(
            'daftartindakan_id' => $_POST['AKPelayananRekM']['daftartindakan_id'],
            'ruangan_id' => $_POST['AKPelayananRekM']['ruangan_id'],
            'komponentarif_id' => $_POST['AKPelayananRekM']['komponentarif_id'],
            'ispelayanan' => empty($_POST['AKPelayananRekM']['ispelayanan']) ? false : true,
            'ispembayaran' => empty($_POST['AKPelayananRekM']['ispembayaran']) ? false : true,
            'isretur' => empty($_POST['AKPelayananRekM']['isretur']) ? false : true,
            'ishutang' => empty($_POST['AKPelayananRekM']['ishutang']) ? false : true,
          ));
          if ($loadTindakanRuangan) {
            $data['sukses'] = 0;
            $data['pesan'] = "Tindakan " . $loadTindakanRuangan->daftartindakan->daftartindakan_nama . "sudah ada di " . $loadTindakanRuangan->ruangan->ruangan_nama . "!";
          } else {

            if (!empty($_POST['AKPelayananRekM']['rekening5_id_d']) && !empty($_POST['AKPelayananRekM']['rekening5_id_k'])) {
              $model_d = new AKPelayananRekM;
              $model_d->ruangan_id = $_POST['AKPelayananRekM']['ruangan_id'];
              $model_d->daftartindakan_id = $_POST['AKPelayananRekM']['daftartindakan_id'];
              $model_d->jnspelayanan = $_POST['AKPelayananRekM']['jnspelayanan'];
              $model_d->komponentarif_id = $_POST['AKPelayananRekM']['komponentarif_id'];
              $model_d->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_d'];
              $model_d->debitkredit = "D";
              $model_d->saldonormal = "D";
              $model_d->create_time = date('Y-m-d H:i:s');
              $model_d->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $model_d->create_ruangan = Yii::app()->user->getState('ruangan_id');

              $model_d->ispelayanan = $_POST['AKPelayananRekM']['ispelayanan'];
              //                            $model_d->ispembayaran = $_POST['AKPelayananRekM']['ispembayaran'];
              // $model_d->isretur = $_POST['AKPelayananRekM']['isretur'];
              //                            $model_d->ishutang = $_POST['AKPelayananRekM']['ishutang'];

              if (!empty($model_d->rekening5_id)) {
                $model_d = $this->inputRek($model_d);
              }

              $model_k = new AKPelayananRekM;
              $model_k->ruangan_id = $_POST['AKPelayananRekM']['ruangan_id'];
              $model_k->daftartindakan_id = $_POST['AKPelayananRekM']['daftartindakan_id'];
              $model_k->jnspelayanan = $_POST['AKPelayananRekM']['jnspelayanan'];
              $model_k->komponentarif_id = $_POST['AKPelayananRekM']['komponentarif_id'];
              $model_k->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_k'];
              $model_k->saldonormal = "K";
              $model_k->debitkredit = "K";
              $model_k->create_time = date('Y-m-d H:i:s');
              $model_k->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $model_k->create_ruangan = Yii::app()->user->getState('ruangan_id');


              $model_k->ispelayanan = $_POST['AKPelayananRekM']['ispelayanan'];
              //                            $model_k->ispembayaran = $_POST['AKPelayananRekM']['ispembayaran'];
              // $model_k->isretur = $_POST['AKPelayananRekM']['isretur'];
              //                            $model_k->ishutang = $_POST['AKPelayananRekM']['ishutang'];

              if (!empty($model_k->rekening5_id)) {
                $model_k = $this->inputRek($model_k);
              }


              // var_dump($model_k->attributes); die;

              if ($model_d->save() && $model_k->save()) {
                $transaction->commit();
                $data['sukses'] = 1;
                $data['pesan'] = "Tindakan " . $model_d->daftartindakan->daftartindakan_nama . " di " . $model_d->ruangan->ruangan_nama . " berhasil disimpan!";
              } else {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data gagal disimpan! <br>" . CHtml::errorSummary($model);
              }
            } else {

              $model = new AKPelayananRekM;
              $model->ruangan_id = $_POST['AKPelayananRekM']['ruangan_id'];
              $model->daftartindakan_id = $_POST['AKPelayananRekM']['daftartindakan_id'];
              $model->jnspelayanan = $_POST['AKPelayananRekM']['jnspelayanan'];
              $model->komponentarif_id = $_POST['AKPelayananRekM']['komponentarif_id'];
              if (!empty($_POST['AKPelayananRekM']['rekening5_id_d'])) {
                $model->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_d'];
                $model->saldonormal = 'D';
                $model->debitkredit = 'D';
              }
              if (!empty($_POST['AKPelayananRekM']['rekening5_id_k'])) {
                $model->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_k'];
                $model->saldonormal = 'K';
                $model->debitkredit = 'K';
              }
              // var_dump($model->attributes);
              $model->ispelayanan = $_POST['AKPelayananRekM']['ispelayanan'];
              //								$model->ispembayaran = $_POST['AKPelayananRekM']['ispembayaran'];
              // $model->isretur = $_POST['AKPelayananRekM']['isretur'];
              //								$model->ishutang = $_POST['AKPelayananRekM']['ishutang'];
              $model->create_time = date('Y-m-d H:i:s');
              $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

              if (!empty($model->rekening5_id)) {
                $model = $this->inputRek($model);
              }

              if ($model->save()) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
                $data['sukses'] = 1;
                $data['pesan'] = "Tindakan " . $model->daftartindakan->daftartindakan_nama . " di " . $model->ruangan->ruangan_nama . " berhasil disimpan!";
              } else {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data gagal disimpan! <br>" . CHtml::errorSummary($model);
              }
            }
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          echo $exc->getMessage();
          die;
          $data['sukses'] = 0;
          $data['pesan'] = 'Data gagal disimpan!' . MyExceptionMessage::getMessage($exc, true);
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modTindakanRuangan' => $modTindakanRuangan,
    ));
  }

  public function actionUpdate($id)
  {
    $model = AKPelayananRekM::model()->findByPk($id);

    $model->daftartindakan_nama = isset($model->daftartindakan_id) ? $model->daftartindakan->daftartindakan_nama : null;
    $model->komponentarif_nama = isset($model->komponentarif_id) ? $model->komponentarif->komponentarif_nama : null;
    $model->ruangan_nama = isset($model->ruangan_id) ? $model->ruangan->ruangan_nama : null;
    if ($model->debitkredit == 'D') {
      $model->rekening5_id_d = $model->rekening5_id;
      $model->nmrekening5_d = isset($model->rekening5_id) ? $model->rekening5->nmrekening5 : null;
    } else {
      $model->rekening5_id_k = $model->rekening5_id;
      $model->nmrekening5_k = isset($model->rekening5_id) ? $model->rekening5->nmrekening5 : null;
    }

    if (isset($_POST['AKPelayananRekM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['AKPelayananRekM'];
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        if (!empty($_POST['AKPelayananRekM']['rekening5_id_d'])) {
          $model->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_d'];
          $model->saldonormal = 'D';
          $model->debitkredit = 'D';
        }
        if (!empty($_POST['AKPelayananRekM']['rekening5_id_k'])) {
          $model->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_k'];
          $model->saldonormal = 'K';
          $model->debitkredit = 'K';
        }
        if (!empty($model->rekening5_id)) {
          $model = $this->inputRek($model);
        }
        $model->ispelayanan = $_POST['AKPelayananRekM']['ispelayanan'];
        //                        $model->ispembayaran = $_POST['AKPelayananRekM']['ispembayaran'];
        // $model->isretur = $_POST['AKPelayananRekM']['isretur'];
        //                        $model->ishutang = $_POST['AKPelayananRekM']['ishutang'];

        if ($model->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          //                        Yii::app()->user->setFlash('success', "Data Rekening Pelayanan telah berhasil disimpan !");
          $this->redirect(array('update', 'id' => $id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Rekening Pelayanan Gagal disimpan");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Rekening Pelayanan gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(SARuanganM::getItems($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionAutocompleteTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(daftartindakan_nama)', strtolower($term), true);
      $criteria->compare('LOWER(daftartindakan_kode)', strtolower($term), true, 'OR');
      $criteria->order = 'daftartindakan_nama';
      $criteria->limit = 5;

      $models = SADaftarTindakanM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->daftartindakan_kode . " " . $model->daftartindakan_nama;
        $returnVal[$i]['value'] = $model->daftartindakan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($idRuangan, $idTindakan)
  {
    $modKasusPenyakitRuangan = array();
    $this->render($this->path_view . 'view', array(
      'model' => RuanganM::model()->findByPk($idRuangan),
      'modKasusPenyakitRuangan' => $modKasusPenyakitRuangan,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      // we only allow deletion via POST request
      $transaction = Yii::app()->db->beginTransaction();
      try {
        PelayananrekM::model()->deleteByPk($_GET['id']);
        $transaction->commit();
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Rekening Pelayanan";
    $model = new AKRekeningpelayananV('search');
    $model->unsetAttributes();  // clear any default values
    if (Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN) {
      // ->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    if (isset($_GET['AKRekeningpelayananV'])) {
      $model->attributes = $_GET['AKRekeningpelayananV'];
      $model->kdrekening5 = isset($_GET['AKRekeningpelayananV']['kdrekening5']) ? $_GET['AKRekeningpelayananV']['kdrekening5'] : null;
      $model->nmrekening5 = isset($_GET['AKRekeningpelayananV']['nmrekening5']) ? $_GET['AKRekeningpelayananV']['nmrekening5'] : null;
      $model->daftartindakan_nama = isset($_GET['AKRekeningpelayananV']['daftartindakan_nama']) ? $_GET['AKRekeningpelayananV']['daftartindakan_nama'] : null;
      $model->saldonormal = isset($_GET['AKRekeningpelayananV']['saldonormal']) ? $_GET['AKRekeningpelayananV']['saldonormal'] : null;
      $model->mappingruangan = isset($_GET['AKRekeningpelayananV']['mappingruangan']) ? $_GET['AKRekeningpelayananV']['mappingruangan'] : null;
      $model->mappingpelayanan = isset($_GET['AKRekeningpelayananV']['mappingpelayanan']) ? $_GET['AKRekeningpelayananV']['mappingpelayanan'] : null;
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  protected function inputRek($model)
  {


    //var_dump($model->attributes); die;

    // $r = RekeningakuntansiV::model()->findByAttributes(array(
    //   'rekeninglast_id' => $model->rekening5_id
    // ));
    // $model->rekening4_id = $r->rekening4_id;
    // $model->rekening3_id = $r->rekening3_id;
    // $model->rekening2_id = $r->rekening2_id;
    // $model->rekening1_id = $r->rekening1_id;


    return $model;
  }

  public function actionPrint()
  {
    $model = new AKRekeningpelayananV('search');
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['AKRekeningpelayananV'])) {
      $model->attributes = $_GET['AKRekeningpelayananV'];
      $model->kdrekening5 = isset($_GET['AKRekeningpelayananV']['kdrekening5']) ? $_GET['AKRekeningpelayananV']['kdrekening5'] : null;
      $model->nmrekening5 = isset($_GET['AKRekeningpelayananV']['nmrekening5']) ? $_GET['AKRekeningpelayananV']['nmrekening5'] : null;
      $model->daftartindakan_nama = isset($_GET['AKRekeningpelayananV']['daftartindakan_nama']) ? $_GET['AKRekeningpelayananV']['daftartindakan_nama'] : null;
      $model->saldonormal = isset($_GET['AKRekeningpelayananV']['saldonormal']) ? $_GET['AKRekeningpelayananV']['saldonormal'] : null;
      $model->mappingruangan = isset($_GET['AKRekeningpelayananV']['mappingruangan']) ? $_GET['AKRekeningpelayananV']['mappingruangan'] : null;
      $model->mappingpelayanan = isset($_GET['AKRekeningpelayananV']['mappingpelayanan']) ? $_GET['AKRekeningpelayananV']['mappingpelayanan'] : null;
    }

    $judulLaporan = 'Data Rekening Pelayanan ';
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
      $footer = '
                <table width="100%">
                <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
                 <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
                </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }
}
