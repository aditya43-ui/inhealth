<?php
Yii::import('rawatInap.controllers.AsesmenAwalMedisController');
/**
 * contoller utama untuk menampilkan data pada dashboard/beranda
 * 
 * @package     application.modules.smsCenter
 * @subpackage  controllers 
 * @author      Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link        http://172.9.1.15/simpp/docs/
 * 
 */
class BerandaController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'smsCenter.views.beranda.';
  public $init = '';

  /**
   * action ini digunakan untuk masuk ke halaman beranda
   */
  public function actionIndex()
  {
    $model = new SCustomModel();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    $this->render($this->path_view . 'index', array(
      'model' => $model
    ));
  }

  /**
   * mencari data sesuai periode laporan
   */
  public function actionCariData()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tgl_awal = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : null;
      $tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : null;


      $model = new LICustomModel();
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($tgl_awal);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($tgl_akhir);

      $data = $model->generateBeranda();

      $return['sukses'] = 1;
      $return['tile'] = $data['tile'];
      $return['pie'] = $data['grafik'];
      $return['table'] = $data['tabel'];

      echo json_encode($return);
      Yii::app()->end();
    }
  }

  /**
   * fungsi detail untuk melihat penelitian
   * @param type $penelitian_id
   * @return type
   */
  public function actionDetail($penelitian_id)
  {

    $con = new PenelitianTController($module = '');

    return $con->actionDetail($penelitian_id);
  }
}
