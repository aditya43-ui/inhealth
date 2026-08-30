<?php
class InformasiSaranaPelayananController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = INProfilRumahSakitM::model()->findByPk(Params::getDefaultProfilRS());
    $fasilitas_utama_title = StaticPage::model()->find("header_static_page = 'fasilitas_utama_title'");
    $fasilitas_penunjang_title = StaticPage::model()->find("header_static_page = 'fasilitas_penunjang_title'");
    $fasilitas_utama = StaticPage::model()->findAllByAttributes(array('header_static_page' => 'fasilitas_utama'), array('order' => 'nama_static_page desc'));
    $fasilitas_penunjang = StaticPage::model()->findAllByAttributes(array('header_static_page' => 'fasilitas_penunjang'), array('order' => 'nama_static_page desc'));
    $modProduk = Produk::model()->findAllByAttributes(array("produk_aktif" => true), array('order' => 'produk_id desc'));

    $modFasilitas = StaticPage::model()->findByPk(65); //id fasilitas rawat jalan

    $this->render('index', array(
      'model' => $model,
      'fasilitas_utama_title' => $fasilitas_utama_title,
      'fasilitas_penunjang_title' => $fasilitas_penunjang_title,
      'fasilitas_utama' => $fasilitas_utama,
      'fasilitas_penunjang' => $fasilitas_penunjang,
      'modProduk' => $modProduk,
      'modFasilitas' => $modFasilitas
    ));
  }

  public function actionAjaxInfoFasilitas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['listData'];
      $modFasilitas = StaticPage::model()->findByPk($id);
      $form = $this->renderPartial('_fasilitas', array('modFasilitas' => $modFasilitas), true);

      $data['isidata'] = $form;
      echo json_encode($data);
    }
  }

  public function actionAjaxInfoProduk()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['listData'];
      $modProduk = Produk::model()->findByPk($id);
      $form = $this->renderPartial('_produk', array('modProduk' => $modProduk), true);

      $data['isidata'] = $form;
      echo json_encode($data);
    }
  }
}
