<?php

class MutasibrgTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'gudangUmum.views.mutasibrgT.';
  public $succesSave = true;

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id)
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Barang";
    $model = new GUMutasibrgT;
    $modDetails = null;
    //$modPesan = null;
    $modPesan = new GUPesanbarangT;
    if (isset($id)) {
      $modPesan = PesanbarangT::model()->findByPk($id);
      $model->pesanbarang_id = $modPesan->pesanbarang_id;
      $model->ruangantujuan_id = $modPesan->ruanganpemesan_id;
      $model->instalasi_id = $model->ruangantujuan->instalasi_id;
      if (!empty($modPesan)) {
        $modDetailPesan = PesanbarangdetailT::model()->findAllByAttributes(array(
          'pesanbarang_id' => $id,
        ));
        foreach ($modDetailPesan as $i => $row) {
          if ($row->qty_pesan == $row->qty_mutasi) continue;
          $row->qty_pesan -= $row->qty_mutasi;

          $modDetails[$i] = new MutasibrgdetailT();
          $modDetails[$i]->attributes = $row->attributes;
          $modDetails[$i]->pesanbarangdetail_id = $row->pesanbarangdetail_id;
          $modDetails[$i]->barang_id = $row->barang_id;
          $modDetails[$i]->satuanbrg = $row->satuanbarang;
          $modDetails[$i]->qty_pesan = $row->qty_pesan;
          $modDetails[$i]->qty_stok = InventarisasiruanganT::tampilStok($modDetails[$i]->barang_id);
          $modDetails[$i]->qty_mutasi = $row->qty_pesan;
          if (Yii::app()->user->getState('krngistokumum') == true) {
            if (InventarisasiruanganT::validasiStok($modDetails[$i]->qty_mutasi, $modDetails[$i]->barang_id) == false) {
              $modDetails[$i]->qty_mutasi = 0;
            }
          }
        }
      }
    }
    $model->tglmutasibrg = date('Y-m-d H:i:s');
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->nomutasibrg = MyGenerator::noMutasiBarang();
    $model->totalhargamutasi = 0;
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->pegpengirim_id = $modLogin->pegawai_id;
    if (!empty($model->pegpengirim_id)) $model->pegpengirim_nama = $modLogin->pegawai->nama_pegawai;
    if (isset($_GET['idMutasi'])) {
      $idMutasi = $_GET['idMutasi'];
      $modelMutasi = GUMutasibrgT::model()->findByPk($idMutasi);
      if (!empty($modelMutasi)) {
        $model = $modelMutasi;
        $model->pegpengirim_nama = (isset($model->pegawaipengirim) ? $model->pegawaipengirim->nama_pegawai : "");
        $model->pegmengetahui_nama = (isset($model->pegawaimengetahui) ? $model->pegawaimengetahui->nama_pegawai : "");
        $model->instalasi_id = $model->ruangantujuan->instalasi_id;
        $modDetails = MutasibrgdetailT::model()->findAll('mutasibrg_id = ' . $model->mutasibrg_id);
      }
    }
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GUMutasibrgT'])) {
      $model->attributes = $_POST['GUMutasibrgT'];
      if (count((array)$_POST['MutasibrgdetailT']) > 0) {
        $modDetails = $this->validateTable($_POST['MutasibrgdetailT'], $model);
        if ($model->validate()) {
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $total = 0;
            $success = true;
            if ($model->save()) {
              if (!empty($_POST['GUMutasibrgT']['pesanbarang_id'])) {
                $modPesan->pesanbarang_id = $_POST['GUMutasibrgT']['pesanbarang_id'];
              }

              if (!empty($modPesan->pesanbarang_id)) {
                PesanbarangT::model()->updateByPk($modPesan->pesanbarang_id, array('mutasibrg_id' => $model->mutasibrg_id));
              }
              $modDetails = $this->validateTable($_POST['MutasibrgdetailT'], $model);
              foreach ($modDetails as $i => $data) {
                if ($data->qty_mutasi > 0) {
                  // $modInventaris = InventarisasiruanganT::model()->findByAttributes(array('barang_id'=>$data->barang_id), array('order'=>'tgltransaksi', 'limit'=>1));
                  // $data->inventarisasi_id = (isset($modInventaris->inventarisasi_id) ? $modInventaris->inventarisasi_id : null);
                  // $harga = (isset($modInventaris->inventarisasi_hargasatuan) ? $modInventaris->inventarisasi_hargasatuan : 0);
                  // $total += $harga*$data->qty_mutasi;

                  // var_dump($data->attributes, $data->validate(), $data->errors); die;

                  if ($data->save()) {

                    $success = $success && InventarisasiruanganT::simpanStokMutasi($model, $data);

                    /*
                                        if(isset($modInventaris->inventarisasi_id)){
                                            //InventarisasiruanganT::model()->updateByPk($modInventaris->inventarisasi_id, array('mutasibrgdetail_id'=>$data->mutasibrgdetail_id));
                                            // Update / Insert Inventarisasiruangan Ruangan tujuan
                                            //$cekInvRuangTujuan = InventarisasiruanganT::model()->findByAttributes(array('barang_id'=>$data->barang_id,'ruangan_id'=>$model->ruangantujuan_id,'inventarisasi_kode'=>$modInventaris->inventarisasi_kode));
                                            /*
                                            if(count((array)$cekInvRuangTujuan)){
                                                    $qty_in = $cekInvRuangTujuan->inventarisasi_qty_in + $data->qty_mutasi;
                                                    $qty_skrg = $cekInvRuangTujuan->inventarisasi_qty_skrg + $data->qty_mutasi;
                                                    InventarisasiruanganT::model()->updateByPk($cekInvRuangTujuan->inventarisasi_id, array(
                                                            'mutasibrgdetail_id'=>$data->mutasibrgdetail_id,
                                                            'inventarisasi_qty_in'=>$qty_in,
                                                            'inventarisasi_qty_skrg'=>$qty_skrg,
                                                            //'inventarisasi_keadaan'=>Params::INVENTA,
                                                            'update_time'=>date('Y-m-d H:i:s'),
                                                            'update_loginpemakai_id'=>Yii::app()->user->id));
                                            }else{ */
                    // $this->simpanInvRuanganTujuan($data,$model,$modInventaris);
                    //}
                    /* }
                                        if (Yii::app()->user->getState('krngistokumum') == true){
                                            if (InventarisasiruanganT::validasiStok($data->qty_mutasi, $data->barang_id) == true){
                                                InventarisasiruanganT::kurangiStok($data->qty_mutasi, $data->barang_id);
                                            }
                                            else{
                                                $success = false;
                                        }
                                         *
                                         */
                    // }
                  } else {
                    $success = false;
                  }
                }
              }
              if ($total != 0) {
                MutasibrgT::model()->updateByPk($model->mutasibrg_id, array('totalhargamutasi' => $total));
              }
            }

            // var_dump($success); die;

            $this->simpanNotifMutasiBarang($model);

            if (Yii::app()->user->getState('isjurnalotomatis') == true) {
              $modDetailMutasi = MutasibrgdetailT::model()->findAllByAttributes(array('mutasibrg_id' => $model->mutasibrg_id));


              if (count((array)$modDetailMutasi) > 0) {
                foreach ($modDetailMutasi as $detailMutasi) {
                  $barang = BarangM::model()->findByPk($detailMutasi->barang_id);

                  if (isset($barang)) {
                    $modJnsBarangRek = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $barang->jenisbarang_id, 'ismutasi' => true));
                    if (count((array)$modJnsBarangRek) > 0) {
                      $modJurnalRekening = $this->saveJurnalRekening($model, $detailMutasi);

                      foreach ($modJnsBarangRek as $jnsbrgRek) {
                        $this->saveJurnalDetail($modJurnalRekening, $detailMutasi, $jnsbrgRek);
                      }
                      $success = $this->succesSave;
                    }
                  }
                }
              }
            }
            if ($success == true) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', ' Data ' . $model->nomutasibrg . ' berhasil disimpan.');
              $this->redirect(array('index', 'idMutasi' => $model->mutasibrg_id, 'sukses' => 1));
            } else {
              // echo "Kick"; die;
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
          } catch (Exception $ex) {
            // var_dump($ex); die;
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
          }
        }
      } else {
        $model->validate();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(408);

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'modDetails' => $modDetails, 'modPesan' => $modPesan, 'linkHalaman' => $linkHalaman
    ));
  }

  public function simpanNotifMutasiBarang($model)
  {

    $asal = RuanganM::model()->findByPk($model->create_ruangan);
    $ruangan = RuanganM::model()->findByPk($model->ruangantujuan_id);
    $judul = 'Mutasi Barang';

    $isi = "Mutasi Asal : " . $asal->ruangan_nama . "<br/>No. Mutasi : ";
    $isi .= CHtml::link($model->nomutasibrg, Yii::app()->createUrl('/gudangUmum/MutasibrgT/detailMutasiBarang', array(
      'id' => $model->mutasibrg_id,
    )), array('target' => '_blank'));

    //var_dump($isi); die;
    //var_dump($ruangan->attributes); die;

    $link = "";
    if (!empty($ruangan->modul_id)) {
      $modul = ModulK::model()->findByPk($ruangan->modul_id);
      $link = Yii::app()->createUrl($modul->url_modul . "/mutasibrgT" . $modul->modul_key . "/informasi", array(
        'GUMutasibrgT[tgl_awal]' => date('Y-m-d', strtotime($model->tglmutasibrg)),
        'GUMutasibrgT[tgl_akhir]' => date('Y-m-d', strtotime($model->tglmutasibrg)),
        'GUMutasibrgT[nomutasibrg]' => $model->nomutasibrg,
        'GUMutasibrgT[masukkeluar]' => '',
        'GUMutasibrgT[create_ruangan]' => '',
        'GUMutasibrgT[ruangantujuan_id]' => '',
        'GUMutasibrgT[pegpengirim_id]' => '',
      ));
    }



    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id, 'link_proses' => $link),
      // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
      // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
    ));

    //var_dump($ok); die;
  }

  public function simpanNotifPenyetujuanMutasiBarang($model)
  {

    $asal = RuanganM::model()->findByPk($model->create_ruangan);
    $ruangan = RuanganM::model()->findByPk($model->ruangantujuan_id);
    $judul = 'Penyetujuan Mutasi Barang';
    $peg = PegawaiM::model()->findByPk($model->pegmenyetujui_id);


    $isi = "Ruangan Terima : " . $asal->ruangan_nama . "<br/>No. Mutasi : ";
    $isi .= CHtml::link($model->nomutasibrg, Yii::app()->createUrl('/gudangUmum/MutasibrgT/detailMutasiBarang', array(
      'id' => $model->mutasibrg_id,
    )), array('target' => '_blank')) . "<br/>";
    $isi .= "Disetujui oleh : " . $peg->nama_pegawai;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
      // array('instalasi_id'=>$ruangan->instalasi_id, 'ruangan_id'=>$ruangan->ruangan_id, 'modul_id'=>$ruangan->modul_id),
      // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
      // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
    ));
  }


  protected function validateTable($datas, $model)
  {
    $valid = true;
    foreach ($datas as $i => $data) {
      $modDetails[$i] = new MutasibrgdetailT();
      $modDetails[$i]->attributes = $data;
      $modDetails[$i]->mutasibrg_id = $model->mutasibrg_id;

      // var_dump($modDetails[$i]->attributes);

      $valid = $modDetails[$i]->validate() && $valid;
    }

    return $modDetails;
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
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (empty($models)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          if (count((array)$models) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * mengecek stok barang
   */
  public function actionGetStokBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idBarang = $_POST['idBarang'];
      $jumlah = $_POST['qty'];
      if (Yii::app()->user->getState('krngistokumum') == true) {
        if (InventarisasiruanganT::validasiStok($jumlah, $idBarang) == false) {
          echo json_encode('kosong');
          Yii::app()->end();
        }
      }
      echo json_encode($jumlah);
      Yii::app()->end();
    }
  }

  /**
   * menampilkan mutasi barang + cek stok
   */
  public function actionGetMutasiBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idBarang = $_POST['idBarang'];
      $jumlah = $_POST['jumlah'];
      $pesan = 0;
      $satuan = $_POST['satuan'];
      if (Yii::app()->user->getState('krngistokumum') == true) {
        //if (InventarisasiruanganT::validasiStok($jumlah, $idBarang) == false){
        //  echo json_encode('kosong');
        //Yii::app()->end();
        //}
      }
      $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($idBarang);
      $modDetail = new MutasibrgdetailT();
      $modDetail->barang_id = $idBarang;
      $modDetail->satuanbrg = $satuan;
      $modDetail->qty_mutasi = $jumlah;
      $modDetail->qty_pesan = $pesan;
      $modDetail->qty_stok = InventarisasiruanganT::tampilStok($idBarang);

      $tr = $this->renderPartial($this->path_view . '_detailMutasiBarang', array('modBarang' => $modBarang, 'modDetail' => $modDetail), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GUMutasibrgT'])) {
      $model->attributes = $_POST['GUMutasibrgT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->mutasibrg_id));
      }
    }

    $this->render($this->path_view . 'update', array(
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
      $this->loadModel($id)->delete();

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
    $model = new GUMutasibrgT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GUMutasibrgT']))
      $model->attributes = $_GET['GUMutasibrgT'];

    $this->render($this->path_view . 'admin', array(
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
    $model = GUMutasibrgT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gumutasibrg-t-form') {
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
    if (!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) {
      throw new CHttpException(401, Yii::t('mds', 'You are prohibited to access this page. Contact Super Administrator'));
    }
  }

  public function actionInformasi($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Barang";
    $model = new GUMutasibrgT('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //$model->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['GUMutasibrgT'])) {
      $model->attributes = $_GET['GUMutasibrgT'];
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
      if ($model->ruangantujuan_id == "") {
        //$model->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
      }
    }


    // if (Yii::app()->request->isAjaxRequest) {
    //    echo $this->renderPartial($this->path_view.'_table', array('model'=>$model,'format'=>$format),true);
    //}else{
    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(403);

    $this->render($this->path_view . 'informasi', array(
      'model' => $model, 'format' => $format, 'linkHalaman' => $linkHalaman
    ));
    //}

  }

  public function actionInformasiGudang()
  {
    $model = new GUMutasibrgT('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d H:i:s');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    if (isset($_GET['GUMutasibrgT'])) {
      $model->attributes = $_GET['GUMutasibrgT'];
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
    }

    $this->render($this->path_view . 'informasiGudang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionDetailMutasiBarang($id)
  {
    $this->layout = '//layouts/iframe';
    $modMutasi = MutasibrgT::model()->findByPk($id);
    if (!empty($modMutasi)) {
      $judulLaporan = 'Data Mutasi Barang';
      $modDetailMutasi = MutasibrgdetailT::model()->findAllByAttributes(array('mutasibrg_id' => $modMutasi->mutasibrg_id));
      $this->render($this->path_view . 'detailInformasi', array(
        'modMutasi' => $modMutasi,
        'modDetailMutasi' => $modDetailMutasi,
        'judulLaporan' => $judulLaporan,
      ));
    }
  }

  public function actionPrintMutasi($id)
  {
    $this->layout = '//layouts/printWindows';
    $judulLaporan = 'Data Mutasi Barang';
    $caraPrint = $_REQUEST['caraPrint'];
    $modMutasi = MutasibrgT::model()->findByPk($id);
    if (!empty($modMutasi)) {
      $modDetailMutasi = MutasibrgdetailT::model()->findAllByAttributes(array('mutasibrg_id' => $modMutasi->mutasibrg_id));
      $this->render($this->path_view . 'detailInformasi', array(
        'judulLaporan' => $judulLaporan,
        'modMutasi' => $modMutasi,
        'modDetailMutasi' => $modDetailMutasi,
        'caraPrint' => $caraPrint,
      ));
    }
  }

  public function actionBatalMutasiBarang($id)
  {
    $this->layout = '//layouts/iframe';
    $modBatals = array();
    $model = new BatalmutasibrgT();
    $model->tglbatalmutasibrg = date('Y-m-d H:i:s');
    $status = '';
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
              $success = $success && InventarisasiruanganT::batalStokMutasi($data);

              //                           InventarisasiruanganT::kembalikanStok($data->qty_batal, $data->barang_id);
              /*
                            MutasibrgdetailT::model()->updateByPk($_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'], array('batalmutasibrg_id' => $data->batalmutasibrg_id));
                            InventarisasiruanganT::model()->updateAll(array('batalmutasibrg_id' => $data->batalmutasibrg_id, 'inventarisasiruangan_aktif' => false), 'mutasibrgdetail_id = ' . $_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'] . ' and barang_id = ' . $data->barang_id);

                            $modInventarisasi = InventarisasiruanganT::model()->findAllByAttributes(array('mutasibrgdetail_id' => $_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'], 'barang_id' => $data->barang_id));
                            foreach ($modInventarisasi as $key => $value) {
                                if(!empty($value->inventarisasiruanganasal_id)){
                                    $modStokAsal = InventarisasiruanganT::model()->findByPk($value->inventarisasiruanganasal_id);
                                    $modStokAsal->inventarisasiruangan_aktif = true;
                                    $modStokAsal->update();
                                }
                            }
                             *
                             */
            } else {
              $success &= false;
            }
          }
        }

        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $status = 'sukses';
          $this->redirect(array('batalMutasiBarang', 'id' => $id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $modMutasi = MutasibrgT::model()->find('mutasibrg_id  = ' . $id);
    $modDetailMutasi = BatalmutasibrgT::model()->findAll('mutasibrg_id = ' . $id);
    if ((!empty($modMutasi)) && (count((array)$modDetailMutasi) < 1)) {
      $modDetailMutasi = MutasibrgdetailT::model()->findAllByAttributes(array('mutasibrg_id' => $modMutasi->mutasibrg_id));
      $modMutasi->ruangan_nama = $modMutasi->ruangantujuan->ruangan_nama;
      $model->mutasibrg_id = $modMutasi->mutasibrg_id;
      $this->render($this->path_view . 'batalMutasi', array(
        'modBatals' => $modBatals,
        'model' => $model,
        'modMutasi' => $modMutasi,
        'modDetailMutasi' => $modDetailMutasi,
        'status' => $status
      ));
    } else {
      $this->render($this->path_view . 'batalMutasi', array(
        'modBatals' => $modBatals,
        'model' => $model,
        'modMutasi' => $modMutasi,
        'modDetailMutasi' => $modDetailMutasi,
        'status' => $status
      ));
    }
  }

  protected function validateTableBatal($datas)
  {
    $valid = true;
    foreach ($datas['barang_id'] as $i => $data) {
      $modDetails[$i] = new BatalmutasibrgT();
      $modDetails[$i]->attributes = $data;
      $modDetails[$i]->alasan_pembatalan = $datas['alasan_pembatalan'];
      $modDetails[$i]->mutasibrg_id = $datas['mutasibrg_id'];
      $modDetails[$i]->tglbatalmutasibrg = $datas['tglbatalmutasibrg'];
      $valid = $modDetails[$i]->validate() && $valid;
    }
    return $modDetails;
  }

  /**
   * simpan GUInvbarangdetT
   * @param type $model
   * @param type $detail
   * @return \GUInvbarangdetT
   */
  public function simpanInvRuanganTujuan($data, $model, $modInventaris)
  {
    $format = new MyFormatter();
    $modInvRuanganTujuan = new GUInventarisasiruanganT;
    $modInvRuanganTujuan->inventarisasi_kode = MyGenerator::kodeTerimaMutasi();
    $modInvRuanganTujuan->mutasibrgdetail_id = $data->mutasibrgdetail_id;
    $modInvRuanganTujuan->barang_id = $data->barang_id;
    $modInvRuanganTujuan->inventarisasi_qty_in = $data->qty_mutasi;
    $modInvRuanganTujuan->inventarisasi_keadaan = isset($modInventaris->inventarisasi_keadaan) ? $modInventaris->inventarisasi_keadaan : "";
    $modInvRuanganTujuan->inventarisasi_hargasatuan = $modInventaris->inventarisasi_hargasatuan;
    $modInvRuanganTujuan->ruangan_id = $model->ruangantujuan_id;
    $modInvRuanganTujuan->tgltransaksi = date('Y-m-d H:i:s');
    $modInvRuanganTujuan->inventarisasi_hargabeli = 0;
    $modInvRuanganTujuan->inventarisasi_qty_out = 0;
    $modInvRuanganTujuan->inventarisasi_qty_skrg = $data->qty_mutasi;
    $modInvRuanganTujuan->create_time = date('Y-m-d H:i:s');
    $modInvRuanganTujuan->create_loginpemakai_id = Yii::app()->user->id;
    $modInvRuanganTujuan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    // var_dump($modInventaris->attributes, $modInvRuanganTujuan->attributes, $modInvRuanganTujuan->validate(), $modInvRuanganTujuan->errors); die;
    if ($modInvRuanganTujuan->validate()) {
      $modInvRuanganTujuan->save();
    }
    return $modInvRuanganTujuan;
  }

  public function actionGetPesanBarangDariMutasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPesanbarang = $_POST['idPesanbarang'];
      $model = new GUMutasibrgT;
      $modMutasiDetail = new MutasibrgdetailT;
      //$modDetailPesanObatAlkes = PesanoadetailT::model()->with('obatalkes','sumberdana','satuankecil')->findAll('pesanobatalkes_id='.$idPesanObatAlkes.'');
      $modDetailPesanBarang = GUPesanbarangdetailT::model()->findAllByAttributes(array('pesanbarang_id' => $idPesanbarang));
      $modelPesanBarang = GUPesanbarangT::model()->findByPk($idPesanbarang);
      $nama_pegawai = $modelPesanBarang->pegawaipemesan->namaLengkap;
      $ruangan_nama = $modelPesanBarang->ruanganpemesan->ruangan_nama;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $format = new MyFormatter;
      $stok = null;
      $totalHargaSub = 0;
      $totalHargaNetto = 0;
      //$totalharganetto = 0;
      //$totalhargajual = 0;
      $tr = "";
      $no = 1;
      $data = array();

      $modDetailPesanBarang = GUPesanbarangdetailT::model()->findAllByAttributes(array('pesanbarang_id' => $idPesanbarang));
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $totalharganetto = 0;
      $totalhargajual = 0;
      if (count((array)$modDetailPesanBarang) > 0) {
        $ii = 0;
        foreach ($modDetailPesanBarang as $a => $detail) {
          $brg = BarangM::model()->findByPk($detail->barang_id);

          //$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail->obatalkes_id, $detail->jmlpesan, $ruangan_id);
          //if(count((array)$modStokOAs) > 0){
          //foreach($modStokOAs AS $i => $stok){
          $modDetails[$ii] = new MutasibrgdetailT();
          // $modDetails[$ii]->stokobatalkes_id = null; //$stok->stokobatalkes_id;
          $modDetails[$ii]->barang_id = $detail->barang_id;
          $modDetails[$ii]->pesanbarangdetail_id = $detail->pesanbarangdetail_id;
          $modDetails[$ii]->barang_type = $brg->barang_type;
          $modDetails[$ii]->barang_kode = $brg->barang_kode;
          $modDetails[$ii]->barang_nama = $brg->barang_nama;
          $modDetails[$ii]->barang_merk = $brg->barang_merk;
          $modDetails[$ii]->barang_ukuran = $brg->barang_ukuran;
          $modDetails[$ii]->barang_ekonomis_thn = $brg->barang_ekonomis_thn;
          $modDetails[$ii]->qty_stok = InventarisasiruanganT::tampilStok($detail->barang_id);
          $modDetails[$ii]->qty_pesan = $detail->qty_pesan;
          $modDetails[$ii]->qty_mutasi = $detail->qty_pesan;
          $modDetails[$ii]->satuanbrg = $detail->satuanbarang;
          if (Yii::app()->user->getState('krngistokumum') == true) {
            if (InventarisasiruanganT::validasiStok($modDetails[$ii]->qty_mutasi, $modDetails[$ii]->barang_id) == false) {
              $modDetails[$ii]->qty_mutasi = 0;
            }
          }
          $modDetails[$ii]->qty_mutasi = $detail->qty_pesan;
          //$modDetails[$ii]->satuanbrg = $brg->satuanbrg;

          // }
          // }else{
          //     $pesan = "Stok obat ".$detail->obatalkes->obatalkes_nama." tidak mencukupi!";
          // }
        }
      }


      foreach ($modDetails as $tampilDetail) {
        $tr .= $this->renderPartial($this->path_view . '_detailMutasiBarang', array('modDetail' => $tampilDetail, 'modBarang' => $tampilDetail, 'pesan' => "", 'model' => $model), true);
      };
      $modPesanBarang =  PesanbarangT::model()->findByPk($idPesanbarang);
      $data['tr'] = $tr;
      $data['ruangan_id'] = $modPesanBarang->ruanganpemesan_id;
      $data['ruangan_nama'] = $ruangan_nama;
      $data['nama_pegawai'] = $nama_pegawai;
      //if (!empty($stok)) $data['stok'] = $stok;


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAutocompleteNoPemesanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopemesanan)', strtolower($_GET['term']), true);
      $criteria->addCondition('mutasibrg_id is null');
      $criteria->compare('ruangantujuan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'nopemesanan';
      $criteria->limit = 5;
      $models = PesanbarangT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['tglpesanbarang'] = MyFormatter::formatDateTimeForUser($returnVal[$i]['tglpesanbarang']);
        $returnVal[$i]['label'] = $model->nopemesanan;
        $returnVal[$i]['value'] = $model->nopemesanan;
        $returnVal[$i]['pegpemesan_nama'] = $model->pegawaipemesan->namaLengkap;
        $returnVal[$i]['ruanganpemesan_nama'] = $model->ruanganpemesan->ruangan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionDetailPesanBarang($id)
  {
    $this->layout = '//layouts/iframe';
    $modPesan = PesanbarangT::model()->findByPk($id);
    $modDetailPesan = PesanbarangdetailT::model()->findAllByAttributes(array('pesanbarang_id' => $modPesan->pesanbarang_id));
    $judulLaporan = 'Data Pemesanan Barang';
    $this->render('gudangUmum.views.pesanbarangT.detailInformasi', array(
      'modPesan' => $modPesan,
      'modDetailPesan' => $modDetailPesan,
      'judulLaporan' => $judulLaporan,
    ));
  }
  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'Data Mutasi Barang';
    // var_dump($id);die;
    $modPesan = MutasibrgT::model()->findByPk($id);


    $modDetailPesan = PesanbarangdetailT::model()->findAllByAttributes(array('pesanbarang_id'=>$modPesan->pesanbarang_id));

    $this->render('gudangUmum.views.pesanbarangT.detailInformasi', array(
      'judulLaporan' => $judulLaporan,
      'modPesan' => $modPesan,
      'modDetailPesan' => $modDetailPesan,
      'caraPrint' => $caraPrint,
    ));
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   *
   * Ajax penyetujuan mutasi.
   */
  public function actionPenyetujuanMutasi()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];
    $ok = 1;
    $msg = "Mutasi barang telah disetujui";

    // $trans = Yii::app()->db->beginTransaction();

    if (!GUMutasibrgT::model()->updateByPk($id, array(
      'pegmenyetujui_id' => Yii::app()->user->getState('pegawai_id')
    ))) {
      $ok = 0;
      $msg = "Mutasi gagal disetujui";
    }

    // kirim notif
    $model = GUMutasibrgT::model()->findByPk($id);
    $this->simpanNotifPenyetujuanMutasiBarang($model);

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   *
   * Ambil data Pegawai dari autocomplete.
   *
   * @param type $term data dari Text Input
   */
  public function actionGetPegawaiPengirim($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $prov = PegawaiM::model()->search();
    $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
    $prov->criteria->addCondition('pegawai_aktif = true');
    $prov->sort->defaultOrder = 'nama_pegawai';
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }


  public function actionPrintInformasi($caraPrint)
  {
    $model = new GUMutasibrgT('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //$model->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['GUMutasibrgT'])) {
      $model->attributes = $_GET['GUMutasibrgT'];
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
      if ($model->ruangantujuan_id == "") {
        //$model->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
      }
    }

    $this->printFunction($model, $caraPrint, "Informasi Mutasi Barang", $this->path_view . "printInformasi");
  }


  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    } else if ($caraPrint == "CSV") {
      CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
    }
  }

  protected function saveJurnalRekening($model, $dtDetail)
  {

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglmutasibrg);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->nomutasibrg;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglmutasibrg);
    $modJurnalRekening->nobku = "";
    $ruangan_nama = "";
    $modRuangan = RuanganM::model()->findByPk($model->ruangantujuan_id);

    if (isset($modRuangan)) {
      $ruangan_nama = $modRuangan->ruangan_nama;
    }

    $modJurnalRekening->urianjurnal = 'Mutasi Barang ' . $dtDetail->barang->barang_nama . " Ruangan " . $ruangan_nama . " - " . $model->nomutasibrg;

    $periodeID = $modJurnalRekening->currentPeriod;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->create_ruangan;
    $modJurnalRekening->mutasibrg_id = $model->mutasibrg_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modelRek)
  {
    $valid = true;
    $modJurnalPosting = null;
    $modBarang = BarangM::model()->findByPk($postRekenings->barang_id);

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);

    $modelJurnalDetail = new JurnaldetailT();

    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

    $totalHasilQty = ($modBarang->barang_hpp * $postRekenings->qty_mutasi);

    if ($modelRek->debitkredit == 'K') {
      $modelJurnalDetail->nourut = 2;
      $modelJurnalDetail->saldokredit = $totalHasilQty;
      $modelJurnalDetail->saldodebit = 0;
    } else if ($modelRek->debitkredit == 'D') {
      $modelJurnalDetail->nourut = 1;
      $modelJurnalDetail->saldodebit = $totalHasilQty;
      $modelJurnalDetail->saldokredit = 0;
    }

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();

      //                if(Yii::app()->user->getState('ispostingotomatis'))
      //                {
      //                    $modJurnalPosting = new JurnalpostingT;
      //                    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->keterangan = "Posting automatis";
      //                    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      //                    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //                    $modJurnalPosting->jurnaldetail_id = $modelJurnalDetail->jurnaldetail_id;
      //                    $modJurnalPosting->periodeposting_id = $modelJurnalDetail->jurnalposting_id;
      //
      //                    $periode = PeriodepostingM::model()->findByAttributes(array('rekperiode_id'=>$modJurnalRekening->rekperiod_id));
      //                    if (!empty($periode)) {
      //                        $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;
      //                    }
      //
      //                    if($modJurnalPosting->validate()){
      //                        if($modJurnalPosting->save()){
      //                            JurnaldetailT::model()->updateByPk($modelJurnalDetail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
      //                        }
      //                    }
      //                }
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }
}
