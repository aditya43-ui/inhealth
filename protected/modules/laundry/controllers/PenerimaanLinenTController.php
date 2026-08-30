<?php

/**
 * controller utama untuk mengakses fungsi - fungsi pada transaksi penerimaan linen
 * 
 * @package application.modules.laundry
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class PenerimaanLinenTController extends MyAuthController
{
  //public $layout = '//layouts/column1';
  public $penerimaanLinen = false;
  public $penerimaanLinenDet = true;
  public $path_view = 'laundry.views.penerimaanLinenT.';

  /**
   * action ini digunakan untuk masuk ke menu penerimaan linen
   * @param type $id
   */
  public function actionIndex($id = null, $pengperawatanlinen_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Linen";
    $format = new MyFormatter;

    $modDetails = array();
    $modPengajuan = new LAPengperawatanlinenT;
    //load header
    if (!empty($id)) {
      $model = LAPenerimaanlinenT::model()->findByPk($id);
      $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id')), 'ruangan_aktif = true');
      $model->instalasi_nama = $modRuangan->instalasi->instalasi_nama;
      $model->ruangan_nama = $modRuangan->ruangan_nama;
      $model->ruangan_id = $modRuangan->ruangan_id;
      $model->tglpenerimaanlinen = MyFormatter::formatDateTimeForUser($model->tglpenerimaanlinen);
      $pegawaiMenerima = PegawaiM::model()->findByPk($model->pegmenerima_id);
      $pegawaiMengetahui = PegawaiM::model()->findByPk($model->pegmengetahui_id);
      if ($pegawaiMenerima != NULL) {
        $model->pegmenerima_nama = $pegawaiMenerima->nama_pegawai;
      } else {
        $model->pegmenerima_nama = '-';
      }
      if ($pegawaiMengetahui != NULL) {
        $model->pegmengetahui_nama = $pegawaiMengetahui->nama_pegawai;
      } else {
        $model->pegmengetahui_nama = '-';
      }
      $modPengajuan = LAPengperawatanlinenT::model()->findByPk($model->pengperawatanlinen_id);
      $model->pengperawatanlinen_no = $modPengajuan->pengperawatanlinen_no;
      // load detail
      $modPengajuanDetail = LAPenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id' => $model->penerimaanlinen_id));
    } else {
      if (!empty($pengperawatanlinen_id)) {
        $modPengajuan = LAPengperawatanlinenT::model()->findByPk($pengperawatanlinen_id);
        $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id' => $modPengajuan->ruangan_id));
        $model = new LAPenerimaanlinenT;
        $model->pengperawatanlinen_id = $pengperawatanlinen_id;
        $model->nopenerimaanlinen = '-- Otomatis --';
        $model->instalasi_nama = $modRuangan->instalasi->instalasi_nama;
        $model->ruangan_nama = $modRuangan->ruangan_nama;
        $model->ruangan_id = $modRuangan->ruangan_id;
        $model->keterangan_penerimaanlinen = $modPengajuan->keterangan_pengperawatanlinen;
        $pegawaiMengetahui = PegawaiM::model()->findByPk($modPengajuan->mengetahui_id);
        $pegawaiMenerima = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if ($pegawaiMengetahui != NULL) {
          $model->pegmengetahui_id = $modPengajuan->mengetahui_id;
          $model->pegawaimengetahui_nama = $pegawaiMengetahui->namaLengkap;
        } else {
          $model->pegmengetahui_id = null;
          $model->pegawaimengetahui_nama = null;
        }
        $model->pengperawatanlinen_no = $modPengajuan->pengperawatanlinen_no;
        $model->pegawaimenerima_nama = $pegawaiMenerima->namaLengkap;
        $model->pegmenerima_id = Yii::app()->user->getState("pegawai_id");

        // load detail
        $modPengajuanDetail = LAPengperawatanlinendetT::model()->findAllByAttributes(array('pengperawatanlinen_id' => $modPengajuan->pengperawatanlinen_id));
      } else {
        $model = new LAPenerimaanlinenT;
        $model->nopenerimaanlinen = "-- Otomatis --";
        $pegawaiMenerima = PegawaiM::model()->findByPk(Yii::app()->user->getState("pegawai_id"));
        $model->instalasi_nama = Yii::app()->user->getState("instalasi_nama");
        $model->pegawaimenerima_nama = $pegawaiMenerima->namaLengkap;
        $model->pegmenerima_id = Yii::app()->user->getState("pegawai_id");
        $model->ruangan_nama = Yii::app()->user->getState("ruangan_nama");
        $model->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modPengajuanDetail = null;
      }
    }

    $modDetails = array();
    if (isset($_POST['LAPenerimaanlinenT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPenerimaan = new LAPenerimaanlinenT;
        $modPenerimaan->attributes = $_POST['LAPenerimaanlinenT'];
        //				$modPenerimaan->ruangan_id = Yii::app()->user->ruangan_id;
        $modPenerimaan->tglpenerimaanlinen = $format->formatDateTimeForDb($_POST['LAPenerimaanlinenT']['tglpenerimaanlinen']);
        $modPenerimaan->create_time = date("Y-m-d H:i:s");
        $modPenerimaan->create_loginpemakai_id = Yii::app()->user->id;
        $modPenerimaan->create_ruangan = Yii::app()->user->ruangan_id;
        $modPenerimaan->nopenerimaanlinen = MyGenerator::noPenerimaanLinen();
        $modPenerimaan->pengperawatanlinen_id = $_POST['LAPenerimaanlinenT']['pengperawatanlinen_id'];

        if ($modPenerimaan->save()) {
          $this->penerimaanLinen = true;
          if (count((array)$_POST['LAPengperawatanlinendetT']) > 0) {
            foreach ($_POST['LAPengperawatanlinendetT'] as $i => $postPengajuanDet) {
              $modDetail = new LAPenerimaanlinendetailT;
              $modDetail->attributes = $postPengajuanDet;
              $modDetail->linen_id = $postPengajuanDet['linen_id'];
              $modDetail->jenisperawatanlinen = $postPengajuanDet['jenisperawatan'];
              $modDetail->keterangan_penerimaanlinen = $postPengajuanDet['keterangan_pengperawatan'];
              $modDetail->jumlah = $postPengajuanDet['jumlah'];
              $modDetail->penerimaanlinen_id = $modPenerimaan->penerimaanlinen_id;
              $modDetail->save();
              if ($modDetail->save()) {
                $this->penerimaanLinenDet &= true;
              } else {
                $this->penerimaanLinenDet &= false;
              }
            }
          }
        }

        $this->notifPenerimaanLinen($modPenerimaan);

        if ($this->penerimaanLinen && $this->penerimaanLinenDet) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $modPenerimaan->penerimaanlinen_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Penerimaan Linen gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penerimaan Linen gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format, 'modPengajuanDetail' => $modPengajuanDetail, 'modPengajuan' => $modPengajuan
    ));
  }

  public function notifPenerimaanLinen($model)
  {


    $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
    $tujuan = RuanganM::model()->findByPk($model->ruangan_id);

    $judul = "Penerimaan Linen";
    $isi_asal = "Tgl. Penerimaan : " . MyFormatter::formatDateTimeForuser($model->tglpenerimaanlinen) . '<br/>';
    $isi_asal .= "No. Penerimaan : " . $model->nopenerimaanlinen . '<br/>';
    $isi_asal .= "Ruangan {posisi} : {ruangan}<br/>";
    $isi_asal .= "Keterangan : " . $model->keterangan_penerimaanlinen . '<br/>';

    $isi_tujuan = $isi_asal;

    $isi_tujuan = str_replace("{ruangan}", $ruangan->ruangan_nama, $isi_tujuan);
    $isi_tujuan = str_replace("{posisi}", 'Penerima', $isi_tujuan);
    $isi_asal = str_replace("{ruangan}", $tujuan->ruangan_nama, $isi_asal);
    $isi_asal = str_replace("{posisi}", 'Pengirim', $isi_asal);

    $ok = CustomFunction::broadcastNotif($judul, $isi_asal, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
    ));
    $ok = CustomFunction::broadcastNotif($judul, $isi_tujuan, array(
      array('instalasi_id' => $tujuan->instalasi_id, 'ruangan_id' => $tujuan->ruangan_id, 'modul_id' => $tujuan->modul_id),
    ));
  }

  /**
   * mengenerate data pegawai, sesuai yang diketikkan
   */
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

  /**
   * mengenerate data pegawai, sesuai yang diketikkan
   */
  public function actionAutocompletePegawaiMerima()
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
      $criteria->order = 't.linen_id';
      $models = LALinenM::model()->findAll($criteria);
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
      $criteria->compare('LOWER(t.noregisterlinen)', strtolower($_GET['term']), true);
      $criteria->order = 't.linen_id';
      $models = LALinenM::model()->findAll($criteria);
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
   * mengenerate prinout
   * @param type $penerimaanlinen_id
   * @param type $caraPrint
   */
  public function actionPrint($penerimaanlinen_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenerimaanLinen = LAPenerimaanlinenT::model()->findByPk($penerimaanlinen_id);
    $modPenerimaanLinenDetail = LAPenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id' => $penerimaanlinen_id));

    $judul_print = 'Penerimaan Linen';
    $deskripsi = $format->formatDateTimeForUser($modPenerimaanLinen->tglpenerimaanlinen);
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('format' => $format, 'judul_print' => $judul_print, 'deskripsi' => $deskripsi, 'modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
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

      $format = new MyFormatter();
      $modLinen = LALinenM::model()->findByPk($linen_id);
      $modDetail = new LAPenerimaanlinendetailT;
      $modDetail->linen_id = $modLinen->linen_id;;
      $modDetail->jenisperawatanlinen = $jenisperawatan;
      $modDetail->keterangan_penerimaanlinen = $keterangan_pengperawatan;
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
   * load data pengajuan
   */
  public function actionGetDataPengajuan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pengajuanperawatan_id = isset($_POST['pengajuanperawatan_id']) ? $_POST['pengajuanperawatan_id'] : null;
      $form2 = "";
      $form = "";
      $pesan = "";
      if ($pengajuanperawatan_id) {
        $modDetail = LAPengperawatanlinendetT::model()->findAllByAttributes(array('pengperawatanlinen_id' => $pengajuanperawatan_id));
        $form = $this->renderPartial('_tabelPengajuanLinen', array('modDetail' => $modDetail, 'form' => $form2), true);
      } else {
        $pesan = "data linen tidak ada!";
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }
}
