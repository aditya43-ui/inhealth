
<?php
Yii::import('keuangan.models.*');
Yii::import('keuangan.controllers.PenerimaanUmumController');
class PenerimaanUmumBKController extends PenerimaanUmumController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";
  public $path_view = 'keuangan.views.penerimaanUmum.';

  public function actionIndex($id = null)
  {
    $modPenUmum = new KUPenerimaanUmumT;
    $modPenUmum->volume = 1;
    $modPenUmum->hargasatuan = 0;
    $modPenUmum->totalharga = 0;
    $modPenUmum->nomor = '-- Otomatis --';
    $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
    $modUraian[0] = new KUUraianpenumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;

    if (!empty($id)) {
      $modPenUmum->jenispenerimaan_id = 17;
      $jnsPen = JenispenerimaanM::model()->findByPk(17);
      if (!empty($jnsPen)) {
        $modPenUmum->jenisKodeNama = $jnsPen->jenispenerimaan_nama;
      }

      $pettyCash = PengajuanpettyT::model()->findByPk($id);
      $modPenUmum->hargasatuan = $pettyCash->pengajuanpetty_total;
      $modPenUmum->totalharga = $pettyCash->pengajuanpetty_total;

      //                    $pettyCashDet = PengajuanpettydetT::model()->findByAttributes(array('pengajuanpetty_id'=>$pettyCash->pengajuanpetty_id));
      //                    if(!empty($pettyCashDet)){
      //                        $modUraian[0] = new KUUraianpenumumT;
      //                        $modUraian[0]->uraiantransaksi = $pettyCashDet->pengajuanpettydet_item;
      //                        $modUraian[0]->volume = $pettyCashDet->pengajuanpettydet_qty;
      //                        $modUraian[0]->hargasatuan = $pettyCashDet->pengajuanpettydet_hargasatuan;
      //                        $modUraian[0]->totalharga = $pettyCashDet->pengajuanpettydet_subtotal;
      //                    }
    }



    $modTandaBukti = new KUTandabuktibayarT;
    $modTandaBukti->jmlpembulatan = 0;
    $modTandaBukti->biayaadministrasi = 0;
    $modTandaBukti->biayamaterai = 0;
    $modTandaBukti->jmlpembayaran = $modPenUmum->totalharga;
    $modTandaBukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
    $modJurnalRekening = array();
    $modJurnalDetail = array();
    $modJUrnalPosting = array();
    if (isset($_POST['KUPenerimaanUmumT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modTandaBukti = $this->saveTandaBukti($_POST['KUTandabuktibayarT']);
        $modPenUmum = $this->savePenerimaan($_POST['KUPenerimaanUmumT'], $modTandaBukti);

        if ($modPenUmum->isuraintransaksi && isset($_POST['KUUraianpenumumT'])) {
          $modUraian = $this->saveUraian($_POST['KUUraianpenumumT'], $modPenUmum);
        }

        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render(
      $this->path_view . 'index',
      array(
        'modPenUmum' => $modPenUmum,
        'modUraian' => $modUraian,
        'modTandaBukti' => $modTandaBukti,
        'modJurnalRekening' => $modJurnalRekening,
        'modJurnalDetail' => $modJurnalDetail,
        'modJurnalPosting' => $modJUrnalPosting,
        'modUraian' => $modUraian
      )
    );
  }
}
