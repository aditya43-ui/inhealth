<?php
/**
 * contoller utama menu transaksi edukasi
 * issue RSST-1660, RSST-2588
 * 
 * @author          Yusuf Putra A <yusufinova@gmail.com>, M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
class TransaksiEdukasipkrsController extends MyAuthController
{
  /**
   * action utama untuk mengakses menu transaksi edukasi
   * @param integer $edukasipkrs_id
   */
  public $path_view = 'informasi.views.transaksiEdukasipkrs.';


  public function actionIndex($edukasipkrs_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Edukasi";
    $ok = true;
    $model = new INEdukasipkrsT();

    if (!empty($edukasipkrs_id)) {
      $model = INEdukasipkrsT::model()->findByPk($edukasipkrs_id);
      $modDok = UploadedukasiT::model()->findAllByAttributes($edukasipkrs_id);
      
      if (!empty($modDok->uploadfile_id)) {
        $temp_path_file = $modDok->filepath;
        $modDok->filepath = $temp_path_file;
      }
    }
    
    if (isset($_POST['INEdukasipkrsT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $format = new MyFormatter();
        $model->attributes = $_POST['INEdukasipkrsT'];
        $model->tgledukasi = $format->formatDateTimeForDb($_POST['INEdukasipkrsT']['tgledukasi']);
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $ok &= $model->save();
        
        if(isset($_FILES['UploadedukasiT'])){
          $total_count = count($_FILES['UploadedukasiT']['name']);
          for( $i=0 ; $i < $total_count ; $i++ ) {
            $modDok = new UploadedukasiT();
            $modDok->attributes = $_POST['UploadedukasiT'];
            $modDok->upload_time = date('Y-m-d');
            $modDok->edukasipkrs_id = $model->edukasipkrs_id;

            $path = Params::pathEdukasiPTRS();
            $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s'))) . '.pdf';
            $fullImgSource = $path . $fullImgName;
            
            $temp = $_FILES['UploadedukasiT']['tmp_name'][$i]['namafile'];
            
            if (!empty($temp)) {
              if (!file_exists($path)) {
                mkdir($path, 0777);
              }
            } 
            
            $modDok->namafile = $fullImgName;
            $modDok->filepath = $fullImgSource;
            if ($modDok->save()) {
                move_uploaded_file($temp, $fullImgSource);
                $ok &= $modDok->save();
              }
          }
      }

        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('Index', 'edukasipkrs_id' => $model->edukasipkrs_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }
}
