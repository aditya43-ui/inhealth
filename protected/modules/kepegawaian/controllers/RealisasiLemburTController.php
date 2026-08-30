<?php

class RealisasiLemburTController extends MyAuthController
{
  public $realisasilemburtersimpan = true; //looping
  public $rencanalemburtersimpan = true; //looping
  public $defaultAction = 'buat';
  public $path_view = 'application.modules.kepegawaian.views.realisasiLemburT.';

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */

  public function actionBuat($id = null, $id_realisasi = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Realisasi Lembur";
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    $format = new MyFormatter;
    $modRealisasiLembur = new KPRealisasiLemburT();
    $modRealisasiLemburDetail = new KPRealisasilemburT();
    $modRencanaLembur = new KPRencanaLemburT();
    //$modRencanaLembur->tglrencana = null;
    $modRealisasiLembur->tglrealisasi = date('Y-m-d');
    $modRealisasiLembur->norealisasi = 'Otomatis';
    $modDetail = array();
    $modPegawai = new KPPegawaiM();
    $i = 0;
    $sukses = 0;
    $gagal = 0;
    $konfig = ApprovalotorisasiM::model()->find();

    $modRencanaLembur->menyetujui_id = $konfig->bagiankepegawaian_id;
    $modRencanaLembur->menyetujui_nama = PegawaiM::model()->findByPk($modRencanaLembur->menyetujui_id)->namaLengkap;
    if (!empty($id)) {
      $modRencanaLembur = KPRencanaLemburT::model()->getModel($id);
      $modRencanaLemburDetail = $modRencanaLembur->detail;
      //				foreach ($modRencanaLemburDetail as $i => $detail){
      //					echo "<pre>";
      //					print_r($detail->attributes);
      //				}
      //					exit;
    }

    if ($id_realisasi != null) {

      $modRealisasiLembur = KPRealisasiLemburT::model()->getModel($id_realisasi);
      if (!empty($modRealisasiLembur->rencanalembur_id)) {
        $modRencanaLembur = KPRencanaLemburT::model()->getModel($modRealisasiLembur->rencanalembur_id);
        $modRencanaLembur->mengetahui_nama = isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : "";
        $modRencanaLembur->menyetujui_nama = isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : "";
        $modRencanaLembur->pemberitugas_nama = isset($modRealisasiLembur->pemberitugas->NamaLengkap) ? $modRealisasiLembur->pemberitugas->NamaLengkap : "";
      }
      $modDetail = $modRealisasiLembur->detail;
    }

    if (isset($modRencanaLembur)) {
      if (!empty($modRencanaLembur->tglrencana)) {
        $modRencanaLembur->tglrencana = date('d M Y H:i:s', strtotime($modRencanaLembur->tglrencana));
      }
    }



    if (isset($_POST['KPRealisasiLemburT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      // print_r(var_export($_POST)); die;
      //                 var_dump($_POST); die;

      try {

        $modRealisasiLembur = KPRealisasiLemburT::model()->saveRealisasiLembur($_POST);
        $this->notifRealisasiLembur($modRealisasiLembur);

        if ($modRealisasiLembur->ok) {
          $transaction->commit();
          $sukses = 1;
          if (isset($_GET['frame'])) {
            $this->redirect(array('buat', 'id_realisasi' => $modRealisasiLembur->realisasilembur_id, 'sukses' => $sukses, 'frame' => 1));
          }
          $this->redirect(array('buat', 'id_realisasi' => $modRealisasiLembur->realisasilembur_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data realisasi lembur pegawai gagal disimpan (err2)!");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data realisasi lembur pegawai gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    } else {
      $modRealisasiLembur->tglrealisasi = date('d M Y H:i:s');
    }
    if (!isset($modRencanaLembur)) {
      $modRencanaLembur = new KPRencanaLemburT();
    }

    if (!isset($modRencanaLemburDetail)) {
      $modRencanaLemburDetail = null;
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(950);

    $modRealisasiLembur->tglrealisasi = date('d M Y H:i:s', strtotime($modRealisasiLembur->tglrealisasi));
    $this->render($this->path_view . 'buat', array(
      'modRealisasiLembur' => $modRealisasiLembur,
      'modRencanaLembur' => $modRencanaLembur,
      'modRealisasiLemburDetail' => $modRealisasiLemburDetail,
      'modRencanaLemburDetail' => $modRencanaLemburDetail,
      // 'norencana'=>$modRencanaLembur->norenca,
      'format' => $format,
      'modPegawai' => $modPegawai,
      'modDetail' => $modDetail,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function notifRealisasiLembur($modRealisasiLembur)
  {

    $det = RealisasilemburdetT::model()->findAllByAttributes(array(
      'realisasilembur_id' => $modRealisasiLembur->realisasilembur_id
    ));

    $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));


    $judul = "Realisasi Lembur " . Yii::app()->user->getState('ruangan_nama');
    $isi = "<ul>";


    foreach ($det as $item) {
      $pegawai = PegawaiM::model()->findByPk($item->pegawai_id);
      $isi .= "<li>" . $pegawai->namaLengkap . " > ";
      $isi .= MyFormatter::formatDateTimeForUser($item->tglmulai) . " - ";
      $isi .= MyFormatter::formatDateTimeForUser($item->tglselesai);
      $isi .= "</li>";
    }

    $isi .= "</ul>";

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      array('instalasi_id' => Params::INSTALASI_ID_UMUM_PENUNJANG, 'ruangan_id' => Params::RUANGAN_ID_KEPEGAWAIAN, 'modul_id' => Params::MODUL_ID_KEPEGAWAIAN),
    ));
  }

  /**
   * Informasi Realisasi Lembur.
   */
  public function actionInformasi($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Realisasi Lembur";
    $modRealisasiLembur = new KPRealisasiLemburT('search');
    $modRealisasiLembur->unsetAttributes();  // clear any default values

    if (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_KEPEGAWAIAN) {
      $modRealisasiLembur->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    if (isset($_GET['KPRealisasiLemburT'])) {
      $modRealisasiLembur->attributes = $_GET['KPRealisasiLemburT'];
      $modRealisasiLembur->tgl_awal = $_GET['KPRealisasiLemburT']['tgl_awal'];
      $modRealisasiLembur->tgl_akhir = $_GET['KPRealisasiLemburT']['tgl_akhir'];
    } else {
      $modRealisasiLembur->tgl_awal = date('d M Y');
      $modRealisasiLembur->tgl_akhir = date('d M Y');
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(949);

    $this->render($this->path_view . 'informasi', array(
      'modRealisasiLembur' => $modRealisasiLembur, 'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * Untuk melihat detail transaksi rencana lembur
   */
  public function actionPrint($id = null)
  {
    $format = new MyFormatter;
    $modRealisasiLembur = KPRealisasiLemburT::model()->getModel($id);
    $modRealisasiLemburDetail = $modRealisasiLembur->detail;

    $modRealisasiLembur->tglrealisasi = $format->formatDateTimeId($modRealisasiLembur->tglrealisasi);


    $judul_print = 'Realisasi Lembur';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array(
        'format' => $format,
        'judulLaporan' => $judul_print,
        'modRealisasiLembur' => $modRealisasiLembur,
        'modRealisasiLemburDetail' => $modRealisasiLemburDetail,
        'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judulLaporan' => $judul_print,
      'modRealisasiLembur' => $modRealisasiLembur,
      'modRealisasiLemburDetail' => $modRealisasiLemburDetail,
      'caraPrint' => $caraPrint
    ));
  }

  /**
   * Untuk print
   */
  public function actionLihatDetail($id)
  {
    $this->layout = '//layouts/iframe';

    $modRealisasiLembur = KPRealisasiLemburT::model()->getModel($id);
    //            $modRealisasiLemburDetail = $modRealisasiLembur->detail;
    $modRealisasiLemburDetail = RealisasilemburdetT::model()->findAllByAttributes(array('realisasilembur_id' => $modRealisasiLembur->realisasilembur_id));

    $format = new MyFormatter;
    $modRealisasiLembur->tglrealisasi = $format->formatDateTimeId($modRealisasiLembur->tglrealisasi);

    $this->render($this->path_view . 'lihatdetail', array(
      'modRealisasiLembur' => $modRealisasiLembur, 'modDetail' => $modRealisasiLemburDetail,
      'norealisasi' => $modRealisasiLembur->norealisasi,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KPRealisasiLemburT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rencana-lembur-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrintRealisasi()
  {
    $model = new KPRealisasiLemburT;
    $model->attributes = $_REQUEST['KPRealisasiLemburT'];
    $judulLaporan = 'Data RealisasiLemburT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * Untuk transaksi rencana lembur pegawai
   */
  public function actionSetPegawaiLembur()
  {
    $tr = "";
    if (Yii::app()->request->isAjaxRequest) {

      $modRencanaLembur = new KPRencanaLemburT;
      $modRealisasiLembur = new KPRealisasiLemburT;
      $modRealisasiLemburDetail = new RealisasilemburT;
      if (!empty($_POST['pegawailembur_id'])) {
        $pegawailembur_id = $_POST['pegawailembur_id'];
        $modPegawai = PegawaiM::model()->findByPk($pegawailembur_id);
      } else if (!empty($_POST['nomorindukpegawai'])) {
        $nomorindukpegawaiPegawaiLembur = $_POST['nomorindukpegawai'];
        $modPegawai = PegawaiM::model()->findByAttributes(array('nomorindukpegawai' => $nomorindukpegawaiPegawaiLembur));
        $pegawailembur_id = $modPegawai->pegawai_id;
      }


      if (!empty($modPegawai->pegawai_id)) {
        $tr .= "<tr>
                           <td>" . CHtml::activeTextField($modRealisasiLemburDetail, '[' . $pegawailembur_id . ']nourut', array('class' => 'span1 no_urut', 'readonly' => TRUE)) .
          CHtml::activeHiddenField($modRealisasiLemburDetail, '[' . $pegawailembur_id . ']pegawai_id', array('value' => $modPegawai->pegawai_id, 'class' => 'karlemburNama')) .
          CHtml::activeHiddenField($modRealisasiLemburDetail, '[' . $pegawailembur_id . ']nomorindukpegawai', array('value' => $modPegawai->nomorindukpegawai, 'class' => 'karlemburNik')) .
          "</td>
                           <td>" . $modPegawai->nomorindukpegawai . "</td>
                           <td>" . $modPegawai->nama_pegawai . "</td>";      //<td>".$modPegawai->jabatan->jabatan_nama."</td>

        $tr .= "<td>" . CHtml::activetextField($modRealisasiLemburDetail, '[' . $pegawailembur_id . ']jamMulai', array('placeholder' => '00:00', 'class' => 'span1 detailRequired', 'readonly' => false, 'maxLength' => 5, 'onkeypress' => 'return $(this).focusNextInputField(event)', 'onblur' => 'checkTime(this);')) . "</td>";
        $tr .= "<td>" . CHtml::activetextField($modRealisasiLemburDetail, '[' . $pegawailembur_id . ']jamSelesai', array('placeholder' => '00:00', 'class' => 'span1', 'readonly' => false, 'maxLength' => 5, 'onkeypress' => 'return $(this).focusNextInputField(event)', 'onblur' => 'checkTime(this);')) . "</td>";

        $tr .= "        <td>" . CHtml::activetextField($modRealisasiLemburDetail, '[' . $pegawailembur_id . ']alasanlembur', array('class' => 'span3', 'readonly' => false, 'onkeypress' => 'return $(this).focusNextInputField(event)')) . "</td>
                           <td>" . CHtml::link("<span class='icon-remove'>&nbsp;</span>", '', array('href' => '', 'onclick' => 'hapusBaris(this); return false')) . "</td>
                        </tr>
                       ";

        $data['tr'] = $tr;
        echo json_encode($data);
        Yii::app()->end();
      } else {
        // Jika data pegawai salah
      }
    }
  }

  public function actionGetPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term_nip'])) {
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($_GET['term_nip']), true);
      }
      if (isset($_GET['term_nama'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term_nama']), true);
      }
      $criteria->addCondition("pegawai_aktif is TRUE");
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['pegawai_id'])) {
        if (!empty($_GET['pegawai_id'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
        }
      }
      $models = PegawaiM::model()->findAll($criteria);



      $returnVal = array();
      foreach ($models as $i => $model) {
        $cr = new CDbCriteria();
        $cr->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
        $cr->compare('t.pegawai_id', $model->pegawai_id);
        $cr->compare('k.komponengaji_kode', array('GP', 'TF', 'TJ'));
        $kom = KomponengajipegawaiM::model()->findAll($cr);

        $kom_total = 0;
        foreach ($kom as $item) {
          $kom_total += $item->nilaigaji;
        }

        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if (isset($_GET['term_nama'])) {
          $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama . " - " . $model->nomorindukpegawai;
          $returnVal[$i]['value'] = $model->pegawai_id;
          $returnVal[$i]['upah_bulanan'] = MyFormatter::formatNumberForPrint($kom_total);
        } else {
          $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
          $returnVal[$i]['value'] = $model->pegawai_id;
          $returnVal[$i]['upah_bulanan'] = MyFormatter::formatNumberForPrint($kom_total);
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadRencanaLembur()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $id = isset($_POST['rencanalembur_id']) ? $_POST['rencanalembur_id'] : null;

      $model = KPRencanaLemburT::model()->findByPk($id);
      $model->tglrencana = !empty($model->tglrencana)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tglrencana))):MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->create_time)));


      $modDetail = RencanalemburdetT::model()->findAll(" rencanalembur_id = '" . $id . "' ");
      $modPegawai = new KPPegawaiM();
      $modRealisasiLemburDetail = new RealisasilemburdetT();

      $tr = $this->renderPartial($this->path_view . '_rowRealisasiRencana', array('modRealisasiLemburDetail' => $modRealisasiLemburDetail, 'modRencanaLemburDetail' => $modDetail, 'modPegawai' => $modPegawai), true);

      $pegMengetahui = PegawaiM::model()->findByPk($model->mengetahui_id);
      $pegMenyetujui = PegawaiM::model()->findByPk($model->menyetujui_id);
      $pegPemberitugas = PegawaiM::model()->findByPk($model->pemberitugas_id);

      $data['tr'] = $tr;
      $data['sukses'] = 1;
      $data['rencana'] = $model->attributes;
      $data['rencana']['mengetahui_nama'] = isset($pegMengetahui) ? $pegMengetahui->namaLengkap : "";
      $data['rencana']['menyetujui_nama']  = isset($pegMenyetujui) ? $pegMenyetujui->namaLengkap : "";
      $data['rencana']['pemberitugas_nama']  = isset($pegPemberitugas) ? $pegPemberitugas->namaLengkap : "";

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function actionHapusRealisasiLembur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $id = isset($_POST['id']) ? $_POST['id'] : null;

      $model = KPRealisasiLemburT::model()->findByPk($id);

      try {
        if (isset($model)) {
          $sukses = false;
          $deleteDetail = true;
          $modupdate = KPRencanaLemburT::model()->updateByPk($model->rencanalembur_id, array('realisasilembur_id' => null));

          $modDet = RealisasilemburdetT::model()->findAllByAttributes(array('realisasilembur_id' => $model->realisasilembur_id));

          if (isset($modDet) && count((array)$modDet) > 0) {
            $deleteDetail = RealisasilemburdetT::model()->deleteAllByAttributes(array('realisasilembur_id' => $model->realisasilembur_id));
          }

          $deleteRealisasi = KPRealisasiLemburT::model()->deleteByPk($model->realisasilembur_id);

          if ($deleteDetail && $deleteRealisasi && $modupdate) {
            $sukses = true;
          }

          if ($sukses) {
            $keterangan = "Data Berhasil Dibatalkan! ";
            $status = 'ok';
            $transaction->commit();
          } else {
            $keterangan = "Data Gagal Dibatalkan! ";
            $status = 'not';
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        $keterangan = "Data Gagal Dibatalkan! " . print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
