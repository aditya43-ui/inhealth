<?php
class JurnalUmumPosting2Controller extends MyAuthController
{
  public $success = false;

  public function loadModel($id)
  {
    $model = AKJurnalrekeningT::model()->findByPk($id);
    if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionAdmin()
  {
    $model = new AKJurnaldetailT();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_REQUEST['AKJurnaldetailT'])) {
      $format = new MyFormatter();
      $model->attributes = $_REQUEST['AKJurnaldetailT'];

      $model->tgl_awal = $_REQUEST['AKJurnaldetailT']['tgl_awal'];
      $model->tgl_akhir = $_REQUEST['AKJurnaldetailT']['tgl_akhir'];
      $model->is_posting = $_REQUEST['AKJurnaldetailT']['is_posting'];
      $model->jenisjurnal_id = $_REQUEST['AKJurnaldetailT']['jenisjurnal_id'];
      $model->nobuktijurnal = $_REQUEST['AKJurnaldetailT']['nobuktijurnal'];
      $model->noreferensi = $_REQUEST['AKJurnaldetailT']['noreferensi'];
      $model->kodejurnal = $_REQUEST['AKJurnaldetailT']['kodejurnal'];
    }
    $this->render(
      'gridJurnalUmum',
      array(
        'model' => $model
      )
    );
  }

  public function actionIndex()
  {
    $model = new AKJurnalrekeningT();
    $modelJurDetail = new AKJurnaldetailT();
    $modelJurPosting = new AKJurnalpostingT();
    $rekeningakuntansiV = new AKRekeningakuntansiV;
    $periodeID = Yii::app()->user->getState('periode_ids');
    $model->rekperiod_id = $periodeID[0];
    $model->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $model->kodejurnal = MyGenerator::kodeJurnalRek();
    $urlRedirect = Yii::app()->createUrl(Yii::app()->controller->module->id . '/RekperiodM');

    $model->tglbuktijurnal = date('Y-m-d H:m:s');
    $model->tglreferensi = date('Y-m-d H:m:s');

    $this->render(
      'index',
      array(
        'model' => $model,
        'modelJurDetail' => $modelJurDetail,
        'modelJurPosting' => $modelJurPosting,
        'rekeningakuntansiV' => $rekeningakuntansiV,
        'redirect' => array($periodeID, $urlRedirect)
      )
    );
  }

  public function actionGetDataRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new AKRekeningakuntansiV();
      $get_id = explode("x", $_POST['id']);
      $model->$get_id[0] = $get_id[1];
      //            $model->rincianobyek_id = $_POST['id'];
      $result = $model->getInfoRekening();
      $rec = $result->attributes;
      if (isset($result->rincianobyek_id)) {
        $rec['nmrincianobyek'] = $result->nmrincianobyek;
      } else {
        if (isset($this->obyek_id)) {
          $rec['nmrincianobyek'] = $result->nmobyek;
        } else {
          $rec['nmrincianobyek'] = $result->nmjenis;
        }
      }
      echo json_encode($rec);
    }
    Yii::app()->end();
  }

  public function actionSimpanJurnalUmum()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $is_action = 'insert';
      $pesan = 'succes';
      parse_str($_REQUEST['data'], $data_parsing);
      $data_parsing['AKJurnalrekeningT']['tglbuktijurnal'] = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tglbuktijurnal']);
      $data_parsing['AKJurnalrekeningT']['tglreferensi'] = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tglreferensi']);
      $transaction = Yii::app()->db->beginTransaction();

      try {

        $jurnal_rek = $this->simpanJurnal($data_parsing['AKJurnalrekeningT']);
        $jurPosting = null;
        if ($_REQUEST['jenis_simpan'] == 'posting') {
          $params = array();
          $params['tgljurnalpost'] = $data_parsing['AKJurnalrekeningT']['tglbuktijurnal'];
          $params['keterangan'] = "Posting Otomatis";
          $params['create_time'] = date('Y-m-d');
          $params['update_time'] = date('Y-m-d');
          $params['create_loginpemekai_id'] = Yii::app()->user->id;
          $params['update_loginpemakai_id'] = Yii::app()->user->id;
          $params['create_ruangan'] = Yii::app()->user->getState('ruangan_id');
          $jurPosting = $this->simpanJurnalPosting($params);
        }
        $this->simpanDetailJurnal($data_parsing, $jurnal_rek, $jurPosting);

        if ($this->success) {
          $transaction->commit();

          $periodeID = Yii::app()->user->getState('periode_ids');
          $pesan = array(
            'nobuktijurnal' => MyGenerator::noBuktiJurnalRek(),
            'kodejurnal' => MyGenerator::kodeJurnalRek(),
            'rekperiod_id' => $periodeID[0]
          );
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $pesan = $exc;
        $this->success = false;
      }

      $result = array(
        'action' => $is_action,
        'pesan' => $pesan,
        'status' => ($this->success == true) ? 'ok' : 'not',
      );
      echo json_encode($result);
    }
    Yii::app()->end();
  }

  private function simpanJurnal($params)
  {
    $model = new AKJurnalrekeningT();
    $model->attributes = $params;
    $model->create_time = date('Y-m-d');
    $model->update_time = date('Y-m-d');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->update_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($model->validate()) {
      if ($model->save()) {
        $this->success = true;
      } else {
        $this->success = false;
        print_r($model->getErrors());
      }
    } else {
      print_r('AKJurnalrekeningT');
      print_r($model->getErrors());
      $this->success = false;
    }
    return $model;
  }

  private function simpanJurnalPosting($params)
  {
    $model = new AKJurnalpostingT();
    $model->attributes = $params;
    if ($model->validate()) {
      if ($model->save()) {
        $this->success = true;
      } else {
        $this->success = false;
        print_r($model->getErrors());
      }
    } else {
      $this->success = false;
      print_r($model->getErrors());
    }
    return $model;
  }

  private function simpanDetailJurnal($params, $jurnal_rek, $jurPosting = null)
  {
    $modDetail = $this->validasiTabular($params['AKJurnaldetailT']);
    foreach ($modDetail as $i => $data) {
      $data->rekperiod_id = $params['AKJurnalrekeningT']['rekperiod_id'];
      $data->jurnalrekening_id = $jurnal_rek->jurnalrekening_id;
      if (isset($jurPosting->jurnalposting_id)) {
        $data->jurnalposting_id = $jurPosting->jurnalposting_id;
      }
      if ($data->jurnaldetail_id > 0) {
        if ($data->update()) {
          $this->success = true;
        } else {
          $this->success = false;
        }
      } else {
        if ($data->save()) {
          $this->success = true;
        } else {
          $this->success = false;
          print_r($data->getErrors());
        }
      }
    }
  }

  private function validasiTabular($params)
  {
    $modDetails = array();
    sort($params);
    foreach ($params as $i => $row) {
      $modDetails[$i] = new AKJurnaldetailT();
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public  function actionRincianJurnal()
  {
    $this->layout = '//layouts/iframe';
    $model = new AKJurnaldetailT();
    $model->jurnalrekening_id = $_GET['id'];
    $this->render(
      '__gridRincianJurnal',
      array(
        'model' => $model
      )
    );
  }

  public  function actionEditJurnal()
  {
    $model = $this->loadModel($_GET['id']);
    $this->render(
      'editJurnal',
      array(
        'model' => $model
      )
    );
  }
}
