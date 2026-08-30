<?php

/**
 * digunakan untuk perbaikan tampilan modul rehab medis
 * BMB-198
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.sistemAdministrator
 * @subpackage      controllers
 * 
 */
class KasuspenyakitdiagnosaMController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.kasuspenyakitdiagnosaM.';

  /**
   * digunakan untuk menampilkan halaman utama kasus penyakit
   */
  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }

  /**
   * digunakan untuk menampilkan admin 
   */
  public function actionAdmin()
  {
    $model = new SAKasuspenyakitdiagnosaM('searchTabel');
    $model->unsetAttributes();
    if (isset($_GET['SAKasuspenyakitdiagnosaM'])) {
      $model->attributes = $_GET['SAKasuspenyakitdiagnosaM'];
      $model->diagnosa_kode = $_GET['SAKasuspenyakitdiagnosaM']['diagnosa_kode'];
      $model->diagnosa_nama = $_GET['SAKasuspenyakitdiagnosaM']['diagnosa_nama'];
      $model->diagnosa_namalainnya = $_GET['SAKasuspenyakitdiagnosaM']['diagnosa_namalainnya'];
    }
    $this->render($this->path_view . 'admin', array('model' => $model));
  }

  /**
   * digunakan untuk form tambah data
   * @throws Exception digunakan memunculkan eror
   */
  public function actionCreate()
  {
    $model = new SAKasuspenyakitdiagnosaM;
    $modDetails = array();
    if (isset($_POST['SAKasuspenyakitdiagnosaM'])) {

      $modDetails = $this->validasiTabular($model, $_POST['SAKasuspenyakitdiagnosaM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        foreach ($modDetails as $j => $row) {
          if ($row->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$modDetails)) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'create', array('model' => $model, 'modDetails' => $modDetails));
  }

  /**
   * digunakan untuk validasi
   * @param object $model model yang dipakai
   * @param array $data data yang di validasi
   * @return \SAKasuspenyakitdiagnosaM mengembalikan data yang lolos validasi tabular
   */
  protected function validasiTabular($model, $data)
  {
    foreach ($data as $i => $row) {
      if (is_array($row)) {
        $modDetails[$i] = new SAKasuspenyakitdiagnosaM;
        $modDetails[$i]->attributes = $row;
        $modDetails[$i]->validate();
        //                        echo '<pre>'.print_r($modDetails[$i]->attributes);
      }
    }
    //                    echo count((array)$modDetails);
    //                    exit();
    return $modDetails;
  }

  /**
   * digunakan untuk fungsi update 
   * @param integer $id menampung id 
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE))
    // {
    //     throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));
    // }
    $model = new SAKasuspenyakitdiagnosaM;
    $modDetails = array();
    if (isset($_POST['SAKasuspenyakitdiagnosaM'])) {
      $jmlhsave = 0;
      foreach ($_POST['SAKasuspenyakitdiagnosaM'] as $value => $row) {
        //                                $modKasuspenyakitdiagnosa = SAKasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id'=>$row['jeniskasuspenyakit_id'],'diagnosa_id'=>$row['diagnosa_id']));
        $model = new SAKasuspenyakitdiagnosaM;
        $model->attributes = $row;
        $model->save();
        $jmlhsave++;
      }
      if ($jmlhsave == count((array)$_POST['SAKasuspenyakitdiagnosaM'])) {
        Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
      //                        $modDetails = $this->validasiTabular($model, $_POST['SAKasuspenyakitdiagnosaM']);
      //                        $transaction = Yii::app()->db->beginTransaction();
      //                        try {
      //                            $jumlah = 0;
      //                            foreach ($modDetails as $j=>$row)
      //                            {
      //                                if($row->save()) {
      //                                    $jumlah++;
      //                                }
      //                            }
      //                            if ($jumlah == count((array)$modDetails)) {
      //                                $transaction->commit();
      //                                Yii::app()->user->setFlash('success','<strong>Berhasil</strong> Data Berhasil disimpan');
      //                                $this->redirect(array('admin'));
      //                            } else {
      //                                throw new Exception('Error');
      //                            }
      //                        }
      //                        catch(Exception $ex) {
      //                            $transaction->rollback();
      //                            Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan'.MyExceptionMessage::getMessage($ex));
      //                        }
    }
    $this->render($this->path_view . 'update', array('model' => $model, 'modDetails' => $modDetails));
  }

  /**
   * digunakan untuk fungsi delete
   * @param integer $jeniskasuspenyakit_id menampung id jenis kasus penyakit
   * @param integer $diagnosa_id menampung id diagnosa 
   */
  public function actionDelete($jeniskasuspenyakit_id, $diagnosa_id)
  {
    $this->loadModel($jeniskasuspenyakit_id, $diagnosa_id)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * untuk autocomplete jenis kasus penyakit
   */
  public function actionAutocompleteJenisKasusPenyakit()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition("jeniskasuspenyakit_aktif = TRUE");
      $criteria->order = 'jeniskasuspenyakit_nama';
      $criteria->limit = 10;
      $models = JeniskasuspenyakitM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jeniskasuspenyakit_nama;
        $returnVal[$i]['value'] = $model->jeniskasuspenyakit_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Autocomplete Diagnosa
   */
  public function actionAutocompleteDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition("diagnosa_aktif = TRUE");
      $criteria->order = 'diagnosa_nama';
      $criteria->limit = 10;
      $models = DiagnosaM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->diagnosa_kode . '-' . $model->diagnosa_nama;
        $returnVal[$i]['value'] = $model->diagnosa_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk menampilkan view
   * @param integer $id menampung id yang dipilih
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * 
   * @param integer $id menampung data id yang diseleksi 
   * @param string $diagnosa menampung diagnosa
   * @return object $model menampung data yang dipilih
   * @throws CHttpException manampilkan exception jika terjadi kesalahan
   */
  public function loadModel($id, $diagnosa = null)
  {
    if (empty($diagnosa)) {
      $model = SAKasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id' => $id));
    } else {
      $model = SAKasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id' => $id, 'diagnosa_id' => $diagnosa));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * digunakan untuk fungsi cetak kasus penyakit diagnosa
   */
  public function actionPrint()
  {
    $model = new SAKasuspenyakitdiagnosaM;
    $model->attributes = $_REQUEST['SAKasuspenyakitdiagnosaM'];
    $model->diagnosa_kode = $_REQUEST['SAKasuspenyakitdiagnosaM']['diagnosa_kode'];
    // $model->diagnosa_nourut = $_REQUEST['SAKasuspenyakitdiagnosaM']['diagnosa_nourut'];
    $model->diagnosa_nama = $_REQUEST['SAKasuspenyakitdiagnosaM']['diagnosa_nama'];
    $model->diagnosa_namalainnya = $_REQUEST['SAKasuspenyakitdiagnosaM']['diagnosa_namalainnya'];

    $judulLaporan = 'Data Diagnosa Kasus Penyakit';
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
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * load ajax detail kasus
   */
  public function actionGetKasusPenyakitDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'];
      $diagnosa_id = $_POST['diagnosa_id'];

      $modjeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPK($jeniskasuspenyakit_id);
      $moddiagnosa = DiagnosaM::model()->findByPK($diagnosa_id);

      $modKasuspenyakitdiagnosa = new SAKasuspenyakitdiagnosaM;
      $tr = "<tr>";
      $tr .= "<td>"
        . $modjeniskasuspenyakit->jeniskasuspenyakit_nama
        . CHtml::activehiddenField($modKasuspenyakitdiagnosa, '[]jeniskasuspenyakit_id', array('readonly' => true, 'value' => $jeniskasuspenyakit_id, 'class' => 'jenispenyakit'))
        . CHtml::activehiddenField($modKasuspenyakitdiagnosa, '[]diagnosa_id', array('readonly' => true, 'value' => $diagnosa_id))
        . "</td>";
      $tr .= "<td>" . $moddiagnosa->diagnosa_kode . ' - ' . $moddiagnosa->diagnosa_nama . "</td>";
      $tr .= "<td>" . $moddiagnosa->diagnosa_namalainnya . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusBaris(this);return false;')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
