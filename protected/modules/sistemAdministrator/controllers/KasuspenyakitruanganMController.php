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
class KasuspenyakitruanganMController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.kasuspenyakitruanganM.';

  /**
   * digunakan untuk menampilkan halaman utama kasus penyakit ruangan
   */
  public function actionIndex()
  {
    $this->render('index');
  }

  /**
   * digunakan untuk menampilkan halaman admin
   */
  public function actionAdmin()
  {
    $model = new SAKasuspenyakitruanganM('search');
    $model->unsetAttributes();
    if (isset($_GET['SAKasuspenyakitruanganM']))
      $model->attributes = $_GET['SAKasuspenyakitruanganM'];

    $this->render($this->path_view . 'admin', array('model' => $model));
  }

  /**
   * digunakan untuk fungsi tambah data
   */
  public function actionCreate()
  {
    $model = new SAKasuspenyakitruanganM;
    $ruangansession = Yii::app()->user->ruangan_id;
    $modDetails = array();

    if (isset($_POST['jeniskasuspenyakit_id'])) {
      $modDetails = $this->validasiTabular($_POST['jeniskasuspenyakit_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['jeniskasuspenyakit_id']); $i++) {
          $model = new SAKasuspenyakitruanganM;
          $model->ruangan_id = $_POST['ruangan_id'][$i];
          $model->jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'][$i];
          if ($model->save()) {
            $jumlah++;
          } else {
          }
        }

        if ($jumlah == count((array)$_POST['jeniskasuspenyakit_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal disimpan' . MyExceptionMessage::getMessage($ex));
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
  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new SAKasuspenyakitruanganM();
      $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDetails[$i]->jeniskasuspenyakit_id = $row;
      $modDetails[$i]->validate();
    }

    return $modDetails;
  }

  /**
   * digunakan untuk fungsi update 
   */
  public function actionUpdate()
  {
    $model = new SAKasuspenyakitruanganM;
    $ruangansession = Yii::app()->user->ruangan_id;
    $modDetails = array();

    if (isset($_POST['jeniskasuspenyakit_id'])) {
      $modDetails = $this->validasiTabular($_POST['jeniskasuspenyakit_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['jeniskasuspenyakit_id']); $i++) {
          $model = new SAKasuspenyakitruanganM;
          $model->ruangan_id = $_POST['ruangan_id'][$i];
          $model->jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'][$i];
          if ($model->save()) {
            $jumlah++;
          }
        }

        if ($jumlah == count((array)$_POST['jeniskasuspenyakit_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }

    $this->render($this->path_view . 'update', array('model' => $model, 'modDetails' => $modDetails));
  }

  /**
   * digunakan sebagai fitur delete
   * @param integer $ruangan_id menampung id ruangan
   * @param integer $jeniskasuspenyakit_id menampung id jensi kasus penyakit
   */
  public function actionDelete($ruangan_id, $jeniskasuspenyakit_id)
  {
    $this->loadModel($ruangan_id, $jeniskasuspenyakit_id)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * digunakan sebagai fitur view data
   * @param integer $id menampung id kasus penyakit
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * digunakan untuk load model
   * @param integer $id digunakan untuk menampung id kasus penyakit ruangan
   * @param string $jeniskasus menampung kriteria jenis kasus
   * @return object $model mengembalikan data yang terseleksi
   * @throws CHttpException ditampilkan jika terjadi kesalahan load data
   */
  public function loadModel($id, $jeniskasus = null)
  {
    if (!empty($jeniskasus)) {
      $model = SAKasuspenyakitruanganM::model()->findByAttributes(array('ruangan_id' => $id, 'jeniskasuspenyakit_id' => $jeniskasus));
    } else {
      $model = SAKasuspenyakitruanganM::model()->findByAttributes(array('ruangan_id' => $id));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * digunakan untuk fitur cetak
   */
  public function actionPrint()
  {
    $model = new SAKasuspenyakitruanganM;
    $model->unsetAttributes();
    if (isset($_REQUEST['SAKasuspenyakitruanganM'])) {
      $model->attributes = $_REQUEST['SAKasuspenyakitruanganM'];
    }
    $judulLaporan = 'Data Kasus Penyakit Ruangan';
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
   * digunakan untuk menampilkan data jenis kasus penyakit ruangan
   */
  public function actionJeniskasuspenyakitruangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

      $modInstalasi = InstalasiM::model()->findByPK($instalasi_id);
      $modRuangan = RuanganM::model()->findByPK($ruangan_id);

      $modJeniskasuspenyakitruangan = new SAKasuspenyakitruanganM();
      $modJeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPk($jeniskasuspenyakit_id);
      $tr = "<tr>";
      $tr .= "<td>"
        . $modInstalasi->instalasi_nama
        . CHtml::hiddenField('ruangan_id[]', $ruangan_id, array('readonly' => true))
        . CHtml::hiddenField('jeniskasuspenyakit_id[]', $jeniskasuspenyakit_id, array('readonly' => true)) . "</td>";
      $tr .= "<td>" . $modRuangan->ruangan_nama . "</td>";
      $tr .= "<td>" . $modJeniskasuspenyakit->jeniskasuspenyakit_nama . "</td>";
      $tr .= "<td>" . $modJeniskasuspenyakit->jeniskasuspenyakit_namalainnya . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='entypo-cancel'></i>", '#', array('onclick' => 'hapusBaris(this); return false;')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
