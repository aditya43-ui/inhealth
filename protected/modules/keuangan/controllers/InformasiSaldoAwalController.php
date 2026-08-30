<?php

class InformasiSaldoAwalController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Saldo Awal";
    $model = new KUInformasisaldoawalV;
    $model->unsetAttributes();

    if (isset($_GET['KUInformasisaldoawalV'])) {
      $model->attributes = $_GET['KUInformasisaldoawalV'];
    }

    // ===== Rekening 1 =====
    // $criteria->addBetweenCondition('tglbuktijurnal', $modelLaporan->tglAwal, $modelLaporan->tglAkhir);
    // $criteria = new CDbCriteria;
    // $criteria->select = 'rekening1_id, nmrekening1, count(nmrekening1) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
    // $criteria->compare('LOWER(nmrekening5)', strtolower($model->nmrekening5), true);
    // $criteria->compare('LOWER(kdrekening5)', strtolower($model->kdrekening5), true);
    // $criteria->group = 'nmrekening1, rekening1_id';
    // $criteria->order = 'rekening1_id';
    // $rekening1 = KUInformasisaldoawalV::model()->findAll($criteria);

    // // ===== Rekening 2 =====
    // $criteria = new CDbCriteria;
    // $criteria->select = 'rekening1_id, rekening2_id, nmrekening2, count(nmrekening2) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
    // $criteria->compare('LOWER(nmrekening5)', strtolower($model->nmrekening5), true);
    // $criteria->compare('LOWER(kdrekening5)', strtolower($model->kdrekening5), true);
    // $criteria->group = 'nmrekening2, rekening2_id, rekening1_id';
    // $criteria->order = 'rekening1_id, rekening2_id';
    // $rekening2 = KUInformasisaldoawalV::model()->findAll($criteria);

    // // ===== Rekening 3 =====
    // $criteria = new CDbCriteria;
    // $criteria->select = 'rekening1_id, rekening2_id, rekening3_id, nmrekening3, count(nmrekening3) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
    // $criteria->compare('LOWER(nmrekening5)', strtolower($model->nmrekening5), true);
    // $criteria->compare('LOWER(kdrekening5)', strtolower($model->kdrekening5), true);
    // $criteria->group = 'nmrekening3, rekening3_id, rekening2_id, rekening1_id';
    // $criteria->order = 'rekening1_id, rekening2_id, rekening3_id';
    // $rekening3 = KUInformasisaldoawalV::model()->findAll($criteria);

    // // ===== Rekening 4 =====
    // $criteria = new CDbCriteria;
    // $criteria->select = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, nmrekening4, count(nmrekening4) as jmlrekening, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
    // $criteria->compare('LOWER(nmrekening5)', strtolower($model->nmrekening5), true);
    // $criteria->compare('LOWER(kdrekening5)', strtolower($model->kdrekening5), true);
    // $criteria->group = 'nmrekening4,  rekening4_id, rekening3_id, rekening2_id, rekening1_id';
    // $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id';
    // $rekening4 = KUInformasisaldoawalV::model()->findAll($criteria);

    // ===== Rekening 5 =====
    $criteria = new CDbCriteria;
    $criteria->select = 'rekening5_id, nmrekening5, sum(jmlsaldoawald) as debit, sum(jmlsaldoawalk) as kredit';
    $criteria->compare('LOWER(nmrekening5)', strtolower($model->nmrekening5), true);
    $criteria->compare('LOWER(kdrekening5)', strtolower($model->kdrekening5), true);
    $criteria->group = 'nmrekening5, rekening5_id';
    $criteria->order = 'rekening5_id';
    $rekening5 = KUInformasisaldoawalV::model()->findAll($criteria);

    $this->render('index', array(
      'model' => $model, 'rekening5' => $rekening5,
    ));
  }
}
