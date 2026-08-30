<?php

/**
 * Form transaksi simpan stok dari penerimaan darah pmi. Dengan penerimaan yang sudah masuk detail ke kantongdarah_t
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class MasukStokDarahPMIController extends MyAuthController
{
  public $path_view = "application.modules.bankDarah.views.masukStokDarahPMI.";

  /**
   * Default menu transaksi masuk stok kantong darah pmi
   * @param integer $penerimaandarahpmi_id
   */
  public function actionIndex($penerimaandarahpmi_id)
  {
    $this->layout = '//layouts/iframe';
    $modKantong = new KantongdarahT;
    $modelPenerimaan = BDPenerimaandarahpmiT::model()->findByPk($penerimaandarahpmi_id);
    if (!empty($modelPenerimaan->petugas_mengetahui_id)) {
      $modelPenerimaan->petugas_mengetahui_nama = PegawaiM::model()->findByPk($modelPenerimaan->petugas_mengetahui_id)->nama_pegawai;
    }
    if (!empty($modelPenerimaan->petugas_penerima_id)) {
      $modelPenerimaan->petugas_penerima_nama = PegawaiM::model()->findByPk($modelPenerimaan->petugas_penerima_id)->nama_pegawai;
    }

    $modelDetail = BDPenerimaandarahpmidetT::model()->findAllByAttributes(array('penerimaandarahpmi_id' => $penerimaandarahpmi_id));

    if (isset($_POST['KantongdarahT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $sukses = true;
      try {
        foreach ($_POST['KantongdarahT'] as $key => $value) {
          if ($value['pilih']) {
            $kantong = KantongdarahT::model()->findByPk($value['kantongdarah_id']);
            $penerimaanDet = PenerimaandarahpmidetT::model()->findByPk($value['penerimaandarahpmidet_id']);

            $stokDarah = new StokkantongdarahT;
            $stokDarah->attributes = $kantong->attributes;
            $stokDarah->kantongdarah_id = $kantong->kantongdarah_id;
            $stokDarah->nomorbarcode = $kantong->no_kantongdarah;
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
                $penerimaanDet->rhesus = null;
              }
            }
            $stokDarah->rhesus = $penerimaanDet->rhesus;

            if ($stokDarah->save()) {
              $sukses &= true;
            } else {
              $sukses &= false;
            }
          }
        }

        if ($sukses) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('index', 'penerimaandarahpmi_id' => $penerimaandarahpmi_id, 'sukses' => 1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $ex) {
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
}
