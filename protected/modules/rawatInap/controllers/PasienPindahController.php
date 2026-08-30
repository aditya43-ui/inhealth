<?php

class PasienPindahController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pindah";
    $format = new MyFormatter();
    $model = new RIPasienriyangpindahV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_REQUEST['RIPasienriyangpindahV'])) {
      $model->attributes = $_REQUEST['RIPasienriyangpindahV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RIPasienriyangpindahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RIPasienriyangpindahV']['tgl_akhir']);
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ceklis = $_REQUEST['RIPasienriyangpindahV']['ceklis'];
      // $model->namaDokter = $_REQUEST['RIPasienriyangpindahV']['namaDokter'];
      $model->prefix_pendaftaran = $_REQUEST['RIPasienriyangpindahV']['prefix_pendaftaran'];
    }
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionBatalPindahKamar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPindahKamar = $_POST['idPindahKamar'];

      $idMasukKamar = isset($_POST['idMasukKamar']) ? $_POST['idMasukKamar'] : '';
      //			print_r($_POST);exit;

      $modPindahKamar = PindahkamarT::model()->findByPk($idPindahKamar);

      $modMasukKamarBaru = MasukkamarT::model()->findByPk($modPindahKamar->masukkamar_id);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = false;
        $modPasienAdmisi = PasienadmisiT::model()->findByPK($modPindahKamar->pasienadmisi_id);

        if ($idMasukKamar != 'null') {
          $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
          $modPasienAdmisi->ruangan_id = $modMasukKamar->ruangan_id;
          $modPasienAdmisi->kelaspelayanan_id = $modMasukKamar->kelaspelayanan_id;
          $modPasienAdmisi->kamarruangan_id = $modMasukKamar->kamarruangan_id;
          $updatePasienAdmisi = $modPasienAdmisi->save();
          $modMasukKamar->pindahkamar_id = null;
          $updateMasukKamar = $modMasukKamar->save();

          $updateKamar1 = KamarruanganM::model()->updateByPk($modPindahKamar->kamarruangan_id, array('kamarruangan_status' => true));
          $updateKamar2 = KamarruanganM::model()->updateByPk($modPasienAdmisi->kamarruangan_id, array('kamarruangan_status' => false));

          $modPindahKamar->masukkamar_id = null;
          $modPindahKamar->save();
          if ($updatePasienAdmisi && $updateMasukKamar) //TIDAK PERLU DI VALIDASI >> && $updateKamar1 && $updateKamar2
          {
            //Hapus masukkamar baru
            if (isset($modMasukKamarBaru) ? $modMasukKamarBaru->delete() : true) {
              if (isset($modPindahKamar) ? $modPindahKamar->delete() : true) {
                $success = true;
                echo CJSON::encode(array(
                  'status' => 'true',
                  'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>"
                ));
              }
            }
          }
        } else {
          $ruangan_lama = Yii::app()->user->getState('ruangan_id');
          $modPasienAdmisi->ruangan_id = $ruangan_lama;
          $updatePasienAdmisi = $modPasienAdmisi->save();
          // kondisi jika pasien belum masuk ruangan
          if (isset($modPindahKamar) ? $modPindahKamar->delete() : true) {
            $success = true;
            echo CJSON::encode(array(
              'status' => 'true',
              'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>"
            ));
          }
        }


        if ($success) {
          $transaction->commit();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . ExceptionMessage::getMessage($exc, true));
      }
      Yii::app()->end();
    }
  }
}
