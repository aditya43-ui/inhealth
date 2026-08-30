<?php

class InformasiReturPembelianController extends MyAuthController
{
  public $path_view = "gudangFarmasi.views.informasiReturPembelian.";
  public function actionIndex()
  {
    $model = new GFInformasireturpembelianV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tglterimafaktur = date('Y-m-d');
    $model->tglfaktur = date('Y-m-d');

    if (isset($_GET['GFInformasireturpembelianV'])) {
      $model->attributes = $_GET['GFInformasireturpembelianV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasireturpembelianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasireturpembelianV']['tgl_akhir']);
      $model->tglterimafaktur = $format->formatDateTimeForDb($_GET['GFInformasireturpembelianV']['tglterimafaktur']);
      $model->tglfaktur = $format->formatDateTimeForDb($_GET['GFInformasireturpembelianV']['tglfaktur']);
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  // Aksi untuk membatalkan Retur Pembelian
  public function actionBatalRetur()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isAjaxRequest) {
      //					$detail = array();
      $delete_stok  = false;
      $sukses = false;
      $id = $_POST['id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $detail =  GFReturDetailT::model()->findAllByAttributes(array('returpembelian_id' => $id));
        $pembelian = GFReturPembelianT::model()->findByPk($id);


        foreach ($detail as $i => $returdetail) {
          $stokoa = GFStokObatAlkesT::model()->findByAttributes(array('returdetail_id' => $returdetail->returdetail_id));
          if (!empty($stokoa)) {
            $stokoa->delete();
            $update_penerimaan = GFPenerimaanDetailT::model()->updateAll(array('returdetail_id' => null), 'returdetail_id=' . $returdetail->returdetail_id);
            $delete_stok = true;
          }
        }

        if ($delete_stok == true) {
          $detail = GFReturDetailT::model()->deleteAllByAttributes(array('returpembelian_id' => $id));
          if ($detail) {
            $pembelian =  GFReturPembelianT::model()->deleteByPk($id);
          }
          if ($detail && $pembelian) {
            $transaction->commit();
            $sukses = true;
          }
        }

        if ($sukses == true) {
          echo CJSON::encode(array(
            'status' => 'delete',
          ));
        }
      } catch (Exception $e) {
        $transaction->rollback();
        echo CJSON::encode(array(
          'status' => 'gagal',
        ));
        exit;
      }
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
