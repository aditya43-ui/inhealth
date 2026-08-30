<?php

class PasienBlacklistController extends MyAuthController
{

  protected $successSave = true;
  public $path_view = "rekamMedis.views.pasienBlacklist.";

  public function actionIndex()
  {
    if (isset($_GET['frame'])) {
      $this->layout = "//layouts/iframe";
    }
    $modPendaftaran = new RKPendaftaranT;
    $model = new RKPasienblacklistT;
    $modHutang = new RinciantagihantindakanV; //hanya mengecek rincian tagihan tindakan

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

    $url_batal = Yii::app()->createAbsoluteUrl(
      Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
    );

    if (isset($_GET['pasienblacklist_id'])) {
      $model = RKPasienblacklistT::model()->findByPk($_GET['pasienblacklist_id']);
      $modPendaftaran = RKPendaftaranT::model()->findBySql('SELECT pendaftaran_t.*,pasien.*,pekerjaan.*,pendidikan.*,ruangan.*,instalasi.*
					FROM pendaftaran_t
					JOIN pasien_m AS pasien ON pasien.pasien_id = pendaftaran_t.pasien_id 
						   JOIN instalasi_m AS instalasi ON instalasi.instalasi_id = pendaftaran_t.instalasi_id 
						   JOIN ruangan_m AS ruangan ON ruangan.ruangan_id = pendaftaran_t.ruangan_id 
						   JOIN pekerjaan_m AS pekerjaan ON pekerjaan.pekerjaan_id = pasien.pekerjaan_id
						   JOIN pendidikan_m AS pendidikan ON pendidikan.pendidikan_id = pasien.pendidikan_id
						   WHERE pendaftaran_t.pendaftaran_id = ' . $model->pendaftaran_id);
    }

    $successSave = false;

    if (isset($_POST['RKPasienblacklistT']) && !empty($_POST['RKPendaftaranT']['pendaftaran_id'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = $this->savePasienBlacklist($_POST['RKPasienblacklistT'], $_POST['RKPendaftaranT']['pendaftaran_id']);

        $successSave = $this->successSave;

        if ($successSave) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $transaction->commit();
          $this->redirect(array('index', 'status' => 1, 'pasienblacklist_id' => $model->pasienblacklist_id));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }

    $this->render(
      'index',
      array(
        'modPendaftaran' => $modPendaftaran,
        'model' => $model,
        'modHutang' => $modHutang,
        'successSave' => $successSave,
        'url_batal' => $url_batal
      )
    );
  }

  public function actionLoadPasienBerhutang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $loadRiwayat = PembayaranpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'tglpembayaran DESC'));
      if (count((array)$loadRiwayat) > 0) {
        foreach ($loadRiwayat as $i => $modHutang) {
          $rows .= $this->renderPartial($this->path_view . "_rowHutangPasien", array('modHutang' => $modHutang), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  protected function savePasienBlacklist($post, $pendaftaran_id)
  {
    $model = new RKPasienblacklistT;
    $model->attributes = $post;
    $model->pasienblacklist_no = MyGenerator::noPasienBlacklist();
    $model->pasienblacklist_tgl = MyFormatter::formatDateTimeForDb($post['pasienblacklist_tgl']);
    $model->pasienblacklist_karenakasus = $post['pasienblacklist_karenakasus'];
    $model->pasienblacklist_ket = $post['pasienblacklist_ket'];
    $model->isblacklist = $post['isblacklist'];
    $model->pendaftaran_id = $pendaftaran_id;
    $model->create_ruangan = Yii::app()->user->ruangan_id;
    $model->create_time = date('Y-m-d');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    if ($model->validate()) {
      $model->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $model;
  }

  public function actionPrint()
  {
    $model = RKPasienblacklistT::model()->findByPk($_REQUEST['pasienblacklist_id']);
    $model->attributes = $model;

    $judulLaporan = 'Pasien Blacklist';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();

      $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($nama_pasien), true);
      $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($no_pendaftaran), true);

      $criteria->join = 'JOIN pasien_m AS pasien ON pasien.pasien_id = t.pasien_id';
      $criteria->limit = 5;
      $models = RKPendaftaranT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }

        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . (isset($model->pasien->no_rekam_medik) ? $model->pasien->no_rekam_medik : "") . ' - ' . (isset($model->pasien->nama_pasien) ? $model->pasien->nama_pasien : "") . (!empty($model->pasien->nama_bin) ? "(" . $model->pasien->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
        $returnVal[$i]['pendaftaran_id'] = $model->pendaftaran_id;
        $returnVal[$i]['pasien_id'] = $model->pasien_id;
        $returnVal[$i]['no_pendaftaran'] = $model->no_pendaftaran;
        $returnVal[$i]['no_rekam_medik'] = isset($model->pasien->no_rekam_medik) ? $model->pasien->no_rekam_medik : "";
        $returnVal[$i]['nama_pasien'] = isset($model->pasien->nama_pasien) ? $model->pasien->nama_pasien : "";
        $returnVal[$i]['tempat_lahir'] = isset($model->pasien->tempat_lahir) ? $model->pasien->tempat_lahir : "";
        $returnVal[$i]['tanggal_lahir'] = isset($model->pasien->tanggal_lahir) ? $model->pasien->tanggal_lahir : "";
        $returnVal[$i]['umur'] = $model->umur;
        $returnVal[$i]['agama'] = isset($model->pasien->agama) ? $model->pasien->agama : "";
        $returnVal[$i]['jeniskelamin'] = isset($model->pasien->jeniskelamin) ? $model->pasien->jeniskelamin : "";
        $returnVal[$i]['pekerjaan_nama'] = isset($model->pasien->pekerjaan->pekerjaan_nama) ? $model->pasien->pekerjaan->pekerjaan_nama : "";
        $returnVal[$i]['pendidikan_nama'] = isset($model->pasien->pendidikan->pendidikan_nama) ? $model->pasien->pendidikan->pendidikan_nama : "";
        $returnVal[$i]['alamat_pasien'] = isset($model->pasien->alamat_pasien) ? $model->pasien->alamat_pasien : "";
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->limit = 5;
      $models = RKPegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }

        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->NamaLengkap;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
