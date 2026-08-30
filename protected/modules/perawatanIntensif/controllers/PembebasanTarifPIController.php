<?php

class PembebasanTarifPIController extends MyAuthController
{
  public $successSavePembebasan = true;

  public function actionIndex()
  {
    $modPasien = new PIPasienM;
    $modPendaftaran = new PIPendaftaranT;
    $model = new PIPembebasantarifT;
    $model->tglpembebasan = date('d M Y H:i:s');

    if (isset($_POST[get_class($model)])) {
      $model->attributes = $_POST[get_class($model)];
      $modPendaftaran = PIPendaftaranT::model()->findByPk($_POST[get_class($modPendaftaran)]['pendaftaran_id']);
      $modPasien = PIPasienM::model()->findByPk($_POST[get_class($modPendaftaran)]['pasien_id']);

      if (isset($_POST['pembebasan'])) {
        foreach ($_POST['pembebasan'] as $tindkomponen_id => $dataPembebasan) {
          if ($tindkomponen_id == $dataPembebasan['tindkomponen_id']) {
            //echo '<pre>'.print_r($data,1).'</pre>';
            $transaction = Yii::app()->db->beginTransaction();
            try {
              $model = $this->savePembebasan($model, $dataPembebasan);
              if ($this->successSavePembebasan) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
              } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan ");
              }
            } catch (Exception $exc) {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
          }
        }
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  protected function savePembebasan($model, $dataPembebasan)
  {
    $format = new MyFormatter;
    $modPembebasan = new PIPembebasantarifT;
    $modPembebasan->attributes = $model->attributes;
    $modPembebasan->tglpembebasan = $format->formatDateTimeForDb(trim($modPembebasan->tglpembebasan));
    $modPembebasan->tindakanpelayanan_id = $dataPembebasan['tindakanpelayanan_id'];
    $modPembebasan->komponentarif_id = $dataPembebasan['komponentarif_id'];
    $modPembebasan->jmlpembebasan = $dataPembebasan['tarif_tindakankomp'];
    $modPembebasan->loginpemakai_id = Yii::app()->user->id;
    if ($modPembebasan->validate()) {
      $modPembebasan->save();
      $tindakan = $this->saveTindakanPelayanan($dataPembebasan);
      if ($tindakan) {
        $this->successSavePembebasan = $this->successSavePembebasan && true;
      } else {
        $this->successSavePembebasan = false;
      }
    } else
      $this->successSavePembebasan = false;

    return $modPembebasan;
  }

  protected function saveTindakanPelayanan($dataPembebasan)
  {
    $is_simpan = false;
    if (!empty($dataPembebasan)) {
      $total = 0;
      if ($dataPembebasan['komponentarif_id'] == Params::KOMPONENTARIF_ID_TOTAL) {
        $total = $dataPembebasan['tarif_tindakankomp'];
        $tindakan = PITindakanPelayananT::model()->updateByPk($dataPembebasan['tindakanpelayanan_id'], array('tarif_satuan' => $total, 'tarif_tindakan' => $total));
      }
      $attributes_komp = array(
        'tarif_tindakankomp' => $dataPembebasan['tarif_tindakankomp']
      );
      TindakankomponenT::model()->updateByPk($dataPembebasan['tindkomponen_id'], $attributes_komp);
      if ($tindakan) {
        $is_simpan = true;
      }
    }

    return $is_simpan;
  }
}
