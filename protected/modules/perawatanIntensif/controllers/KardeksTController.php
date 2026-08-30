<?php

class KardeksTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';
  public $path_view = "perawatanIntensif.views.kardeksT.";

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $pasien = InfopasienmasukkamarV::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $kardeks = KardeksT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ), array(
      'order' => 'pemeriksaan_ke asc',
    ));

    $kardeks_chart = array(
      'label' => array(),
      'suhu' => array(),
      'nadi' => array(),
      'sistol' => array(),
      'diastol' => array(),
      'rr' => array(),
      'spo2' => array(),
    );
    foreach ($kardeks as $i => $item) {
      $kardeks_chart['label'][] = date('H:i', strtotime($item->tgl_pemeriksaan));
      $kardeks_chart['suhu'][] = (empty($item->hemo_dewasa_suhu) || !is_numeric($item->hemo_dewasa_suhu)) ? 0 : $item->hemo_dewasa_suhu;
      $kardeks_chart['nadi'][] = (empty($item->hemo_dewasa_nadi) || !is_numeric($item->hemo_dewasa_nadi)) ? 0 : $item->hemo_dewasa_nadi;
      $kardeks_chart['sistol'][] = (empty($item->hemo_dewasa_sistol) || !is_numeric($item->hemo_dewasa_sistol)) ? 0 : $item->hemo_dewasa_sistol;
      $kardeks_chart['diastol'][] = (empty($item->hemo_dewasa_diastol) || !is_numeric($item->hemo_dewasa_diastol)) ? 0 : $item->hemo_dewasa_diastol;
      $kardeks_chart['rr'][] = (empty($item->hemo_dewasa_rr) || !is_numeric($item->hemo_dewasa_rr)) ? 0 : $item->hemo_dewasa_rr;
      $kardeks_chart['spo2'][] = (empty($item->hemo_dewasa_spo2 || !is_numeric($item->hemo_dewasa_spo2))) ? 0 : $item->hemo_dewasa_spo2;
    }

    // var_dump($kardeks_chart); die;

    $this->render($this->path_view . 'view', array(
      'pasien' => $pasien,
      'kardeks' => $kardeks,
      'kardeks_chart' => $kardeks_chart,
      'pendaftaran_id' => $pendaftaran_id,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $model = new KardeksT;
    $model->pendaftaran_id = $pendaftaran_id;
    $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->setPemeriksaanKe();
    $model->balance_konstanta = 15;

    $modelAda = KardeksT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    if (!empty($modelAda)) {
      $model->kardeks_dewasa = $modelAda->kardeks_dewasa ? 1 : 0;
    }


    if (isset($_POST['KardeksT'])) {
      $model->attributes = $_POST['KardeksT'];
      $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForDB($model->tgl_pemeriksaan);
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      $model->balance_beratbadan = str_replace(",", ".", $model->balance_beratbadan);

      // var_dump($model->attributes, $_POST); die;

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'pendaftaran_id' => $pendaftaran_id));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($pendaftaran_id, $kardeks_id)
  {
    $this->layout = '//layouts/iframe';

    $model = $this->loadModel($kardeks_id);
    $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

    $model->balance_konstanta = str_replace(".", ",", $model->balance_konstanta);
    $model->balance_beratbadan = str_replace(".", ",", $model->balance_beratbadan);
    $model->balance_jmlcairan = str_replace(".", ",", $model->balance_jmlcairan);
    $model->balance_iwl = str_replace(".", ",", $model->balance_iwl);
    $model->balance_konstanta_suhu = str_replace(".", ",", $model->balance_konstanta_suhu);
    $model->balance_kenaikan_suhu = str_replace(".", ",", $model->balance_kenaikan_suhu);
    $model->balance_iwl_kenaikan_suhu = str_replace(".", ",", $model->balance_iwl_kenaikan_suhu);
    $model->balance_total_intake = str_replace(".", ",", $model->balance_total_intake);
    $model->balance_total_output = str_replace(".", ",", $model->balance_total_output);
    $model->balance_total_sekarang = str_replace(".", ",", $model->balance_total_sekarang);
    $model->balance_total_sebelum = str_replace(".", ",", $model->balance_total_sebelum);
    $model->balance_total_komulatif = str_replace(".", ",", $model->balance_total_komulatif);

    $model->kardeks_dewasa = $model->kardeks_dewasa ? 1 : 0;

    // var_dump($model->attributes); die;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KardeksT'])) {
      $kardeks_id = $model->kardeks_id;
      $create_time = $model->create_time;
      $create_loginpemakai_id = $model->create_loginpemakai_id;
      $create_ruangan = $model->create_ruangan;

      $model->unsetAttributes();
      $model->kardeks_id = $kardeks_id;
      $model->create_time = $create_time;
      $model->create_loginpemakai_id = $create_loginpemakai_id;
      $model->create_ruangan = $create_ruangan;
      $model->attributes = $_POST['KardeksT'];
      $model->tgl_pemeriksaan = MyFormatter::formatDateTimeForDB($model->tgl_pemeriksaan);
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai_id = Yii::app()->user->id;

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'pendaftaran_id' => $pendaftaran_id));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $id = $_POST['kardeks_id'];
      $res = $this->loadModel($id)->delete();

      if($res) {
        $data['sukses'] = 1;
      } else {
        $data['sukses'] = 0;
      }
      
      echo json_encode($data);
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }


  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KardeksT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kardeks-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint($pendaftaran_id, $caraPrint = 'PRINT')
  {
    $this->layout = '//layouts/iframe';

    $pasien = InfopasienmasukkamarV::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    $kardeks = KardeksT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ), array(
      'order' => 'pemeriksaan_ke asc',
    ));

    $kardeks_chart = array(
      'label' => array(),
      'suhu' => array(),
      'nadi' => array(),
      'sistol' => array(),
      'diastol' => array(),
      'rr' => array(),
      'spo2' => array(),
    );
    foreach ($kardeks as $i => $item) {
      $kardeks_chart['label'][] = date('H:i', strtotime($item->tgl_pemeriksaan));
      $kardeks_chart['suhu'][] = (empty($item->hemo_dewasa_suhu) || !is_numeric($item->hemo_dewasa_suhu)) ? 0 : $item->hemo_dewasa_suhu;
      $kardeks_chart['nadi'][] = (empty($item->hemo_dewasa_nadi) || !is_numeric($item->hemo_dewasa_nadi)) ? 0 : $item->hemo_dewasa_nadi;
      $kardeks_chart['sistol'][] = (empty($item->hemo_dewasa_sistol) || !is_numeric($item->hemo_dewasa_sistol)) ? 0 : $item->hemo_dewasa_sistol;
      $kardeks_chart['diastol'][] = (empty($item->hemo_dewasa_diastol) || !is_numeric($item->hemo_dewasa_diastol)) ? 0 : $item->hemo_dewasa_diastol;
      $kardeks_chart['rr'][] = (empty($item->hemo_dewasa_rr) || !is_numeric($item->hemo_dewasa_rr)) ? 0 : $item->hemo_dewasa_rr;
      $kardeks_chart['spo2'][] = (empty($item->hemo_dewasa_spo2 || !is_numeric($item->hemo_dewasa_spo2))) ? 0 : $item->hemo_dewasa_spo2;
    }

    // var_dump($kardeks_chart); die;

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows_delay';
      $this->render($this->path_view . 'Print', array(
        'pasien' => $pasien,
        'kardeks' => $kardeks,
        'kardeks_chart' => $kardeks_chart,
        'pendaftaran_id' => $pendaftaran_id,
        'caraPrint' => $caraPrint,
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array(
        'pasien' => $pasien,
        'kardeks' => $kardeks,
        'kardeks_chart' => $kardeks_chart,
        'pendaftaran_id' => $pendaftaran_id,
        'caraPrint' => $caraPrint,
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = 'L'; //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = true;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array(
        'pasien' => $pasien,
        'kardeks' => $kardeks,
        'kardeks_chart' => $kardeks_chart,
        'pendaftaran_id' => $pendaftaran_id,
        'caraPrint' => $caraPrint,
      ), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRM($pendaftaran_id, $caraPrint = 'PRINT')
  {
    $this->layout = '//layouts/iframe';

    $pasien = PendaftaranT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    $kardeks = KardeksT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ), array(
      'order' => 'pemeriksaan_ke asc',
    ));

    $kardeks_chart = array(
      'label' => array(),
      'suhu' => array(),
      'nadi' => array(),
      'sistol' => array(),
      'diastol' => array(),
      'rr' => array(),
      'spo2' => array(),
    );
    foreach ($kardeks as $i => $item) {
      $kardeks_chart['label'][] = date('H:i', strtotime($item->tgl_pemeriksaan));
      $kardeks_chart['suhu'][] = (empty($item->hemo_dewasa_suhu) || !is_numeric($item->hemo_dewasa_suhu)) ? 0 : $item->hemo_dewasa_suhu;
      $kardeks_chart['nadi'][] = (empty($item->hemo_dewasa_nadi) || !is_numeric($item->hemo_dewasa_nadi)) ? 0 : $item->hemo_dewasa_nadi;
      $kardeks_chart['sistol'][] = (empty($item->hemo_dewasa_sistol) || !is_numeric($item->hemo_dewasa_sistol)) ? 0 : $item->hemo_dewasa_sistol;
      $kardeks_chart['diastol'][] = (empty($item->hemo_dewasa_diastol) || !is_numeric($item->hemo_dewasa_diastol)) ? 0 : $item->hemo_dewasa_diastol;
      $kardeks_chart['rr'][] = (empty($item->hemo_dewasa_rr) || !is_numeric($item->hemo_dewasa_rr)) ? 0 : $item->hemo_dewasa_rr;
      $kardeks_chart['spo2'][] = (empty($item->hemo_dewasa_spo2 || !is_numeric($item->hemo_dewasa_spo2))) ? 0 : $item->hemo_dewasa_spo2;
    }

    // var_dump($kardeks_chart); die;

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows_delay';
      $this->render($this->path_view . 'PrintRM', array(
        'pasien' => $pasien,
        'kardeks' => $kardeks,
        'kardeks_chart' => $kardeks_chart,
        'pendaftaran_id' => $pendaftaran_id,
        'caraPrint' => $caraPrint,
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintRM', array(
        'pasien' => $pasien,
        'kardeks' => $kardeks,
        'kardeks_chart' => $kardeks_chart,
        'pendaftaran_id' => $pendaftaran_id,
        'caraPrint' => $caraPrint,
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = 'L'; //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = true;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintRM', array(
        'pasien' => $pasien,
        'kardeks' => $kardeks,
        'kardeks_chart' => $kardeks_chart,
        'pendaftaran_id' => $pendaftaran_id,
        'caraPrint' => $caraPrint,
      ), true));
      $mpdf->Output();
    }
  }

  public function actionSimpanGCS()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new PIMetodeGCSM;
    $model->attributes = $_POST['form_gcs'];

    $ok = 1;
    $msg = "Data berhasil disimpan";
    $option = "";

    if ($model->validate()) {

      $model->save();

      $crit = new CDbCriteria();
      $crit->addCondition("LOWER(metodegcs_singkatan) = lower('" . $model->metodegcs_singkatan . "')");
      $crit->addCondition('metodegcs_nilai is not null');
      $crit->order = 'metodegcs_nilai ASC';

      $list = PIMetodeGCSM::model()->findAll($crit);

      $option = '<option value="">-- Pilih --</option>';
      foreach ($list as $item) {
        $option .= '<option value="' . $item->metodegcs_nilai . '">' . $item->textMetodeGCSM . '</option>';
      }
    } else {
      $ok = 0;
      $msg = "Data gagal disimpan<br/>";
      $msg .= "<ul>";

      foreach ($model->errors as $attr) {
        foreach ($attr as $item) {
          $msg .= "<li>" . $item . "</li>";
        }
      }

      $msg .= "</ul>";
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'option' => $option));
  }
}
