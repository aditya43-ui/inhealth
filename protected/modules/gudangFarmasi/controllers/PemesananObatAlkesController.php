<?php
class PemesananObatAlkesController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.pemesananObatAlkes.';
  public $pesanobatalkestersimpan = true;

  public function actionIndex($pesanobatalkes_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Obat Alkes";
    $format = new MyFormatter();
    $modPesanObatalkes = new GFPesanobatalkesT;
    $modPesanObatalkes->tglpemesanan = date('Y-m-d H:i:s');
    $modPesanObatalkes->tglmintadikirim = date('Y-m-d H:i:s');
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GUDANG_FARMASI) {
      //$modPesanObatalkes->instalasitujuan_id = Params::INSTALASI_ID_LOGISTIK;
      //$modPesanObatalkes->ruangan_id = Params::RUANGAN_ID_GUDANG_UMUM;
    } else {
      $modPesanObatalkes->instalasitujuan_id = Params::INSTALASI_ID_FARMASI;
      $modPesanObatalkes->ruangan_id = Params::RUANGAN_ID_GUDANG_FARMASI;
    }
    $modPesanObatalkes->pegawaipemesan_id = Yii::app()->user->getState('pegawai_id');
    //$modPesanObatalkes->statuspesan = Params::STATUSPESAN_BIASA;
    if (!empty($modPesanObatalkes->pegawaipemesan_id)) $modPesanObatalkes->pegawaipemesan_nama = $modPesanObatalkes->pegawaipemesan->namaLengkap;
    $modDetails = array();
    $instalasiTujuans = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($modPesanObatalkes->instalasitujuan_id), 'ruangan_id', 'ruangan_nama');

    if (!empty($pesanobatalkes_id)) {
      $modPesanObatalkes = GFPesanobatalkesT::model()->findByPk($pesanobatalkes_id);
      $modPesanObatalkes->pegawaimengetahui_nama = !empty($modPesanObatalkes->pegawaimengetahui->NamaLengkap) ? $modPesanObatalkes->pegawaimengetahui->NamaLengkap : "";
      $modPesanObatalkes->pegawaipemesan_nama = !empty($modPesanObatalkes->pegawaipemesan->NamaLengkap) ? $modPesanObatalkes->pegawaipemesan->NamaLengkap : "";
      $modDetails = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id' => $modPesanObatalkes->pesanobatalkes_id));
    }

    if (isset($_POST['GFPesanobatalkesT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPesanObatalkes->attributes = $_POST['GFPesanobatalkesT'];
        $modPesanObatalkes->nopemesanan = MyGenerator::noPemesanan(Yii::app()->user->getState('instalasi_id'));
        $modPesanObatalkes->tglpemesanan = $format->formatDateTimeForDb($_POST['GFPesanobatalkesT']['tglpemesanan']);
        $modPesanObatalkes->tglmintadikirim = $format->formatDateTimeForDb($_POST['GFPesanobatalkesT']['tglmintadikirim']);
        $modPesanObatalkes->ruanganpemesan_id = Yii::app()->user->getState('ruangan_id');
        $modPesanObatalkes->create_time = date('Y-m-d H:i:s');
        $modPesanObatalkes->update_time = date('Y-m-d H:i:s');
        $modPesanObatalkes->create_loginpemakai_id = Yii::app()->user->id;
        $modPesanObatalkes->update_loginpemakai_id = Yii::app()->user->id;
        $modPesanObatalkes->create_ruangan = Yii::app()->user->ruangan_id;
        $modPesanObatalkes->statuspengiriman = Params::STATUS_PENGIRIMANOA_PENDING;

        if ($modPesanObatalkes->save()) {
          if (isset($_POST['GFPesanoadetailT'])) {
            if (count((array)$_POST['GFPesanoadetailT']) > 0) {
              foreach ($_POST['GFPesanoadetailT'] as $i => $postOa) {
                $modDetails[$i] = $this->simpanPesanObatalkes($modPesanObatalkes, $postOa);
              }
            }
          } else {
            $this->pesanobatalkestersimpan = false;
          }
        }
        $this->simpanNotifPesanObat($modPesanObatalkes);
        // die;
        if ($this->pesanobatalkestersimpan) {
          $transaction->commit();
          $modPesanObatalkes->isNewRecord = FALSE;
          $this->redirect(array('index', 'pesanobatalkes_id' => $modPesanObatalkes->pesanobatalkes_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemesanan Obat Alkes gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pemesanan Obat Alkes gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modPesanObatalkes' => $modPesanObatalkes,
      'modDetails' => $modDetails,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }


  public function simpanNotifPesanObat($modPesanObatalkes)
  {
    // var_dump($modPesanObatalkes->attributes); die;

    $ruangan = RuanganM::model()->findByPk($modPesanObatalkes->ruangan_id);
    $asal = RuanganM::model()->findByPk($modPesanObatalkes->ruanganpemesan_id);
    $judul = 'Pemesanan Obat Alkes';

    $isi = "Pemesan : " . $asal->ruangan_nama . "<br/>No. Pemesanan : ";
    $isi .= CHtml::link($modPesanObatalkes->nopemesanan, $this->createUrl('print', array(
      'pesanobatalkes_id' => $modPesanObatalkes->pesanobatalkes_id,
    )), array('target' => '_blank'));

    // var_dump($mr->attributes); die;

    // var_dump($isi); die;
    //var_dump($ruangan->attributes); die;
    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
    ));

    //var_dump($ok); die;
  }

  /**
   * simpan GFPesanoadetailT
   * @param type $modPesanObatalkes
   * @param type $post
   * @return \GFPesanoadetailT
   */
  public function simpanPesanObatalkes($modPesanObatalkes, $post)
  {
    $format = new MyFormatter();
    $modDetailPesanOA = new GFPesanoadetailT;
    $modDetailPesanOA->attributes = $post;
    $modDetailPesanOA->pesanobatalkes_id = $modPesanObatalkes->pesanobatalkes_id;

    if ($modDetailPesanOA->validate()) {
      $modDetailPesanOA->save();
    } else {
      $this->pesanobatalkestersimpan &= false;
    }
    return $modDetailPesanOA;
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
        $instalasi_id = $_POST["$model_nama"]['instalasitujuan_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionSetFormDetailPemesanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $tglkadaluarsa = $_POST['tglkadaluarsa'];
      $stok = $_POST['stok'];
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      if ($modObatAlkes) {
        $modDetailPesanOA = new GFPesanoadetailT;
        $modDetailPesanOA->obatalkes_id = $modObatAlkes->obatalkes_id;
        $modDetailPesanOA->jmlpesan = $jumlah;
        $modDetailPesanOA->tglkadaluarsa = $tglkadaluarsa;
        $modDetailPesanOA->satuankecil_id = $modObatAlkes->satuankecil_id;
        $modDetailPesanOA->sumberdana_id = $modObatAlkes->sumberdana_id;
        $modDetailPesanOA->stok = $stok;
        $form = $this->renderPartial($this->path_view . '_rowDetailPemesanan', array('modDetail' => $modDetailPesanOA), true);
      } else {
        $pesan = "Obat alkes tidak ada!";
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan, 'stok' => $stok, 'jumlah' => $jumlah));
      Yii::app()->end();
    }
  }

  /**
   * untuk print data pemesanan obat alkes
   */
  public function actionPrint($pesanobatalkes_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $model = GFPesanobatalkesT::model()->findByPk($pesanobatalkes_id);
    $modDetails = GFPesanoadetailT::model()->findAllByAttributes(array('pesanobatalkes_id' => $pesanobatalkes_id));

    $judul_print = 'Permintaan Unit';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraprint' => $caraprint
    ));
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->join = "join ruanganpegawai_m p on p.pegawai_id = t.pegawai_id";
      $criteria->addCondition("p.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = GFPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk form tambah obat alkes
   * di copy dari laboratorium/pemakaianBmhpController
   */
  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      //  $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
      //            JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
      //             LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
      //              ";
      $criteria->join = " JOIN stokobatalkes_t stok ON stok.obatalkes_id = t.obatalkes_id ";
      $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.obatalkes_farmasi = TRUE');
      $criteria->addCondition('t.obatalkes_aktif = true');
      $criteria->addCondition("stok.ruangan_id = :ruangan_id");
      $criteria->params[':ruangan_id'] = $_GET['ruangan_id'];
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;

      //$models = ObatalkesM::model()->findAll($criteria);
      $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
      $format = new MyFormatter();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();

        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        } //$_GET['ruangan_id']
        // $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
        $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, $_GET['ruangan_id']);
        $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Harga " . number_format($model->hargajual, 0, ',', '.') . " - Jumlah Stok " . $qty_stok;
        $returnVal[$i]['value'] = $model->obatalkes_nama;
        $returnVal[$i]['qty_stok'] = $qty_stok;
        $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
