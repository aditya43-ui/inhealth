<?php

/**
 * digunakan untuk pembuatan informasi
 * RSST-3852  
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.informasi
 * @subpackage controllers
 **/
class InformasiEdukasiController extends MyAuthController
{
  public $path_view = 'pendidikanKlinis.views.informasiEdukasi.';
  public $simpanevaluasi = true;
  public $simpanevaluasidetail = true;
  /**
   * Menampilkan data informasi edukasi 
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Edukasi";
    $model = new INEdukasipkrsT();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");

    if (!empty($_GET['INEdukasipkrsT'])) {
      $model->attributes = $_GET['INEdukasipkrsT'];

      $model->bentuk_edukasi = $_GET['INEdukasipkrsT']['bentuk_edukasi'];
      $model->metode_edukasi = $_GET['INEdukasipkrsT']['metode_edukasi'];

      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['INEdukasipkrsT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['INEdukasipkrsT']['tgl_akhir']);
    }
    $this->render(
      'index',
      array(
        'model' => $model,

      )
    );
  }
  /**
   * Menampilkan detail edukasi ppds berdasarkan id nya
   * @params $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = INEdukasipkrsT::model()->findByPk($id);

    $this->render(
      '_detail',
      array(
        'data' => $model,

      )
    );
  }


  /**
   * Fungsi unduh file 
   * @param type $id
   */
  public function actionUnduh($id)
  {
    $filename = INEdukasipkrsT::model()->findByPk($id);
    $path = Params::pathEdukasiPTRS() . "/" . $filename->file_lampiran;
    if (!empty($filename->file_lampiran)) {
      if (file_exists($path)) {
        Yii::app()->getRequest()->sendFile($filename->file_lampiran, file_get_contents($path));
      } else {
        Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathKenaikangajiTDirectory() . 'file_tidak_ditemukan.txt'));
      }
    } else {
      Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathKenaikangajiTDirectory() . 'file_tidak_ditemukan.txt'));
    }
  }

  /**
   * digunakan untuk delete data 
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {

      if (!empty($_POST['id'])) {

        $sukses = false;

        $trans = Yii::app()->db->beginTransaction();
        try {

          $dir_gambar = INEdukasipkrsT::model()->findByAttributes(['edukasipkrs_id' => $_POST['id']]); //mencari file yang mempunyai id edukasipkrs yang sama

          if (!empty($dir_gambar->file_lampiran)) {
            // hapus gambar dari direktori
            if (file_exists(Params::pathEdukasiPTRS() . $dir_gambar->file_lampiran)) {
              unlink(Params::pathEdukasiPTRS() . $dir_gambar->file_lampiran);
            }
          }

          $sukses = INEdukasipkrsT::model()->deleteByPk($_POST['id']);

          if ($sukses) {
            $trans->commit();
            $data['status'] = 'sukses';
          } else {

            $data['status'] = 'gagal';
            $trans->rollback();
          }
        } catch (Exception $ex) {

          $data['status'] = 'gagal';
          $trans->rollback();
        }
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
