<?php

class JadwalrehabmedisTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'penjadwalanRH';
  public $path_view = 'pendaftaranPenjadwalan.views.jadwalRehabmedisT.';

  public function actionPenjadwalanRH()
  {
    $model = new PPJadwalhemodialisaT();

    if (isset($_POST['jadwalRehab'])) {

      // print_r($_POST); die;

      // $idJadwalHari = $_POST['jadwalRH']['IdHari'];
      $jadwal = $_POST['jadwalRehab'];
      $transaction = Yii::app()->db->beginTransaction();

      $modSMS = null;
      if (isset($_POST['jadwalRH']['kirim_sms']) && $_POST['jadwalRH']['kirim_sms'] == 1) {
        $cr = new CDbCriteria();
        $cr->compare("trim(lower(tujuansms))", strtolower(Params::TUJUANSMS_PASIEN));
        $cr->compare('modul_id', Yii::app()->user->getState('modul_id'));
        $cr->compare('trim(lower(modcontroller))', strtolower($this->id . "controller"));
        $cr->compare('trim(lower(modaction))', strtolower($this->action->id));

        $modSMS = SmsgatewayM::model()->find($cr);
        $sms = new Sms();
      }

      try {
        $return = true;
        $jumlah = 0;
        $totalData = 0;
        if (count((array)$jadwal['jadwal']) > 0) {
          foreach ($jadwal['jadwal'] as $shift => $valShift) {

            foreach ($valShift['shift'] as $i => $row) {

              if (count((array)$row['ruangan_id']) > 0) {
                foreach ($row['ruangan_id'] as $j => $row2) {
                  if (isset($row2['cek']) && $row2['cek'] == 1) {
                    if (isset($row2['pasien_id']) && !empty($row2['pasien_id'])) {
                      foreach ($row2['pasien_id'] as $k => $row3) {



                        $jadwalRH = new JadwalrehabmedisT();
                        $jadwalRH->shift_id = $row['jadwalrehabmedis_shift'];
                        $jadwalRH->pasien_id = $row3;
                        $jadwalRH->jadwalhari_id = null; //$idJadwalHari;
                        $jadwalRH->pegawai_id = Yii::app()->user->id;
                        $jadwalRH->ruangan_id = $row2['ruangan_id'];
                        // $jadwalRH->kamarruangan_id = $row2['bed'][$k];

                        $HDke = JadwalrehabmedisT::model()->findByAttributes(array('pasien_id' => $row3), array('order' => 'jadwalrehabmedis_id DESC', 'limit' => 1));
                        if (!empty($HDke)) {
                          $jadwalRH->jadwalrehabmedis_ke = $HDke->jadwalrehabmedis_ke + 1;
                        } else {
                          $jadwalRH->jadwalrehabmedis_ke = 1;
                        }
                        $jadwalRH->jadwalrehabmedis_tgl_ke = $row['jadwalrehabmedis_tgl'];
                        $jadwalRH->jadwalrehabmedis_hari = $row['jadwalrehabmedis_hari'];
                        $jadwalRH->jadwalrehabmedis_status = 0;
                        $jadwalRH->membuat_id = Yii::app()->user->id;
                        $jadwalRH->mengetahui_id = Yii::app()->user->id;
                        $jadwalRH->create_time = date("Y-m-d H:i:s");
                        $jadwalRH->create_loginpemakai_id = Yii::app()->user->id;
                        $jadwalRH->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $jadwalRH->create_iphost = getHostByName(getHostName());

                        if ($jadwalRH->validate()) {
                          if (!$jadwalRH->save()) {
                            $return = false;
                          } else {
                            $jumlah++;
                          }
                        }

                        if ($return && !empty($modSMS)) {


                          $isiPesan = $modSMS->templatesms;

                          $modPasien = PasienM::model()->findByPk($jadwalRH->pasien_id);
                          $modRuangan = RuanganM::model()->findByPk($jadwalRH->ruangan_id);

                          $attributes = $modPasien->getAttributes();
                          foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                          }

                          $hari = MyFormatter::getDayName($jadwalRH->jadwalrehabmedis_tgl_ke);
                          $jadwalRH->jadwalrehabmedis_tgl_ke = MyFormatter::formatDateTimeForUser($jadwalRH->jadwalrehabmedis_tgl_ke);
                          $attributes = $jadwalRH->getAttributes();

                          foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                          }

                          $attributes = $modRuangan->getAttributes();
                          foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                          }

                          $isiPesan = str_replace("{{hari}}", $hari . " ", $isiPesan);
                          $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

                          if (!empty($modPasien->no_mobile_pasien)) {
                            $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                          }
                        }


                        $totalData = $totalData + 1;
                      }
                    }
                  }
                }
              }
            }
          }
        }


        if ($jumlah > 0 && ($return)) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Jadwal berhasil disimpan.');
          $this->redirect(array('penjadwalanRH', 'sukses' => 1, 'totalData' => $totalData));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.', MyExceptionMessage::getMessage($exc));
      }
    }

    //        $this->render($this->path_view . 'penjadwalanHD_old', array(
    $this->render($this->path_view . 'penjadwalanRH', array(
      'model' => $model,
    ));
  }

  public function actionInfoPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $models = PasienM::model()->findByPk($_GET['pasien_id']);
      $returnVal['pasien'] = $models->pasien_id;
      $returnVal['namapasien'] = $models->nama_pasien;
      $returnVal['jeniskelamin'] = $models->jeniskelamin;
      $returnVal['tanggallahir'] = $models->tanggal_lahir;
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAjaxListHari()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $IdHari = $_POST['jadwalRH']['IdHari'];
      $criteria = new CDbCriteria;
      if (!empty($IdHari)) {
        $criteria->addCondition("jadwalhari_id = " . $IdHari);
      } else {
        $criteria->addCondition("jadwalhari_id IS NULL");
      }
      $criteria->addCondition('jadwalhari_aktif = TRUE');

      $polis = PPJadwalhariM::model()->findAll($criteria);
      $no = 0;
      foreach ($polis as $i => $val) {
        if ($val->jadwalhari_hari_senin == true) {
          $this->NamaHari('Senin', '1', $no);
        }
        if ($val->jadwalhari_hari_selasa == true) {
          $this->NamaHari('Selasa', '2', $no);
        }
        if ($val->jadwalhari_hari_rabu == true) {
          $this->NamaHari('Rabu', '3', $no);
        }
        if ($val->jadwalhari_hari_kamis == true) {
          $this->NamaHari('Kamis', '4', $no);
        }
        if ($val->jadwalhari_hari_jumat == true) {
          $this->NamaHari('Jumat', '5', $no);
        }
        if ($val->jadwalhari_hari_sabtu == true) {
          $this->NamaHari('Sabtu', '6', $no);
        }
        if ($val->jadwalhari_hari_minggu == true) {
          $this->NamaHari('Minggu', '0', $no);
        }
        $no++;
      }
    }
  }

  public function NamaHari($nama, $val, $ke)
  {
    echo '
                <label class="checkbox-inline">
                    <input type="checkbox" name="jadwalRH[hari_nama][]" id="jadwalRH_hari_nama_' . $ke . '" value="' . $val . '"> 
                    <label for="jadwalRH_hari_nama_' . $ke . '">' . $nama . '</label>
              </label>';
  }

  public function actionAjaxGenerateInputForm()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $hari = @$_POST['jadwalRH']['hari_nama'];
      $shift = @$_POST['jadwalRH']['shift'];
      $ruangan = @$_POST['jadwalRH']['ruangan'];

      $form = '';
      $submit = '';
      $data = array();

      $totalShift = count((array)$shift);
      $modRuangan = RuanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan));

      for ($i = 0; $i < count((array)$hari); $i++) {
        for ($j = 0; $j < count((array)$shift); $j++) {
          $form .= $this->renderPartial($this->path_view . 'formJadwalHari', array(
            'i' => $i,
            'j' => $j,
            'hari' => $hari,
            'shift' => $shift,
            'totalShift' => $totalShift,
            'modRuangan' => $modRuangan,
          ), true);
        }
      }
      $submit = CHtml::htmlButton(Yii::t('mds', '{icon} Simpan Jadwal', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onClick' => 'return checkValidasi();'));
      $batal = CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
      $batal .= CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/jadwalhemodialisaT/penjadwalanHD'), array('class' => 'btn btn-danger'));
      $data['form'] = $form;
      $data['submit'] = $submit;
      $data['batal'] = $batal;
      echo json_encode($data);
    }
  }

  public function actionAjaxListBed()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = (isset($_POST['id_Ruangan']) ? $_POST['id_Ruangan'] : null);
      $idTabel = (isset($_POST['idTabel']) ? $_POST['idTabel'] : null);
      $idShift = (isset($_POST['idShift']) ? $_POST['idShift'] : null);
      $idRuangan = (isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null);
      $jmlBaris = (isset($_POST['jmlBaris']) ? $_POST['jmlBaris'] : null);
      $criteria = new CDbCriteria;
      if (!empty($ruangan_id)) {
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
      }

      $ruangans = KamarruanganM::model()->findAll($criteria);
      $data = array();
      $data['options'] = null;
      foreach ($ruangans as $ruangan) {
        $bed_id = (isset($ruangan->kamarruangan_id) ? $ruangan->kamarruangan_id : null);
        $bed_nama = (isset($ruangan->kamarruangan_nobed) ? 'Bed : ' . $ruangan->kamarruangan_nobed : null);
        $data['options'] .= CHtml::tag('option', array('value' => $bed_id), CHtml::encode($bed_nama), true);
      }

      $data['ruangan_id'] = $ruangan_id;
      $data['idTabel'] = $idTabel;
      $data['idShift'] = $idShift;
      $data['idRuangan'] = $idRuangan;
      $data['jmlBaris'] = $jmlBaris;
      $data['input'] = $this->renderPartial($this->path_view . 'input', array('idTabel' => $idTabel, 'idShift' => $idShift, 'idRuangan' => $idRuangan, 'jmlBaris' => $jmlBaris), true);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $model = new PPJadwalhemodialisaT();
    //$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    //$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
    //ob_end_clean();
    //$mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->AddPage($posisi,'','','','',15,15,15,30,15,15);
    //$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
    //$mpdf->WriteHTML($formatkonten, 1);
    //$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css')
    //$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    //$mpdf->WriteHTML($stylesheet, 1);

    //$mpdf->WriteHTML($this->renderPartial(, array('model' => $model), true));
    //$mpdf->SetJS('this.print();');
    //$mpdf->Output();

    $this->layout = '//layouts/printWindows';
    $this->render($this->path_view . 'PrintPdf', array(
      'model' => $model,
    ));
    //$mpdf->Output();

  }

  public function actionAutoCompletePasien()
  { // RSSP-269
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pasien = isset($_GET['term']) ? $_GET['term'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'pasien_id DESC';
      $criteria->addCondition('ispasienluar = FALSE');
      $criteria->limit = 10;
      $models = PasienM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pasien . '(' . $model->no_rekam_medik . ')' . '(' . $model->tanggal_lahir . ')';
        $returnVal[$i]['value'] = $model->pasien_id;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
}
