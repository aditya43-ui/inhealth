<?php
class CutiPegawaiController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.cutiPegawai.';
  public $layout = '//layouts/iframe';

  public function actionIndex($pegawai_id = null, $pegawaicuti_id = null)
  {
    $cutiBulanSekarang = 0;

    if (!empty($pegawai_id)) {
      //$this->layout = '//layouts/iframe';
      $model = KPPegawaiM::model()->findByPk($pegawai_id);
      $bulanIni = CustomFunction::getTotalBulan(date('Y-m-d'), $model->tglditerima);

      $cr = new CDbCriteria();
      $cr->compare('status_cuti', Params::STATUS_CUTI_DISETUJUI);
      $cr->compare('pegawai_id', $pegawai_id);
      $cr->addCondition("date_part('year', tglmulaicuti) = " . date('Y'));
      $cr->addCondition("jeniscuti_id <> 2");

      if (!empty($pegawaicuti_id)) {
        $cr->addCondition('pegawaicuti_id <> ' . $pegawaicuti_id);
      }

      $modCutiPeg = PegawaicutiT::model()->findAll($cr);
      if (count((array)$modCutiPeg) > 0) {
        foreach ($modCutiPeg as $cutiPeg) {
          $tglawal = $cutiPeg->tglmulaicuti;
          $tglakhir = $cutiPeg->tglakhircuti;

          if (date('Y', strtotime($cutiPeg->tglmulaicuti)) < date('Y')) {
            $tglawal = date('d-m-Y', strtotime('first day of january this year'));
          }
          if (date('Y', strtotime($cutiPeg->tglakhircuti)) > date('Y')) {
            $tglakhir = date('d-m-Y', strtotime('last day of december this year'));
          }
          $cutiBulanSekarang += CustomFunction::hitungHari($tglakhir, $tglawal) + 1;
        }

        // var_dump($cutiBulanSekarang); die;
      }
    } else {
      if (!empty(Yii::app()->user->getState('pegawai_id'))) {
        $model = KPPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $bulanIni = CustomFunction::getTotalBulan(date('Y-m-d'), $model->tglditerima);
        //var_dump($bulanIni);
      } else {
        $model = new KPPegawaiM;
      }
    }
    $modPegawaicuti = new KPPegawaicutiT;
    $modPegawaicuti->tglmulaicuti = date('d M Y');
    $modPegawaicuti->tglakhircuti = date('d M Y', strtotime('+1 day'));
    $selisih = CustomFunction::hitungHariRawat($modPegawaicuti->tglmulaicuti, $modPegawaicuti->tglakhircuti);
    $modPegawaicuti->lamacuti = $selisih;
    $modPegawaicuti->pegawai_id = $model->pegawai_id;
    $modPegawaicuti->nama_pegawai = !empty($model->pegawai_id) ? $model->namaLengkap : null;

    $modApprovalOtorisasi = ApprovalotorisasiM::model()->find();


    if (isset($_GET['pegawaicuti_id'])) {
      if (!empty($_GET['pegawaicuti_id'])) {
        $modPegawaicuti = KPPegawaicutiT::model()->findByPk($_GET['pegawaicuti_id']);
        if (!empty($modPegawaicuti->pejabatmenyetujui)) {
          $modPegawaicuti->pejabatmenyetujui_nama = $modPegawaicuti->pegMenyetujui->namaLengkap;
        }

        if (!empty($modPegawaicuti->pejabatmengetahui)) {
          $modPegawaicuti->pejabatmengetahui_nama = $modPegawaicuti->pegMengetahui->namaLengkap;
        }
        if (!empty($modPegawaicuti->pegawai_id)) {
          $modPegawaicuti->nama_pegawai = $modPegawaicuti->pemohon->namaLengkap;
        }
      }
    }
    if (!isset($_GET['sukses'])) {
      if (!empty($modApprovalOtorisasi->bagiankepegawaian_id)) {
        $modPegawaicuti->pejabatmenyetujui = $modApprovalOtorisasi->bagiankepegawaian_id;
        $modPegawaicuti->pejabatmenyetujui_nama = $modApprovalOtorisasi->bagiankepegawaian->namaLengkap;
      }
    }

    $konfigSystem = KonfigsystemK::model()->find();
    $modPegawaicuti->lamacuti_konfigsystem = isset($konfigSystem->lama_cuti) ? $konfigSystem->lama_cuti : 0;
    
    // var_dump($modPegawaicuti->lamacuti_konfigsystem);die;
    if (isset($_POST['KPPegawaicutiT'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $modPegawaicuti->attributes = $_POST['KPPegawaicutiT'];
        $modPegawaicuti->pegawai_id = $model->pegawai_id;
        $modPegawaicuti->tglmulaicuti = MyFormatter::formatDateTimeForDb($_POST['KPPegawaicutiT']['tglmulaicuti']);
        $modPegawaicuti->tglakhircuti = MyFormatter::formatDateTimeForDb($_POST['KPPegawaicutiT']['tglakhircuti']);
        $modPegawaicuti->tglditetapkanskcuti = isset($_POST['KPPegawaicutiT']['tglditetapkanskcuti']) ? MyFormatter::formatDateTimeForDb($_POST['KPPegawaicutiT']['tglditetapkanskcuti']) : null;
        $modPegawaicuti->create_time = date('Y-m-d H:i:s');
        $modPegawaicuti->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modPegawaicuti->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($modPegawaicuti->validate()) {
          $ok = $ok && $modPegawaicuti->save();
        } else {
          $ok = false;
        }


        if ($ok) {
          $judul = "Permohonan Cuti Pegawai ";
          $isi =      "Pegawai atas nama " . $modPegawaicuti->pemohon->namaLengkap . " membuat permohonan cuti";
          $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
            array('instalasi_id' => Params::INSTALASI_ID_KEPEGAWAIAN, 'ruangan_id' => Params::RUANGAN_ID_KEPEGAWAIAN, 'modul_id' => Params::MODUL_ID_KEPEGAWAIAN),
          ));


          $trans->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan');
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
        } else {

          $str = "Data gagal disimpan<br/>";
          if (count((array)$modPegawaicuti->errors) > 0) {
            $str .= "<ul>";
            foreach ($modPegawaicuti->errors as $attr) {
              foreach ($attr as $item) {
                $str .= "<li>" . $item . "</li>";
              }
            }
            $str .= "</ul>";
          }

          Yii::app()->user->setFlash('error', $str);
          $trans->rollback();
        }
      } catch (Exception $e) {
        //echo $e->getMessage();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan');
        $trans->rollback();
      }
    }
    $this->render($this->path_view . 'index', array('bulanIni' => $bulanIni, 'model' => $model, 'modPegawaicuti' => $modPegawaicuti, 'cutiBulanSekarang' => $cutiBulanSekarang));
  }

  /**
   * menampilkan cuti pegawai
   * @return rows table
   */
  public function actionGetPegawaicuti()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter;
      $pegawai_id = $_POST['pegawai_id'];
      $modPegawaicuti = PegawaicutiT::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'tglmulaicuti'));
      $i = 1;
      $tr = '';
      foreach ($modPegawaicuti as $row) {
        $urlDelete = $this->createUrl('deletePegawaicuti', array('pegawaicuti_id' => $row->pegawaicuti_id, 'pegawai_id' => $pegawai_id));
        $urlUpdate = $this->createUrl('index', array('pegawai_id' => $pegawai_id, 'pegawaicuti_id' => $row->pegawaicuti_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . (!empty($row->jeniscuti_id) ? $row->jeniscuti->jeniscuti_nama : '') . '</td>';
        $tr .= '<td>' . $format->formatDateTimeForUser(date('Y-m-d', strtotime($row->tglmulaicuti))) . ' s/d ' . $format->formatDateTimeForUser(date('Y-m-d', strtotime($row->tglakhircuti))) . '</td>';
        $tr .= '<td>' . $row->lamacuti . ' hari' . '</td>';
        $tr .= '<td>' . $row->noskcuti . '</td>';
        $tr .= '<td>' . $format->formatDateTimeForUser($row->tglditetapkanskcuti) . '</td>';
        $tr .= '<td>' . $row->keperluancuti . '</td>';
        $tr .= '<td>' . $row->keterangan . '</td>';
        $tr .= '<td>' . (!empty($row->pejabatmengetahui) ? $row->pegMengetahui->namaLengkap : '') . '</td>';
        $tr .= '<td>' . (!empty($row->pejabatmenyetujui) ? $row->pegMenyetujui->namaLengkap : '') . '</td>';
        if (!empty($row->tgl_menyetujui)) {
          $tr .= '<td>' . $row->status_cuti . '</td>';
          $tr .= '<td>' . $row->status_cuti . '</td>';
        } else {
          $tr .= '<td>' . CHtml::link("<i class='glyphicon glyphicon-pencil'></i>", $urlUpdate, array("rel" => "tooltip", "title" => "Klik untuk Ubah Cuti Pegawai")) . '</td>';
          $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        }
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionDeletePegawaicuti($pegawaicuti_id, $pegawai_id)
  {
    $modPegawaicuti = new KPPegawaicutiT;
    if ($modPegawaicuti->deleteByPK($pegawaicuti_id)) {
      $this->redirect(array('index'));
    }
  }


  /**
   * - digunakan untuk menampilkan informasi cuti pegawai
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Gaji Pegawai Pt";
    $this->layout = '//layouts/mainNeonSidebar';

    $model  = new KPInfocutipegawaiV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');


    if (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_KEPEGAWAIAN) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    if (isset($_GET['KPInfocutipegawaiV'])) {
      $model->attributes = $_GET['KPInfocutipegawaiV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPInfocutipegawaiV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPInfocutipegawaiV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'informasi', array('model' => $model));
  }

  /**
   * - digunakan untuk menampilkan detail data cuti pegawai
   * @param type $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $model = KPInfocutipegawaiV::model()->findByAttributes(array('pegawaicuti_id' => $id));
    $profil = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));
    $profil->jenisrs_profilrs = $profil->getInitJenisRS();

    $pengganti = KPPegawaicutiT::model()->findByPK($model->pegawaicuti_id);

    $model->pengganti = (!empty($pengganti->pegpengganti_id) ? $pengganti->pegpengganti->namaLengkap : '');

    $model->tanggal_transaksi = MyFormatter::formatDateTimeForDb($model->tanggal_transaksi);

    $this->render($this->path_view . 'detail/_detailInfo', array(
      'model' => $model,
      'profil' => $profil,
      'judulLaporan' => 'Permohonan Cuti'
    ));
  }

  /**
   * - digunakan untuk menampilkan dprinout
   * @param type $id
   */
  public function actionDetailPrint($id)
  {
    $this->layout = '//layouts/iframe';
    $model = KPInfocutipegawaiV::model()->findByAttributes(array('pegawaicuti_id' => $id));
    $profil = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));
    $profil->jenisrs_profilrs = $profil->getInitJenisRS();

    $pengganti = KPPegawaicutiT::model()->findByPK($model->pegawaicuti_id);

    $model->pengganti = (!empty($pengganti->pegpengganti_id) ? $pengganti->pegpengganti->namaLengkap : '');

    $model->tanggal_transaksi = MyFormatter::formatDateTimeForDb($model->tanggal_transaksi);

    $this->render($this->path_view . 'detail/_detailInfo', array(
      'model' => $model,
      'profil' => $profil,
      'judulLaporan' => 'Permohonan Cuti'
    ));
  }

  /**
   * - digunakan untuk menampilkan fungsi approve
   * @param type $id
   */
  public function actionApprove($id)
  {
    $this->layout = '//layouts/iframe';
    $model = KPPegawaicutiT::model()->findByPk($id);

    if (isset($_POST['KPPegawaicutiT'])) {

      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['KPPegawaicutiT'])) {
          $model->attributes = $_POST['KPPegawaicutiT'];
          $model->tglditetapkanskcuti = isset($_POST['KPPegawaicutiT']['tglditetapkanskcuti']) ? MyFormatter::formatDateTimeForDb($_POST['KPPegawaicutiT']['tglditetapkanskcuti']) : null;
          $model->pejabatmenyetujui = Yii::app()->user->getState('pegawai_id');
          if ($model->status_cuti == Params::STATUS_CUTI_DISETUJUI) {
            $model->tgl_menyetujui = date('Y-m-d H:i:s');
          } else {
            if ($model->status_cuti == Params::STATUS_CUTI_DITOLAK) {
              $model->tgl_menyetujui = date('Y-m-d H:i:s');
            } else {
              $model->tgl_menyetujui = null;
              $model->pegpengganti = null;
            }
          }
          $model->update_time = date('Y-m-d H:i:s');
          $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');


          $ok = $ok && $model->save();
          if ($ok) {

            $judul = "Proses Permohonan Cuti Pegawai ";
            $isi =      "Pegawai atas nama " . $model->pemohon->namaLengkap . ", status permohonan cuti pegawai " . $model->status_cuti;

            $r = RuanganM::model()->findByPk($model->create_ruangan);

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array(
                'instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => $r->modul_id, 'pegawai_id' => $model->pegawai_id
              ),
            ));

            // insert / update presensi cuti
            if ($model->status_cuti == Params::STATUS_CUTI_DISETUJUI) {
              $this->insertPresensiCuti($model);
            }

            $trans->commit();
            Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
            $sukses = 1;
            $this->redirect(array('approve', 'sukses' => $sukses, 'id' => $model->pegawaicuti_id));
          } else {
            $str = "<strong>Gagal </strong> Data gagal disimpan<br/>";
            if (count((array)$model->errors) > 0) {
              $str .= "<ul>";
              foreach ($model->errors as $attr) {
                foreach ($attr as $item) {
                  $str .= "<li>" . $item . "</li>";
                }
              }
              $str .= "</ul>";
            }

            Yii::app()->user->setFlash('error', $str);
            $trans->rollback();
          }
        }
      } catch (Exception $e) {
        //echo $e->getMessage();die;
        Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
        $trans->rollback();
      }
    }


    $this->render($this->path_view . 'form/_approve', array(
      'model' => $model,
    ));
  }

  public function insertPresensiCuti($model)
  {
    $criteriaPresensi = new CDbCriteria();
    $criteriaPresensi->addCondition('pegawai_id = ' . $model->pegawai_id);
    $criteriaPresensi->addBetweenCondition('date(tglpresensi)', MyFormatter::formatDateTimeForDb($model->tglmulaicuti), MyFormatter::formatDateTimeForDb($model->tglakhircuti));
    $modPresensi = PresensiT::model()->findAll($criteriaPresensi);

    if (isset($modPresensi) && count((array)$modPresensi) > 0) {
      foreach ($modPresensi as $dataPresensi) {
        PresensiT::model()->updateByPk($dataPresensi->presensi_id, array('statuskehadiran_id' => Params::STATUSKEHADIRAN_CUTI));
      }
    } else {
      $peg = PegawaiM::model()->findByPk($model->pegawai_id);

      $period = new DatePeriod(
        new DateTime($model->tglmulaicuti),
        new DateInterval('P1D'),
        new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($model->tglakhircuti))))
      );

      foreach ($period as $item) {

        $presensi = new PresensiT;
        $presensi->verifikasi = true;
        $presensi->keterangan = "Cuti Pegawai - No.SK : " . $model->noskcuti;
        $presensi->pegawai_id = $model->pegawai_id;
        $presensi->tglpresensi = $item->format('Y-m-d H:i:s');
        $presensi->no_fingerprint = $peg->nofingerprint;
        $presensi->statuskehadiran_id = Params::STATUSKEHADIRAN_CUTI;
        $presensi->terlambat_mnt = $presensi->pulangawal_mnt = 0;
        $presensi->isfingerprintscan = false;

        if ($presensi->validate()) {
          $presensi->save();
        }
      }
    }
  }

  public function actionPegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->addCondition('pegawai_aktif is true');
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
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

  public function actionHapusPembatalanCuti()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $id = isset($_POST['id']) ? $_POST['id'] : null;

      $model = PegawaicutiT::model()->findByPk($id);

      try {
        if (isset($model)) {
          $sukses = false;
          $deleteCuti = PegawaicutiT::model()->deleteByPk($model->pegawaicuti_id);

          if ($deleteCuti) {
            $sukses = true;
          }

          if ($sukses) {
            $keterangan = "Data Berhasil Dibatalkan! ";
            $status = 'ok';
            $transaction->commit();
          } else {
            $keterangan = "Data Gagal Dibatalkan! ";
            $status = 'not';
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        $keterangan = "Data Gagal Dibatalkan! " . print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
