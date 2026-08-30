
<?php

class DaftarPemakaianObatController extends MyAuthController
{
  public $layout = '//layouts/column1';
  // public $defaultAction = 'index';
  public $path_view = 'bedahSentral.views.daftarPemakaianObat.';
  public $tersimpan = false;

  public function actionAdmin($pendaftaran_id, $frame = 0) {
      $modelRiwayat = new CpptpasienT();
      $modelRiwayat->unsetAttributes();
      $this->layout = '//layouts/iframe';
      if (isset($_GET['CpptpasienT'])) {
          $modelRiwayat->attributes = $_GET['CpptpasienT'];
      }

      $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $model = new CpptpasienT();
      $ruangan_id = Yii::app()->user->getState("ruangan_id");

      $modRencana= RencanaoperasiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      
      $modObatAlkes= ObatalkespasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      // echo"<pre>";var_dump($modObatAlkes);die();
      $model->tanggal_cppt = date('d M Y H:i:s');

      $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
      $model->pasien_id = $modPendaftaran->pasien_id;
      $modAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

      $this->render($this->path_view . 'index', array(
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'model' => $model,
          'modRencana'=>$modRencana,
          'modObatAlkes'=>$modObatAlkes,
          'modelRiwayat' => $modelRiwayat
      ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = AsesmenprainduksiT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionSetOperasi(){
      if (Yii::app()->getRequest()->getIsAjaxRequest()) {
          $returnVal = array();
          if (isset($_POST['id'])) {
              $modRencanaOperasi= RencanaoperasiT::model()->findByAttributes(array('operasi_id' => $_POST['id']));
              $temp=MyFormatter::formatDateTimeForUser($modRencanaOperasi->tglrencanaoperasi);
              if(!empty($modRencanaOperasi->dokterpelaksana1_id)){
                $modDokter1=$modRencanaOperasi->dokter1->namalengkap;
              }else{
                $modDokter1='-';
              }
              if(!empty($modRencanaOperasi->dokteranastesi_id)){
                $modDokter2=$modRencanaOperasi->dokteranastesi->namalengkap;
              }else{
                $modDokter2='-';
              }
              // $modDokter2=$modRencanaOperasi->dokter2->pegawai_id;

              $returnVal['tglrencanaoperasi']= $temp;
              $returnVal['dokterpelaksana1_id']=$modDokter1;
              $returnVal['dokterpelaksana2_id']=$modDokter2;


              
              // $add=5;             $modIzin->dari_jam=date('H:i:s');


          // $date=date_create($modIzin->dari_tanggal);
          // date_add($date,date_interval_create_from_date_string($add."days"));
          // echo date_format($date,"Y-m-d");
          }
          echo json_encode($returnVal);
          Yii::app()->end();
      }
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'asesmenprainduksi-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint($pendaftaran_id,$operasi_id)
  {
    // var_dump($_GET);die();
    if(!empty($operasi_id)){
      $modRencanaOperasi= RencanaoperasiT::model()->findByAttributes(array('operasi_id' => $operasi_id));
      $modRencanaOperasi->tglrencanaoperasi=MyFormatter::formatDateTimeForUser($modRencanaOperasi->tglrencanaoperasi);
      if(!empty($modRencanaOperasi->dokterpelaksana1_id)){
        $modRencanaOperasi->dokterpelaksana1_id=$modRencanaOperasi->dokter1->namalengkap;
      }else{
        $modDokter1='-';
      }
      if(!empty($modRencanaOperasi->dokteranastesi_id)){
        $modRencanaOperasi->dokteranastesi_id=$modRencanaOperasi->dokteranastesi->namalengkap;
      }else{
        $modDokter2='-';
      }
    }
    $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien= PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
    $modObatAlkes = ObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPenunjang->pasienmasukpenunjang_id));
    $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

    // $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
    //   'pendaftaran_id' => $penunjang->pendaftaran_id,
    //   'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    // ), array(
    //   'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    // ));

    // $anestesi = PasienanastesiT::model()->findByAttributes(array(
    //   'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,

    $judulLaporan = 'Daftar Pemakaian Obat';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . '_print', array('modRencanaOperasi' => $modRencanaOperasi, 'peg'=>$peg, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPenunjang' => $modPenunjang, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'penunjang' => $penunjang, 'rencana' => $rencana, 'anestesi' => $anestesi, 'diagnosa' => $diagnosa, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'penunjang' => $penunjang, 'rencana' => $rencana, 'anestesi' => $anestesi, 'diagnosa' => $diagnosa, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  function simpanStokKeluar($modPemakaianBahan)
  {
    $format = new MyFormatter;
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modPemakaianBahan->obatalkes_id);
    //var_dump($oa->attributes);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes;
    $modStokOaNew->attributes = $modPemakaianBahan->attributes; //duplicate
    //$modStokOaNew->unsetIdTransaksi();
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = ceil($modPemakaianBahan->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
    $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
    $modStokOaNew->obatalkespasien_id = $modPemakaianBahan->obatalkespasien_id;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    //$modStokOaNew->validate();
    //var_dump($modStokOaNew->errors);


    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
    }

    // var_dump($this->stokobatalkestersimpan);

    return $modStokOaNew;
  }

  public function actionHapusPramedikasi()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];

    $trans = Yii::app()->db->beginTransaction();
    $ok = 1;
    $msg = "Data berhasil dihapus";

    try {
      $oa = ObatalkespasienT::model()->findAllByAttributes(array(
        'premedikasiprainduksi_id' => $id,
      ));

      foreach ($oa as $item) {
        StokobatalkesT::model()->deleteAllByAttributes(array(
          'obatalkespasien_id' => $item->obatalkespasien_id,
        ));
        $item->delete();
      }

      PremedikasiprainduksiT::model()->deleteByPk($id);

      $trans->commit();
    } catch (Exception $e) {
      $ok = 0;
      $msg = "Data gagal dihapus. " . $e->getMessage();
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }
}
