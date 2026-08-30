<?php

class PengajuanPerawatanTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'laundry.views.pengajuanPerawatanT.';
  public $pengPeratawan = false;
  public $pengPeratawanDet = true;

  public function actionIndex($pengperawatanlinen_id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Perawatan";
    $format = new MyFormatter;
    if (isset($pengperawatanlinen_id)) {
      $model = LAPengperawatanlinenT::model()->findByPk($pengperawatanlinen_id);
      $model->pegawaimengajukan_nama = isset($model->mengajukan_id) ? $model->pegawaiMengajukan->nama_pegawai : '';
      $model->pegawaimengetahui_nama = isset($model->mengetahui_id) ? $model->pegawai->nama_pegawai : '';
    } else {
      $model = new LAPengperawatanlinenT;
      $model->pengperawatanlinen_no = MyGenerator::noPengPerawatanLinen();
    }

    $modDetails = array();
    $modDetail = new LAPengperawatanlinendetT;
    if (isset($_POST['LAPengperawatanlinenT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['LAPengperawatanlinenT'];
        $model->ruangan_id = Yii::app()->user->ruangan_id;
        $model->tglpengperawatanlinen = $format->formatDateTimeForDb($_POST['LAPengperawatanlinenT']['tglpengperawatanlinen']);
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        if ($model->save()) {
          $this->pengPeratawan = true;
          if (count((array)$_POST['LAPengperawatanlinendetT']) > 0) {
            foreach ($_POST['LAPengperawatanlinendetT'] as $i => $postPengPerLinenDet) {
              $modDetails[$i] = $this->simpanPengPerawatanLinenDet($model, $postPengPerLinenDet);
            }
          }
        }

        $this->notifPengajuanPerawatan($model);

        if ($this->pengPeratawan && $this->pengPeratawanDet) {
          $transaction->commit();
          $this->redirect(array('index', 'pengperawatanlinen_id' => $model->pengperawatanlinen_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pengajuan Perawatan Linen gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pengajuan Perawatan Linen gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(2515);

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format, 'linkHalaman' => $linkHalaman
    ));
  }

  public function notifPengajuanPerawatan($model)
  {

    $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
    $tujuan = RuanganM::model()->findByPk(Params::RUANGAN_ID_LAUNDRY);

    $judul = "Pengajuan Perawatan Linen";
    $isi = "Tgl. Pengajuan : " . MyFormatter::formatDateTimeForuser($model->tglpengperawatanlinen) . '<br/>';
    $isi .= "No. Pengajuan : " . $model->pengperawatanlinen_no . '<br/>';
    $isi .= "Ruangan Pengajuan : " . $ruangan->ruangan_nama . '<br/>';
    $isi .= "Keterangan : " . $model->keterangan_pengperawatanlinen . '<br/>';

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      array('instalasi_id' => $tujuan->instalasi_id, 'ruangan_id' => $tujuan->ruangan_id, 'modul_id' => $tujuan->modul_id),
    ));
  }

  /**
   * simpan LAPengperawatanlinendetT
   * @param type $model
   * @param type $post
   * @return LAPengperawatanlinendetT
   */
  public function simpanPengPerawatanLinenDet($model, $post)
  {
    $format = new MyFormatter();
    $modDetail = new LAPengperawatanlinendetT;
    $modDetail->attributes = $post;
    $modDetail->jumlah = $post['jumlah'];
    $modDetail->pengperawatanlinen_id = $model->pengperawatanlinen_id;
    if ($modDetail->save()) {
      $this->pengPeratawanDet &= true;
    } else {
      $this->pengPeratawanDet &= false;
    }
    return $modDetail;
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LAPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompletePegawaiMengajukan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LAPegawaiV::model()->findAll($criteria);
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

  /*
     * untuk mencari linen melalui autocomplete
     */

  public function actionAutocompleteLinen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.namalinen)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = LALinenM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->namalinen;
        $returnVal[$i]['value'] = $model->linen_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /*
     * untuk mencari register linen melalui autocomplete
     */

  public function actionAutocompleteRegisterLinen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $noregisterlinen = isset($_GET['noregisterlinen']) ? $_GET['noregisterlinen'] : null;
      $namalinen = isset($_GET['namalinen']) ? $_GET['namalinen'] : null;
      $criteria->compare('LOWER(t.noregisterlinen)', strtolower($noregisterlinen), true);
      $criteria->compare('LOWER(t.namalinen)', strtolower($namalinen), true);
      $criteria->limit = 5;
      $models = LALinenM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->noregisterlinen;
        $returnVal[$i]['value'] = $model->linen_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan rencana anggaran pengeluaran detail
   * @return row table 
   */
  public function actionLoadFormLine()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $noregisterlinen = $_POST['noregisterlinen'];
      $linen_id = $_POST['linen_id'];
      $jenisperawatan = $_POST['jenisperawatan'];
      $keterangan_pengperawatan = $_POST['keterangan_pengperawatan'];
      $jumlah = $_POST['jumlah'];

      $format = new MyFormatter();
      $modLinen = LALinenM::model()->findByPk($linen_id);
      $modDetail = new LAPengperawatanlinendetT;
      $modDetail->linen_id = $modLinen->linen_id;;
      $modDetail->jenisperawatan = $jenisperawatan;
      $modDetail->keterangan_pengperawatan = $keterangan_pengperawatan;
      $modDetail->jumlah = $jumlah;
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial($this->path_view . '_rowLinen', array(
            'format' => $format,
            'modLinen' => $modLinen,
            'modDetail' => $modDetail,
          ), true)
        )
      );
      exit;
    }
  }

  /**
   * untuk print data pengajuan perawatan
   */
  public function actionPrint($pengperawatanlinen_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPengPerawataninen = LAPengperawatanlinenT::model()->findByPk($pengperawatanlinen_id);
    $modPengPerawataninenDetail = LAPengperawatanlinendetT::model()->findAllByAttributes(array('pengperawatanlinen_id' => $pengperawatanlinen_id));

    $judul_print = 'Pengajuan Perawatan Linen';
    $deskripsi = $format->formatDateTimeForUser($modPengPerawataninen->tglpengperawatanlinen);
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPengPerawataninen' => $modPengPerawataninen, 'modPengPerawataninenDetail' => $modPengPerawataninenDetail, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPengPerawataninen' => $modPengPerawataninen, 'modPengPerawataninenDetail' => $modPengPerawataninenDetail, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPengPerawataninen' => $modPengPerawataninen, 'modPengPerawataninenDetail' => $modPengPerawataninenDetail, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
