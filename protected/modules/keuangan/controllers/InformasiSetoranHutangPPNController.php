<?php
class InformasiSetoranHutangPPNController extends MyAuthController
{
  protected $successSave = true;
  protected $pesan = "succes";
  protected $path_view = "keuangan.views.informasiSetoranHutangPPN.";

  public function actionIndex()
  {
    $model = new KUInformasisetoranppnkeluaranV();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tglnyetor_awal = date('Y-m-d');
    $model->tglnyetor_akhir = date('Y-m-d');
    $model->ceklis = false;

    if (isset($_GET['KUInformasisetoranppnkeluaranV'])) {
      $model->attributes = $_GET['KUInformasisetoranppnkeluaranV'];
      $model->ceklis = $_GET['KUInformasisetoranppnkeluaranV']['ceklis'];
      $model->status_penyetoran = $_GET['KUInformasisetoranppnkeluaranV']['status_penyetoran'];
      $model->status_pembatalan = $_GET['KUInformasisetoranppnkeluaranV']['status_pembatalan'];
      $model->tgl_awal = $format->formatDateTimeForDB($_GET['KUInformasisetoranppnkeluaranV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDB($_GET['KUInformasisetoranppnkeluaranV']['tgl_akhir']);
      $model->tglnyetor_awal = $format->formatDateTimeForDB($_GET['KUInformasisetoranppnkeluaranV']['tglnyetor_awal']);
      $model->tglnyetor_akhir = $format->formatDateTimeForDB($_GET['KUInformasisetoranppnkeluaranV']['tglnyetor_akhir']);
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function actionRincian($tandabuktikeluar_id)
  {
    if (isset($_GET['caraPrint']) && ($_GET['caraPrint'] == "PRINT")) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }

    $totalhutang = 0;
    $totalsisahutang = 0;
    $jmlpembayaran = 0;
    $tglsetoran = "";
    $pajak_nama = "";

    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
    $model = SetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));

    if (count((array)$model) > 0) {
      foreach ($model as $dataSetor) {
        $totalhutang += $dataSetor->totalhutang;
        $totalsisahutang += $dataSetor->totalsisahutang;
        $jmlpembayaran += $dataSetor->jmlpembayaran;
        $tglsetoran = MyFormatter::formatDateTimeForUser($dataSetor->tglsetoranpajak);
        $pajak_nama = (isset($dataSetor->pajak) ? $dataSetor->pajak->pajak_nama : "");
      }
    }
    $judulRincian = "RINCIAN SETORAN HUTANG PPN KELUARAN";

    $this->render($this->path_view . '_rincian', array(
      'modBuktiKeluar' => $modBuktiKeluar,
      'totalhutang' => $totalhutang,
      'totalsisahutang' => $totalsisahutang,
      'tglsetoran' => $tglsetoran,
      'jmlpembayaran' => $jmlpembayaran,
      'model' => $model,
      'pajak_nama' => $pajak_nama,
      'judulRincian' => $judulRincian
    ));
  }


  public function actionBatalSetoranPajak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $keterangan = "";

      $tandabuktikeluar_id = isset($_POST['tandabuktikeluar_id']) ? $_POST['tandabuktikeluar_id'] : null;
      $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
      $pegawaibatal_id = isset($_POST['pegawaibatal_id']) ? $_POST['pegawaibatal_id'] : null;
      $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

      $model = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);

      try {
        if (isset($model)) {
          $sukses = true;
          $moddetails = KUSetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $tandabuktikeluar_id));

          if (count((array)$moddetails) > 0) {
            foreach ($moddetails as $dataDet) {
              $modupdate = KUSetoranpajakT::model()->updateByPk($dataDet->setoranpajak_id, array('tglbatalsetor' => MyFormatter::formatDateTimeForDb($tglbatal), 'batalpegawai_id' => $pegawaibatal_id, 'alasanbatal' => $keterangan_batal));

              if (!$modupdate) {
                $sukses = false;
              }
            }
          }
          $deleteJurnal = true;

          $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $tandabuktikeluar_id));
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


          if ($sukses && $deleteJurnal) {
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
