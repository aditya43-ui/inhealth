<?php

class JadwalhemodialisaTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'penjadwalanHD';
  public $path_view = 'pendaftaranPenjadwalan.views.jadwalHemodialisaT.';

  public function actionPenjadwalanHD()
  {
    $model = new PPJadwalhemodialisaT();
    $ruangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_HEMODIALISA);

    if (isset($_POST['jadwalHemo'])) {
      $idJadwalHari = $_POST['jadwalHD']['IdHari'];
      $jadwal = $_POST['jadwalHemo'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $return = true;
        $jumlah = 0;
        $totalData = 0;
        $jadwalHemo_id = [];
        if (count((array)$jadwal['jadwal']) > 0) {
          foreach ($jadwal['jadwal'] as $shift => $valShift) {

            foreach ($valShift['shift'] as $i => $row) {

              if (count((array)$row['ruangan_id']) > 0) {
                foreach ($row['ruangan_id'] as $j => $row2) {
                  if (isset($row2['cek']) && $row2['cek'] == 1) {
                    if (isset($row2['pasien_id']) && !empty($row2['pasien_id'])) {
                      foreach ($row2['pasien_id'] as $k => $row3) {

                        $jadwalHD = new JadwalhemodialisaT();
                        $jadwalHD->shift_id = $row['jadwalhemodialisa_shift'];
                        $jadwalHD->pasien_id = $row3;
                        $jadwalHD->jadwalhari_id = $idJadwalHari;
                        $jadwalHD->pegawai_id = Yii::app()->user->id;
                        $jadwalHD->ruangan_id = $row2['ruangan_id'];
                        if (isset($row['bed'][$k])) {
                          $jadwalHD->kamarruangan_id = $row2['bed'][$k];
                        }

                        $HDke = JadwalhemodialisaT::model()->findByAttributes(array('pasien_id' => $row3), array('order' => 'jadwalhemodialisa_id DESC', 'limit' => 1));
                        if (!empty($HDke)) {
                          $jadwalHD->jadwalhemodialisa_ke = $HDke->jadwalhemodialisa_ke + 1;
                        } else {
                          $jadwalHD->jadwalhemodialisa_ke = 1;
                        }
                        $jadwalHD->jadwalhemodialisa_tgl_ke = $row['jadwalhemodialisa_tgl'];
                        $jadwalHD->jadwalhemodialisa_hari = $row['jadwalhemodialisa_hari'];
                        $jadwalHD->jadwalhemodialisa_status = 0;
                        $jadwalHD->membuat_id = Yii::app()->user->id;
                        $jadwalHD->mengetahui_id = Yii::app()->user->id;
                        $jadwalHD->jh_create_time = date("Y-m-d H:i:s");
                        $jadwalHD->jh_create_loginid = Yii::app()->user->id;
                        $jadwalHD->jh_create_ruanganid = Yii::app()->user->getState('ruangan_id');
                        $jadwalHD->jh_create_ruanganiphost = getHostByName(getHostName());

                        if ($jadwalHD->validate()) {
                          if (!$jadwalHD->save()) {
                            $return = false;
                          } else {
                            // simpan notif
                            if ($jadwalHD->jadwalhemodialisa_tgl_ke == date('Y-m-d', strtotime("+1 days"))) {
                              $this->kirimNotifJadwal($jadwalHD, $ruangan);
                            }

                            $jadwalHemo_id[] = $jadwalHD->jadwalhemodialisa_id;

                            $jumlah++;
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
          Yii::app()->user->setFlash('success', 'Data Jadwal berhasil disimpan');
          $implodeIdJadwal = implode(',', $jadwalHemo_id);
          $this->redirect(array('penjadwalanHD', 'sukses' => 1, 'totalData' => $totalData, 'jadwalhemodialisa_id' => $implodeIdJadwal));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', ' Data gagal disimpan.', MyExceptionMessage::getMessage($exc));
      }
    }

    //        $this->render($this->path_view . 'penjadwalanHD_old', array(
    $this->render($this->path_view . 'penjadwalanHD', array(
      'model' => $model,
    ));
  }

  protected function kirimNotifJadwal($item, $ruangan)
  {


    //  var_dump($item->attributes); die;
    $nama_ruangan = "Hemodialisa";
    $pasien = PasienM::model()->findByPk($item->pasien_id);
    $shift = ShiftM::model()->findByPk($item->shift_id);
    $tanggal = $item->jadwalhemodialisa_tgl_ke;
    $hari = $item->jadwalhemodialisa_hari;


    $jam_awal = empty($shift) ? '08:00:00' : $shift->shift_jamawal;


    $formatNotif = "Pasien : {nama_pasien} ({no_rekam_medik})<br/>Waktu Daftar : {hari} {tgl} jam {shift_jamawal}<br/>Ruangan : {ruangan}";
    $judulNotif = "Jadwal Daftar Pasien {ruangan} Untuk Besok";

    foreach ($pasien->attributes as $param => $value) {
      $formatNotif = str_replace('{' . $param . '}', $value, $formatNotif);
    }


    $judulNotif = str_replace('{ruangan}', $nama_ruangan, $judulNotif);

    $formatNotif = str_replace('{ruangan}', $nama_ruangan, $formatNotif);
    $formatNotif = str_replace('{hari}', $hari, $formatNotif);
    $formatNotif = str_replace('{tgl}', MyFormatter::formatDateTimeForUser($tanggal), $formatNotif);
    $formatNotif = str_replace('{shift_jamawal}', $jam_awal, $formatNotif);

    $ok = CustomFunction::broadcastNotifCron($judulNotif, $formatNotif, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
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
      $IdHari = $_POST['jadwalHD']['IdHari'];
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
            <div class="controls">
                <span id="jadwalHD_hari_nama">
                <label class="checkbox">
                    <input type="checkbox" name="jadwalHD[hari_nama][]" checked="checked" id="jadwalHD_hari_nama_' . $ke . '" value="' . $val . '"> 
                    <label for="jadwalHD_hari_nama_' . $ke . '">' . $nama . '</label>
              </label>
                </span>
            </div>';
  }

  public function actionAjaxGenerateInputForm()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $hari = @$_POST['jadwalHD']['hari_nama'];
      $shift = @$_POST['jadwalHD']['shift'];
      $ruangan = @$_POST['jadwalHD']['ruangan'];

      $form = '';
      $submit = '';
      $data = array();

      $totalShift = count((array)$shift);
      $modRuangan = PPRuanganhemodialisaV::model()->findAllByAttributes(array('ruangan_id' => $ruangan));

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
    // $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    // $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
    // ob_end_clean();
    // $mpdf = new MyPDF60('', $ukuranKertasPDF);
    // $mpdf->debug = true;
    // $mpdf->mirrorMargins = 2;
    // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    // $mpdf->WriteHTML($stylesheet, 1);
    // $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    // $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintPdf', array('model' => $model), true));
    // $mpdf->SetJS('this.print();');
    // $mpdf->Output();
    $this->layout = '//layouts/printWindows';
    $this->render($this->path_view . 'PrintPdf', array(
      'model' => $model,
    ));
  }

  public function actionPrintJadwal()
  {

    $jadwalhemodialisa_idARR = $_GET['jadwalhemodialisa_id'];

    if(!empty($jadwalhemodialisa_idARR)) {
      $criteria = new CDbCriteria();
      $criteria->addCondition('jadwalhemodialisa_id in (' . $jadwalhemodialisa_idARR . ')');
      $modJadwal = PPJadwalhemodialisaT::model()->findAll($criteria);

      // echo '<pre>';var_dump($modJadwal);die;

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = 'L'; //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // $mpdf->debug = true;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      ob_clean();
      $mpdf->WriteHTML($stylesheet, 1);
      if(!empty($modJadwal)) {
        if(count($modJadwal)) {
          foreach ($modJadwal as $i => $model) {
            $mpdf->AddPage($posisi, '', '', '', '', 1, 1, 0, 0, 0, 0);
            $mpdf->SetHTMLFooter('<span><span>');
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printJadwal', array('model' => $model), true));
          }
        }
      }
      $mpdf->SetJS('this.print();');
      $mpdf->Output();
    }
    
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
