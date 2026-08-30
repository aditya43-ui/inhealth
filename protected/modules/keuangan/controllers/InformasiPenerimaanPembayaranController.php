<?php
class InformasiPenerimaanPembayaranController extends MyAuthController
{
  protected $successSave = true;
  protected $pesan = "succes";
  protected $path_view = "keuangan.views.informasiPenerimaanPembayaran.";

  public function actionIndex()
  {
    $model = new KUInformasipenerimaanpembayaranpiutangV();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tglbayar_awal = date('Y-m-d');
    $model->tglbayar_akhir = date('Y-m-d');
    $model->ceklis = false;

    if (isset($_GET['KUInformasipenerimaanpembayaranpiutangV'])) {
      $model->attributes = $_GET['KUInformasipenerimaanpembayaranpiutangV'];
      $model->ceklis = $_GET['KUInformasipenerimaanpembayaranpiutangV']['ceklis'];
      $model->status_pembayaran = $_GET['KUInformasipenerimaanpembayaranpiutangV']['status_pembayaran'];
      $model->status_pembatalan = $_GET['KUInformasipenerimaanpembayaranpiutangV']['status_pembatalan'];
      $model->tgl_awal = $format->formatDateTimeForDB($_GET['KUInformasipenerimaanpembayaranpiutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDB($_GET['KUInformasipenerimaanpembayaranpiutangV']['tgl_akhir']);
      $model->tglbayar_awal = $format->formatDateTimeForDB($_GET['KUInformasipenerimaanpembayaranpiutangV']['tglbayar_awal']);
      $model->tglbayar_akhir = $format->formatDateTimeForDB($_GET['KUInformasipenerimaanpembayaranpiutangV']['tglbayar_akhir']);
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function actionRincian($tandabuktibayar_id, $pembpiutangbank_id)
  {
    if (isset($_GET['caraPrint']) && ($_GET['caraPrint'] == "PRINT")) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }
    $modBuktibayar = TandabuktibayarT::model()->findByPk($tandabuktibayar_id);
    $modPembDetail = KUPembpiutangbankdetailT::model()->findAllByAttributes(array('pembpiutangbank_id' => $pembpiutangbank_id));
    $model = KUPembpiutangbankT::model()->findByPk($pembpiutangbank_id);

    $jenispembayaran = "";
    $banknama = "";

    if (isset($modPembDetail) && count((array)$modPembDetail) > 0) {
      foreach ($modPembDetail as $dataPem) {
        $banknama = (isset($dataPem->bank) ? $dataPem->bank->namabank : "-");
        $jenispembayaran = (isset($dataPem->jnspembayar) ? $dataPem->jnspembayar->jnspembayar_nama : "");
      }
    }

    $this->render($this->path_view . '_rincian', array(
      'modBuktibayar' => $modBuktibayar,
      'jenispembayaran' => $jenispembayaran,
      'model' => $model,
      'modPembDetail' => $modPembDetail,
      'banknama' => $banknama
    ));
  }


  public function actionBatalSetoranPajak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $pembpiutangbank_id = isset($_POST['pembpiutangbank_id']) ? $_POST['pembpiutangbank_id'] : null;
      $tandabuktibayar_id = isset($_POST['tandabuktibayar_id']) ? $_POST['tandabuktibayar_id'] : null;
      $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
      $pegawaibatal_id = isset($_POST['pegawaibatal_id']) ? $_POST['pegawaibatal_id'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

      $model = PembpiutangbankT::model()->findByPk($pembpiutangbank_id);
      $modDetail = PembpiutangbankdetailT::model()->findAllByAttributes(array('pembpiutangbank_id' => $pembpiutangbank_id));

      try {
        if (isset($model)) {
          $sukses = true;
          $deleteJurnal = true;

          if (isset($modDetail) && count((array)$modDetail) > 0) {
            foreach ($modDetail as $modDet) {
              $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('pembpiutangbankdetail_id' => $modDet->pembpiutangbankdetail_id));
              if (isset($modJurnalBefore)) {
                foreach ($modJurnalBefore as $jurnalBef) {
                  $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));
                  if (count((array)$jurnaldetail) > 0) {
                    foreach ($jurnaldetail as $jurnaldetBefor) {
                      $jurnaldetBefor->delete();
                    }
                  }
                  $deleteJurnal = $jurnalBef->delete();
                }
              }
            }
          }

          $modupdate = PembpiutangbankT::model()->updateByPk($model->pembpiutangbank_id, array('tglbatalbayar' => MyFormatter::formatDateTimeForDb($tglbatal), 'pegawaibatal_id' => $pegawaibatal_id, 'alasanbatal' => $keterangan_batal));

          if ($modupdate && $deleteJurnal) {
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
