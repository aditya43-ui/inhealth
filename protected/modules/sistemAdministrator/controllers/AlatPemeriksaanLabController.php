<?php

class AlatPemeriksaanLabController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe'; //diakses dari : sistemAdministrator/MasterAlatLaboratorium
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.alatPemeriksaanLab.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render($this->path_view . 'view', array(
      'model' => $model,
    ));
  }

  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAPemeriksaanlabmappingM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Membuat dan menyimpan data baru / mengubah data lama.
   * id untuk load pemeriksaanlab_m (ajax)
   */
  public function actionCreate()
  {
    $model = new SAPemeriksaanlabmappingM;
    $modDetails = array();
    if (isset($_POST['nilairujukan_id'])) {
      $modDetails = $this->validasiTabular($_POST['nilairujukan_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['nilairujukan_id']); $i++) {
          $model = new SAPemeriksaanlabmappingM;
          $model->pemeriksaanlabalat_id = $_POST['pemeriksaanlabalat_id'][$i];
          $model->nilairujukan_id = $_POST['nilairujukan_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['nilairujukan_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('Error', 'Data gagal disimpan');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new SAPemeriksaanlabmappingM;
      $modDetails[$i]->pemeriksaanlabalat_id = $row;
      $modDetails[$i]->nilairujukan_id = $row;
      $modDetails[$i]->validate();
    }

    return $modDetails;
  }

  public function actionDelete()
  {
    $id = $_GET['id'];
    $this->loadModel($id['pemeriksaanlabalat_id'], $id['nilairujukan_id'])->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAPemeriksaanlabmappingM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPemeriksaanlabmappingM'])) {
      $model->attributes = $_GET['SAPemeriksaanlabmappingM'];
      $model->pemeriksaanlabalat_nama = !empty($_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_nama']) ? $_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_nama'] : null;
      $model->nilairujukan_nama = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_nama']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_nama'] : null;
      $model->pemeriksaanlabalat_kode = !empty($_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_kode']) ? $_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_kode'] : null;
      $model->kelompokdet = !empty($_GET['SAPemeriksaanlabmappingM']['kelompokdet']) ? $_GET['SAPemeriksaanlabmappingM']['kelompokdet'] : null;
      $model->namapemeriksaandet = !empty($_GET['SAPemeriksaanlabmappingM']['namapemeriksaandet']) ? $_GET['SAPemeriksaanlabmappingM']['namapemeriksaandet'] : null;
      $model->nilairujukan_min = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_min']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_min'] : null;
      $model->nilairujukan_max = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_max']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_max'] : null;
      $model->nilairujukan_satuan = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_satuan']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_satuan'] : null;
      $model->nilairujukan_jeniskelamin = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_jeniskelamin']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_jeniskelamin'] : null;
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id, $nilairujukan_id = null)
  {
    if (empty($pemeriksaanrad_id)) {
      $model = SAPemeriksaanlabmappingM::model()->findByAttributes(array('pemeriksaanlabalat_id' => $id));
    } else {
      $model = SAPemeriksaanlabmappingM::model()->findByAttributes(array('pemeriksaanlabalat_id' => $id, 'nilairujukan_id' => $nilairujukan_id));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
  /**
   * Memanggil data dari model berdasarkan pemeriksaanlab_id.
   * @param integer the ID of the model to be loaded
   */


  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapemeriksaanlabmapping-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAPemeriksaanlabmappingM;
    $model->attributes = $_REQUEST['SAPemeriksaanlabmappingM'];
    $model->pemeriksaanlabalat_nama = !empty($_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_nama']) ? $_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_nama'] : null;
    $model->nilairujukan_nama = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_nama']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_nama'] : null;
    $model->pemeriksaanlabalat_kode = !empty($_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_kode']) ? $_GET['SAPemeriksaanlabmappingM']['pemeriksaanlabalat_kode'] : null;
    $model->kelompokdet = !empty($_GET['SAPemeriksaanlabmappingM']['kelompokdet']) ? $_GET['SAPemeriksaanlabmappingM']['kelompokdet'] : null;
    $model->namapemeriksaandet = !empty($_GET['SAPemeriksaanlabmappingM']['namapemeriksaandet']) ? $_GET['SAPemeriksaanlabmappingM']['namapemeriksaandet'] : null;
    $model->nilairujukan_min = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_min']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_min'] : null;
    $model->nilairujukan_max = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_max']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_max'] : null;
    $model->nilairujukan_satuan = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_satuan']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_satuan'] : null;
    $model->nilairujukan_jeniskelamin = !empty($_GET['SAPemeriksaanlabmappingM']['nilairujukan_jeniskelamin']) ? $_GET['SAPemeriksaanlabmappingM']['nilairujukan_jeniskelamin'] : null;
    $judulLaporan = 'Data Pemeriksaan Alat Laboratorium';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanPDFNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionAutocompletePemeriksaanLabAlat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(pemeriksaanlabalat_nama)', strtolower($term), true);
      $criteria->addCondition('pemeriksaanlabalat_aktif = TRUE');
      $criteria->limit = 5;
      $models = SAPemeriksaanlabalatM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->pemeriksaanlabalat_nama;
        $returnVal[$i]['value'] = $model->pemeriksaanlabalat_id;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionPemeriksaanlabmapping()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pemeriksaanlabalat_id = $_POST['pemeriksaanlabalat_id'];
      $nilairujukan_id = $_POST['nilairujukan_id'];
      $modpemeriksaanlabalat = SAPemeriksaanlabalatM::model()->findByPK($pemeriksaanlabalat_id);
      $modnilairujukan = SANilairujukanM::model()->findByPK($nilairujukan_id);

      $tr = "<tr>";
      $tr .= "<td>"
        . CHtml::hiddenField('pemeriksaanlabalat_id[]', $pemeriksaanlabalat_id, array('readonly' => true))
        . $modpemeriksaanlabalat->pemeriksaanlabalat_nama . "</td>";
      $tr .= "<td>"
        . $modnilairujukan->kelkumurhasillab->kelkumurhasillabnama . "</td>";
      $tr .= "<td>"
        . $modnilairujukan->nilairujukan_jeniskelamin . "</td>";
      $tr .= "<td>"
        . $modnilairujukan->namapemeriksaandet . "</td>";
      $tr .= "<td>"
        . CHtml::hiddenField('nilairujukan_id[]', $nilairujukan_id, array('readonly' => true))
        . $modnilairujukan->nilairujukan_nama . "</td>";
      $tr .= "<td>"
        . $modnilairujukan->nilairujukan_min . "</td>";
      $tr .= "<td>"
        . $modnilairujukan->nilairujukan_max . "</td>";
      $tr .= "<td>"
        . $modnilairujukan->nilairujukan_satuan . "</td>";
      $tr .= "<td>"
        . $modnilairujukan->nilairujukan_metode . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='icon-remove'></i>", '#', array('onclick' => 'hapusBaris(this); return false;')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
