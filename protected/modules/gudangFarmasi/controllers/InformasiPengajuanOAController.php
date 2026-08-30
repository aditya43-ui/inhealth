<?php

class InformasiPengajuanOAController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiPengajuanOA.';

  public function actionIndex()
  {
    $model = new GFPengajuanhargaoaT();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GFPengajuanhargaoaT'])) {
      $model->attributes = $_GET['GFPengajuanhargaoaT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFPengajuanhargaoaT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFPengajuanhargaoaT']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'model' => $model));
  }

  public function actionRincian($pengajuanhargaoa_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFPengajuanhargaoaT::model()->findByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));
    $modDetails = GFPenghargaoadetailT::model()->findAllByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));

    $judulLaporan = 'PENGAJUAN PERUBAHAN HARGA OBAT & ALKES';

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    }

    $this->render($this->path_view . '_rincian', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'modDetails' => $modDetails,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionApproveMengetahui($pengajuanhargaoa_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFPengajuanhargaoaT::model()->findByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));
    $modDetails = GFPenghargaoadetailT::model()->findAllByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));

    if (isset($_POST['GFPengajuanhargaoaT'])) {
      $updateDetail = true;

      $update = GFPengajuanhargaoaT::model()->updateByPk($_POST['GFPengajuanhargaoaT']['pengajuanhargaoa_id'], array('tglmengetahui' => date("Y-m-d H:i:s")));

      if (isset($_POST['GFPenghargaoadetailT']) && count((array)$_POST['GFPenghargaoadetailT']) > 0) {
        foreach ($_POST['GFPenghargaoadetailT'] as $dataDetail) {
          $isperubahan = false;
          if ($dataDetail['checklist'] == 1) {
            $isperubahan = true;
          }
          $updateDetail = GFPenghargaoadetailT::model()->updateByPk($dataDetail['penghargaoadetail_id'], array('isperubahanharga' => $isperubahan));
        }
      }

      if ($update && $updateDetail) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('approveMengetahui', 'pengajuanhargaoa_id' => $pengajuanhargaoa_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }

    $judulLaporan = 'PENGAJUAN PERUBAHAN HARGA OBAT & ALKES';
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'modDetails' => $modDetails,
    ));
  }

  public function actionApproveMenyetujui($pengajuanhargaoa_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFPengajuanhargaoaT::model()->findByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));
    $modDetails = GFPenghargaoadetailT::model()->findAllByAttributes(array('pengajuanhargaoa_id' => $pengajuanhargaoa_id));

    if (isset($_POST['GFPengajuanhargaoaT'])) {
      $updateDetail = true;
      $statuspengajuan = $_POST['GFPengajuanhargaoaT']['statuspengajuan'];
      $update = GFPengajuanhargaoaT::model()->updateByPk($_POST['GFPengajuanhargaoaT']['pengajuanhargaoa_id'], array('tglmenyetujui' => date("Y-m-d H:i:s"), 'statuspengajuan' => $_POST['GFPengajuanhargaoaT']['statuspengajuan']));

      if (isset($_POST['GFPenghargaoadetailT']) && count((array)$_POST['GFPenghargaoadetailT']) > 0) {
        foreach ($_POST['GFPenghargaoadetailT'] as $dataDetail) {
          $isperubahan = false;
          if ($dataDetail['checklist'] == 1) {
            $isperubahan = true;
          }
          $updateDetail = GFPenghargaoadetailT::model()->updateByPk($dataDetail['penghargaoadetail_id'], array('isperubahanharga' => $isperubahan));
        }
      }

      if ($update && $updateDetail) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('approveMenyetujui', 'pengajuanhargaoa_id' => $pengajuanhargaoa_id, 'sukses' => 1, 'status' => $statuspengajuan));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }

    $judulLaporan = 'PENGAJUAN PERUBAHAN HARGA OBAT & ALKES';
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'modDetails' => $modDetails,
    ));
  }

  public function actionBatalPengajuan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $pengajuanhargaoa_id = isset($_POST['pengajuanhargaoa_id']) ? $_POST['pengajuanhargaoa_id'] : null;
      $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
      $pegawaibatal_id = isset($_POST['pegawaibatal_id']) ? $_POST['pegawaibatal_id'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

      $model = PengajuanhargaoaT::model()->findByPk($pengajuanhargaoa_id);

      try {
        if (isset($model)) {
          $modupdate = PengajuanhargaoaT::model()->updateByPk($model->pengajuanhargaoa_id, array('tglpembatalanpengajuanoa' => MyFormatter::formatDateTimeForDb($tglbatal), 'pegawaibatal_id' => $pegawaibatal_id, 'alasanpembatalan' => $keterangan_batal));
          $sukses = true;
          if (!$modupdate) {
            $sukses = false;
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
