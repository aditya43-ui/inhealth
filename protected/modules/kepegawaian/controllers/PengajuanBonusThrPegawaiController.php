<?php

class PengajuanBonusThrPegawaiController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.pengajuanBonusThrPegawai.';
  public $tersimpan = true;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Bonus/ Thr Pegawai";
    $format = new MyFormatter;
    $model = new KPPengbonusthrT;
    $model->tglpengajuan = date('Y-m-d H:i:s');
    $mon = (int) date('m');
    $tahun = (int) date('Y');
    $mon--;
    if ($mon == 0) {
      $mon = 12;
      $tahun--;
    }

    $model->periodebonusthr = Params::getBulan3()[$mon] . ' ' . $tahun;
    $model->nopengajuan = "Otomatis";
    $model->keteranganpengajuan = "Pengajuan Bonus Periode " . MyFormatter::getMonthId(date('m', strtotime($model->periodebonusthr))) . ' ' . date('Y', strtotime($model->periodebonusthr));

    $approval = ApprovalotorisasiM::model()->find();

    if (!empty($approval)) {
      $model->mengetahuirs_id = $approval->direkturrs_id;
      $model->mengetahui_pt = $approval->kasipersonalia_id;
      $model->menyetujui_id = $approval->direkturpt_id;
    }

    if (!empty($model->mengetahuirs_id)) {
      $peg = PegawaiM::model()->findByPk($model->mengetahuirs_id);
      if (!empty($peg)) {
        $model->mengetahuirs_nama = $peg->namaLengkap;
      }
    }
    if (!empty($model->mengetahui_pt)) {
      $peg = PegawaiM::model()->findByPk($model->mengetahui_pt);
      if (!empty($peg)) {
        $model->mengetahui_pt_nama = $peg->namaLengkap;
      }
    }
    if (!empty($model->menyetujui_id)) {
      $peg = PegawaiM::model()->findByPk($model->menyetujui_id);
      if (!empty($peg)) {
        $model->menyetujui_nama = $peg->namaLengkap;
      }
    }

    if (isset($_POST['KPPengbonusthrT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KPPengbonusthrT'];
        $model->tglpengajuan = $format->formatDateTimeForDb($model->tglpengajuan);
        $model->nopengajuan = MyGenerator::noPengajuanBonusThr($model->tglpengajuan, $model->jenisgaji);
        $model->periodebonusthr = MyFormatter::formatMonthForDb($model->periodebonusthr) . '-01';

        if (isset($model->pengbonusthr_id) &&  !empty($model->pengbonusthr_id)) {
          $model->update_time = date('Y-m-d H:i:s');
          $model->update_loginpemakai_id = Yii::app()->user->id;
        } else {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
        }
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          if ($model->save()) {
            $this->tersimpan = true;
            $detailSimpan = true;

            if (isset($_POST['detailpengajuan']) && count((array)$_POST['detailpengajuan']) > 0) {

              foreach ($_POST['detailpengajuan'] as $detailMod) {
                $modPengajuanDet = new PengbonusthrdetailT();
                $modPengajuanDet->attributes = $detailMod;
                $modPengajuanDet->statuspegawai = $detailMod['kategoripegawai'];
                $modPengajuanDet->pengbonusthr_id = $model->pengbonusthr_id;
                $modPengajuanDet->tglditerima = $format->formatDateTimeForDb($modPengajuanDet->tglditerima);

                if (isset($modPengajuanDet->pengbonusthrdetail_id) &&  !empty($modPengajuanDet->pengbonusthrdetail_id)) {
                  $modPengajuanDet->update_time = date('Y-m-d H:i:s');
                  $modPengajuanDet->update_loginpemakai_id = Yii::app()->user->id;
                } else {
                  $modPengajuanDet->create_time = date('Y-m-d H:i:s');
                  $modPengajuanDet->create_loginpemakai_id = Yii::app()->user->id;
                }
                $modPengajuanDet->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if (!$modPengajuanDet->save()) {
                  $detailSimpan = false;
                }
              }
            }

            if ($this->tersimpan && $detailSimpan) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('index', 'pengbonusthr_id' => $model->pengbonusthr_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
    ));
  }

  public function actionAddDetailPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $jenis = $_POST['jenis'];
      $nama_pegawai = (!empty($_POST['nama_pegawai']) ? $_POST['nama_pegawai'] : null);
      $nip = (!empty($_POST['nip']) ? $_POST['nip'] : null);
      $instalasi_id = (!empty($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $ruangan_id = (!empty($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $unitkerja_id = (!empty($_POST['unitkerja_id']) ? $_POST['unitkerja_id'] : null);
      $kategoripegawai = (!empty($_POST['kategoripegawai']) ? $_POST['kategoripegawai'] : null);
      $kelompokpegawai_id = (!empty($_POST['kelompokpegawai_id']) ? $_POST['kelompokpegawai_id'] : null);
      $jabatan_id = (!empty($_POST['jabatan_id']) ? $_POST['jabatan_id'] : null);

      $criteria = new CDbCriteria();
      $criteria->select = "t.metode_pph_21, t.pegawai_id, t.gelardepan, t.nama_pegawai, t.gelarbelakang_id, t.tglditerima, t.kategoripegawai";
      $criteria->group = $criteria->select;
      $criteria->join = "LEFT JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id "
        . " JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id "
        . " JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id ";

      $criteria->addCondition('t.pegawai_aktif = true');

      $criteria->compare('LOWER(t.nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->compare('lower(t.nomorindukpegawai)', strtolower($nip), true);

      if (!empty($instalasi_id)) {
        $criteria->addCondition('instalasi_m.instalasi_id = ' . $instalasi_id);
      }
      if (!empty($ruangan_id)) {
        $criteria->addCondition('ruangan_m.ruangan_id = ' . $ruangan_id);
      }
      if (!empty($unitkerja_id)) {
        $criteria->addCondition('t.unitkerja_id = ' . $unitkerja_id);
      }
      $criteria->compare('lower(t.kategoripegawai)', strtolower($kategoripegawai), true);

      if (!empty($kelompokpegawai_id)) {
        $criteria->addCondition('t.kelompokpegawai_id = ' . $kelompokpegawai_id);
      }

      if (!empty($jabatan_id)) {
        $criteria->addCondition('t.jabatan_id = ' . $jabatan_id);
      }

      $models = PegawaiM::model()->findAll($criteria);
      $html = "";
      if (count((array)$models)) {
        foreach ($models as $detail) {
          $modDetail = new PengbonusthrdetailT();
          $nilaigapok = 0;
          $nilaithr = 0;
          $nilaitetap = 0;

          $modKomponen = KomponengajipegawaiM::model()->findAllByAttributes(array('pegawai_id' => $detail->pegawai_id));

          if (count((array)$modKomponen) > 0) {
            foreach ($modKomponen as $dataKomponen) {
              if ($dataKomponen->komponengaji_id == 1) {
                $nilaigapok += $dataKomponen->nilaigaji;
                $nilaithr += $dataKomponen->nilaigaji;
              }
              if ($dataKomponen->komponengaji_id == 2 || $dataKomponen->komponengaji_id == 4) {
                $nilaitetap += $dataKomponen->nilaigaji;
                $nilaithr += $dataKomponen->nilaigaji;
              }
              if ($dataKomponen->komponengaji_id == 109) {
                $nilaitetap += $dataKomponen->nilaigaji;
                $nilaithr += $dataKomponen->nilaigaji;
              }
            }
          }
          $totalthr = 0;

          if ($detail->kategoripegawai == 'PEGAWAI TETAP') {
            $totalthr = $nilaithr;
          } else {
            $jmlBln = CustomFunction::getTotalBulan(date('Y-m-d'), date('Y-m-d', strtotime($detail->tglditerima)));

            if ($jmlBln <= 12) {
              $totalthr = ($jmlBln / 12) * $nilaithr;
            } else {
              $totalthr = $nilaithr;
            }
          }

          $detail->nilaigajipokok = $nilaigapok;
          $detail->nilaithr = $totalthr;
          $detail->nilaitetap = $nilaitetap;

          if ($jenis == 'Bonus') {
            $html .= $this->renderPartial($this->path_view . '_rowBonus', array(
              'modDetail' => $modDetail,
              'detail' => $detail,
              'jenisgaji' => $jenis
            ), true);
          } else {
            $html .= $this->renderPartial($this->path_view . '_rowTHR', array(
              'modDetail' => $modDetail,
              'detail' => $detail,
              'jenisgaji' => $jenis
            ), true);
          }
        }
      }

      echo CJSON::encode(
        array(
          'form' => $html, 'jenisgaji' => $jenis
        )
      );
      exit;
    }
  }
}
