<?php
Yii::import('billingKasir.controllers.PemakaianBmhpController');
Yii::import("billingKasir.controllers.TindakanRawatJalanController");
class DietPasienController extends TindakanRawatJalanController
{
  public $layout = "//layouts/iframe";
  public $path_view_rj = "billingKasir.views.tindakanRawatJalan.";
  public $path_view = "billingKasir.views.dietPasien.";

  /**
   * menghapus tindakanpelayanan (ajax)
   */
  public function actionHapusTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $loadTindakanPelayanan = TindakanpelayananT::model()->findByPk($_POST['tindakanpelayanan_id']);
        $deleteTindakanKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $_POST['tindakanpelayanan_id']));
        $deleteObatAlkes = ObatalkespasienT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $_POST['tindakanpelayanan_id']));
        if ($loadTindakanPelayanan->delete()) {
          $transaction->commit();
          $data['pesan'] = "Menu Diet Pasien berhasil dihapus!";
          $data['sukses'] = 1;
        } else {
          $transaction->rollback();
          $data['pesan'] = "Menu Diet Pasien gagal dihapus!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Menu Diet Pasien gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
