<?php
class InformasiSuratInternalController extends MyAuthController
{
  public $layout = '//layouts/column1';
  protected $path_view = "kepegawaian.views.informasiSuratInternal.";
  
  public function actionIndex()
  {
    $model = new SuratinternalT();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['SuratinternalT'])) {
      $model->attributes = $_GET['SuratinternalT'];
      $model->tgl_awal = $format->formatDateTimeForDB($_GET['SuratinternalT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDB($_GET['SuratinternalT']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function actionDownload($suratinternal_id) {
    $model = SuratinternalT::model()->findByAttributes(array('suratinternal_id'=>$suratinternal_id));
    
    $file = Params::pathDokumenSuratInternalDirectory().$model->dokumen;
    
    if (file_exists($file)) {
  
        header('Content-Description: File Transfer');
        header('Content-Type: '.mime_content_type($file));
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
  }

  public function actionRincian($suratinternal_id)
  {
    $this->layout = '//layouts/iframe';
    $model = SuratinternalT::model()->findByPk($suratinternal_id);
    $modDetail = PihaksuratinternalT::model()->findAllByAttributes(array('suratinternal_id' => $model->suratinternal_id));

    if(!empty($model->unitkerja_penanggungjawab_id)){
      $modUnit = UnitkerjaM::model()->findByAttributes(array('unitkerja_id'=>$model->unitkerja_penanggungjawab_id));
      $model->unitkerja_penanggungjawab_nama = (!empty($modUnit)?$modUnit->namaunitkerja:"");
    } 

    $this->render($this->path_view . '_rincian', array(
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

}
