<?php

class PenerimaanUmumController extends MyAuthController
{
  protected $succesSave = true;

  public function actionIndex()
  {
    $modPenUmum = new BKPenerimaanUmumT;
    $modPenUmum->volume = 1;
    $modPenUmum->isuraintransaksi = 0;
    $modPenUmum->hargasatuan = 0;
    $modPenUmum->totalharga = 0;
    $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
    $modUraian[0] = new BKUraianpenumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;
    $modTandaBukti = new BKTandabuktibayarT;
    $modTandaBukti->jmlpembulatan = 0;
    $modTandaBukti->biayaadministrasi = 0;
    $modTandaBukti->biayamaterai = 0;
    $modTandaBukti->jmlpembayaran = $modPenUmum->totalharga;

    if (isset($_POST['BKPenerimaanUmumT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modTandaBukti = $this->saveTandaBukti($_POST['BKTandabuktibayarT']);
        $modPenUmum = $this->savePenerimaan($_POST['BKPenerimaanUmumT'], $modTandaBukti);
        if (isset($_POST['adaUraian'])) {
          if (($_POST['adaUraian'] == true) && isset($_POST['BKUraianpenumumT'])) {
            $modUraian = $this->saveUraian($_POST['BKUraianpenumumT'], $modPenUmum);
          }
        }

        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'modPenUmum' => $modPenUmum,
      'modUraian' => $modUraian,
      'modTandaBukti' => $modTandaBukti
    ));
  }

  protected function saveTandaBukti($postTandaBukti)
  {
    $format = new MyFormatter();

    $modTandaBukti = new BKTandabuktibayarT;
    $modTandaBukti->attributes = $postTandaBukti;
    $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTandaBukti->shift_id = 1;
    $modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($postTandaBukti['tglbuktibayar']);
    $modTandaBukti->alamat_bkm = $postTandaBukti['alamat_bkm'];
    $modTandaBukti->create_time = date("Y-m-d h:i:s");
    $modTandaBukti->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    $modTandaBukti->create_ruangan = $modTandaBukti->ruangan_id;
    $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
    $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
    if ($modTandaBukti->validate()) {
      $modTandaBukti->save();
      $this->succesSave = $this->succesSave && true;
    } else {
      $this->succesSave = $this->succesSave && false;
    }

    return $modTandaBukti;
  }

  protected function savePenerimaan($postPenerimaan, $modTandaBukti)
  {
    $modPenUmum = new BKPenerimaanUmumT;
    $modPenUmum->attributes = $postPenerimaan;
    $modPenUmum->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenUmum->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $modPenUmum->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
    $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
    if ($modPenUmum->validate()) {
      $modPenUmum->save();
      $this->succesSave = $this->succesSave && true;
    } else {
      $this->succesSave = $this->succesSave && false;
    }
    return $modPenUmum;
  }

  protected function saveUraian($arrPostUraian, $modPenUmum)
  {
    $valid = true;
    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {
      $modUraian[$i] = new BKUraianpenumumT;
      $modUraian[$i]->attributes = $arrPostUraian[$i];
      $modUraian[$i]->penerimaanumum_id = $modPenUmum->penerimaanumum_id;
      $valid = $valid && $modUraian[$i]->validate();
    }
    if ($valid) {
      for ($j = 0; $j < count((array)$arrPostUraian); $j++) {
        $modUraian[$j]->save();
      }
    }

    $this->succesSave = $this->succesSave && $valid;

    return $modUraian;
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
