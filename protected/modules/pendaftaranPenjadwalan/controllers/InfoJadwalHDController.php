<?php
class InfoJadwalHDController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'pendaftaranPenjadwalan.views.infoJadwalHD.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new PPJadwalhemodialisaT();
    $model->jadwalhemodialisa_tgl_ke = date('Y-m-d');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_REQUEST['PPJadwalhemodialisaT'])) {
      $model->attributes = $_REQUEST['PPJadwalhemodialisaT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['PPJadwalhemodialisaT']['tgl_awal']);
      $model->tgl_akhir  = $format->formatDateTimeForDb($_REQUEST['PPJadwalhemodialisaT']['tgl_akhir']);
      $model->nama_pasien  = $_REQUEST['PPJadwalhemodialisaT']['nama_pasien'];
      $model->no_rekam_medik  = $_REQUEST['PPJadwalhemodialisaT']['no_rekam_medik'];
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionBatalJadwal($jadwalhemodialisa_id)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $modBatal = new BataljadwalhdR();
    $modJadwal    = PPJadwalhemodialisaT::model()->findByPk($jadwalhemodialisa_id);
    $modPasien    = PasienM::model()->findByPk($modJadwal->pasien_id);
    $modJadwal->shift_id = $modJadwal->shift->shift_nama;
    $modJadwal->ruangan_id = $modJadwal->getNamaRuangan();
    $modJadwal->jadwalhemodialisa_tgl_ke = $format->formatDateTimeForUser($modJadwal->jadwalhemodialisa_tgl_ke);

    $modBatal->bataljadwalhd_tgl = $modJadwal->jadwalhemodialisa_tgl_ke;
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    if (!empty($_POST['BataljadwalhdR'])) {

      $modBatal->attributes = $_POST['BataljadwalhdR'];
      $modBatal->pasien_id = $modJadwal->pasien_id;
      $modBatal->bataljadwalhd_tgl = $format->formatDateTimeForDb($modBatal->bataljadwalhd_tgl);
      $modBatal->bjhd_create_time = date('Y-m-d H:i:s');
      $modBatal->bjhd_create_loginid  = Yii::app()->user->id;
      $modBatal->bjhd_create_ruangan_id  = Yii::app()->user->getState('ruangan_id');

      if ($modBatal->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modBatal->save()) {
            $jadwalhemodialisa_id = $_POST['jadwalhemodialisa_id'];
            $updateJadwal = PPJadwalhemodialisaT::model()->updateByPk($jadwalhemodialisa_id, array('bataljadwalhd_id' => $modBatal->bataljadwalhd_id));
            if ($updateJadwal) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan 2");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan 1");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan 3", MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render('_formBatalJadwal', array(
      'modBatal' => $modBatal,
      'modJadwal' => $modJadwal,
      'modPasien' => $modPasien,
      'tersimpan' => $tersimpan
    ));
  }

  public function actionUbahJadwal($jadwalhemodialisa_id)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $modUbah = new GantijadwalhdR();
    $modJadwal    = PPJadwalhemodialisaT::model()->findByPk($jadwalhemodialisa_id);
    $modPasien    = PasienM::model()->findByPk($modJadwal->pasien_id);
    $modJadwal->shift_id = $modJadwal->shift->shift_nama;
    $modJadwal->ruangan_id = $modJadwal->getNamaRuangan();
    $modJadwal->jadwalhemodialisa_tgl_ke_2 = $format->formatDateTimeForUser($modJadwal->jadwalhemodialisa_tgl_ke);
    $modJadwal->jadwalhemodialisa_tgl_ke = $format->formatDateTimeForUser($modJadwal->jadwalhemodialisa_tgl_ke);

    $modUbah->gantijadwalhd_tgl = $modJadwal->jadwalhemodialisa_tgl_ke;
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    $criteria->compare('LOWER(tujuansms)', strtolower('pasien'), true);
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (!empty($_POST['GantijadwalhdR'])) {

      $modUbah->attributes = $_POST['GantijadwalhdR'];
      $modUbah->pasien_id = $modJadwal->pasien_id;
      $modUbah->gantijadwalhd_tgl = $format->formatDateTimeForDb($modUbah->gantijadwalhd_tgl);
      $modUbah->gantijadwalhd_tglsblmnya = $format->formatDateTimeForDb($_POST['jadwalhemodialisa_tgl_ke']);
      $modUbah->gjhd_create_time = date('Y-m-d H:i:s');
      $modUbah->gjhd_create_loginid  = Yii::app()->user->id;
      $modUbah->gjhd_create_ruangan_id  = Yii::app()->user->getState('ruangan_id');
      $modUbah->gjhd_create_iphost = getHostByName(getHostName());

      if ($modUbah->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modUbah->save()) {
            $jadwalhemodialisa_id = $_POST['jadwalhemodialisa_id'];
            $tanggalHD = $format->formatDateTimeForDb($_POST['PPJadwalhemodialisaT']['jadwalhemodialisa_tgl_ke']);
            $jadwalHari = $format->getDayName($tanggalHD);

            $updateJadwal = PPJadwalhemodialisaT::model()->updateByPk($jadwalhemodialisa_id, array(
              'gantijadwalhd_id' => $modUbah->gantijadwalhd_id,
              'shift_id' => $_POST['PPJadwalhemodialisaT']['shift_id'],
              'jadwalhari_id' => $_POST['PPJadwalhemodialisaT']['jadwalhari_id'],
              'ruangan_id' => $_POST['PPJadwalhemodialisaT']['ruangan_id'],
              'jadwalhemodialisa_tgl_ke' => $tanggalHD,
              'jadwalhemodialisa_hari' => $jadwalHari,
              'jh_update_time' => date('Y-m-d H:i:s'),
              'jh_update_loginid' => Yii::app()->user->id,
            ));

            if ($updateJadwal) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';

              $sms = new Sms();
              foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;
                $modJadwal = PPJadwalhemodialisaT::model()->findByPk($jadwalhemodialisa_id);
                $attributes = $modJadwal->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $modRuangan = PPRuanganM::model()->findByPk($modJadwal->ruangan_id);
                $attributes = $modRuangan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms && Yii::app()->user->getState('issmsgateway')) {
                  if (!empty($modPasien->no_mobile_pasien)) {
                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                  }
                }
              }
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan 2");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan 1");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan 3", MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render('_formUbahJadwal', array(
      'modUbah' => $modUbah,
      'modJadwal' => $modJadwal,
      'modPasien' => $modPasien,
      'tersimpan' => $tersimpan
    ));
  }

  public function actionAjaxListHari()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $IdHari = $_POST['PPJadwalhemodialisaT']['jadwalhari_id'];
      $criteria = new CDbCriteria;
      if (!empty($IdHari)) {
        $criteria->addCondition("jadwalhari_id = " . $IdHari);

        $criteria->addCondition('jadwalhari_aktif = TRUE');

        $polis = PPJadwalhariM::model()->findAll($criteria);
        $no = 0;
        foreach ($polis as $i => $val) {
          if ($val->jadwalhari_hari_senin == true) {
            $this->NamaHari('Senin', $val->jadwalhari_id, $no);
          }
          if ($val->jadwalhari_hari_selasa == true) {
            $this->NamaHari('Selasa', $val->jadwalhari_id, $no);
          }
          if ($val->jadwalhari_hari_rabu == true) {
            $this->NamaHari('Rabu', $val->jadwalhari_id, $no);
          }
          if ($val->jadwalhari_hari_kamis == true) {
            $this->NamaHari('Kamis', $val->jadwalhari_id, $no);
          }
          if ($val->jadwalhari_hari_jumat == true) {
            $this->NamaHari('Jumat', $val->jadwalhari_id, $no);
          }
          if ($val->jadwalhari_hari_sabtu == true) {
            $this->NamaHari('Sabtu', $val->jadwalhari_id, $no);
          }
          if ($val->jadwalhari_hari_minggu == true) {
            $this->NamaHari('Minggu', $val->jadwalhari_id, $no);
          }
          $no++;
        }
      }
    }
  }

  public function NamaHari($nama, $val, $ke)
  {
    echo    '<span id="PPJadwalhemodialisaT_hari_nama">
                    <label class="checkbox">
                        <input type="checkbox" value="' . $val . '" name="PPJadwalhemodialisaT[hari_nama][]" checked="checked"> 
						<label>' . $nama . '</label>
					</label>
                </span>';
  }

  public function actionAutocompletePasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['term']), true);
      }
      $criteria->limit = 5;

      $models = PasienM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pasien;
        $returnVal[$i]['value'] = $model->pasien_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
