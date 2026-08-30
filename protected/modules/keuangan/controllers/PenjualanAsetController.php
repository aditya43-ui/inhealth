<?php

class PenjualanAsetController extends MyAuthController
{
  protected $succesSave = true;
  protected $successSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";
  public $path_view = 'keuangan.views.penjualanAset.';
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex($id = null)
  {
    $modAset = new InvperalatanT;

    if (isset($_POST['InvperalatanT'])) {
      // var_dump($_POST['InvperalatanT']['detail']);
      $transaction = Yii::app()->db->beginTransaction();
      try {

        foreach ($_POST['InvperalatanT']['detail'] as $key => $value) {
          if (isset($value['is_checked'])) {
            $id   = $value['invperalatan_id'];
            $model   = InvperalatanT::model()->findByPk($id);
            $model->tglpenghapusan = date('Y-m-d H:i:s');
            $model->tipepenghapusan = "penjualan";
            $model->hargajualaktiva = str_replace(".", "", $value['hargajualaktiva']);

            if ($model->invperalatan_harga < $model->hargajualaktiva) {
              $model->keuntungan = $model->hargajualaktiva - $model->invperalatan_harga;
            } else {
              $model->kerugian = $model->invperalatan_harga - $model->hargajualaktiva;
            }


            // var_dump($model->attributes); die;
            $model->save();
          }
        }
        if (isset($_POST['JenispengeluaranrekeningV'])) {

          //=========== Save Jurnal Rekening =================
          $modJurnalRekening = $this->saveJurnalRekening($model, $_POST['InvperalatanT']);
          // if($_POST['BKReturbayarpelayananT']['is_posting']=='posting')
          // {
          //     $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          // }else{
          //     $modJurnalPosting = null;
          // }
          $noUrut = 0;
          foreach ($_POST['JenispengeluaranrekeningV'] as $i => $post) {
            $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, null);
            $noUrut++;
          }
          //==================================================

        }
        // die;
        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index'));
          $model->isNewRecord = false;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array('modAset' => $modAset));
  }

  public function actionIndexTanah($id = null)
  {
    $modAset = new InvtanahT;

    if (isset($_POST['InvtanahT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      // var_dump($_POST['InvtanahT']['detail']); die;
      try {

        foreach ($_POST['InvtanahT']['detail'] as $key => $value) {
          // var_dump($value); die;
          if (isset($value['is_checked'])) {
            $id     = $value['invtanah_id'];
            $model  = InvtanahT::model()->findByPk($id);
            $model->tglpenghapusan = date('Y-m-d H:i:s');
            $model->tipepenghapusan = "penjualan";
            $model->hargajualaktiva = str_replace(".", "", $value['hargajualaktiva']);

            if ($model->invtanah_harga < $model->hargajualaktiva) {
              $model->keuntungan = $model->hargajualaktiva - $model->invtanah_harga;
            } else {
              $model->kerugian = $model->invtanah_harga - $model->hargajualaktiva;
            }

            // var_dump($value, $model->attributes); die;

            $model->save();
          }
        }
        if (isset($_POST['JenispengeluaranrekeningV'])) {

          //=========== Save Jurnal Rekening =================
          $modJurnalRekening = $this->saveJurnalRekening($model, $_POST['InvtanahT']);
          // if($_POST['BKReturbayarpelayananT']['is_posting']=='posting')
          // {
          //     $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          // }else{
          //     $modJurnalPosting = null;
          // }
          $noUrut = 0;
          foreach ($_POST['JenispengeluaranrekeningV'] as $i => $post) {
            $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, null);
            $noUrut++;
          }
          //==================================================
        }
        //var_dump($this->succesSave);
        //die;
        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('indexTanah'));
          $model->isNewRecord = false;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'indexTanah', array('modAset' => $modAset));
  }

  //    public function actionGetDataRekeningByJnsPengeluaran()
  //    {
  //        if(Yii::app()->getRequest()->getIsAjaxRequest())
  //        {
  //            $jenispengeluaran_id = $_POST['jenispengeluaran_id'];
  //            $criteria = new CDbCriteria;
  //            $criteria->condition = 'jenispengeluaran_id = :jenispengeluaran_id';
  //            $criteria->order ='jenispengeluaran_id,saldonormal';
  //            $criteria->params = array(':jenispengeluaran_id'=>$jenispengeluaran_id);
  ////            $model = RekeningakuntansiV::model()->findAll($criteria);
  //             $model = JenispengeluaranrekeningV::model()->findAll($criteria);
  //            if($model)
  //            {
  //                echo CJSON::encode(
  //                    $this->renderPartial($this->path_view.'akuntansi.views.penjualanAset._formKodeRekening', array('model'=>$model), true)
  //                );
  //            }
  //            Yii::app()->end();
  //        }
  //    }

  public function actionIndexGedung($id = null)
  {
    $modAset = new InvgedungT;

    if (isset($_POST['InvgedungT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        foreach ($_POST['InvgedungT']['detail'] as $key => $value) {
          if ($value['is_checked']) {
            $id     = $value['invgedung_id'];
            $model  = InvgedungT::model()->findByPk($id);;
            $model->tglpenghapusan = date('Y-m-d H:i:s');
            $model->tipepenghapusan = "penjualan";
            $model->hargajualaktiva = str_replace(".", "", $value['hargajualaktiva']);

            if ($model->invgedung_harga < $model->hargajualaktiva) {
              $model->keuntungan = $model->hargajualaktiva - $model->invgedung_harga;
            } else {
              $model->kerugian = $model->invgedung_harga - $model->hargajualaktiva;
            }
            $model->save();
          }
        }
        if (isset($_POST['JenispengeluaranrekeningV'])) {

          //=========== Save Jurnal Rekening =================
          $modJurnalRekening = $this->saveJurnalRekening($model, $_POST['InvgedungT']);
          // if($_POST['BKReturbayarpelayananT']['is_posting']=='posting')
          // {
          //     $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          // }else{
          //     $modJurnalPosting = null;
          // }
          $noUrut = 0;
          foreach ($_POST['JenispengeluaranrekeningV'] as $i => $post) {
            $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, null);
            $noUrut++;
          }
          //==================================================
        }

        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('indexGedung'));
          $model->isNewRecord = false;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'indexGedung', array('modAset' => $modAset));
  }

  public function actionIndexPeralatanNonMedis($id = null)
  {
    $modAset = new InvperalatanT;

    if (isset($_POST['InvperalatanT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        foreach ($_POST['InvperalatanT']['detail'] as $key => $value) {
          if (isset($value['is_checked'])) {
            $id   = $value['invperalatan_id'];
            $model   = InvperalatanT::model()->findByPk($id);;
            $model->tglpenghapusan = date('Y-m-d H:i:s');
            $model->tipepenghapusan = "penjualan";
            $model->hargajualaktiva = str_replace(".", "", $value['hargajualaktiva']);

            if ($model->invperalatan_harga < $model->hargajualaktiva) {
              $model->keuntungan = $model->hargajualaktiva - $model->invperalatan_harga;
            } else {
              $model->kerugian = $model->invperalatan_harga - $model->hargajualaktiva;
            }
            $model->save();
          }
        }
        if (isset($_POST['JenispengeluaranrekeningV'])) {

          //=========== Save Jurnal Rekening =================
          $modJurnalRekening = $this->saveJurnalRekening($model, $_POST['InvperalatanT']);
          // if($_POST['BKReturbayarpelayananT']['is_posting']=='posting')
          // {
          //     $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          // }else{
          //     $modJurnalPosting = null;
          // }
          $noUrut = 0;
          foreach ($_POST['JenispengeluaranrekeningV'] as $i => $post) {
            $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, null);
            $noUrut++;
          }
          //==================================================

        }

        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('indexPeralatanNonMedis'));
          $model->isNewRecord = false;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'indexPeralatanNonMedis', array('modAset' => $modAset));
  }

  public function actionIndexKendaraan($id = null)
  {
    $modAset = new InvperalatanT;

    if (isset($_POST['InvperalatanT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        foreach ($_POST['InvperalatanT']['detail'] as $key => $value) {
          if (isset($value['is_checked'])) {
            $id     = $value['invperalatan_id'];
            $model  = InvperalatanT::model()->findByPk($id);;
            $model->tglpenghapusan = date('Y-m-d H:i:s');
            $model->tipepenghapusan = "penjualan";
            $model->hargajualaktiva = str_replace(".", "", $value['hargajualaktiva']);

            if ($model->invperalatan_harga < $model->hargajualaktiva) {
              $model->keuntungan = $model->hargajualaktiva - $model->invperalatan_harga;
            } else {
              $model->kerugian = $model->invperalatan_harga - $model->hargajualaktiva;
            }

            $model->save();
          }
        }
        if (isset($_POST['JenispengeluaranrekeningV'])) {
          //=========== Save Jurnal Rekening =================
          $modJurnalRekening = $this->saveJurnalRekening($model, $_POST['InvperalatanT']);
          // if($_POST['BKReturbayarpelayananT']['is_posting']=='posting')
          // {
          //     $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          // }else{
          //     $modJurnalPosting = null;
          // }
          $noUrut = 0;
          foreach ($_POST['JenispengeluaranrekeningV'] as $i => $post) {
            $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, null);
            $noUrut++;
          }
          //==================================================
        }

        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('indexKendaraan'));
          $model->isNewRecord = false;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render($this->path_view . 'indexKendaraan', array('modAset' => $modAset));
  }

  /**
   * menampilkan data aset yang akan dihapus / dijual
   */
  public function actionGetDataPenghapusan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $conditions = "t.tipepenghapusan <> '" . Params::TIPE_PENGHAAPUSAN_PENJUALAN . "' "
        . "or t.tipepenghapusan is null";
      /*
		if (isset($_POST['periode'])) {
			$periode        = explode(' ', $_POST['periode']);
			$periode_bulan  = $periode[0];
			$periode_tahun  = $periode[1];
			$format         = new MyFormatter;
			$bulan_angka    = $format->getMonthDb($periode_bulan);
			$periode_hapus   = $periode_tahun.'-'.$bulan_angka;
			$conditions = "to_char(tglpenghapusan,'yyyy-mm') = '".$periode_hapus."' AND tipepenghapusan='penjualan'";
		}
		 *
		 */
      $jenis_inventori = $_POST['jenis'];
      $criteria       = new CDbCriteria;
      $criteria->addCondition($conditions);
      if ($jenis_inventori == "peralatan") {
        $criteria->join = "join barang_v b on b.barang_id = t.barang_id";
        $criteria->addCondition("b.bidang_id in (8, 9)");
        // $criteria->addCondition("split_part(invperalatan_noregister, '-',3)='04' ");
        $modPenggajian  = InvperalatanT::model()->findAll($criteria);
        if (count((array)$modPenggajian) > 0) {
          foreach ($modPenggajian as $i => $model) {
            $models[$i]['invperalatan_kode']  = $model->invperalatan_kode;
            $models[$i]['invperalatan_noregister']  = $model->invperalatan_noregister;
            $models[$i]['invperalatan_namabrg']    = $model->invperalatan_namabrg;
            $models[$i]['invperalatan_harga']    = $model->invperalatan_harga;
            $models[$i]['invperalatan_id']   = $model->invperalatan_id;
            $models[$i]['hargajualaktiva']   = $model->hargajualaktiva;
            $models[$i]['keuntungan']        = $model->keuntungan;
            $models[$i]['kerugian']          = $model->kerugian;
            $models[$i]['invperalatan_akumsusut']   = $model->invperalatan_akumsusut;
          }
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincian', array('modRincian' => $models), true)
          );
        } else {
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincian', array('modRincian' => null), false)
          );
        }
      } elseif ($jenis_inventori == "peralatan_non_medis") {
        $criteria->join = "join barang_v b on b.barang_id = t.barang_id";
        $criteria->addCondition("b.bidang_id not in (8, 9, 3)");
        // $criteria->addCondition("split_part(invperalatan_noregister, '-',3)='05' ");
        $modPenggajian  = InvperalatanT::model()->findAll($criteria);
        if (count((array)$modPenggajian) > 0) {
          foreach ($modPenggajian as $i => $model) {
            $models[$i]['invperalatan_kode']  = $model->invperalatan_kode;
            $models[$i]['invperalatan_noregister']  = $model->invperalatan_noregister;
            $models[$i]['invperalatan_namabrg']    = $model->invperalatan_namabrg;
            $models[$i]['invperalatan_harga']    = $model->invperalatan_harga;
            $models[$i]['invperalatan_id']   = $model->invperalatan_id;
            $models[$i]['hargajualaktiva']   = $model->hargajualaktiva;
            $models[$i]['keuntungan']        = $model->keuntungan;
            $models[$i]['kerugian']          = $model->kerugian;
            $models[$i]['invperalatan_akumsusut']   = $model->invperalatan_akumsusut;
          }
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincian', array('modRincian' => $models), true)
          );
        } else {
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincian', array('modRincian' => null), false)
          );
        }
      } elseif ($jenis_inventori == "tanah") {
        // var_dump($criteria); die;
        $modPenggajian  = InvtanahT::model()->findAll($criteria);
        if (count((array)$modPenggajian) > 0) {
          foreach ($modPenggajian as $i => $model) {
            $models[$i]['invtanah_kode']  = $model->invtanah_kode;
            $models[$i]['invtanah_noregister']  = $model->invtanah_noregister;
            $models[$i]['invtanah_namabrg']     = $model->invtanah_namabrg;
            $models[$i]['invtanah_harga']   = $model->invtanah_harga;
            $models[$i]['invtanah_id']      = $model->invtanah_id;
            $models[$i]['hargajualaktiva']  = $model->hargajualaktiva;
            $models[$i]['keuntungan']       = $model->keuntungan;
            $models[$i]['kerugian']         = $model->kerugian;
            $models[$i]['invtanah_alamat']  = $model->invtanah_alamat;
          }
          // var_dump($models); die;
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincianTanah', array('modRincian' => $models), true)
          );
        } else {
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincianTanah', array('modRincian' => null), false)
          );
        }
      } elseif ($jenis_inventori == "gedung") {
        $modPenggajian  = InvgedungT::model()->findAll($criteria);
        if (count((array)$modPenggajian) > 0) {
          foreach ($modPenggajian as $i => $model) {
            $models[$i]['invgedung_kode']  = $model->invgedung_kode;
            $models[$i]['invgedung_noregister']  = $model->invgedung_noregister;
            $models[$i]['invgedung_namabrg']     = $model->invgedung_namabrg;
            $models[$i]['invgedung_harga']   = $model->invgedung_harga;
            $models[$i]['invgedung_id']      = $model->invgedung_id;
            $models[$i]['hargajualaktiva']  = $model->hargajualaktiva;
            $models[$i]['keuntungan']       = $model->keuntungan;
            $models[$i]['kerugian']         = $model->kerugian;
            $models[$i]['invgedung_akumsusut']   = $model->invgedung_akumsusut;
          }
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincianGedung', array('modRincian' => $models), true)
          );
        } else {
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincianGedung', array('modRincian' => null), false)
          );
        }
      } elseif ($jenis_inventori == "kendaraan") {
        $criteria->join = "join barang_v b on b.barang_id = t.barang_id";
        $criteria->addCondition("b.bidang_id = 3");
        //$criteria->addCondition("split_part(invperalatan_noregister, '-',3)='03' ");
        $modPenggajian  = InvperalatanT::model()->findAll($criteria);
        if (count((array)$modPenggajian) > 0) {
          foreach ($modPenggajian as $i => $model) {
            $models[$i]['invperalatan_kode']  = $model->invperalatan_kode;
            $models[$i]['invperalatan_noregister']  = $model->invperalatan_noregister;
            $models[$i]['invperalatan_namabrg']    = $model->invperalatan_namabrg;
            $models[$i]['invperalatan_harga']    = $model->invperalatan_harga;
            $models[$i]['invperalatan_id']   = $model->invperalatan_id;
            $models[$i]['hargajualaktiva']   = $model->hargajualaktiva;
            $models[$i]['keuntungan']        = $model->keuntungan;
            $models[$i]['kerugian']          = $model->kerugian;
            $models[$i]['invperalatan_akumsusut']   = $model->invperalatan_akumsusut;
          }
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincian', array('modRincian' => $models), true)
          );
        } else {
          echo CJSON::encode(
            $this->renderPartial($this->path_view . '_rincian', array('modRincian' => null), false)
          );
        }
      }
      Yii::app()->end();
    }
  }

  protected function saveJurnalRekening($model, $postPenUmum)
  {
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = date('Y-m-d H:i:s'); //$model->tglpenghapusan;
    $modJurnalRekening->nobuktijurnal = Generator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = Generator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = date('Y-m-d H:i:s'); //$model->tglpenghapusan;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = "Penjualan Aset " . date('Y-m-d H:i:s'); //$model->tglpenghapusan;

    $modJurnalRekening->jenisjurnal_id = Params::JURNAL_PENGELUARAN_KAS;
    $periodeID = Yii::app()->session['periodeID'];
    $modJurnalRekening->rekperiod_id = $periodeID[0];
    $modJurnalRekening->create_time = date('Y-m-d H:i:s'); //$model->tglpenghapusan;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }

    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $post, $noUrut = 0, $modJurnalPosting)
  {
    $modJurnalDetail = new JurnaldetailT();
    $modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
    $modJurnalDetail->saldodebit = $post['saldodebit'];
    $modJurnalDetail->saldokredit = $post['saldokredit'];
    $modJurnalDetail->nourut = $noUrut;
    // $modJurnalDetail->rekening1_id = $post['struktur_id'];
    // $modJurnalDetail->rekening2_id = $post['kelompok_id'];
    // $modJurnalDetail->rekening3_id = $post['jenis_id'];
    // $modJurnalDetail->rekening4_id = $post['obyek_id'];
    $modJurnalDetail->rekening5_id = $post['rincianobyek_id'];
    $modJurnalDetail->catatan = "";

    if ($modJurnalDetail->validate()) {
      $modJurnalDetail->save();
    }
    return $modJurnalDetail;
  }

  protected function saveJurnalPosting($arrJurnalPosting)
  {
    $modJurnalPosting = new JurnalpostingT;
    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    $modJurnalPosting->keterangan = "Posting automatis";
    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modJurnalPosting->validate()) {
      $modJurnalPosting->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $this->pesan = $modJurnalPosting->getErrors();
    }
    return $modJurnalPosting;
  }
}
