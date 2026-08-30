<?php

class InfoJadwalRHController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'pendaftaranPenjadwalan.views.infoJadwalRH.';
  public $controller_pendaftaran = 'PendaftaranRehabilitasiMedisPP';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new PPJadwalrehabmedisT();
    $model->jadwalrehabmedis_tgl_ke = date('Y-m-d');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_REQUEST['PPJadwalrehabmedisT'])) {
      $model->attributes = $_REQUEST['PPJadwalrehabmedisT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPJadwalrehabmedisT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPJadwalrehabmedisT']['tgl_akhir']);
      $model->nama_pasien = $_REQUEST['PPJadwalrehabmedisT']['nama_pasien'];
      $model->no_rekam_medik = $_REQUEST['PPJadwalrehabmedisT']['no_rekam_medik'];
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionBatalJadwal($jadwalrehabmedis_id)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $modBatal = new BataljadwalrhR();
    $modJadwal = PPJadwalrehabmedisT::model()->findByPk($jadwalrehabmedis_id);
    $modPasien = PasienM::model()->findByPk($modJadwal->pasien_id);
    $modJadwal->shift_id = $modJadwal->shift->shift_nama;
    $modJadwal->ruangan_id = $modJadwal->getNamaRuangan();
    $modJadwal->jadwalrehabmedis_tgl_ke = $format->formatDateTimeForUser($modJadwal->jadwalrehabmedis_tgl_ke);
    $modJadwal->jadwalrehabmedis_tgl_ke_2 = $modJadwal->jadwalrehabmedis_tgl_ke;

    $modBatal->bataljadwalrh_tgl = $modJadwal->jadwalrehabmedis_tgl_ke;
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    if (!empty($_POST['BataljadwalrhR'])) {

      $modBatal->attributes = $_POST['BataljadwalrhR'];
      $modBatal->pasien_id = $modJadwal->pasien_id;
      $modBatal->bataljadwalrh_tgl = $format->formatDateTimeForDb($modBatal->bataljadwalrh_tgl);
      $modBatal->bjrh_create_time = date('Y-m-d H:i:s');
      $modBatal->bjrh_create_loginid = Yii::app()->user->id;
      $modBatal->bjrh_create_ruangan_id = Yii::app()->user->getState('ruangan_id');


      if ($modBatal->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modBatal->save()) {
            $jadwalrehabmedis_id = $_POST['jadwalrehabmedis_id'];
            $updateJadwal = PPJadwalrehabmedisT::model()->updateByPk($jadwalrehabmedis_id, array('bataljadwalrh_id' => $modBatal->bataljadwalrh_id));

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

    $this->render($this->path_view . '_formBatalJadwal', array(
      'modBatal' => $modBatal,
      'modJadwal' => $modJadwal,
      'modPasien' => $modPasien,
      'tersimpan' => $tersimpan
    ));
  }

  public function actionUbahJadwal($jadwalrehabmedis_id)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $modUbah = new GantijadwalrhR();
    $modJadwal = PPJadwalrehabmedisT::model()->findByPk($jadwalrehabmedis_id);
    $modPasien = PasienM::model()->findByPk($modJadwal->pasien_id);
    $modJadwal->shift_id = $modJadwal->shift->shift_nama;
    $modJadwal->ruangan_id = $modJadwal->getNamaRuangan();
    $modJadwal->jadwalrehabmedis_tgl_ke_2 = $format->formatDateTimeForUser(date('Y-m-d', strtotime($modJadwal->jadwalrehabmedis_tgl_ke)));
    $modJadwal->jadwalrehabmedis_tgl_ke = $format->formatDateTimeForUser(date('Y-m-d', strtotime($modJadwal->jadwalrehabmedis_tgl_ke)));

    $modUbah->gantijadwalrh_tgl = $modJadwal->jadwalrehabmedis_tgl_ke;
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

    if (!empty($_POST['GantijadwalrhR'])) {

      $modUbah->attributes = $_POST['GantijadwalrhR'];
      $modUbah->pasien_id = $modJadwal->pasien_id;
      $modUbah->gantijadwalrh_tgl = $format->formatDateTimeForDb($modUbah->gantijadwalrh_tgl);
      $modUbah->gantijadwalrh_tglsblmnya = $format->formatDateTimeForDb($_POST['jadwalrehabmedis_tgl_ke']);
      $modUbah->gjrh_create_time = date('Y-m-d H:i:s');
      $modUbah->gjrh_create_loginid = Yii::app()->user->id;
      $modUbah->gjrh_create_ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modUbah->gjrh_create_iphost = getHostByName(getHostName());


      if ($modUbah->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modUbah->save()) {
            $jadwalrehabmedis_id = $_POST['jadwalrehabmedis_id'];
            $tanggalHD =  $modUbah->gantijadwalrh_tgl; //$format->formatDateTimeForDb($_POST['PPJadwalrehabmedisT']['jadwalrehabmedis_tgl_ke']);
            $jadwalHari = $format->getDayName($tanggalHD);

            $attr = array(
              'gantijadwalrh_id' => $modUbah->gantijadwalrh_id,
              'shift_id' => $_POST['PPJadwalrehabmedisT']['shift_id'],
              'jadwalhari_id' => $_POST['PPJadwalrehabmedisT']['jadwalhari_id'],
              'ruangan_id' => $_POST['PPJadwalrehabmedisT']['ruangan_id'],
              'jadwalrehabmedis_tgl_ke' => $tanggalHD,
              'jadwalrehabmedis_hari' => $jadwalHari,
              'update_time' => date('Y-m-d H:i:s'),
              'update_loginpemakai_id' => Yii::app()->user->id,
            );

            $updateJadwal = PPJadwalrehabmedisT::model()->updateByPk($jadwalrehabmedis_id, $attr);

            if ($updateJadwal) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';

              $sms = new Sms();
              foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;
                $modJadwal = PPJadwalrehabmedisT::model()->findByPk($jadwalrehabmedis_id);
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

    $this->render($this->path_view . '_formUbahJadwal', array(
      'modUbah' => $modUbah,
      'modJadwal' => $modJadwal,
      'modPasien' => $modPasien,
      'tersimpan' => $tersimpan
    ));
  }

  public function actionAjaxListHari()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $IdHari = $_POST['PPJadwalrehabmedisT']['jadwalhari_id'];
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
    echo '<span id="PPJadwalhemodialisaT_hari_nama">
                    <label class="checkbox">
                        <input type="checkbox" value="' . $val . '" name="PPJadwalrehabmedisT[hari_nama][]" checked="checked"> 
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
