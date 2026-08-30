<?php

Yii::import('farmasiApotek.controllers.PemakaianObatController');
Yii::import('farmasiApotek.models.*');

class PemakaianObatAMController extends PemakaianObatController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'farmasiApotek.views.pemakaianObat.';
  public $pemakaianobatsimpan = false;
  public $pemakaianobatdetailsimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping

  public function actionIndex($pemakaianobat_id = null, $a = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
    $model = new FAPemakaianobatT();
    $model->nopemakaian_obat = '-- Otomatis --';
    $modDetails = array();

    if (!empty($pemakaianobat_id)) {
      $model = FAPemakaianobatT::model()->findByPk($pemakaianobat_id);
      $modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id' => $pemakaianobat_id));
    }

    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['FAPemakaianobatT'])) {
      $model = $this->savePemakaianObat($_POST['FAPemakaianobatT']);
      if ($this->pemakaianobatsimpan) {
        if (count((array)$_POST['FAPemakaianobatdetailT']) > 0) {
          //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
          $detailGroups = array();
          foreach ($_POST['FAPemakaianobatdetailT'] as $i => $postDetail) {
            $modDetails[$i] = new FAPemakaianobatdetailT;
            $modDetails[$i]->attributes = $postDetail;
            $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
            $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
            $obatalkes_id = $postDetail['obatalkes_id'];
            if (isset($detailGroups[$obatalkes_id])) {
              $detailGroups[$obatalkes_id]['qty_satuanpakai'] += $postDetail['qty_satuanpakai'];
            } else {
              $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
              $detailGroups[$obatalkes_id]['qty_satuanpakai'] = $postDetail['qty_satuanpakai'];
              //$detailGroups[$obatalkes_id]['ket_obatpakai'] = $postDetail['ket_obatpakai'];
            }
          }
          //END GROUP
        }
        $obathabis = "";
        //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
        foreach ($detailGroups as $i => $detail) {
          $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_satuanpakai'], Yii::app()->user->getState('ruangan_id'));
          if (count((array)$modStokOAs) > 0) {
            foreach ($modStokOAs as $i => $stok) {
              $modDetails[$i] = $this->savePemakaianObatDetail($model, $stok, $_POST['FAPemakaianobatdetailT'], $detail);
              $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
            }
          } else {
            $this->stokobatalkestersimpan &= false;
            $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
          }
        }

        try {
          if ($this->pemakaianobatdetailsimpan && $this->stokobatalkestersimpan) {
            $transaction->commit();
            $sukses = 1;
            $this->redirect(array('index', 'pemakaianobat_id' => $model->pemakaianobat_id, 'sukses' => $sukses));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data detail pemakaian obat gagal disimpan !");
            if (!$this->stokobatalkestersimpan) {
              Yii::app()->user->setFlash('error', "Data detail pemakaian obat gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
            }
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemakaian obat gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
        }
      }
    }

    $linkHalaman = CustomFunction::getUrlByMenuID();

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modDetails' => $modDetails,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionAutocompleteObatReseptur()
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
      $criteria->limit = 5;
      $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
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
      } else {
        $returnVal = null;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modPemakaianObatDetail = new FAPemakaianobatdetailT();
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      if (count((array)$modStokOAs) > 0) {

        foreach ($modStokOAs as $i => $stok) {
          $modPemakaianObatDetail->satuankecil_id = $stok->satuankecil_id;
          $modPemakaianObatDetail->obatalkes_id = $stok->obatalkes_id;
          $modPemakaianObatDetail->stokobatalkes_id = $stok->stokobatalkes_id;
          $modPemakaianObatDetail->qty_satuanpakai = $stok->qtystok_terpakai;
          $modPemakaianObatDetail->harga_satuanpakai = $stok->getHargaJualSatuan();
          $modPemakaianObatDetail->harganetto_satuanpakai = $stok->HPP;
          $modPemakaianObatDetail->jmlstok = $stok->qtystok;
          $modPemakaianObatDetail->subtotal = $modPemakaianObatDetail->qty_satuanpakai * $modPemakaianObatDetail->harga_satuanpakai;
          $form .= $this->renderPartial($this->path_view . '_rowDetail', array('modPemakaianObatDetail' => $modPemakaianObatDetail), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'Data Pemakaian Obat';
    $model = FAPemakaianobatT::model()->findByPk($id);
    $modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id' => $id));
    $this->render($this->path_view . 'print', array(
      'judulLaporan' => $judulLaporan,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraPrint' => $caraPrint,
    ));
  }

  public function actionRincianDetail()
  {
    $id = $_REQUEST['pemakaianobat_id'];
    $this->layout = '//layouts/frame';
    $model = FAPemakaianobatT::model()->findByPk($id);
    $modDetails = FAPemakaianobatdetailT::model()->findAllByAttributes(array('pemakaianobat_id' => $id));
    $this->render($this->path_view . 'rincianDetail', array(
      'model' => $model,
      'modDetails' => $modDetails,
    ));
  }
}
