<?php
class InfoBayarUangMukaBeliController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Uang Muka Pembelian";
    $model = new KUInformasipembayaranuangmukapembelianV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KUInformasipembayaranuangmukapembelianV'])) {
      $model->attributes = $_GET['KUInformasipembayaranuangmukapembelianV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasipembayaranuangmukapembelianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasipembayaranuangmukapembelianV']['tgl_akhir']);
    }

    $this->render('index', array('model' => $model));
  }

  public function actionGetSupplierData()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(supplier_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('supplier_aktif = true');
      $criteria->limit = 5;
      $models = SupplierM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->supplier_nama;
        $returnVal[$i]['value'] = $model->supplier_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionDetailInformasi($uangmukabeli_id)
  {
    $this->layout = '//layouts/iframe';
    $model = UangmukabeliT::model()->findByPk($uangmukabeli_id);
    $modBuktiKeluar = KUTandabuktikeluarT::model()->findByAttributes(array('uangmukabeli_id' => $model->uangmukabeli_id));

    if (isset($_GET['caraPrint'])) {
      $this->layout = '//layouts/printWindows';
    }
    $this->render('detailInformasi', array(
      'modBuktiKeluar' => $modBuktiKeluar,
      'model' => $model
    ));
  }

  public function actionBatalPembayaranUangMuka()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $uangmukabeli_id = isset($_POST['uangmukabeli_id']) ? $_POST['uangmukabeli_id'] : null;
      $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
      $pegawaibatal_id = isset($_POST['pegawaibatal_id']) ? $_POST['pegawaibatal_id'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

      if (!empty($tglbatal)) {
        $tglbatal = MyFormatter::formatDateTimeForDb($tglbatal);
      }
      $model = UangmukabeliT::model()->findByPk($uangmukabeli_id);

      try {
        if (isset($model)) {
          $sukses = true;

          //                    $tandabuktikeluar = TandabuktikeluarT::model()->deleteAllByAttributes(array('uangmukabeli_id'=>$model->uangmukabeli_id));
          $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('uangmukabeli_id' => $model->uangmukabeli_id));

          if (isset($modJurnalBefore)) {
            if (count((array)$modJurnalBefore) > 0) {
              foreach ($modJurnalBefore as $jurnalBef) {
                $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));

                if (count((array)$jurnaldetail) > 0) {
                  foreach ($jurnaldetail as $jurnaldetBefor) {
                    $jurnaldetBefor->delete();
                  }
                }
                $jurnalBef->delete();
              }
            }
          }

          $modupdate = UangmukabeliT::model()->updateByPk($model->uangmukabeli_id, array('tglbataluangmuka' => $tglbatal, 'pegawaibatal_id' => $pegawaibatal_id, 'alasanbatalbayar' => $keterangan_batal, 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->id));

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
