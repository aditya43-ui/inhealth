<?php

class InformasiJadwalPegawaiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.informasiJadwalPegawai.';

  /**
   * Melihat daftar data.
   */
  /*public function actionIndex()
	{
		$format = new MyFormatter; 
		$model	= new KPInformasijadwalpegawaiV;
		$model->unsetAttributes();  // clear any default values
		$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['KPInformasijadwalpegawaiV'])){
			$model->attributes=$_GET['KPInformasijadwalpegawaiV'];
            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
            //if($model->ruangan_id == ""){
              //  $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            //}
		}
		$this->render($this->path_view.'indexBaru',array(
				'model'=>$model, 'format'=>$format
		));
	}
	*/
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Jadwal Pegawai";
    $model = new KPInformasijadwalpegawaiV;
    $model->tgl_awal = date('m Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');

    $dis = false;
    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_KEPEGAWAIAN) {
      $dis = true;
    }

    $ruanganAsal = CHtml::listData(KPRuanganM::getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama');

    $listHari = array(
      'Minggu' => 'Minggu',
      'Senin' => 'Senin',
      'Selasa' => 'Selasa',
      'Rabu' => 'Rabu',
      'Kamis' => 'Kamis',
      'Jumat' => 'Jumat',
      'Sabtu' => 'Sabtu',
    );

    $this->render(
      $this->path_view . 'indexBaru',
      array('dropRuang' => $ruanganAsal, 'model' => $model, 'listHari' => $listHari, 'dis' => $dis)
    );
  }

  public function actionCreateGrid()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tgljadwal = isset($_POST['tgl']) ?  MyFormatter::formatMonthForDb($_POST['tgl']) : null;
      $kelompokpegawai_id = isset($_POST['kelompokpegawai_id']) ? $_POST['kelompokpegawai_id'] : null;
      $nama_pegawai = isset($_POST['nama_pegawai']) ? $_POST['nama_pegawai'] : null;
      $shift_id = isset($_POST['shift_id']) ? $_POST['shift_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;

      $model = new KPInformasijadwalpegawaiV();
      $model->kelompokpegawai_id = $kelompokpegawai_id;
      $model->nama_pegawai = $nama_pegawai;
      $model->shift_id = $shift_id;
      $model->ruangan_id = $ruangan_id;
      $model->instalasi_id = $instalasi_id;

      $j = $model->generateJadwal();


      $tgl = explode('-', $tgljadwal);
      $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
      $bulan = $tgl[1];
      $tahun = $tgl[0];

      $grid =  $this->renderPartial($this->path_view . "_createGrid", array('bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $day, 'variable' => $j), true);

      $data['tr'] = $grid;
      $data['sukses'] = 1;
      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function actionPrintJadwalPegawai($caraPrint, $tgljadwal = null, $kelompokpegawai_id = null, $nama_pegawai = null, $shift_id = null, $ruangan_id = null, $instalasi_id = null)
  {


    $model = new KPInformasijadwalpegawaiV();
    $model->kelompokpegawai_id = $kelompokpegawai_id;
    $model->nama_pegawai = $nama_pegawai;
    $model->shift_id = $shift_id;
    $model->ruangan_id = $ruangan_id;
    $model->instalasi_id = $instalasi_id;

    $j = $model->generateJadwal();

    if (!empty($tgljadwal)) {
      $tgljadwal = MyFormatter::formatMonthForDb($tgljadwal);
    }

    $tgl = explode('-', $tgljadwal);
    $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
    $bulan = $tgl[1];
    $tahun = $tgl[0];

    $judulLaporan = 'Jadwal Pegawai Rumah Sakit';
    $target = $this->path_view . "print";
    $this->printFunction($target, $caraPrint, $judulLaporan, $bulan, $tahun, $day, $j);

    //        if($caraPrint=='PRINT') {
    //            $this->layout='//layouts/printWindows';
    //            //$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    //            $this->render($this->path_view."print",array('caraPrint'=>$caraPrint, 'judulLaporan'=>$judulLaporan, 'bulan'=>$bulan,'tahun'=>$tahun,'jumlahHari'=>$day,'variable'=>$j));
    //        }
    //        else if($caraPrint=='EXCEL') {
    //            $this->layout='//layouts/printExcel';
    //            //$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    //            $this->render($this->path_view."print",array('caraPrint'=>$caraPrint, 'judulLaporan'=>$judulLaporan, 'bulan'=>$bulan,'tahun'=>$tahun,'jumlahHari'=>$day,'variable'=>$j));
    //        }
  }


  protected function printFunction($target, $caraPrint, $judulLaporan, $bulan, $tahun, $day, $j)
  {
    $format = new MyFormatter();

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $day, 'variable' => $j));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $day, 'variable' => $j));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //            //$mpdf->useOddEven = 2;

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $day, 'variable' => $j), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionBatalJadwal()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];
    $ok = 1;
    $msg = "Jadwal pegawai berhasil dibatalkan";
    if (!KPPenjadwalandetailT::model()->deleteByPk($id)) {
      $ok = 0;
      $msg = "Jadwal pegawai batal dibatalkan";
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  public function actionUbahJadwal($penjadwalandetail_id)
  {

    $this->layout = '//layouts/iframe';

    $modDet = KPPenjadwalandetailT::model()->findByPk($penjadwalandetail_id);
    $modDet->asalshift_nama = $modDet->shift->shift_nama;
    $modDet->asalshift_awal = $modDet->shift->shift_jamawal;
    $modDet->asalshift_akhir = $modDet->shift->shift_jamakhir;
    $modDet->ruangan_id = !empty($modDet->ruangan_id) ? $modDet->ruangan_id : $modDet->penjadwalan->create_ruangan;
    $modDet->asalruangan_nama = !empty($modDet->ruangan_id) ? $modDet->ruangan->ruangan_nama : $modDet->penjadwalan->createRuanganNama->ruangan_nama;
    $modDet->shift_id = null;
    $modDet->instalasi_id = !empty($modDet->ruangan_id) ? $modDet->ruangan->instalasi_id : $modDet->penjadwalan->createRuanganNama->instalasi_id;



    $model = KPPenjadwalandetailT::model()->findByAttributes(array(
      'penjadwalandetail_id' => $penjadwalandetail_id
    ));

    $modPeg = KPPegawaiM::model()->findByPk($modDet->pegawai_id);
    $modPeg->nama_pegawai = $modPeg->namaLengkap;
    $modPeg->kelompokpegawai_nama = !empty($modPeg->kelompokpegawai_id) ? $modPeg->kelompokpegawai->kelompokpegawai_nama : null;

    $dropIns = CHtml::listData(InstalasiM::model()->findAll(" instalasi_aktif = TRUE ORDER BY instalasi_nama ASC "), 'instalasi_id', 'instalasi_nama');
    $dropRuang = CHtml::listData(RuanganM::model()->findAll(" ruangan_aktif = TRUE AND instalasi_id = '" . $modDet->instalasi_id . "' ORDER BY ruangan_nama ASC "), 'ruangan_id', 'ruangan_nama');

    if (isset($_POST['KPPenjadwalandetailT'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $modDet->shift_id = $_POST['KPPenjadwalandetailT']['shift_id'];
        $modDet->jamkerjamasuk = $_POST['KPPenjadwalandetailT']['shift_jamawal'];
        $modDet->jamkerjapulang = $_POST['KPPenjadwalandetailT']['shift_jamakhir'];
        $modDet->ruangan_id = $_POST['KPPenjadwalandetailT']['ruangan_id'];

        $ok = $ok && $modDet->save();


        //var_dump($modDet->attributes);die;
        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan! ");
          $this->redirect(array('UbahJadwal', 'penjadwalandetail_id' => $modDet->penjadwalandetail_id, 'sukses' => 1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render(
      $this->path_view . '_ubahJadwal',
      array('dropRuang' => $dropRuang, 'dropIns' => $dropIns, 'modPeg' => $modPeg, 'model' => $model, 'modDet' => $modDet)
    );
  }
}
