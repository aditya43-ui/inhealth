<?php

class PengajuanPerubahanHargaObatController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.pengajuanPerubahanHargaObat.';
  public $tersimpan = false;

  public function actionIndex($pengajuanhargaoa_id = null)
  {
    $format = new MyFormatter;
    $model = new GFPengajuanhargaoaT;
    $modDetails = array();

    $model->nopengajuanhargaoa = "Otomatis";
    $model->tglpengajuanhargaoa = $format->formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');

    $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
    if (isset($modApprovalotorisasiM)) {
      $model->pegawaimengetahui_id = $modApprovalotorisasiM->managerkeuangan_id;
      $model->pegawaimenyetujui_id = $modApprovalotorisasiM->direkturrs_id;
    }

    if (!empty($pengajuanhargaoa_id)) {
      $model = GFPengajuanhargaoaT::model()->findByPk($pengajuanhargaoa_id);
      $modDetails = GFPenghargaoadetailT::model()->findAllByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));
    }


    $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);

    if (isset($modPegawai)) {
      $model->pegawai_nama = $modPegawai->namaLengkap;
    }

    $modPegKeu = PegawaiM::model()->findByPk($model->pegawaimengetahui_id);

    if (isset($modPegKeu)) {
      $model->pegawaimengetahui_nama = $modPegKeu->namaLengkap;
    }

    $modPegDirektur = PegawaiM::model()->findByPk($model->pegawaimenyetujui_id);

    if (isset($modPegDirektur)) {
      $model->pegawaimenyetujui_nama = $modPegDirektur->namaLengkap;
    }

    if (isset($_POST['GFPengajuanhargaoaT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $model->attributes = $_POST['GFPengajuanhargaoaT'];
        $model->tglpengajuanhargaoa = $format->formatDateTimeForDb($model->tglpengajuanhargaoa);

        if (isset($model->pengajuanhargaoa_id)) {
          $model->update_time = date('Y-m-d H:i:s');
          $model->update_loginpemakai = Yii::app()->user->id;
        } else {

          $model->create_time = date('Y-m-d H:i:s');

          $model->create_loginpemakai = Yii::app()->user->id;
          $model->nopengajuanhargaoa = MyGenerator::noPengajuanPerubahanHarga();
        }

        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $detailtersimpan = true;

        if ($model->validate()) {
          if ($model->save()) {
            $this->tersimpan = true;

            if (isset($_POST['GFPenghargaoadetailT'])) {
              GFPenghargaoadetailT::model()->deleteAllByAttributes(array('pengajuanhargaoa_id' => $model->pengajuanhargaoa_id));

              foreach ($_POST['GFPenghargaoadetailT'] as $i => $dataDetail) {
                $modDetail = new GFPenghargaoadetailT;
                $modDetail->attributes = $dataDetail;
                $modDetail->pengajuanhargaoa_id = $model->pengajuanhargaoa_id;

                if ($dataDetail['satuanobat'] == Params::SATUANOBAT_BESAR) {
                  $modDetail->satuankecil_id = null;
                  $modDetail->satuanbesar_id = $dataDetail['satuanbesar_id'];
                  $modDetail->kemasanbesar = $dataDetail['kemasanbesar'];
                } else {
                  $modDetail->satuankecil_id = $dataDetail['satuankecil_id'];
                  $modDetail->satuanbesar_id = null;
                  $modDetail->kemasanbesar = null;
                }

                if (isset($modDetail->penghargaoadetail_id)) {
                  $modDetail->update_time = date('Y-m-d H:i:s');
                  $modDetail->update_loginpemakai = Yii::app()->user->id;
                } else {
                  $modDetail->create_time = date('Y-m-d H:i:s');
                  $modDetail->create_loginpemakai = Yii::app()->user->id;
                }
                $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if (!$modDetail->save()) {
                  $detailtersimpan = false;
                }
              }
            }
          }
        }

        if ($this->tersimpan == true && $detailtersimpan == true) {
          $transaction->commit();
          $this->redirect(array('index', 'pengajuanhargaoa_id' => $model->pengajuanhargaoa_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'modDetails' => $modDetails,
    ));
  }


  public function actionLoadFormObat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];

      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
      $modDetail = new GFPenghargaoadetailT();
      $modDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
      $modDetail->satuanobat = Params::SATUANOBAT_KECIL;
      $modDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
      $modDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
      $modDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
      $modDetail->harganettolama = $modObatAlkes->harganetto;
      $modDetail->diskonlama = $modObatAlkes->discount;
      $hargappn = ((($modDetail->harganettolama - $modDetail->diskonlama) * $modObatAlkes->ppn_persen) / 100);
      // $hargappn = ($modObatAlkes->ppn_persen * ($modDetail->harganettolama - $modDetail->diskonlama));
      $modDetail->ppnlama = $hargappn;
      $modDetail->hpplama = (($modDetail->harganettolama - $modDetail->diskonlama) + $hargappn);
      $modDetail->marginlama = $modObatAlkes->margin;
      $jmlmargin = (($modDetail->marginlama * $modDetail->hpplama) / 100);
      $modDetail->hargajuallama = MyFormatter::formatNumberForPrint(($modDetail->hpplama + $jmlmargin), 2);
      $modDetail->ppn_persen = $modObatAlkes->ppn_persen;
      $modDetail->marginbaru = $modObatAlkes->margin;


      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial(
            $this->path_view . '_rowPerubahanHarga',
            array(
              'modDetail' => $modDetail,
              'modObatAlkes' => $modObatAlkes,
            ),
            true
          )
        )
      );
      exit;
    }
  }

  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = GFObatAlkesM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes_nama;
        $returnVal[$i]['value'] = $model->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrint($pengajuanhargaoa_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $model = PengajuanhargaoaT::model()->findByPk($pengajuanhargaoa_id);
    $modDetail = PenghargaoadetailT::model()->findAllByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));

    $judul_print = 'PENGAJUAN PERUBAHAN HARGA OBAT ALKES';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modDetail' => $modDetail,
      'caraPrint' => $caraPrint
    ));
  }






  /**
   * simpan ADPermintaanDetailT
   * @param type $modPermintaanPembelian
   * @param type $post
   * @return \ADPermintaanDetailT
   */
  public function simpanPermintaanPembelian($modPermintaanPembelian, $post)
  {
    $format = new MyFormatter();
    $modPermintaanPembelianDetail = new ADPermintaanDetailT;
    $modPermintaanPembelianDetail->attributes = $post;
    $modPermintaanPembelianDetail->permintaanpembelian_id = $modPermintaanPembelian->permintaanpembelian_id; //fake id
    $modPermintaanPembelianDetail->tglkadaluarsa = $format->formatDateTimeForDb($post['tglkadaluarsa']);
    $modPermintaanPembelianDetail->jmldiscount = 0;
    $modPermintaanPembelianDetail->maksimalstok = 0;
    //$modPermintaanPembelianDetail->persenppn = 0;
    //$modPermintaanPembelianDetail->persenpph = 0;
    $modPermintaanPembelianDetail->hargasatuanper = MyFormatter::formatNumberForDb($modPermintaanPembelianDetail->hargasatuanper);
    $modPermintaanPembelianDetail->hpp = MyFormatter::formatNumberForDb($modPermintaanPembelianDetail->hpp);
    $modPermintaanPembelianDetail->ppn = MyFormatter::formatNumberForDb($modPermintaanPembelianDetail->ppn);
    //var_dump($modPermintaanPembelianDetail->hargasatuanper);die;
    $modPermintaanPembelianDetail->biaya_lainlain = 0;

    if ($post['satuanobat'] == PARAMS::SATUAN_KECIL) {
      $modPermintaanPembelianDetail->satuanbesar_id = NULL;
    } else {
      $modPermintaanPembelianDetail->satuankecil_id = NULL;
    }

    if ($modPermintaanPembelianDetail->validate()) {
      //var_dump($modPermintaanPembelianDetail->attributes);die;
      $modPermintaanPembelianDetail->save();
    } else {
      $this->permintaanpembeliantersimpan &= false;
    }


    return $modPermintaanPembelianDetail;
  }

  /**
   * menampilkan obat
   * @return row table
   */


  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->compare('ruangan_id', Params::RUANGAN_ID_GUDANG_UMUM);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawairuanganV::model()->findAll($criteria);
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
      $criteria->join = "JOIN ruanganpegawai_m rp ON rp.pegawai_id = t.pegawai_id";
      // $criteria->addCondition(" rp.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->compare('unitkerja_id', array(Params::UNITKERJA_ID_PELAYANAN_MEDIS, Params::UNITKERJA_ID_PENUNJANG_MEDIS));

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
   * untuk print data permintaan pembelian farmasi
   */



  public function actionViewStokOA()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $oa = ObatalkesM::model()->findByPk($_POST['id']);
    $stok = StokobatalkesT::model()->findAllByAttributes(array(
      'obatalkes_id' => $_POST['id'],
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkadaluarsa asc',
    ));

    $restok = array();
    foreach ($stok as $item) {
      if (empty($restok[$item->tglkadaluarsa])) {
        $restok[$item->tglkadaluarsa] = array(
          'tgl' => MyFormatter::formatDateTimeForUser($item->tglkadaluarsa),
          'stok' => 0,
        );
      }

      $restok[$item->tglkadaluarsa]['stok'] += $item->qtystok_in - $item->qtystok_out;
    }

    $rows = "";

    foreach ($restok as $item) {
      $rows .= '<tr class="details"><td>' . $item['tgl'] . '</td><td class="info_num">' . $item['stok'] . '</td></tr>';
    }

    $res = array();
    $res['stok_min'] = $oa->minimalstok;
    $res['stok_max'] = $oa->maksimalstok;
    $res['detail'] = $rows;



    // print_r($oa->attributes); die;

    echo CJSON::encode($res);
  }



  public function actionAutoCompleteSupplier($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $criteria = new CDbCriteria;
    $criteria->compare('lower(supplier_nama)', strtolower($term), true);
    $criteria->addCondition('supplier_aktif = true');
    $criteria->order = 'supplier_nama';
    $criteria->limit = 10;

    $model = SupplierM::model()->findAll($criteria);
    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->supplier_nama;
      $sub['value'] = $item->supplier_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }


  public function actionPrintObatTertentu($permintaanpembelian_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPermintaanPembelian = ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);
    $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $apoteker = new ADPegawaiM();
    if (!empty($modPermintaanPembelian->pegawaiapoteker_id)) {
      $apoteker = ADPegawaiM::model()->findByPk($modPermintaanPembelian->pegawaiapoteker_id);
    }

    $distributor = SupplierM::model()->findByPk($modPermintaanPembelian->supplier_id);

    $judul_print = 'Permintaan Pembelian Farmasi';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    }
    $this->render($this->path_view . 'PrintObatTertentu', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPermintaanPembelian' => $modPermintaanPembelian,
      'modPermintaanPembelianDetail' => $modPermintaanPembelianDetail,
      'apoteker' => $apoteker,
      'distributor' => $distributor,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionPrintObatPrekursor($permintaanpembelian_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPermintaanPembelian = ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);
    $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $apoteker = new ADPegawaiM();
    if (!empty($modPermintaanPembelian->pegawaiapoteker_id)) {
      $apoteker = ADPegawaiM::model()->findByPk($modPermintaanPembelian->pegawaiapoteker_id);
    }

    $distributor = SupplierM::model()->findByPk($modPermintaanPembelian->supplier_id);

    $judul_print = 'Permintaan Pembelian Farmasi';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    }
    $this->render($this->path_view . 'PrintObatPrekursor', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPermintaanPembelian' => $modPermintaanPembelian,
      'modPermintaanPembelianDetail' => $modPermintaanPembelianDetail,
      'apoteker' => $apoteker,
      'distributor' => $distributor,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionPrintObatPsikotropika($permintaanpembelian_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPermintaanPembelian = ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);
    $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $apoteker = new ADPegawaiM();
    if (!empty($modPermintaanPembelian->pegawaiapoteker_id)) {
      $apoteker = ADPegawaiM::model()->findByPk($modPermintaanPembelian->pegawaiapoteker_id);
    }

    $distributor = SupplierM::model()->findByPk($modPermintaanPembelian->supplier_id);

    $judul_print = 'Permintaan Pembelian Farmasi';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    }
    $this->render($this->path_view . 'PrintObatPsikotropika', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPermintaanPembelian' => $modPermintaanPembelian,
      'modPermintaanPembelianDetail' => $modPermintaanPembelianDetail,
      'apoteker' => $apoteker,
      'distributor' => $distributor,
      'caraPrint' => $caraPrint
    ));
  }
}
