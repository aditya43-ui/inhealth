<?php

/**
 * Form transaksi detail penerimaan darah UTD PMI. Detail tersimpan menjadi ke tabel kantong darah
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class DetailPenerimaanDarahPMIController extends MyAuthController
{
  public $path_view = "application.modules.bankDarah.views.detailPenerimaanDarahPMI.";

  /**
   * Default menu transaksi detail penerimaan darah
   * @param integer $penerimaandarahpmi_id
   */
  public function actionIndex($penerimaandarahpmi_id = null)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    $this->pageTitle = Yii::app()->name . " - Detail Penerimaan Darah Pmi";
    $modelPenerimaan = new BDPenerimaandarahpmiT;
    $modelDetail = new BDPenerimaandarahpmidetT;
    $modKantong = new KantongdarahT;

    if (!empty($penerimaandarahpmi_id)) {
      $modelPenerimaan = BDPenerimaandarahpmiT::model()->findByPk($penerimaandarahpmi_id);
      if (!empty($modelPenerimaan->petugas_mengetahui_id)) {
        $modelPenerimaan->petugas_mengetahui_nama = PegawaiM::model()->findByPk($modelPenerimaan->petugas_mengetahui_id)->nama_pegawai;
      }
      if (!empty($modelPenerimaan->petugas_penerima_id)) {
        $modelPenerimaan->petugas_penerima_nama = PegawaiM::model()->findByPk($modelPenerimaan->petugas_penerima_id)->nama_pegawai;
      }

      $modelDetail = BDPenerimaandarahpmidetT::model()->findAllByAttributes(array('penerimaandarahpmi_id' => $penerimaandarahpmi_id));
    }

    if (isset($_POST['KantongdarahT'])) {
      // echo '<pre>';var_dump($_POST);die;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $sukses = true;
        $modelPenerimaan = BDPenerimaandarahpmiT::model()->findByPk($_POST['BDPenerimaandarahpmiT']['penerimaandarahpmi_id']);
        foreach ($_POST['KantongdarahT'] as $key => $value) {
          $modKantong = new KantongdarahT;
          $modKantong->attributes = $value;
          $modKantong->tglpencatatan = date('Y-m-d H:i:s');
          $modKantong->tgl_aftap = !empty($modKantong->tgl_aftap) ? MyFormatter::formatDateTimeForDb($modKantong->tgl_aftap) : null;
          $modKantong->tgl_kadaluarsa = MyFormatter::formatDateTimeForDb($modKantong->tgl_kadaluarsa);
          $modKantong->petugaspencatat_id = $modelPenerimaan->petugas_penerima_id;
          $modKantong->create_time = date('Y-m-d H:i:s');
          $modKantong->create_loginpemakai_id = Yii::app()->user->id;
          $modKantong->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modKantong->jeniskantongdarah_id = 1; //single

          if ($modKantong->save()) {
            $stokDarah = $this->simpanStokDarah($modKantong);
            if (!empty($stokDarah->stokkantongdarah_id)) {
              $sukses &= true;
            } else {
              $sukses &= false;
            }
          } else {
            $sukses &= false;
          }
        }

        if ($sukses) {
          $modelPenerimaan->is_detailpenerimaan = true;
          $modelPenerimaan->update();
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data No. Penerimaan " . $modelPenerimaan->no_penerimaan . " berhasil Disimpan");

          if (isset($_GET['frame'])) {
            $this->redirect(array('index', 'penerimaandarahpmi_id' => $modelPenerimaan->penerimaandarahpmi_id, 'sukses' => 1, 'frame' => 1));
          } else {
            $this->redirect(array('index', 'penerimaandarahpmi_id' => $modelPenerimaan->penerimaandarahpmi_id, 'sukses' => 1));
          }
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $exc) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modelPenerimaan' => $modelPenerimaan,
      'modelDetail' => $modelDetail,
      'modKantong' => $modKantong,
    ));
  }

  /**
   * Simpan data stok darah
   * @param array $modKantong
   * @return \StokkantongdarahT
   */
  public function simpanStokDarah($modKantong)
  {
    $penerimaanDet = PenerimaandarahpmidetT::model()->findByPk($modKantong->penerimaandarahpmidet_id);
    $stokDarah = new StokkantongdarahT;
    $stokDarah->attributes = $modKantong->attributes;
    $stokDarah->kantongdarah_id = $modKantong->kantongdarah_id;
    $stokDarah->komponendarah_id = $modKantong->komponendarah_id;
    $stokDarah->nomorbarcode = $modKantong->no_kantongdarah;
    $stokDarah->no_kantongpabrik = $stokDarah->nomorbarcode;
    $stokDarah->rhesus = $penerimaanDet->rhesus;
    $stokDarah->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $stokDarah->jmlkantongdarah = 1;
    $stokDarah->create_time = date('Y-m-d H:i:s');
    $stokDarah->create_loginpemakai_id = Yii::app()->user->id;
    $stokDarah->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $stokDarah->golongan_darah = $penerimaanDet->golongandarah;
    if (!empty($penerimaanDet->rhesus)) {
      $penerimaanDet->rhesus = strtolower(str_replace(' ', '', $penerimaanDet->rhesus));
      if ($penerimaanDet->rhesus == 'rh+') {
        $penerimaanDet->rhesus = "Positif";
      } else if ($penerimaanDet->rhesus == 'rh-') {
        $penerimaanDet->rhesus = "Negatif";
      } else {
        $penerimaanDet->rhesus = $penerimaanDet->rhesus;
      }
    }
    $stokDarah->rhesus = $penerimaanDet->rhesus;

    $stokDarah->save();

    return $stokDarah;
  }

  /**
   * Autocomplete penerimaan darah PMI
   * @param string $term
   */
  public function actionAutoCompletePenerimaanDarah($term = "")
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $mod = new BDPenerimaandarahpmiT;
    $mod->no_penerimaan = $term;
    $prov = $mod->searchDialogDetail();

    $res = array();
    foreach ($prov->data as $data) {
      $petugas_penerima_nama = "";
      $petugas_mengetahui_nama = "";
      $sub = $data->attributes;
      $sub['label'] = $data->no_penerimaan . " - " . MyFormatter::formatDateTimeForUser($data->tgl_penerimaan);
      $sub['value'] = $data->penerimaandarahpmi_id;
      if (!empty($data->petugas_penerima_id)) {
        $petugas_penerima_nama = PegawaiM::model()->findByPk($data->petugas_penerima_id)->nama_pegawai;
      }
      if (!empty($data->petugas_mengetahui_id)) {
        $petugas_mengetahui_nama = PegawaiM::model()->findByPk($data->petugas_mengetahui_id)->nama_pegawai;
      }
      $sub['petugas_penerima_nama'] = $petugas_penerima_nama;
      $sub['petugas_mengetahui_nama'] = $petugas_mengetahui_nama;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  /**
   * Set detail darah dari penerimaan
   */
  public function actionSetLoadDetailPenerimaan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new KantongdarahT;
    $modTerima = BDPenerimaandarahpmiT::model()->findByPk($_POST['penerimaandarahpmi_id']);
    $modDetail = BDPenerimaandarahpmidetT::model()->findAllByAttributes(array('penerimaandarahpmi_id' => $modTerima->penerimaandarahpmi_id));

    $str = "";
    $k = 0;
    foreach ($modDetail as $key => $value) {
      for ($i = 0; $i < $value->jumlah_terima; $i++) {
        $str .= $this->renderPartial($this->path_view . "form/_rowDetail", array(
          'key' => $k,
          'value' => $value,
          'model' => $model
        ), true);
        $k++;
      }
    }

    $res['row'] = $str;

    echo CJSON::encode($res);
  }

  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPermintaandarah = BDPermintaandarahpmiT::model()->findByPk($id);
    $modPermintaandarahdetail = BDPermintaandarahpmidetT::model()->findAllByAttributes(array('permintaandarahpmi_id' => $id));
    $modPenerimaan = PenerimaandarahpmiT::model()->findByAttributes(array('permintaandarahpmi_id' => $id));
    $modDetail = BDPenerimaandarahpmidetT::model()->findAllByAttributes(array('penerimaandarahpmi_id' => $id));

    $judul_print = 'Detail Penerimaan Darah PMI';
    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPermintaandarah' => $modPermintaandarah,
      'modPermintaandarahdetail' => $modPermintaandarahdetail,
      'modPenerimaan' => $modPenerimaan,
      'modDetail' => $modDetail,
    ));
  }
}
