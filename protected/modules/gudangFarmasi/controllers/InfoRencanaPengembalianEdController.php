<?php

class InfoRencanaPengembalianEdController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = new GFRenpengembalianedT;
    $format = new MyFormatter;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GFRenpengembalianedT'])) {
      $model->attributes = $_GET['GFRenpengembalianedT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFRenpengembalianedT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFRenpengembalianedT']['tgl_akhir']);
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionMengetahui($renpengembalianed_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFRenpengembalianedT::model()->findByPk($renpengembalianed_id);
    $criteria2 = new CDbCriteria();
    $criteria2->select = 't.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id, supplier_m.supplier_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama';
    $criteria2->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id = obatalkes_m.obatalkes_id
							LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
							LEFT JOIN satuankecil_m ON t.satuankecil_id = satuankecil_m.satuankecil_id';

    if (!empty($renpengembalianed_id)) {
      $criteria2->addCondition('t.renpengembalianed_id =' . $renpengembalianed_id);
    }
    $modDetails = GFRenpengeddetailT::model()->findAll($criteria2);
    if ($approve) {
      $update = GFRenpengembalianedT::model()->updateByPk($renpengembalianed_id, array('tglmengetahui' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('mengetahui', 'renpengembalianed_id' => $renpengembalianed_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Rencana Pengembalian Obat Alkes Expired Date';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglrenpengembalian);
    $this->render('_mengetahui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintMengetahui($renpengembalianed_id)
  {
    $format = new MyFormatter();
    $model = GFRenpengembalianedT::model()->findByPk($renpengembalianed_id);
    $criteria2 = new CDbCriteria();
    $criteria2->select = 't.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id, supplier_m.supplier_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama';
    $criteria2->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id = obatalkes_m.obatalkes_id
							LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
							LEFT JOIN satuankecil_m ON t.satuankecil_id = satuankecil_m.satuankecil_id';

    if (!empty($renpengembalianed_id)) {
      $criteria2->addCondition('t.renpengembalianed_id =' . $renpengembalianed_id);
    }
    $modDetails = GFRenpengeddetailT::model()->findAll($criteria2);
    $judulLaporan = 'Rencana Pengembalian Obat Alkes Expired Date';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglrenpengembalian);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printMengetahui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printMengetahui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printMengetahui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionMenyetujui($renpengembalianed_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFRenpengembalianedT::model()->findByPk($renpengembalianed_id);
    $criteria2 = new CDbCriteria();
    $criteria2->select = 't.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id, supplier_m.supplier_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama';
    $criteria2->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id = obatalkes_m.obatalkes_id
							LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
							LEFT JOIN satuankecil_m ON t.satuankecil_id = satuankecil_m.satuankecil_id';

    if (!empty($renpengembalianed_id)) {
      $criteria2->addCondition('t.renpengembalianed_id =' . $renpengembalianed_id);
    }
    $modDetails = GFRenpengeddetailT::model()->findAll($criteria2);
    if ($approve) {
      $update = GFRenpengembalianedT::model()->updateByPk($renpengembalianed_id, array('tglmenyetujui' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'renpengembalianed_id' => $renpengembalianed_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    /*if($tolak){
			$update = GFRenpengembalianedT::model()->updateByPk($renpengembalianed_id,array('statusrencana'=>"DITOLAK"));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1,'ditolak'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
		 * 
		 */
    $judulLaporan = 'Rencana Pengembalian Obat Alkes Expired Date';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglrenpengembalian);
    $this->render('_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintMenyetujui($renpengembalianed_id)
  {
    $format = new MyFormatter();
    $model = GFRenpengembalianedT::model()->findByPk($renpengembalianed_id);
    $criteria2 = new CDbCriteria();
    $criteria2->select = 't.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id, supplier_m.supplier_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama';
    $criteria2->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id = obatalkes_m.obatalkes_id
							LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
							LEFT JOIN satuankecil_m ON t.satuankecil_id = satuankecil_m.satuankecil_id';

    if (!empty($renpengembalianed_id)) {
      $criteria2->addCondition('t.renpengembalianed_id =' . $renpengembalianed_id);
    }
    $modDetails = GFRenpengeddetailT::model()->findAll($criteria2);
    $judulLaporan = 'Rencana Pengembalian Obat Alkes Expired Date';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglrenpengembalian);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionRincian($renpengembalianed_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFRenpengembalianedT::model()->findByPk($renpengembalianed_id);
    $criteria2 = new CDbCriteria();
    $criteria2->select = 't.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id, supplier_m.supplier_nama, satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama';
    $criteria2->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id = obatalkes_m.obatalkes_id
							LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
							LEFT JOIN satuankecil_m ON t.satuankecil_id = satuankecil_m.satuankecil_id';

    if (!empty($renpengembalianed_id)) {
      $criteria2->addCondition('t.renpengembalianed_id =' . $renpengembalianed_id);
    }
    $modDetails = GFRenpengeddetailT::model()->findAll($criteria2);

    $judulLaporan = 'Rencana Pengembalian Obat Alkes Expired Date';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglrenpengembalian);
    $this->render('_rincian', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }
}
