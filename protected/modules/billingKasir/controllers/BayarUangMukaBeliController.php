<?php

class BayarUangMukaBeliController extends MyAuthController
{
  protected $successSave = true;
  public $path_view = 'billingKasir.views.bayarUangMukaBeli.';

  public function actionIndex($tandabuktikeluar_id = null)
  {
    $modSupplier = new BKSupplierM;
    $modUangMuka = new BKUangMukaBeliT;
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->untukpembayaran = 'Pembayaran Uang Muka Pembelian';
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->jmlkaskeluar = 0;
    if (!empty($tandabuktikeluar_id)) {
      $modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
    }
    if (isset($_POST['BKTandabuktikeluarT'])) {
      $idSupplier = $_POST['BKSupplierM']['supplier_id'];
      $modSupplier->attributes = $_POST['BKSupplierM'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modBuktiKeluar = $this->saveBuktiKeluar($_POST['BKTandabuktikeluarT']);
        $modUangMuka = $this->saveBayarUangMukaBeli($modBuktiKeluar, $idSupplier);
        if ($this->successSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modSupplier' => $modSupplier,
      'modUangMuka' => $modUangMuka,
      'modBuktiKeluar' => $modBuktiKeluar
    ));
  }

  protected function saveBuktiKeluar($postBuktiKeluar)
  {
    $format = new MyFormatter;
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    // $modBuktiKeluar->jmlkaskeluar = $format->formatNumberForDb($postBuktiKeluar['jmlkaskeluar']);
    // echo "<pre>"; print_r($modBuktiKeluar->jmlkaskeluar); exit;

    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modBuktiKeluar;
  }

  protected function saveBayarUangMukaBeli($modBuktiKeluar, $idSupplier)
  {
    $modBayarUangMuka = new BKUangMukaBeliT;
    $modBayarUangMuka->supplier_id = $idSupplier;
    $modBayarUangMuka->namabank = $modBuktiKeluar->melalubank;
    $modBayarUangMuka->norekening = $modBuktiKeluar->denganrekening;
    $modBayarUangMuka->rekatasnama = $modBuktiKeluar->atasnamarekening;
    $modBayarUangMuka->jumlahuang = $modBuktiKeluar->jmlkaskeluar;
    if ($modBayarUangMuka->validate()) {
      $modBayarUangMuka->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $modBayarUangMuka;
  }

  public function actionDaftarSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      //$criteria->with = array();
      $criteria->compare('LOWER(supplier_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'supplier_nama DESC';
      $models = SupplierM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->supplier_kode . ' - ' . $model->supplier_nama;
        $returnVal[$i]['value'] = $model->supplier_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrint($tandabuktikeluar_id)
  {
    $this->layout = '//layouts/printWindows';
    $modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);

    $this->render($this->path_view . 'print', array(
      'modBuktiKeluar' => $modBuktiKeluar,
    ));
  }
}
