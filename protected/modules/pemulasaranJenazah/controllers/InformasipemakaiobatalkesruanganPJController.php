<?php
Yii::import('farmasiApotek.models.*');
Yii::import('farmasiApotek.controllers.InformasipemakaiobatalkesruanganVController');
class InformasipemakaiobatalkesruanganPJController extends InformasipemakaiobatalkesruanganVController
{
  public $defaultAction = 'index';
  public $path_view = 'farmasiApotek.views.informasipemakaiobatalkesruanganV.';

  public function actionIndex()
  {
    $model = new FAInformasipemakaiobatalkesruanganV('searchInformasi');
    $format = new MyFormatter();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");

    if (isset($_GET['FAInformasipemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['FAInformasipemakaiobatalkesruanganV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipemakaiobatalkesruanganV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
    ));
  }

  // Aksi untuk membatalkan obat
  public function actionBatalPakaiObat()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isAjaxRequest) {
      //					$detail = array();
      $delete_stok = false;
      $sukses = false;
      $id = $_POST['id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        /* dicomment karena belum ada proses
				 * $detail=  GFReturDetailT::model()->findAllByAttributes(array('returpembelian_id'=>$id));
				  $pembelian = GFReturPembelianT::model()->findByPk($id);


				  foreach ($detail as $i => $returdetail) {
					$stokoa = GFStokObatAlkesT::model()->findByAttributes(array('returdetail_id'=>$returdetail->returdetail_id));
					if (count((array)$stokoa) > 0){
						$stokoa->delete();
						$update_penerimaan = GFPenerimaanDetailT::model()->updateAll(array('returdetail_id'=>null),'returdetail_id='.$returdetail->returdetail_id);
						$delete_stok = true;
					}
				  }

				  if($delete_stok == true){
					$detail=GFReturDetailT::model()->deleteAllByAttributes(array('returpembelian_id'=>$id));
					if($detail){
						$pembelian=  GFReturPembelianT::model()->deleteByPk($id);
					}
					if($detail&&$pembelian){
						$transaction->commit();
						$sukses = true;
					}
				  } */

        $sukses = true;

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

  /**
   * menampilkan url lihat karna setiap modul berbeda
   */
  public function getUrlRincian()
  {
    return $this->createUrl('PemakaianObatPJ/rincianDetail');
  }

  /**
   * url ubah karna setiap modul berbeda
   */
  public function getUrlUbah()
  {
    return $this->createUrl('PemakaianObatPJ/Index');
  }
}
