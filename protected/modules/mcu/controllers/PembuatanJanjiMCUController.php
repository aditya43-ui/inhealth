
<?php
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('pendaftaranPenjadwalan.controllers.PembuatanJanjiPoliController');
class PembuatanJanjiMCUController extends PembuatanJanjiPoliController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'mcu.views.pembuatanJanjiMCU.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  //	public function actionView($id)
  //	{
  //		$model = $this->loadModel($id);
  //		$this->render($this->path_view.'view',array(
  //				'model'=>$model,
  //		));
  //	}

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($buatjanjipoli_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Buat Janji Mcu";

    $model = new MCBuatJanjiMCU;

    $modPasien = new PPPasienM;

    $modPegawai = new PPPegawaiM;

    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($buatjanjipoli_id)) {
      $model = $this->loadModel($buatjanjipoli_id);
      $model->pegawai_id = $model->pegawai_id;
      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
      $modPegawai = PPPegawaiM::model()->findByPk($modPasien->pegawai_id);
    }

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);



    $format = new MyFormatter;
    if (isset($_POST['MCBuatJanjiMCU'])) {
      $transaction = Yii::app()->db->beginTransaction();

      try {
        $model = new MCBuatJanjiMCU;
        $model->attributes = $_POST['MCBuatJanjiMCU'];
        $model->tglbuatjanji = date('Y-m-d H:i:s');
        $model->tgljadwal = $format->formatDateTimeForDb($_POST['MCBuatJanjiMCU']['tgljadwal']);
        $model->ruangan_id = $_POST['MCBuatJanjiMCU']['ruangan_id'];
        $model->pegawai_id = empty($model->pegawai_id) ?  null : $model->pegawai_id;
        $model->no_antrianjanji = MyGenerator::noAntrianJanjiMCU($model->ruangan_id);
        $model->no_buatjanji = MyGenerator::noJanjiMCU("MCU");
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (!isset($_POST['isPasienLama'])) {   //Jika Pasiennya Lama
          $modPasien = $this->savePasien($_POST['PPPasienM']);
          $model->pasien_id = $modPasien->pasien_id;
          $model->no_rekam_medik = $modPasien->no_rekam_medik;
        } else {
          $modPasien = PPPasienM::model()->findByAttributes(array('no_rekam_medik' => $_POST['no_rekam_medik']));
          $modPasien->no_mobile_pasien = $_POST['PPPasienM']['no_mobile_pasien'];
          $model->pasien_id = $modPasien->pasien_id;
          $model->no_rekam_medik = $modPasien->no_rekam_medik;
        }
        if ($model->validate()) {
          $model->save();
          // SMS GATEWAY
          if (isset($model->pegawai)) {
            $modPegawai = $model->pegawai;
          }
          $modRuangan = $model->ruangan;
          $sms = new Sms();
          $smspasien = 1;
          $smsdokter = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modRuangan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
              if (!empty($modPegawai->nomobile_pegawai)) {
                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
              } else {
                $smsdokter = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'buatjanjipoli_id' => $model->buatjanjipoli_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai
    ));
  }

  public function savePasien($attrPasien)
  {

    $modPasien = new PPPasienM;
    $modPasien->attributes = $attrPasien;
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modPasien->no_rekam_medik = MyGenerator::noRekamMedikJanjiMCU(); // generator noRekamMedik TIdak Ada
    $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
    $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->profilrs_id = Params::getDefaultProfilRS();
    $modPasien->statusrekammedis = 'AKTIF';
    $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasien->loginpemakai_id = Yii::app()->user->id;
    $modPasien->create_time = date('Y-m-d H:i:s');
    $modPasien->update_time = date('Y-m-d H:i:s');
    $modPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modPasien->update_loginpemakai_id = Yii::app()->user->id;
    $modPasien->ispasienluar = TRUE;
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $modPasien->pekerjaan_id = 14;

    if ($modPasien->validate()) {
      $modPasien->save();
    } else {
      $modPasien->tanggal_lahir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasien->tanggal_lahir, 'yyyy-MM-dd'), 'medium', null);
    }
    return $modPasien;
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  //	public function actionUpdate($id)
  //	{
  //		$model=$this->loadModel($id);
  //		$modPasien= PPPasienM::model()->findByAttributes(array('pasien_id'=>$id));
  //		// Uncomment the following line if AJAX validation is needed
  //		
  //
  //		if(isset($_POST['MCBuatJanjiMCU']))
  //		{
  //			$model->attributes=$_POST['MCBuatJanjiMCU'];
  //			if($model->save()){
  //				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
  //				$this->redirect(array('view','id'=>$model->buatjanjipoli_id));
  //			}
  //		}
  //
  //		$this->render($this->path_view.'update',array(
  //				'model'=>$model,
  //				'modPasien'=>$modPasien
  //		));
  //	}

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  //	public function actionDelete($id)
  //	{
  //		if(Yii::app()->request->isPostRequest)
  //		{
  //			// we only allow deletion via POST request
  //			$this->loadModel($id)->delete();
  //
  //			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
  //			if(!isset($_GET['ajax']))
  //				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  //		}
  //		else
  //			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  //	}
  /**
   * Memanggil dan menonaktifkan status 
   */
  //	public function actionNonActive($id)
  //	{
  //		if(Yii::app()->request->isAjaxRequest)
  //		{
  //			$data['sukses']=0;
  //			$model = $this->loadModel($id);
  //			// set non-active this
  //			// example: 
  //			// $model->modelaktif = false;
  //			// if($model->save()){
  //			//	$data['sukses'] = 1;
  //			// }
  //			echo CJSON::encode($data); 
  //		}
  //	}

  /**GetKabupaten
   * 
   * Melihat daftar data.
   */
  //	public function actionIndex()
  //	{
  //		$dataProvider=new CActiveDataProvider('MCBuatJanjiMCU');
  //		$this->render($this->path_view.'index',array(
  //			'dataProvider'=>$dataProvider,
  //		));
  //	}

  /**
   * Pengaturan data.
   */
  //	public function actionAdmin()
  //	{
  //		$model=new MCBuatJanjiMCU('search');
  //		$model->unsetAttributes();  // clear any default values
  //		if(isset($_GET['MCBuatJanjiMCU'])){
  //			$model->attributes=$_GET['MCBuatJanjiMCU'];
  //		}
  //		$this->render($this->path_view.'admin',array(
  //				'model'=>$model,
  //		));
  //	}

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = MCBuatJanjiMCU::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppbuat-janji-poli-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new MCBuatJanjiMCU;
    $model->attributes = $_REQUEST['MCBuatJanjiMCU'];
    $judulLaporan = 'Data MCBuatJanjiMCU';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
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
   * Fungsi untuk autocomplete no rekam medik 
   */
  public function actionPasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = PasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur'] = null;
      if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
        $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
        $data['tanggal'] = (!empty($_POST['tanggal_lahir']) ? date("d/m/Y", strtotime($_POST['tanggal_lahir'])) : null);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set Nip dari Pegawaai Id (int)
   */
  public function actionSetNip()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['nomorindukpegawai'] = null;
      $pegawai = $_POST['pegawai_id'];
      $res = PegawaiM::model()->findByPk($pegawai);
      $data['nomorindukpegawai'] = $res->nomorindukpegawai;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetListDaerahPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $idPropinsi = (isset($_POST['idProp']) ? $_POST['idProp'] : null);
      $idKabupaten = (isset($_POST['idKab']) ? $_POST['idKab'] : null);
      $idKecamatan = (isset($_POST['idKec']) ? $_POST['idKec'] : null);
      $idKelurahan = (isset($_POST['idKel']) ? $_POST['idKel'] : null);
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $pasien = PasienM::model()->findByPk($pasien_id);

      $propinsiOption = '';
      foreach ($propinsis as $value => $name) {
        if ($value == $idPropinsi)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatenOption = '';
      $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $idPropinsi, 'kabupaten_aktif' => true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      foreach ($kabupatens as $value => $name) {
        if ($value == $idKabupaten)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $kecamatanOption = '';
      $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id' => $idKabupaten, 'kecamatan_aktif' => true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      foreach ($kecamatans as $value => $name) {
        if ($value == $idKecamatan)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $kelurahanOption = '';
      if (!empty($pasien->kelurahan_id)) {
        //                echo $pasien->kelurahan_id;exit;
        $kelurahans = KelurahanM::model()->findAllByAttributes(array('kecamatan_id' => $idKecamatan, 'kelurahan_aktif' => true));
        $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
        $kelurahanOption .= CHtml::tag('option', array('value' => null), "-- Pilih --", true);
        foreach ($kelurahans as $value => $name) {
          if ($value == $pasien->kelurahan_id)
            $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
          else
            $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      } else {
        $kelurahanOption .= CHtml::tag('option', array('value' => null), "-- Pilih --", true);
      }


      $dataList['listPropinsi'] = $propinsiOption;
      $dataList['listKabupaten'] = $kabupatenOption;
      $dataList['listKecamatan'] = $kecamatanOption;
      $dataList['listKelurahan'] = $kelurahanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }


  public function actionGetHari()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $tanggalWaktu = $_POST['tanggal'];

      $tanggal = trim(substr($tanggalWaktu, 0, -8)); //Menampilkan Tanggal Tanpa Jam
      $tanggalDB = $format->formatDateTimeForDb($tanggal); //Mengubah Tanggal inputan ke tanggal database
      $hari = date('l', strtotime($tanggalDB)); //Mendapatkan nilai hari dari tanggal yang dipilih

      if (strtolower($hari) == 'sunday') {
        $hari = 'Minggu';
      } else if (strtolower($hari) == 'monday') {
        $hari = 'Senin';
      } else if (strtolower($hari) == 'tuesday') {
        $hari = 'Selasa';
      } else if (strtolower($hari) == 'wednesday') {
        $hari = 'Rabu';
      } else if (strtolower($hari) == 'thursday') {
        $hari = 'Kamis';
      } else if (strtolower($hari) == 'friday') {
        $hari = 'Jumat';
      } else if (strtolower($hari) == 'saturday') {
        $hari = 'Sabtu';
      }
      $data['hari'] = $hari;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetTglLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {

      $format = new MyFormatter();
      $umur = explode(' ', $_POST['umur']);
      $today = date('Y-m-d');
      if (isset($umur[0]) && isset($umur[2]) && isset($umur[4])) {
        $thn = $umur[0];
        $bln = $umur[2];
        $hr = $umur[4];

        if ($thn == '') $thn = 0;
        if ($bln == '') $bln = 0;
        $date_calc = strtotime(date("Y-m-d", strtotime($today)) . "-$thn year");
        $date = date('Y-m-d', $date_calc);
        $date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$bln month");
        $date = date('Y-m-d', $date_calc);
        $date_calc = strtotime(date("Y-m-d", strtotime($date)) . "-$hr day");
        $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d', $date_calc), 'yyyy-MM-dd'), 'medium', null);
        $data['tglLahir'] = $tgl; // 28/02/2002
      } else {
        $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($today, 'yyyy-MM-dd'), 'medium', null);
        $data['tglLahir'] = $tgl;
      }
      //				print_r($data);exit;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintKarcis($buatjanjipoli_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $model = MCBuatJanjiMCU::model()->findByPk($buatjanjipoli_id);
    $modPasien = PasienM::model()->findByPk($model->pasien_id);
    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);


    $judul_print = 'Karcis Janji MCU';
    $this->render($this->path_view . 'printKarcis', array(
      'format' => $format,
      'model' => $model,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
    ));
  }


  /**
   * untuk menampilkan pasien lama dari autocomplete
   * 1. no_rekam_medik
   * 2. no_identitas_pasien
   * 3. nama_pasien
   * 4. nama_bin (alias)
   */
  public function actionAutocompletePasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

      if (empty($no_badge)) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
        $criteria->compare('tanggal_lahir', $tanggal_lahir);
        $criteria->addCondition('ispasienluar = FALSE');
        $criteria->limit = 5;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . (!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
          $returnVal[$i]['tanggal_lahir'] = isset($model->tanggal_lahir) ? $format->formatDateTimeForUser($model->tanggal_lahir) : "";
        }
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
        $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
        $criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
        $criteria->limit = 50;
        $models = PPPasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai .
            ' - ' . $model->no_rekam_medik .
            ' - ' . $model->nama_pasien .
            ' - (' . $model->pegawai->nama_pegawai .
            ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
          $returnVal[$i]['tanggal_lahir'] = isset($model->tanggal_lahir) ? $format->formatDateTimeForUser($model->tanggal_lahir) : "";
        }
      }



      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
}
