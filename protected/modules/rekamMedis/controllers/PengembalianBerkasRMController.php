<?php
class PengembalianBerkasRMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'rekamMedis.views.pengembalianBerkasRM.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pengembalian Berkas Rekam Medis";
    $format = new MyFormatter();
    $modPengiriman = new RKPeminjamandokumenrmV('searchPengiriman');
    $modPengiriman->unsetAttributes();  // clear any default values
    $modPengiriman->tglpeminjamanrm = date('Y-m-d');
    $modPengiriman->tglpeminjamanrm_akhir = date('Y-m-d');
    if (isset($_GET['RKPeminjamandokumenrmV'])) {
      $modPengiriman->attributes = $_GET['RKPeminjamandokumenrmV'];
      $modPengiriman->tglpeminjamanrm = $format->formatDateTimeForDb($modPengiriman->tglpeminjamanrm);
      $modPengiriman->tglpeminjamanrm_akhir = $format->formatDateTimeForDb($modPengiriman->tglpeminjamanrm_akhir);
    }

    $model = new RKKembalirmT;
    $model->petugaspenerima = Yii::app()->user->name;
    $model->tglkembali = date('Y-m-d H:i:s');

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

    if (isset($_POST['RKKembalirmT'])) {
      $model->attributes = $_POST['RKKembalirmT'];
      $jumlah  = count((array)$_POST['KembalirmT']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        if (isset($_POST['KembalirmT'])) {
          foreach ($_POST['KembalirmT'] as $i => $dokumen) {
            if (isset($dokumen['cekList'])) {
              if ($dokumen['cekList'] == 1) {
                $models = new RKKembalirmT();
                $models->attributes = $model->attributes;
                $models->dokrekammedis_id = $dokumen['dokrekammedis_id'];
                $models->pasien_id = $dokumen['pasien_id'];
                $models->pendaftaran_id = $dokumen['pendaftaran_id'];
                $models->peminjamanrm_id = $dokumen['peminjamanrm_id'];
                $models->pengirimanrm_id = $dokumen['pengirimanrm_id'];
                if ($dokumen['kelengkapan'] == 1) {
                  $models->lengkapdokumenkembali = true;
                } else {
                  $models->lengkapdokumenkembali = false;
                }
                $pengiriman = PengirimanrmT::model()->findByPk($models->pengirimanrm_id);
                if (isset($pengiriman->ruanganpengirim_id)) {
                  $models->ruanganasal_id = $pengiriman->ruanganpengirim_id;
                }
                if (!$models->save()) {
                  $success = false;
                } else {
                  DokrekammedisM::model()->updateByPk(
                    $models->dokrekammedis_id,
                    array('subrak_id' => $dokumen['subrak_id'], 'lokasirak_id' => $dokumen['lokasirak_id'], 'statusrekammedis' => 'AKTIF')
                  );
                  //PendaftaranT::model()->updateByPk($models->pendaftaran_id, array('kembali'))
                  PengirimanrmT::model()->updateByPk($models->pengirimanrm_id, array('kembalirm_id' => $models->kembalirm_id));
                  PeminjamanrmT::model()->updateByPk($models->peminjamanrm_id, array('kembalirm_id' => $models->kembalirm_id));

                  // SMS GATEWAY
                  $loginpemakai = LoginpemakaiK::model()->findByPk($models->create_loginpemakai_id);
                  $modPegawaiPenerima = PegawaiM::model()->findByPk($loginpemakai->pegawai_id);
                  $modPeminjaman = PeminjamanrmT::model()->findByPk($models->peminjamanrm_id);
                  $loginpemakaiPeminjam = LoginpemakaiK::model()->findByPk($modPeminjaman->create_loginpemakai_id);
                  $modPegawaiPeminjam = PegawaiM::model()->findByPk($loginpemakaiPeminjam->pegawai_id);

                  $modDokRekamMedis = $models->dokrekammedis;
                  $modSubRak = $modDokRekamMedis->subrak;
                  $modLokasiRak = $modDokRekamMedis->lokasirak;

                  $sms = new Sms();
                  foreach ($modSmsgateway as $i => $smsgateway) {
                    $isiPesan = $smsgateway->templatesms;

                    $attributes = $modPegawaiPenerima->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $modPegawaiPeminjam->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $models->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $modSubRak->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $modLokasiRak->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($models->tglkembali), $isiPesan);

                    if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI_PENERIMA && $smsgateway->statussms) {
                      if (!empty($modPegawaiPenerima->nomobile_pegawai)) {
                        $sms->kirim($modPegawaiPenerima->nomobile_pegawai, $isiPesan);
                      }
                    }
                    if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI_PEMINJAM && $smsgateway->statussms) {
                      if (!empty($loginpemakaiPeminjam->nomobile_pegawai)) {
                        $sms->kirim($loginpemakaiPeminjam->nomobile_pegawai, $isiPesan);
                      }
                    }
                  }
                  // END SMS GATEWAY
                }
              }
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Pengembalian Data Dokumen Rekam Medis berhasil disimpan");
          $this->redirect(array('index', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modPengiriman' => $modPengiriman,
    ));
  }

  public function actionGetPetugasPenerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addCondition('pegawai_aktif is true');
      $criteria->order = 'nama_pegawai';
      $models = PegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPenyimpanan()
  {
    $modDokRekamMedis = new RKDokrekammedisM;
    if (isset($_POST['Dokumen'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $jumlah = count((array)$_POST['Dokumen']['dokrekammedis_id']);

      try {
        $success = true;
        for ($i = 0; $i < $jumlah; $i++) {
          if (isset($_POST['cekList'][$i])) {
            if ($_POST['cekList'][$i] == 1) {
              RKDokrekammedisM::model()->updateByPk(
                $_POST['Dokumen']['dokrekammedis_id'][$i],
                array('subrak_id' => $_POST['Dokumen']['subrak_id'][$i], 'lokasirak_id' => $_POST['Dokumen']['lokasirak_id'][$i])
              );
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Pengiriman Dokumen Rekam Medis berhasil disimpan");
          //						RND-7490
          //						$this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $this->refresh();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $this->refresh();
      }
    }

    $model = new RKPengirimanrmT('search');
    $model->tgl_rekam_medik = date('Y-m-d H:i:s');
    $model->tgl_rekam_medik_akhir = date('Y-m-d H:i:s');
    $model->unsetAttributes();  // clear any default values
    //$modDokRekamMedis->nodokumenrm = MyGenerator::noDokumenRM();
    if (isset($_GET['RKPengirimanrmT'])) {
      $model->attributes = $_GET['RKPengirimanrmT'];
      $format = new MyFormatter();
      $model->tgl_rekam_medik = $format->formatDateTimeForDb($model->tgl_rekam_medik);
      $model->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($model->tgl_rekam_medik_akhir);
    }

    $this->render('penyimpanan', array(
      'model' => $model,
      'modDokRekamMedis' => $modDokRekamMedis,
      //'modPengiriman'=>$modPengiriman,
    ));
  }

  public function actionPrint()
  {
    $model = new RKKembalirmT;
    $model->attributes = $_REQUEST['RKKembalirmT'];
    $judulLaporan = 'Data RKKembalirmT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
