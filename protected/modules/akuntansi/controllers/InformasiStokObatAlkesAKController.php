<?php
//Yii::import("gudangFarmasi.controllers.InformasiStokObatAlkesController");
YII::import("gudangFarmasi.models.*");
class InformasiStokObatAlkesAKController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'akuntansi.views.informasiStokObatAlkesAK.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Kartu Stock Farmasi";
    //$model=new GFInformasistokobatalkesV('search');
    //
    /*
        $model = new GFObatalkesM;             
        $model->unsetAttributes();
        if(isset($_GET['GFObatalkesM'])){
            $model->attributes=$_GET['GFObatalkesM'];
            //if(empty($model->ruangan_id)){ $model->ruangan_id=Yii::app()->user->getState('ruangan_id'); }
        } */
    // $instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiStokOas(),'instalasi_id','instalasi_nama');
    // $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganStokOas(Params::INSTALASI_ID_FARMASI),'ruangan_id','ruangan_nama');
    //if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_FARMASI){
    $model = new GFInfostokobatalkesruanganV('search');
    $model->unsetAttributes();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['GFInfostokobatalkesruanganV'])) {
      $model->attributes = $_GET['GFInfostokobatalkesruanganV'];
      $model->jnskelompok = $_GET['GFInfostokobatalkesruanganV']['jnskelompok'];
      //if(empty($model->ruangan_id)){ $model->ruangan_id=Yii::app()->user->getState('ruangan_id'); }
    }
    //}
    $format = new MyFormatter();


    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      //'instalasiAsals'=>$instalasiAsals,
      //'ruanganAsals'=>$ruanganAsals,
    ));
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganStokOas($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
