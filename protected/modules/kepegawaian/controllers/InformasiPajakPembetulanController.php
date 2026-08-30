<?php
class InformasiPajakPembetulanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  /**
   * Informasi Rencana Pelatihan
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pajak Dan Pembetulan";
    $model = new KPPenggajianpegT();
    $model->tglpenggajian = date('Y-m-d');

    if (isset($_GET['KPPenggajianpegT'])) {
      $model->attributes = $_GET['KPPenggajianpegT'];
      $model->tglpenggajian = MyFormatter::formatDateTimeForDb($_GET['KPPenggajianpegT']['tglpenggajian']);
      $model->nama_pegawai = isset($_GET['KPPenggajianpegT']['nama_pegawai']) ? $_GET['KPPenggajianpegT']['nama_pegawai'] : null;
    }

    $this->render('index', array('model' => $model));
  }

  public function actionPembetulanPph($penggajianpeg_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);
    $model = new KPPembetulanpajakT();
    $model->tglpajak = MyFormatter::formatDateTimeForUser($modelpeg->tglpenggajian);
    $model->jml_pph = $modelpeg->pph21perbulan;
    $model->jml_bruto = $modelpeg->totalterima;

    $modPembetulanKe = KPPembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $modelpeg->pegawai_id, 'tglpajak' => $modelpeg->tglpenggajian));
    if (count((array)$modPembetulanKe) > 0) {
      $countrevisi = count((array)$modPembetulanKe) + 1;
      $model->pembetulanke = $countrevisi;
    } else {
      $model->pembetulanke = 1;
    }

    if (isset($_POST['KPPembetulanpajakT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //                 $model = new AGRevisicpaT();
        $model->attributes = $_POST['KPPembetulanpajakT'];
        $model->tglpembetulan = $format->formatDateTimeForDb($_POST['KPPembetulanpajakT']['tglpembetulan']);
        $model->pegawai_id = $modelpeg->pegawai_id;
        $model->tglpajak = $modelpeg->tglpenggajian;

        $model->create_time = date('Y-m-d h:i:s');
        $model->create_user = Yii::app()->user->getState('nama_pegawai');;
        $model->create_ruanganid = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          if ($model->save()) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $this->redirect(array('pembetulanPph', 'penggajianpeg_id' => $modelpeg->penggajianpeg_id, 'pembetulanpajak_id' => $model->pembetulanpajak_id, 'sukses' => 1));
          }
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('pembetulanPph', array(
      'format' => $format,
      'modelpeg' => $modelpeg,
      'model' => $model,
    ));
  }

  public function actionPrintPembetulan($id, $penggajianpeg_id = null)
  {
    $format = new MyFormatter();

    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

    $model = KPPembetulanpajakT::model()->findByPk($id);
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);

    //            $modelpegawai = GJPegawaiM::model()->findByPk($model->pegawai_id);


    //        $crkom = new CDbCriteria;
    //        $crkom->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    //        $crkom->compare('t.penggajianpeg_id', $penggajianpeg_id);
    //        $crkom->order = 'k.ispotongan asc, t.penggajiankomp_id';
    //        
    //        
    //        $kom = PenggajiankompT::model()->findAll($crkom);
    //
    //        if (empty($model)) {
    //            $model = new PenggajianpegT;                        
    //        }
    //                $modelpegawai->jabatan_nama = isset($modelpegawai->jabatan_id)?$modelpegawai->jabatan->jabatan_nama:"";
    //                $model->totalterima = number_format($model->totalterima,0,"",".");
    //                $model->totalpotongan = number_format($model->totalpotongan,0,"",".");
    //                $model->penerimaanbersih = number_format($model->penerimaanbersih,0,"",".");
    //                $model->totalpajak = number_format($model->totalpajak,0,"",".");

    $judulLaporan = 'Pembetulan PPH 21';
    //		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpajak);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('format' => $format, 'model' => $model, 'modelpeg' => $modelpeg, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('format' => $format, 'model' => $model, 'modelpeg' => $modelpeg, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('format' => $format, 'model' => $model, 'modelpeg' => $modelpeg, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionExportCSV($id, $penggajianpeg_id = null)
  {

    $model = KPPembetulanpajakT::model()->findByPk($id);
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);
    $a = array('name' => '');
    $content = "";
    $content .= 'Masa Pajak, Tahun Pajak, Pembetulan Ke, NPWP, Nama, Kode Objek Pajak, Jumlah Bruto, Jumlah PPH, Jumlah Pembetulan, Kode Negara';
    $content .= "\n";
    $bulanpajak = !empty($model->tglpajak) ? date("n", strtotime(MyFormatter::formatDateTimeForDb($model->tglpajak))) : "-";
    $tahunpajak = !empty($model->tglpajak) ? date("Y", strtotime(MyFormatter::formatDateTimeForDb($model->tglpajak))) : "-";
    $pembetulanke = $model->pembetulanke;
    $npwp = isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->npwp : "";
    $namalengkap = isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->namaLengkap : "";
    //       $kodetkp = $modelpeg->kodeptkp;
    $kodetkp = isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->kode_objekpajak : "";
    $totalterima = $modelpeg->totalterima;
    $pph21bulan = $modelpeg->pph21perbulan;
    $jmpembetulan = $model->jmlpembetulan;



    $content .= $bulanpajak . ',' . $tahunpajak . ',' . $pembetulanke . ',' . $npwp . ',' . $namalengkap . ',' . $kodetkp . ',' . $totalterima . ',' . $pph21bulan . ',' . $jmpembetulan;

    $judul = "Template CSV";

    Yii::app()->getRequest()->sendFile($judul . '-' . date("Y/m/d") . '.csv', $content, "text/csv", false);
    die;
  }

  public function actionExportInformasiCSV()
  {
    $content = "";
    $content .= 'Masa Pajak;Tahun Pajak;Pembetulan;NPWP;Nama;Kode Pajak;Jumlah Bruto;Jumlah PPh;Kode Negara';
    $judul = "Informasi Pajak dan Pembetulan Non PPh";

    $tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPPenggajianpegT']['tglpenggajian']);
    $tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPPenggajianpegT']['tglpenggajian']);
    $nama_pegawai = isset($_GET['KPPenggajianpegT']['KPPenggajianpegT']) ? $_GET['KPPenggajianpegT']['nama_pegawai'] : null;
    $periodegaji = isset($_GET['KPPenggajianpegT']['periodegaji']) ? $_GET['KPPenggajianpegT']['periodegaji'] : null;

    $criteria = new CDbCriteria;
    $criteria->with = 'pegawai';
    $criteria->addBetweenCondition('DATE(tglpenggajian)', $tgl_awal, $tgl_akhir);
    $criteria->compare('LOWER(pegawai.nama_pegawai)', strtolower($nama_pegawai), true);
    if (isset($_GET['pph'])) {
      if (!empty($_GET['pph'])) {
        $judul = "Informasi Pajak dan Pembetulan PPh";
        $criteria->addCondition('pph21perbulan > 0');
      } else {
        $criteria->addCondition('pph21perbulan = 0');
      }
    } else {
      $criteria->addCondition('pph21perbulan = 0');
    }

    $criteria->order = "pegawai.nama_pegawai";
    $modInformasi = KPPenggajianpegT::model()->findAll($criteria);
    if (!empty($modInformasi)) {
      $pembetulanke = 0;
      $indexCek = 0;
      foreach ($modInformasi as $key => $val) {
        $model = KPPembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $val->pegawai_id, 'tglpajak' => $val->tglpenggajian));

        if (count((array)$model) > 0) {
          $indexCek++;
        } else {
          if ($indexCek > 1) {
            $indexCek--;
          }
        }
      }

      if ($indexCek > 0) {
        $pembetulanke = 1;
      }

      foreach ($modInformasi as $key => $val) {

        $peg = PegawaiM::model()->findByPk($val->pegawai_id);

        $content .= "\n";

        //                $pembetulanke = 0;
        $jmpembetulan = 0;
        //                $model = KPPembetulanpajakT::model()->findByAttributes(array('pegawai_id'=>$val->pegawai_id,'tglpajak'=>$val->tglpenggajian));
        $model = KPPembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $val->pegawai_id, 'tglpajak' => $val->tglpenggajian));

        if (count((array)$model) > 0) {
          //                    $pembetulanke = 1;
          foreach ($model as $dtPembetulan) {
            //                        $pembetulanke = $dtPembetulan->pembetulanke;
            $jmpembetulan = $dtPembetulan->jmlpembetulan;
          }
        }
        //                if(!empty($model)){
        //                    $pembetulanke = $model->pembetulanke;
        //                    $jmpembetulan = $model->jmlpembetulan;
        //                }

        $kode_negara = (empty($peg->kode_negara) || trim($peg->kode_negara) == "") ? "" : $peg->kode_negara;
        $bulanpajak = !empty($val->tglpenggajian) ? date("n", strtotime(MyFormatter::formatDateTimeForDb($val->tglpenggajian))) : "-";
        $tahunpajak = !empty($val->tglpenggajian) ? date("Y", strtotime(MyFormatter::formatDateTimeForDb($val->tglpenggajian))) : "-";
        $npwp = isset($val->pegawai_id) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $val->pegawai->npwp) . '"' : "";
        $namalengkap = isset($val->pegawai_id) ? '"' . $val->pegawai->nama_pegawai . '"' : "";
        $kodetkp = isset($val->pegawai_id) ? $val->pegawai->kode_objekpajak : "";
        $totalterima = $val->totalterima;
        $pph21bulan = $val->pph21perbulan;


        $content .= $bulanpajak . ';' . $tahunpajak . ';' . $pembetulanke . ';' . $npwp . ';' . $namalengkap . ';' . $kodetkp . ';' . $totalterima . ';' . $pph21bulan . ';' . $kode_negara;
      }
    }



    Yii::app()->getRequest()->sendFile($judul . '-' . date("Y/m/d") . '.csv', $content, "text/csv", false);
    die;
  }

  public function actionRincian($penggajianpeg_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);
    $model = KPPembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $modelpeg->pegawai_id, 'tglpajak' => $modelpeg->tglpenggajian));
    $this->render('rincian', array(
      'format' => $format,
      'modelpeg' => $modelpeg,
      'model' => $model,
    ));
  }

  public function actionPrintRincian($penggajianpeg_id)
  {
    $format = new MyFormatter();
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);
    $model = KPPembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $modelpeg->pegawai_id, 'tglpajak' => $modelpeg->tglpenggajian));
    $judulLaporan = 'Pembetulan PPH 21';

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('PrintRincian', array('format' => $format, 'model' => $model, 'modelpeg' => $modelpeg, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('PrintRincian', array('format' => $format, 'model' => $model, 'modelpeg' => $modelpeg, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('PrintRincian', array('format' => $format, 'model' => $model, 'modelpeg' => $modelpeg, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionExportRincianCSV($penggajianpeg_id)
  {
    $format = new MyFormatter();
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);
    $model = KPPembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $modelpeg->pegawai_id, 'tglpajak' => $modelpeg->tglpenggajian));
    $a = array('name' => '');
    $content = "";
    $content .= 'Masa Pajak; Tahun Pajak; Pembetulan Ke; NPWP; Nama; Kode Objek Pajak; Jumlah Bruto; Jumlah PPH; Jumlah Pembetulan; Kode Negara';
    $content .= "\n";
    foreach ($model as $key => $val) {
      $bulanpajak = !empty($val->tglpajak) ? date("n", strtotime($format->formatDateTimeForDb($val->tglpajak))) : "-";
      $tahunpajak = !empty($val->tglpajak) ? date("Y", strtotime($format->formatDateTimeForDb($val->tglpajak))) : "-";
      $pembetulanke = $val->pembetulanke;
      $npwp = isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->npwp : "";
      $namalengkap = isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->namaLengkap : "";
      //            $kodetkp = $modelpeg->kodeptkp;
      $kodetkp = isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->kode_objekpajak : "";
      $totalterima = $modelpeg->totalterima;
      $pph21bulan = $modelpeg->pph21perbulan;
      $jmpembetulan = $val->jmlpembetulan;
      $content .= $bulanpajak . ';' . $tahunpajak . ';' . $pembetulanke . ';' . $npwp . ';' . $namalengkap . ';' . $kodetkp . ';' . $totalterima . ';' . $pph21bulan . ';' . $jmpembetulan;
      $content .= "\n";
    }

    $judul = "Template CSV";
    Yii::app()->getRequest()->sendFile($judul . '-' . date("Y/m/d") . '.csv', $content, "text/csv", false);
    die;
  }

  public function actionFormulir($penggajianpeg_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modelpeg = KPPenggajianpegT::model()->findByPk($penggajianpeg_id);
    $model = KPPembetulanpajakT::model()->findAllByAttributes(array('pegawai_id' => $modelpeg->pegawai_id, 'tglpajak' => $modelpeg->tglpenggajian));
    $modPem = new PegawaiM();
    if (!empty($modelpeg->pemotong_id)) {
      $modPem = PegawaiM::model()->findByPk($modelpeg->pemotong_id);
    }
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('formulir', array(
        'format' => $format,
        'modelpeg' => $modelpeg,
        'model' => $model,
        'modPem' => $modPem,
        'profil' => $profil,
        'caraPrint' => $caraPrint,
      ));
    } else {
      $this->render('formulir', array(
        'format' => $format,
        'modelpeg' => $modelpeg,
        'model' => $model,
        'modPem' => $modPem,
        'profil' => $profil,
      ));
    }
  }

  public function actionFormulirPrint()
  {

    $format = new MyFormatter();
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);

    $pegawai_id = $_GET['pegawai_id'];
    $tahun = $_GET['tahun'];
    $masa_1 = $_GET['masa_1'];
    $masa_2 = $_GET['masa_2'];
    $tgl_penggajian = isset($_GET['tglpenggajian']) ? $format->formatDateTimeForDb($_GET['tglpenggajian']) : null;
    $pemotong_id = isset($_GET['pemotong_id']) ? $_GET['pemotong_id'] : null;
    $penggajianpeg_id = $_GET['penggajianpeg_id'];
    PenggajianpegT::model()->updateByPk($penggajianpeg_id, array('pemotong_id' => $pemotong_id, 'tglpenggajian' => $tgl_penggajian));

    $tglAwal = $tahun . '-' . $masa_1 . '-01';
    $caritglakhir = $tahun . '-' . $masa_2 . '-01';
    $tglAkhir = date("Y-m-t", strtotime($caritglakhir));

    $criteria = new CDbCriteria;
    $criteria->addBetweenCondition('DATE(periodegaji)', $tglAwal, $tglAkhir);
    $criteria->addCondition('pegawai_id = ' . $pegawai_id);
    $modelpeg = KPPenggajianpegT::model()->findAll($criteria);
    $modGaji = new KPPenggajianpegT();



    $modPegawai = PegawaiM::model()->findByPk($pegawai_id);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('formulirPrint', array(
        'format' => $format,
        'modelpeg' => $modelpeg,
        'modGaji' => $modGaji,
        'profil' => $profil,
        'masa_1' => $masa_1,
        'masa_2' => $masa_2,
        'modPegawai' => $modPegawai,
        'caraPrint' => $caraPrint,
      ));
    }
  }

  public function actionSetFormulir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pegawai_id = $_POST['pegawai_id'];
      $tahun = $_POST['tahun'];
      $masa_1 = $_POST['masa_1'];
      $masa_2 = $_POST['masa_2'];

      $tglAwal = $tahun . '-' . $masa_1 . '-01';
      $caritglakhir = $tahun . '-' . $masa_2 . '-01';
      $tglAkhir = date("Y-m-t", strtotime($caritglakhir));

      $data = array();
      $data['status'] = '';

      $criteria = new CDbCriteria;
      $criteria->addBetweenCondition('DATE(periodegaji)', $tglAwal, $tglAkhir);
      $criteria->addCondition('pegawai_id = ' . $pegawai_id);
      $modelpeg = KPPenggajianpegT::model()->findAll($criteria);
      $modGaji = new KPPenggajianpegT();

      $data['no_1'] = 0;
      $data['no_2'] = 0;
      $data['no_3'] = 0;
      $data['no_4'] = 0;
      $data['no_5'] = 0;
      $data['no_6'] = 0;
      $data['no_7'] = 0;
      $data['no_8'] = 0;
      $data['no_9'] = 0;
      $data['no_10'] = 0;
      $data['no_11'] = 0;
      $data['no_12'] = 0;
      $data['no_13'] = 0;
      $data['no_14'] = 0;
      $data['no_15'] = 0;
      $data['no_16'] = 0;
      $data['no_17'] = 0;
      $data['no_18'] = 0;
      $data['no_19'] = 0;
      $data['no_20'] = 0;
      foreach ($modelpeg as $key => $val) {
        $data['no_1'] += $val->gajipokok;
        $data['no_2'] += $val->pph21perbulan;

        $fungsional = $modGaji->fungsional($val->penggajianpeg_id);
        $lembur = $modGaji->lembur($val->penggajianpeg_id);
        $data['no_3'] += ($fungsional + $lembur);

        $data['no_5'] += $val->premiasuransi;

        $bonus = $modGaji->bonus($val->penggajianpeg_id);
        $thr = $modGaji->thr($val->penggajianpeg_id);
        $data['no_7'] += ($bonus + $thr);

        $data['no_9'] += $val->biayajabatan;
        $data['no_10'] += ($val->potonganpensiun + $val->jaminanpensiun + $val->bpjskesehatan);
        $data['no_15'] += $val->ptkppertahun;
        $data['no_17'] += $val->pph21perbulan;
        $data['no_19'] += $val->pph21perbulan;
        $data['no_20'] += $val->pph21perbulan;
      }

      $data['no_8'] = $data['no_1'] + $data['no_2'] + $data['no_3'] + $data['no_4'] + $data['no_5'] + $data['no_6'] + $data['no_7'];
      $data['no_11'] = $data['no_9'] + $data['no_10'];
      $data['no_12'] = $data['no_8'] - $data['no_11'];
      $data['no_14'] = $data['no_12'];
      $data['no_16'] = $data['no_14'] - $data['no_15'];
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
