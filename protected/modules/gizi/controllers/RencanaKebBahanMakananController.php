
<?php

class RencanaKebBahanMakananController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.rencanaKebBahanMakanan.';
  public $rencanakebutuhantersimpan = true;

  public function actionIndex($renkebbahanmakanan_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Kebutuhan Bahan Makanan";
    $format = new MyFormatter();
    $modRencanaKebBarang = new RenkebbahanmakananT;
    $modRencanaKebBarang->renkebbahanmakanan_tgl = date('Y-m-d H:i:s');
    $modRencanaKebBarang->renkebbahanmakanan_no = '-- Otomatis --';
    $mengetahui = Yii::app()->user->getState('pegawai_id');
    $konfig = ApprovalotorisasiM::model()->find();
    if (!empty($mengetahui)) {
      $data = PegawaiM::model()->findByPk($mengetahui);
      $dataMenyetujui = PegawaiM::model()->findByPk($konfig->kepalagizi_id);
      $modRencanaKebBarang->pegmengetahui_id = $data->pegawai_id;
      $modRencanaKebBarang->pegmengetahui_nama = $data->namaLengkap;

      if (!empty($dataMenyetujui)) {
        $modRencanaKebBarang->pegmenyetujui_id = $dataMenyetujui->pegawai_id;
        $modRencanaKebBarang->pegmenyetujui_nama = $dataMenyetujui->namaLengkap;
      }
    }


    $modDetails = array();
    if (!empty($renkebbahanmakanan_id)) {
      $modRencanaKebBarang = RenkebbahanmakananT::model()->findByPk($renkebbahanmakanan_id);
      $modRencanaKebBarang->pegmengetahui_nama = !empty($modRencanaKebBarang->pegmengetahui_id) ? $modRencanaKebBarang->pegawaimengetahui->namaLengkap : "";
      $modRencanaKebBarang->pegmenyetujui_nama = !empty($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegawaimenyetujui->namaLengkap : "";
      $modDetails = RenkebbahanmakanandetT::model()->findAllByAttributes(array('renkebbahanmakanan_id' => $modRencanaKebBarang->renkebbahanmakanan_id));
    }

    if (isset($_GET['ubah'])) {
      if (isset($konfig)) {
        $data = PegawaiM::model()->findByPk($konfig->kepalagizi_id);
        $modRencanaKebBarang->pegmenyetujui_id = $data->pegawai_id;
        $modRencanaKebBarang->pegmenyetujui_nama = $data->namaLengkap;
      }
    }

    if (isset($_POST['RenkebbahanmakananT'])) {
     
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRencanaKebBarang->attributes = $_POST['RenkebbahanmakananT'];

        $pegawai = Yii::app()->user->getState('pegawai_id');
        if (empty($pegawai))
          $pegawai = '0';
        $modRencanaKebBarang->renkebbahanmakanan_no = MyGenerator::noPerencanaanKebutuhanBahanMakanan();
        $modRencanaKebBarang->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modRencanaKebBarang->pegawai_id = $pegawai;
        $modRencanaKebBarang->renkebbahanmakanan_tgl = $format->formatDateTimeForDb($_POST['RenkebbahanmakananT']['renkebbahanmakanan_tgl']);
        $modRencanaKebBarang->ro_bahanmakanan_bulan = $_POST['RenkebbahanmakananT']['ro_bahanmakanan_bulan'];

        if (isset($_GET['ubah'])) {
          $modRencanaKebBarang->update_time = date('Y-m-d H:i:s');
          $modRencanaKebBarang->update_loginpemekai_id = Yii::app()->user->id;
        } else {
          $modRencanaKebBarang->create_time = date('Y-m-d H:i:s');
          $modRencanaKebBarang->create_loginpemekai_id = Yii::app()->user->id;
        }
        $modRencanaKebBarang->create_ruangan = Yii::app()->user->ruangan_id;
        
        //var_dump($modRencanaKebBarang->validate());
        //var_dump($modRencanaKebBarang->errors);
        //var_dump($modRencanaKebBarang->attributes);
        //die;
        if ($modRencanaKebBarang->save()) {
          
          $this->rencanakebutuhantersimpan = true;
          if (isset($_GET['ubah'])) {
            $modRencanaDetailKeb = RenkebbahanmakanandetT::model()->deleteAllByAttributes(array('renkebbahanmakanan_id' => $modRencanaKebBarang->renkebbahanmakanan_id));
          }
          if (count((array)$_POST['RenkebbahanmakanandetT']) > 0) {
            foreach ($_POST['RenkebbahanmakanandetT'] as $i => $post) {
              $modDetails[$i] = $this->simpanRencanaKebutuhan($modRencanaKebBarang, $post);
            }
          } else {
            $this->rencanakebutuhantersimpan = false;
          }
        }

        if ($this->rencanakebutuhantersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Rencana Kebutuhan Barang " . $modRencanaKebBarang->renkebbahanmakanan_no . " berhasil disimpan !");
          $modRencanaKebBarang->isNewRecord = FALSE;
          $this->redirect(array('index', 'renkebbahanmakanan_id' => $modRencanaKebBarang->renkebbahanmakanan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Rencana Kebutuhan gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Rencana Kebutuhan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modRencanaKebBarang' => $modRencanaKebBarang,
      'modDetails' => $modDetails,
    ));
  }

  public function simpanRencanaKebutuhan($modRencanaKebBarang, $post)
  {
    $format = new MyFormatter();
    // var_dump($post);

    $modRencanaDetailKebBarang = new RenkebbahanmakanandetT;
    $modRencanaDetailKebBarang->attributes = $post;
    $modRencanaDetailKebBarang->bahanmakanan_id = $post['bahanmakanan_id'];
    $modRencanaDetailKebBarang->renkebbahanmakanan_id = $modRencanaKebBarang->renkebbahanmakanan_id; //fake id
    $modRencanaDetailKebBarang->satuanbahan = !empty($post['satuanbahan']) ? $post['satuanbahan'] : "-";
    $modRencanaDetailKebBarang->jmlpermintaandet = $post['jmlpermintaandet'];
    $modRencanaDetailKebBarang->harga_barangdet = $post['harga_barangdet'];
    $modRencanaDetailKebBarang->persen_ppn = $post['persen_ppn'];

    //        $modRencanaDetailKebBarang->stokakhir_bahanmakanan = 0;
    //        $modRencanaDetailKebBarang->minstok_bahanmakanan = 0; 
    //        $modRencanaDetailKebBarang->makstok_bahanmakanan = 0; 
    // $modRencanaDetailKebBarang->harga_barangdet = $modRencanaDetailKebBarang->jmlpermintaandet * $modRencanaDetailKebBarang->harga_barangdet;
    /* var_dump($modRencanaDetailKebBarang->validate());
        var_dump($modRencanaDetailKebBarang->errors);
        var_dump($modRencanaDetailKebBarang->attributes); 
        die;
         * 
         */
        
    if ($modRencanaDetailKebBarang->validate()) {
      
      $modRencanaDetailKebBarang->save();
    } else {
      $this->rencanakebutuhantersimpan &= false;
    }
    return $modRencanaDetailKebBarang;
  }

  public function actionLoadFormRencanaKebutuhan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bahanmakanan_id = $_POST['idBarang'];
      $jumlah = $_POST['jumlah'];
      $satuan = $_POST['satuan'];


      //$format = new MyFormatter();
      $modRencanaKebBarang = new RenkebbahanmakananT;
      $modRencanaDetailKebBarang = new RenkebbahanmakanandetT;
      $modBarang = BahanmakananM::model()->findByPk($bahanmakanan_id);
      $modRencanaDetailKebBarang->harga_barangdet = $modBarang->harganettobahan;
      $modRencanaDetailKebBarang->bahanmakanan_id = $modBarang->bahanmakanan_id;
      $modRencanaDetailKebBarang->minstok_bahanmakanan = $modBarang->jmlminimal;
      $modRencanaDetailKebBarang->makstok_bahanmakanan = 0;
      //            $modRencanaDetailKebBarang->stokakhir_bahanmakanan = 0;
      $modRencanaDetailKebBarang->stokakhir_bahanmakanan = StokbahanmakananT::getJumlahStok($bahanmakanan_id);
      $modRencanaDetailKebBarang->jmlpermintaandet = $jumlah;
      $modRencanaDetailKebBarang->namabahanmakanan = $modBarang->namabahanmakanan;
      $modRencanaDetailKebBarang->satuanbahan = (!empty($satuan) ? $satuan : $modBarang->satuanbahan);

      // var_dump($modRencanaDetailKebBarang->attributes); die;

      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial($this->path_view . '_rowBarangRencanaKebutuhan', array(
            'modRencanaKebBarang' => $modRencanaKebBarang,
            'modRencanaDetailKebBarang' => $modRencanaDetailKebBarang,
          ), true)
        )
      );
      exit;
    }
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = ADPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompletePegawaiMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = ADPegawaiV::model()->findAll($criteria);
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
   * untuk menampilkan barang dari autocomplete
   */
  public function actionAutoCompleteBahanMakanan()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $data = new GZStokbahanmakananT();
      $data->unsetAttributes();
      $data->namabahanmakanan = $_GET['term'];
      $prov = $data->searchInformasi();


      /*
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(namabahanmakanan)', strtolower($_GET['term']), true);
            // $criteria->addCondition('inventarisasi_stok <= minimalstok');
            $criteria->order = 'namabahanmakanan';

            $models = GZStokbahanmakananT::model()->findAll($criteria);
             * 
             */

      foreach ($prov->data as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['namabahanmakanan'] = $model->namabahanmakanan;
        $returnVal[$i]['satuanbahan'] = $model->satuanbahan;
        $returnVal[$i]['bahanmakanan_id'] = $model->bahanmakanan_id;
        $returnVal[$i]['label'] = $model->namabahanmakanan;
        $returnVal[$i]['value'] = $model->bahanmakanan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mencetak data rencana kebutuhan barang
   * @param $renkebbarang
   */
  public function actionPrint($renkebbahanmakanan_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modRencanaKebBarang = RenkebbahanmakananT::model()->findByPk($renkebbahanmakanan_id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('renkebbahanmakanan_id = ' . $renkebbahanmakanan_id);
    $modRencanaKebBarangDetail = RenkebbahanmakanandetT::model()->findAll($criteria);

    $judul_print = 'Rencana Kebutuhan Bahan Makanan';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modRencanaKebBarang' => $modRencanaKebBarang,
      'modRencanaKebBarangDetail' => $modRencanaKebBarangDetail,
      'caraprint' => $caraprint
    ));
  }

  public function actionSetHitungRO()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = '';
      $pesan = '';

      $ruangan_id = Params::RUANGAN_ID_GUDANG_UMUM;
      $jumlah = 0;
      $lt = 0.5;
      $t = isset($_POST['ro_bahanmakanan_bulan']) ? $_POST['ro_bahanmakanan_bulan'] : null;
      $tgl_sekarang = date('Y-m-d');
      $tgl_ro = date("Y-m-d", strtotime("-" . $t . " months"));
      $modRencanaDetailKebBarang = new RenkebbahanmakanandetT;

      $modBarang = BahanmakananM::model()->findAll();
      if (count((array)$modBarang) > 0) {
        foreach ($modBarang as $i => $barang) {
          $minimal_stok = isset($barang->barang_min) ? $barang->barang_min : 0;
          $maksimal_stok = isset($barang->barang_max) ? $barang->barang_max : 0;
          $criteria = new CDbCriteria();

          $criteria->select = 'bahanmakanan_id,sum(inventarisasi_qty_skrg) as inventarisasi_qty_skrg';
          $criteria->addCondition('bahanmakanan_id = ' . $barang->bahanmakanan_id);
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
          $criteria->group = 'bahanmakanan_id';
          $criteria->order = 'inventarisasi_qty_skrg,bahanmakanan_id ASC';
          /*
                      $stok_barang = ADInventarisasiruanganT::model()->find($criteria);


                      if(count((array)$stok_barang) > 0){
                      if($stok_barang->inventarisasi_qty_skrg <= $minimal_stok){
                      $criteria2 = new CDbCriteria();

                      $criteria2->select = 'bahanmakanan_id,sum(inventarisasi_qty_out) as inventarisasi_qty_out';
                      $criteria2->addBetweenCondition('DATE(tgltransaksi)',$tgl_ro,$tgl_sekarang);
                      $criteria2->addCondition('bahanmakanan_id = '.$barang->bahanmakanan_id);
                      $criteria2->addCondition('ruangan_id = '.$ruangan_id);
                      $criteria2->group = 'bahanmakanan_id';
                      $criteria->order = 'inventarisasi_qty_out,bahanmakanan_id ASC';
                      $jumlah_barang_keluar = ADInventarisasiruanganT::model()->find($criteria2);

                      if(count((array)$jumlah_barang_keluar) > 0){
                      if($jumlah_barang_keluar->inventarisasi_qty_out >= $maksimal_stok){
                      $selisih_stok = $maksimal_stok - $stok_barang->inventarisasi_qty_skrg;
                      $jumlah = $selisih_stok;
                      $modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
                      $modRencanaDetailKebBarang->bahanmakanan_id = $barang->bahanmakanan_id;
                      $modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
                      $modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
                      $modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
                      $modRencanaDetailKebBarang->jmlpermintaandet = $jumlah;
                      $modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
                      $modRencanaDetailKebBarang->satuanbahan = $barang->barang_satuan;
                      }else{
                      $jumlah = $jumlah_barang_keluar->inventarisasi_qty_out;
                      $modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
                      $modRencanaDetailKebBarang->bahanmakanan_id = $barang->bahanmakanan_id;
                      $modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
                      $modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
                      $modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
                      $modRencanaDetailKebBarang->jmlpermintaandet = $jumlah;
                      $modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
                      $modRencanaDetailKebBarang->satuanbahan = $barang->barang_satuan;
                      }
                      }else{
                      //$modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
                      $modRencanaDetailKebBarang->bahanmakanan_id = $barang->bahanmakanan_id;
                      //$modRencanaDetailKebBarang->asal_barang = $barang->barang_nama;
                      //$modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
                      //$modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
                      //$modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
                      //$modRencanaDetailKebBarang->jmlpermintaandet = 0;
                      $modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
                      $modRencanaDetailKebBarang->satuanbahan = $barang->barang_satuan;
                      }
                      $form .=$this->renderPartial($this->path_view.'_rowBarangRencanaKebutuhan', array('modRencanaDetailKebBarang'=>$modRencanaDetailKebBarang), true);
                      }
                      }
                     * 
                     */
          Yii::app()->end();
        }
      } else {
        $pesan = 'Data Barang tidak ditemukan.';
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan, 'lead_time' => $lt));
    }
    Yii::app()->end();
  }
}
