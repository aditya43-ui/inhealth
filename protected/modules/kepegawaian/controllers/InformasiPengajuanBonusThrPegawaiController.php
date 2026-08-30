<?php
class InformasiPengajuanBonusThrPegawaiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'kepegawaian.views.informasiPengajuanBonusThrPegawai.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Bonus/ Thr Pegawai";
    $format = new MyFormatter();
    $model = new KPInfobonusthrpegawaiV();
    $model->periodebonusthr = date('Y-m');

    if (isset($_GET['KPInfobonusthrpegawaiV'])) {
      $model->attributes = $_GET['KPInfobonusthrpegawaiV'];
      $model->periodebonusthr = MyFormatter::formatMonthForDB($model->periodebonusthr);
      $model->ruangan_id = (isset($_GET['KPInfobonusthrpegawaiV']['ruangan_id']) ? $_GET['KPInfobonusthrpegawaiV']['ruangan_id'] : null);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format,
    ));
  }

  public function actionbatalPengajuan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pengbonusthrdetail_id = isset($_POST['pengbonusthrdetail_id']) ? $_POST['pengbonusthrdetail_id'] : null;
        $pengbonusthr_id = isset($_POST['pengbonusthr_id']) ? $_POST['pengbonusthr_id'] : null;

        $pesan = '';
        $status = false;
        $modDelete = PengbonusthrdetailT::model()->deleteByPk($pengbonusthrdetail_id);

        if ($modDelete) {
          $modDetail = PengbonusthrdetailT::model()->findAllByAttributes(array('pengbonusthr_id' => $pengbonusthr_id));

          if (count((array)$modDetail) == 0) {
            $modDelPengajuan = PengbonusthrT::model()->deleteByPk($pengbonusthr_id);

            if ($modDelPengajuan) {
              $status = true;
            }
          } else {
            $status = true;
          }
        }

        if ($status) {
          $transaction->commit();
          $pesan = "Pengajuan Bonus/THR Pegawai berhasil dibatalkan";
        } else {
          $transaction->rollback();
          $pesan = "Pengajuan Bonus/THR Pegawai gagal dibatalkan!";
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "Pengajuan Bonus/THR Pegawai gagal dibatalkan!";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrintInformasi()
  {
    $format = new MyFormatter();

    $model = new KPInfobonusthrpegawaiV();
    $model->periodebonusthr = date('Y-m');

    if (isset($_GET['KPInfobonusthrpegawaiV'])) {
      $model->attributes = $_GET['KPInfobonusthrpegawaiV'];
      $model->periodebonusthr = MyFormatter::formatMonthForDB($model->periodebonusthr);
      $periode =  date('F Y', strtotime($model->periodebonusthr));
      $model->ruangan_id = (isset($_GET['KPInfobonusthrpegawaiV']['ruangan_id']) ? $_GET['KPInfobonusthrpegawaiV']['ruangan_id'] : null);
    }
    $judulLaporan = 'Pengajuan Bonus / THR Pegawai';
    $deskripsi = 'Perioder ' . MyFormatter::formatMonthForUser($model->periodebonusthr);

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXPORT') {
      $this->layout = '//layouts/printExcel';
      $jenis = $_GET['KPInfobonusthrpegawaiV']['jenisgaji'];
      $model->jenis = $_GET['KPInfobonusthrpegawaiV']['jenisgaji'];
      $this->render($this->path_view . 'PrintExport', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'jenis' => $jenis, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionRincian($pengbonusthrdetail_id, $pengbonusthr_id)
  {

    if (isset($_GET['caraPrint']) && ($_GET['caraPrint'] == "PRINT")) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }

    $model = PengbonusthrT::model()->findByPk($pengbonusthr_id);
    $modDetail = PengbonusthrdetailT::model()->findByPk($pengbonusthrdetail_id);


    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    $this->render($this->path_view . '_rincian', array(
      'caraPrint' => $caraPrint,
      'modDetail' => $modDetail,
      'model' => $model,
    ));
  }

  public function actionApproveAll()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $dataArray = array();
      $format = new MyFormatter();
      $model = array();
      $type_approve = null;

      if (isset($_POST['KPInfobonusthrpegawaiV'])) {
        $type_approve = $_POST['type_approve'];
        $modInfo = new KPInfobonusthrpegawaiV();
        $modInfo->attributes = $_POST['KPInfobonusthrpegawaiV'];
        $modInfo->periodebonusthr = MyFormatter::formatMonthForDB($modInfo->periodebonusthr);
        $modInfo->ruangan_id = (isset($_POST['KPInfobonusthrpegawaiV']['ruangan_id']) ? $_POST['KPInfobonusthrpegawaiV']['ruangan_id'] : null);

        $prov = $modInfo->searchInformasi();
        if ($type_approve == 'mengetahuirs') {
          $prov->criteria->addCondition('tgl_mengetahui is null');
        } else if ($type_approve == 'mengetahuipt') {
          $prov->criteria->addCondition('tgl_mengetahuipt is null');
        } else if ($type_approve == 'menyetujui') {
          $prov->criteria->addCondition('tgl_menyetujui is null');
        }
        $model = $prov->data;
      }
      $sukseData = null;
      if (isset($_GET['approve'])) {
        if ($_GET['approve'] == true) {
          $type_approve = $_GET['type_approve'];
          $indexApp = 0;

          if (count((array)$_GET['id']) > 0) {
            foreach ($_GET['id'] as $data) {
              $modelData =  KPInfobonusthrpegawaiV::model()->findByAttributes(array('pengbonusthr_id' => $data));
              $modelUpdate = null;
              if ($type_approve == 'mengetahuirs') {
                $modelUpdate = PengbonusthrT::model()->updateByPk($data, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
              } else if ($type_approve == 'mengetahuipt') {
                $modelUpdate = PengbonusthrT::model()->updateByPk($data, array('tgl_mengetahuipt' => date("Y-m-d H:i:s")));
              } else if ($type_approve == 'menyetujui') {
                $modelUpdate = PengbonusthrT::model()->updateByPk($data, array('tgl_menyetujui' => date("Y-m-d H:i:s")));
              }

              if (isset($modelUpdate)) {
                $indexApp += 1;
              } else {
                if ($indexApp < 0) {
                  $indexApp = 0;
                } else {
                  $indexApp -= 1;
                }
              }
              $model[] = $modelData;
            }
            if ($indexApp == count((array)$_GET['id'])) {
              $sukseData = true;
            }
          }
        }
      }


      $dataArray['form'] = $this->renderPartial($this->path_view . '_approveAll', array(
        'format' => $format,
        'model' => $model,
        'suksesForm' => $sukseData,
        'type_approve' => $type_approve,
      ), true);
      $dataArray['sukses'] = 1;

      echo json_encode($dataArray);
      Yii::app()->end();
    }
  }

  public function actionPrintApproveAll()
  {
    $format = new MyFormatter();
    $model = array();
    $type_approve = null;
    if (isset($_GET['id']) && count((array)$_GET['id']) > 0) {
      foreach ($_GET['id'] as $data) {

        $modelData = KPInfobonusthrpegawaiV::model()->findByAttributes(array('pengbonusthr_id' => $data));
        $model[] = $modelData;
      }
      $type_approve = (isset($_GET['type_approve']) ? $_GET['type_approve'] : null);
    }

    if (isset($_GET['KPInfobonusthrpegawaiV'])) {
      // $type_approve = $_GET['type_approve'];
      $modInfo = new KPInfobonusthrpegawaiV();
      $modInfo->attributes = $_GET['KPInfobonusthrpegawaiV'];
      $modInfo->periodebonusthr = MyFormatter::formatMonthForDB($modInfo->periodebonusthr);
      $modInfo->ruangan_id = (isset($_GET['KPInfobonusthrpegawaiV']['ruangan_id']) ? $_GET['KPInfobonusthrpegawaiV']['ruangan_id'] : null);

      $prov = $modInfo->searchInformasi();
      if ($type_approve == 'mengetahuirs') {
        $prov->criteria->addCondition('tgl_mengetahui is null');
      } else if ($type_approve == 'mengetahuipt') {
        $prov->criteria->addCondition('tgl_mengetahuipt is null');
      } else if ($type_approve == 'menyetujui') {
        $prov->criteria->addCondition('tgl_menyetujui is null');
      }
      $model = $prov->data;
    }

    $judulLaporan = 'Pengajuan Bonus / THR Pegawai';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printApproveAll', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $appmenyet = false;

      if (isset($type_approve)) {
        if ($type_approve == 'menyetujui') {
          $appmenyet = true;
        }
      }

      if ($appmenyet) {
        $this->render($this->path_view . 'printApprvAllExcelMenyetujui', array('format' => $format, 'model' => $model, 'judulLaporan' => "Data Pegawai", 'caraPrint' => $caraPrint));
      } else {
        $this->render($this->path_view . 'printExcel', array('format' => $format, 'model' => $model, 'judulLaporan' => "Data Pegawai", 'caraPrint' => $caraPrint));
      }
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printApproveAll', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApproveMengetahui($pengbonusthr_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PengbonusthrT::model()->findByPk($pengbonusthr_id);
    $modDetail = PengbonusthrdetailT::model()->findAllByAttributes(array('pengbonusthr_id' => $pengbonusthr_id));

    if ($approve) {
      $update = PengbonusthrT::model()->updateByPk($pengbonusthr_id, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahui', 'pengbonusthr_id' => $pengbonusthr_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pengajuan ' . $model->jenisgaji . ' Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'modDetail' => $modDetail,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi
    ));
  }

  public function actionPrintApproveMengetahui($pengbonusthr_id)
  {
    $format = new MyFormatter();

    $model = PengbonusthrT::model()->findByPk($pengbonusthr_id);
    $modDetail = PengbonusthrdetailT::model()->findAllByAttributes(array('pengbonusthr_id' => $pengbonusthr_id));

    $judulLaporan = 'Pengajuan ' . $model->jenisgaji . ' Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApproveMengetahuiPT($pengbonusthr_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PengbonusthrT::model()->findByPk($pengbonusthr_id);
    $modDetail = PengbonusthrdetailT::model()->findAllByAttributes(array('pengbonusthr_id' => $pengbonusthr_id));

    if ($approve) {
      $update = PengbonusthrT::model()->updateByPk($pengbonusthr_id, array('tgl_mengetahuipt' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahuiPT', 'pengbonusthr_id' => $pengbonusthr_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Pengajuan ' . $model->jenisgaji . ' Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $this->render($this->path_view . '_mengetahuipt', array(
      'format' => $format,
      'modDetail' => $modDetail,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
    ));
  }

  public function actionPrintApproveMengetahuiPT($pengbonusthr_id)
  {
    $format = new MyFormatter();
    $model = PengbonusthrT::model()->findByPk($pengbonusthr_id);
    $modDetail = PengbonusthrdetailT::model()->findAllByAttributes(array('pengbonusthr_id' => $pengbonusthr_id));

    $judulLaporan = 'Pengajuan ' . $model->jenisgaji . ' Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahuiPT', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApproveMenyetujui($pengbonusthr_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PengbonusthrT::model()->findByPk($pengbonusthr_id);
    $modDetail = PengbonusthrdetailT::model()->findAllByAttributes(array('pengbonusthr_id' => $pengbonusthr_id));

    if ($approve) {
      $update = PengbonusthrT::model()->updateByPk($pengbonusthr_id, array('tgl_menyetujui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'pengbonusthr_id' => $pengbonusthr_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    //		if($tolak){
    //			$update = ADPembelianbarangT::model()->updateByPk($rencanakebfarmasi_id,array('statusrencana'=>"DITOLAK"));
    //			if($update){
    //				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    //				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1,'ditolak'=>1));
    //			}else{
    //				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
    //			}
    //		}
    $judulLaporan = 'Pengajuan ' . $model->jenisgaji . ' Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'modDetail' => $modDetail,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
    ));
  }

  public function actionprintApproveMenyetujui($pengbonusthr_id)
  {
    $format = new MyFormatter();
    $model = PengbonusthrT::model()->findByPk($pengbonusthr_id);
    $modDetail = PengbonusthrdetailT::model()->findAllByAttributes(array('pengbonusthr_id' => $pengbonusthr_id));

    $judulLaporan = 'Pengajuan ' . $model->jenisgaji . ' Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
